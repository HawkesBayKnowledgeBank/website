<?php get_header(); ?>
<div class="pageTitles">
	<h1><?php the_title(); ?></h1>
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


	<div class="grid-container">
		<?php if ( $videos->have_posts() ) : ?>
			<?php while ( $videos->have_posts() ) :?>
				<?php $videos->the_post(); ?>
				<div class="grid-4">
					<div class="imageWrap">
						<?php $images = get_field('images'); ?>
						<?php if(isset($images[0]['image']['sizes']['700w'])): ?>

							<a href="<?php the_permalink(); ?>?quickview=true"><img src="<?php echo $images[0]['image']['sizes']['700w']; ?>" /></a>

							<span class="quick_view"><a class="lightbox_icon quick_view" href="<?php the_permalink(); ?>?quickview=true">View</a></span>

						<?php elseif(get_field('youtube_id',$post->ID)): ?>

							<?php $ytid = get_field( 'youtube_id' ); ?>
							<a href="<?php the_permalink(); ?>?quickview=true" class="quick_view"><img src="http://img.youtube.com/vi/<?php echo $ytid; ?>/0.jpg" /></a>

							<span class="quick_view"><a class="lightbox_icon quick_view" href="<?php the_permalink(); ?>?quickview=true"><img src="/wp-content/themes/kb2/img/search-white.png" alt="View" /></a></span>

						<?php endif; ?>
					</div>
					<div class="inner">
						<h2><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo kb_nicename($post->post_type); ?></p>
						<span class="action_buttons">
							<span class="more"><a class="view_button" href="<?php echo get_permalink($post->ID); ?>">More</a></span>
						</span>
					</div>
				</div>
				<?php $blog_count = $videos->current_post+1; ?>
				<?php if ( $blog_count % 3 == 0 && $blog_count != $videos->post_count) : ?>
					</div><div class="grid-container group">
				<?php endif; ?>
			<?php endwhile;?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
