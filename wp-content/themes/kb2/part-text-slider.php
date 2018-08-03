<?php $images = get_field('images'); ?>

<?php if(!empty($images)): ?>

	<div class="images flexslider">

		<div id="textslider">
		
			<ul class="slides">

				<?php foreach($images as $index => $image): ?>

					<?php

						$src = $image['image']['sizes']['700w'];						
						$largesrc = (isset($image['image']['sizes']['1200w']) ? $image['image']['sizes']['1200w'] : $image['image']['url']);

					?>


					<?php if($index == 0): ?>

						<li><a href="<?php echo $largesrc; ?>" class="magnific"><img src="<?php echo $src; ?>" class="gallery-image" /></a></li>

					<?php else: ?>

						<li><a href="<?php echo $largesrc; ?>" class="magnific"><img data-src="<?php echo $src; ?>" class="gallery-image lazy" /></a></li>

					<?php endif; ?>

				<?php endforeach; ?>

			</ul>

		</div><!-- #textslider -->

			
	</div>

	<div class="slidernav flexslider">

		<ul class="slides">

			<?php foreach($images as $index => $image): ?>

					<?php $smallsrc = $image['image']['sizes']['thumbnail']; ?>

					<li><img src="<?php echo $smallsrc; ?>" class="gallery-image-small" /></li>

			<?php endforeach; ?>

		</ul>

	</div><!-- .slidernav -->			

	

<?php endif; ?>