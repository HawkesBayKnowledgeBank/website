<?php
/*
	Template Name: Image Page
*/
?>

<?php get_header(); ?>

	<h1><?php the_title(); ?></h1>

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

		if( !empty($subjects)):
			foreach($subjects as $subject) : ?>

				<?php 
					//Not sure where I'm going wrong here. As I understand it,
					//we need to get the ID of a term(in our case $subject)
					//and pass it as an argument to get_term_link(). If this works
					//we should get a string to echo out in our <a href="">
					$termID = $subject->term_id;
					$termLinks = get_term_link($termID);
				?><a href="<?php echo $termLinks; ?>">	
					<?php echo $subject->name; ?></a> 
				
			<?php endforeach;
		endif;
		
	?>

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

			<?php //print_r($record); ?>
			<a href='<?php echo get_permalink($record->ID); ?>'>
			<h3><?php echo $record->post_title; ?></h3>
			</a>

			<?php 

				$images = get_field('images',$record->ID);

				if(!empty($images)): ?>

					<div class="grid-3 imageGallery">

						<?php foreach($images as $image): ?>

								<?php //print_r($image); ?>

								<?php if(isset($image['image']['sizes']['thumbnail'])): ?>

									<img src="<?php echo $image['image']['sizes']['thumbnail']; ?>" alt="<?php echo $image['image']['alt'] ?>" />		

								<?php endif; ?>


						<?php endforeach; ?>

					</div><!-- .imageGallery -->
			<?php

				endif;

			?>
				
			<hr style="clear:both;" />

		<?php endforeach; ?>

	<?php endif; ?>

	</div>


	<?php /*



	<section class="featured-text">

		<?php 

			$texts = get_field('featured_text'); //repeater field

			if(!empty($texts)):

				foreach($texts as $text):
			?>

					<div class="text post featured">

						<?php

							//get title, use override value if one is there
							$title = ( !empty($text['title']) ? $text['title'] : $text['post']->post_title );

							//get image, either from this row or from the post itself. That's a bit tricky.
							if( isset($text['image']['sizes']['300w']) ) :

								$image = $text['image']['sizes']['300w'];

							else:

								$postimage = get_field('images',$text->ID);

								if( !empty($postimage) && isset($postimage['sizes']['300w']) ) :

									$image = $postimage['sizes']['300w'];

								else :

									$image = false; //could use some kind of placeholder image here

								endif;

							endif;

						?>

						<h3>
							<a href="<?php echo get_permalink($text->ID); ?>">
								<?php echo $title; ?>
							</a>
						</h3>

						<?php if($image): ?>

							<img src="<?php echo $image; ?>" />

						<?php endif; ?>

					</div>

			<?php
				endforeach;

			endif;

		?>

	</section>



*/ ?>

<?php get_footer(); ?>
