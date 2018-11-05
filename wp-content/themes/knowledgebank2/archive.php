<?php get_header(); ?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<ul class="breadcrumbs">
							<li><a href="http://mogulframework.wpengine.com">Home</a></li><li>Browse</li>
						</ul>
						<h1><?php the_archive_title(); ?></h1>
		  			<p>Default page intro text. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id.</p>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php get_template_part('sections/search','main'); ?>

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

					<div class="grid column-5">
						<div class="col tile shadow">foo</div>
						<div class="col tile shadow">foo</div>
						<div class="col tile shadow">foo</div>
						<div class="col tile shadow">foo</div>
						<div class="col tile shadow">foo</div>
					</div><!-- child terms -->


					<div class="grid column-4 ">

						<?php if(have_posts()): while(have_posts()): the_post(); ?>

							<?php

								$type = $post->post_type;
								$images = get_field('images', $post->ID);
								if(!empty($images[0]['image'])){
									$image = $images[0]['image'];
								}
								$link = get_permalink($post->ID);

							?>

				  			<div class="col tile shadow <?php echo $type; ?>">
								<?php if(!empty($image)): ?>
									<?php print_r($image);
										$src = !empty($image['sizes']['medium']) ? $image['sizes']['medium'] : '';
									?>
									<div class="tile-img lazy" style="background-image:url(/wp-content/themes/knowledgebank2/img/placeholder-400.png)" data-src="<?php echo $src; ?>">
										<a href="<?php echo $link; ?>"></a>
									</div>
								<?php endif; ?>
								<div class="tile-copy">
									<h4><a href="<?php echo $link; ?>"><?php echo $post->post_title; ?></a></h4>
										<?php the_excerpt(); ?>
									<div class="button-group">
										<a href="<?php echo $link; ?>" class="button">View Details</a>
									</div>
								</div><!-- .tile-copy -->
							</div><!-- .col -->

						<?php endwhile; endif; ?>

					</div><!-- .grid -->

					<ul class="pagination">
						<?php knowledgebank_numeric_posts_nav(); ?>
					</ul>

				</div><!-- .inner -->
			</section>

	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
