<?php
		/* //Person */

		global $fields;

		global $node;

		global $mode;

		$nid = $node['nid'];

		import_log("");
		import_log("********************************************************************");
		import_log("********************************************************************");
		import_log("Doing node $nid / wp_id $wp_id ");
		import_log("********************************************************************");
		import_log("********************************************************************");



/***********************/
//		print_r($node);
//		exit;
/***********************/


		unset($node['body']); //I will unset things from my temporary $node array as I go, so I can see at the end what's left / not processed

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
//
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
//
// 				$newvalue = array();
//
// 				foreach($node['field_' . $field['name']]['und'] as $dval) {
// 					$newvalue[] = $dval['target_id'];
// 				}
//
// 				update_field($field['key'], $newvalue, $wp_id);
// 				import_log("Added value " . print_r($newvalue,true) . ' to ' . $field['name'] . ' (' . $field['key'] . ')' );
//
// 				unset($node['field_' . $field['name']]);
// 			}
//
// 		}//foreach field

		//Name fields

		$namefields = array('name','parents','partner','children', 'author','people');

		foreach($namefields as $nf) {

			if(isset($node['field_' . $nf]['und'][0])) {

				$people = array();

				foreach($node['field_' . $nf]['und'] as $person) {

					$name = array();

					if(!empty($person['title'])){
						$name['field_5cb6d6abb619d'] = $person['title'];
					}

					$acf_key_first_name = acf_key($nf,'first_name');
					$acf_key_first_name = array_pop($acf_key_first_name);
					$name[$acf_key_first_name] = $person['given'];

					$acf_key_middle = acf_key($nf,'middle_names');
					$acf_key_middle = array_pop($acf_key_middle);
					$name[$acf_key_middle] = $person['middle'];

					$acf_key_family = acf_key($nf,'family_name');
					$acf_key_family = array_pop($acf_key_family);
					$name[$acf_key_family] = $person['family'];

					$people[] = $name;
					if(!empty($person['title'])) update_field(acf_key($nf),$people,$wp_id);
				}

//				update_field(acf_key($nf),$people,$wp_id);

				import_log("Added people " . print_r($people,true) . " to field $nf (" . acf_key($nf) . ")");
				unset($node['field_' . $nf]);
			}

		}

		//see what's left in the node that we didn't get and unset()
		import_log("Left in node:");
		//print_r($node);
		import_log("");

?>
