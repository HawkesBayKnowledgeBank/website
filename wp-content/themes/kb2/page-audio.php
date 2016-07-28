<?php get_header(); ?>


	<div class="container">

		<div class="pageTitles">

		<h1><?php the_title(); ?></h1>
		<?php
		//identify rows that have the matching first letter of family name with
		//the letter that is clicked on

		//set $letter to our GET variable if that variable is set, otherwise false
		$letter = ( isset($_GET['letter']) ? $_GET['letter'] : false );


		if($letter) :

			//match family_name on our letter, with both coverted to lowercase in case either is uppercase

			$rows = $wpdb->get_results($wpdb->prepare(
	            "
	            SELECT post_id
	            FROM {$wpdb->prefix}postmeta
	            WHERE meta_key LIKE %s
	                AND LOWER(meta_value) LIKE %s
	            ORDER BY LOWER(meta_value)
	            ",
	            'name_%_family_name',
	            strtolower($letter) . '%' //family names starting with our letter
	        ));

			$counter = 0;
			$number_of_rows = count($rows);

	        //print_r($rows);   ?>
		<div class="grid-container peopleNames">
		<?php	// loop through the results
			if( !empty($rows) ) :

				foreach( $rows as $row ) : //rows contain just post ids for our people

						//Get the person
						$person = get_post($row->post_id);

						$name = get_field('name',$person->ID);
						//print_r($name);

						$images = get_field('images',$person->ID);
						//print_r($images);

						//etc - see http://new.knowledgebank.org.nz/wp-admin/post.php?post=36254&action=edit for more field names
						$counter++;
					?>

							<div class="grid-4 peopleList">

									<a href="<?php echo get_permalink( $person->ID ); ?>">
										<li><?php echo $name[0]['family_name'] . ', ' . $name[0]['first_name'] . ' ' . $name[0]['middle_names'] ?></li>
									</a>


								<?php if(!empty($images) && isset($images[0]['image']['sizes']['thumbnail'])): ?>

										<a href="<?php echo get_permalink( $person->ID ); ?>">
											<img src="<?php echo $images[0]['image']['sizes']['thumbnail']; ?>" />
										</a>

								<?php endif; ?>

							</div>


					<?php if ( $counter % 3 == 0 && $counter != $number_of_rows) : ?>

        				</div><div class="grid-container peopleNames">

        			<?php endif; ?>

				<?php


				endforeach; //foreach($rows)


			endif; //if($rows) ?>

		</div> <!-- close grid-container div -->

		<?php endif; //if($letter)

	?>
		<h3>Latest Posts</h3>

	</div>

	<?php

		$args = array(

			'post_type' => 'audio',

			'posts_per_page' => 5

		);

		$latest_posts = get_posts($args);

	?>

	<div class="grid-container">

		<?php

			if( !empty( $latest_posts ) ) :

				 foreach( $latest_posts as $latest_post ) : ?>

				 	<div class="grid-1-5 image-subjects-links">

				 		<a href='<?php echo get_permalink( $latest_post->ID ); ?>'>

				 			<?php echo $latest_post->post_title; ?>

				 		</a>

				 	</div>

				<?php endforeach;

			endif; ?>

	</div>

	<div class="pageTitles">
		
		<h3>Search our archive of Oral Interviews</h3>
	
	</div>	

	<?php 

		$args = array(

			'post_type' => 'audio',

		);

		$audios = new WP_Query($args);

	?>

	<div class="grid-container">
		
	<?php if( $audios->have_posts() ) : ?>

		<?php while( $audios->have_posts() ) : ?>

			<?php $audios->the_post(); ?>

				<div class="grid-4 image-subjects-links">
					
					<a href="<?php echo get_permalink(); ?>">
						
						<?php the_title(); ?>
					
					</a>
					
				</div>

				<?php $audio_count = $audios->current_post+1; ?>

				<?php if ( $audio_count % 3 == 0 && $audio_count != $audios->post_count) : ?>
        		
        			</div><div class='grid-container'>
      				
      			<?php endif; ?>

		<?php endwhile; ?>

	<?php endif; ?>

	</div>



</div>

<?php get_footer(); ?>
