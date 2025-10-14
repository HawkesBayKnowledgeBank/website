<?php get_header(); ?>

<section class="home-intro dark">

    <?php $slides = get_field('slider'); ?>

    <?php //print_r($slides); 
    ?>
    <?php if (!empty($slides)) : ?>
        <div class="intro-background-slider">
            <?php foreach ($slides as $slide) : ?>
                <?php if (!empty($slide['image']['sizes']['large'])) : ?>
                    <div class="home-bg-slide" style="background-image:url('<?php echo $slide['image']['sizes']['large']; ?>');"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div><!--.intro-background-slider -->

        <div class="inner">
            <div class="intro-slider">
                <?php foreach ($slides as $slide) : ?>
                    <?php $src = !empty($slide['image']['sizes']['large']) ? $slide['image']['sizes']['large'] : $slide['image']['url']; ?>
                    <div class="home-slide" style="background-image:url('<?php echo $src; ?>');">
                        <div class="slide-copy">
                            <h5>Featured content</h5>
                            <h2><?php echo $slide['title']; ?></h2>
                            <?php if (!empty($slide['description'])) echo $slide['description']; ?>

                            <div class="button-group">
                                <?php
                                $target = $slide['link']['new_window'] ? ' target="_blank"' : '';
                                ?>
                                <a href="<?php echo $slide['link']['link']; ?>" class="button" <?php echo $target; ?>><?php echo $slide['link']['link_text']; ?></a>

                            </div>
                        </div>
                    </div><!-- .home-slide -->
                <?php endforeach; ?>
            </div><!-- .intro-slider-->
            <div class="intro-text">
                <?php the_field('slider_intro'); ?>
                <?php if (get_field('intro_link_text')) : ?>
                    <div class="button-group">
                        <a href="<?php the_field('intro_link_url'); ?>" class="button"><?php the_field('intro_link_text'); ?></a>
                    </div>
                <?php endif; ?>
            </div><!-- .intro-text -->
        </div><!-- .inner -->

    <?php endif; ?>


</section> <!-- .home-intro -->

<?php get_template_part('sections/search', 'main'); ?>

<section class="layer cards">
    <div class="inner">
        <div class="grid column-3">

            <?php foreach (['box_left', 'box_centre', 'box_right'] as $col) : ?>

                <?php $box = get_field($col); ?>

                <div class="col card">
                    <h3><?php echo $box['heading']; ?></h3>
                    <?php echo $box['content']; ?>
                    <div class="button-group">
                        <a href="<?php echo $box['button_link']; ?>" class="button"><?php echo $box['button_label']; ?></a>
                    </div>
                </div>

            <?php endforeach; ?>

        </div><!-- .grid -->

        <div class="grid column-2 ">

            <div class="col card">
                <h3>Facebook news</h3>
                <?php echo kb_facebook_embed(); ?>

            </div>

            <div class="col card explore-items">
                <h3><?php the_field('explore_heading'); ?></h3>

                <?php $items = get_field('explore_items'); ?>
                <?php if (!empty($items)) : ?>
                    <?php foreach ($items as $item) : ?>

                        <div class="explore-item">
                            <?php echo $item['item']; ?>
                        </div><!-- .explore-item -->

                    <?php endforeach; ?>

                <?php endif; ?>

            </div><!-- .explore-items -->


        </div><!-- .grid -->

    </div><!-- .inner -->
</section>

<?php get_template_part('sections/sponsors'); ?>

<?php get_template_part('sections/signup'); ?>

<?php get_footer(); ?>