<?php get_header("home");  ?>



<?php $slides = get_field('slider'); ?>

<?php if(!empty($slides)): ?>
	<div class="flexslider">

		<ul class="slides">

		<?php foreach($slides as $slide): ?>

			<li>

				<?php
					//get our href - it's either a permalink from a post object or a string from a text field, depending on what link_type is set to
					$link = ( $slide['link_type'] == 'internal' ? get_permalink($slide['internal']->ID) : $slide['external'] );
				?>

				<!-- <a href="<?php echo $link; ?>" <?php if($slide['new_window'] == 1) echo 'target="_blank"'; ?>>
					<img src="<?php echo $slide['image']['sizes']['1200w']; ?>" alt="<?php echo $slide['image']['alt'] ?>" />
					<?php if(!empty($slide['caption'])): ?>
					<div class="caption"><?php echo $slide['caption']; ?></div>
					<?php endif; ?>
				</a> -->

			</li>

		<?php endforeach; ?>

		</ul>

	</div>
<?php endif; ?>

<!-- <div class="grid-container  top-padding">

	<div class="grid-6">
		<h3>The Hawke's Bay Knowledge Bank is a voluntary organisation based in Hastings, New Zealand.</h3>
		<p>Everything you see on the website has been collated, edited, and put together by members of the community who want to preserve the history of their region digitally, before physical records disappear in the ether of time. <a href="/about">Read more</a></p>

	</div>

	<div class="grid-6">

		<div class="homesearch">

			<form action="/" method="get" class="searchBar">

				<input class="search" type="text" placeholder="Search for a name, place or subject" required="" name="s" value="">
				<input class="button" type="button" value="Search">

			</form>

			<p>or try our <a href="/search">Advanced Search</a> page.</p>



		</div>


	</div>


</div>

<div class="grid-container">

	<div class="grid-12 centerheading">

		<h2>Explore</h2>

	</div>

</div> -->

<div class="grid-container bottom-margin ">

	<?php $landingpages = get_field('content_landing_pages'); ?>

	<?php if(!empty($landingpages)): ?>
		<div class="home-page">

			<div class="tiles tiles-3">
				<?php $NB=0;?>

				<?php foreach($landingpages as $page): ?>
					<?php $NB=$NB+1 ;?>
							<article class="tile">

								<div class="imageWrap" style="max-height :200px;">
									<div class="block-text">
										<p><?php echo $page['blurb']; ?></p>
									</div>

									<a href="<?php echo get_permalink($page['landing_page']->ID); ?>"><img src="<?php echo $page['image']['sizes']['300w']; ?>" alt="<?php echo $page['image']['alt'] ?>" /></a>

								</div>
								<div class="inner">
									<!-- <span title="blurb"> -->
										<a href="<?php echo get_permalink($page['landing_page']->ID); ?>"><h3><?php echo $page['landing_page']->post_title; ?></h3></a>
									<!-- </span> -->

								</div>


							</article>
							<?php if ($NB==4):?>
								<article class="tile">

									<div class="inner">
										<!-- <span title="blurb"> -->
											<div class="title-main"><a href="photonews"><h3>Photo News</h3></a></div>
											<div class="title-main" style="	border-top:1px solid rgba(70, 151, 48, 0.5);"><a href="collections"><h3>Collections</h3></a>
											</div>
											<div class="title-main" style="	border-top:1px solid rgba(70, 151, 48, 0.5);"><a href="books"><h3>Books</h3></a>
											</div>
										<!-- </span> -->

									</div>


								</article>


							<?php endif; ?>
							<?php if ($NB==3):?>
								</div>
								<div class="tiles tiles-4">
							<?php endif; ?>
				<?php endforeach; ?>
			</div>

		</div>

	<?php endif; ?>

</div>


<?php get_footer(); ?>
