<?php global $post; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('tile'); ?>>

	<div class="imageWrap">

		<?php $images = get_field('images'); ?>

		<?php if(isset($images[0]['image']['sizes']['700w'])): ?>

			<a href="<?php the_permalink(); ?>?quickview=true" class="quick_view"><img src="<?php echo $images[0]['image']['sizes']['700w']; ?>" /></a>
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
	
</article>