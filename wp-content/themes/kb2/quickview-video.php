<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div>				
	<?php $youtube_id = get_field('youtube_id'); ?>

		<?php if(!empty($youtube_id)): ?>
			<div class="video">
			
				<iframe width="800" height="550" src="https://www.youtube.com/watch?v=<?php echo $youtube_id; ?>" frameborder="0" allowfullscreen></iframe>
						
			</div>
		<?php endif; ?>
</div>
<?php endwhile; endif; ?>