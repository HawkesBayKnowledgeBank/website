<?php global $post; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('tile'); ?>>

	<div class="imageWrap">

		<?php $images = get_field('images'); ?>

		<?php if(isset($images[0]['image']['sizes']['640x480_cropped'])): ?>

			<a href="<?php the_permalink(); ?>"><img src="<?php echo $images[0]['image']['sizes']['640x480_cropped']; ?>" /></a>

		<?php endif; ?>

	</div>

	<div class="inner">

		<h2><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h2>
		
		<p><?php echo kb_nicename($post->post_type); ?></p>

		<span class="action_buttons">					
			<span class="more"><a class="view_button" href="<?php echo get_permalink($post->ID); ?>">More</a></span>
			<span class="quick_view"><a class="lightbox_icon quick_view" href="<?php the_permalink(); ?>?quickview=true">View</a></span>
		</span>
		
	</div>
	
</article>