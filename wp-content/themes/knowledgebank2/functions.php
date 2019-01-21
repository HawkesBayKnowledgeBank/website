<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: knowledgebank.com | @knowledgebank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

require_once(get_stylesheet_directory() . '/inc/theme-functions.php');
require_once(get_stylesheet_directory() . '/inc/theme-acf.php');
require_once(get_stylesheet_directory() . '/inc/file-conversions.php');
require_once(get_stylesheet_directory() . '/inc/pagination.php');


/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width)){
    $content_width = 900;
}

if (function_exists('add_theme_support')){
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');

    //add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

}

/*------------------------------------*\
	Functions
\*------------------------------------*/


// Load HTML5 Blank scripts (header.php)
function knowledgebank_header_scripts(){
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr');

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr');

        wp_register_script('knowledgebank-js', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('knowledgebank-js');

        wp_register_script('knowledgebank-terms-js', get_template_directory_uri() . '/js/term-filters.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('knowledgebank-terms-js');

        wp_register_script('magnific-js', get_template_directory_uri() . '/js/lib/jquery.magnific-popup.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('magnific-js');

        wp_register_script('lazy-js', get_template_directory_uri() . '/js/lib/jquery.lazy.min.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('lazy-js');

        wp_register_script('slick-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('slick-js');

        wp_register_script('select2-js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('select2-js');

    }
}

function knowledgebank_admin_scripts(){
    wp_enqueue_script( 'acf-date-picker-js', get_stylesheet_directory_uri() . '/js/custom_acf_date_picker.js', array(), '1.0.0', true );
}
add_action('admin_enqueue_scripts', 'knowledgebank_admin_scripts');

// Load HTML5 Blank styles
function knowledgebank_styles(){
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize');

    wp_register_style('google-karla', 'https://fonts.googleapis.com/css?family=Karla:400,700', array(), '1.0', 'all');
    wp_enqueue_style('google-karla');

    wp_register_style('material-icons', get_template_directory_uri() . '/css/lib/materialdesignicons.min.css', array(), '1.0', 'all');
    wp_enqueue_style('material-icons');

    wp_register_style('knowledgebank', get_template_directory_uri() . '/css/knowledgebank.css', array(), '1.0', 'all');
    wp_enqueue_style('knowledgebank');

    wp_register_style('magnific-css', get_template_directory_uri() . '/css/lib/magnific-popup.css', array(), '1.0', 'all');
    wp_enqueue_style('magnific-css');

    wp_register_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', array(), '1.0', 'all');
    wp_enqueue_style('select2-css');

}


// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist){
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes){
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}


// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function knowledgebank_pagination(){
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}



// Create the Custom Excerpts callback
function knowledgebank_excerpt($length_callback = '', $more_callback = ''){
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom Gravatar in Settings > Discussion
function knowledgebankgravatar ($avatar_defaults){
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}


/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'knowledgebank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_enqueue_scripts', 'knowledgebank_styles'); // Add Theme Stylesheets


// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
//add_filter('avatar_defaults', 'knowledgebankgravatar'); // Custom Gravatar in Settings > Discussion
//add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)

//add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
//add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
//add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)

// Remove Filters
//remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

//don't let WP make PDF thumbnails from our massive pdfs
function wpb_disable_pdf_previews() {
    $fallbacksizes = array();
    return $fallbacksizes;
}
add_filter('fallback_intermediate_image_sizes', 'wpb_disable_pdf_previews');

//WP cli hard-codes the mime types it looks for when regenerating (-_-)
function knowledgebank_regenerate_types( $query ) {
    if(!empty($query->query['post_mime_type']) && $query->query['post_type'] == 'attachment'){
        $query->set('post_mime_type', array('image'));
    }
}
add_action( 'pre_get_posts', 'knowledgebank_regenerate_types', 1 );

function knowledgebank_numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link() );

}//knowledgebank_numeric_posts_nav

//get certain allowed values from the URL to do filtery things with
function knowledgebank_get_filters(){
    $allowed_keys = array('order','orderby','view_mode','tags','number','search');
    $filters = array();
    if(!empty($_GET['filters']) && is_array($_GET['filters'])){
        //get any $_GET['filters'] elements with a key in $allowed keys
        $filters = array_intersect_key($_GET['filters'], array_flip($allowed_keys));
    }
    return $filters;
}//knowledgebank_get_filters

function knowledgebank_pre_get_posts($query){
    if(empty($query)) return false;
    if($query->is_main_query()){
        $filters = knowledgebank_get_filters();
        //search filtering if applicable
        if(!empty($filters['search'])){
            if(is_archive()) $query->set('search', $filters['search']);
            if(is_archive()) $query->set('s', $filters['search']);
        }//$filters['search']

        //ordering
        if(!empty($filters['order'])){
            $query->set('order', $filters['order']);
        }
        elseif(is_archive() && $query->queried_object_id != 277873){ //not the news page
            $query->set('order', 'ASC');
        }
        if(!empty($filters['orderby'])){
            $query->set('orderby', $filters['orderby']);
        }
        elseif(is_archive() && $query->queried_object_id != 277873){
            $query->set('orderby', 'name');
        }

        if(!empty($filters['number'])){
            $query->set('posts_per_page', $filters['number']);
        }


        if(is_tag()) $query->set('post_type', array('still_image','audio','video','person','text'));

        //print_r($query);
    }
}//knowledgebank_pre_get_posts()
add_filter('pre_get_posts', 'knowledgebank_pre_get_posts');



function knowledgebank_get_collections($post_id){
    $terms = wp_get_post_terms($post_id, 'collections');
    if(empty($terms)) return false;

    $collections = array();
    foreach($terms as $collection){
        if($collection->parent == 0) {
            $collection->children = knowledgebank_find_child_terms($collection, $terms);
            $collections[$collection->term_id] = $collection;
        }
    }

    return $collections;

}

function knowledgebank_find_child_terms($parent_collection, $all_post_collections){
    $children = array();
    foreach($all_post_collections as $collection){
        if($collection->parent == $parent_collection->term_id){
            //find this term's children too
            $collection->children = knowledgebank_find_child_terms($collection, $all_post_collections);
            $children[] = $collection;
        }
    }
    return $children;
}


function knowledgebank_remove_redux_stuff(){
    global $wp_meta_boxes;

    if(!empty($wp_meta_boxes['dashboard']['side']['high']['redux_dashboard_widget'])){
        unset($wp_meta_boxes['dashboard']['side']['high']['redux_dashboard_widget']);
    }

}
add_action('wp_dashboard_setup','knowledgebank_remove_redux_stuff',100);

$redux = ReduxFrameworkInstances::get_instance('wpml_settings');
remove_action('admin_notices', array($redux, '_admin_notices'), 99);


/* Fancy search */
require_once('wp-advanced-search/wpas.php');


function knowledgebank_advanced_search_form() {
    $args = array();
    $args['wp_query'] = array('post_type' => 'post',
                              'posts_per_page' => 5);
    $args['fields'][] = array('type' => 'search',
                              'title' => 'Search',
                              'placeholder' => 'Enter search terms...');
    $args['fields'][] = array('type' => 'taxonomy',
                              'taxonomy' => 'collections',
                              'format' => 'select');
    register_wpas_form('knowledgebank_advanced_search', $args);
}
add_action('init', 'knowledgebank_advanced_search_form');
