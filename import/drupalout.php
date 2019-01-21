<?php


	//Get content out of Drupal as simple json

	//Bootstrap Drupal
	chdir('/webs/hbda');
	define('DRUPAL_ROOT', getcwd());
	require_once 'includes/bootstrap.inc';
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


	if(!isset($_GET['mode'])) {
		die('need a mode');
	}

	$mode = $_GET['mode'];

	switch($mode) {

		case 'tags':

			$v = taxonomy_vocabulary_machine_name_load('tags');

			$items = taxonomy_term_load_multiple(array(), array('vid' => $v->vid));

			echo json_encode($items);

		break;

		case 'subjects':

			$v = taxonomy_vocabulary_machine_name_load('subjects');

			$items = taxonomy_term_load_multiple(array(), array('vid' => $v->vid));

			echo json_encode($items);

		break;

		case 'still_image':
		case 'person':
		case 'text':
		case 'video':
		case 'audio':
		case 'book':


			$nodes = node_load_multiple(array(), array('type' => $mode));
			echo json_encode($nodes);


		break;

		case 'collections':

			if(isset($_GET['tid'])) {

				$tid = $_GET['tid'];

				$items = taxonomy_term_load_multiple(array($tid), array());

				echo json_encode(array_pop($items));
			}
			else {

				$v = taxonomy_vocabulary_machine_name_load('collections');

				$items = taxonomy_term_load_multiple(array(), array('vid' => $v->vid));

				echo json_encode($items);

			}

		break;

		case 'series':

			$v = taxonomy_vocabulary_machine_name_load('series');

			$items = taxonomy_term_load_multiple(array(), array('vid' => $v->vid));

			echo json_encode($items);

		break;

		case 'collection':
		case 'series_single':

			if(!isset($_GET['tid'])) die('need a tid with collection or series_single');

			$tid = $_GET['tid'];

			$items = taxonomy_term_load_multiple(array($tid), array());

			echo json_encode(array_pop($items));


		break;


	}




?>
