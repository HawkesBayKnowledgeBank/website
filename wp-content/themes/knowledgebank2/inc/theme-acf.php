<?php

//change upload dir for records
function knowledgebank_acf_upload_prefilter( $errors, $file, $field ) {
    //this filter changes directory just for item being uploaded
    add_filter('cud_generate_path', 'knowledgebank_master_upload_directory',10,2);

    return $errors;
}
add_filter('acf/upload_prefilter/name=master', 'knowledgebank_acf_upload_prefilter',10,3);

function knowledgebank_master_upload_directory( $dir, $post_id){

    $filename = basename($dir);

    //create /node/ and /node/master/ dirs if needed
    $dir = "/node/$post_id";
    if(!file_exists($param['basedir'] . $dir)){
        mkdir($param['basedir'] . $dir);
    }
    $dir .= "/master";
    if(!file_exists($param['basedir'] . $dir)){
        mkdir($param['basedir'] . $dir);
    }

    return $dir;// . $filename;
}


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


function knowledgebank_wysiwyg_render_field_settings( $field ) {
	acf_render_field_setting( $field, array(
		'label'			=> __('Height of Editor'),
		'instructions'	=> __('Height of Editor after Init'),
		'name'			=> 'wysiwyg_height',
		'type'			=> 'number',
	));
}
add_action('acf/render_field_settings/type=wysiwyg', 'knowledgebank_wysiwyg_render_field_settings', 10, 1 );
/**
 * Render height on ACF WYSIWYG
 */
function knowledgebank_wysiwyg_render_field( $field ) {
	$field_class = '.acf-'.str_replace('_', '-', $field['key']);
?>
	<style type="text/css">
	<?php echo $field_class; ?> iframe {
		min-height: <?php echo $field['wysiwyg_height']; ?>px;
	}
	</style>
	<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery('<?php echo $field_class; ?>').each(function() {
			jQuery('#'+jQuery(this).find('iframe').attr('id')).height( <?php echo $field['wysiwyg_height']; ?> );
		});
	});
	</script>
<?php
}
add_action( 'acf/render_field/type=wysiwyg', 'knowledgebank_wysiwyg_render_field', 10, 1 );
