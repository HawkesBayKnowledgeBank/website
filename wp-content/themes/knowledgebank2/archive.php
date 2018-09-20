<?php get_header(); ?>

	<main role="main">

			<section class="layer intro intro-default">
				<div class="inner">
					<div class="intro-copy dark inner-700">
						<ul class="breadcrumbs">
							<li><a href="http://mogulframework.wpengine.com">Home</a></li><li>Browse</li>
						</ul>
						<h1>Browse</h1>
		  			<p>Default page intro text. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id.</p>
					</div><!-- .intro-copy -->
				</div><!-- .inner -->
			</section>


			<section class="layer searchbar-wrap" id="main-search">
				<div class="inner">
					<div class="searchbar">

						<form class="" action="index.html" method="post">
							<div class="top">
								<i class="mdi mdi-magnify"></i>
								<input type="text" name="" value="" placeholder="Keyword Search">
								<button type="submit" name="button">Search</button>
							</div>
							<div class="bottom">
								<button class="searchbar-toggle" type="button" name="Show options">Filter</button>
								<div class="searchbar-options">
									<ul>
										<li>
											<input type="checkbox" id="check_books" value="Books">
											<label for="check_books">Books</label>
										</li>
										<li>
											<input type="checkbox" id="check_images" value="Images">
											<label for="check_images">Images</label>
										</li>
										<li>
											<input type="checkbox" id="check_audio" value="Audio">
											<label for="check_audio">Audio</label>
										</li>
										<li>
											<input type="checkbox" id="check_video" value="Video">
											<label for="check_video">Video</label>
										</li>
										<li>
											<input type="checkbox" id="check_text" value="Text">
											<label for="check_text">Text</label>
										</li>
										<li>
											<input type="checkbox" id="check_people" value="People">
											<label for="check_people">People</label>
										</li>
									</ul>
									<span class="grow"></span>
									<a href="#">Tips</a>

								</div>
							</div>
						</form>

					</div>
				</div>
			</section>

			<section class="layer controls">
				<div class="inner">

					<form class="" action="index.html" method="post">
						<div class="controls-grid">

							<div class="control-option">
								<label>Filter results by tags</label>
								<select class="select2" name="tags[]" multiple="multiple">
								  <option value="tag1">Tag 1</option>
								  <option value="tag2">Tag 2</option>
									<option value="tag3">Tag 3</option>
								</select>
							</div><!-- .control-option -->

							<div class="control-option">
								<label>View as</label>
								<select class="select2-nosearch" name="View" id="view-select">
								  <option value="tiles" class="tiles-option">Tiles</option>
								  <option value="rows" class="rows-option">Rows</option>
								</select>
							</div><!-- .control-option -->

							<div class="control-option">
								<label>Sort by</label>
								<select class="select2-nosearch" name="View">
								  <option value="item-count">Item count</option>
								  <option value="name">Name</option>
								</select>
							</div><!-- .control-option -->

							<div class="control-option">
								<label>Order</label>
								<select class="select2-nosearch" name="View">
								  <option value="ascending">Ascending</option>
								  <option value="descending">Descending</option>
								</select>
							</div><!-- .control-option -->

							<div class="control-option">
								<label>Items per page</label>
								<select class="select2-nosearch" name="View">
								  <option value="5">5</option>
								  <option value="10">10</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="60">60</option>
								</select>
							</div><!-- .control-option -->


						</div>
					</form>

				</div>
			</section>


			<section class="layer results tiles ">
				<div class="inner">

					<div class="grid column-4 ">

			  		<div class="col tile shadow video">
							<div class="tile-img" style="background-image:url('img/quake.jpg')">
								<a href="#"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="#">Tile title</a></h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								<div class="button-group">
									<a href="#" class="button">Button</a>
								</div>
							</div><!-- .tile-copy -->
						</div><!-- .col -->

						<div class="col tile shadow image">
							<div class="tile-img" style="background-image:url('img/quake1.jpg')">
								<a href="#"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="#">Tile title</a></h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								<div class="button-group">
									<a href="#" class="button">Button</a>
								</div>
							</div><!-- .tile-copy -->
						</div><!-- .col -->

						<div class="col tile shadow audio">
							<div class="tile-img" style="background-image:url('img/quake2.jpg')">
								<a href="#"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="#">Tile title</a></h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								<div class="button-group">
									<a href="#" class="button">Button</a>
								</div>
							</div><!-- .tile-copy -->
						</div><!-- .col -->

						<div class="col tile shadow book">
							<div class="tile-img" style="background-image:url('img/quake3.jpg')">
								<a href="#"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="#">Tile title</a></h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								<div class="button-group">
									<a href="#" class="button">Button</a>
								</div>
							</div><!-- .tile-copy -->
						</div><!-- .col -->

						<div class="col tile shadow text">
							<div class="tile-img" style="background-image:url('img/quake1.jpg')">
								<a href="#"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="#">Tile title</a></h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								<div class="button-group">
									<a href="#" class="button">Button</a>
								</div>
							</div><!-- .tile-copy -->
						</div><!-- .col -->

						<div class="col tile shadow people">
							<div class="tile-img" style="background-image:url('img/quake2.jpg')">
								<a href="#"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="#">Tile title</a></h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								<div class="button-group">
									<a href="#" class="button">Button</a>
								</div>
							</div><!-- .tile-copy -->
						</div><!-- .col -->

						<div class="col tile shadow video">
							<div class="tile-img" style="background-image:url('img/quake.jpg')">
								<a href="#"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="#">Tile title</a></h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								<div class="button-group">
									<a href="#" class="button">Button</a>
								</div>
							</div><!-- .tile-copy -->
						</div><!-- .col -->

						<div class="col tile shadow image">
							<div class="tile-img" style="background-image:url('img/quake1.jpg')">
								<a href="#"></a>
							</div>
							<div class="tile-copy">
								<h4><a href="#">Tile title</a></h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								<div class="button-group">
									<a href="#" class="button">Button</a>
								</div>
							</div><!-- .tile-copy -->
						</div><!-- .col -->



					</div><!-- .grid -->

					<ul class="pagination">
						<li class="current-page"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#">6</a></li>
						<li><a href="#">7</a></li>
						<li><a href="#">8</a></li>
						<li><a href="#">9</a></li>
						<li class="elipses">...</li>
						<li><a href="#">Next ></a></li>
						<li><a href="#">Last >></a></li>
					</ul>

				</div><!-- .inner -->
			</section>

	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
