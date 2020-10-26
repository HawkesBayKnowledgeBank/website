<?php

    require_once('../wp-load.php');

    $posts = get_posts(
        array(
            'post_type' => 'any',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'collections',
                    'terms' => [731],
                    'field' => 'term_id'
                )
            )
        )
    );

    // //print_r($posts);
    // foreach($posts as $post){
    //
    //     wp_set_object_terms($post->ID, [3303], 'collections');
    //     echo "Done $post->ID \n";
    //
    // }

?>
