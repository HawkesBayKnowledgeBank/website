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

				<div class="title_fields"><h3>Collections</h3></div>

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

				<div class="title_fields"><h3>Tags</h3></div>

				<ul class="image-subjects-links">

					<?php foreach($tags as $tag): ?>

						<li><a href="<?php echo get_term_link($tag->term_id); ?>" class="term tag"><?php echo $tag->name; ?></a></li>

					<?php endforeach; ?>

				</ul>

			<?php endif; ?>

		<?php

		$subjects = get_field('subjects');

		if( !empty($subjects) ): ?>

		<div class="title_fields"><h3>Subjects</h3></div>

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

	<div class="title_fields"><h3>Format of the original:</h3></div>

	<p class="image-subjects-links">

		<?php the_field( 'format_original' ); ?>

	</p>

<?php endif; ?>

<?php $location = get_field( 'location' );?>

<?php if( !empty( $location )) : ?>

	<div class="title_fields"><h3>Location</h3></div>

	<p class="image-subjects-links">

		<?php echo $location; ?>

	</p>

<?php endif; ?>

<?php

$file = get_field('master');?>

<?php if( $file ): ?>

	<h3 class="image-subjects-links">Original Data File</h3></div>

	<a href="<?php echo $file['url']; ?>"><?php echo $file['filename']; ?></a>

<?php endif; ?>

<?php $accession_number = get_field( 'accession_number' );?>

<?php if( !empty( $accession_number ) ) : ?>

	<div class="title_fields"><h3>Accession number</h3></div>

	<p class="image-subjects-links">

		<?php the_field( 'accession_number' ); ?>
	</p>

<?php endif; ?>

<?php $licence = get_field( 'licence' );?>

<?php if( !empty( $licence ) ) : ?>

	<div class="title_fields"><h3>licence :</h3></div>

	<p class="image-subjects-links">

		<?php the_field( 'licence' ); ?>
	</p>

<?php endif; ?>

<?php $allow_commercial_licence = get_field( 'allow_commercial_licence' );?>

<?php if( !empty( $allow_commercial_licence ) ) : ?>

	<div class="title_fields"><h3>Allow commercial licence :</h3></div>

	<p class="image-subjects-links">

		<?php the_field( 'allow_commercial_licence' ); ?>
	</p>

<?php endif; ?>

<?php $people = get_field( 'people' );?>

<?php if( !empty( $people ) ) : ?>

	<div class="title_fields"><h3>People :</h3></div>

	<p class="image-subjects-links">

		<?php the_field( 'people' ); ?>
	</p>

<?php endif; ?>

<?php $business = get_field( 'business' );?>

<?php if( !empty( $business ) ) : ?>

	<div class="title_fields"><h3>Business :</h3></div>

	<p class="image-subjects-links">

		<?php echo "business"; ?>
	</p>

<?php endif; ?>

<?php $yearpublished = get_field( 'yearpublished' );?>

<?php if( !empty( $yearpublished ) ) : ?>

	<div class="title_fields"><h3>Year published :</h3></div>

	<p class="image-subjects-links">

		<?php echo "yearpublished"; ?>
	</p>

<?php endif; ?>
<?php $notes = get_field( 'notes' );?>

<?php if( !empty( $notes ) ) : ?>

	<div class="title_fields"><h3>Notes :</h3></div>

	<p class="image-subjects-links">

		<?php get_field('notes'); ?>
	</p>

<?php endif; ?>
<?php $languages = get_field( 'languages' );?>

<?php if( !empty( $languages ) ) : ?>

	<div class="title_fields"><h3>Languages :</h3></div>

	<p class="image-subjects-links">

		<?php echo "languages";?>
	</p>

<?php endif; ?>

<?php $computed_aperturefnumber = get_field( 'computed_aperturefnumber' );?>

<?php if( !empty( $computed_aperturefnumber ) ) : ?>

	<div class="title_fields"><h3>Computed aperture :</h3></div>

	<p class="image-subjects-links">

		<?php echo "computed_aperturefnumber";?>
	</p>

<?php endif; ?>
<?php $exif_model = get_field( 'exif_model' );?>

<?php if( !empty( $exif_model ) ) : ?>

	<div class="title_fields"><h3>Exif model :</h3></div>

	<p class="image-subjects-links">

		<?php echo "exif_model";?>
	</p>

<?php endif; ?>
<?php $exif_compression = get_field( 'exif_compression' );?>

<?php if( !empty( $exif_compression ) ) : ?>

	<div class="title_fields"><h3>Exif compression :</h3></div>

	<p class="image-subjects-links">

		<?php echo "exif_compression";?>
	</p>

<?php endif; ?>
<?php $exif_isospeedratings = get_field( 'exif_isospeedratings' );?>

<?php if( !empty( $exif_isospeedratings ) ) : ?>

	<div class="title_fields"><h3>Exif ISO speed :</h3></div>

	<p class="image-subjects-links">

		<?php echo "exif_isospeedratings";?>
	</p>

<?php endif; ?>

<?php $exif_focallenght = get_field( 'exif_focallenght' );?>

<?php if( !empty( $exif_focallenght ) ) : ?>

	<div class="title_fields"><h3>Exif focal length :</h3></div>

	<p class="image-subjects-links">

		<?php echo "exif_focallenght";?>
	</p>

<?php endif; ?>

<?php $gps_gpslatitude = get_field( 'gps_gpslatitude' );?>

<?php if( !empty( $gps_gpslatitude ) ) : ?>

	<div class="title_fields"><h3>GPS latitude :</h3></div>

	<p class="image-subjects-links">

		<?php echo "gps_gpslatitude";?>
	</p>

<?php endif; ?>
<?php $gps_gpslatituderef = get_field( 'gps_gpslatituderef' );?>

<?php if( !empty( $gps_gpslatituderef ) ) : ?>

	<div class="title_fields"><h3>GPS latitude ref :</h3></div>

	<p class="image-subjects-links">

		<?php echo "gps_gpslatituderef";?>
	</p>

<?php endif; ?>
<?php $gps_gpslongitude = get_field( 'gps_gpslongitude' );?>

<?php if( !empty( $gps_gpslongitude ) ) : ?>

	<div class="title_fields"><h3>GPS longitude :</h3></div>

	<p class="image-subjects-links">

		<?php echo "gps_gpslongitude";?>
	</p>

<?php endif; ?>
<?php $gps_gpslongituderef = get_field( 'gps_gpslongituderef' );?>

<?php if( !empty( $gps_gpslongituderef ) ) : ?>

	<div class="title_fields"><h3>GPS longitude ref :</h3></div>

	<p class="image-subjects-links">

		<?php echo "gps_gpslongituderef";?>
	</p>

<?php endif; ?>
<?php $gps_gpslatitude = get_field( 'gps_gpslatitude' );?>

<?php if( !empty( $gps_gpslatitude ) ) : ?>

	<div class="title_fields"><h3>GPS latitude :</h3></div>

	<p class="image-subjects-links">

		<?php echo "gps_gpslatitude";?>
	</p>

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
