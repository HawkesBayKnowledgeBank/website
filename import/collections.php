<?php
    require_once('../wp-load.php');


    exit;
    //fixing images on collections

    $args = array(
        'taxonomy' => 'collections',
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'asc',
    );
    $collections = get_terms($args);

    foreach($collections as $collection):

        if(get_field('image','collections_' . $collection->term_id)) continue;

        //print_r($collection); exit;
        $args = array(
            'post_type' => array('still_image','text'),
            'posts_per_page' => 1,
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'collections',
                    'field' => 'id',
                    'terms' => $collection->term_id
                )
            ),
            'meta_query' => array(
                array(
                    'key' => 'images',
                    'compare' => 'EXISTS'
                )
            )
        );
        $images = get_posts($args);
        if(!empty($images[0])){
            $post_images = get_field('images', $images[0]->ID);
            if(!empty($post_images[0]['image']['id'])){
                //echo 'update ' . print_r($collection,true);
                echo 'Update ' . $collection->name . "\n";
                update_field('image', $post_images[0]['image']['id'], 'collections_' . $collection->term_id);
            }
        }
        else{
            echo 'No images for ' . $collection->name . "\n";
        }


    endforeach;

?>
