<?php get_header(); ?>

<div class="grid-container collections-list">


	<?php

		//top level collections
		$collections = get_terms( array(
		    'taxonomy' => 'collections',
		    'hide_empty' => false,
		    'parent' => 0,
		));		

	?>

	<?php if(!empty($collections)): ?>

		<?php foreach($collections as $collection): ?>

			<div class="collection">

				<?php if(get_field('image',$collection)): ?>

					<?php $image = get_field('image', $collection); //print_r($image); ?>

					<img src="<?php echo $image['sizes']['300w']; ?>" class="thumbnail" />					

				<?php endif; ?>

				<h3><a href="<?php echo get_term_link($collection->term_id); ?>"><?php echo $collection->name; ?></a></h3>

				<?php if(isset($collection->count)): ?><h5><?php echo $collection->count; ?> items</h5><?php endif; ?>
				
				<?php if(!empty($collection->description)): ?>

					<div class="description">

						<?php echo $collection->description; ?>

					</div><!-- . description -->

					<?php 
						//children
						$children = get_terms( array(
						    'taxonomy' => 'collections',
						    'hide_empty' => false,
						    'parent' => $collection->term_id,
						));	
					?>

					<?php if(!empty($children)): ?>

						<div class="subcollections tiles">

							<?php foreach($children as $child): ?>

								<div class="subcollection tile">

									<h4><a href="<?php echo get_term_link($child->term_id); ?>"><?php echo $child->name; ?></a></h4>

								</div><!-- .subcollection -->

							<?php endforeach; ?>

						</div><!-- .subcollections -->

					<?php endif; ?>

				<?php endif; ?>

			</div><!-- .collection -->

		<?php endforeach; ?>

	<?php endif; ?>


<?php
	/*
			// List terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)
			 
			$taxonomy     = 'collections';
			$orderby      = 'name'; 
			$show_count   = true;
			$pad_counts   = false;
			$hierarchical = true;
			$title        = '';
			 
			$args = array(
			  'taxonomy'     => $taxonomy,
			  'orderby'      => $orderby,
			  'show_count'   => $show_count,
			  'pad_counts'   => $pad_counts,
			  'hierarchical' => $hierarchical,
			  'title_li'     => $title
			);
		?>
	 
		<ul class="collections">
		    <?php wp_list_categories( $args ); ?>
		</ul>

	*/
?>

</div>

<?php get_footer(); ?>