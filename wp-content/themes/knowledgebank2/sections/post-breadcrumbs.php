<ul class="breadcrumbs tile-breadcrumbs">
<?php
    //get hierarchical collection list
    global $post;
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
