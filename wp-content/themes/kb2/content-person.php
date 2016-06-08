<?php get_header(); ?>

<div class="lndngPgFtr">
				<img src="img/sliderImg.jpg" />
			</div>
	<ul class="namesList peopleList">
		<!-- Not sure if this is how we want to set $_GET variables and
		 the url's -->
		<!-- <li><a href='page-person.php?letter=a'>A</a></li>
		<li><a href='page-person.php?letter=b'>B</a></li>
		<li><a href='page-person.php?letter=c'>C</a></li>
		<li><a href='page-person.php?letter=d'>D</a></li>
		<li><a href='page-person.php?letter=e'>E</a></li>
		<li><a href='page-person.php?letter=f'>F</a></li>
		<li><a href='page-person.php?letter=g'>G</a></li>
		<li><a href='page-person.php?letter=h'>H</a></li>
		<li><a href='page-person.php?letter=i'>I</a></li>
		<li><a href='page-person.php?letter=j'>J</a></li>
		<li><a href='page-person.php?letter=k'>K</a></li>
		<li><a href='page-person.php?letter=l'>L</a></li>
		<li><a href='page-person.php?letter=m'>M</a></li>
		<li><a href='page-person.php?letter=n'>N</a></li>
		<li><a href='page-person.php?letter=o'>O</a></li>
		<li><a href='page-person.php?letter=p'>P</a></li>
		<li><a href='page-person.php?letter=q'>Q</a></li>
		<li><a href='page-person.php?letter=r'>R</a></li>
		<li><a href='page-person.php?letter=s'>S</a></li>
		<li><a href='page-person.php?letter=t'>T</a></li>
		<li><a href='page-person.php?letter=u'>U</a></li>
		<li><a href='page-person.php?letter=v'>V</a></li>
		<li><a href='page-person.php?letter=w'>W</a></li>
		<li><a href='page-person.php?letter=x'>X</a></li>
		<li><a href='page-person.php?letter=y'>Y</a></li>
		<li><a href='page-person.php?letter=z'>Z</a></li> -->
	</ul>
		<form class="searchBar">
		<label><h3 class="searchLabel">Search Names</h3></label>
		<input class="search" type='text' placeholder='Search...' required>
		<input class="button" type='button' value='Search'>
	</form>

	<?php 
		//identify rows that have the matching first letter of family name with
		//the letter that is clicked on

		//set $letter to our GET variable, if that variable is set and it's 1 character long (otherwise set $letter to '');
		$letter = ( isset($_GET['letter']) && strlen(utf8_decode($_GET['letter']) == 1) ? $_GET['letter'] : '' );


		if(!empty($letter)) :

			$rows = $wpdb->get_results($wpdb->prepare( 
	            "
	            SELECT post_id 
	            FROM {$wpdb->prefix}postmeta
	            WHERE meta_key LIKE %s
	                AND meta_value = %s
	            ",
	            'name_%_family_name',	            
	            $letter
	        ));

	        print_r($rows);    

			// loop through the results
			if( !empty($rows) ) :

				foreach( $rows as $row ) :


						preg_match('_([0-9]+)_', $row->meta_key, $matches);
						$meta_key = 'name_' . $matches[0] . '_family_name';

						$family_id = get_post_meta( $row->post_id, $meta_key, true );

						// $src = wp_get_attachment_image_src( $image_id, 'medium' ); 
					?>
						<div class="grid-container peopleNames">
							<div class="grid-3 peopleList">
							<!-- I'm thinking that we can simple echo out the title as it will be the name of the person.
							This way, we will end up with a list of names. -->
								<a href='<?php get_permalink( $row->post_id ); ?>'>
									<li><?php echo get_the_title( $row->post_id ); ?></li>
								</a>
							</div>
						</div>

	<?php
					

				endforeach; //foreach($rows)

			endif; //if($rows)

		endif; //if($letter)

	?>



<?php get_footer(); ?>