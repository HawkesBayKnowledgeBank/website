<?php get_header(); ?>

<main role="main">
	<!-- section -->
	<section>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="grid-container bottom_margin">
					<div class='grid-6'>
						<!-- NAME AND DETAILS
						\\====================================================//
						\\====================================================//
						-->
						<h2 class="Title_single"><?php the_title(); ?></h2>
						<?php if( have_rows('images') ): ?>
							<?php while( have_rows('images') ): the_row();
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
								<?php print_r($gender)?>
							</p>
						<?php endif; ?>
						<?php $maiden_name = get_field( 'maiden_name' );?>
						<?php if( !empty( $maiden_name ) ) : ?>
							<div class="title_fields"><h3>Maiden name :</h3></div>
							<p class="image-subjects-links">
								<?php echo $maiden_name;?>
							</p>
						<?php endif; ?>
						<?php $biography = get_field( 'biography' );?>
						<?php if( !empty( $biography ) ) : ?>
							<div class="title_fields"><h3>Biography :</h3></div>
							<div class="background_wysywyg_colour"><?php echo $biography; ?></div>
						<?php endif; ?>
						<?php $known_as = get_field('known_as');?>
						<?php if($known_as): ?>
							<div class="title_fields"><h3>Known as:</h3></div>
							<?php echo $known_as; ?>
						<?php endif; ?>
						<?php $military_identification = get_field('military_identification');?>
						<?php if($military_identification): ?>
							<div class="title_fields"><h3>Military identification:</h3></div>
							<p class="image-subjects-links"><?php echo $military_identification; ?></p>
						<?php endif; ?>
						<!-- END NAME AND DETAILS
						\\====================================================//
						\\====================================================//
						-->
					</div>
					<div class='grid-3'>
						<!-- BIRTH
						\\====================================================//
						\\====================================================//
						-->
						<?php $birthdate = get_field( 'birthdate' );?>
						<?php $birthplace = get_field( 'birthplace' );?>
						<?php $birthdate_accuracy = get_field( 'birthdate_accuracy' );?>
						<?php if (!empty($birthdate)or !empty($birthplace) or !empty($birthdate_accuracy )):?>
							<h2 class="Title_single">Birth :</h2>
							<?php if (!empty($birthdate)):?>
								<div class="title_fields"><h3>Born:</h3></div>
								<p class="image-subjects-links">
								<?php echo date("jS F, Y",strtotime($birthdate));?>
								</p>
							<?php endif;?>
							<?php if( !empty( $birthdate_accuracy ) ) : ?>
								<div class="title_fields"><h3>Birthdate accuracy :</h3></div>
								<p class="image-subjects-links">
									<?php echo $birthdate_accuracy;?>
								</p>
							<?php endif; ?>
							<?php if( !empty( $birthplace ) ) : ?>
								<div class="title_fields"><h3>Birthplace :</h3></div>
								<p class="image-subjects-links">
									<?php echo $birthplace;?>
								</p>
							<?php endif; ?>
						<?php endif; ?>
						<!-- END BIRTH
						\\====================================================//
						\\====================================================//
						-->
						<!-- MARRIAGE
						\\====================================================//
						\\====================================================//
						-->
						<?php $marriage_date_accuracy = get_field( 'marriage_date_accuracy');?>
						<?php $marriage_date = get_field( 'marriage_date' );?>
						<?php $marriage_place = get_field( 'marriage_place' );?>
						<?php if( !empty( $marriage_date ) or !empty($marriage_place) or !empty($marriage_date_accuracy)) : ?>
							<h2 class="Title_single">Marriage :</h2>
							<?php if( !empty( $marriage_date ) ) : ?>
								<div class="title_fields"><h3>Marriage date :</h3></div>
								<p class="image-subjects-links">
									<?php echo date("jS F, Y",strtotime($marriage_date));?>
								</p>
							<?php endif; ?>
							<?php if( !empty( $marriage_date_accuracy) ) : ?>
								<div class="title_fields"><h3>Marriage date accuracy :</h3></div>
								<p class="image-subjects-links">
									<?php echo $marriage_date_accuracy;?>
								</p>
							<?php endif; ?>
							<?php if( !empty( $marriage_place ) ) : ?>
								<div class="title_fields"><h3>Place of Marriage :</h3></div>
								<p class="image-subjects-links">
									<?php echo $marriage_place;?>
								</p>
							<?php endif; ?>
						<?php endif; ?>
						<!--END MARRIAGE
						\\====================================================//
						\\====================================================//
						-->
						<!--DEATH
						\\====================================================//
						\\====================================================//
						-->
						<?php $deathdate = get_field( 'deathdate' );?>
						<?php $deathplace = get_field( 'deathplace' );?>
						<?php $deathdate_accuracy = get_field( 'deathdate_accuracy' );?>
						<?php if( !empty( $deathdate ) or !empty( $deathplace) or !empty( $deathdate_accuracy) ) : ?>
							<h2 class="Title_single">Death :</h2>
							<?php if( !empty( $deathdate ) ) : ?>
								<div class="title_fields"><h3>Date of death :</h3></div>
								<p class="image-subjects-links">
									<?php echo date("jS F, Y",strtotime($deathdate));?>
								</p>
							<?php endif; ?>
							<?php if( !empty( $deathdate_accuracy ) ) : ?>
								<div class="title_fields"><h3>Death date accuracy :</h3></div>
								<p class="image-subjects-links">
									<?php echo $deathdate_accuracy;?>
								</p>
							<?php endif; ?>
							<?php if( !empty( $deathplace ) ) : ?>
								<div class="title_fields"><h3>Place of death :</h3></div>
								<p class="image-subjects-links">
									<?php echo $deathplace;?>
								</p>
							<?php endif; ?>
						<?php endif; ?>
						<!--END DEATH
						\\====================================================//
						\\====================================================//
						-->
					</div>

					<div class='grid-3'>
						<!--FAMILY
						\\====================================================//
						\\====================================================//
						-->
						<?php $parents = get_field( 'parents' );?>
						<?php $parent_records = get_field( 'parent_records' );?>
						<?php $partner = get_field( 'partner' );?>
						<?php $partner_records = get_field( 'partner_records' );?>
						<?php $children = get_field( 'children' );?>
						<?php $children_records = get_field( 'children_records' );?>
						<?php $find=false ;?>
						<?php $permalink="" ;?>
						<?php $the_title="" ;?>

						<?php if( !empty( $parents ) or !empty( $parent_records ) or !empty( $partner ) or !empty( $children ) or !empty( $children_records )) : ?>
							<h2 class="Title_single">Family :</h2>
							<?php if( !empty( $parents ) ) : ?>
								<div class="title_fields"><h3>Parents :</h3></div>
								<?php while( have_rows( 'parents' ) ) : the_row();?>
									<?php $first_name = get_sub_field( 'first_name' );
									$middle_names = get_sub_field( 'middle_names' );
									$family_name = get_sub_field( 'family_name' );?>
									<?php $find=FALSE ;?>
									<?php if( !empty( $parent_records ) ) : ?>
										<?php foreach( $parent_records as $parent_record ):?>
											<?php $explo=explode(" ",get_the_title( $parent_record->ID ));?>
												<!-- <?php print_r(strtoupper($explo[0]))?>
												<?php print_r(strtoupper($explo[1]))?>
												<?php print_r(strtoupper($explo[2]))?> -->
												<?php if( strtoupper($explo[0])== strtoupper($first_name)and  strtoupper($explo[2])== strtoupper($family_name)):?>
													<?php $find=TRUE ;?>
													<?php $permalink=get_permalink( $parent_record->ID ) ;?>
													<?php $the_title=get_the_title( $parent_record->ID ) ;?>
												<?php endif ;?>
										<?php endforeach; ?>
									<?php endif; ?>
									<?php if ($find==TRUE):?>
										<div class="image-subjects-links">
											<a href="<?php echo $permalink; ?>"><?php echo $the_title; ?></a>
										</div>
									<?php else :?>
										<p class=" image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?>
										</p>
									<?php endif; ?>
								<?php endwhile;?>
							<?php endif; ?>

							<?php if( !empty( $partner ) ) : ?>
								<div class="title_fields"><h3>Partner(s) :</h3></div>
								<?php while( have_rows( 'partner' ) ) : the_row();?>
									<?php $first_name = get_sub_field( 'first_name' );
									$middle_names = get_sub_field( 'middle_names' );
									$family_name = get_sub_field( 'family_name' );?>
									<?php $find=FALSE ;?>
									<?php if( !empty( $partner_records ) ) : ?>
										<?php foreach( $partner_records as $partner_record ):?>
											<?php $explo=explode(" ",get_the_title( $partner_record->ID ));?>
												<?php if( strtoupper($explo[0])== strtoupper($first_name)and  strtoupper($explo[2])== strtoupper($family_name)):?>
													<?php $find=TRUE ;?>
													<?php $permalink=get_permalink( $partner_record->ID ) ;?>
													<?php $the_title=get_the_title( $partner_record->ID ) ;?>
												<?php endif ;?>
										<?php endforeach; ?>
									<?php endif; ?>
									<?php if ($find==TRUE):?>
										<div class="image-subjects-links">
											<a href="<?php echo $permalink; ?>"><?php echo $the_title; ?></a>
										</div>
									<?php else :?>
										<p class=" image-subjects-links"><?php echo $first_name . " " . $middle_names . " " . $family_name; ?>
										</p>
									<?php endif; ?>
								<?php endwhile;?>
							<?php endif; ?>

							<?php if( !empty( $children ) ): ?>
								<div class="title_fields"><h3>Children:</h3></div>
								<!-- <?php print_r($children);?> -->
								<!-- //vars -->

								<?php while( have_rows( 'children' ) ) : the_row();?>
									<?php $first_name = get_sub_field( 'first_name' );
									$middle_names = get_sub_field( 'middle_names' );
									$family_name = get_sub_field( 'family_name' );?>
									<?php if( !empty( $children_records ) ) : ?>
										<?php $find=FALSE ;?>
										<?php foreach( $children_records as $children_record ):?>
											<!-- <div class="image-subjects-links"> -->
												<?php $explo=explode(" ",get_the_title( $children_record->ID ));?>
												<!-- explo[0] <?php print_r(strtoupper($explo[0]))?>
												explo[1] <?php print_r(strtoupper($explo[1]))?>
												explo[2] <?php print_r(strtoupper($explo[2]))?>
												first_name <?php print_r(strtoupper($first_name))?>
												family_name <?php print_r(strtoupper($family_name))?>
												middle_names <?php print_r(strtoupper($middle_names))?> -->
												<?php if( strtoupper($explo[0])== strtoupper($first_name)and  strtoupper($explo[1])== strtoupper($middle_names)):?>
													<?php $find=TRUE ;?>
													<?php $permalink=get_permalink( $children_record->ID ) ;?>
													<?php $the_title=get_the_title( $children_record->ID ) ;?>
												<?php endif ;?>
											<!-- </div> -->
										<?php endforeach; ?>
									<?php endif;?>
									<?php if ($find==TRUE):?>
										<div class="image-subjects-links">
											<a href="<?php echo $permalink; ?>"><?php echo $the_title; ?></a>
										</div>
									<?php else :?>
										<p class="image-subjects-links">
											<?php echo $first_name . " " . $middle_names . " " . $family_name; ?>
										</p>
									<?php endif; ?>
								<?php endwhile;?>
							<?php  endif; ?>

						<?php  endif; ?>
						<!--END FAMILY
						\\====================================================//
						\\====================================================//
						-->
						<!--EDUCATION
						\\====================================================//
						\\====================================================//
						-->
						<?php $primary_education = get_field( 'primary_education' );?>
						<?php $secondary_education = get_field( 'secondary_education' );?>
						<?php $tertiary_education = get_field( 'tertiary_education' );?>
						<?php if( !empty( $primary_education ) or !empty( $secondary_education ) or !empty( $tertiary_education ) ) : ?>
							<h2 class="Title_single">Education :</h2>

							<?php if( !empty( $primary_education ) ) : ?>
								<div class="title_fields"><h3>Primary education :</h3></div>
								<p class="image-subjects-links">
									<?php echo $primary_education;?>
								</p>
							<?php endif; ?>
							<?php if( !empty( $secondary_education ) ) : ?>
								<div class="title_fields"><h3>Secondary education :</h3></div>
								<p class="image-subjects-links">
									<?php echo $secondary_education;?>
								</p>
							<?php endif; ?>
							<?php if( !empty( $tertiary_education ) ) : ?>
								<div class="title_fields"><h3>Tertiary education :</h3></div>
								<p class="image-subjects-links">
									<?php echo $tertiary_education;?>
								</p>
							<?php endif; ?>
						<?php endif; ?>
						<!--END EDUCATION
						\\====================================================//
						\\====================================================//
						-->
						<!--RELATED MATERIAL
						\\====================================================//
						\\====================================================//
						-->
						<?php $related_records = get_field( 'related_records' );?>
						<?php $related_collections = get_field( 'related_collections' );?>
						<?php if( !empty( $related_records ) or !empty($related_collections) ) : ?>
							<h2 class="Title_single">Related material:</h2>
							<!-- <a class="image-subjects-links" href="#">Title of article</a> -->
							<!-- post thumbnail -->
							<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
									<?php the_post_thumbnail(); // Fullsize image for the single post ?>
								</a>
							<?php endif; ?>
							<?php if( !empty( $related_records ) ) : ?>
								<div class="title_fields"><h3>Related records :</h3></div>
								<?php foreach( $related_records as $related_record ):?>
									<div class="image-subjects-links">
										<a href="<?php echo get_permalink( $related_record->ID ); ?>"><?php echo get_the_title( $related_record->ID ); ?></a>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php if( !empty( $related_collections ) ) : ?>
								<!-- <?php print_r($related_collections)?> -->
								<div class="title_fields"><h3>Related collections :</h3></div>
									<?php foreach($related_collections as $related_collection): ?>
										<div class="image-subjects-links">
											<li><a href="<?php echo get_term_link($related_collection->term_id); ?>" class="term collection"><?php echo $related_collection->name; ?></a></li>
										</div>
								<?php endforeach;?>
							<?php endif; ?>
						<?php endif; ?>
						<!--END RELATED MATERIAL
						\\====================================================//
						\\====================================================//
						-->

					<!-- /post thumbnail -->
					</div>
				</div>
			</article>
		<?php endwhile; ?>
		<?php endif; ?>
	</section>
</main>


<?php get_footer(); ?>
