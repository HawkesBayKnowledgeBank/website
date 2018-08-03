<?php get_header(); ?>

	<div class="grid-container">		

			<h1><?php echo sprintf( __( '%s Search Results for ', 'kb2' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>

			 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


			 	<div class="grid-12 searchResult">
			 	
			 		<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

				 	<small><?php echo kb_nicename($post->post_type); ?></small>

				</div>

			 <?php endwhile; else : ?>


			 	<!-- The very first "if" tested to see if there were any Posts to -->
			 	<!-- display.  This "else" part tells what do if there weren't any. -->
			 	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>


			 	<!-- REALLY stop The Loop. -->
			 <?php endif; ?>

			<?php get_template_part('pagination'); ?>

	</div>



<?php get_footer(); ?>
