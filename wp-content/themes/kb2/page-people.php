<?php get_header(); ?>

	
	<div class="container">
		
		<div class="pageTitles">
		
		<h1><?php the_title(); ?></h1>
		<h3>Latest Posts</h3>
	
	</div>
	
	<?php
		
		$args = array(

			'post_type' => 'person',

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

	<ul class="grid-container namesList link-hover peopleList">

		<li class='col-1-8'><a href='people?letter=a'>A</a></li>
		<li class='col-1-8'><a href='people?letter=b'>B</a></li>
		<li class='col-1-8'><a href='people?letter=c'>C</a></li>
		<li class='col-1-8'><a href='people?letter=d'>D</a></li>
		<li class='col-1-8'><a href='people?letter=e'>E</a></li>
		<li class='col-1-8'><a href='people?letter=f'>F</a></li>
		<li class='col-1-8'><a href='people?letter=g'>G</a></li>
		<li class='col-1-8'><a href='people?letter=h'>H</a></li>
	</ul>
		
	<ul class="grid-container namesList link-hover peopleList">
		<li class='col-1-8'><a href='people?letter=i'>I</a></li>
		<li class='col-1-8'><a href='people?letter=j'>J</a></li>
		<li class='col-1-8'><a href='people?letter=k'>K</a></li>
		<li class='col-1-8'><a href='people?letter=l'>L</a></li>
		<li class='col-1-8'><a href='people?letter=m'>M</a></li>
		<li class='col-1-8'><a href='people?letter=n'>N</a></li>
		<li class='col-1-8'><a href='people?letter=o'>O</a></li>
		<li class='col-1-8'><a href='people?letter=p'>P</a></li>
	</ul>

	<ul class="grid-container namesList link-hover peopleList">
		
		<li class='col-1-8'><a href='people?letter=q'>Q</a></li>
		<li class='col-1-8'><a href='people?letter=r'>R</a></li>
		<li class='col-1-8'><a href='people?letter=s'>S</a></li>
		<li class='col-1-8'><a href='people?letter=t'>T</a></li>
		<li class='col-1-8'><a href='people?letter=u'>U</a></li>
		<li class='col-1-8'><a href='people?letter=v'>V</a></li>
		<li class='col-1-8'><a href='people?letter=w'>W</a></li>
		<li class='col-1-8'><a href='people?letter=x'>X</a></li>
	</ul>
	
	<ul class="grid-container namesList link-hover peopleList">
		<li class='col-1-8'><a href='people?letter=y'>Y</a></li>
		<li class='col-1-8'><a href='people?letter=z'>Z</a></li>
	</ul>


	<form class="searchBar">
		<?php get_search_form(); ?>
	</form>

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

</div>

<?php get_footer(); ?>