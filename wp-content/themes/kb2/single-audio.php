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
						<?php $file = get_field( 'audio' );?>
							<?php if( !empty($file) ): ?>
								<h1>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h1>
								<audio controls>
									<source src="<?php echo $file['url']; ?>" type="<?php echo $file['mime_type']; ?>">
								</audio>
							<?php endif; ?>
							<?php $additional = get_field('additional');?>
							<?php if( !empty($additional) ): ?>
								<div class="title_fields"><h3>Notes</h3></div>
									<div class="image-subjects-links">
										<?php echo $additional;?>
									</div>
							<?php endif; ?>
							<?php $file = get_field('master');?>
							<?php if( $file ): ?>
								<div class="LicenceBox">
									<div class="grid-container bottom_margin">
										<div class='grid-8'>
											<h3 class="image-subjects-links">Attachment</h3>
											<a href="<?php echo $file['url']; ?>" download="<?php echo $file['filename']; ?>"><?php echo $file['filename']; ?></a>
										</div>

										<div class='grid-4'>
											<?php $NameFile="";
											$NameFile=$file['name'];?>
											<h3 class="image-subjects-links">Size</h3>
										<!-- 	<?php echo filesize($NameFile); ?> Mo -->
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<div class="grid-3">
							<?php $collections = get_field( 'collections' );?>
							<?php if( !empty($collections) ): ?>
								<div class="title_fields"><h3>Collections</h3></div>
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
							<?php $subjects = get_field('subjects');?>
							<?php if( !empty($subjects) ): ?>
								<div class="title_fields"><h3>Subjects</h3></div>
								<ul class="image-subjects-links">
									<?php foreach( $subjects as $subject ): ?>
										<li><a href="<?php echo get_term_link($subject->term_id); ?>" class="term subject"><?php echo $subject->name; ?></a></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
							<?php $image = get_field('image');?>
							<?php if( !empty($image) ): ?>
								<div class="title_fields"><h3>Image</h3></div>
									<?php print_r($image);?>
									<?php the_field("image");?>
							<?php endif; ?>
							<?php $people = get_field('people');?>
							<?php if( !empty($people) ): ?>
								<div class="title_fields"><h3>People</h3></div>
								<ul class="image-subjects-links">
									<?php while( have_rows( 'people' ) ) : the_row();?>
										<!-- //vars -->
										<?php $first_name = get_sub_field( 'first_name' );
										$middle_names = get_sub_field( 'middle_names' );
										$family_name = get_sub_field( 'family_name' );
										?>
										<?php echo $first_name . " " . $middle_names . " " . $family_name; ?>
									<?php endwhile;?>
								</ul>
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
								<ul class="image-subjects-links">
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
							<?php $languages = get_field('languages');?>
							<?php if( !empty($languages) ): ?>
								<div class="title_fields"><h3>Language(s)</h3></div>
								<p class="image-subjects-links">
									<?php echo $languages;?>
								</p>
							<?php endif; ?>
						</div>
						<div class="grid-3">
							<?php $format_original = get_field( 'format_original' );?>
							<?php if( !empty( $format_original ) ): ?>
								<div class="title_fields"><h3>Format of the original</h3></div>
								<p class="image-subjects-links">
									<?php echo $format_original; ?>
								</p>
							<?php endif;?>
							<?php $accession_number = get_field( 'accession_number' );?>
							<?php if( !empty( $accession_number ) ): ?>
								<div class="title_fields"><h3>Accession Number</h3></div>
								<p class="image-subjects-links"><?php echo $accession_number; ?></p>
							<?php endif;?>
						</div>
					</div>
						<!-- post thumbnail -->
					<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail(); // Fullsize image for the single post ?>
						</a>
					<?php endif; ?>
			<!-- /post thumbnail -->

				<div class="grid-container">

					<div class="grid-6">

						<?php get_template_part('part','field-master'); ?>

					</div>
					<div class="grid-6">
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
