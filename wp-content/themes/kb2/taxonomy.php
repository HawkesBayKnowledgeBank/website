<?php  get_header(); ?>
		
		<?php 

			$tid = get_queried_object_id();
			$term = get_term($tid);

			//get child collections, if any
			$children = get_terms( array(
			    'taxonomy' => 'collections',
			    'hide_empty' => false,
			    'parent' => $tid,
			));

		?>

		<div class="tax-header">

			<?php if(!empty($term->description)): ?>

				<div class="description">

					<?php echo $term->description; ?>

				</div><!-- . description -->
			<?php endif; ?>

			<?php if(!empty($children)): ?>

				<div class="subcollections tiles">

					<?php foreach($children as $child): ?>						

						<div class="subcollection tile">

							<h4><a href="<?php echo get_term_link($child->term_id); ?>"><?php echo $child->name; ?></a></h4>
							<h5><?php echo $child->count; ?></h5>

						</div><!-- .subcollection -->					

					<?php endforeach; ?>

				</div><!-- .subcollections -->
			<?php endif; ?>

		</div>


		<section class="tiles tiles-4">

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<?php get_template_part('tile', $post->post_type); ?>		
		<?php endwhile; ?>

		<?php 

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => 'Previous page',
				'next_text'          => 'Next Page',
				'before_page_number' => '',
			) );

		?>

		<?php else: ?>
			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'kb2' ); ?></h2>

			</article>
			<!-- /article -->
		<?php endif; ?>

		</section>



<?php get_footer(); ?>
