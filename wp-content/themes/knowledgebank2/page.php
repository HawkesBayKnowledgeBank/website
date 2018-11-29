<?php get_header(); ?>

	<main role="main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<section class="layer intro intro-default">
			<div class="inner">
				<div class="intro-copy dark inner-700">
					<?php get_template_part('sections/breadcrumbs'); ?>
					<h1><?php the_title(); ?></h1>
					<?php the_field('intro'); ?>
				</div><!-- .intro-copy -->
			</div><!-- .inner -->
		</section>

		<section class="layer single-column">
			<div class="inner thin content">

				<?php if (have_posts()): while (have_posts()) : the_post(); ?>

						<?php the_content(); ?>
						<?php comments_template( '', true ); // Remove if you don't want comments ?>
						<?php edit_post_link(); ?>

				<?php endwhile; ?>

				<?php else: ?>

					<h2><?php _e( 'Sorry, nothing to display.', 'knowledgebank' ); ?></h2>

				<?php endif; ?>

			</div><!-- .inner -->
		</section>


	</main>

<?php get_footer(); ?>
