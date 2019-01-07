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
            exec("ffmpeg -i $input_path $mp3_path");
            if(file_exists($mp3_path)) return $mp3_path;
        }
    }
    return false;
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
 * @param  int $wp_id - Id of audio
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
            return false;        }
        else {
            wp_update_attachment_metadata($attach_id, $attach_data);
        }

        return $attach_id;

    }
    else {
        return false;
    }
}
