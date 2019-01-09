<?php get_header(); ?>

<section class="home-intro dark">

    <div class="intro-background-slider">
        <div class="home-bg-slide" style="background-image:url('/templates/img/quake.jpg');"></div>
        <div class="home-bg-slide" style="background-image:url('/templates/img/quake1.jpg');"></div>
        <div class="home-bg-slide" style="background-image:url('/templates/img/quake3.jpg');"></div>
        <div class="home-bg-slide" style="background-image:url('/templates/img/quake4.jpg');"></div>
    </div>

    <div class="inner">
        <div class="intro-slider">
            <div class="home-slide" style="background-image:url('/templates/img/quake.jpg');">
                <div class="slide-copy">
                    <h5>Featured content</h5>
                    <h1>History to be revealed through photos</h1>
                    <div class="button-group">
                        <a href="#" class="button">Watch the video</a>
                    </div>
                </div>
            </div><!-- .home-slide -->
            <div class="home-slide" style="background-image:url('/templates/img/quake1.jpg');">
                <div class="slide-copy">
                    <h5>Featured content</h5>
                    <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
                    <div class="button-group">
                        <a href="#" class="button">Read more</a>
                    </div>
                </div>
            </div><!-- .home-slide -->
            <div class="home-slide" style="background-image:url('/templates/img/quake3.jpg');">
                <div class="slide-copy">
                    <h5>Featured content</h5>
                    <h2>Duis aute irure dolor in reprehenderit</h2>
                    <div class="button-group">
                        <a href="#" class="button">Read more</a>
                    </div>
                </div>
            </div><!-- .home-slide -->
            <div class="home-slide" style="background-image:url('/templates/img/quake4.jpg');">
                <div class="slide-copy">
                    <h5>Featured content</h5>
                    <h2>Nemo enim ipsam voluptatem</h2>
                    <div class="button-group">
                        <a href="#" class="button">Read more</a>
                    </div>
                </div>
            </div><!-- .home-slide -->
        </div>
        <div class="intro-text">
            <h4>The Hawke's Bay Knowledge Bank is a living record of Hawke's Bay and its people.</h4>
            <p>It combines a robust, secure and widely-compatible digital archive with a new generation of multimedia and social tools.</p>
            <!-- <p>We want to enrich our stored material with the knowledge of the community through user comments, tagging and sharing of information.</p> -->
            <div class="button-group">
                <a href="#" class="button">About Us</a>
            </div>

        </div>
    </div>
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
                    <a href="<?php echo $box_left['button_url']; ?>" class="button"><?php echo $box_left['button_label']; ?></a>
                </div>
            </div>
            <?php $box_right = get_field('box_right'); ?>
            <div class="col card">
                <h3><?php echo $box_right['heading']; ?></h3>
                <?php echo $box_right['content']; ?>
                <div class="button-group">
                    <a href="<?php echo $box_right['button_url']; ?>" class="button"><?php echo $box_right['button_label']; ?></a>
                </div>
            </div>
        </div>
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

<?php get_footer(); ?>
