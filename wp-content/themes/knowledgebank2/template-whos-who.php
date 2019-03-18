<?php /* Template Name: Who's Who */ ?>

<?php get_header(); ?>

<?php

	$filters = knowledgebank_get_filters();

	//arguments for get_posts()
	$args = array(
		'post_type' => 'person',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_query' => 'name_0_family_name',
		'orderby' => 'meta_value',
		'order' => 'ASC'
	);

	global $wpdb;
	//$all_people = $wpdb->get_results('SELECT ID, pm1.meta_value AS last_name, pm2.meta_value AS first_name FROM wp_posts LEFT JOIN wp_postmeta pm1 ON ID = pm1.post_id LEFT JOIN wp_postmeta pm2 ON ID = pm2.post_id WHERE pm1.meta_key = "name_0_family_name" AND pm2.meta_key = "name_0_first_name" ORDER BY last_name, first_name ASC');


	$letter = '';
	if(!empty($_GET['letter']) && strlen($_GET['letter']) == 1) {
		$letter = $_GET['letter'];
		$sql = $wpdb->prepare('SELECT ID, pm1.meta_value AS last_name, pm2.meta_value AS first_name FROM wp_posts LEFT JOIN wp_postmeta pm1 ON ID = pm1.post_id LEFT JOIN wp_postmeta pm2 ON ID = pm2.post_id WHERE pm1.meta_key = "name_0_family_name" AND pm2.meta_key = "name_0_first_name" AND pm1.meta_value LIKE "%s" AND wp_posts.post_status = "publish" ORDER BY last_name, first_name ASC',array($letter . '%'));
		//echo $sql;
		$all_people = $wpdb->get_results($sql);

	}
	else{
		$all_people = $wpdb->get_results('SELECT ID, pm1.meta_value AS last_name, pm2.meta_value AS first_name FROM wp_posts LEFT JOIN wp_postmeta pm1 ON ID = pm1.post_id LEFT JOIN wp_postmeta pm2 ON ID = pm2.post_id WHERE pm1.meta_key = "name_0_family_name" AND pm2.meta_key = "name_0_first_name" AND wp_posts.post_status = "publish" ORDER BY last_name, first_name ASC');
	}
	//print_r($args);
//	$all_people = get_posts( $args );

	//print_r($all_people);

	//Filters
	if(!empty($filters['number']) && is_numeric($filters['number'])){
		$args['posts_per_page'] = $filters['number']; //per page
	}
	else{
		$args['posts_per_page'] = 90;
	}

	$args['offset'] = 0;
	if(!empty($_GET['_page']) && is_numeric($_GET['_page'])){
		$offset = $args['posts_per_page'] * ($_GET['_page'] - 1); //eg on page 2, with 20 posts per page, we skip 20 * (2-1)
		$args['offset'] = $offset;
	}

	$people = array_slice($all_people, $args['offset'], $args['posts_per_page']);

	//$people = get_posts( $args ); //just the terms we want, accounting for pagination

?>

	<main role="main">

				<section class="layer intro intro-default">
					<div class="inner">
						<div class="intro-copy dark inner-700">
							<?php get_template_part('sections/breadcrumbs'); ?>
							<h1><?php the_title(); ?></h1>
							<?php the_field('intro'); ?>
							<p>An index of Hawke's Bay people.</p>
						</div><!-- .intro-copy -->
					</div><!-- .inner -->
				</section>


				<section class="layer controls">
					<div class="inner">

						<form class="" action="index.html" method="post">
							<div class="controls-grid">

								<div class="control-option alphabet">
									<div class="alphabet-flex">
										<?php $active = empty($_GET['letter']) ? 'active' : ''; ?>
										<a class="<?php echo $active; ?>" href="<?php echo get_permalink(); ?>">All</button>
										<?php foreach(range('a','z') as $page_letter): ?>
											<?php $active = !empty($_GET['letter']) && $_GET['letter'] == $page_letter ? 'active' : ''; ?>
											<a href="<?php echo get_permalink() . '?letter=' . $page_letter; ?>" class="<?php echo $active; ?>"><?php echo $page_letter; ?></a>
										<?php endforeach; ?>
									</div>
								</div><!-- .control-option -->

							</div>
						</form>

					</div>
				</section>

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
										$person = get_post($person->ID);

										$name = get_field('name', $person->ID);
										//print_r($name);
										$family_name = !empty($name[0]['family_name']) ? $name[0]['family_name'] : '';
										$first_names = !empty($name[0]['first_name']) ? $name[0]['first_name'] : '';
										if(!empty($name[0]['middle_names'])) $first_names .= " {$name[0]['middle_names']}";

										//dates are kind of complex as they have an accuracy which determines how much of the date is valid and should be shown

										$birthdate = get_field('birthdate', $person->ID, false);

										if(!empty($birthdate)){
											//birthdates have some odd values brought over from Drupal - might be Y or Y-m or Y-m-d
											$birthdate_dt = DateTime::createFromFormat('Ymd', $birthdate);
											if(!empty($birthdate_dt)) $birthdate = $birthdate_dt->format('Y');
										}


										$deathdate = get_field('deathdate',$person->ID, false);
										if(!empty($deathdate)){
											$deathdate_dt = DateTime::createFromFormat('Ymd', $deathdate);
											if(!empty($deathdate_dt)) $deathdate = $deathdate_dt->format('Y');
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
