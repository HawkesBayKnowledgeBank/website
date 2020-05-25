<?php

/**
 * Output a field template
 * @param  array  $field  Acf field from get_field_object()
 * @param  boolean $looping If we are looping through all fields on a record, we will automatically exclude certain ones. If not, just output whatever field we are given
 */
function knowledgebank_field_template($field, $looping = true){

    if(empty($field['value']) || !is_array($field) || empty($field['key'])) return false;

    //skip the automatic output of certain fields
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
        'marriage_date_accuracy',
        'youtube_id',
        'auto_generate',
        'auto_convert',
        'collections',
        'transcript',
        'source',
        'holder',
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
    if(empty($fields)) return false;

    //first sort by back end order
    uasort($fields, function($a,$b){
        return strnatcmp($a['menu_order'], $b['menu_order']);
    });

    //Anything we want to go before other fields, in desired order
    //We use a nice simple array to declare field names, but array_flip() because we really want them as array keys
    $before = array_flip(array('master','licence','name','notes'));

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
    $after = array_flip(array('people', 'biography','accession_number'));
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


/** Advanced admin listings */

function knowledgebank_manage_content_page(){
  add_menu_page( 'Find Content', 'Find Content', 'manage_options', 'knowledgebank_content_manager', 'knowledgebank_manage_content_page_html','',0);
}
add_action('admin_menu', 'knowledgebank_manage_content_page');

function knowledgebank_manage_content_page_html(){
        include(get_stylesheet_directory() . '/admin/find-content.php');
}




//Format a date using an associated 'accuracy' field
function knowledgebank_get_date($field_name, $post_id){
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
                    $_date = $_date_dt->format('F Y');
                break;

                default:
                    $_date = $_date_dt->format('d F Y');
                break;

            }
        }
    }

    return $_date;

}//knowldgebank_get_date()

/**
 * Get the year part of a date field, if possible. Intended for person birth and death dates
 * @param  string $field_name Name of the field
 * @param  integer $post_id WP post id
 * @return string|boolean a year or false
 */
function knowledgebank_get_year($field_name, $post_id){
    $field = get_field_object($field_name,$post_id);
    $_date = $field['value'];
    if(!empty($_date)){
        $_date_dt = DateTime::createFromFormat($field['return_format'], $_date);
        if(!empty($_date_dt)) return $_date_dt->format('Y');
    }
    return false;
}

/**
 * Output a set of icons representing the content types found with a particular term.
 * For performance we save this as term meta and update it only if missing or when saving posts
 * @param  [type] $term [description]
 * @return [type]       [description]
 */
function knowledgebank_term_content_type_icons($term, $force = false){

    $types = get_term_meta($term->term_id, 'term_post_types', true);

    if(empty($types) || $force){ //query and determine the content types in the term
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
                $term_types = get_term_meta($term->term_id, 'term_post_types', true); //get existing list of types on the term
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

//Accession numbers on post creation
function knowledgebank_generate_post_accession_number( $post_id, $post, $update ) {

	if ($update || wp_is_post_revision( $post_id ) || get_field('accession_number', $post_id)) return;

    $accession_number = $post_id; //start with post id

    $collections = get_field('collections',$post_id);

    if(!empty($collections)){

        //we take the first hierarchy we can find in our collections - as soon as we find a parent term, we push it into our hierarchal list and repeat for its children
        $collection_hierarchy = array();
        $parent_id = 0;
        $child_found = true;
        while($child_found != false){
            $child_found = false;
            foreach($collections as $collection){
                if($collection->parent == $parent_id){
                    $parent_id = $collection->term_id;//this term is a child of the current parent, it now becomes the parent
                    $collection_hierarchy[] = $parent_id; //push this term into the hierarchy
                    $child_found = true; //set flag to true to we recurse down into this term's children
                    break;
                }
            }
        }

        if(!empty($collection_hierarchy)){
            $collection_hierarchy[] = $accession_number;
            $accession_number = implode('/',$collection_hierarchy);
        }
    }
    //update_post_meta($post_id, 'accession_number', $accession_number);
    update_field('field_56d3eb00414ad', $accession_number,$post_id);

}
add_action( 'wp_insert_post', 'knowledgebank_generate_post_accession_number', 10, 3 );

function knowledgebank_generate_person_title($post_id, $post, $update) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
         return $post_id;

    global $wpdb;

    if(empty($post->post_type) || $post->post_type != 'person') return ;
    $name = get_field('name', $post_id);

    if(!empty($name[0]['family_name'])) $name[0]['family_name'] = strtoupper($name[0]['family_name']);

    if(!empty($name[0])) $name = implode(' ', array_filter($name[0]));

    $dates = [];
    $dates[] = knowledgebank_get_year('birthdate',$post_id);
    $dates[] = knowledgebank_get_year('deathdate',$post_id);
    $dates = array_filter($dates);

    $title = '';
    if(!empty($name)) $title = $name;
    if(!empty($dates)) $title .= ' (' . implode(' - ', $dates) . ')';
    remove_action('save_post_person','knowledgebank_generate_person_title',10,3);

    $wpdb->query($wpdb->prepare('UPDATE wp_posts SET post_title = %s WHERE ID = %d',array($title,$post_id)));
    //wp_update_post(array('ID' => $post_id, 'post_title' => $title));
    //echo 'saved title ' . $title . ' to ' . $post_id . "\n";
}
add_action('save_post_person','knowledgebank_generate_person_title',10,3);


add_filter('tiny_mce_before_init','kb_configure_tinymce');

/**
 * Customize TinyMCE's configuration
 *
 * @param   array
 * @return  array
 */
function kb_configure_tinymce($in) {
  $in['paste_preprocess'] = "function(plugin, args){
    // Strip all HTML tags except those we have whitelisted
    var whitelist = 'p,b,strong,i,em,h3,h4,h5,h6,ul,li,ol';
    var stripped = jQuery('<div>' + args.content + '</div>');
    var els = stripped.find('*').not(whitelist);
    for (var i = els.length - 1; i >= 0; i--) {
      var e = els[i];
      jQuery(e).replaceWith(e.innerHTML);
    }
    // Strip all class and id attributes
    stripped.find('*').removeAttr('id').removeAttr('class');
    // Return the clean HTML
    args.content = stripped.html();
  }";
  return $in;
}//kb_configure_tinymce()


//add_action('create_term', 'knowledgebank_term_slug', 10, 3 );
function knowledgebank_term_slug($term_id, $tt_id, $taxonomy) {

    if($taxonomy != 'collections') return;

    $term = get_term_by('id', $term_id, $taxonomy, ARRAY_A);
    $term['slug'] = $term['term_id'];
    wp_update_term($term_id, $taxonomy, $term);

}


function is_chris(){
    return (get_current_user_id() == 5116);
}


//get the 'current collection(s)' in JS format.
//Current collections means the ones from a post you are viewing / editing,
//or the current collection and its ancestors if you are viewing / editing a collection.
//This is used to pre-populate the collections on a new post if you click the 'new post' button in the above circumstances.
function knowledgebank_admin_new_post_links() {
    if(is_user_logged_in() && is_single()){
        global $post;
        $collections = wp_get_post_terms($post->ID, 'collections');
        if(!empty($collections)){
            $collection_ids = array();
            foreach($collections as $collection){
                $collection_ids[] = $collection->term_id;
            }
            echo "<script>var knowledgebank_collections = '" . http_build_query(array('collections' => $collection_ids)) . "';</script>";
        }
    }
    elseif(is_user_logged_in() && is_tax('collections')){
        $collection_id = get_queried_object()->term_id;
        if(!empty($collection_id)){
            $collection_ids = array($collection_id);
            $collection = get_term_by('id',$collection_id,'collections');
            while(!empty($collection->parent)){//recurse up the term parents getting ids
                $collection = get_term_by('id',$collection->parent,'collections');
                if(!empty($collection->term_id)) $collection_ids[] = $collection->term_id;
            }
            //finally flip the id array so eldest ancestor is first, which we want for our acf field
            $collection_ids = array_reverse($collection_ids);
            echo "<script>var knowledgebank_collections = '" . http_build_query(array('collections' => $collection_ids)) . "';</script>";
        }
    }
}
add_action( 'wp_footer', 'knowledgebank_admin_new_post_links' );



function kb_create_ACF_meta_in_REST() {
    $postypes_to_exclude = ['acf-field-group','acf-field'];
    $extra_postypes_to_include = ["video","audio","text","still_image","person"];
    $post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);

    array_push($post_types, $extra_postypes_to_include);

    foreach ($post_types as $post_type) {
        register_rest_field( $post_type, 'meta', [
            'get_callback'    => 'kb_expose_ACF_fields',
            'schema'          => null,
       ]
     );
    }

}

function kb_expose_ACF_fields( $object ) {
    $ID = $object['id'];
    return get_fields($ID);
}

add_action( 'rest_api_init', 'kb_create_ACF_meta_in_REST' );

add_action( 'rest_api_init', function () {
  register_rest_route( 'knowledgebank', '/recent(?:/(?P<since>\d+))?', array(
    'methods' => 'GET',
    'callback' => 'kb_recently_modified',
  ) );
} );

function kb_recently_modified( WP_REST_Request $request ){

    $since_ymd = $request->get_param('since');

    $args = array(
        'post_type' => array('video','audio','still_image','text','person'),
        'posts_per_page' => 500,
        'orderby' => 'modified',
        'order' => 'DESC',
    );

    if(!empty($since_ymd)){
        $since = DateTime::createFromFormat('Ymd', $since_ymd);
        if(!empty($since)){
            $args['date_query'] = array(
                array(
                    'column' => 'post_modified',
                    'after' => $since->format('Y-m-d'),
                )
            );

            $args['posts_per_page'] = -1;
        }
    }

    $records = get_posts($args);

    $display_values = array_map(function($record){
        return array(
            'ID' => $record->ID,
            'title' => $record->post_title,
            'post_date' => $record->post_date,
            'post_modified' => $record->post_modified,
            'post_modified_gmt' => $record->post_modified_gmt,
            'post_type' => $record->post_type,
            'link' => get_permalink($record->ID),
            'json' => get_rest_url(null,"/wp/v2/{$record->post_type}/{$record->ID}"),
        );
    },$records);

    return $display_values;

}

add_filter( 'big_image_size_threshold', '__return_false' );

function kb_ucm_get_collections(){

    $parent = 0;

    if(!empty($_GET['parents'])){
        $parent = array_pop($_GET['parents']);
    }

    $args = array('taxonomy' => 'collections', 'parent' => $parent, 'hide_empty' => false);
    if(!empty($_GET['search'])){
        $args['search'] = $_GET['search'];
    }

    $collections = get_terms($args);

    //we need to include the parent term in our results too
    $collections[] = get_term_by('id',$parent, 'collections');

    //simple reformatting for select2
    $collections_json = array();
    foreach($collections as $collection){
        $collections_json[] = array(
            'id' => $collection->term_id,
            'text' => $collection->name,
            'parent' => $collection->parent
        );
    }
    wp_send_json(array('results' => $collections_json));

}
add_action('wp_ajax_ucm_get_collections', 'kb_ucm_get_collections');


function kb_paypal_button_html(){
    ob_start();
    get_template_part('sections/paypal-button');
    $html = ob_get_clean();
    return $html;
}
add_shortcode('kb_paypal_button', 'kb_paypal_button_html');

function kb_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(/wp-content/themes/knowledgebank2/img/knowledgebank_logo.svg);
    		height:65px;
    		width:320px;
    		background-size: 320px 65px;
    		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
        #loginform input.button { background-color:#24802d;border-color:#24802d;}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'kb_login_logo' );

function kb_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'kb_login_logo_url' );
