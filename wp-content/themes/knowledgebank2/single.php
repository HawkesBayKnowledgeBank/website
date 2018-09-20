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
						<ul class="breadcrumbs">
							<li><a href="#">Home</a></li>
							<li><a href="#">Browse</a></li>
							<li><?php the_title(); ?></li>
						</ul>
						<h1><?php the_title(); ?></h1>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php get_template_part('sections/search','main'); ?>

			<?php $fields = get_field_objects(); ?>

			<a href="#json">json</a>
			<pre style="padding:30px; background-color:#fff;display:none;" id="json">
				<?php print_r($fields); ?>
				<?php //print_r(get_fields()); ?>
			</pre>

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
											$src = sprintf('src="" data-lazy-src="%s"',$image['sizes']['medium_large']);
										}
										else{
											$src = sprintf('src="%s"',$image['sizes']['medium_large']);
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

			<section class="layer attributes">
				<div class="inner">
					<div class="grid column-2">

						<?php
							foreach($fields as $field):
								//look for templates for each field, first by name and then by type
								knowledgebank_field_template($field);
							endforeach;
						?>

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

<?php get_footer(); ?>
