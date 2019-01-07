<?php get_header(); ?>
<?php $filters = knowledgebank_get_filters(); ?>
<?php
	global $wp_query;

	$term = get_queried_object();
	$term_id = $term->term_id;
	$taxonomy = get_taxonomy($term->taxonomy);
	$taxonomy_name = $term->taxonomy;

	$title = get_the_title(get_option('page_for_posts'));;


?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php echo $title; ?></h1>
		  				<?php if(!empty($term->description)) echo apply_filters('the_content', $term->description); ?>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>



				<main role="main">
					<!-- section -->
					<section class="layer">
						<div class="inner thin content">
						<?php get_template_part('loop'); ?>
						<ul class="pagination">
							<?php knowledgebank_numeric_posts_nav(); ?>
						</ul>

					</div>
					</section>
					<!-- /section -->
				</main>


	</main>

<?php get_footer(); ?>
