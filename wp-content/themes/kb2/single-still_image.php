<?php get_header(); ?>

<main role="main">
	<script>
	/* <![CDATA[ */
	/*
	|-----------------------------------------------------------------------
	|  jQuery Toggle Script by Matt - skyminds.net
	|-----------------------------------------------------------------------
	|
	| Affiche/cache le contenu d'un bloc une fois qu'un lien est cliqué.
	|
	*/

	// On attend que la page soit chargée
	jQuery(document).ready(function()
	{
	   // On cache la zone de texte
	   jQuery('#toggle').hide();
	   // toggle() lorsque le lien avec l'ID #toggler est cliqué
	   jQuery('a#toggler').click(function()
	  {
	      jQuery('#toggle').toggle(400);
	      return false;
	   });
	});
/* ]]> */
	</script>
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

					<h2 class="Title_single"><?php the_title(); ?></h2>

					<?php if( have_rows('images') ): ?>

						<?php while( have_rows('images') ): the_row();
						// vars

							$image = get_sub_field('image');

							?>

							<div class="imageWrap">

								<?php $images = get_field('images'); ?>

								<?php if(isset($images[0]['image']['sizes']['700w'])): ?>

									<a href="<?php the_permalink(); ?>?quickview=true" class="quick_view"><img src="<?php echo $images[0]['image']['sizes']['700w']; ?>" /></a>

								<?php endif; ?>

								<span class="quick_view"><a class="lightbox_icon quick_view" href="<?php the_permalink(); ?>?quickview=true"><img src="/wp-content/themes/kb2/img/search-white.png" alt="View" /></a></span>

							</div>

						<?php endwhile; ?>

					<?php endif; ?>
					<!--ORIGINAL INFORMATION
					\\====================================================//
					\\====================================================//
					-->

					<h2 class="Title_single">Original information :</h2>
					<?php $notes = get_field( 'notes' );?>


					<?php if( !empty( $notes ) ) : ?>
						<div class="image-subjects-links"><h3>Notes :</h3></div>
						<div class="background_wysywyg_colour">
							<?php echo $notes; ?>
						</div>
					<?php endif; ?>
					<!-- END ORIGINAL INFORMATION
					\\====================================================//
					\\====================================================//
					-->
					<!--ATTACHEMENTS
					\\====================================================//
					\\====================================================//
					-->

					<?php $file = get_field('master');?>
					<?php if( $file ): ?>
						<div class="LicenceBox">
							<div class="grid-container bottom_margin">
								<div class='grid-8'>
									<h3 class="image-subjects-links">Attachment</h3>
									<a href="<?php echo $file['url']; ?>" download="<?php echo $file['filename']; ?>"><?php echo $file['filename']; ?></a>
								</div>
								<div class='grid-4'>
									<h3 class="image-subjects-links">Size</h3>
									<?php $number=0;
									$number=($file['height']/1024);
									$number=number_format($number, 2, ',', ' ');?>
									<?php echo $number; ?> Mo
								</div>
							</div>
						</div>
					<?php endif; ?>
					<div class="LicenceBox">
						<div class="grid-container bottom_margin">
							<div class='grid-6'>
								<?php $licence = get_field( 'licence' );?>
								<?php if( !empty( $licence ) ) : ?>
										<?php if ($licence=="a-nc"): ?>
											<a class='NoCommercial' href="https://creativecommons.org/licenses/by-nc/4.0/"></a>
											<p>
												This work is licensed under a</p>
											<a href="http://creativecommons.org/licenses/by-nc/4.0/" rel="license"> Creative Commons Attribution-NonCommercial 4.0 International License</a>
										<?php endif; ?>
								<?php endif; ?>
							</div>
							<div class='grid-6'>
								<?php $allow_commercial_licence = get_field( 'allow_commercial_licence' );?>
								<?php if( !empty( $allow_commercial_licence ) ) : ?>
										<?php if ($allow_commercial_licence==true): ?>
											<a class='Copyright' href="https://www.paypal.com/cgi-bin/webscr"></a>
											<a href="/licensing">About commercial licensing.</a>
										<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<!--END ATTACHEMENTS
				y\\====================================================//
				\\====================================================//
				-->
				<div class="grid-6">
					<!--SUBJECTS
					\\====================================================//
					\\====================================================//
					-->
					<?php $subjects = get_field('subjects');?>
					<?php if( !empty($subjects) ): ?>
						<div class="title_fields"><h3>Subjects</h3></div>
						<ul class="image-subjects-links">
							<?php foreach( $subjects as $subject ): ?>
								<li><a href="<?php echo get_term_link($subject->term_id); ?>" class="term subject"><?php echo $subject->name; ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php $tags = get_field( 'tags' );?>
					<?php if( !empty($tags) ): ?>
						<div class="title_fields"><h3>Tags</h3></div>
						<ul class="image-subjects-links">
							<?php foreach($tags as $tag): ?>
								<li><a href="<?php echo get_term_link($tag->term_id); ?>" class="term tag"><?php echo $tag->name; ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php $people = get_field( 'people' );?>
					<?php if( !empty( $people ) ) : ?>
						<div class="title_fields"><h3>People :</h3></div>
						<p class="image-subjects-links">
							<?php the_field( $people ); ?>
						</p>
					<?php endif; ?>

					<?php $business = get_field( 'business' );?>
					<?php if( !empty( $business ) ) : ?>
						<div class="title_fields"><h3>Business :</h3></div>
						<p class="image-subjects-links">
							<?php echo $business; ?>
						</p>
					<?php endif; ?>
					<?php $location = get_field( 'location' );?>
					<?php if( !empty( $location )) : ?>
						<div class="title_fields"><h3>Location</h3></div>
						<p class="image-subjects-links">
							<?php echo $location; ?>
						</p>
					<?php endif; ?>
					<!--END SUBJECTS
					\\====================================================//
					\\====================================================//
					-->
					<!--ORIGINAL INFORMATION
					\\====================================================//
					\\====================================================//
					-->
					<?php $origianl_format = get_field( 'format_original' );?>
					<?php if( !empty( $origianl_format ) ): ?>
						<div class="title_fields"><h3>Format of the original:</h3></div>
						<p class="image-subjects-links">
							<?php the_field( 'format_original' ); ?>
						</p>
					<?php endif; ?>
					<?php $yearpublished = get_field( 'yearpublished' );?>
					<?php if( !empty( $yearpublished ) ) : ?>
						<div class="title_fields"><h3>Year published :</h3></div>
						<p class="image-subjects-links">
							<?php echo $yearpublished; ?>
						</p>
					<?php endif; ?>

					<?php $languages = get_field( 'languages' );?>
					<?php if( !empty( $languages ) ) : ?>
						<div class="title_fields"><h3>Languages :</h3></div>
						<p class="image-subjects-links">
							<?php echo $languages;?>
						</p>
					<?php endif; ?>
					<?php $accession_number = get_field( 'accession_number' );?>
					<?php if( !empty( $accession_number ) ) : ?>
						<div class="title_fields"><h3>Accession number</h3></div>
						<p class="image-subjects-links">
							<?php echo $accession_number; ?>
						</p>
					<?php endif; ?>
					<!--END ATTACHEMENTS
					\\====================================================//
					\\====================================================//
					-->
					<!--EXIF
					\\====================================================//
					\\====================================================//
					-->
					<?php $exif_model = get_field( 'exif_model' );?>
					<?php $computed_aperturefnumber = get_field( 'computed_aperturefnumber' );?>
					<?php $exif_compression = get_field( 'exif_compression' );?>
					<?php $exif_isospeedratings = get_field( 'exif_isospeedratings' );?>
					<?php $exif_focallenght = get_field( 'exif_focallenght' );?>
					<?php $gps_gpslatitude = get_field( 'gps_gpslatitude' );?>
					<?php $gps_gpslatituderef = get_field( 'gps_gpslatituderef' );?>
					<?php $gps_gpslongitude = get_field( 'gps_gpslongitude' );?>
					<?php $gps_gpslongituderef = get_field( 'gps_gpslongituderef' );?>

					<?php if (!empty($exif_model)or !empty($computed_aperturefnumber)or !empty($exif_isospeedratings)or !empty($exif_compression)or !empty($exif_focallenght)or !empty($gps_gpslatitude)or !empty($gps_gpslatituderef)or !empty($gps_gpslongitude)or !empty($gps_gpslongituderef)):?>
						<a href="#" id="toggler"><h2 class="Title_single">Image information</h2></a>
						<div id="toggle">
							<div id="id_du_div" >
								<?php if( !empty( $computed_aperturefnumber ) ) : ?>
									<div class="title_fields"><h3>Computed aperture :</h3></div>
									<p class="image-subjects-links">
										<?php echo $computed_aperturefnumber;?>
									</p>
								<?php endif; ?>
								<?php if( !empty( $exif_model ) ) : ?>
									<div class="title_fields"><h3>Exif model :</h3></div>
									<p class="image-subjects-links">
										<?php echo $exif_model;?>
									</p>
								<?php endif; ?>
								<?php if( !empty( $exif_compression ) ) : ?>
									<div class="title_fields"><h3>Exif compression :</h3></div>
									<p class="image-subjects-links">
										<?php echo $exif_compression;?>
									</p>
								<?php endif; ?>
								<?php if( !empty( $exif_isospeedratings ) ) : ?>
									<div class="title_fields"><h3>Exif ISO speed :</h3></div>
									<p class="image-subjects-links">
										<?php echo $exif_isospeedratings;?>
									</p>
								<?php endif; ?>
								<?php if( !empty( $exif_focallenght ) ) : ?>
									<div class="title_fields"><h3>Exif focal length :</h3></div>
									<p class="image-subjects-links">
										<?php echo $exif_focallenght;?>
									</p>
								<?php endif; ?>
								<?php if( !empty( $gps_gpslatitude ) ) : ?>
									<div class="title_fields"><h3>GPS latitude :</h3></div>
									<p class="image-subjects-links">
										<?php echo $gps_gpslatitude;?>
									</p>
								<?php endif; ?>
								<?php if( !empty( $gps_gpslatituderef ) ) : ?>
									<div class="title_fields"><h3>GPS latitude ref :</h3></div>
									<p class="image-subjects-links">
										<?php echo $gps_gpslatituderef;?>
									</p>
								<?php endif; ?>
								<?php if( !empty( $gps_gpslongitude ) ) : ?>
									<div class="title_fields"><h3>GPS longitude :</h3></div>
									<p class="image-subjects-links">
										<?php echo $gps_gpslongitude;?>
									</p>
								<?php endif; ?>
								<?php if( !empty( $gps_gpslongituderef ) ) : ?>
									<div class="title_fields"><h3>GPS longitude ref :</h3></div>
									<p class="image-subjects-links">
										<?php echo $gps_gpslongituderef;?>
									</p>
								<?php endif; ?>
							</div>
						</div>
					<?php endif;?>
					<!--END EXIF
					\\====================================================//
					\\====================================================//
					-->
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
