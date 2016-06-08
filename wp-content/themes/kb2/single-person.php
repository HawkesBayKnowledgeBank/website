<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="grid-container bottom_margin">
				<div class='grid-6'>
					<h2><?php the_title(); ?></h2>
					<h3>Name:</h3>
					
						<?php if( have_rows( 'name' ) ): ?>
							<?php while( have_rows( 'name' ) ) : the_row();
								//vars 
								$first_name = get_sub_field( 'first_name' );
								$middle_names = get_sub_field( 'middle_names' );
								$family_name = get_sub_field( 'family_name' );
							?>
							<p class="image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?></p>
						<?php endwhile; endif; ?>
					
					
					<?php $known_as = get_field('known_as');
					if($known_as): ?>
						<h3>Known as:</h3>
						<p class="image-subjects-links"><?php echo $known_as; ?></p>
					<?php endif; ?>
					
					
					<?php $military_identification = get_field('military_identification');
					if($military_identification): ?>
						<h3>Military identification:</h3> 
						<p class="image-subjects-links"><?php echo $military_identification; ?></p>
					<?php endif; ?>
				</div>

				<div class='grid-6'>
					
					<h3>Born:</h3><p class="image-subjects-links"><?php the_field( 'birthdate' ); ?></p>
					
				</div>
					
				<div class='grid-6'>
					
					<?php if( have_rows( 'children' ) ): ?>
						
						<h3>Children:</h3>
						
						<?php while( have_rows( 'children' ) ) : the_row();
							//vars 
							$first_name = get_sub_field( 'first_name' );
							$middle_names = get_sub_field( 'middle_names' );
							$family_name = get_sub_field( 'family_name' );
						?>
						
						<p class="children image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?></p>
					
					<?php endwhile; endif; ?>
				
				</div>
					<h3>Related material:</h1><a class="image-subjects-links" href="#">Title of article</a>
				
			</div>	

			<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail(); // Fullsize image for the single post ?>
				</a>
			<?php endif; ?>
			<!-- /post thumbnail -->


		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php endif; ?>


	</section>
	<!-- /section -->
	</main>


<?php get_footer(); ?>
