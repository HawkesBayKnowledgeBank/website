<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<section class="layer intro intro-default background-image" style="background-image:url(img/quake.jpg);">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php the_title(); ?></h1>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php //get_template_part('sections/search','main'); ?>
			<section class="layer single-column">
				<div class="inner thin content">
					<div class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></div>
					<?php the_content(); ?>
				</div><!-- .inner -->
			</section>


			<section class="layer commenting-wrap">
				<div class="inner">
					<div class="commenting">
						<h4>Comments</h4>
						<p class="temp">Commenting system here</p>
					</div>
				</div>
			</section>

			<?php get_template_part('sections/sponsors'); ?>

			<section class="layer signup">
				<div class="inner">
					<div class="section-header center">
						<h4>Sign up to our newsletter</h4>
					</div>
					<form class="" action="index.html" method="post">
						<input type="text" name="" value="" placeholder="First name">
						<input type="text" name="" value="" placeholder="Last name">
						<input type="email" name="" value="" placeholder="Email address">
						<button type="submit" name="button">Sign up</button>
					</form>
				</div>
			</section>


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
