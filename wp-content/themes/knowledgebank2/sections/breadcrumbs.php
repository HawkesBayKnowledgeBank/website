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

    ?>


</ul>
