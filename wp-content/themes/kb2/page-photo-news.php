<?php get_header(); ?>

<?php $args = array(
		'post_type' => 'text',
		'posts_per_page' => 40,
		'post_status' => array('publish', 'draft'),
		'tax_query' => array(
			array(
				'taxonomy' => 'collections',
				'field'    => 'term_id',
				'terms'    => array( 967, 968 ),
			),
		),
	);

	$photo_news = get_posts($args); ?>
	<?php foreach($photo_news as $photo) : ?>
		<?php $images = get_field('images', $photo->ID); echo $photo->ID; print_r($images); ?>
	<?php endforeach; ?>



<?php get_footer(); ?>