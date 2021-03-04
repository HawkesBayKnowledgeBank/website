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
                            <?php if(!empty($slide['description'])) echo $slide['description']; ?>

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

            <?php foreach(['box_left','box_centre','box_right'] as $col): ?>

                <?php $box = get_field($col); ?>

                <div class="col card">
                    <h3><?php echo $box['heading']; ?></h3>
                    <?php echo $box['content']; ?>
                    <div class="button-group">
                        <a href="<?php echo $box['button_link']; ?>" class="button"><?php echo $box['button_label']; ?></a>
                    </div>
                </div>

            <?php endforeach; ?>
            <div class="col card explore-items">
                <h3>Explore</h3>

                <div class="explore-item">
                    <h5><a href="/collections/" class="icon-collections">Collections</a></h5>
                    <p>Collections of material donated by individuals, families and organisations.</p>
                </div>
                <div class="explore-item">
                    <h5><a href="/tags/" class="icon-tags">Tags</a></h5>
                    <p>Tags are informal subjects or topics used to group related material.</p>
                </div>
                <div class="explore-item">
                    <h5><a href="/photo-news/" class="icon-hb-photo-news">Hawke’s Bay Photo News</a></h5>
                    <p>Hawke's Bay Photo News, a local magazine published November 1958 - June 1967</p>
                </div>
                <div class="explore-item">
                    <h5><a href="/people/" class="icon-people">Who’s Who</a></h5>
                    <p>An index of Hawke's Bay people.</p>
                </div>
                <div class="explore-item">
                    <h5><a href="/tag/oral-history/" class="icon-audio">Oral History</a></h5>
                    <p>Recordings and transcripts of interviews with Hawke's Bay personalities.</p>
                </div>
                <div class="explore-item">
                    <h5><a href="/bibliography" class="icon-book">Bibliography</a></h5>
                    <p>An index of printed publications relating to Hawke's Bay and its history.</p>
                </div>
                <div class="explore-item">
                    <h5><a href="/video" class="icon-video">Video and Film</a></h5>
                    <p>Film and video from across our collections.</p>
                </div>
                <div class="explore-item">
                    <h5><a href="/images" class="icon-images">Images</a></h5>
                    <p>Photographs and other still images from our collections.</p>
                </div>

            </div>


        </div>
    </div>
</section>

<?php get_template_part('sections/sponsors'); ?>

<?php get_template_part('sections/signup'); ?>

<?php get_footer(); ?>
