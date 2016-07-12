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
								$file = get_field('master');
								if( !empty( $file ) ): ?>
									<?php $explo=explode(".",$file['url']);?>
									<?php if( $explo[4]== "m4v" or $explo[4]== "mp4" ) :?>
										<video width="520" height="340" src="<?php echo $file['url']; ?>" controls oncontextmenu="return false">
											<?php if ( !empty( $video )) : ?>
												<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $video; ?>" frameborder="0" allowfullscreen></iframe>
											<?php endif; ?>
										</video>
									<?php elseif (!empty( $video )) : ?>
												<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $video; ?>" frameborder="0" allowfullscreen></iframe>
									<?php endif; ?>
								<?php elseif ( !empty( $video )) : ?>
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

									<div class="title_fields">

										<h3>Tags</h3>

									</div>

									<ul class="image-subjects-links">

										<?php foreach($tags as $tag): ?>

											<li><a href="<?php echo get_term_link($tag->term_id); ?>" class="term tag"><?php echo $tag->name; ?></a></li>

										<?php endforeach;?>

									</ul>

								<?php endif;?>

								<?php $subjects = get_field('subjects');?>

								<?php if( !empty($subjects) ): ?>

									<div class="title_fields">

										<h3>Subjects</h3>

									</div>

									<ul class="image-subjects-links ">

										<?php foreach( $subjects as $subject ): ?>

											<li><a href="<?php echo get_term_link($subject->term_id); ?>" class="term subject"><?php echo $subject->name; ?></a></li>

										<?php endforeach; ?>

									</ul>

								<?php endif; ?>

							</div>

						<div class="grid-3">

							<?php $format_original = get_field( 'format_original' );?>

							<?php if( !empty( $format_original ) ): ?>

								<div class="title_fields">

									<h3>Format of the original</h3>

								</div>

								<p class="image-subjects-links">

									<?php echo $format_original; ?>

								</p>

							<?php endif;?>
<!-- Original File -->

								<?php if( $file ): ?>
								<h3>Original Data File</h3><a href="<?php echo $file['url']; ?>"><?php echo $file['filename']; ?></a>
							<?php endif;?>
<!-- Accession number -->
								<?php $accession_number = get_field( 'accession_number' );?>
							<?php if( !empty( $accession_number ) ): ?>
								<div class="title_fields"><h3>Accession Number</h3></div>
								<p class="image-subjects-links"><?php echo $accession_number; ?></p>
							<?php endif;?>

								<?php //Cover image
								$image = get_field( 'image' );
								if( !empty( $image ) ): ?>
								<h3>Cover image</h3><?php get_field('image'); ?>
							<?php endif;?>

							<?php $people = get_field( 'people' );

						if( !empty($people) ) : ?>

								<h3>People</h3>

								<ul class="people_list background_wysywyg_colour">

								<?php foreach($people as $person) : ?>

									<li class="image-subjects-links">

										<span><?php echo $person['first_name']; ?></span>

										<span><?php echo $person['middle_names']; ?></span>

										<span><?php echo $person['family_name']; ?></span>

									</li>

								<?php endforeach;

								?></ul>

						<?php endif; ?>

						<?php $business = get_field('business');?>

						<?php if( !empty($business) ): ?>

							<div class="title_fields"><h3>Business / organisation name :</h3></div>

							<p class="image-subjects-links">

								<?php echo $business;?>

							</p>

						<?php endif; ?>

						<?php $author = get_field('author');?>
							<?php if( !empty($author) ): ?>
								<div class="title_fields"><h3>Creator / Author</h3></div>
								<ul class="image-subjects-links background_wysywyg_colour">
									<?php while( have_rows( 'author' ) ) : the_row();?>
										<!-- //vars -->
										<?php $first_name = get_sub_field( 'first_name' );
										$middle_names = get_sub_field( 'middle_names' );
										$family_name = get_sub_field( 'family_name' );
										?>
										<?php echo $first_name . " " . $middle_names . " " . $family_name; ?>
									<?php endwhile;?>
								</ul>
							<?php endif; ?>

						<?php $additional = get_field('additional');?>

						<?php if( !empty($additional) ): ?>

							<div class="title_fields"><h3>Additional Information</h3></div>

							<div class="background_wysywyg_colour">



								<?php echo $additional;?>
							</p>

						</div>

					<?php endif; ?>

					<?php $languages = get_field( 'languages' );?>

					<?php if( !empty( $languages ) ) : ?>

						<div class="title_fields"><h3>Languages :</h3></div>

						<p class="image-subjects-links">

							<?php echo $languages;?>
						</p>

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
