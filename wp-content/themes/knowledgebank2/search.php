<?php /* Template Name: Search results */ ?>
<?php get_header(); ?>
<?php $filters = knowledgebank_get_filters(); ?>
<?php
	global $wp_query;

	$title = 'Search';
	$search_query = get_search_query();
	//if(!empty($search_query)) $title .= ' - ' . $search_query;

?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php echo $title; ?></h1>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php get_template_part('sections/search','main'); ?>

			<?php

				//$advanced_search = new WP_Advanced_Search('knowledgebank_advanced_search');
				//$advanced_search->the_form();

			?>


				<main role="main">
					<!-- section -->
					<section class="layer results tiles search-results">
						<div class="inner">

							<div class="grid column-4 ">

								<?php if(have_posts()): while(have_posts()): the_post(); ?>
									<?php if($post->post_status != 'publish' || $post->ID == 113310) continue; ?>
									<?php

										$type = $post->post_type;
										$images = get_field('images', $post->ID);
										$image = !empty($images[0]['image']) ? $images[0]['image'] : false;
										if(empty($image)) $image = get_field('image');


										$link = get_permalink($post->ID);
										$image_size = 'thumbnail';
										if(is_tax() && ($term->term_id == 967 || $term->parent == 967)) $image_size = 'medium';//medium for photo news
									?>

									<div class="col tile shadow <?php echo $type; ?>">

										<?php
											$src = '/wp-content/themes/knowledgebank2/img/placeholder-400.png'; //default
											if($post->post_type == 'video' && get_field('youtube_id', $post->ID)) $src = sprintf('https://img.youtube.com/vi/%s/0.jpg', get_field('youtube_id', $post->ID));
											if(!empty($image['sizes'][$image_size])) $src = $image['sizes'][$image_size];
										?>

										<div class="tile-img lazy" style="background-image:url(/wp-content/themes/knowledgebank2/img/placeholder-400.png)" data-src="<?php echo $src; ?>">
											<a href="<?php echo $link; ?>"></a>
										</div>

										<div class="tile-copy">
											<h4><a href="<?php echo $link; ?>"><?php echo $post->post_title; ?></a></h4>
												<?php get_template_part('sections/post-breadcrumbs'); ?>
												<?php //the_excerpt(); ?>
												<?php
													if($type == 'audio') { //see if we have an mp3 and/or ogg
														$mp3 = get_field('audio', $post->ID);
														$ogg = false;
														$master = get_field('master', $post->ID);
														if(!empty($master['mime_type']) && $master['mime_type'] == 'audio/ogg'){
															$ogg = $master['url'];
														}
														if(!empty($mp3) || !empty($ogg)): ?>
														<audio controls>
														  <?php if($mp3): ?><source src="<?php echo $mp3['url']; ?>" type="<?php echo $mp3['mime_type']; ?>"><?php endif; ?>
														  <?php if($ogg): ?><source src="<?php echo $ogg; ?>" type="audio/ogg"><?php endif; ?>
														  Your browser does not support the audio element.
														</audio>
														<?php endif;
													}

												?>
											<div class="button-group">
												<a href="<?php echo $link; ?>" class="button">View Details</a>
											</div>
										</div><!-- .tile-copy -->
									</div><!-- .col -->

									<?php endwhile; ?>

								<?php else: ?>

									<p>No results found</p>

								<?php endif; ?>

							</div><!-- .grid -->

							<ul class="pagination">
								<?php knowledgebank_numeric_posts_nav(); ?>
							</ul>

						</div><!-- .inner -->
					</section>
					<!-- /section -->
				</main>


	</main>

<?php get_footer(); ?>
