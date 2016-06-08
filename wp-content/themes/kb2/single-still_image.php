<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<!-- In the page-still_image.php, we get out posts by using an $args array with 'post_type' as 
	an argument. Not entirely sure whether we want to do the same here, or whether WP will
	know the post_type, from the naming convention of the template, i.e. single-still_image. -->
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="grid-container bottom_margin">
				
				<div class='grid-6'>
					
					<h2><?php the_title(); ?></h2>
					
					<?php if( have_rows('images') ): ?>
						
						<?php while( have_rows('images') ): the_row(); 
						// vars
							
							$image = get_sub_field('image');
						
						?>
						
						<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
						
						<?php endwhile; ?>
					
					<?php endif; ?>
				
				
				</div>

				<div class="grid-3">
					
					<?php 
						
					$collections = get_field( 'collections' ); 
					//print_r($collections); 

					if( !empty($collections) ): ?>

						<h3>Collections</h3>

						<ul class="image-subjects-links">
						
							<?php foreach($collections as $collection): ?>

								<li><a href="<?php echo get_term_link($collection->term_id); ?>" class="term collection"><?php echo $collection->name; ?></a></li>

							<?php endforeach; ?>

						</ul>
					
					<?php endif; ?>
					
					<?php 
						
					$tags = get_field( 'tags' ); 
					//print_r($tags); 

					if( !empty($tags) ): ?>

						<h3>Tags</h3>
			
						<ul class="image-subjects-links">
						
							<?php foreach($tags as $tag): ?>

								<li><a href="<?php echo get_term_link($tag->term_id); ?>" class="term tag"><?php echo $tag->name; ?></a></li>

							<?php endforeach; ?>

						</ul>

					<?php endif; ?>
					
					<?php
					
					$subjects = get_field('subjects');
						
					if( !empty($subjects) ): ?>

						<h3>Subjects</h3>
						
						<ul class="image-subjects-links">
						
							<?php foreach( $subjects as $subject ): ?>
								
								<li><a href="<?php echo get_term_link($subject->term_id); ?>" class="term subject"><?php echo $subject->name; ?></a></li>
							
							<?php endforeach; ?>
					
						</ul>
				
					<?php endif; ?>
					
				</div>
				
				<div class="grid-3">

					<?php $origianl_format = get_field( 'format_original' );

					if( !empty( $origianl_format ) ): ?>
					
						<h3>Format of the original:</h3>

						<p class="image-subjects-links">

							<?php the_field( 'format_original' ); ?>

						</p>

					<?php endif; ?>
					
					<?php $location = get_field( 'location' );

					if( !empty( $location )) : ?>

						<h3>Location</h3>

						<p class="image-subjects-links">

							<?php echo $location; ?>

						</p>

					<?php endif; ?>
					
					<?php 
						
					$file = get_field('master');
						
					if( $file ): ?>	
			
						<h3 class="image-subjects-links">Original Data File</h3>

						<a href="<?php echo $file['url']; ?>"><?php echo $file['filename']; ?></a>
					
					<?php endif; ?>

					<?php $accession_number = get_field( 'accession_number' );

					if( !empty( $accession_number ) ) : ?>
					
						<h3>Accession number</h3>

						<p class="image-subjects-links">

							<?php the_field( 'accession_number' ); ?>
						<p>

					<?php endif; ?>
				
				</div>
			
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
