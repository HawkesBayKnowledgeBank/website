<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="grid-container bottom_margin">
				<div class='grid-6'>
				<!-- post title -->

					<?php
						$file = get_field( 'audio' );
						if( !empty($file) ): ?>
							<h1>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h1>
							<audio controls>
								<source src="<?php echo $file['url']; ?>" type="<?php echo $file['mime_type']; ?>">
							</audio>
						<?php endif; ?>
				</div>

				<div class="grid-3">

					<h3>Collections</h3>

					<ul>
						<?php

							$collections = get_field( 'collections' );
							//print_r($collections);

							if( !empty($collections) ):
								foreach($collections as $collection): ?>

									<li><a href="<?php echo get_term_link($collection->term_id); ?>" class="term collection"><?php echo $collection->name; ?></a></li>

							<?php
								endforeach;
							endif;
						?>
					</ul>


					<h3>Tags</h3>

					<ul>
						<?php

							$tags = get_field( 'tags' );
							//print_r($tags);

							if( !empty($tags) ):
								foreach($tags as $tag): ?>

									<li><a href="<?php echo get_term_link($tag->term_id); ?>" class="term tag"><?php echo $tag->name; ?></a></li>

							<?php
								endforeach;
							endif;
						?>
					</ul>

					<h3>Subjects</h3>

					<?php

						$subjects = get_field('subjects');

						if( !empty($subjects) ): ?>

							<ul>

							<?php foreach( $subjects as $subject ): ?>

								<li><a href="<?php echo get_term_link($subject->term_id); ?>" class="term subject"><?php echo $subject->name; ?></a></li>

							<?php endforeach; ?>

						</ul>

					<?php endif; ?>
					<h3>Image</h3>

					<?php

						$image = get_field('image');

						if( !empty($image) ): ?>

							<ul>

							<p class="image-subjects-links">

								<?php get_field("image");?>
							</p>

						</ul>

					<?php endif; ?>
					<h3>Subjects</h3>

					<?php

						$people = get_field('people');

						if( !empty($people) ): ?>

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

					<?php $business = get_field('business');

						if( !empty($business) ): ?>

							<ul>

							<p class="image-subjects-links">

								<?php echo $business;?>
							</p>

						</ul>

					<?php endif; ?>
					<?php $author = get_field('author');

					if( !empty($author) ): ?>

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
					<?php $additional = get_field('additional');

						if( !empty($additional) ): ?>

							<ul>

							<p class="image-subjects-links">

								<?php echo $additional;?>
							</p>

						</ul>

					<?php endif; ?>
					<?php $languages = get_field('languages');

						if( !empty($languages) ): ?>

							<ul>

							<p class="image-subjects-links">

								<?php echo $languages;?>
							</p>

						</ul>

					<?php endif; ?>



				</div>

				<div class="grid-3">

					<?php

						$originalFormat = get_field( 'format_original' );

						if( !empty( $originalFormat ) ): ?>

							<h3>Original Format</h3><?php echo $originalFormat; ?>

						<?php endif;

					?>

					<?php

						$original_digital_file = get_field( 'master' );

						if( !empty($original_digital_file) ): ?>

							<h3>Original Digital File</h3><p><?php echo $original_digital_file['title']; ?></p>

						<?php endif;

					?>

					<?php

						$accessionNumber = get_field( 'accession_number' );

						if( !empty( $accessionNumber ) ): ?>

							<h3 class="Title_single">Accession Number</h3><?php echo $accessionNumber; ?>

						<?php endif;

					?>

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
