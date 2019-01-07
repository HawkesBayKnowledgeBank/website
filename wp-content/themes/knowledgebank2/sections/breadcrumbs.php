<ul class="breadcrumbs">
	<li><a href="/">Home</a></li>
    <?php

        if(is_archive()){

            $term = get_queried_object();
            //print_r($term);

            echo sprintf('<li><a href="/%s">%s</a></li> ', $term->taxonomy, ucwords($term->taxonomy));

            $ancestors = get_ancestors($term->term_id, $term->taxonomy, 'taxonomy');
            if(!empty($ancestors)){
                foreach($ancestors as $ancestor_id){
                    $ancestor = get_term_by('id', $ancestor_id, $term->taxonomy);
                    if(!empty($ancestor)){
                        echo sprintf('<li><a href="%s">%s</a></li> ', get_term_link($ancestor), $ancestor->name);
                    }
                }
            }

            echo sprintf('<li>%s</li>', $term->name);

        }

		if(is_single()){

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

			echo sprintf('<li>%s</li>', $post->post_title);

		}

		//Blog page
		global $wp_query;
		if ( isset( $wp_query ) && (bool) $wp_query->is_posts_page ) {
			$posts_page_id = get_option('page_for_posts');
			echo sprintf('<li>%s</li>', get_the_title($posts_page_id));
		}



    ?>

</ul>
