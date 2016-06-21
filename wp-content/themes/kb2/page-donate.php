<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>

<div class="pageTitles">
	
	<h1><?php the_title(); ?></h1>

</div>

<div class='aboutPageContent'>

<?php the_content(); ?>

</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>