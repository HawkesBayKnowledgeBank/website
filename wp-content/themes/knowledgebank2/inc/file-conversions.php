<?php

/**
 * If a master file is found, no web files found ('images','image','audio','video'), and an 'auto_generate' field is true.. generate the relevant kind of web file (image, audio etc).
 * @param  integer $post_id WP post ID
 * @param boolean $force Whether to force the conversion
 * @return void
 */
function knowledgebank_auto_file_conversion($post_id, $force = false) {

    //whether it's an image or audio, we route through our async conversion request function

    switch (get_post_type($post_id)) {

        case 'still_image':
        case 'text':
            if ($force || (get_field('auto_generate', $post_id) && get_field('master', $post_id) && !get_field('images', $post_id))) {

                knowledgebank_request_async_conversion($post_id); //async
            } //if auto generate
            break;

        case 'audio':
            if (get_field('auto_convert', $post_id) && get_field('master', $post_id) && !get_field('audio', $post_id)) {
                knowledgebank_request_async_conversion($post_id); //async
            }
            break;

        case 'video':

            break;
    } //switch

} //knowledgebank_auto_file_conversion()



/*
    Run conversions asynchronously - this function just requests /wp-admin/admin.ajax.php?action=request_master_conversion which runs knowledgebank_do_master_conversion()
*/
function knowledgebank_request_async_conversion($post_id) {

    $url = site_url() . '/wp-admin/admin-ajax.php';

    // Parameters to be sent with the GET request
    $params = array(
        'action' => 'request_master_conversion', // Change this to the actual action name
        'post_id' => $post_id,
    );

    $queryString = http_build_query($params);
    $url = $url . '?' . $queryString;

    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true, // Return response as a string
        CURLOPT_HEADER => false, // Don't include the header in the output
        CURLOPT_TIMEOUT => 1, // Timeout in seconds
        CURLOPT_HTTPGET => true, // Use GET method
    ));

    // Execute cURL request
    $response = curl_exec($curl);

    // Check for errors
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
        // Handle cURL error
        echo "cURL Error: $error_msg";
    } else {
        // No error, print response
        echo "Response: $response";
    }

    // Close cURL session
    curl_close($curl);
}

//Perform the appropriate type of conversion for the master
function knowledgebank_do_master_conversion() {

    $post_id = !empty($_GET['post_id']) ? $_GET['post_id'] : false;

    if (empty($post_id)) return;
    $post = get_post($post_id);
    if (empty($post->ID)) return;


    switch (get_post_type($post_id)) {

        case 'still_image':
        case 'text':
            if (get_field('auto_generate', $post_id) && get_field('master', $post_id) && !get_field('images', $post_id)) {
                knowledgebank_convert_master_image($post_id);
            } //if auto generate
            break;

        case 'audio':
            if (get_field('auto_convert', $post_id) && get_field('master', $post_id) && !get_field('audio', $post_id)) {
                knowledgebank_audio_create_web_from_master($post_id);
            }
            break;

        case 'video':

            break;
    } //switch

}
add_action('wp_ajax_nopriv_request_master_conversion', 'knowledgebank_do_master_conversion');
add_action('wp_ajax_request_master_conversion', 'knowledgebank_do_master_conversion');


/********************************************************************************************************************************** */
/**
 * If the audio post has a 'master' file but no 'audio' file, try to convert it to mp3
 * @param  int $post_id Audio post
 * @return string|bool Path to new file or false if we couldn't do it
 */
function knowledgebank_audio_create_web_from_master($post_id) {
    $master = get_field('master', $post_id);
    $audio = get_field('audio', $post_id);
    if (empty($master) || !empty($audio)) return false;

    //if the master is an mp3, just use that instead of converting
    if ($master['mime_type'] == 'audio/mpeg') {
        update_field('field_56e8f61e8f822', $master['id'], $post_id);
        return true;
    }

    $file_path = get_attached_file($master['id']);
    if (empty($file_path)) return false;

    //create a conversion job record
    $job = [
        'master' => $file_path,
        'status' => 'Converting to mp3'
    ];

    update_post_meta($post_id, '_master_conversion_status', $job);

    $mp3 = knowledgebank_convert_to_mp3($file_path);

    $job['status'] = 'Complete';
    update_post_meta($post_id, '_master_conversion_status', $job);


    if (!empty($mp3)) {
        //now we need to 'upload' the file to WordPress
        $attachment_id = knowledgebank_insert_file_into_wp($mp3, $post_id);
        if (!empty($attachment_id) && !is_wp_error($attachment_id)) {
            update_field('field_56e8f61e8f822', $attachment_id, $post_id);
        }
    }
}


/**
 * Make an mp3 copy of an input (usually ogg) file
 */
function knowledgebank_convert_to_mp3($input_path) {
    if (file_exists($input_path)) {

        $path = pathinfo($input_path);
        if (empty($path)) return false;

        $mp3_path = "{$path['dirname']}/{$path['filename']}.mp3"; // /path/to/file.ogg -> /path/to/file.mp3

        if ($mp3_path != '/.mp3') {
            if (file_exists($mp3_path)) return $mp3_path;


            echo "ffmpeg -i \"$input_path\" \"$mp3_path\"";
            exec("ffmpeg -i \"$input_path\" \"$mp3_path\"");


            if (file_exists($mp3_path)) return $mp3_path;
        }
    }
} //knowledgebank_convert_to_mp3()




//


/**
 * Given a file path that we are already happy with (in wp-uploads or wherever already), create a WP attachment for it
 * @param  string $file_path Path to file
 * @param  int $wp_id - Id of parent post
 * @return int Attachment id
 */
function knowledgebank_insert_file_into_wp($file_path, $wp_id) {

    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    global $wpdb;

    if (file_exists($file_path) && fclose(fopen($file_path, "r"))) { //make sure the file actually exists

        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype(basename($file_path), NULL);

        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid'           => $file_path,
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($file_path)),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        // Insert the attachment.
        $attach_id = wp_insert_attachment($attachment, $file_path, $wp_id);

        // Generate the metadata for the attachment, and update the database record.

        //$new_sizes = apply_filters( 'intermediate_image_sizes_advanced', $new_sizes, $image_meta, $attachment_id );

        $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);

        if (is_wp_error($attach_data)) {
            return false;
        } else {
            wp_update_attachment_metadata($attach_id, $attach_data);
        }

        return $attach_id;
    } else {
        return false;
    }
} //knowledgebank_insert_file_into_wp()




function knowledgebank_convert_master_image($post_id) {


    $master = get_field('master', $post_id);

    //do the conversion
    if (!empty($master['id'])) {
        $master_path = get_attached_file($master['id']);
        if (empty($master_path) || !file_exists($master_path)) return false;

        //output path is wp-content/uploads/node/$post_id/images/
        $wp_upload_dir = wp_get_upload_dir();

        //make sure our /$post_id/ and /$post_id/images/ subdirectories exist
        $output_dir = $wp_upload_dir['basedir'] . "/node/$post_id";
        if (!file_exists($output_dir)) mkdir($output_dir);
        $output_dir .= "/images";
        if (!file_exists($output_dir)) mkdir($output_dir);


        if (file_exists($output_dir)) { //create our image


            //create a conversion job record
            $job = [
                'master' => $master_path,
                'output' => $output_dir,
                'pages' => 0,
                'status' => ''
            ];

            //first delete existing jpegs in output dir
            //try to be a little bit safe in what we expect $output_dir to look like :p
            if (preg_match('@^/webs/new/wp-content/uploads/node/[0-9]+/images@', $output_dir)) {
                $job['status'] = 'Removing existing images from ' . $output_dir;
                update_post_meta($post_id, '_master_conversion_status', $job);
                //echo "Deleting jpgs";
                error_log('Clearing images on ' . $post_id . ' prior to regenerating');
                error_log("rm -f $output_dir/*.jpg $output_dir/*.jpeg");
                exec("rm -f $output_dir/*.jpg $output_dir/*.jpeg");
            }

            $output_filename = !empty($master['name']) ? "{$master['name']}.jpg" : "$post_id.jpg";
            $output_path = "$output_dir/$output_filename";

            //for PDFs we run GhostScript (gs) directly, for everything else imagemagick convert (which can also do PDFs but it's slow af)
            if (!empty($master['subtype']) && $master['subtype'] == 'pdf') {
                $output_filename = str_replace('.jpg', '-%03d.jpg', $output_filename); //%03d will be replaced with the page number by gs
                $output_path = "$output_dir/$output_filename";
                //gs -o ../images/DentonRA1632_WhereWeCameFrom-2-%03d.jpg -sDEVICE=jpeg -r300 -dDOINTERPOLATE -dJPEGQ=90 -dPDFFitPage DentonRA1632_WhereWeCameFrom-2.pdf
                $cmd = "gs -o $output_path -sDEVICE=jpeg -r200 -dDOINTERPOLATE -dJPEGQ=90 -dPDFFitPage -dDownScaleFactor=2 $master_path";


                exec("pdfinfo $master_path", $pdfinfo);

                // Extract total number of pages
                $totalPages = 0;
                foreach ($pdfinfo as $line) {
                    if (preg_match('/Pages:\s*(\d+)/', $line, $matches)) {
                        $totalPages = intval($matches[1]);
                        break;
                    }
                }
                $job['pages'] = $totalPages;
                $job['status'] = 'Generating images from PDF';
                update_post_meta($post_id, '_master_conversion_status', $job);

                exec($cmd);

                //update job status
                $job['status'] = 'Resizing images from PDF';
                update_post_meta($post_id, '_master_conversion_status', $job);

                $resize = "mogrify -resize 1100x1100 -quality 90 $output_dir/*.jpg";
                error_log('Generating images from PDF: ' . $resize);
                exec($resize);
            } else {
                exec("convert -colorspace sRGB -quality 90 -interlace none -density 200 -alpha flatten -format jpg -resize 1100x1100\> \"$master_path\" \"$output_path\"");
                error_log('Converting attachment on ' . $post_id);
                error_log("convert -colorspace sRGB -quality 90 -interlace none -density 200 -alpha flatten -format jpg -resize 1100x1100\> \"$master_path\" \"$output_path\"");
            }



            //or
            /*
            gs -o ./output-%03d.jpg -sDEVICE=jpeg -r300 -dDOINTERPOLATE -dJPEGQ=90 -dPDFFitPage -dDownScaleFactor=2 input.pdf
            */


            //if conversion worked, we should have jpegs in our output dir
            $jpgs = glob("$output_dir/*.jpg");

            if (!empty($jpgs)) { //insert new jpgs as wordpress attachments and into the images field on the post

                natsort($jpgs); //ensure jpegs are in correct numerical order

                $images_field = get_field_object('images', $post_id);
                $images_key = $images_field['key'];
                $image_key = $images_field['sub_fields'][0]['key'];

                update_field($images_key, array(), $post_id); //clear existing images

                //update job status
                $job['status'] = 'Adding images to WordPress';
                update_post_meta($post_id, '_master_conversion_status', $job);

                foreach ($jpgs as $jpg) {
                    //echo "Adding wp attachment for $jpg \n";
                    $attachment_id = knowledgebank_insert_file_into_wp($jpg, $post_id);
                    if (!empty($attachment_id)) {
                        add_row($images_key, array($image_key => $attachment_id), $post_id);
                    }
                }

                $job['status'] = 'Complete';
                update_post_meta($post_id, '_master_conversion_status', $job);
            }
        } //create image(s)

    } //if master[id]

} //knowledgebank_convert_master_image


/**
 * SLightly modified wp_generate_attachment_metadata() which doesn't make derived images / sub sizes
 */
function knowledgebank_wp_generate_attachment_metadata($attachment_id, $file) {
    $attachment = get_post($attachment_id);

    $metadata  = array();
    $support   = false;
    $mime_type = get_post_mime_type($attachment);

    if (preg_match('!^image/!', $mime_type) && file_is_displayable_image($file)) {
        // Make thumbnails and other intermediate sizes.
        $metadata = []; //wp_create_image_subsizes( $file, $attachment_id );
    } elseif (wp_attachment_is('video', $attachment)) {
        $metadata = wp_read_video_metadata($file);
        $support  = current_theme_supports('post-thumbnails', 'attachment:video') || post_type_supports('attachment:video', 'thumbnail');
    } elseif (wp_attachment_is('audio', $attachment)) {
        $metadata = wp_read_audio_metadata($file);
        $support  = current_theme_supports('post-thumbnails', 'attachment:audio') || post_type_supports('attachment:audio', 'thumbnail');
    }

    /*
	 * wp_read_video_metadata() and wp_read_audio_metadata() return `false`
	 * if the attachment does not exist in the local filesystem,
	 * so make sure to convert the value to an array.
	 */
    if (!is_array($metadata)) {
        $metadata = array();
    }

    if ($support && !empty($metadata['image']['data'])) {
        // Check for existing cover.
        $hash   = md5($metadata['image']['data']);
        $posts  = get_posts(
            array(
                'fields'         => 'ids',
                'post_type'      => 'attachment',
                'post_mime_type' => $metadata['image']['mime'],
                'post_status'    => 'inherit',
                'posts_per_page' => 1,
                'meta_key'       => '_cover_hash',
                'meta_value'     => $hash,
            )
        );
        $exists = reset($posts);

        if (!empty($exists)) {
            update_post_meta($attachment_id, '_thumbnail_id', $exists);
        } else {
            $ext = '.jpg';
            switch ($metadata['image']['mime']) {
                case 'image/gif':
                    $ext = '.gif';
                    break;
                case 'image/png':
                    $ext = '.png';
                    break;
                case 'image/webp':
                    $ext = '.webp';
                    break;
            }
            $basename = str_replace('.', '-', wp_basename($file)) . '-image' . $ext;
            $uploaded = wp_upload_bits($basename, '', $metadata['image']['data']);
            if (false === $uploaded['error']) {
                $image_attachment = array(
                    'post_mime_type' => $metadata['image']['mime'],
                    'post_type'      => 'attachment',
                    'post_content'   => '',
                );
                /**
                 * Filters the parameters for the attachment thumbnail creation.
                 *
                 * @since 3.9.0
                 *
                 * @param array $image_attachment An array of parameters to create the thumbnail.
                 * @param array $metadata         Current attachment metadata.
                 * @param array $uploaded         {
                 *     Information about the newly-uploaded file.
                 *
                 *     @type string $file  Filename of the newly-uploaded file.
                 *     @type string $url   URL of the uploaded file.
                 *     @type string $type  File type.
                 * }
                 */
                $image_attachment = apply_filters('attachment_thumbnail_args', $image_attachment, $metadata, $uploaded);

                $sub_attachment_id = wp_insert_attachment($image_attachment, $uploaded['file']);
                add_post_meta($sub_attachment_id, '_cover_hash', $hash);
                $attach_data = wp_generate_attachment_metadata($sub_attachment_id, $uploaded['file']);
                wp_update_attachment_metadata($sub_attachment_id, $attach_data);
                update_post_meta($attachment_id, '_thumbnail_id', $sub_attachment_id);
            }
        }
    } elseif ('application/pdf' === $mime_type) {
        // Try to create image thumbnails for PDFs.

        $fallback_sizes = array(
            'thumbnail',
            'medium',
            'large',
        );

        /**
         * Filters the image sizes generated for non-image mime types.
         *
         * @since 4.7.0
         *
         * @param string[] $fallback_sizes An array of image size names.
         * @param array    $metadata       Current attachment metadata.
         */
        $fallback_sizes = apply_filters('fallback_intermediate_image_sizes', $fallback_sizes, $metadata);

        $registered_sizes = wp_get_registered_image_subsizes();
        $merged_sizes     = array_intersect_key($registered_sizes, array_flip($fallback_sizes));

        // Force thumbnails to be soft crops.
        if (isset($merged_sizes['thumbnail']) && is_array($merged_sizes['thumbnail'])) {
            $merged_sizes['thumbnail']['crop'] = false;
        }

        // Only load PDFs in an image editor if we're processing sizes.
        if (!empty($merged_sizes)) {
            $editor = wp_get_image_editor($file);

            if (!is_wp_error($editor)) { // No support for this type of file.
                /*
				 * PDFs may have the same file filename as JPEGs.
				 * Ensure the PDF preview image does not overwrite any JPEG images that already exist.
				 */
                $dirname      = dirname($file) . '/';
                $ext          = '.' . pathinfo($file, PATHINFO_EXTENSION);
                $preview_file = $dirname . wp_unique_filename($dirname, wp_basename($file, $ext) . '-pdf.jpg');

                $uploaded = $editor->save($preview_file, 'image/jpeg');
                unset($editor);

                // Resize based on the full size image, rather than the source.
                if (!is_wp_error($uploaded)) {
                    $image_file = $uploaded['path'];
                    unset($uploaded['path']);

                    $metadata['sizes'] = array(
                        'full' => $uploaded,
                    );

                    // Save the meta data before any image post-processing errors could happen.
                    wp_update_attachment_metadata($attachment_id, $metadata);

                    // Create sub-sizes saving the image meta after each.
                    $metadata = _wp_make_subsizes($merged_sizes, $image_file, $metadata, $attachment_id);
                }
            }
        }
    }

    // Remove the blob of binary data from the array.
    unset($metadata['image']['data']);

    // Capture file size for cases where it has not been captured yet, such as PDFs.
    if (!isset($metadata['filesize']) && file_exists($file)) {
        $metadata['filesize'] = wp_filesize($file);
    }

    /**
     * Filters the generated attachment meta data.
     *
     * @since 2.1.0
     * @since 5.3.0 The `$context` parameter was added.
     *
     * @param array  $metadata      An array of attachment meta data.
     * @param int    $attachment_id Current attachment ID.
     * @param string $context       Additional context. Can be 'create' when metadata was initially created for new attachment
     *                              or 'update' when the metadata was updated.
     */
    return apply_filters('wp_generate_attachment_metadata', $metadata, $attachment_id, 'create');
}


/******************************/
//Actions
add_action('save_post', 'knowledgebank_auto_file_conversion');
