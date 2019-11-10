<?php

    require_once('../wp-load.php');
    global $wpdb;
    $records = $wpdb->get_results("SELECT ID FROM wp_posts WHERE post_type IN ('video','audio','still_image','text','person') AND post_status = 'publish' ORDER BY post_modified_gmt DESC");
    $output = [];
    file_put_contents(ABSPATH . '/import/records.json',"[");
    foreach($records as $row){
        $record = get_post($row->ID);
        $display_values = new stdClass();

        $display_values->ID = $record->ID;
        $display_values->title = $record->post_title;
        $display_values->post_date = $record->post_date;
        $display_values->post_modified = $record->post_modified;
        $display_values->post_modified_gmt = $record->post_modified_gmt;
        $display_values->post_type = $record->post_type;
        $display_values->link = get_permalink($record->ID);
        $display_values->json = get_rest_url(null,"/wp/v2/{$record->post_type}/{$record->ID}");

        file_put_contents(ABSPATH . '/import/records.json',json_encode( $display_values ) . ",\n",FILE_APPEND);
        //$output[] = $display_values;
    }
    file_put_contents(ABSPATH . '/import/records.json',"]", FILE_APPEND);
    //file_put_contents(ABSPATH . '/import/records.json',json_encode($output));




/*
    $fields = acf_get_fields(35615);

    foreach($fields as $index => &$field){
        if(empty($field['name'])) {
            unset($fields[$index]);
            continue;
        }
        kb_filter_field($field);
    }

    function kb_filter_field(&$field){
        foreach($field as $key => $value){
            //only get whitelisted keys from the field (and subfield) arrays
            if(!in_array($key,array('key','name','label','type','sub_fields','return_format','choices','instructions'))) unset($field[$key]);
            if($key == 'sub_fields'){
                foreach($field['sub_fields'] as &$sub_field){
                    kb_filter_field($sub_field);
                }
            }
        }
    }

    //remove non-display fields
    $fields = array_values($fields);


    echo json_encode($fields);


*/
?>
