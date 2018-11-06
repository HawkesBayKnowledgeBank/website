<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	require_once('wp-load.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	require_once(ABSPATH . 'wp-admin/includes/image-edit.php');
	require_once(ABSPATH . 'wp-admin/includes/media.php');

	echo phpinfo();
//	print_r(wp_generate_attachment_metadata( 269326, '/webs/new/wp-content/uploads/node/42741/images/1508519897_HardingR741_Weeklymercuryjune301877-13_0.jpg' ));

	print_r(wp_get_attachment_metadata(269326));






?>
