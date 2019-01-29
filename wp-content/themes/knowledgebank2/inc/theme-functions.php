<?php

/**
 * Output a field template
 * @param  array  $field  Acf field from get_field_object()
 * @param  boolean $looping If we are looping through all fields on a record, we will automatically exclude certain ones. If not, just output whatever field we are given
 */
function knowledgebank_field_template($field, $looping= true){

    if(empty($field['value']) || !is_array($field) || empty($field['key'])) return false;

    //skip certain fields
    $exclude = array(
        'licence',
        'allow_commercial_licence',
        'computed_aperturefnumber',
        'exif_model',
        'exif_isospeedratings',
        'exif_focallength',
        'audio',
        'birthdate_accuracy',
        'deathdate_accuracy',
        'youtube_id',
        'auto_generate_images',
        'collections',
    );
    if($looping && in_array($field['name'], $exclude)) return false;

    //try in order of priority: field key, name, type, fallback default
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


/**
 * Wrapper arund get_field_objects() with some extra field ordering
 * @return array ACF field objects
 */
function knowledgebank_get_field_objects(){
    $fields = get_field_objects();

    //Anything we want to go before other fields, in desired order
    $before = array_flip(array('master','licence')); //use a nice simple array to declare field names, but flip so these become keys for use

    if(!empty($before) && !empty($fields)){
        foreach($before as $field_name => $_val){
            if(array_key_exists($field_name, $fields)){ //found the field we are looking for, move it into $before
                $before[$field_name] = $fields[$field_name];
                unset($fields[$field_name]);
            }
            else{
                unset($before[$field_name]);
            }
        }
    }

    //Anything we want specifically moved to the end
    $after = array_flip(array('accession_number'));
    if(!empty($after) && !empty($fields)){
        foreach($after as $field_name => $_val){
            if(array_key_exists($field_name, $fields)){ //found the field we are looking for, move it into $after
                $after[$field_name] = $fields[$field_name];
                unset($fields[$field_name]);
            }
            else{
                unset($after['field_name']);
            }
        }
    }

    $fields = array_merge($before, $fields, $after);
    //print_r($fields);

    return $fields;

}

/**
* Format a number of bytes in a nice human format
*/
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


if( function_exists('acf_add_options_page') ) {

	$option_page = acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title' 	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability' 	=> 'manage_options',
		'redirect' 	=> false
	));

}


/**
*menus
*/

function knowledgebank_register_menus() {
  register_nav_menu('top', 'Top');
  register_nav_menu('main', 'Main');
  register_nav_menu('footer', 'Footer');
}
add_action( 'init', 'knowledgebank_register_menus' );



//Format a date using an associated 'accuracy' field
function knowledgebank_get_date($field_name, $post_id) {
    $field = get_field_object($field_name,$post_id);
    $_date = $field['value'];
    if(!empty($_date)){
        $_date_dt = DateTime::createFromFormat($field['return_format'], $_date);
        if(!empty($_date_dt)){
            $_date_accuracy = get_field($field_name . '_accuracy', $post_id);
            switch($_date_accuracy){

                case '365':
                    $_date = $_date_dt->format('Y');
                break;

                case '30':
                    $_date = $_date_dt->format('Y-m');
                break;

                default:
                    $_date = $_date_dt->format('Y-m-d');
                break;

            }
        }
    }

    return $_date;

}//knowldgebank_get_date()

/**
 * Output a set of icons representing the content types found with a particular term.
 * For performance we save this as term meta and update it only if missing or when saving posts
 * @param  [type] $term [description]
 * @return [type]       [description]
 */
function knowledgebank_term_content_type_icons($term){

    $types = get_term_meta($term->term_id, 'term_post_types', true);

    if(empty($types)){ //query and determine the content types in the term
        $args = array(
            'post_type' => 'any',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => $term->taxonomy,
                    'field' => 'slug',
                    'terms' => $term->slug,
                )
            )
        );
        $term_posts = get_posts($args);
        $types = array();
        if(!empty($term_posts)){
            //get a simple unique array of post types found
            $types = array_unique(array_map(function($term_post){ return $term_post->post_type; },$term_posts));

            if(!empty($types)) update_term_meta($term->term_id, 'term_post_types', $types);
        }

    }
    if(!empty($types)){
        foreach($types as $type){
            echo sprintf('<span class="icon-content-type %s"></span>',$type);
        }
    }

}//knowledgebank_term_content_type_icons

function update_term_icons($post_id){
    $saved_post_type = get_post_type($post_id);
    foreach(array('post_tag','collections') as $tax_name){
        $terms = wp_get_post_terms($post_id, $tax_name);
        if(!empty($terms)){
            foreach($terms as $term){
                $term_types = get_term_meta($term->term_id, 'term_content_types', true); //get existing list of types on the term
                if(empty($term_types)){
                    $term_types = array($saved_post_type);
                    update_term_meta($term->term_id, 'term_post_types', $term_types);
                }
                elseif(!in_array($saved_post_type, $term_types)){
                    $term_types[] = $saved_post_type;
                    update_term_meta($term->term_id, 'term_post_types', $term_types);
                }
            }
        }
    }
}
add_action('save_post','update_term_icons');
