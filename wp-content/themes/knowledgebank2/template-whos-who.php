<?php /* Template Name: Who's Who */ ?>

<?php get_header(); ?>

<?php

	$filters = knowledgebank_get_filters();

	//arguments for get_posts()
	$args = array(
		'post_type' => 'person',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_key' => 'name_0_family_name',
		'orderby' => 'meta_value',
		'order' => 'ASC'
	);



	$letter = '';
	if(!empty($_GET['letter']) && strlen($_GET['letter']) == 1) {
		$letter = $_GET['letter'];
		$regex_letter = strtolower($letter) . strtoupper($letter);
		$args['meta_query'] = array(
			array(
				'key' => 'name_0_family_name',
				'value' => "^[$regex_letter]",
				'compare' => 'REGEXP'
			)
		);
	}
	print_r($args);
	$all_people = get_posts( $args );

	//Filters
	if(!empty($filters['number']) && is_numeric($filters['number'])){
		$args['posts_per_page'] = $filters['number']; //per page
	}
	else{
		$args['posts_per_page'] = 20;
	}

	if(!empty($_GET['_page']) && is_numeric($_GET['_page'])){
		$offset = $args['posts_per_page'] * ($_GET['_page'] - 1); //eg on page 2, with 20 posts per page, we skip 20 * (2-1)
		$args['offset'] = $offset;
	}



	$people = get_posts( $args ); //just the terms we want, accounting for pagination

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

			<?php include_once(get_template_directory() . '/sections/term-filters.php'); //include rather than get_template_part so we can share $filters ?>

				<section class="layer results table">
				<div class="inner">

						<?php if(!empty($people)): ?>
						<table>
							<thead>
								<tr>
									<th>Last Name</th>
									<th>First Name</th>
									<th>DOB</th>
									<th>DOD</th>
								</tr>
							</thead>
							<?php foreach($people as $person): ?>
								<?php
									$name = get_field('name', $person->ID);
									//print_r($name);
									$family_name = !empty($name[0]['family_name']) ? $name[0]['family_name'] : '';
									$first_names = !empty($name[0]['first_name']) ? $name[0]['first_name'] : '';
									if(!empty($name[0]['middle_names'])) $first_names .= " {$name[0]['middle_names']}";

									//dates are kind of complex as they have an accuracy which determines how much of the date is valid and should be shown

									$birthdate = get_field('birthdate',$person->ID);
									if(!empty($birthdate)){
										$birthdate_dt = DateTime::createFromFormat('Y-m-d H:i:s', $birthdate);
										if(!empty($birthdate_dt)){
											$birthdate_accuracy = get_field('birthdate_accuracy', $person->ID);
											switch($birthdate_accuracy){

												case '365':
													$birthdate = $birthdate_dt->format('Y');
												break;

												case '30':
													$birthdate = $birthdate_dt->format('Y-m');
												break;

												default:
													$birthdate = $birthdate_dt->format('Y-m-d');
												break;

											}
										}
									}

									$deathdate = get_field('deathdate',$person->ID);
									if(!empty($deathdate)){
										$deathdate_dt = DateTime::createFromFormat('Y-m-d H:i:s', $deathdate);
										if(!empty($deathdate_dt)){
											$deathdate_accuracy = get_field('birthdate_accuracy', $person->ID);
											switch($deathdate_accuracy){

												case '365':
													$deathdate = $deathdate_dt->format('Y');
												break;

												case '30':
													$deathdate = $deathdate_dt->format('Y-m');
												break;

												default:
													$deathdate = $deathdate_dt->format('Y-m-d');
												break;

											}
										}
									}

								?>
								<tr>
									<td data-title="Last Name:"><a href="<?php echo get_permalink($person->ID); ?>"><?php echo $family_name; ?></a></td>
									<td data-title="First Name:"><a href="<?php echo get_permalink($person->ID); ?>"><?php echo $first_names; ?></a></td>
									<td data-title="DOB:"><?php echo $birthdate; ?></td>
									<td data-title="DOD:"><?php echo $deathdate; ?></td>
								</tr>

							<?php endforeach; ?>

							</table>

						<?php else: ?>

							<p>No terms</p>

						<?php endif; ?>


					<ul class="pagination">
						<?php
							//pagination
							$total_people = count($all_people);
							$max_pages = ceil($total_people / $args['posts_per_page']);

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
