<?php get_header(); ?>

<main role="main">
	<!-- section -->
	<section>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="grid-container bottom_margin">
					<div class='grid-6'>
						<h2 class="Title_single"><?php the_title(); ?></h2>
						<div class="title_fields"><h3>Name:</h3></div>

						<?php if( have_rows( 'name' ) ): ?>
							<?php while( have_rows( 'name' ) ) : the_row();?>
								<!-- //vars -->
								<?php $first_name = get_sub_field( 'first_name' );
								$middle_names = get_sub_field( 'middle_names' );
								$family_name = get_sub_field( 'family_name' );
								?>
								<p class="image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?></p>


							<?php endwhile;?>
						<?php endif; ?>
						<?php $gender = get_field( 'gender' );?>

						<?php if( !empty( $gender ) ) : ?>

							<div class="title_fields"><h3>Gender :</h3></div>

							<p class="image-subjects-links">

								<?php if ($gender==false): ?>
									<?php echo "Male";?>
								<?php else: ?>
									<?php echo "Female";?>
								<?php endif; ?>

							</p>

						<?php endif; ?>


						<?php $known_as = get_field('known_as');?>
						<?php if($known_as): ?>
							<div class="title_fields"><h3>Known as:</h3></div>
							<p class="image-subjects-links"><?php echo $known_as; ?></p>
						<?php endif; ?>


						<?php $military_identification = get_field('military_identification');?>
						<?php if($military_identification): ?>
							<div class="title_fields"><h3>Military identification:</h3></div>
							<p class="image-subjects-links"><?php echo $military_identification; ?></p>
						<?php endif; ?>

					</div>
					<div class='grid-3'>
						<h2 class="Title_single">Birth :</h2>
						<div class="title_fields"><h3>Born:</h3></div><p class="image-subjects-links"><?php the_field( 'birthdate' ); ?></p>
						<?php $maiden_name = get_field( 'maiden_name' );?>

						<?php if( !empty( $maiden_name ) ) : ?>

							<div class="title_fields"><h3>Maiden name :</h3></div>

							<p class="image-subjects-links">

								<?php echo $maiden_name;?>
							</p>
							<?php $birthdate_accuracy = get_field( 'birthdate_accuracy' );?>

							<?php if( !empty( $birthdate_accuracy ) ) : ?>

								<p class="image-subjects-links">

									<?php echo $birthdate_accuracy;?>
								</p>

							<?php endif; ?>

						<?php endif; ?>
						<?php $birthplace = get_field( 'birthplace' );?>

						<?php if( !empty( $birthplace ) ) : ?>

							<div class="title_fields"><h3>Birthplace :</h3></div>

							<p class="image-subjects-links">

								<?php echo $birthplace;?>

							</p>

						<?php endif; ?>
						<?php $maiden_name = get_field( 'maiden_name' );?>

						<?php if( !empty( $maiden_name ) ) : ?>

							<div class="title_fields"><h3>Maiden name :</h3></div>

							<p class="image-subjects-links">

								<?php echo $maiden_name;?>
							</p>

						<?php endif; ?>



						<?php $marriage_date = get_field( 'marriage_date' );?>

						<?php if( !empty( $marriage_date ) ) : ?>

							<div class="title_fields"><h3>Marriage date :</h3></div>

							<p class="image-subjects-links">

								<?php echo "marriage_date";?>
							</p>

						<?php endif; ?>
						<?php $marriage_date_accuracy = get_field( 'marriage_date_accuracy' );?>
						<?php if( !empty( $marriage_date_accuracy) ) : ?>
							<div class="title_fields"><h3>Marriage date accuracy :</h3></div>
							<p class="image-subjects-links">
								<?php echo $marriage_date_accuracy;?>
							</p>

						<?php endif; ?>
						<?php $marriage_place = get_field( 'marriage_place' );?>
						<?php if( !empty( $marriage_place ) ) : ?>
							<div class="title_fields"><h3>Place of Marriage :</h3></div>
							<p class="image-subjects-links">
								<?php echo "marriage_place";?>
							</p>

						<?php endif; ?>
						<?php $deathdate = get_field( 'deathdate' );?>
						<?php if( !empty( $deathdate ) ) : ?>
							<div class="title_fields"><h3>Date of death :</h3></div>
							<p class="image-subjects-links">
								<?php echo $deathdate;?>
							</p>
						<?php endif; ?>
						<?php $deathdate_accuracy = get_field( 'deathdate_accuracy' );?>

						<?php if( !empty( $deathdate_accuracy ) ) : ?>

							<div class="title_fields"><h3>Death date accuracy :</h3></div>
							<p class="image-subjects-links">
								<?php echo "deathdate_accuracy";?>
							</p>

						<?php endif; ?>
						<?php $deathplace = get_field( 'deathplace' );?>

						<?php if( !empty( $deathplace ) ) : ?>

							<div class="title_fields"><h3>Place of death :</h3></div>
							<p class="image-subjects-links">
								<?php echo $deathplace
								;?>
							</p>

						<?php endif; ?>

					</div>
					<div class='grid-3'>
					<h2 class="Title_single">Family :</h2>
						<?php $parents = get_field( 'parents' );?>
						<?php if( !empty( $parents ) ) : ?>
							<div class="title_fields"><h3>Parents :</h3></div>

							<?php while( have_rows( 'parents' ) ) : the_row();?>

								<?php $first_name = get_sub_field( 'first_name' );
								$middle_names = get_sub_field( 'middle_names' );
								$family_name = get_sub_field( 'family_name' );?>

								<p class=" image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?></p>

							<?php endwhile;?>
						<?php endif; ?>
						<?php $parent_records = get_field( 'parent_records' );?>

						<?php if( !empty( $parent_records ) ) : ?>

							<div class="title_fields"><h3>Parent records :</h3></div>

							<p class="image-subjects-links">

								<?php get_field("parent_records");?>
							</p>

						<?php endif; ?>
						<?php $partner = get_field( 'partner' );?>

						<?php if( !empty( $partner ) ) : ?>

							<div class="title_fields"><h3>Partner(s) :</h3></div>
							<?php while( have_rows( 'partner' ) ) : the_row();?>

								<?php $first_name = get_sub_field( 'first_name' );
								$middle_names = get_sub_field( 'middle_names' );
								$family_name = get_sub_field( 'family_name' );?>
								<p class="partner image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?></p>

							<?php endwhile;?>
						<?php endif; ?>
						<?php $primary_education = get_field( 'primary_education' );?>

						<?php if( !empty( $primary_education ) ) : ?>

							<div class="title_fields"><h3>Primary education :</h3></div>

							<p class="image-subjects-links">

								<?php echo $primary_education;?>
							</p>

						<?php endif; ?>
						<?php $secondary_education = get_field( 'secondary_education' );?>

						<?php if( !empty( $secondary_education ) ) : ?>

							<div class="title_fields"><h3>Secondary education :</h3></div>

							<p class="image-subjects-links">

								<?php get_field("secondary_education");?>
							</p>

						<?php endif; ?>
						<?php $tertiary_education = get_field( 'tertiary_education' );?>

						<?php if( !empty( $tertiary_education ) ) : ?>

							<div class="title_fields"><h3>Tertiary education :</h3></div>

							<p class="image-subjects-links">

								<?php echo "tertiary_education";?>
							</p>

						<?php endif; ?>
						<?php $biography = get_field( 'biography' );?>

						<?php if( !empty( $biography ) ) : ?>

							<div class="title_fields"><h3>Biography :</h3></div>

							<div class="background_wysiwyg_colour">

								<?php echo $biography;?>
							
							</div>

						<?php endif; ?>
						<?php $related_records = get_field( 'related_records' );?>

						<!-- <?php if( !empty( $related_records ) ) : ?>
							<div class="title_fields"><h3>Related records :</h3></div>
							<p class="image-subjects-links">
								<?php print_r($related_records);?>
								<?php get_field("related_records");?>
							</p>
						<?php endif; ?> -->
						<?php $related_collections = get_field( 'related_collections' );?>
						<?php if( !empty( $related_collections ) ) : ?>
							<?php print_r($related_collections)?>


							<?php if( !empty($collections) ):?>
							<div class="title_fields"><h3>Related collections :</h3></div>
								<?php foreach($collections as $collection): ?>

									<li><a href="<?php echo get_term_link($collection->term_id); ?>" class="term collection"><?php echo $collection->name; ?></a></li>

							<?php
								endforeach;
							endif;?>
							<!-- <div class="title_fields"><h3>Related collections :</h3></div>
							<p class="image-subjects-links">
								<?php get_field("related_collections");?>
							</p> -->
						<?php endif; ?>
						<?php if( have_rows( 'children' ) ): ?>

							<div class="title_fields"><h3>Children:</h3></div>

							<?php while( have_rows( 'children' ) ) : the_row();?>
								<!-- //vars -->
								<?php $first_name = get_sub_field( 'first_name' );
								$middle_names = get_sub_field( 'middle_names' );
								$family_name = get_sub_field( 'family_name' );
								?>
								<p class="children image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?></p>
							<?php endwhile;?>
						<?php  endif; ?>
						<div class="title_fields"><h3>Related material:</h3></div><a class="image-subjects-links" href="#">Title of article</a>
						<!-- post thumbnail -->
							<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
									<?php the_post_thumbnail(); // Fullsize image for the single post ?>
								</a>
							<?php endif; ?>
					<!-- /post thumbnail -->
					</div>
				</div>
			</article>
		<?php endwhile; ?>
		<?php endif; ?>
	</section>
		<!-- /section -->
</main>


<?php get_footer(); ?>
