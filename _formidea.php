<?php

require_once('wp-load.php');

acf_form_head();

print_r($_POST);

$settings = array(
    'id' => 'acf-form',
    'post_id' => 'x',
    'fields' => array('field_580469541b7f9'),
	'html_before_fields' => '</form></div><div class="acf-fields acf-form-fields -top"><form name="test" action="" method="GET">',
	'html_after_fields' => '',
);

acf_form($settings);
