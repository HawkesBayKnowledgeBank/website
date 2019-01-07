<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('news'); ?>>

		<!-- post thumbnail -->
		<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-thumbnail">
				<?php the_post_thumbnail('thumbnail'); // Declare pixel size you need inside the array ?>
			</a>
		<?php endif; ?>
		<!-- /post thumbnail -->

		<!-- post title -->
		<h4>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h4>
		<!-- /post title -->

		<!-- post details -->
		<span class="date"><?php the_time( get_option( 'date_format' ) ); ?></span>

		<!-- /post details -->

		<?php knowledgebank_excerpt(); // Build your custom callback length in functions.php ?>

		<?php edit_post_link(); ?>

	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'knowledgebank' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
