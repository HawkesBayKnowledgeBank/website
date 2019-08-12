<?php /* Template Name: Admin Find Content */ ?>
<?php if(!is_user_logged_in()) { wp_redirect('/'); exit; } ?>
<?php acf_form_head(); ?>
<?php get_header(); ?>

	<main role="main">


		<div id="find-content">
			<?php
				$settings = array(
					'id' => 'kb-find-content',
					'form' => false,
					'field_groups' => array('group_5d2ed9acaaee0'),
					'html_after_fields' => '<input type="submit" value="Submit" />'
				);
			?>
			<section class="layer single-column">
				<div class="inner thin content">
					<h2>Find content</h2>
					<form action="" method="post">
						<?php acf_form($settings); ?>
					</form>



				</div><!-- .inner -->
			</section>

			<?php if(!empty($_POST)): ?>
			<pre>
			    <?php

				print_r($_POST);


			    ?>
			</pre>
			<?php endif; ?>

			<?php

				//defaults
				$args = array(
					'post_type' => array('audio','still_image','text','video','person'),
					'posts_per_page' => 50,
					'post_status' => 'any',
					'orderby' => 'date',
					'order' => 'DESC'
				);


				$search_posts = get_posts($args);
				print_r($search_posts[0]);


			?>

			<?php if(!empty($search_posts)): ?>
			<section class="layer results table">
				<div class="inner">
					<table>
						<thead>
							<tr>
								<th>Title</th>
								<th>Type</th>
								<th>Last updated</th>
								<th>Updated by</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($search_posts as $p): ?>
							<tr>
								<td data-title=""><a href="<?php echo get_permalink($p->ID); ?>"><?php echo $p->post_title; ?></a></td>
								<td data-title=""><?php echo $p->post_type; ?></td>
								<td data-title=""><?php echo $p->post_modified; ?></td>
								<td data-title="">
									<?php
										$revision_author_id = get_post_meta($p->ID, '_edit_last', true );
										if(!empty($revision_author_id)){
											$revision_author = get_user_by('id',$revision_author_id);
											echo $revision_author->display_name;
										}
									?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div><!-- .inner -->
			</section>
			<?php endif; ?>


		</div>

	</main>

<?php get_footer(); ?>
