
<?php

function knowledgebank_field_template($field){

    if(empty($field) || !is_array($field) || empty($field['key'])) return false;

    //try in order: field key, name, type, fallback default
    foreach(array('key','name','type','default') as $template_type){

        //default - we get here after exhausting other options
        if($template_type == 'default'){
            include(get_stylesheet_directory() . '/fields/default.php');
            break;
        }

        //key, name, type
        $template_path = get_stylesheet_directory() . '/fields/' . $field[$template_type] . '.php';
        if(file_exists($template_path)){
            include($template_path);
            break;
        }

    }

}//knowledgebank_field_template()

//https://stackoverflow.com/a/2510540/10189367
function formatBytes($size, $precision = 2){
    $base = log($size, 1024);
    $suffixes = array('', 'kB', 'MB', 'GB', 'TB');
    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}


//Remove SEO Menu in Admin Bar
function knowledgebank_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('all-in-one-seo-pack');
    $wp_admin_bar->remove_menu('customize');
}
add_action( 'wp_before_admin_bar_render', 'knowledgebank_admin_bar_render' );
