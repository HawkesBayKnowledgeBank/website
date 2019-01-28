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
			<section class="layer single-column">
				<div class="inner thin content">
					<div class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></div>
					<?php the_content(); ?>
				</div><!-- .inner -->
			</section>


			<section class="layer commenting-wrap">
				<div class="inner">
					<div class="commenting">
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

			<section class="layer signup">
				<div class="inner">
					<div class="section-header center">
						<h4>Sign up to our newsletter</h4>
					</div>
					<form class="" action="index.html" method="post">
						<input type="text" name="" value="" placeholder="First name">
						<input type="text" name="" value="" placeholder="Last name">
						<input type="email" name="" value="" placeholder="Email address">
						<button type="submit" name="button">Sign up</button>
					</form>
				</div>
			</section>


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
