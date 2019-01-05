<?php get_header(); ?>
<?php $filters = knowledgebank_get_filters(); ?>
<?php
	global $wp_query;

	$term = get_queried_object();
	$term_id = $term->term_id;
	$taxonomy = get_taxonomy($term->taxonomy);
	$taxonomy_name = $term->taxonomy;
?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php the_archive_title(); ?></h1>
		  				<?php if(!empty($term->description)) echo apply_filters('the_content', $term->description); ?>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php include_once(get_template_directory() . '/sections/term-filters.php'); //include rather than get_template_part so we can share $filters ?>

			<?php
				$extra_classes = array();
				if($term->parent == 967){
					$extra_classes[] = 'photo-news';
				}
			?>
			<section class="layer results tiles <?php echo implode(' ', $extra_classes); ?>">
				<div class="inner">
					<?php
						$child_terms = get_terms(array( 'taxonomy' => $taxonomy_name, 'child_of' => $term_id, 'orderby' => 'name' ));
					?>
					<?php if(!empty($child_terms)): ?>
						<?php /* <h5>Sub-<?php echo strtolower($taxonomy->labels->singular_name); ?>s in <?php echo single_cat_title( '', false ); ?></h5> */ ?>
					<div class="grid column-5">
						<?php foreach($child_terms as $child_term): ?>
							<?php
								$link = get_term_link($child_term);
								$image = get_field('image',$child_term);
							?>

							<div class="col tile shadow">
								<?php /*if(!empty($image)): ?>
									<?php
										$src = !empty($image['sizes']['thumbnail']) ? $image['sizes']['thumbnail'] : '';
									?>
									<div class="tile-img lazy" data-src="<?php echo $src; ?>">
										<a href="<?php echo $link; ?>"></a>
									</div>
								<?php endif; */ ?>
								<div class="tile-copy">
									<h4><a href="<?php echo $link; ?>"><?php echo $child_term->name; ?></a></h4>
									<p class="term-item-count"><?php echo $child_term->count; ?> items</p>
									<?php if(!empty($child_term->description)): ?><p><?php echo $child_term->description; ?></p><?php endif; ?>
									<?php /*
									<div class="button-group">
										<a href="<?php echo $link; ?>" class="button">View</a>
									</div>
									*/ ?>
								</div><!-- .tile-copy -->
							</div><!-- .col -->
						<?php endforeach; ?>

					</div><!-- child terms -->
					<?php endif; ?>

					<?php /* <h5>Records in <?php echo single_cat_title( '', false ); ?></h5> */ ?>
					<div class="grid column-4 ">

						<?php if(have_posts()): while(have_posts()): the_post(); ?>

							<?php

								$type = $post->post_type;
								$images = get_field('images', $post->ID);
								$image = !empty($images[0]['image']) ? $images[0]['image'] : false;
								$link = get_permalink($post->ID);
								$image_size = $term->parent == 967 ? 'medium' : 'thumbnail';
							?>

				  			<div class="col tile shadow <?php echo $type; ?>">

								<?php $src = !empty($image['sizes'][$image_size]) ? $image['sizes'][$image_size] : '/wp-content/themes/knowledgebank2/img/placeholder-400.png';	?>
								<div class="tile-img lazy" style="background-image:url(/wp-content/themes/knowledgebank2/img/placeholder-400.png)" data-src="<?php echo $src; ?>">
									<a href="<?php echo $link; ?>"></a>
								</div>

								<div class="tile-copy">
									<h4><a href="<?php echo $link; ?>"><?php echo $post->post_title; ?></a></h4>
										<?php the_excerpt(); ?>
									<div class="button-group">
										<a href="<?php echo $link; ?>" class="button">View Details</a>
									</div>
								</div><!-- .tile-copy -->
							</div><!-- .col -->

							<?php endwhile; ?>

						<?php else: ?>

							<p>No results found</p>

						<?php endif; ?>

					</div><!-- .grid -->

					<ul class="pagination">
						<?php knowledgebank_numeric_posts_nav(); ?>
					</ul>

				</div><!-- .inner -->
			</section>

	</main>

<?php get_footer(); ?>
