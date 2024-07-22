<?php


if (class_exists('BigFileUploads')) { //great plugin, PITFA for upload dirs

    function edd_change_downloads_upload_dir() {
        global $pagenow;

        // print_r($_REQUEST);
        // die();

        if (!empty($_REQUEST['post_id']) &&  in_array($_REQUEST['_acfuploader'], ['field_56d3eb0040e96', 'field_56e8fa267d168', 'field_56e8f5252c76c', 'field_56b1b000cc95a'])) { //acf 'master' field keys - still image, text, audio, video


            add_filter('upload_dir', 'knowledgebank_master_upload_directory');
        } elseif (!empty($_REQUEST['post_id'] && in_array($_REQUEST['_acfuploader'], ['field_56d52ee7363d5', 'field_56e8fa2681099', 'field_56b1b2da7d393', 'field_56c189ce6ed93']))) { //acf 'images' field keys - still image, text, video,person
            add_filter('upload_dir', 'knowledgebank_image_upload_directory');
        }
    }
    add_filter('bfu_upload_base_dir', 'edd_change_downloads_upload_dir', 11);
} else {
    function knowledgebank_acf_upload_prefilter($errors, $file, $field) {
        //this filter changes directory just for item being uploaded
        add_filter('cud_generate_path', 'knowledgebank_master_upload_directory', 10, 2);

        return $errors;
    }
    add_filter('acf/upload_prefilter/name=master', 'knowledgebank_acf_upload_prefilter', 10, 3);

    function knowledgebank_acf_upload_prefilter_images($errors, $file, $field) {
        //this filter changes directory just for item being uploaded
        add_filter('cud_generate_path', 'knowledgebank_image_upload_directory', 10, 2);

        return $errors;
    }
    add_filter('acf/upload_prefilter/name=images', 'knowledgebank_acf_upload_prefilter_images', 10, 3);
}




function knowledgebank_master_upload_directory($dir) {

    $post_id = $_REQUEST['post_id'];

    //create /node/[ID]/ and /node/[ID]/master/ dirs if needed
    $path = "/webs/new/wp-content/uploads/node/$post_id";
    if (!file_exists($path)) {
        mkdir($path);
    }

    $path .= '/master';
    if (!file_exists("$path")) {
        mkdir($path);
    }


    $dir['path']   = $path;
    $dir['subdir'] .= "/node/$post_id/master";
    $dir['url']    .= "/node/$post_id/master";

    return $dir;
}

function knowledgebank_image_upload_directory($dir) {

    $post_id = $_REQUEST['post_id'];

    //create /node/[ID]/ and /node/[ID]/images/ dirs if needed
    $path = "/webs/new/wp-content/uploads/node/$post_id";
    if (!file_exists($path)) {
        mkdir($path);
    }

    $path .= '/images';
    if (!file_exists($path)) {
        mkdir($path);
    }


    $dir['path']   = $path;
    $dir['subdir'] .= "/node/$post_id/images";
    $dir['url']    .= "/node/$post_id/images";

    return $dir;
}

//if a collection is already chosen, filter the collections select box to children of the chosen collection - this is used with some custom JS
function knowledgebank_collections_hierarchy($args, $field, $post_id) {
    $args['parent'] = empty($_POST['parent']) ? 0 : $_POST['parent'];
    $args['number'] = 999999;
    return $args;
}
add_filter('acf/fields/taxonomy/query/name=collections', 'knowledgebank_collections_hierarchy', 10, 3);

//With related collections we don't want to lock it down to just one chosen parent collection, but we do want to promote the children of chosen collections
function knowledgebank_related_collections_hierarchy($args, $field, $post_id) {

    if (!empty($_POST['related_collection_parents'])) {
        $term_ids = [];
        foreach ($_POST['related_collection_parents'] as $pid) {
            $term_ids[] = $pid;
            $term_children = get_term_children($pid, 'collections');
            if (!empty($term_children) && !is_wp_error($term_children)) {
                $term_ids = array_unique(array_merge($term_ids, $term_children));
            }
        }

        if (!empty($term_ids)) {
            //get top-level collections too
            $top_collections = get_terms(array('taxonomy' => 'collections', 'hide_empty' => false, 'parent' => 0, 'fields' => 'ids'));
            $term_ids = array_unique(array_merge($term_ids, $top_collections));
            $args['include'] = $term_ids;
            $args['orderby'] = 'include';
        }
    }


    return $args;
}
add_filter('acf/fields/taxonomy/query/name=related_collections', 'knowledgebank_related_collections_hierarchy', 10, 3);


function knowledgebank_term_accession_number($field) {
    $field['disabled'] = 1;
    if (empty($field['value']) && !empty($_GET['tag_ID']) && !empty($_GET['taxonomy'])) {
        $term = get_term_by('id', $_GET['tag_ID'], 'collections');
        if (empty($term)) return $field; //bail out
        $accession_number = $_GET['tag_ID'];

        if ($term->parent != 0) {
            while ($term->parent != 0) { //prepend parents until we run out of parents
                $accession_number = $term->parent . "/" . $accession_number;
                $term = get_term_by('id', $term->parent, 'collections');
            }
        }

        //update for reals
        remove_filter('acf/load_field/key=field_5c7cca30a8a4a', 'knowledgebank_term_accession_number');
        update_field('field_5c7cca30a8a4a', $accession_number, 'collections_' . $_GET['tag_id']);

        $field['value'] = $accession_number;
        return $field;
    }
    return $field;
}
add_filter('acf/load_field/key=field_5c7cca30a8a4a', 'knowledgebank_term_accession_number');

//Allow new posts to be created with collections pre-chosen via the URL
function knowledgebank_new_post_collections($field) {
    global $pagenow;

    if (in_array($pagenow, array('post-new.php')) && !empty($_GET['collections'])) {
        $field['value'] = $_GET['collections'];
    }
    return $field;
}
add_filter('acf/load_field/name=collections', 'knowledgebank_new_post_collections', 10, 1);


function knowledgebank_wysiwyg_render_field_settings($field) {
    acf_render_field_setting($field, array(
        'label'            => __('Height of Editor'),
        'instructions'    => __('Height of Editor after Init'),
        'name'            => 'wysiwyg_height',
        'type'            => 'number',
    ));
}
add_action('acf/render_field_settings/type=wysiwyg', 'knowledgebank_wysiwyg_render_field_settings', 10, 1);
/**
 * Render height on ACF WYSIWYG
 */
function knowledgebank_wysiwyg_render_field($field) {
    $field_class = '.acf-' . str_replace('_', '-', $field['key']);
?>
    <style type="text/css">
        <?php echo $field_class; ?>iframe {
            min-height: <?php echo $field['wysiwyg_height']; ?>px;
        }
    </style>
    <script type="text/javascript">
        jQuery(window).load(function() {
            jQuery('<?php echo $field_class; ?>').each(function() {
                jQuery('#' + jQuery(this).find('iframe').attr('id')).height(<?php echo $field['wysiwyg_height']; ?>);
            });
        });
    </script>
<?php
}
add_action('acf/render_field/type=wysiwyg', 'knowledgebank_wysiwyg_render_field', 10, 1);

//create checksums for original digital master field files
function knowledgebank_master_generate_checksum($value, $post_id, $field, $original) {

    if (!empty($value)) {
        $file = get_attached_file($value);
        $path = dirname($file);
        $checksum_path = $path . '/master.md5';
        if (file_exists($path)) {
            exec("md5sum $file > $checksum_path");
        }
    }

    return $value;
}
add_action('acf/update_value/name=master', 'knowledgebank_master_generate_checksum', 10, 4);

function knowledgebank_commercial_licence_default($value, $post_id, $field) {
    if (empty($value)) $value = get_post(514797);
    return $value;
}
add_filter('acf/load_value/name=commercial_licence', 'knowledgebank_commercial_licence_default', 10, 3);

function kb_format_original_values() {

    global $wpdb;

    /*
    $results = $wpdb->get_col( $wpdb->prepare( "
         SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = 'format_original' AND meta_value LIKE %s",
         '%' . $_GET['keyword'] . '%'
    ));
    */

    $field = get_field_object('field_625b3c43ab672'); //format_of_the_original in theme settings
    if (!empty($field['choices'])) {
        $term = $_GET['keyword'];
        $choices = array_filter($field['choices'], function ($choice) use ($term) {
            return stripos($choice, $term) !== false;
        });
        wp_send_json($choices);
    }

    wp_send_json([]);
} //kb_format_original_values()
add_action('wp_ajax_nopriv_kb_format_original_values', 'kb_format_original_values');
add_action('wp_ajax_kb_format_original_values', 'kb_format_original_values');

//this is a select field, but some legacy non-selectable values need to be preserved
//If we have post meta for format_original but no acf field value, it's a legacy one so we include it in the select options
function knowledgebank_format_original_values($field) {

    global $post;
    if (!empty($post->format_original) && empty($field['value'])) $field['value'] = $post->format_original;
    //print_r($field); exit;
    /*
    $choices_field = get_field_object('field_625b3c43ab672'); //format_of_the_original in theme settings
    if(!empty($choices_field['choices'])){
        $field['choices'] = $choices_field['choices'];
    }
    */
    $choices_values = get_option('options_format_of_the_original');
    //print_r($choices_values);
    if (!empty($choices_values)) {
        $choices = explode(PHP_EOL, $choices_values);
        $choices = array_combine($choices, $choices); //gives us an array with the same keys as values
        $field['choices'] =  $choices;
    }

    if (!in_array($field['value'], $field['choices'])) {
        $field['choices'][$field['value']] = $field['value'];
    }
    //print_r($field);
    return $field;
}
add_filter('acf/load_field/name=format_original', 'knowledgebank_format_original_values');
add_filter('acf/load_field/key=field_56e8fa267d692', 'knowledgebank_format_original_values');


function fix_post_id_on_preview($null, $post_id) {
    if (is_preview() && $post_id !== 'options') {
        return get_the_ID();
    } else {
        $acf_post_id = isset($post_id->ID) ? $post_id->ID : $post_id;

        if (!empty($acf_post_id)) {
            return $acf_post_id;
        } else {
            return $null;
        }
    }
}
add_filter('acf/pre_load_post_id', 'fix_post_id_on_preview', 10, 2);


function knowledgebank_auto_generate_field($field) {

    global $post;
    if (!is_admin() || empty($post->ID)) return $field;


    $status = knowledgebank_conversion_status($post->ID);
    if ($status) $field['instructions'] .= '<div class="conversion-status-wrap"><b>Conversion status</b>: <span id="conversion-status">' . $status . '</span> <a class="cancel" href="/wp-admin/admin-ajax.php?action=cancel_master_conversion&post_id=' . $post->ID . '">cancel</a></div>';

    return $field;
}
add_filter('acf/load_field/name=images', 'knowledgebank_auto_generate_field');
add_filter('acf/load_field/name=audio', 'knowledgebank_auto_generate_field');


function knowledgebank_conversion_status($post_id) {



    $status = get_post_meta($post_id, '_master_conversion_status', true);
    if (empty($status)) return false;

    $output = $status['status'];

    if ($status['status'] == 'Generating images from PDF') {
        $jpgs = glob($status['output'] . '/*.jpg');
        if (empty($jpgs)) {
            $count = 0;
        } else {
            $count = count($jpgs);
        }
        $output .= ' ' . $count . ' / ' . $status['pages'];
    }

    if ($status['status'] == 'Adding images to WordPress') {
        $jpgs = get_post_meta($post_id, 'images', true);
        if (empty($jpgs)) {
            $count = 0;
        } else {
            $count = count($jpgs);
        }
        $output .= ' ' . $count . ' / ' . $status['pages'];
    }

    return $output;
}

function knowledgebank_conversion_status_handler() {
    $post_id = !empty($_GET['post_id']) ? $_GET['post_id'] : false;
    if (empty($post_id)) return false;

    echo knowledgebank_conversion_status($post_id);
    exit;
}
add_action('wp_ajax_nopriv_conversion_status', 'knowledgebank_conversion_status_handler');
add_action('wp_ajax_conversion_status', 'knowledgebank_conversion_status_handler');


function knowledgebank_cancel_master_conversion() {
    $post_id = !empty($_GET['post_id']) ? $_GET['post_id'] : false;
    if (empty($post_id)) return false;
    delete_post_meta($post_id, '_master_conversion_status');
}

add_action('wp_ajax_cancel_master_conversion', 'knowledgebank_cancel_master_conversion');
