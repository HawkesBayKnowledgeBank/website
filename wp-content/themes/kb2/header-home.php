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
			<div class="new_header">
				<div class="headerBack_home">
					<header class="main-header" role="banner">


						<!-- logo -->
						<div class="grid-container">
							<div class="grid-2">
								<a href="<?php echo home_url(); ?>"><div class="main-logo">

								</div></a>
							</div>
							<div class="grid-4">
								<div class="byline">
									<!-- <img class="main-logo" src="img/HBDA_logo.png" alt="logo"> -->
									<a href="<?php echo home_url(); ?>"><h1><?php bloginfo( 'name' ); ?></h1>
									<h3><?php bloginfo( 'description' ); ?></h3></a>

								</div>
							</div>
							<!-- <div class="grid-2">
								<div class="link-hover">
									<?php kb2_extra_nav_menu(); ?>
								</div>
							</div> -->
							<div class="grid-4">

								<div class="only-search-home<?php if ( ! empty( $header_image ) ) : ?> with-image<?php endif; ?>">
				               				<?php get_search_form(); ?>
				                	</div>
			                </div>
		            	</div>
					</header>
				</div>
			</div>
			<!-- /header -->
