<?php get_header(); ?>
	<div class="pageTitles">
		<h1><?php the_title(); ?></h1>
	</div>
	<?php $args = array(
		'post_type' => 'still_image',
		'tax_query' => array(
			array(
				'taxonomy' => 'subject',
				'field'    => 'term_id',
				'terms'    => array( 765 ),
			),
		),
	);

	$maps = new WP_Query($args); ?>

	<div class="tiles tiles-3">
		<?php if ($maps->have_posts()): while ($maps->have_posts()) : $maps->the_post(); ?>
			<?php get_template_part('tile', $post->post_type); ?>		
		<?php endwhile; endif; ?>
	</div>

	<?php
	//this code uses get_posts() and but only returns 5 posts,
	//when it should return 9
	$args = array(
		'post_type' => 'still_image',
		'tax_query' => array(
			array(
				'taxonomy' => 'subject',
				'field'    => 'term_id',
				'terms'    => array( 765 ),
			),
		),
	);

	$maps = get_posts($args); ?>

	<!-- <div class="grid-container">
		<?php foreach($maps as $map) : ?>
			<div class="grid-4">
				<?php echo $map->post_title; ?>
			</div>
		<?php endforeach; ?>
	</div> -->

<?php get_footer(); ?>
