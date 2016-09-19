<?php get_header(); ?>

<div class="grid-container collections-list">


	<?php

		//top level collections
		$collections = get_terms( array(
		    'taxonomy' => 'collections',
		    'hide_empty' => true,
		    'parent' => 0,
		));		

		$counter = 0;
		$number_of_rows = count($collections);

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
				$counter++;
			?>

			<!-- <div class="grid-6"> -->
			<div class="collection">

				<?php if(get_field('image',$collection)): ?>

					<?php $image = get_field('image', $collection); //print_r($image); ?>

					<a href="<?php echo get_term_link($collection->term_id); ?>">
						<img src="<?php echo $image['sizes']['300w']; ?>" class="thumbnail"  />					
					</a>

				<?php endif; ?>

				<h3><a href="<?php echo get_term_link($collection->term_id); ?>"><?php echo $collection->name; ?></a></h3>

				<?php 
			
					$itemcount = $collection->count;

				?>

				<h5><?php echo $itemcount; ?> items</h5>
				
				<?php if(!empty($collection->description)): ?>

					<div class="description">

						<?php echo $collection->description; ?>
						<?php echo $number_of_rows ?>
						<?php echo $counter ?>
					</div><!-- . description -->
				<?php endif; ?>


			</div><!-- .collection -->
			
			<?php if ( $counter % 2 == 0 && $counter != $number_of_rows) : ?>

				</div><div class="grid-container collections-list">

			<?php endif; ?>
			
		<?php endforeach; ?>

	<?php endif; ?>


</div>

<?php get_footer(); ?>