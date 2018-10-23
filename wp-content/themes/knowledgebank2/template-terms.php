<?php /* Template Name: Term listing */ ?>
<?php
/**
* This template is for listing terms in a specified taxonomy, or subterms of a specified term.
*/
?>
<?php

	$mode = get_field('mode');
	if($mode == 'Taxonomy'):

		$taxonomy = get_field('display_taxonomy');

		$terms = get_terms( array(
			'taxonomy' => $taxonomy[0]->name,
			'hide_empty' => false,
		));

	else:

		$term = get_field('display_term');
		$terms = get_terms( array(
			'child_of' => $term[0]->term_id,
			'hide_empty' => false,
		));

	endif;

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

						<div class="col tile shadow video">
							<div class="tile-img" style="background-image:url('img/quake.jpg')">
								<a href="#"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="#">Tile title</a></h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								<div class="button-group">
									<a href="#" class="button">Button</a>
								</div>
							</div><!-- .tile-copy -->
						</div><!-- .col -->


						<div class="col tile shadow">
							<div class="tile-img" style="background-image:url('<?php echo $tile['image']['sizes']['medium']; ?>')">
								<a href="<?php echo $tile['link']; ?>"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="<?php echo $tile['link']; ?>"><?php echo $tile['title']; ?></a></h4>
								<?php echo $tile['content']; ?>
								<?php if(!empty($tile['button_label'])): ?>
									<div class="button-group">
										<a href="<?php echo $tile['button_link']; ?>" class="button"><?php echo $tile['button_label']; ?></a>
									</div>
								<?php endif; ?>
							</div><!-- .tile-copy -->
						</div><!-- .col -->

					</div><!-- .grid -->

					<ul class="pagination">
						<li class="current-page"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#">6</a></li>
						<li><a href="#">7</a></li>
						<li><a href="#">8</a></li>
						<li><a href="#">9</a></li>
						<li class="elipses">...</li>
						<li><a href="#">Next ></a></li>
						<li><a href="#">Last >></a></li>
					</ul>

				</div><!-- .inner -->
			</section>


















			<section class="layer results tiles ">

				<div class="inner">

					<div class="grid column-4 ">

						<?php $tiles = get_field('tiles'); ?>

						<?php if(!empty($tiles['tiles'])): ?>
							<?php foreach($tiles['tiles'] as $tile): ?>

					  			<div class="col tile shadow">
									<div class="tile-img" style="background-image:url('<?php echo $tile['image']['sizes']['medium']; ?>')">
										<a href="<?php echo $tile['link']; ?>"></a>
									</div>
									<div class="tile-copy">
										<h4><a href="<?php echo $tile['link']; ?>"><?php echo $tile['title']; ?></a></h4>
										<?php echo $tile['content']; ?>
										<?php if(!empty($tile['button_label'])): ?>
											<div class="button-group">
												<a href="<?php echo $tile['button_link']; ?>" class="button"><?php echo $tile['button_label']; ?></a>
											</div>
										<?php endif; ?>
									</div><!-- .tile-copy -->
								</div><!-- .col -->

							<?php endforeach; ?>
						<?php endif; ?>

					</div><!-- .grid -->

				</div><!-- .inner -->

			</section>

	</main>


<?php get_footer(); ?>
