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
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'></script>

	</head>
	<body <?php body_class( 'cbp-spmenu-push' ); ?>>

		<!-- wrapper -->
		<div class="wrapper">

			<!-- header -->
			<div class="headerBack">
				<header class="main-header container" role="banner">
<!--
					<?php kb2_extra_nav_menu(); ?>

					logo -->

					<div class="main-logo">

					</div>
					<div class="byline">
						<!-- <img class="main-logo" src="img/HBDA_logo.png" alt="logo"> -->
						<h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
						<h3><?php bloginfo( 'description' ); ?></h3>
					</div>


					<!-- /logo -->

					<!-- nav -->
					<nav id="nav-main" class="link-hover" role="navigation">
						<?php kb2_nav(); ?>
					</nav>

					<!-- /nav -->
					<div id="nav-icon1">
						<span></span>
						<span></span>
						<span></span>
					</div>
					<div class="overlay">
						<?php kb2_nav(); ?>

					</div>
					<div class="only-search<?php if ( ! empty( $header_image ) ) : ?> with-image<?php endif; ?>">
               				<?php get_search_form(); ?>
                	</div>


			</header>

			</div>
			<!-- /header -->
