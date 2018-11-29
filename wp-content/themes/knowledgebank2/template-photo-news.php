<?php /* Template Name: Photo News */ ?>

<?php get_header(); ?>

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
		$display_term = get_field('display_term');
		//print_r($term);
		$args['taxonomy'] = $display_term[0]->taxonomy;
		$args['child_of'] = $display_term[0]->term_id;
	endif;

	$all_terms = get_terms( $args ); //we need to know how many terms there are in total, for pagination

	//Filters
	if(!empty($filters['number']) && is_numeric($filters['number'])){
		$args['number'] = $filters['number']; //per page
	}
	else{
		$args['number'] = 20;
	}

	if(!empty($_GET['term_page']) && is_numeric($_GET['term_page'])){
		$offset = $args['number'] * ($_GET['term_page'] - 1); //eg on page 2, with 20 posts per page, we skip 20 * (2-1)
		$args['offset'] = $offset;
	}

	$terms = get_terms( $args ); //just the terms we want, accounting for pagination

?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php the_title(); ?></h1>
						<?php the_field('intro'); ?>
						<?php if(!empty($display_term[0]->description)): ?>
							<p><?php echo $display_term[0]->description; ?></p>
						<?php endif; ?>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>
			<?php $filters = knowledgebank_get_filters(); ?>
			<?php include_once(get_template_directory() . '/sections/term-filters.php'); //include rather than get_template_part so we can share $filters ?>

				<section class="layer results tiles photo-news">
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

						<?php else: ?>

							<p>No terms</p>

						<?php endif; ?>


					</div><!-- .grid -->

					<ul class="pagination">
						<?php
							//pagination
							$total_terms = count($all_terms);
							$max_pages = ceil($total_terms / $args['number']);

							foreach(range(1,$max_pages) as $page_number):

								$term_page = !empty($_GET['term_page']) ? $_GET['term_page'] : 1;
								$current_page = $term_page == $page_number ? 'active' : '';
								$url_params = array('term_page' => $page_number, 'filters' => $filters);
								$url = get_permalink() . '?' . http_build_query($url_params);

						?>
							<li class="<?php echo $current_page; ?>"><a href="<?php echo $url; ?>"><?php echo $page_number; ?></a></li>

						<?php endforeach; ?>
					</ul>

				</div><!-- .inner -->
			</section>

	</main>

<?php get_footer(); ?>
