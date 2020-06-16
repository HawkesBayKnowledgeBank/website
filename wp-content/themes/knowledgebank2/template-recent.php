<?php /*Template name: Recent */ get_header(); ?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php echo get_the_title(); ?></h1>
		  				<?php if(!empty($term->description)) echo "<p>{$term->description}</p>"; ?>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php //include_once(get_template_directory() . '/sections/term-filters.php'); //include rather than get_template_part so we can share $filters ?>


			<section class="layer results tiles <?php echo implode(' ', $extra_classes); ?>">
				<div class="inner">


					<div class="grid column-4 ">

                        <?php

                            $recent_records = new WP_Query(array(
                                'post_type' =>  array('still_image','audio','video','person','text'),
                                'post_status' => 'publish',
                                'posts_per_page' => 200,
                                'orderby' => 'date',
                                'order' => 'desc',
                            ));


                            //we are only going to show at most three posts from each collection, so we don't get whole collections taking over this page
                             $collection_post_limit = 3;
                             $person_post_limit = 5;
                             $found_collections = array();

                        ?>

						<?php if($recent_records->have_posts()): while($recent_records->have_posts()): $recent_records->the_post();  ?>
                            <?php

                                $skip = false; //only skip this post if we have enough from its collection(s) already

                                $post_collections = wp_get_post_terms($post->ID, 'collections');

                                if(!empty($post_collections)){
                                    foreach($post_collections as $term){
                                        if(!empty($found_collections[$term->term_id]) && $found_collections[$term->term_id] >= $collection_post_limit) $skip = true;
                                        $found_collections[$term->term_id] = !empty($found_collections[$term->term_id]) ? $found_collections[$term->term_id] + 1 : 1;
                                    }
                                }

                                if($post->post_type == 'person'){//limit how many 'person' posts we show
                                    if($person_post_limit == 0) continue;
                                    $person_post_limit -= 1;
                                }

                                if($skip) continue;

                            ?>
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

	</main>

<?php get_footer(); ?>
