<?php
		/* //Videos */

		global $node;


		unset($node['rdf_mapping']);
		$nid = $node['nid'];
		echo "Doing node $nid \n";

	
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
		    'post_type' => 'video',
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

				update_field('field_56b1b000cc95a',$fileid,$new_post_id);
				echo 'File ' . $fileid . ' attached to ' . $new_post_id . "\n";

			}
			
		}			
/*
		//image
		$filefield = 'field_image';
		if(isset($node[$filefield]['und'][0]['uri'])) {

			foreach($node[$filefield]['und'] as $index => $image) {

				$file_url = str_replace('public://','/webs/hbda/sites/default/files/', $node[$filefield]['und']['0']['uri']);

				$fileid = kb_fetch_media($file_url,$new_post_id,'/node/' . $new_post_id . '/images/');

				if($fileid) {

					update_field('field_56b1b2da7d393',$fileid,$new_post_id);
					echo 'File ' . $fileid . ' attached to ' . $new_post_id . "\n";

				}

			}
			
		}

		//simple text fields

		//drupal_name => field_key
		$fieldmap = array(
			'field_accession_number' => 'field_56b1b27b3ae75',
			'field_business' => 'field_56b1b1f23ae6b',			
			'field_youtube_id' => 'field_56b1b02fcc95b',
			'field_format_original' => 'field_56b1b2103ae6d',
			'field_additional' => 'field_56b1b2413ae73',
			'field_languages' => 'field_56b1b2613ae74',

		);


		foreach($fieldmap as $name => $key) {

			if(isset($node[$name]['und'][0]['value'])){

				update_field($key, $node[$name]['und'][0]['value'], $new_post_id);
				echo "Added $name \n";

			}

		}

		//subjects
		if(isset($node['field_subjects']['und'][0]['tid'])){

			$terms = array();

			foreach($node['field_subjects']['und'] as $term) {
				$terms[] = $term['tid'];
			}
			
			wp_set_post_terms( $new_post_id, $terms, 'subject' );
			echo 'Set terms ' . print_r($terms,true) . "\n";
		}

		//tags
		if(isset($node['field_tags']['und'][0]['tid'])){

			$terms = array();

			foreach($node['field_tags']['und'] as $term) {
				$terms[] = $term['tid'];
			}
			
			wp_set_post_terms( $new_post_id, $terms, 'post_tag' );
			echo 'Set terms ' . print_r($terms,true) . "\n";
		}

		//Author

		if(isset($node['field_author']['und'][0])) {

			$authors = array();

			foreach($node['field_author']['und'] as $author) {

				$authors[] = array(
					'field_56b1b2323ae70' => $author['given'],
					'field_56b1b2323ae71' => $author['middle'],
					'field_56b1b2323ae72' => $author['family'],
				);

			}

			update_field('field_56b1b2323ae6f',$authors,$new_post_id);
			echo "Added authors " . print_r($authors,true) . "\n";

		}

		//People
		if(isset($node['field_people']['und'][0])) {

			$people = array();

			foreach($node['field_people']['und'] as $person) {

				$people[] = array(
					'field_56b1b128b7b71' => $person['given'],
					'field_56b1b157b7b72' => $person['middle'],
					'field_56b1b168b7b73' => $person['family'],
				);

			}

			update_field('field_56b1b119b7b70',$people,$new_post_id);
			echo "Added people " . print_r($people,true) . "\n";

		}

		if(isset($node['field_youtube_id']['und'][0])) {

			$file_url = 'http://img.youtube.com/vi/' . $node['field_youtube_id']['und'][0]['value'] . '/0.jpg';

			echo '<img src="' . $file_url . '"/>';

			$fileid = kb_fetch_media($file_url,$new_post_id,'/node/' . $new_post_id . '/images/');

			if($fileid) {

				update_field('field_56b1b2da7d393',$fileid,$new_post_id);
				echo 'File ' . $fileid . ' attached to ' . $new_post_id . "\n";

			}		
			
		}
*/
?>