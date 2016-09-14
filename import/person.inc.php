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

	
		//print_r($node);

/***********************/
		//exit;
/***********************/


		//Post
		$status = ($node['status'] == 1 ? 'publish' : 'draft');

		$new_post = array(
		    'post_title' => $node['title'],
		    'post_date' => date('Y-m-d H:i:s',$node['created']),
		    'post_modified' => date('Y-m-d H:i:s',$node['changed']),
		    'post_content' => '',
		    'post_status' => $status,
		    'post_type' => 'person',
		    'import_id' => $node['nid'],
		    'post_author' => $node['uid']
		);
		$new_post_id = wp_insert_post( $new_post );		

		echo 'Inserted ' . $new_post_id . "\n";
	

		//Collections
		if(isset($node['field_collections']['und'][0]['tid'])){
			$cid = $node['field_collections']['und'][0]['tid'];		
			wp_set_post_terms( $new_post_id, $cid, 'collections' );
		}

		//master
		$filefield = 'field_master';
		if(isset($node[$filefield]['und']['0']['uri'])) {
			$file_url = str_replace('public://','/webs/hbda/sites/default/files/', $node[$filefield]['und']['0']['uri']);

			$fileid = kb_fetch_media($file_url,$new_post_id,'/node/' . $new_post_id . '/master/');

			if($fileid) {

				update_field(acf_key('master'),$fileid,$new_post_id);
				echo 'File ' . $fileid . ' attached to ' . $new_post_id . "\n";

			}
			
		}			

		//image
		$filefield = 'field_image';
		if(isset($node[$filefield]['und'][0]['uri'])) {

			foreach($node[$filefield]['und'] as $index => $image) {

				$file_url = str_replace('public://','/webs/hbda/sites/default/files/', $node[$filefield]['und']['0']['uri']);

				$fileid = kb_fetch_media($file_url,$new_post_id,'/node/' . $new_post_id . '/images/');

				if($fileid) {
					
					$key = acf_key('images');
					$subkey = array_pop(acf_key('images','image'));					
					
					update_field($key,array(),$new_post_id);

					add_row($key,array($subkey => $fileid),$new_post_id);					
					
					echo 'File ' . $fileid . ' attached to ' . $new_post_id . "\n";

				}

			}
			
		}

		

		//auto mapping - wp field name must be exactly the same as the Drupal field name, minus field_
		//drupal = field_foo
		//wp = foo


		foreach($fields as $field) {

			//simple text fields

			if(in_array($field['type'], array('text','radio','wysiwyg')) && isset($node['field_' . $field['name']]['und'][0]['value'])) {

				update_field($field['key'], $node['field_' . $field['name']]['und'][0]['value'], $new_post_id);
				echo "Added " . $field['name'] . "\n";

			}

			//relationship fields

			if(in_array($field['type'], array('relationship')) && isset($node['field_' . $field['name']]['und'][0])) {

				$newvalue = array();

				foreach($node['field_' . $field['name']]['und'] as $dval) {
					$newvalue[] = $dval['target_id'];
				}

				update_field($field['key'], $newvalue, $new_post_id);
				echo "Added " . print_r($newvalue,true) . ' to ' . $field['name'] . "\n";

			}


		}






		//Name fields

		$namefields = array('name','parents','partner','children');

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
				echo "Added people " . print_r($people,true) . " to field $nf\n";

			}

		}





?>