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
            <div class="col card">
                <h3>We need your history</h3>
                <p>We're always interested in hearing about family or individual collections which might not have been shared as widely as they could be. If you have a cache of old photographs, film, slides or other materials which you think could be of interest to the wider public, please get in touch.</p>
                <div class="button-group">
                    <a href="#" class="button">Contribute Now</a>
                </div>
            </div>
            <div class="col card">
                <h3>Make a donation</h3>
                <p>Can you help? We appreciate any and all donations towards preserving our local history.</p>
                <div class="button-group">
                    <a href="#" class="button">Donate Now</a>
                </div>
            </div>
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
            <a href="#"><img src="/templates/img/freeman-decorators.png" alt="Freeman Decorators"></a>
            <a href="#"><img src="/templates/img/new_life_electrical.png" alt="New Life Electrical"></a>
            <a href="#"><img src="/templates/img/unison-fibre-80.png" alt="unison Fiber"></a>
            <a href="#"><img src="/templates/img/knowledge@2x.png" alt="Knowledge Accountants"></a>
            <a href="#"><img src="/templates/img/bvond-logo.jpg" alt="Bannister and Von Dadelszen"></a>
            <a href="#"><img src="/templates/img/ubuntu_black-orange_hex.png" alt="Ubuntu ( unofficial )"></a>
            <a href="#"><img src="/templates/img/morgan_builders.png" alt="Morgan Builders"></a>
            <a href="#"><img src="/templates/img/hutchinsons.png" alt="Hutchinson’s Furnishers"></a>
            <a href="#"><img src="/templates/img/ecct-logo-2014.png" alt="Eastern & Central Community Trust"></a>
            <a href="#"><img src="/templates/img/rd9_historical_trust.png" alt="RD9 Historical Trust"></a>
            <a href="#"><img src="/templates/img/ballantyne_trust.png" alt="Ballantyne Trust"></a>
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

<?php get_footer(); ?>
