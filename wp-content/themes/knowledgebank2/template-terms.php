<?php /* Template Name: Term listing */ ?>
<?php
/**
* This template is for listing terms in a specified taxonomy, or subterms of a specified term.
*/
?>
<?php

	$mode = get_field('mode');

	//arguments for get_terms()
	$args = array(
		'hide_empty' => true,
		'meta_query' => array(
			array(
				'key' => 'public',
				'value' => 1,
			)
		)
	);

	if($mode == 'Taxonomy'):
		$taxonomy = get_field('display_taxonomy');
		$args['taxonomy'] = $taxonomy[0]->name;
		$args['parent'] = 0;
	else:
		$term = get_field('display_term');
		$args['child_of'] = $term[0]->term_id;
	endif;

	$terms = get_terms( $args );

?>
<?php get_header(); ?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<ul class="breadcrumbs">
							<li><a href="http://mogulframework.wpengine.com">Home</a></li><li>Browse</li>
						</ul>
						<h1><?php the_title(); ?></h1>
						<?php the_field('intro'); ?>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php //get_template_part('sections/search','main'); ?>

			<section class="layer controls">
				<div class="inner">

					<form class="" action="index.html" method="post">
						<div class="controls-grid">

							<div class="control-option">
								<label>Filter results by tags</label>
								<select class="select2" name="tags[]" multiple="multiple">
								  <option value="tag1">Tag 1</option>
								  <option value="tag2">Tag 2</option>
									<option value="tag3">Tag 3</option>
								</select>
							</div><!-- .control-option -->

							<div class="control-option">
								<label>View as</label>
								<select class="select2-nosearch" name="View" id="view-select">
								  <option value="tiles" class="tiles-option">Tiles</option>
								  <option value="rows" class="rows-option">Rows</option>
								</select>
							</div><!-- .control-option -->

							<div class="control-option">
								<label>Sort by</label>
								<select class="select2-nosearch" name="View">
								  <option value="item-count">Item count</option>
								  <option value="name">Name</option>
								</select>
							</div><!-- .control-option -->

							<div class="control-option">
								<label>Order</label>
								<select class="select2-nosearch" name="View">
								  <option value="ascending">Ascending</option>
								  <option value="descending">Descending</option>
								</select>
							</div><!-- .control-option -->

							<div class="control-option">
								<label>Items per page</label>
								<select class="select2-nosearch" name="View">
								  <option value="5">5</option>
								  <option value="10">10</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="60">60</option>
								</select>
							</div><!-- .control-option -->


						</div>
					</form>

				</div>
			</section>


			<section class="layer results tiles ">
				<div class="inner">

					<div class="grid column-4 ">

						<?php if(!empty($terms)): ?>

							<?php foreach($terms as $term): ?>

								<?php

									$link = get_term_link($term);
									$image = get_field('image',$term);

								?>

								<div class="col tile shadow">
									<?php if(!empty($image)): ?>
										<?php
											$src = !empty($image['sizes']['medium']) ? $image['sizes']['medium'] : '';
										?>
										<div class="tile-img lazy" data-src="<?php echo $src; ?>">
											<a href="<?php echo $link; ?>"></a>
										</div>
									<?php endif; ?>
									<div class="tile-copy">
										<h4><a href="<?php echo $link; ?>"><?php echo $term->name; ?></a></h4>
										<p class="term-item-count"><?php echo $term->count; ?> items</p>
										<?php if(!empty($term->description)): ?><p><?php echo $term->description; ?></p><?php endif; ?>
										<div class="button-group">
											<a href="<?php echo $link; ?>" class="button">View</a>
										</div>
									</div><!-- .tile-copy -->
								</div><!-- .col -->

							<?php endforeach; ?>

						<?php endif; ?>


					</div><!-- .grid -->


				</div><!-- .inner -->
			</section>

	</main>

<?php get_footer(); ?>
