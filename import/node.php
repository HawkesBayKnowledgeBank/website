<?php
		/* //Person */

		global $fields; 

		global $node;

		global $mode;

		$nid = $node['nid'];

		echo "\n\n";
		echo "********************************************************************\n";
		echo "********************************************************************\n";
		echo "Doing node $nid \n";
		echo "********************************************************************\n";
		echo "********************************************************************\n";



/***********************/
//		print_r($node);
//		exit;
/***********************/


		//Post
		$status = ($node['status'] == 1 ? 'publish' : 'draft');

		$new_post = array(
		    'post_title' => $node['title'],
		    'post_date' => date('Y-m-d H:i:s',$node['created']),
		    'post_modified' => date('Y-m-d H:i:s',$node['changed']),
		    'post_content' => (isset($node['body']['und'][0]['value']) ? $node['body']['und'][0]['value'] : ''),
		    'post_status' => $status,
		    'post_type' => $mode,
		    'import_id' => $node['nid'], //preserve Drupal nid
		    'post_author' => $node['uid']
		);
		$new_post_id = wp_insert_post( $new_post );		

		echo 'Inserted ' . $new_post_id . "\n";
	
		unset($node['body']); //I will unset things from my temporary $node array as I go, so I can see at the end what's left / not processed

		//Collections
		if(isset($node['field_collections']['und'][0]['tid'])){
			echo "Doing collections\n";
			$cid = $node['field_collections']['und'][0]['tid'];

			//see if the collection exists already
			$collection = get_term($cid,'collections');

			if(empty($collection)) {
				kb_add_term($cid,'collections');
			}


			wp_set_object_terms( $new_post_id, $cid, 'collections' );
			echo 'Set collection ' . $cid . "\n";

			unset($node['field_collections']);
		}

		//Series
		if(isset($node['field_series']['und'][0]['tid'])){
			echo "Doing series\n";
			$cid = $node['field_series']['und'][0]['tid'];

			//see if the collection exists already
			$series = get_term($cid,'collections');

			if(empty($series)) {
				kb_add_term($cid,'collections');
			}

			wp_set_object_terms( $new_post_id, $cid, 'collections', true );
			echo 'Set series ' . $cid . "\n";
			unset($node['field_series']);
		}



		//subjects
		if(isset($node['field_subjects']['und'][0]['tid'])){
			echo "Doing subjects\n";

			$terms = array();

			foreach($node['field_subjects']['und'] as $term) {

				$wp_term = get_term( $term['tid'] ,'subjects');

				if(empty($wp_term)) {
					kb_add_term( $term['tid'] ,'subjects');
				}

				$terms[] = $term['tid'];
			}
			
			wp_set_post_terms( $nid, $terms, 'subject' );
			echo 'Set terms ' . print_r($terms,true) . " on subjects\n";
			unset($node['field_subjects']);
		}

		//tags
		if(isset($node['field_tags']['und'][0]['tid'])){
			echo "Doing tags\n";

			$terms = array();

			foreach($node['field_tags']['und'] as $term) {

				$wp_term = get_term( $term['tid'] ,'subjects');

				if(empty($wp_term)) {
					kb_add_term( $term['tid'] ,'subjects');
				}

				$terms[] = $term['tid'];
			}
			
			wp_set_post_terms( $nid, $terms, 'post_tag' );
			echo 'Set terms ' . print_r($terms,true) . " on tags\n";
			unset($node['field_tags']);
		}

		//master
		$filefield = 'field_master';
		if(isset($node[$filefield]['und']['0']['uri'])) {
			echo "Doing field_master\n";
			$file_url = str_replace('public://','/webs/hbda/sites/default/files/', $node[$filefield]['und']['0']['uri']);
			echo 'Fetchmedia for ' . $nid . "\n" . print_r($node[$filefield]['und']['0'],true) . "\n";
			$fileid = kb_fetch_media($file_url,$nid,'/node/' . $nid . '/master/');

			if($fileid) {

				update_field(acf_key('master'),$fileid,$nid);
				echo 'File ' . $fileid . ' attached to master' . "\n";

			}
			unset($node[$filefield]);
			
		}			

		//image
		$filefield = 'field_image';
		if(isset($node[$filefield]['und'][0]['uri'])) {

			echo "Doing field_image\n";

			$key = acf_key('images');
			$subkey_array = acf_key('images','image'); //returns both parent and subkey as an array
			$subkey = array_pop($subkey_array);	//grab the subkey				
			
			update_field($key,array(),$nid); //clear the image field

			foreach($node[$filefield]['und'] as $index => $image) {

				$file_url = str_replace('public://','/webs/hbda/sites/default/files/', $image['uri']);
				echo "Fetchmedia for " . $nid . "\n" . print_r($node[$filefield]['und']['0'],true) . "\n";
				$fileid = kb_fetch_media($file_url,$nid,'/node/' . $nid . '/images/');

				if($fileid) {					

					add_row($key,array($subkey => $fileid),$nid);					
					
					echo 'File ' . $fileid . ' attached to image' . "\n";

				}

			}

			unset($node[$filefield]);
			
		}

		

		//auto mapping - wp field name must be exactly the same as the Drupal field name, minus field_
		//drupal = field_foo
		//wp = foo


		foreach($fields as $field) {

			//simple text fields

			if(in_array($field['type'], array('text','radio','wysiwyg','true_false','select')) && isset($node['field_' . $field['name']]['und'][0]['value'])) {

				echo "Doing field " . 'field_' . $field['name'] . "\n";

				update_field($field['key'], $node['field_' . $field['name']]['und'][0]['value'], $nid);
				echo "Added value " .  $node['field_' . $field['name']]['und'][0]['value'] . ' to ' . $field['name'] . ' (' . $field['key'] . ')' . "\n";
				unset($node['field_' . $field['name']]);
			}
			elseif( isset($node['field_' . $field['name']]) ){
				unset($node['field_' . $field['name']]);
			}



			//relationship fields

			if(in_array($field['type'], array('relationship')) && isset($node['field_' . $field['name']]['und'][0])) {

				$newvalue = array();

				foreach($node['field_' . $field['name']]['und'] as $dval) {
					$newvalue[] = $dval['target_id'];
				}

				update_field($field['key'], $newvalue, $nid);
				echo "Added value " . print_r($newvalue,true) . ' to ' . $field['name'] . ' (' . $field['key'] . ')' . "\n";

				unset($node['field_' . $field['name']]);
			}


		}



		//Name fields

		$namefields = array('name','parents','partner','children', 'author','people');

		foreach($namefields as $nf) {


			if(isset($node['field_' . $nf]['und'][0])) {

				$people = array();

				foreach($node['field_' . $nf]['und'] as $person) {

					$people[] = array(
						array_pop(acf_key($nf,'first_name')) => $person['given'],
						array_pop(acf_key($nf,'middle_names')) => $person['middle'],
						array_pop(acf_key($nf,'family_name')) => $person['family'],
					);

				}

				update_field(acf_key($nf),$people,$nid);
				echo "Added people " . print_r($people,true) . " to field $nf (" . acf_key($nf) . ")\n";
				unset($node['field_' . $nf]);
			}

		}

		//see what's left in the node that we didn't get and unset()
		echo "\nLeft in node:\n";
		print_r($node);
		echo "\n\n";



?>