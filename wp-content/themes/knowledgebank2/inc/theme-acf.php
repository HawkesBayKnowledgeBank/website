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


function knowledgebank_term_accession_number($field){
    $field['disabled'] = 1;
    if(empty($field['value']) && !empty($_GET['tag_ID']) && !empty($_GET['taxonomy'])){
        $term = get_term_by('id',$_GET['tag_ID'],'collections');
        if(empty($term)) return $field; //bail out
        $accession_number = $_GET['tag_ID'];

        if($term->parent != 0){
            while($term->parent != 0){ //prepend parents until we run out of parents
                $accession_number = $term->parent . "/" . $accession_number;
                $term = get_term_by('id', $term->parent,'collections');
            }
        }

        //update for reals
        remove_filter('acf/load_field/key=field_5c7cca30a8a4a', 'knowledgebank_term_accession_number');
        update_field('field_5c7cca30a8a4a',$accession_number,'collections_' . $_GET['tag_id']);

        $field['value'] = $accession_number;
        return $field;

    }
    return $field;
}
add_filter('acf/load_field/key=field_5c7cca30a8a4a', 'knowledgebank_term_accession_number');


function knowledgebank_new_post_collections($field){
    global $pagenow;

    if(in_array($pagenow, array('post-new.php')) && !empty($_GET['collections'])){
        $field['value'] = $_GET['collections'];
    }
    return $field;
}
add_filter('acf/load_field/name=collections','knowledgebank_new_post_collections', 10, 1);
