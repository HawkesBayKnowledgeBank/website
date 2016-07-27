<pre>
<?php

require_once('../wp-load.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

	
	$modes = array(
		'collections' => 35640,//$mode => $fgid
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

				//have to get content from another script, can't bootstrap both WP and Drupal in this one
				//json is as good as anything for the job
				$json = file_get_contents('http://new.knowledgebank.org.nz/import/drupalout.php?mode=' . $mode); 
				
				$nodes = json_decode($json,true);//true = return as A_ARRAY

				$templatepath = '/webs/new/import/node.php';

				if(!empty($nodes) && file_exists($templatepath)) {

					$count = 0;

					$limit = 0;
			
					foreach($nodes as $node) :

						//check if this already exists
						$checkpost = get_post($node['nid']);					

						if(!empty($checkpost) && $checkpost != null) { //already exists, move on without importing
							echo $node['nid'] . " already exists, moving on\n";
							continue;
						}

						//else... do the import with the template

						/********************************************/

						include($templatepath);

						/*********************************************/		


						$count+=1;	

						if($limit > 0 && $count == $limit) break;

					endforeach;


				}
				else {

					echo "$nodes is empty or no template found\n";
					exit;

				}

				echo "Did $count nodes";


			break;

			case 'collections': //does both collections and series from drupal

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

				echo count($d_collections) . " collections in Drupal\n";
/*
				$wp_collections_unsorted = get_terms('collections',array('hide_empty' => false));

				$wp_collections = array();

				foreach($wp_collections_unsorted as $term) {
					$wp_collections[$term->term_id] = $term;
				}
*/

				foreach($d_collections as $t) {

					$tid = $t['tid'];

					//if(get_term($tid,'collections')) {
					//	echo 'Term ' . $tid . " already exists, moving on\n";
					//	continue;
					//}

					//else get on with inserting the term

					$wpdb->query('INSERT INTO `wp_terms` values ('  . $t["tid"] . ',"' . $t["name"] . '","' . $t["tid"] . '",0) ON DUPLICATE KEY UPDATE term_id = ' . $t["tid"] . ', name = "' . $t['name'] . '", slug = "' . $t['tid'] . '"');	
					
					$parent = 0;

					if(isset($t['field_collections']['und'][0]['tid'])){
						$parent = $t['field_collections']['und'][0]['tid'];		
					}

					$wpdb->query('INSERT INTO `wp_term_taxonomy` (term_id, taxonomy, parent) VALUES ("' . $t["tid"] . '", "' . $t["name"] . '", "' . $parent . '") ON DUPLICATE KEY UPDATE term_id = ' . $t['tid'] . ', taxonomy = "' . $t["name"] . '", parent = ' . $parent);
				

					echo 'Inserted term ' . $t["tid"] . ' (' . $t['name'] . ')' . "\n";

					$filefield = 'field_donor_form';
					if(isset($t[$filefield]['und']['0']['uri']) && !get_field('donor_form','collections_' . $tid)) {
						$file_url = str_replace('public://','/webs/hbda/sites/default/files/', $t[$filefield]['und']['0']['uri']);

						$fileid = kb_fetch_media($file_url,$tid,'/collections/'.$tid.'/');

						if($fileid) {

							update_field('field_56b452c658411',$fileid,'collections_' . $tid);
							echo 'File ' . $fileid . ' attached to ' . $tid . "\n";

						}
						
					}


					foreach($fields as $field) {

						//simple text fields

						if(in_array($field['type'], array('text','radio','wysiwyg','true_false','select')) && isset($t['field_' . $field['name']]['und'][0]['value'])) {

							echo "Doing field " . 'field_' . $field['name'] . "\n";

							update_field($field['key'], $t['field_' . $field['name']]['und'][0]['value'], 'collections_' . $tid);
							echo "Added value " .  $t['field_' . $field['name']]['und'][0]['value'] . ' to ' . $field['name'] . ' (' . $field['key'] . ')' . "\n";
							unset($t['field_' . $field['name']]);
						}
						elseif( isset($t['field_' . $field['name']]) ){
							unset($t['field_' . $field['name']]);
						}


					}


					echo 'Updated term ' . $tid . ' (' . $t['name'] . ')' . "\n";

					echo 'Left in d_term: ' . print_r($t,true) . "\n";	

				}			

			break;

			case 'tags':
			case 'subjects':
		
				$json = file_get_contents('http://new.knowledgebank.org.nz/import/drupalout.php?mode=' . $mode);

				$terms = json_decode($json,true);

				foreach($terms as $t) {

					$tid = $t['tid'];

					if(get_term($tid,$mode)) {
						echo 'Term ' . $tid . " already exists, moving on\n";
						continue;
					}

					//else get on with inserting the term

					$wpdb->query('INSERT INTO `wp_terms` values ('  . $t["tid"] . ',"' . $t["name"] . '","' . $t["tid"] . '",0)');	
					
					$parent = 0;

					$wpdb->query('INSERT INTO `wp_term_taxonomy` (term_id, taxonomy, parent) VALUES ("' . $t["tid"] . '", "' . $mode . '", "' . $parent . '")');
				
					echo 'Inserted term ' . $t["tid"] . ' (' . $t['name'] . ')' . "\n";
					
				}						

			break;		

			


		

		}//switch


	endforeach;


function kb_fetch_media($file_url, $nid, $dir) {
	require_once(ABSPATH . 'wp-load.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	global $wpdb;


	//directory to import to	
	$uploads = wp_upload_dir();
	$save_path = $uploads['basedir'].$dir;

	//if the directory doesn't exist, create it	
	if(!file_exists($save_path)) {
		echo 'Making directory ' . $save_path . "\n";
		mkdir($save_path,0775,true);
		echo 'Made directory ' . $save_path . "\n";
	}

	//rename the file... alternatively, you could explode on "/" and keep the original file name
	$fileparts = explode("/", $file_url);
	$new_filename = $nid . '_' . array_pop($fileparts);
	//$new_filename = 'blogmedia-'.$post_id.".".$ext; //if your post has multiple files, you may need to add a random number to the file name to prevent overwrites

	echo 'Attempting to open file for copying ' . $file_url . "\n";
	if (file_exists($file_url) && fclose(fopen($file_url, "r"))) { //make sure the file actually exists

		echo 'Copying ' . $file_url . " to " . $save_path.$new_filename ."\n";
		copy($file_url, $save_path.$new_filename);

		//echo (file_exists($save_path.$new_filename) ? $save_path.$new_filename . 'exists' : $save_path.$new_filename . 'does not exist :(');

		$siteurl = get_option('siteurl');
		echo "getimagesize()\n";
		$file_info = getimagesize($save_path.$new_filename);

		//create an array of attachment data to insert into wp_posts table
		$artdata = array();
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
		echo "attaching to WP\n" . print_r($artdata,true) . "\n";
		try{


			$defaults = array(
	                'file'        => $save_path.$new_filename,
	                'post_parent' => 0
	        );


	        $data = wp_parse_args( $artdata, $defaults );
	
	        if ( ! empty( $parent ) ) {
	                $data['post_parent'] = $parent;
	        }
	
	        $data['post_type'] = 'attachment';
	

			echo 'inserting attachment post' . "\n";
	        $attach_id = wp_insert_post( $data, true );
	       

			//$attach_id = wp_insert_attachment( $artdata, $save_path.$new_filename, 0 ); //can swap 0 for $post_id to be parent
		}
		catch(Exception $e) {
			echo 'no deal'; exit;
		}

		//generate metadata and thumbnails
		echo 'making image metadata' . "\n";
		if ($attach_data = wp_generate_attachment_metadata( $attach_id, $save_path . $new_filename)) {

			if(is_wp_error($attach_data)) {

				echo $attach_data->get_error_message();

			}
			else {

				echo "adding image metadata\n";
				wp_update_attachment_metadata($attach_id, $attach_data);

			}
			
		}

		return $attach_id;

		//optional make it the featured image of the post it's attached to
		//$rows_affected = $wpdb->insert($wpdb->prefix.'postmeta', array('post_id' => $post_id, 'meta_key' => '_thumbnail_id', 'meta_value' => $attach_id));
	}
	else {
		return false;
	}

	return true;
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
		
		echo 'Inserted term ' . $t["tid"] . ' (' . $t['name'] . ')' . "\n";

		$filefield = 'field_donor_form';
		if(isset($t[$filefield]['und']['0']['uri'])) {
			$file_url = str_replace('public://','/webs/hbda/sites/default/files/', $t[$filefield]['und']['0']['uri']);

			$fileid = kb_fetch_media($file_url,$tid,'/collections/'.$tid.'/');

			if($fileid) {

				update_field('field_56b452c658411',$fileid,'collections_' . $tid);
				echo 'File ' . $fileid . ' attached to ' . $tid . "\n";

			}
			
		}


		echo 'Updated term ' . $tid . ' (' . $t['name'] . ')' . "\n";


	}

}







?>
</pre>