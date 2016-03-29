<?php get_header(); ?>

	<main role="main">
		<!-- section -->
			<section>

			<?php if (have_posts()): 

				while (have_posts()) : the_post(); ?>

					<!-- article -->
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="grid-container">
							<div class='grid-6'>
								<!-- post title -->
								<h1><?php the_title(); ?></h1>
								<!-- /post title -->
								<?php 
									$video = get_field( 'youtube_id' ); //Make a youtube embed
									//print_r($video);
									if( !empty( $video ) ): ?>
										<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $video; ?>" frameborder="0" allowfullscreen></iframe>
									<!-- post thumbnail -->
									<?php elseif ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> -->
											<?php the_post_thumbnail(); // Fullsize image for the single post ?>
										</a>
									<?php endif; 
								?>
									<!-- /post thumbnail -->

							</div>
							<div class="grid-3">
								
								<?php //Collections
									$collections = get_field( 'collections' );
									//print_r($collections);
									if( !empty( $collections ) ): ?>
										<h3>Collections</h3>
										<ul>
											<?php foreach( $collections as $collection ): ?>
												<li><?php echo $collection->name; ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif;
								?>

								<?php
									$tags = get_field( 'tags' );
									print_r($tags);
									if( !empty($tags) ): ?>
									<h3>Tags</h3>
									<ul>
										<?php foreach ($tags as $tag): ?>
											<li><?php echo $tag->name; ?></li>
										<?php endforeach; ?>
									</ul>
									<?php endif;
								?>

								<?php //Subjects
									$subjects = get_field( 'subjects' );
									//print_r($subjects);
									if( !empty( $subjects ) ): ?>
									<h3>Subjects</h3>
									<ul>
										<?php foreach ( $subjects as $subject ): ?> 
											<li><?php echo $subject->name; ?></li>
										<?php endforeach; ?>
									</ul>
									<?php endif;
								?>


							</div>
							<div class="grid-3">

								<?php
									$originalFormat = get_field( 'format_original' );
									//print_r($originalFormat);
									if( !empty($originalFormat) ): ?>
										<h3>Original Format</h3>
										<?php echo $originalFormat; ?>
									<?php endif; 
								?>

								<?php //Original File
									$file = get_field('master');
									if( $file ): ?>	
										<h3>Original Data File</h3><a href="<?php echo $file['url']; ?>"><?php echo $file['filename']; ?></a>
									<?php endif; 
								?>

								<?php //Accession number
									$accessionNumber = get_field( 'accession_number' );
									if( !empty( $accessionNumber ) ): ?>
										<h3>Accession Number</h3><?php echo $accessionNumber; ?>
									<?php endif;
								?>

							</div>

						</div>

						

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

					</article>
					<!-- /article -->

				<?php endwhile; ?>

			<?php endif; ?>

			</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
