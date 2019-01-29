<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<section class="layer intro intro-default background-image" style="background-image:url(img/quake.jpg);">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php the_title(); ?></h1>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php //get_template_part('sections/search','main'); ?>

			<?php
				$fields = knowledgebank_get_field_objects(); //we want to move / remove / play around with field orders
			?>

			<?php $images = get_field('images'); ?>

			<?php if(!empty($images)): ?>

				<?php
					//maybe output a caption with each image
					$transcript = get_field('transcript');
					if(!empty($transcript)){
						$captions = preg_split('/<hr ?\/?>/', $transcript);//pages are delimited by <hr /> (match variations <hr> and <hr/>)
					}
				?>

				<section class="layer media-slider-wrap">
					<div class="inner">
						<div class="media-slider">

							<?php foreach($images as $index => $image): $image = $image['image']; //image :) ?>

							<div class="media-slide">
								<div class="media-slide-inner">
									<?php
										if($index > 3){ //lazy load everything after image 3
											$src = sprintf('src="" data-lazy-src="%s"',$image['sizes']['large']);
										}
										else{
											$src = sprintf('src="%s"',$image['sizes']['large']);
										}
									?>
									<img <?php echo $src; ?> alt="<?php echo $image['alt']; ?>" />
									<a href="<?php echo $image['url']; ?>" class="zoom">
										<i class="mdi mdi-magnify"></i>
									</a>
								</div>
								<?php if(!empty($captions[$index])): ?>
								<div class="caption">
									<?php echo $captions[$index]; ?>
								</div>
							<?php endif; ?>
							</div><!-- .media-slide -->

							<?php endforeach; ?>

						</div><!-- .media-slider -->
					</div>
				</section>

			<?php endif; //!empty($images) ?>

			<?php if(get_field('audio')): ?>

				<?php
					$audio = get_field_object('audio');
					knowledgebank_field_template($audio, false);
				?>

			<?php endif; //audio ?>

			<?php
				if($post->post_type == 'video'):
					$video = get_field_object('master');
					$video['name'] = 'video';
					knowledgebank_field_template($video, false);
				 endif; //videos
			?>

			<section class="layer attributes">
				<div class="inner">
					<div class="grid column-2">

						<?php
							foreach($fields as $field):
								//look for templates for each field, first by name and then by type
								knowledgebank_field_template($field); //see inc/theme_functions.php
							endforeach;
						?>

					</div>
					<?php /*
					<a href="#json">json</a>
					<pre style="padding:30px; background-color:#fff;display:none;" id="json">
						<?php print_r($fields); ?>
						<?php //print_r(get_fields()); ?>
					</pre>
					*/
					?>
				</div>
			</section>

			<section class="layer commenting-wrap">
				<div class="inner">
					<div class="commenting">
						<h4>Do you know something about this record?</h4>
						<p>Please note we cannot verify the accuracy of any information posted by the community.</p>
						<div id="disqus_thread"></div>
						<script>
						    /**
						     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT
						     *  THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR
						     *  PLATFORM OR CMS.
						     *
						     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT:
						     *  https://disqus.com/admin/universalcode/#configuration-variables
						     */

						    var disqus_config = function () {
						        // Replace PAGE_URL with your page's canonical URL variable
						        //this.page.url = https://knowledgebank.org.nz/<?php echo get_field('accession_number'); ?>;

						        // Replace PAGE_IDENTIFIER with your page's unique identifier variable
								<?php
									$identifier = get_post_meta($post->ID, '_drupal_nid', true);
									if(empty($identifier)) $identifier = $post->ID;
								?>
								this.page.identifier = 'node/<?php echo $identifier; ?>';
						    };


						    (function() {  // REQUIRED CONFIGURATION VARIABLE: EDIT THE SHORTNAME BELOW
						        var d = document, s = d.createElement('script');

						        s.src = 'https://hawkesbayknowledgebank.disqus.com/embed.js';

						        s.setAttribute('data-timestamp', +new Date());
						        (d.head || d.body).appendChild(s);
						    })();
						</script>
						<noscript>
						    Please enable JavaScript to view the
						    <a href="https://disqus.com/?ref_noscript" rel="nofollow">
						        comments powered by Disqus.
						    </a>
						</noscript>
					</div><!-- .commenting -->
				</div>
			</section>

			<?php get_template_part('sections/sponsors'); ?>

			<?php get_template_part('sections/signup'); ?>


		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'knowledgebank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_footer(); ?>
