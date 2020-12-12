<?php

/**
* Make an mp3 copy of an input (usually ogg) file
*/
function knowledgebank_convert_to_mp3($input_path) {
    if(file_exists($input_path)){

        $path = pathinfo($input_path);
        if(empty($path)) return false;

        $mp3_path = "{$path['dirname']}/{$path['filename']}.mp3"; // /path/to/file.ogg -> /path/to/file.mp3

        if($mp3_path != '/.mp3'){
            if(file_exists($mp3_path)) return $mp3_path;
            echo "ffmpeg -i \"$input_path\" \"$mp3_path\"";
            exec("ffmpeg -i \"$input_path\" \"$mp3_path\"");
            if(file_exists($mp3_path)) return $mp3_path;

        }
    }

}//knowledgebank_ogg_to_mp3()


/**
 * If the audio post has a 'master' file but no 'audio' file, try to convert it to mp3
 * @param  int $post_id Audio post
 * @return string|bool Path to new file or false if we couldn't do it
 */
function knowledgebank_audio_create_web_from_master($post_id) {
    $master = get_field('master',$post_id);
    $audio = get_field('audio',$post_id);
    if(empty($master) || !empty($audio)) return false;

    //if the master is an mp3, just use that instead of converting
    if($master['mime_type'] == 'audio/mpeg'){
        update_field('field_56e8f61e8f822', $master['id'], $post_id);
        return true;
    }

    $file_path = get_attached_file($master['id']);
    if(empty($file_path)) return false;

    $mp3 = knowledgebank_convert_to_mp3($file_path);

    if(!empty($mp3)){
        //now we need to 'upload' the file to WordPress
        $attachment_id = knowledgebank_insert_file_into_wp($mp3, $post_id);
        if(!empty($attachment_id) && !is_wp_error($attachment_id)){
            update_field('field_56e8f61e8f822', $attachment_id, $post_id);
        }
    }

}


/**
 * Given a file path that we are already happy with (in wp-uploads or wherever already), create a WP attachment for it
 * @param  string $file_path Path to file
 * @param  int $wp_id - Id of parent post
 * @return int Attachment id
 */
function knowledgebank_insert_file_into_wp($file_path, $wp_id){

    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    global $wpdb;

    if (file_exists($file_path) && fclose(fopen($file_path, "r"))) { //make sure the file actually exists

        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype( basename( $file_path ), NULL );

        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid'           => $file_path,
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_path ) ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        // Insert the attachment.
        $attach_id = wp_insert_attachment( $attachment, $file_path, $wp_id );

        // Generate the metadata for the attachment, and update the database record.
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

        if(is_wp_error($attach_data)) {
            return false;
        }
        else {
            wp_update_attachment_metadata($attach_id, $attach_data);
        }

        return $attach_id;

    }
    else {
        return false;
    }
}//knowledgebank_insert_file_into_wp()


/**
 * If a master file is found, no web files found ('images','image','audio','video'), and an 'auto_generate' field is true.. generate the relevant kind of web file (image, audio etc).
 * @param  integer $post_id WP post ID
 * @param boolean $force Whether to force the conversion
 * @return void
 */
function knowledgebank_auto_file_conversion($post_id, $force = false){


    switch(get_post_type($post_id)){

        case 'still_image':
        case 'text':
            if($force || (get_field('auto_generate',$post_id) && get_field('master',$post_id) && !get_field('images', $post_id))){
                knowledgebank_convert_master_image($post_id);
            }//if auto generate
        break;

        case 'audio':
            if(get_field('auto_convert',$post_id) && get_field('master',$post_id) && !get_field('audio',$post_id)){
                knowledgebank_audio_create_web_from_master($post_id);
            }
        break;

        case 'video':

        break;

    }//switch

}//knowledgebank_auto_file_conversion()

function knowledgebank_convert_master_image($post_id){


    $master = get_field('master',$post_id);

    //do the conversion
    if(!empty($master['id'])){
        $master_path = get_attached_file($master['id']);
        if(empty($master_path) || !file_exists($master_path)) return false;

        //output path is wp-content/uploads/node/$post_id/images/
        $wp_upload_dir = wp_get_upload_dir();

        //make sure our /$post_id/ and /$post_id/images/ subdirectories exist
        $output_dir = $wp_upload_dir['basedir'] . "/node/$post_id";
        if(!file_exists($output_dir)) mkdir($output_dir);
        $output_dir .= "/images";
        if(!file_exists($output_dir)) mkdir($output_dir);


        if(file_exists($output_dir)){ //create our image

            //first delete existing jpegs in output dir
            //try to be a little bit safe in what we expect $output_dir to look like :p
            if(preg_match('@^/webs/new/wp-content/uploads/node/[0-9]+/images@', $output_dir)){
                //echo "Deleting jpgs";
                exec("rm -f $output_dir/*.jpg $output_dir/*.jpeg");
            }

            $output_filename = !empty($master['name']) ? "{$master['name']}.jpg" : "$post_id.jpg";
            $output_path = "$output_dir/$output_filename";

            //for PDFs we run GhostScript (gs) directly, for everything else imagemagick convert (which can also do PDFs but it's slow af)
            if(!empty($master['subtype']) && $master['subtype'] == 'pdf'){
                $output_filename = str_replace('.jpg', '-%03d.jpg',$output_filename); //%03d is the page number from gs
                $output_path = "$output_dir/$output_filename";
                //gs -o ../images/DentonRA1632_WhereWeCameFrom-2-%03d.jpg -sDEVICE=jpeg -r300 -dDOINTERPOLATE -dJPEGQ=90 -dPDFFitPage DentonRA1632_WhereWeCameFrom-2.pdf
                $cmd = "gs -o $output_path -sDEVICE=jpeg -r200 -dDOINTERPOLATE -dJPEGQ=90 -dPDFFitPage -dDownScaleFactor=2 $master_path";
                //echo $cmd;
                exec($cmd);

                $resize = "mogrify -resize 1400x1400 -quality 90 $output_dir/*.jpg";
                exec($resize);

            }
            else{
                exec("convert -colorspace sRGB -quality 90 -interlace none -density 200 -alpha flatten -format jpg -resize 1400x1400\> \"$master_path\" \"$output_path\"");
            }



            //or
            /*
            gs -o ./output-%03d.jpg -sDEVICE=jpeg -r300 -dDOINTERPOLATE -dJPEGQ=90 -dPDFFitPage -dDownScaleFactor=2 input.pdf
            */


            //if conversion worked, we should have jpegs in our output dir
            $jpgs = glob("$output_dir/*.jpg");

            if(!empty($jpgs)){ //insert new jpgs as wordpress attachments and into the images field on the post

                natsort($jpgs);//ensure jpegs are in correct numerical order

                $images_field = get_field_object('images',$post_id);
                $images_key = $images_field['key'];
                $image_key = $images_field['sub_fields'][0]['key'];

                update_field($images_key,array(),$post_id); //clear existing images

                foreach($jpgs as $jpg){
                    //echo "Adding wp attachment for $jpg \n";
                    $attachment_id = knowledgebank_insert_file_into_wp($jpg, $post_id);
                    if(!empty($attachment_id)){
                        add_row($images_key, array($image_key => $attachment_id),$post_id);
                    }

                }

            }

        }//create image(s)

    }//if master[id]

}//knowledgebank_convert_master_image

/******************************/
//Actions
add_action('save_post','knowledgebank_auto_file_conversion');
