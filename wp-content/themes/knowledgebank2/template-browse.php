<?php /* Template Name: Browse */ ?>
<?php get_header(); ?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<?php get_template_part('sections/breadcrumbs'); ?>
						<h1><?php the_title(); ?></h1>
						<?php the_field('intro'); ?>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>

			<?php get_template_part('sections/search','main'); ?>

			<section class="layer results tiles ">

				<div class="inner">

					<div class="grid column-4 ">

						<?php $tiles = get_field('tiles'); ?>

						<?php if(!empty($tiles['tiles'])): ?>
							<?php foreach($tiles['tiles'] as $tile): ?>

					  			<div class="col tile shadow">
									<div class="tile-img" style="background-image:url('<?php echo $tile['image']['sizes']['thumbnail']; ?>')">
										<a href="<?php echo $tile['link']; ?>"></a>
									</div>
									<div class="tile-copy">
										<h4><a href="<?php echo $tile['link']; ?>"><?php echo $tile['title']; ?></a></h4>
										<?php echo $tile['content']; ?>
										<?php if(!empty($tile['button_label'])): ?>
											<div class="button-group">
												<a href="<?php echo $tile['button_link']; ?>" class="button"><?php echo $tile['button_label']; ?></a>
											</div>
										<?php endif; ?>
									</div><!-- .tile-copy -->
								</div><!-- .col -->

							<?php endforeach; ?>
						<?php endif; ?>

					</div><!-- .grid -->

				</div><!-- .inner -->

			</section>

	</main>


<?php get_footer(); ?>
