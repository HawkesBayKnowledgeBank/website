<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="pageTitles">
			
	<h1><?php the_title(); ?></h1>

	<?php the_content(); ?>

</div>

<div class="advancedSearchOptions">
	
	<h3>Basic Search</h3>

</div>

<form action="/" method="get" class="searchBar">
	
	<input class="search" type="text" placeholder="Search for a name, place or subject" required="" name="s" value="">
	<input class="button" type="submit" value="Search">

</form>

<form class="basicSrchFilters">
		
		<div class="radioTxtAlign">

			<input  class="advancedSearchDateAll" name='advancedSearch[date]' type='radio' value='all' checked='checked'>
			<label for='advanced_search_date_all'>Search for all of these words</label><br>
			<input class="searchDateRange" name='advancedSearch[date]' type='radio' value='range' checked='checked'>
			<label for='advancedSearchDateRange'>Search for any of these words</label>
			<br>
			<input class="searchDateRange" name='advancedSearch[date]' type='radio' value='range' checked='checked'>
			<label for='advancedSearchDateRange'>Search for exactly this phrase</label>
		
		</div>

</form>

<div class="advancedSearchOptions">
	
	<h3>Advanced Search</h3>

</div>
	
<form action="/" method="get" class="searchBar">

	<input class="search" type="text" placeholder="Search..." required="" name="s" value="">
	<input class="button" type="submit" value="Search">

</form>

<form class="advncdSearchFilters">

	<input type="checkbox" id="audio" class="srchChckBoxes" value="search_audio" name="user_search"><label class="chckBoxLabel" for="audio">Audio</label>
	<input type="checkbox" id="images" class="srchChckBoxes" value="search_images" name="user_search"><label class="chckBoxLabel" for="images">Images</label>
	<input type="checkbox" id="maps" class="srchChckBoxes" value="search_maps" name="user_search"><label class="chckBoxLabel" for="maps">Maps</label><br class="chckBoxBreak">
	<input type="checkbox" id="publications" class="srchChckBoxes" value="search_publications" name="user_search"><label class="chckBoxLabel" for="publications">Publicaitons</label>
	<input type="checkbox" id="videos" class="srchChckBoxes" value="search_videos" name="user_search"><label class="chckBoxLabel" for="video">Video</label>

</form>

<?php endwhile; endif; ?>

<?php get_footer(); ?>