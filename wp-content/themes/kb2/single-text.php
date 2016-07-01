<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="grid-container bottom_margin">
				
				<div class="grid-6">
					
					<!-- post title -->
					<?php $images = get_field('images'); ?>

					<?php if($images && count($images) > 1): ?>

						<?php get_template_part('part','text-slider'); ?>

					<?php else: ?>

						<?php if(isset($images[0]['image']['sizes']['700w'])): ?>

							<img src="<?php echo $images[0]['image']['sizes']['700w']; ?>" />

						<?php endif; ?>

					<?php endif; ?>

					<div class="grid-6">

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
					
						<?php endif; ?>
					
					<?php
						
					$publication_year = get_field('yearpublished');

					if(!empty($publication_year)): ?>
						
						<h3>Publication Date:</h3>

						<p class="image-subjects-links"><?php echo $publication_year; ?></p>
					
					<?php endif; ?>

					<?php 
						
						$originalFormat = get_field( 'format_original' );
						
						if( !empty( $originalFormat ) ): ?>
							
							<h3>Original Format</h3><p class="image-subjects-links"><?php echo $originalFormat; ?></p>
						
						<?php endif; ?> 

					<?php 
						
						$accessionNumber = get_field( 'accession_number' );
						
						if( !empty( $accessionNumber ) ): ?>
							
							<h3>Accession Number</h3><p class="image-subjects-links"><?php echo $accessionNumber; ?></p>
						
						<?php endif; ?>


	
				</div>
					
				</div>
					
				<div class="grid-6 transcript">

					<?php 

							$transcript = get_field( 'transcript' ); 

							//print_r($transcript);

							if( !empty($transcript) ) : ?>

								<h3>Transcript</h3><?php echo $transcript; ?>

							<?php endif;
						?>
						
					
				
				</div>
					
				

				<div class="grid-6">

					

				</div>
			
			</div>
	
	<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail(); // Fullsize image for the single post ?>
				</a>
			<?php endif; ?>
			<!-- /post thumbnail -->

			
			<?php /*
			<!-- post details -->
			<span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
			<span class="author"><?php _e( 'Published by', 'kb2' ); ?> <?php the_author_posts_link(); ?></span>
			<span class="comments"><?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'kb2' ), __( '1 Comment', 'kb2' ), __( '% Comments', 'kb2' )); ?></span>
			<!-- /post details -->

			<?php the_content(); // Dynamic Content ?>

			<?php the_tags( __( 'Tags: ', 'kb2' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

			<p><?php _e( 'Categorised in: ', 'kb2' ); the_category(', '); // Separated by commas ?></p>

			<p><?php _e( 'This post was written by ', 'kb2' ); the_author(); ?></p>

			<?php edit_post_link(); // Always handy to have Edit Post Links available ?>

			<?php comments_template(); ?>

			*/ ?>

		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>



<?php get_footer(); ?>
