<?php get_header(); ?>

<div class="pageTitles">

	<h1>Collections</h1>		

	<p>Collections of material donated by people and organisations.</p>

</div>

<?php

	//top level collections
	$collections = get_terms( array(
	    'taxonomy' => 'collections',
	    'hide_empty' => true,
	    'parent' => 0,
	));		

	$counter = 0;
	$number_of_rows = count($collections);

	$filterletter = (isset($_GET['letter']) ? strtolower(substr($_GET['letter'],0,1)) : '');

?>


<?php if(!empty($collections)): ?>


	<div class="grid-container collections-list">	

		<?php $pagerletter = ''; ?>

		<div class="letter-paging">

			<?php $activeclass = ($filterletter == '' ? 'active' : ''); ?>

			<a href="<?php the_permalink(); ?>" class="<?php echo $activeclass; ?>">all</a>

			<?php foreach($collections as $collection): ?>

				<?php

					$letter = strtolower(substr($collection->name,0,1));

					$activeclass = ($filterletter == $letter ? 'active' : '');

					if($pagerletter != $letter) :
						$pagerletter = $letter;	?>

						<a href="<?php the_permalink(); ?>?letter=<?php echo $letter; ?>" class="<?php echo $activeclass; ?>"><?php echo $letter; ?></a>

					<?php

					endif;

				?>

			<?php endforeach; ?>
			
		</div>


		<?php foreach($collections as $collection): ?>

			<?php $letter = strtolower(substr($collection->name,0,1)); ?>

			<?php if(!empty($filterletter) && $filterletter != $letter) continue; //skip this collection if it does not begin with the requested letter ?>

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

					</div><!-- . description -->
				<?php endif; ?>


			</div><!-- .collection -->
			

			
		<?php endforeach; ?>

	</div>

<?php endif; ?>

<?php get_footer(); ?>