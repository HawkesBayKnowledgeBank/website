<?php

require_once('../wp-load.php');
global $wpdb;

$ids = $wpdb->get_results("SELECT ID from wp_posts WHERE post_type IN ('still_image','text','video','audio','person')");



foreach($ids as $id){
    wp_delete_post($id->ID,true);
    echo "done $id->ID \n";
}
