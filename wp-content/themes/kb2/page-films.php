<?php get_header(); ?>
<div class="pageTitles">
	<h1><?php the_title(); ?></h1>
</div>

<?php

	$args = array(
		'post_type' => 'video',
		'posts_per_page' => 5
	);

	$latest_posts = get_posts($args);

?>
<div class="tiles tiles-5">
<?php


			if( !empty( $latest_posts ) ) :

				 foreach( $latest_posts as $latest_post ) : ?>

				 	<div class="tile image-subjects-links">

				 		<a href='<?php echo get_permalink( $latest_post->ID ); ?>'>

				 			<?php echo $latest_post->post_title; ?>

				 		</a>

				 	</div>

				<?php endforeach;

			endif; ?>
</div>
	<?php $args = array(
		'post_type' => 'video',
		'posts_per_page' => -1
		/*'tax_query' => array(
			array(
				'taxonomy' => 'subject',
				'field'    => 'term_id',
				'terms'    => array( 765 ),
			),
		),*/
	);
	$videos = new WP_Query($args); ?>


	<div class="tiles tiles-4">
		<?php if ( $videos->have_posts() ) : ?>
			<?php while ( $videos->have_posts() ) :?>
				<?php $videos->the_post(); ?>
				<div class="tile">
					
						<div class="imageWrap">
							<?php $images = get_field('images'); ?>
							<a href="<?php echo get_permalink($post->ID); ?>">
							<?php if(isset($images[0]['image']['sizes']['700w'])): ?>

								<img src="<?php echo $images[0]['image']['sizes']['700w']; ?>" />


							<?php elseif(get_field('youtube_id',$post->ID)): ?>

								<?php $ytid = get_field( 'youtube_id' ); ?>
								<img src="http://img.youtube.com/vi/<?php echo $ytid; ?>/0.jpg" />


							<?php endif; ?>
						</a>
						</div>
						<div class="inner">
							<h2><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo kb_nicename($post->post_type); ?></p>
						</div>
					
				</div>

			<?php endwhile;?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>