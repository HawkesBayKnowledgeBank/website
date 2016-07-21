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

	<div class="grid-container">
		<?php if ( $maps->have_posts() ) : while ( $maps->have_posts() ) : $maps->the_post(); ?>
			<div class="grid-4">
				<?php $image = get_field('images'); ?>
				<a href="<?php echo get_permalink(); ?>">
					<img src="<?php echo $image[0]['image']['sizes']['700w']; ?>">
				</a>
				<div class="inner">
					<h2><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h2>
					<span class="action_buttons">
						<a class='view_button' href="<?php echo get_permalink($post->ID); ?>">View</a>
						<span class="quick_view"><a class="lightbox_icon quick_view" href="<?php the_permalink(); ?>?quickview=true">Quick view</a></span>
					</span>
				</div>
			</div>
			<?php $blog_count = $maps->current_post+1; ?>
     		<?php if ( $blog_count % 3 == 0 && $blog_count != $maps->post_count) : ?>
        		</div><div class="grid-container group">
      		<?php endif; ?>
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
