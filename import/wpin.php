<pre>
<?php

if(php_sapi_name() != "cli") die('cli only');


require_once('/webs/new/wp-load.php');
require_once('/webs/new/wp-admin/includes/media.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function import_log($message){
	file_put_contents('import.log', date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
}

	//still_image
	//$mode = 'still_image';
	//$fgid = 37072; //fieldgroup id

	//video
	//$mode = 'video';
	//$fgid = 35615; //fieldgroup id

	//person
	//$mode = 'person';
	//$fgid = 36254; //fieldgroup id

	//audio
	//$mode = 'audio';
	//$fgid = '51154';//fieldgroup id

	//text
	//$mode = 'text';
	//$fgid = '51186';

	//Different things to import - we will loop through them all

	//taxonomies first, content second

	$modes = array(
		'collections' => 35640,//$mode => $fgid
		'tags' => '',
		'subjects' => '',
		'still_image' => 37072,
		'video' => 35615,
		'person' => 36254,
		'audio' => 51154,
		'text' => 51186,
	);


	foreach($modes as $mode => $fgid) :

		//Get all the fields on an ACF field group
		$fields = acf_get_fields_by_id($fgid);

		switch($mode) {

			//nodes
			case 'still_image':
			case 'person':
			case 'text':
			case 'video':
			case 'audio':
			case 'book':
				$count = 0;
				//have to get content from another script, can't bootstrap both WP and Drupal in this one
				//json is as good as anything for the job
				$json = file_get_contents('http://new.knowledgebank.org.nz/import/drupalout.php?mode=' . $mode);

				if($mode == 'book') $mode = 'bibliography'; //books are renamed bibliography in WP

				$nodes = json_decode($json,true);//true = return as A_ARRAY

				$templatepath = '/webs/new/import/node.php';

				if(!empty($nodes) && file_exists($templatepath)) {


					$limit = 0;

					$update_existing = true;

					foreach($nodes as $node) :

						$wp_id = nid_to_wpid($node['nid']);

						if(!empty($wp_id) && $update_existing == false){
							import_log("drupal: {$node['nid']} already exists (wp: $wp_id)\n");
							//continue;
						}

						if(empty($wp_id)){ //need to create a post

							//Post
							$status = ($node['status'] == 1 ? 'publish' : 'draft');

							$new_post = array(
							    'post_title' => $node['title'],
							    'post_date' => date('Y-m-d H:i:s',$node['created']),
							    'post_modified' => date('Y-m-d H:i:s',$node['changed']),
							    'post_content' => (isset($node['body']['und'][0]['value']) ? $node['body']['und'][0]['value'] : ''),
							    'post_status' => $status,
							    'post_type' => $mode,
							    'import_id' => $node['nid'], //preserve Drupal nid if possible (but we cannot rely on it)
							    'post_author' => 5115,
								'meta_input' => array('_drupal_nid' => $node['nid'])
							);
							$wp_id = wp_insert_post( $new_post );
							import_log('Inserted ' . $wp_id );

							$wp_post = get_post($wp_id);

						}
						else{ //update with current details

							$status = ($node['status'] == 1 ? 'publish' : 'draft');
							
							$updated_post = array(
								'ID' => $wp_id,
							    'post_title' => $node['title'],
							    'post_modified' => date('Y-m-d H:i:s',$node['changed']),
							    'post_content' => (isset($node['body']['und'][0]['value']) ? $node['body']['und'][0]['value'] : ''),
							    'post_status' => $status,
							);
							wp_update_post($updated_post);

							$wp_post = get_post($wp_id);
						}

						//Now do the data update / import
						/********************************************/

						include($templatepath);

						/*********************************************/


						$count+=1;

						if($limit > 0 && $count == $limit) break;

					endforeach;


				}
				else {

					import_log("$json could not be decoded for $mode or no template found\n");
					//exit;

				}

				import_log("Did $count nodes");


			break;

			case 'collections': //does both collections and series from drupal
				echo 'collections';

				$json = file_get_contents('http://new.knowledgebank.org.nz/import/drupalout.php?mode=collections');

				$terms = json_decode($json,true);

				$json2 = file_get_contents('http://new.knowledgebank.org.nz/import/drupalout.php?mode=series');

				$terms2 = json_decode($json2,true);

				$d_collections_unsorted = array_merge($terms,$terms2);

				$d_collections = array();

				foreach($d_collections_unsorted as $term) {
					$d_collections[$term['tid']] = $term;
				}

				//print_r($d_collections);

				import_log(count($d_collections) . " collections in Drupal\n");

				foreach($d_collections as $t) {

					$tid = $t['tid'];

					if(get_term($tid,'collections')) {
						import_log('Term ' . $tid . " already exists\n");
						//continue;
					}

					//else get on with inserting the term

					$wpdb->query('INSERT INTO `wp_terms` values ('  . $t["tid"] . ',"' . $t["name"] . '","' . $t["tid"] . '",0) ON DUPLICATE KEY UPDATE term_id = ' . $t["tid"] . ', name = "' . $t['name'] . '", slug = "' . $t['tid'] . '"');

					$parent = 0;
					if(isset($t['field_collections']['und'][0]['tid'])){
						$parent = $t['field_collections']['und'][0]['tid'];
					}

					$wpdb->query('INSERT INTO `wp_term_taxonomy` (term_id, taxonomy, parent) VALUES ("' . $t["tid"] . '", "collections", "' . $parent . '") ON DUPLICATE KEY UPDATE term_id = ' . $t['tid'] . ', taxonomy = "collections", parent = ' . $parent);


					import_log('Inserted term ' . $t["tid"] . ' (' . $t['name'] . ')' );

					$filefield = 'field_donor_form';
					if(isset($t[$filefield]['und']['0']['uri']) && !get_field('donor_form','collections_' . $tid)) {
						$file_path = str_replace('public://','/webs/hbda/sites/default/files/', $t[$filefield]['und']['0']['uri']);

						$fileid = kb_fetch_media($file_path,$tid,'/collections/'.$tid.'/');

						if($fileid) {

							update_field('field_56b452c658411',$fileid,'collections_' . $tid);
							import_log('File ' . $fileid . ' attached to ' . $tid );

						}
						else{
							import_log('Failed to attach file');
						}

					}


					foreach($fields as $field) {

						//simple text fields

						if(in_array($field['type'], array('text','radio','wysiwyg','true_false','select')) && isset($t['field_' . $field['name']]['und'][0]['value'])) {

							import_log("Doing field " . 'field_' . $field['name'] );

							update_field($field['key'], $t['field_' . $field['name']]['und'][0]['value'], 'collections_' . $tid);
							import_log("Added value " .  $t['field_' . $field['name']]['und'][0]['value'] . ' to ' . $field['name'] . ' (' . $field['key'] . ')' );
							unset($t['field_' . $field['name']]);
						}
						elseif( isset($t['field_' . $field['name']]) ){
							unset($t['field_' . $field['name']]);
						}


					}


					import_log('Updated term ' . $tid . ' (' . $t['name'] . ')' );

					import_log('Left in d_term: ' . print_r($t,true) );

				}

				delete_option("collections_children");

			break;

			case 'tags':
			case 'subjects':

				$json = file_get_contents('http://new.knowledgebank.org.nz/import/drupalout.php?mode=' . $mode);

				$terms = json_decode($json,true);

				foreach($terms as $t) {

					$tid = $t['tid'];

					if(get_term($tid,$mode)) {
						//import_log('Term ' . $tid . " already exists, moving on\n");
						//continue;
					}

					//else get on with inserting the term

					$wpdb->query('REPLACE INTO `wp_terms` values ('  . $t["tid"] . ',"' . $t["name"] . '","' . $t["tid"] . '",0)');

					//$wpdb->query('REPLACE INTO `wp_terms` values (%d, "%s", "%d",0)',$t["tid"],$t["name"],$t["tid"]);

					$parent = 0;

					if($mode == 'tags') $mode = 'post_tag';
					if($mode == 'subjects') $mode = 'subject';

					$wpdb->query('REPLACE INTO `wp_term_taxonomy` (term_id, taxonomy, parent) VALUES ("' . $t["tid"] . '", "' . $mode . '", "' . $parent . '")');

					import_log('Inserted term ' . $t["tid"] . ' (' . $t['name'] . ')' );

				}

			break;

		}//switch

	endforeach;

/**
* Fetch remote physical media and stick it in WordPress
* Need the existing file path, the Wordpress post to attach the media to, and the desired save path within the Wordpress uploads directory
*/
function kb_fetch_media($file_path, $wp_id, $uploads_subdir) {
	//require_once(ABSPATH . 'wp-load.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	global $wpdb;

	//rename the file
	$fileparts = explode("/", $file_path);
	$filename = array_pop($fileparts);

	//directory to import to
	// Get the path to the upload directory.
	$wp_upload_dir = wp_upload_dir();
	$save_dir = $wp_upload_dir['basedir'].$uploads_subdir;
	$save_path = $save_dir. $filename;

	//if the directory doesn't exist, create it
	if(!file_exists($save_dir)) {
		import_log('Making directory ' . $save_dir );
		mkdir($save_dir,0775,true);
		import_log('Made directory ' . $save_dir );
	}

	import_log('Attempting to open file for copying ' . $file_path );
	if (file_exists($file_path) && fclose(fopen($file_path, "r"))) { //make sure the file actually exists

		import_log('Copying ' . $file_path . " to " . $save_path ."\n");
		copy($file_path, $save_path);

		$siteurl = get_option('siteurl');
		import_log("getimagesize()\n");
		$file_info = getimagesize($save_path);

		// Check the type of file. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $save_path ), NULL );

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $save_path ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $save_path ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $save_path, $wp_id );

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $save_path );

		if(is_wp_error($attach_data)) {
			import_log($attach_data->get_error_message());
			return false;
		}
		else {
			import_log("adding image metadata\n");
			wp_update_attachment_metadata($attach_id, $attach_data);
		}

		return $attach_id;

	}
	else {
		import_log("File at $file_path does not exist");
		return false;
	}

}


//key a field key by name
function acf_key($name, $subfield = null) {

	global $fields;

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

/**********************************************************************/

function kb_add_term($cid,$taxonomy) {

	global $wpdb;

	$json = file_get_contents('http://new.knowledgebank.org.nz/import/drupalout.php?mode=' . $taxonomy . '&tid=' . $cid);

	$t = json_decode($json,true);

	if(!empty($t)) {

		$tid = $t['tid'];

		$wpdb->query('INSERT INTO `wp_terms` values ('  . $t["tid"] . ',"' . $t["name"] . '","' . $t["tid"] . '",0) ON DUPLICATE KEY UPDATE term_id = ' . $t["tid"] . ', name = "' . $t['name'] . '", slug = "' . $t['tid'] . '"');

		$parent = 0;

		if(isset($t['field_collections']['und'][0]['tid'])){
			$parent = $t['field_collections']['und'][0]['tid'];
		}

		$wpdb->query('INSERT INTO `wp_term_taxonomy` (term_id, taxonomy, parent) VALUES ("' . $t["tid"] . '", "' . $taxonomy . '", "' . $parent . '") ON DUPLICATE KEY UPDATE term_id = ' . $t['tid'] . ', taxonomy = "' . $taxonomy . '", parent = ' . $parent);

		import_log('Inserted term ' . $t["tid"] . ' (' . $t['name'] . ')' );

		$filefield = 'field_donor_form';
		if(isset($t[$filefield]['und']['0']['uri'])) {
			$file_path = str_replace('public://','/webs/hbda/sites/default/files/', $t[$filefield]['und']['0']['uri']);

			$fileid = kb_fetch_media($file_path,$tid,'/collections/'.$tid.'/');

			if($fileid) {

				update_field('field_56b452c658411',$fileid,'collections_' . $tid);
				import_log('File ' . $fileid . ' attached to ' . $tid );

			}

		}


		import_log('Updated term ' . $tid . ' (' . $t['name'] . ')' );


	}

}


function nid_to_wpid($nid){
	global $wpdb;
	$result = $wpdb->get_results("SELECT post_id FROM wp_postmeta WHERE meta_key = '_drupal_nid' AND meta_value = '$nid'");
	return !empty($result[0]->post_id) ? $result[0]->post_id : false;
}




?>
</pre>
