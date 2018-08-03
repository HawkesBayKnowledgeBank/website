<?php global $post; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('tile'); ?>>

	<div class="inner">

		<h2><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h2>
		<p><?php echo kb_nicename($post->post_type); ?></p>
		<span class="action_buttons">
			<span class="more"><a class="view_button" href="<?php echo get_permalink($post->ID); ?>">More</a></span>
		</span>
		
		<!--<span class="quick_view"><a class="lightbox_icon quick_view" href="<?php the_permalink(); ?>?quickview=true">Quick view</a></span>-->
	</div>
	
</article>