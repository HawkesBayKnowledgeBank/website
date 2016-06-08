<?php get_header(); ?>
<div class="pageTitles">
	<h1><?php the_title(); ?></h1>
	<h3>Latest Images</h3>
</div>

<?php

	$args = array(
		'post_type' => 'still_image',
		'posts_per_page' => 5
	);

	$latest_posts = get_posts($args);

?>

<div class="grid-container">
	<?php if( !empty($latest_posts) ) :
		foreach($latest_posts as $latest_post) : ?>

		<div class='grid-1-5'>
				<?php $images = get_field('images', $latest_post->ID); ?>
				<?php if( !empty($images) ) :
					foreach($images as $image) : ?>
						<a href="<?php echo get_permalink( $latest_post->ID ); ?>"> 
							<img src="<?php echo $image['image']['sizes']['thumbnail']; ?>" alt="<?php echo $image['image']['alt']; ?>">
						</a>
					<?php endforeach;
				endif; 
				?>
		</div>

		<?php endforeach;
	endif;
	?>
</div>
<div class="pageTitles">
		<h3>Search our archive of images by subject</h3>
	</div>	
<div class="grid-container">
	
	
	<?php

		$subjects = $wpdb->get_results(
			"
			SELECT DISTINCT t.term_id, t.name 
			FROM `wp_term_taxonomy` tt 
			LEFT JOIN `wp_term_relationships` tr ON tt.term_taxonomy_id = tr.term_taxonomy_id 
			LEFT JOIN `wp_posts` p ON tr.object_id = p.ID 
			LEFT JOIN `wp_terms` t ON t.term_id = tt.term_id 
			WHERE p.post_type = 'still_image' 
			AND tt.taxonomy = 'subject'
			ORDER BY tt.term_id ASC
			"
		);

		$counter = 0; //used to keep track of loop iterations so styling is correct
		$number_of_subjects = count($subjects); // 

		if( !empty($subjects)):
			foreach($subjects as $subject) : ?>

				<?php 
					//Not entirely sure that this is correct. 
					//I couldn't get it to work last night, but it's going now??
					//Also, I tried applying the post type filter but it doesn't seem 
					//to work.
					$termID = $subject->term_id;
					$termLinks = get_term_link($termID, 'subject');
					$postTypeLink = "?post_type=still_image";
					$subjectPermalink = $termLinks . $postTypeLink;
					$counter++;
				?>
				<div class="grid-4 image-subjects-links">
					<a href="<?php echo $subjectPermalink; ?>">	
						<?php echo $subject->name; ?>
					</a> 
				</div>
				
      			<?php if ( $counter % 3 == 0 && $counter != $number_of_subjects) : ?>
        			</div><div class="grid-container">
        		<?php endif; ?>

			<?php endforeach;
		endif;
		
	?>

</div>

	<?php 
		$args = array(
			'post_type' => 'still_image',
			'posts_per_page' => 20,
		);
		
		$records = get_posts($args);
		
	?>
	<div class="grid-container">
	<?php if ( !empty($records) ):  ?>

		<?php foreach($records as $record): ?>
			<div class="grid-3 imageGallery">
			<?php //print_r($record); ?>
			<a href='<?php echo get_permalink($record->ID); ?>'>
			<h3><?php echo $record->post_title; ?></h3>
			</a>

			<?php 

				$images = get_field('images',$record->ID);

				if(!empty($images)): ?>

					

						<?php foreach($images as $image): ?>

								<?php //print_r($image); ?>

								<?php if(isset($image['image']['sizes']['thumbnail'])): ?>

									<img src="<?php echo $image['image']['sizes']['thumbnail']; ?>" alt="<?php echo $image['image']['alt']; ?>" />		

								<?php endif; ?>


						<?php endforeach; ?>

					</div><!-- .imageGallery -->
			<?php

				endif;

			?>
				
			<!-- <hr style="clear:both;" /> -->

		<?php endforeach; ?>

	<?php endif; ?>

	</div>

<?php get_footer(); ?>
