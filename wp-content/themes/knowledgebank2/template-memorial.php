<?php /* Template Name: Memorial page */ get_header(); ?>

	<main role="main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<section class="layer intro intro-default">
			<div class="inner">
				<div class="intro-copy dark inner-700">
					<?php get_template_part('sections/breadcrumbs'); ?>
					<h1><?php the_title(); ?></h1>
					<?php the_field('intro'); ?>
				</div><!-- .intro-copy -->
			</div><!-- .inner -->
		</section>

		<section class="layer single-column">
			<div class="inner thin content">

				<?php if (have_posts()): while (have_posts()) : the_post(); ?>

						<?php the_content(); ?>

						<?php edit_post_link(); ?>

				<?php endwhile; ?>

				<?php else: ?>

					<h2><?php _e( 'Sorry, nothing to display.', 'knowledgebank' ); ?></h2>

				<?php endif; ?>

			</div><!-- .inner -->
		</section>

        <section class="layer results tiles ">

            <div class="inner">

                <div class="grid column-4 ">

                    <?php $tiles = get_field('tiles_people'); ?>

                    <?php if(!empty($tiles)): ?>
                        <?php foreach($tiles as $tile): ?>

                            <div class="col tile shadow">

                                <img src="<?php echo $tile['image']['sizes']['medium']; ?>" alt="<?php echo $tile['image']['alt']; ?>" class="tile-img-inline" />

                                <div class="tile-copy">
                                    <h4>
                                        <?php if(!empty($tile['person'])): ?>
                                            <a href="<?php echo get_permalink($tile['person']->ID); ?>" target="_blank"><?php echo $tile['title']; ?></a>
                                        <?php else: ?>
                                            <?php echo $tile['title']; ?>
                                        <?php endif; ?>

                                    </h4>
                                    <?php echo $tile['content']; ?>

                                </div><!-- .tile-copy -->
                            </div><!-- .col -->

                        <?php endforeach; ?>
                    <?php endif; ?>

                </div><!-- .grid -->

            </div><!-- .inner -->

        </section>



	</main>

<?php get_footer(); ?>
