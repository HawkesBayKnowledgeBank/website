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
						
						<div id="cache"></div>
						<a href="#cache"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>"></a>
						<div class="popup"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>"><a href="#">X</a></div>

						<!-- <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" /> -->
						
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

					<?php $licence = get_field( 'licence' );

					if( !empty( $licence ) ) : ?>
					
						<h3>licence :</h3>

						<p class="image-subjects-links">

							<?php the_field( 'licence' ); ?>
						<p>

					<?php endif; ?>

					<?php $allow_commercial_licence = get_field( 'allow_commercial_licence' );

					if( !empty( $allow_commercial_licence ) ) : ?>
					
						<h3>Allow commercial licence :</h3>

						<p class="image-subjects-links">

							<?php the_field( 'allow_commercial_licence' ); ?>
						<p>

					<?php endif; ?>

					<?php $people = get_field( 'people' );

					if( !empty( $people ) ) : ?>
					
						<h3>People :</h3>

						<p class="image-subjects-links">

							<?php the_field( 'people' ); ?>
						<p>

					<?php endif; ?>

					<?php $business = get_field( 'business' );

					if( !empty( $business ) ) : ?>
					
						<h3>Business :</h3>

						<p class="image-subjects-links">

							<?php echo "business"; ?>
						<p>

					<?php endif; ?>

					<?php $yearpublished = get_field( 'yearpublished' );

					if( !empty( $yearpublished ) ) : ?>
					
						<h3>Year published :</h3>

						<p class="image-subjects-links">

							<?php echo "yearpublished"; ?>
						<p>

					<?php endif; ?>
					<?php $notes = get_field( 'notes' );

					if( !empty( $notes ) ) : ?>
					
						<h3>Notes :</h3>

						<p class="image-subjects-links">

							<?php get_field('notes'); ?>
						<p>

					<?php endif; ?>
					<?php $languages = get_field( 'languages' );

					if( !empty( $languages ) ) : ?>
					
						<h3>Languages :</h3>

						<p class="image-subjects-links">

							<?php echo "languages";?>
						<p>

					<?php endif; ?>

					<?php $computed_aperturefnumber = get_field( 'computed_aperturefnumber' );

					if( !empty( $computed_aperturefnumber ) ) : ?>
					
						<h3>Computed aperture :</h3>

						<p class="image-subjects-links">

							<?php echo "computed_aperturefnumber";?>
						<p>

					<?php endif; ?>
					<?php $exif_model = get_field( 'exif_model' );

					if( !empty( $exif_model ) ) : ?>
					
						<h3>Exif model :</h3>

						<p class="image-subjects-links">

							<?php echo "exif_model";?>
						<p>

					<?php endif; ?>
					<?php $exif_compression = get_field( 'exif_compression' );

					if( !empty( $exif_compression ) ) : ?>
					
						<h3>Exif compression :</h3>

						<p class="image-subjects-links">

							<?php echo "exif_compression";?>
						<p>

					<?php endif; ?>
					<?php $exif_isospeedratings = get_field( 'exif_isospeedratings' );

					if( !empty( $exif_isospeedratings ) ) : ?>
					
						<h3>Exif ISO speed :</h3>

						<p class="image-subjects-links">

							<?php echo "exif_isospeedratings";?>
						<p>

					<?php endif; ?>

					<?php $exif_focallenght = get_field( 'exif_focallenght' );

					if( !empty( $exif_focallenght ) ) : ?>
					
						<h3>Exif focal length :</h3>

						<p class="image-subjects-links">

							<?php echo "exif_focallenght";?>
						<p>

					<?php endif; ?>

					<?php $gps_gpslatitude = get_field( 'gps_gpslatitude' );

					if( !empty( $gps_gpslatitude ) ) : ?>
					
						<h3>GPS latitude :</h3>

						<p class="image-subjects-links">

							<?php echo "gps_gpslatitude";?>
						<p>

					<?php endif; ?>
					<?php $gps_gpslatituderef = get_field( 'gps_gpslatituderef' );

					if( !empty( $gps_gpslatituderef ) ) : ?>
					
						<h3>GPS latitude ref :</h3>

						<p class="image-subjects-links">

							<?php echo "gps_gpslatituderef";?>
						<p>

					<?php endif; ?>
					<?php $gps_gpslongitude = get_field( 'gps_gpslongitude' );

					if( !empty( $gps_gpslongitude ) ) : ?>
					
						<h3>GPS longitude :</h3>

						<p class="image-subjects-links">

							<?php echo "gps_gpslongitude";?>
						<p>

					<?php endif; ?>
					<?php $gps_gpslongituderef = get_field( 'gps_gpslongituderef' );

					if( !empty( $gps_gpslongituderef ) ) : ?>
					
						<h3>GPS longitude ref :</h3>

						<p class="image-subjects-links">

							<?php echo "gps_gpslongituderef";?>
						<p>

					<?php endif; ?>
					<?php $gps_gpslatitude = get_field( 'gps_gpslatitude' );

					if( !empty( $gps_gpslatitude ) ) : ?>
					
						<h3>GPS latitude :</h3>

						<p class="image-subjects-links">

							<?php echo "gps_gpslatitude";?>
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
