<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="pageTitles">
			<h1><?php the_title(); ?></h1>		

			<?php the_content(); ?>

		</div>
		
		<section class="tiles tiles-4 years">

			<?php 

				$years = get_terms( array(
				    'taxonomy' => 'collections',    
				    'child_of' => 968,
				    'hide_empty' => false,
				) );

			?>

			<?php if(!empty($years)) : ?>

				<?php foreach($years as $year): ?>

						<div <?php post_class('tile'); ?>>

							<div class="imageWrap">

								<?php $image = get_field('image','collections_' . $year->term_id); ?>

								<?php if(isset($image['sizes']['700w'])): ?>

									<a href="<?php echo get_term_link($year->term_id); ?>"><img src="<?php echo $image['sizes']['700w']; ?>" /></a>

								<?php endif; ?>

							</div>	

							<div class="inner">

								<h2><a href="<?php echo get_term_link($year->term_id); ?>"><?php echo $year->name; ?></a></h2>
								<p><?php echo $year->count; ?> items</p>								

							</div>
							
						</div>

				<?php endforeach; ?>

			<?php endif; ?>

		</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
