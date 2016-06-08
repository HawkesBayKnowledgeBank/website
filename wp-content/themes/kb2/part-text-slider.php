<?php $images = get_field('images'); ?>

<?php if(!empty($images)): ?>

	<div class="images flexslider">

		<div id="textslider">
		
			<ul class="slides">

				<?php foreach($images as $index => $image): ?>

					<?php if($index == 0): ?>

						<li><img src="<?php echo $image['image']['sizes']['700w']; ?>" class="gallery-image" /></li>

					<?php else: ?>

						<li><img data-src="<?php echo $image['image']['sizes']['700w']; ?>" class="gallery-image lazy" /></li>

					<?php endif; ?>

				<?php endforeach; ?>

			</ul>

		</div><!-- #textslider -->

	</div>

<?php endif; ?>