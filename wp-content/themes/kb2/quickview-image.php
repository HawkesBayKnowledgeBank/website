<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div>
	<?php $images = get_field('images'); ?>

		<?php if(!empty($images)): ?>
			<div class="images">
			<?php foreach($images as $image): ?>

				<img src="<?php echo $image['image']['sizes']['large']; ?>" class="gallery-image" />

			<?php endforeach; ?>
			</div>
		<?php endif; ?>
</div>
<?php endwhile; endif; ?>