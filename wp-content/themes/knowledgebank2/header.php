<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>

	</head>
	<body <?php body_class(); ?>>

		<header class="header">
			<div class="inner">
				<a href="/" class="logo">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/knowledgebank_logo.svg">
					<span>Knowledge<br/>Bank</span>
				</a>
				<span class="grow"></span>
				<nav>
					<ul>

						<?php wp_nav_menu( array( 'theme_location' => 'main', 'container' => '' ) ); ?>

					</ul>
				</nav>
				<a href="#main-search" class="search-icon"><i class="mdi mdi-magnify"></i></a>
			</div><!-- .inner -->
		</header><!-- .header -->
