<?php
		/* //Person */




		global $fields; 



		global $node;


		unset($node['rdf_mapping']);
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
		    'post_type' => 'still_image',
		    'import_id' => $nid,
		    'post_author' => $node['uid']
		);
		$new_post_id = wp_insert_post( $new_post );		

		echo 'Inserted ' . $new_post_id . "\n";
	
		unset($node['body']);

		//Collections
		if(isset($node['field_collections']['und'][0]['tid'])){
			echo "Doing collections\n";
			$cid = $node['field_collections']['und'][0]['tid'];		
			wp_set_object_terms( $new_post_id, $cid, 'collections' );
			echo 'Set collection ' . $cid . "\n";

			unset($node['field_collections']);
		}

		//Series
		if(isset($node['field_series']['und'][0]['tid'])){
			echo "Doing series\n";
			$cid = $node['field_series']['und'][0]['tid'];		
			wp_set_object_terms( $new_post_id, $cid, 'collections', true );
			echo 'Set series ' . $cid . "\n";
			unset($node['field_series']);
		}



		//subjects
		if(isset($node['field_subjects']['und'][0]['tid'])){
			echo "Doing subjects\n";

			$terms = array();

			foreach($node['field_subjects']['und'] as $term) {
				$terms[] = $term['tid'];
			}
			
			wp_set_post_terms( $new_post_id, $terms, 'subject' );
			echo 'Set terms ' . print_r($terms,true) . " on subjects\n";
			unset($node['field_subjects']);
		}

		//tags
		if(isset($node['field_tags']['und'][0]['tid'])){
			echo "Doing tags\n";

			$terms = array();

			foreach($node['field_tags']['und'] as $term) {
				$terms[] = $term['tid'];
			}
			
			wp_set_post_terms( $new_post_id, $terms, 'post_tag' );
			echo 'Set terms ' . print_r($terms,true) . " on tags\n";
			unset($node['field_tags']);
		}

		//master
		$filefield = 'field_master';
		if(isset($node[$filefield]['und']['0']['uri'])) {
			echo "Doing field_master\n";
			$file_url = str_replace('public://','/webs/hbda/sites/default/files/', $node[$filefield]['und']['0']['uri']);
			echo 'Fetchmedia for ' . $new_post_id . "\n" . print_r($node[$filefield]['und']['0'],true) . "\n";
			$fileid = kb_fetch_media($file_url,$new_post_id,'/node/' . $new_post_id . '/master/');

			if($fileid) {

				update_field(acf_key('master'),$fileid,$new_post_id);
				echo 'File ' . $fileid . ' attached to master' . "\n";

			}
			unset($node[$filefield]);
			
		}			

		//image
		$filefield = 'field_image';
		if(isset($node[$filefield]['und'][0]['uri'])) {

			echo "Doing field_image\n";

			foreach($node[$filefield]['und'] as $index => $image) {

				$file_url = str_replace('public://','/webs/hbda/sites/default/files/', $image['uri']);
				echo "Fetchmedia for " . $new_post_id . "\n" . print_r($node[$filefield]['und']['0'],true) . "\n";
				$fileid = kb_fetch_media($file_url,$new_post_id,'/node/' . $new_post_id . '/images/');

				if($fileid) {
					
					$key = acf_key('images');
					$subkey = array_pop(acf_key('images','image'));					
					
					update_field($key,array(),$new_post_id);

					add_row($key,array($subkey => $fileid),$new_post_id);					
					
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

				update_field($field['key'], $node['field_' . $field['name']]['und'][0]['value'], $new_post_id);
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

				update_field($field['key'], $newvalue, $new_post_id);
				echo "Added value " . print_r($newvalue,true) . ' to ' . $field['name'] . ' (' . $field['key'] . ')' . "\n";

				unset($node['field_' . $field['name']]);
			}


		}


		//special case - body -> notes field
		$notes = (isset($node['body']['und'][0]['value']) ? $node['body']['und'][0]['value'] : '');
		if(!empty($notes)) {
			update_field('field_56d3eb00413be', $notes, $new_post_id);
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

				update_field(acf_key($nf),$people,$new_post_id);
				echo "Added people " . print_r($people,true) . " to field $nf (" . acf_key($nf) . ")\n";
				unset($node['field_' . $nf]);
			}

		}

		echo "\nLeft in node:\n";
		print_r($node);
		echo "\n\n";



?>