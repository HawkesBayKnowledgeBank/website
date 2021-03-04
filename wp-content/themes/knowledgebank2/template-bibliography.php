<?php /* Template Name: Bibliography */ ?>

<?php get_header(); ?>

<?php

	$filters = knowledgebank_get_filters();

	//arguments for get_posts()
	$args = array(
		'post_type' => 'bibliography',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'orderby' => 'title',
		'order' => 'ASC'
	);

	$all_books = get_posts( $args ); //just the terms we want, accounting for pagination


	//Filters
	if(!empty($filters['number']) && is_numeric($filters['number'])){
		$args['posts_per_page'] = $filters['number']; //per page
	}
	else{
		$args['posts_per_page'] = 90;
	}

	if(!empty($_GET['_page']) && is_numeric($_GET['_page'])){
		$offset = $args['posts_per_page'] * ($_GET['_page'] - 1); //eg on page 2, with 20 posts per page, we skip 20 * (2-1)
		$args['offset'] = $offset;
	}

	$books = get_posts($args);

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

				<?php include_once(get_template_directory() . '/sections/term-filters.php');  ?>

				<section class="layer results table">
					<div class="inner">

							<?php if(!empty($books)): ?>
							<table>
								<thead>
									<tr>
										<th>Title</th>
										<th>Author(s)</th>
										<th>ISBN</th>
										<th>Publication date</th>
									</tr>
								</thead>
								<?php foreach($books as $book): ?>
									<?php

										$author = get_field('author', $book->ID);
										if(!empty($author)){
											$author_strings = array();
											foreach($author as $person){
												$record = false;
							                    if(!empty($person['record'])) {
							                        $record = $person['record'];
							                        unset($person['record']);
							                    }
							                    $name = implode(' ', $person);
							                    if(!empty($record)){
							                        $author_strings[] = sprintf('<a href="%s">%s</a>', get_permalink($record->ID), $name);
							                    }
							                    else{
							                        $author_strings[] = $name;
							                    }
											}
											$author = implode(", ", $author_strings);
										}

										$isbn = get_field('isbn', $book->ID);
										$yearpublished = get_field('yearpublished', $book->ID);

									?>
									<tr>
										<td data-title="Title"><a href="<?php echo get_permalink($book->ID); ?>"><?php echo $book->post_title; ?></a></td>
										<td data-title="Author"><?php echo $author; ?></td>
										<td data-title="ISBN"><?php echo $isbn; ?></td>
										<td data-title="Year"><?php echo $yearpublished; ?></td>
									</tr>

								<?php endforeach; ?>

								</table>

							<?php else: ?>

								<p>No results</p>

							<?php endif; ?>

							<ul class="pagination">
								<?php
									//pagination
									$total_books = count($all_books);
									$max_pages = ceil($total_books / $args['posts_per_page']);

									foreach(range(1,$max_pages) as $page_number):

										$url_params = array('_page' => $page_number, 'filters' => $filters);

										if(!empty($letter)) $url_params['letter'] = $letter;


										$_page = !empty($_GET['_page']) ? $_GET['_page'] : 1;
										$current_page_class = $_page == $page_number ? 'active' : '';
										$url = get_permalink() . '?' . http_build_query($url_params);

								?>
									<li class="<?php echo $current_page_class; ?>"><a href="<?php echo $url; ?>"><?php echo $page_number; ?></a></li>

								<?php endforeach; ?>
							</ul>

					</div><!-- .inner -->
				</section>

	</main>

<?php get_footer(); ?>
