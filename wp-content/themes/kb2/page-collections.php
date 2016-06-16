<?php get_header(); ?>

<div class="grid-container collections-list">



	<?php

		// List terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)
		 
		$taxonomy     = 'collections';
		$orderby      = 'name'; 
		$show_count   = true;
		$pad_counts   = false;
		$hierarchical = true;
		$title        = '';
		 
		$args = array(
		  'taxonomy'     => $taxonomy,
		  'orderby'      => $orderby,
		  'show_count'   => $show_count,
		  'pad_counts'   => $pad_counts,
		  'hierarchical' => $hierarchical,
		  'title_li'     => $title
		);
	?>
 
	<ul class="collections">
	    <?php wp_list_categories( $args ); ?>
	</ul>



</div>

<?php get_footer(); ?>