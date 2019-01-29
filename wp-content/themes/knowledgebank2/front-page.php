<?php get_header(); ?>

<section class="home-intro dark">

    <?php $slides = get_field('slider'); ?>

    <?php //print_r($slides); ?>
    <?php if(!empty($slides)): ?>
        <div class="intro-background-slider">
            <?php foreach($slides as $slide): ?>
                <?php if(!empty($slide['image']['sizes']['large'])): ?>
                    <div class="home-bg-slide" style="background-image:url('<?php echo $slide['image']['sizes']['large']; ?>');"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div><!--.intro-background-slider -->

        <div class="inner">
            <div class="intro-slider">
                <?php foreach($slides as $slide): ?>
                    <?php $src = !empty($slide['image']['sizes']['large']) ? $slide['image']['sizes']['large'] : $slide['image']['url']; ?>
                    <div class="home-slide" style="background-image:url('<?php echo $src; ?>');">
                        <div class="slide-copy">
                            <h5>Featured content</h5>
                            <h2><?php echo $slide['title']; ?></h2>
                            <div class="button-group">
                                <?php
                                    $target = $slide['new_window'] ? ' target="_blank"' : '';
                                ?>
                                <a href="<?php echo $slide['link']; ?>" class="button" <?php echo $target; ?>><?php echo $slide['link_text']; ?></a>

                            </div>
                        </div>
                    </div><!-- .home-slide -->
                <?php endforeach; ?>
            </div><!-- .intro-slider-->
            <div class="intro-text">
                <?php the_field('slider_intro'); ?>
                <?php if(get_field('intro_link_text')): ?>
                    <div class="button-group">
                        <a href="<?php the_field('intro_link_url'); ?>" class="button"><?php the_field('intro_link_text'); ?></a>
                    </div>
                <?php endif; ?>
            </div><!-- .intro-text -->
        </div><!-- .inner -->

    <?php endif; ?>


</section> <!-- .home-intro -->

<?php get_template_part('sections/search','main'); ?>

<section class="layer cards">
    <div class="inner">
        <div class="grid column-2 tight">
            <?php $box_left = get_field('box_left'); ?>
            <div class="col card">
                <h3><?php echo $box_left['heading']; ?></h3>
                <?php echo $box_left['content']; ?>
                <div class="button-group">
                    <a href="<?php echo $box_left['button_link']; ?>" class="button"><?php echo $box_left['button_label']; ?></a>
                </div>
            </div>
            <?php $box_right = get_field('box_right'); ?>
            <div class="col card">
                <h3><?php echo $box_right['heading']; ?></h3>
                <?php echo $box_right['content']; ?>
                <div class="button-group">
                    <a href="<?php echo $box_right['button_link']; ?>" class="button"><?php echo $box_right['button_label']; ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_template_part('sections/sponsors'); ?>

<?php get_template_part('sections/signup'); ?>

<?php get_footer(); ?>
