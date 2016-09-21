<?php
/*
 *  Author: Chris Webb / Gabriel Ward
 *  URL: knowledgebank.org.nz
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Fniles
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('700w', 700, '', false); // Large Thumbnail
    add_image_size('300w', 300, '', false); // Medium Thumbnail
    add_image_size('1200w', 1200, 9999, false);
    add_image_size('700w',640,480,true);


    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('kb2', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function kb2_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

function kb2_extra_nav_menu()
{
    wp_nav_menu(
    array(
        'theme_location'  => 'extra-menu',
        'menu'            => '',
        'container'       => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id'    => '',
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
        )
    );
}

// Load HTML5 Blank scripts (header.php)
function kb2_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array('jquery'), '1'); // Flexslider
        wp_enqueue_script('flexslider');

        wp_register_script('kb2scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery','flexslider'), '1.0.1'); // Custom scripts
        wp_enqueue_script('kb2scripts');

        wp_register_script('kb2transcripts', get_template_directory_uri() . '/js/transcripts.js', array('jquery','flexslider','kb2scripts'), '1.0.1'); // Custom scripts
        wp_enqueue_script('kb2transcripts');

        wp_register_script('magnificjs', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), '1.0.1'); // Custom scripts
        wp_enqueue_script('magnificjs');

    }
}

// Load HTML5 Blank conditional scripts
function kb2_conditional_scripts()
{
    //if (is_page('pagenamehere')) {
        //wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
       // wp_enqueue_script('scriptname'); // Enqueue it!
    //}
}

// Load HTML5 Blank styles
function kb2_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('grid', get_template_directory_uri() . '/grid.css', array(), '1.0', 'all');
    wp_enqueue_style('grid'); // Enqueue it!

    wp_register_style( 'google_font', 'https://fonts.googleapis.com/css?family=Merriweather' );
    wp_enqueue_style( 'google_font' );

    wp_register_style('kb2', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('kb2'); // Enqueue it!

    wp_register_style('flexslidercss', get_template_directory_uri() . '/css/flexslider.css', array(), '1.0', 'all');
    wp_enqueue_style('flexslidercss');

    wp_register_style('magnificcss', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.0', 'all');
    wp_enqueue_style('magnificcss');
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'kb2'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'kb2'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'kb2') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
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

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'kb2'),
        'description' => __('Description for this widget-area...', 'kb2'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'kb2'),
        'description' => __('Description for this widget-area...', 'kb2'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
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

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'kb2') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function kb2gravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function kb2comments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'kb2_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'kb2_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'kb2_styles'); // Add Theme Stylesheet
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination
add_action( 'init', 'register_html5_menu'); // Add custom theme menu locations
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
add_filter('avatar_defaults', 'kb2gravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
//add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/



/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}



//Knowledge Bank


/* custom permalinks */
function change_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
}
add_action('init', 'change_permalinks');



add_filter('_wp_post_revision_fields', 'add_field_debug_preview');
function add_field_debug_preview($fields){
   $fields["debug_preview"] = "debug_preview";
   return $fields;
}
add_action( 'edit_form_after_title', 'add_input_debug_preview' );
function add_input_debug_preview() {
   echo '<input type="hidden" name="debug_preview" value="debug_preview">';
}

//Wordpress customizer link - gtfo
add_action( 'wp_before_admin_bar_render', 'wpse200296_before_admin_bar_render' );

function wpse200296_before_admin_bar_render() {
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('customize');
}


//'Quick view' previews of text posts

//allow our own get variable to be detectable with get_query_var()
function add_query_vars_filter( $vars ){
  $vars[] = "quickview";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );



function quick_view_template($single_template) {

    $quickview = get_query_var('quickview');

    if($quickview != 'true') return $single_template; //bail out, this is a regular template view

    global $post;

    if ($post->post_type == 'text') {
          $single_template = dirname( __FILE__ ) . '/quickview-text.php';
    }

    if ($post->post_type == 'video') {
          $single_template = dirname( __FILE__ ) . '/quickview-video.php';
    }

    if ($post->post_type == 'still_image') {
          $single_template = dirname( __FILE__ ) . '/quickview-image.php';
    }

    return $single_template;
}
add_filter( 'single_template', 'quick_view_template' );


function kb_nicename($post_type) {

    $names = array(
        'still_image' => 'Image',
        'video' => 'Video / Film',
        'text' => 'Text / Publication',
        'person' => 'Person',
        'audio' => 'Audio'
    );

    if(array_key_exists($post_type, $names)) {
        return $names[$post_type];
    }
    //else
    return $post_type;

}


/*************************/

//Auto-generate images from PDF and TIFF uploads

function kb_auto_images( $post_id, $post, $update ) {

    //return false; //remove me

    ini_set( 'error_log', WP_CONTENT_DIR . '/debug.log' ); //redirect error output to the debug log

    error_log('Firing doc -> image auto conversion');

    //if this isn't one of the post types we want, bail out
    if ( !in_array($post->post_type, array('text','still_image')) ) {
        return;
    }

    // unhook this function for now, so it doesn't loop infinitely when we save things on the post below
    remove_action( 'save_post', 'kb_auto_images' );

    //we have a master file and the checkbox is checked and we don't have any images, time to auto generate
    if(get_field('master',$post_id) && get_field('auto_generate_images',$post_id) && !get_field('images',$post_id)) {

        $master = get_field('master',$post_id);

        error_log('auto generate images for ' . $post_id . print_r($master,true));


        //1. Can we just copy the master over? Yes if it's an image, no if it's a tiff or a PDF or something else.

        if(isset($master['mime_type'])) {

            switch( $master['mime_type'] ) {

                //only copy images, fallthrough on accepted mime types
                case 'image/jpeg':
                case 'image/png':
                case 'image/gif':

                    //field key varies by content type, but the names are always the same. Helper function kb_acf_key below does a basic name => key conversion.
                    $image_field_key = kb_acf_key('images', 'image'); //returns array($field key, $subfield key)
                    
                    $images[] = array($image_field_key[1] => $master['id']); //add repeater row

                    update_field($image_field_key[0], $images, $post_id); //save

                    error_log('copied master to ' . $image_field_key[0] . ' on ' . $post_id);

                    return;
                    break;

            }//switch
        }
        else { //this is no image

            error_log('not an image');

        }//endif

        //If we got here, we are not dealing with an image - let's try to make some jpegs out of whatever we have.

        //get absolute file path of master
        //make output directory
        //generate images
        //turn images into wp attachments
        //save attachments to the files custom field        

        $file_path = get_attached_file( $master['id'] ); //absolute path to file we are converting

        //build our path and filename bits
        
        $uploads = wp_upload_dir();
        $uploads_sub_directory = '/attachments/' . $post_id . '/';
        $save_directory = $uploads['basedir'].$uploads_sub_directory;

        $fileparts = explode("/", $file_path);
        $current_filename = array_pop($fileparts); //includes extension
        $new_filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $current_filename); //strip extension
        $new_filename = $post_id . '_' .  $new_filename . '.jpg'; //add prefix and new extension - something like 12345_originalfilename.jpg

        $output_file_path = $save_directory . $new_filename; //full path to output file.

        if(file_exists($output_file_path)) {
            error_log('output file already exists'); 
            return false;  
        } 

        //if the directory doesn't exist, create it 
        if(!file_exists($save_directory)) {
            echo 'Making directory ' . $save_directory . "\n";
            mkdir($save_directory,0775,true);
            echo 'Made directory ' . $save_directory . "\n";
        }

        //do conversion

        //Use imagemagick's convert command to make jpeg(s) from the import file. Imagemagick will auto detect and handle pretty much what we throw at it - jpeg, tiff or pdf. Also handles multiple pages.
        exec('convert -quality 90 -interlace none -density 300 -format jpg -resize 1800x1800 ' . $file_path . ' ' . $output_file_path);
        error_log('convert -quality 90 -interlace none -density 300 -format jpg -resize 1800x1800 ' . $file_path . ' ' . $output_file_path);
        

        //ok then, that either worked or it didn't. Let's check.
        //if we got multiple jpegs from a multi-page file, they will be numbered. If we only got one, we'll just handle it the same way.        
        $jpegs = glob($save_directory . '*.jpg'); //get a list of all the jpegs in the output directory
            
        if (!empty($jpegs)) { //we got one or more

            natsort($jpegs); //get our numbered filenames in the right natural order (so we get 1, 2, 3 instead of 1, 10, 2, 3 etc)
        
            foreach($jpegs as $jpeg) {

                echo 'Attempting to open file for copying ' . $jpeg . "\n";

                if (file_exists($jpeg) && fclose(fopen($jpeg, "r"))) { //make sure the file actually exists

                    $siteurl = get_option('siteurl');
                    
                    $file_info = getimagesize($jpeg); //despite the name gets a bit more than size

                    //create an array of attachment data to insert into wp_posts table            
                    $artdata = array(
                        'post_author' => 1, 
                        'post_date' => current_time('mysql'),
                        'post_date_gmt' => current_time('mysql'),
                        'post_title' => $new_filename, 
                        'post_status' => 'inherit',
                        'comment_status' => 'closed',
                        'ping_status' => 'closed',
                        'post_name' => sanitize_title_with_dashes(str_replace("_", "-", $new_filename)),                                            
                        'post_modified' => current_time('mysql'),
                        'post_modified_gmt' => current_time('mysql'),
                        'post_parent' => '', //$post_id
                        'post_type' => 'attachment',
                        'guid' => sanitize_title_with_dashes(str_replace("_", "-", $new_filename)),
                        'post_mime_type' => $file_info['mime'],
                        'post_excerpt' => '',
                        'post_content' => ''
                    );  

                    //insert the database record
                    //echo "attaching to WP\n" . print_r($artdata,true) . "\n";
                    try{

                        $defaults = array(
                                'file'        => $jpeg,
                                'post_parent' => 0
                        );

                        $data = wp_parse_args( $artdata, $defaults );
                
                        if ( ! empty( $parent ) ) {
                                $data['post_parent'] = $parent;
                        }
                
                        $data['post_type'] = 'attachment';        
                        
                        $attach_id = wp_insert_post( $data, true );
                        
                    }
                    catch(Exception $e) {
                        //echo 'no deal'; exit;
                        error_log('Could not create an attachment for ' . $post_id);
                    }

                    //generate metadata and thumbnails
                    //echo 'making image metadata' . "\n";
                    if ($attach_data = wp_generate_attachment_metadata( $attach_id, $jpeg)) {

                        if(is_wp_error($attach_data)) {
                            error_log($attach_data->get_error_message());
                        }
                        else {
                            error_log("adding image metadata\n");
                            wp_update_attachment_metadata($attach_id, $attach_data);
                        }
                        
                    }

                    //all done, add this image to our image field if everything looks ok
                    if(!empty($attach_id)){

                        //first get current field value
                        $images = get_field('images',$post_id);
                        if(empty($images)) $images = array(); //initialise if empty

                        //field key varies by content type, but the names are always the same. Helper function kb_acf_key below does a basic name => key conversion.
                        $image_field_key = kb_acf_key('images', 'image'); //returns array($field key, $subfield key)
                        
                        $images[] = array($image_field_key[1] => $attach_id); //add repeater row

                        update_field($image_field_key[0], $images, $post_id); //save

                        error_log('added image to repeater field ' . $image_field_key[0] . ' on ' . $post_id);

                    }

                }//endif

            }//foreach

        } //endif conversion worked        
        
    }//endif conditions for auto generation are satisified

    // re-hook this function
    add_action( 'save_post', 'kb_auto_images', 10, 3 );

}//kb_auto_images()

add_action( 'save_post', 'kb_auto_images', 10, 3 );


//key an ACF field key by name
function kb_acf_key($name, $subfield = null) {

    global $post;

    $fieldgroup_ids = array(
        'collections' => 35640,
        'still_image' => 37072, 
        'video' => 35615,
        'person' => 36254,
        'audio' => 51154,
        'text' => 51186,        
    );
        
    //Get all the fields on an ACF field group
    $fields = acf_get_fields_by_id($fieldgroup_ids[$post->post_type]);

    foreach($fields as $field) {

        if($field['name'] == $name) {

            if($subfield != null){

                if(!empty($field['sub_fields'])) {

                    foreach($field['sub_fields'] as $sub) {

                        if($sub['name'] == $subfield) {
                            return array($field['key'],$sub['key']);                                    
                        }

                    }
                    return false;

                }
                else {
                    return false;
                }
            }
            else {
                return $field['key'];
            }
        }

    }

}//acf_key()


/*************************/




add_filter( 'posts_search', 'my_search_is_perfect', 20, 2 );
function my_search_is_perfect( $search, $wp_query ) {
    global $wpdb;

    if ( empty( $search ) )
        return $search;

    $q = $wp_query->query_vars;
    $n = !empty( $q['exact'] ) ? '' : '%';

    $search = $searchand = '';

    foreach ( (array) $q['search_terms'] as $term ) {
        $term = esc_sql( $wpdb->esc_like( $term ) );

        $search .= "{$searchand}($wpdb->posts.post_title REGEXP '[[:<:]]{$term}[[:>:]]') OR ($wpdb->posts.post_content REGEXP '[[:<:]]{$term}[[:>:]]')";

        $searchand = ' AND ';
    }

    if ( ! empty( $search ) ) {
        $search = " AND ({$search}) ";
        if ( ! is_user_logged_in() )
            $search .= " AND ($wpdb->posts.post_password = '') ";
    }

    return $search;
}




?>

