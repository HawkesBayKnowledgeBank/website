<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail(); // Fullsize image for the single post ?>
				</a>
			<?php endif; ?>
			<!-- /post thumbnail -->

			<!-- post title -->
			<h1>
				<?php the_title(); ?>
			</h1>
			<!-- /post title -->

			<!-- post details -->
			<span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
			<span class="author"><?php _e( 'Published by', 'knowledgebank' ); ?> <?php the_author_posts_link(); ?></span>
			<span class="comments"><?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'knowledgebank' ), __( '1 Comment', 'knowledgebank' ), __( '% Comments', 'knowledgebank' )); ?></span>
			<!-- /post details -->

			<?php the_content(); // Dynamic Content ?>

			<pre style="padding:30px; background-color:#fff;">
				<?php print_r(get_fields()); ?>
			</pre>

			<?php the_tags( __( 'Tags: ', 'knowledgebank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

			<p><?php _e( 'Categorised in: ', 'knowledgebank' ); the_category(', '); // Separated by commas ?></p>

			<p><?php _e( 'This post was written by ', 'knowledgebank' ); the_author(); ?></p>

			<?php edit_post_link(); // Always handy to have Edit Post Links available ?>

			<?php comments_template(); ?>
















			<section class="layer intro intro-default background-image" style="background-image:url(img/quake.jpg);">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<ul class="breadcrumbs">
							<li><a href="#">Home</a></li>
							<li><a href="#">Browse</a></li>
							<li>Title</li>
						</ul>
						<h1>Page Title</h1>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php get_template_part('part','searchbar'); ?>

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
									<img src="<?php echo $image['sizes']['medium_large']; ?>" alt="<?php echo $image['alt']; ?>" />
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

			<section class="layer attributes">
				<div class="inner">
					<div class="grid column-2">
						<div class="col">
							<h4>Notes:</h4>
							<p>Official photograph of earthquake damage, "14"</p>
						</div>
						<div class="col">
							<h4>Date published:</h4>
							<p>1931</p>
						</div>
						<div class="col">
							<h4>Collection: </h4>
							<p><a href="#">COLWILL VM</a></p>
						</div>
						<div class="col">
							<h4>Series:</h4>
							<p><a href="#">1931 Earthquake</a></p>
						</div>
						<div class="col">
							<h4>Tags:</h4>
							<p><a href="#">earthquake</a></p>
						</div>
						<div class="col">
							<h4>Subjects:</h4>
							<p><a href="#">Disasters and Emergencies</a></p>
						</div>
						<div class="col">
							<h4>Format of the original:</h4>
							<p>Photograph</p>
						</div>
						<div class="col">
							<h4>Original digital file:</h4>
							<p class="file-name">colwillvm1123-brownphotoalbum-02c-warrensbuildings.jpg</p>
							<div class="button-group">
								<a href="#" class="button download image">Download <span>1.3MB</span></a>
								<!--<a href="#" class="button download pdf">Download <span>1.3MB</span></a>
								<a href="#" class="button download video">Download <span>1.3MB</span></a>
								<a href="#" class="button download audio">Download <span>1.3MB</span></a> -->
							</div>
						</div>
						<div class="col">
							<h4>Accession Number: </h4>
							<p>967/968/35522</p>
						</div>
						<div class="col">
							<h4>License:</h4>
							<img src="img/cc.png" style="float: right;" alt="Creative Commons Attribution-NonCommercial 4.0 International License">
							<p>This work is licensed under a <a href="https://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License.</a></p>
							<p><a href="#">About commercial licensing</a></p>
							<div class="button-group">
								<a href="#" class="button">Purchase commercial license</a>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="layer commenting-wrap">
				<div class="inner">
					<div class="commenting">
						<h4>Do you know something about this record?</h4>
						<p class="temp">Commenting system here</p>
					</div>
				</div>
			</section>

			<section class="layer logos">
				<div class="inner">
					<div class="section-header center">
						<h4>Sponsors &amp; Supporters</h4>
						<p>We'd like to thank the following businesses and organisations for their support.</p>
					</div>
					<div class="grid">
						<a href="#"><img src="img/freeman-decorators.png" alt="Freeman Decorators"></a>
						<a href="#"><img src="img/new_life_electrical.png" alt="New Life Electrical"></a>
						<a href="#"><img src="img/unison-fibre-80.png" alt="unison Fiber"></a>
						<a href="#"><img src="img/knowledge@2x.png" alt="Knowledge Accountants"></a>
						<a href="#"><img src="img/bvond-logo.jpg" alt="Bannister and Von Dadelszen"></a>
						<a href="#"><img src="img/ubuntu_black-orange_hex.png" alt="Ubuntu ( unofficial )"></a>
						<a href="#"><img src="img/morgan_builders.png" alt="Morgan Builders"></a>
						<a href="#"><img src="img/hutchinsons.png" alt="Hutchinson’s Furnishers"></a>
						<a href="#"><img src="img/ecct-logo-2014.png" alt="Eastern & Central Community Trust"></a>
						<a href="#"><img src="img/rd9_historical_trust.png" alt="RD9 Historical Trust"></a>
						<a href="#"><img src="img/ballantyne_trust.png" alt="Ballantyne Trust"></a>
					</div>
				</div>
			</section>

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

<?php get_sidebar(); ?>

<?php get_footer(); ?>
