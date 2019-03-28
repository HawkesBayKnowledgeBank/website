<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<section class="layer intro intro-default background-image" style="">
				<?php //if(function_exists('the_favorites_button')) the_favorites_button($post->ID); ?>
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php the_title(); ?></h1>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php //get_template_part('sections/search','main'); ?>

			<?php
				$fields = knowledgebank_get_field_objects(); //we want to move / remove / play around with field orders
			?>

			<?php $images = get_field('images'); ?>

			<?php if(!empty($images)): ?>

				<?php include('sections/image-slider.php'); ?>

			<?php endif; //!empty($images) ?>

			<?php if(get_field('audio')): ?>

				<?php
					$audio = get_field_object('audio');
					knowledgebank_field_template($audio, false);
				?>

			<?php endif; //audio ?>

			<section class="layer attributes">
				<div class="inner">
					<div class="grid column-2">

						<?php
							foreach($fields as $field):
								//look for templates for each field, first by name and then by type
								knowledgebank_field_template($field); //see inc/theme_functions.php
							endforeach;
						?>

					</div>

				</div>
			</section>

			<?php include('sections/disqus.php'); ?>

			<?php get_template_part('sections/sponsors'); ?>

			<?php get_template_part('sections/signup'); ?>


		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'knowledgebank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_footer(); ?>
