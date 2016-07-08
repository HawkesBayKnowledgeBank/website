<?php get_header(); ?>

<main role="main">
	<!-- section -->
	<section>

		<?php if (have_posts()):

		while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="grid-container bottom_margin">
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

								<?php $collections = get_field( 'collections' );?>
									
								<?php if( !empty($collections) ): ?>
									
									<div class="title_fields">

										<h3>Collections</h3>

									</div>
							
									<ul class="image-subjects-links">
										
										<?php foreach($collections as $collection): ?>
								
											<li><a href="<?php echo get_term_link($collection->term_id); ?>" class="term collection"><?php echo $collection->name; ?></a></li>
							
										<?php endforeach; ?>
									
									</ul>
									
									<?php endif; ?>

							<?php $tags = get_field( 'tags' );?>
							<?php if( !empty($tags) ):?>
								<div class="title_fields"><h3>Tags</h3></div>
								<ul class="image-subjects-links">
									<?php foreach($tags as $tag): ?>
										<li><a href="<?php echo get_term_link($tag->term_id); ?>" class="term tag"><?php echo $tag->name; ?></a></li>
									<?php endforeach;?>
								</ul>
							<?php endif;?>

								<?php //Subjects
								$subjects = get_field( 'subjects' );
									//print_r($subjects);
								if( !empty( $subjects ) ): ?>
								<h3>Subjects</h3>
								<ul>
									<?php foreach ( $subjects as $subject ): ?>
										<li><a href="<?php echo get_term_link($subject->term_id); ?>" class="term subject"><?php echo $subject->name; ?></a></li>
									<?php endforeach; ?>
								</ul>
							<?php endif;
							?>


						</div>
						<div class="grid-3">

							<?php $originalFormat = get_field( 'format_original' );?>

							<?php if( !empty($originalFormat) ): ?>
								<h3>Original Format</h3>
								<?php echo $originalFormat; ?>
							<?php endif;?>
<!-- Original File -->
								<?php $file = get_field('master');?>
								<?php if( $file ): ?>
								<h3>Original Data File</h3><a href="<?php echo $file['url']; ?>"><?php echo $file['filename']; ?></a>
							<?php endif;?>
<!-- Accession number -->
								<?php $accessionNumber = get_field( 'accession_number' );?>
								<?php if( !empty( $accessionNumber ) ): ?>
									<h3>Accession Number</h3><?php echo $accessionNumber; ?>
							<?php endif;?>

								<?php //Cover image
								$image = get_field( 'image' );
								if( !empty( $image ) ): ?>
								<h3>Cover image</h3><?php get_field('image'); ?>
							<?php endif;?>
							<?php $people = get_field('people');?>

							<?php if( !empty($people) ): ?>

							<ul>
								<?php while( have_rows( 'people' ) ) : the_row();?>
									<!-- //vars -->
									<?php $first_name = get_sub_field( 'first_name' );
									$middle_names = get_sub_field( 'middle_names' );
									$family_name = get_sub_field( 'family_name' );
									?>
									<p class="image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?></p>


								<?php endwhile;?>

							</ul>

						<?php endif; ?>
						<?php $business = get_field('business');?>

						<?php if( !empty($business) ): ?>

							<ul>

							<p class="image-subjects-links">

								<?php echo $business;?>
							</p>

						</ul>

					<?php endif; ?>
					<?php $author = get_field('author');?>


							<?php if( !empty($author) ): ?>

							<ul>
								<?php while( have_rows( 'author' ) ) : the_row();?>
									<!-- //vars -->
									<?php $first_name = get_sub_field( 'first_name' );
									$middle_names = get_sub_field( 'middle_names' );
									$family_name = get_sub_field( 'family_name' );
									?>
									<p class="image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?></p>


								<?php endwhile;?>

							</ul>

						<?php endif; ?>
						
						<?php $additional = get_field('additional');?>

						<?php if( !empty($additional) ): ?>

							<ul>

							<p class="image-subjects-links">

								<?php echo $additional;?>
							</p>

						</ul>

					<?php endif; ?>
					
					<?php $languages = get_field('languages');?>

						<?php if( !empty($languages) ): ?>

							<ul>

							<p class="image-subjects-links">

								<?php echo $languages;?>
							</p>

						</ul>

					<?php endif; ?>


					</div>

				</div>



			</article>
			<!-- /article -->

		<?php endwhile; ?>

	<?php endif; ?>

</section>
<!-- /section -->
</main>

<?php get_footer(); ?>
