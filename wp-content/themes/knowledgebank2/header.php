<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(''); ?><?php if (wp_title('', false)) {
                                        echo ' :';
                                    } ?> <?php bloginfo('name'); ?></title>

    <link href="//www.google-analytics.com" rel="dns-prefetch">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/img/icons/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">

    <?php wp_head(); ?>
    <meta property="og:image" content="https://www.knowledgebank.org.nz/wp-content/themes/knowledgebank2/img/share.png" />


</head>

<body <?php body_class(); ?>>

    <?php $banner = get_field('header_banner_message', 'option'); ?>

    <?php if ($banner): ?>

        <div class="header-banner-message">
            <?php echo $banner; ?>
        </div>


    <?php endif; ?>

    <header class=" header">
        <div class="inner">
            <a href="/" class="logo">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/knowledgebank_logo.svg">
                <span>Knowledge<br />Bank</span>
            </a>
            <span class="grow"></span>
            <nav>


                <?php wp_nav_menu(array('theme_location' => 'main', 'container' => '')); ?>


            </nav>
            <a href="/search" class="search-icon"><i class="mdi mdi-magnify"></i></a>
        </div><!-- .inner -->
    </header><!-- .header -->