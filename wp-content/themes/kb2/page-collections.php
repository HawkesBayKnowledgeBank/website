<?php get_header(); ?>

<div class="grid-container collections-list">


	<?php

		//top level collections
		$collections = get_terms( array(
		    'taxonomy' => 'collections',
		    'hide_empty' => true,
		    'parent' => 0,
		));		

	?>

	<?php if(!empty($collections)): ?>

		<?php foreach($collections as $collection): ?>

			<?php 
				//get child collections, if any
				$children = get_terms( array(
				    'taxonomy' => 'collections',
				    'hide_empty' => false,
				    'parent' => $collection->term_id,
				));	
			?>

			<div class="collection">

				<?php if(get_field('image',$collection)): ?>

					<?php $image = get_field('image', $collection); //print_r($image); ?>

					<a href="<?php echo get_term_link($collection->term_id); ?>">
						<img src="<?php echo $image['sizes']['700w']; ?>" class="thumbnail"  />					
					</a>

				<?php endif; ?>

				<h3><a href="<?php echo get_term_link($collection->term_id); ?>"><?php echo $collection->name; ?></a></h3>

				<?php 
					
					$itemcount = $collection->count;
					if(!empty($children)):
						foreach($children as $child):
							//(int)$itemcount += (int)$child->count;
						endforeach;
					endif;

				?>

				<h5><?php echo $itemcount; ?> items</h5>
				
				
				<?php if(!empty($collection->description)): ?>

					<div class="description">

						<?php echo $collection->description; ?>

					</div><!-- . description -->
				<?php endif; ?>

					<?php if(!empty($children)): ?>

						<div class="subcollections tiles">

							<?php foreach($children as $child): ?>
								

								<div class="subcollection tile">

									<h4><a href="<?php echo get_term_link($child->term_id); ?>"><?php echo $child->name; ?></a></h4>

								</div><!-- .subcollection -->


							<?php endforeach; ?>

						</div><!-- .subcollections -->
					<?php endif; ?>

			</div><!-- .collection -->

		<?php endforeach; ?>

	<?php endif; ?>


</div>

<?php get_footer(); ?>