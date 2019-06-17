<?php global $wp_query; ?>
<p>Showing <?php echo $wp_query->found_posts; ?> results</p>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	<?php if($post->post_status != 'publish' || $post->ID == 113310) continue; ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('search-results'); ?>>

		<!-- post thumbnail -->
		<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-thumbnail">
				<?php
					$images = get_field('images', $post->ID);
					if(!empty($images[0]['image']['sizes']['thumbnail'])){
						echo sprintf('<img src="%s" alt="%s" />', $images[0]['image']['sizes']['thumbnail'], $images[0]['image']['alt']);
					}
					else {
						the_post_thumbnail('thumbnail'); // Declare pixel size you need inside the array
					}
				?>
			</a>
		<?php endif; ?>
		<!-- /post thumbnail -->

		<!-- post title -->
		<h4>
			<span class="icon-content-type <?php echo $post->post_type; ?>"></span>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h4>
		<!-- /post title -->
		<ul class="breadcrumbs">
		<?php
			//get hierarchical collection list
			$collections = knowledgebank_get_collections($post->ID);
			//grab one... could potentially deal with multiple though
			if(!empty($collections)){

				echo sprintf('<li><a href="%s">%s</a></li> ', '/collections/', 'Collections');

				$collection = array_shift($collections);
				echo sprintf('<li><a href="%s">%s</a></li> ', get_term_link($collection->term_id), $collection->name);
				if(!empty($collection->children)){
					$children = $collection->children;
					do{
						$child = array_shift($children);
						echo sprintf('<li><a href="%s">%s</a></li> ', get_term_link($child->term_id), $child->name);
						$children = $child->children;
					} while (!empty($children));
				}
			}

			if($post->post_type == 'post'){
				$posts_page_id = get_option('page_for_posts');
				echo sprintf('<li><a href="%s">%s</a></li>', get_permalink($posts_page_id),get_the_title($posts_page_id));
			}


			if($post->post_type == 'bibliography'){
				echo '<li><a href="/bibliography">Bibliography</a></li>';
			}
		?>
		</ul>
		<!-- /post details -->

		<?php knowledgebank_excerpt(); // Build your custom callback length in functions.php ?>

	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h4>Sorry, no results were found.</h4>
	</article>
	<!-- /article -->

<?php endif; ?>
