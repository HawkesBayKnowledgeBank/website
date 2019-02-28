<?php /* Template Name: Search results */ ?>
<?php get_header(); ?>
<?php $filters = knowledgebank_get_filters(); ?>
<?php
	global $wp_query;

	$title = 'Search';
	$search_query = get_search_query();
	//if(!empty($search_query)) $title .= ' - ' . $search_query;

?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php echo $title; ?></h1>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php get_template_part('sections/search','main'); ?>

			<?php

				//$advanced_search = new WP_Advanced_Search('knowledgebank_advanced_search');
				//$advanced_search->the_form();

			?>


				<main role="main">
					<!-- section -->
					<section class="layer">
						<div class="inner thin content">

							<?php if(!empty($search_query)): ?><h3>Results for <em><?php echo $search_query; ?></em></h3><?php endif; ?>

							<?php get_template_part('search_loop'); ?>
				
							<ul class="pagination">
								<?php knowledgebank_numeric_posts_nav(); ?>
							</ul>
						</div>
					</section>
					<!-- /section -->
				</main>


	</main>

<?php get_footer(); ?>
