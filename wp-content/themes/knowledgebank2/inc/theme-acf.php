<?php
/*
//change upload dir for records
function knowledgebank_acf_upload_prefilter( $errors, $file, $field ) {
    //this filter changes directory just for item being uploaded
    add_filter('upload_dir', 'knowledgebank_upload_directory');
    return $errors;
}
//add_filter('acf/upload_prefilter/name=master', 'knowledgebank_acf_upload_prefilter',10,3);

function knowledgebank_master_upload_directory( $param ){
    global $post;

    //create /node/ and /node/master/ dirs if needed
    $dir = "/node/{$post->ID}";
    if(!file_exists($param['basedir'] . $dir)){
        mkdir($param['basedir'] . $dir);
    }
    $dir .= "/master";
    if(!file_exists($param['basedir'] . $dir)){
        mkdir($param['basedir'] . $dir);
    }

    $param['path'] = $param['basedir'] . $dir;
    $param['url'] = $param['baseurl'] . $dir;

    return $param;
}
*/


function knowledgebank_collections_hierarchy( $args, $field, $post_id ){
    $args['parent'] = empty($_POST['parent']) ? 0 : $_POST['parent'];
    return $args;
}
add_filter('acf/fields/taxonomy/query/name=collections', 'knowledgebank_collections_hierarchy',10,3);
