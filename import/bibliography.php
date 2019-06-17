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
	echo date('Y-m-d H:i:s') . " - $message\n";
}


	$modes = array(
		'book' => 279435,
	);


	foreach($modes as $mode => $fgid) :

		//Get all the fields on an ACF field group
		$fields = acf_get_fields($fgid);

		$count = 0;
		//have to get content from another script, can't bootstrap both WP and Drupal in this one
		//json is as good as anything for the job
		$json = file_get_contents('http://new.knowledgebank.org.nz/import/drupalout.php?mode=' . $mode);

		$mode = 'bibliography'; //books are renamed bibliography in WP

		$nodes = json_decode($json,true);//true = return as A_ARRAY

		$templatepath = '/webs/new/import/node.php';

		if(!empty($nodes) && file_exists($templatepath)) {

			$limit = 0;

			$update_existing = true;

			foreach($nodes as $node) :


				$wp_id = nid_to_wpid($node['nid']);

				if(!empty($wp_id) && $update_existing == false){
					import_log("drupal: {$node['nid']} already exists (wp: $wp_id)\n");
					continue;
				}

				if(empty($wp_id)){ //need to create a post
					echo "Need a new post for " . $node['nid'] . "\n";
					continue;
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

					// $status = ($node['status'] == 1 ? 'publish' : 'draft');
					//
					// $updated_post = array(
					// 	'ID' => $wp_id,
					//     'post_title' => $node['title'],
					//     'post_modified' => date('Y-m-d H:i:s',$node['changed']),
					//     'post_content' => (isset($node['body']['und'][0]['value']) ? $node['body']['und'][0]['value'] : ''),
					//     'post_status' => $status,
					// );
					// wp_update_post($updated_post);

					$wp_post = get_post($wp_id);
				}

				//Now do the data update / import
				/********************************************/

				$nid = $node['nid'];


				import_log("Doing node $nid / wp_id $wp_id ");
				import_log("********************************************************************");


		/***********************/
		//		print_r($node);
		//		exit;
		/***********************/

		if(!empty($node['field_bibliography_subjects']['und'])){

			$subs = $node['field_bibliography_subjects']['und'];
			$wp_term_ids = [];
			foreach($subs as $sub){
				$tid = $sub['tid'];
				$wp_term = get_term_by('id',$tid,'bibliography_subjects');
				if(!empty($wp_term)){
					$wp_term_ids[] = $wp_term->term_id;
				}
			}
			if(!empty($wp_term_ids)){
				wp_set_object_terms($wp_id, $wp_term_ids, 'bibliography_subjects');
				echo "Updated $wp_id with " . print_r($wp_term_ids,true) . "\n";
				//update_field()
			}

		}


				//unset($node['body']); //I will unset things from my temporary $node array as I go, so I can see at the end what's left / not processed

		// 		//Collections
		// 		if(isset($node['field_collections']['und'][0]['tid'])){
		// 			import_log("Doing collections");
		// 			$cid = $node['field_collections']['und'][0]['tid'];
		//
		// /*
		// 			//see if the collection exists already
		// 			$collection = get_term($cid,'collections');
		//
		// 			if(empty($collection)) {
		// 				kb_add_term($cid,'collections');
		// 			}
		// */
		//
		// 			wp_set_object_terms( $wp_id, $cid, 'collections' );
		// 			$collections = array($cid);
		// 			update_field(acf_key('collections'), $collections, $wp_id);
		//
		// 			import_log('Set collection ' . $cid );
		//
		// 			unset($node['field_collections']);
		// 		}
		//
		// 		//Series
		// 		if(isset($node['field_series']['und'][0]['tid'])){
		// 			import_log("Doing series");
		// 			$cid = $node['field_series']['und'][0]['tid'];
		//
		// 			//see if the collection exists already
		// 			$series = get_term($cid,'collections');
		//
		// 			if(empty($series)) {
		// 				kb_add_term($cid,'collections');
		// 			}
		//
		// 			wp_set_object_terms( $wp_id, $cid, 'collections', true ); //true = append
		//
		// 			if(empty($collections)) $collections = array();
		// 			$collections[] = $cid;
		// 			update_field(acf_key('collections'), $collections, $wp_id);
		//
		// 			import_log('Set series ' . $cid );
		// 			unset($node['field_series']);
		// 		}
		//
		//
		//
		// 		//subjects
		// 		if(isset($node['field_subjects']['und'][0]['tid'])){
		// 			import_log("Doing subjects");
		//
		// 			$terms = array();
		//
		// 			foreach($node['field_subjects']['und'] as $term) {
		//
		// 				$wp_term = get_term( $term['tid'] ,'subjects');
		//
		// 				if(empty($wp_term)) {
		// 					kb_add_term( $term['tid'] ,'subjects');
		// 				}
		//
		// 				$terms[] = $term['tid'];
		// 			}
		//
		// 			wp_set_post_terms( $wp_id, $terms, 'subject' );
		// 			update_field(acf_key('subjects'), $terms, $wp_id);
		// 			import_log('Set terms ' . print_r($terms,true) . " on subjects");
		// 			unset($node['field_subjects']);
		// 		}
		//
		// 		//tags
		// 		if(isset($node['field_tags']['und'][0]['tid'])){
		// 			import_log("Doing tags");
		//
		// 			$terms = array();
		//
		// 			foreach($node['field_tags']['und'] as $term) {
		//
		// 				$wp_term = get_term( $term['tid'] ,'post_tag');
		//
		// 				if(empty($wp_term)) {
		// 					kb_add_term( $term['tid'] ,'post_tag');
		// 				}
		//
		// 				$terms[] = $term['tid'];
		// 			}
		//
		// 			wp_set_post_terms( $wp_id, $terms, 'post_tag' );
		// 			update_field(acf_key('tags'), $terms, $wp_id);
		// 			import_log('Set terms ' . print_r($terms,true) . " on tags");
		// 			unset($node['field_tags']);
		// 		}
		//
		//
		// 		//FILES
		//
		// 		//master
		// 		$filefield = 'field_master';
		// 		if(isset($node[$filefield]['und']['0']['uri']) && !get_field('master', $wp_id)) {
		// 			import_log("Doing field_master");
		// 			$file_path = str_replace('public://','/webs/hbda/sites/default/files/', $node[$filefield]['und']['0']['uri']);
		// 			import_log('Fetchmedia for master on  ' . $wp_id  . print_r($node[$filefield]['und']['0'],true) );
		// 			$fileid = kb_fetch_media($file_path,$wp_id,'/node/' . $nid . '/master/');
		//
		// 			if($fileid) {
		//
		// 				update_field(acf_key('master'),$fileid,$wp_id);
		// 				import_log('File ' . $fileid . ' attached to master' );
		//
		// 			}
		// 			unset($node[$filefield]);
		//
		// 		}
		//
		// 		//image
		// 		$filefield = 'field_image';
		// 		if(isset($node[$filefield]['und'][0]['uri']) && !get_field('images', $wp_id)) {
		//
		// 			import_log("Doing field_image");
		//
		// 			$key = acf_key('images');
		// 			$subkey_array = acf_key('images','image'); //returns both parent and subkey as an array
		// 			$subkey = array_pop($subkey_array);	//grab the subkey
		//
		// 			update_field($key,array(),$wp_id); //clear the image field
		//
		// 			foreach($node[$filefield]['und'] as $index => $image) {
		//
		// 				$file_path = str_replace('public://','/webs/hbda/sites/default/files/', $image['uri']);
		// 				import_log("Fetchmedia for images on " . $wp_id  . print_r($node[$filefield]['und']['0'],true) );
		// 				$fileid = kb_fetch_media($file_path,$wp_id,'/node/' . $nid . '/images/');
		//
		// 				if($fileid) {
		// 					add_row($key,array($subkey => $fileid),$wp_id);
		// 					import_log('File ' . $fileid . ' attached to image' );
		// 				}
		//
		// 			}
		//
		// 			unset($node[$filefield]);
		//
		// 		}
		//
		//
		// 		//auto mapping - wp field name must be exactly the same as the Drupal field name, minus field_
		// 		//drupal = field_foo
		// 		//wp = foo
		//
		// 		foreach($fields as $field) {
		//
		// 			//simple text fields
		//
		// 			if(in_array($field['type'], array('text','radio','wysiwyg','true_false','select')) && !empty($node['field_' . $field['name']]['und'][0]['value'])) {
		// 				//do not overwrite
		// 				if(!empty(get_field($field['name'], $wp_id))) continue;
		// 				import_log("Doing text field " . 'field_' . $field['name'] );
		//
		// 				update_field($field['key'], $node['field_' . $field['name']]['und'][0]['value'], $wp_id);
		// 				import_log("Added value " .  $node['field_' . $field['name']]['und'][0]['value'] . ' to ' . $field['name'] . ' (' . $field['key'] . ')' );
		// 				unset($node['field_' . $field['name']]);
		// 			}
		//
		//
		// 			//relationship fields
		//
		// 			if(in_array($field['type'], array('relationship')) && isset($node['field_' . $field['name']]['und'][0])) {
		// 				$d_field_name = 'field_' . $field['name'];
		// 				$newvalue = array();
		//
		//
		// 				switch($d_field_name) {
		//
		// 					case 'field_related_records': //nodes
		//
		// 						foreach($node[$d_field_name]['und'] as $dval) {
		// 							$target_nid = $dval['target_id'];
		// 							$target_wp_id = nid_to_wpid($target_nid);
		// 							if(empty($target_wp_id)){
		// 								import_log("Could not find matching target wpid for drupal nid $target_nid");
		// 								continue;
		// 							}
		// 							$newvalue[] = $target_wp_id;
		// 						}
		//
		// 					break;
		//
		// 					default: //terms
		//
		// 						foreach($node[$d_field_name]['und'] as $dval) {
		// 							$target_tid = $dval['target_id'];
		// 							$newvalue[] = $target_tid;
		// 						}
		//
		// 					break;
		//
		// 				}
		// 				if(empty($newvalue)) continue;
		//
		// 				$current_value = get_field($field['key'], $wp_id, false);
		//
		// 				if(json_encode($current_value) != json_encode($newvalue)){
		// 					//echo $d_field_name . ' on ' . $wp_id . "\n";
		// 					//echo "current: " . print_r($current_value,true) . "\n";
		// 					//echo "new: " . print_r($newvalue,true) . "\n";
		// 					if(!empty($current_value)) {
		// 						$merge = array_merge($current_value, $newvalue);
		// 						$merge = array_unique($merge);
		// 						$newvalue = $merge;
		// 						//echo "merged: " . print_r($newvalue,true) . "\n";
		// 					}
		// 				}
		//
		// 				//update_field($field['key'], $newvalue, $wp_id);
		// 				import_log("Added value " . print_r($newvalue,true) . ' to ' . $field['name'] . ' (' . $field['key'] . ')' );
		//
		// 				unset($node[$d_field_name]);
		// 			}
		//
		// 		}//foreach field
		//
		// 		//Name fields
		//
		// 		$namefields = array('name','parents','partner','children', 'author','people');
		//
		// 		foreach($namefields as $nf) {
		//
		// 			if(isset($node['field_' . $nf]['und'][0]) && empty(get_field(acf_key($nf), $wp_id))) {
		//
		// 				$people = array();
		//
		// 				foreach($node['field_' . $nf]['und'] as $person) {
		//
		// 					$name = array();
		//
		// 					if(!empty($person['title'])){
		// 						$name['field_5cb6d6abb619d'] = $person['title'];
		// 					}
		//
		// 					$acf_key_first_name = acf_key($nf,'first_name');
		// 					$acf_key_first_name = array_pop($acf_key_first_name);
		// 					$name[$acf_key_first_name] = $person['given'];
		//
		// 					$acf_key_middle = acf_key($nf,'middle_names');
		// 					$acf_key_middle = array_pop($acf_key_middle);
		// 					$name[$acf_key_middle] = $person['middle'];
		//
		// 					$acf_key_family = acf_key($nf,'family_name');
		// 					$acf_key_family = array_pop($acf_key_family);
		// 					$name[$acf_key_family] = $person['family'];
		//
		// 					$people[] = $name;
		// 					if(!empty($person['title'])) update_field(acf_key($nf),$people,$wp_id);
		// 				}
		//
		// //				update_field(acf_key($nf),$people,$wp_id);
		//
		// 				import_log("Added people " . print_r($people,true) . " to field $nf (" . acf_key($nf) . ")");
		// 				unset($node['field_' . $nf]);
		// 			}
		//
		// 		}
		//
		// 		if($mode == 'bibliography' && !empty($node['body']['und'][0]['value'])){
		// 			update_field('field_5c3ba56895ab0', $node['body']['und'][0]['value'], $wp_id);
		// 			echo 'added description to ' . $wp_id . "\n";
		// 		}

				//see what's left in the node that we didn't get and unset()
				//import_log("Left in node:");
				//print_r($node);
				import_log("");

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
