<?php get_header(); ?>
<?php $filters = knowledgebank_get_filters(); ?>
<?php
    global $wp_query;

    $extra_classes = array();

    $title = get_the_archive_title();

    if(is_tax()){

        $term = get_queried_object();

        $term_id = $term->term_id;
        $taxonomy = get_taxonomy($term->taxonomy);
        $taxonomy_name = $term->taxonomy;


        if(!empty($term->name)) $title = $term->name; //get_the_archive_title();
        if($term->parent == 967){
            $title = "Hawke's Bay Photo News - " . $term->name;
        }
        if(get_field('display_title', $term)) $title = get_field('display_title', $term);


        if($term->term_id == 967 || $term->parent == 967){
            $extra_classes[] = 'photo-news';
        }
    }
    elseif(is_post_type_archive()){
        $post_type = get_queried_object();
        $title = $post_type->label;
    }

?>

    <main role="main">

            <section class="layer intro intro-default">
                <div class="inner">
                    <div class="intro-copy dark inner-700">
                        <?php get_template_part('sections/breadcrumbs'); ?>
                        <h1><?php echo $title; ?></h1>
                          <?php if(!empty($term->description)) echo "<p>{$term->description}</p>"; ?>
                    </div><!-- .intro-copy -->
                </div><!-- .inner -->
            </section>

            <?php include_once(get_template_directory() . '/sections/term-filters.php'); //include rather than get_template_part so we can share $filters ?>

            <!-- sub-terms -->
            <section class="layer results tiles <?php echo implode(' ', $extra_classes); ?>">
                <div class="inner">

                    <?php if(is_tax()) include('sections/sub-terms.php'); ?>

                    <?php /* <h5>Records in <?php echo single_cat_title( '', false ); ?></h5> */ ?>
                    <div class="grid column-4 ">

                        <?php

                            // global $wp_query;
                            // if(!empty($_GET['filters']['search'])){ //replace main query with a special searchy one
                            //
                            //     //set taxonomy and term for query
                            //     $taxonomy = get_query_var('taxonomy'); //passed via $_GET
                            //     $term = get_query_var('term');
                            //
                            //     $query_term = get_queried_object(); //or get from the context if we are viewing a term
                            //     if(!empty($query_term->taxonomy)) $taxonomy = $query_term->taxonomy;
                            //     if(!empty($query_term->slug)) $term = $query_term->slug;
                            //
                            //     $args = array(
                            //         'tax_query' => array(
                            //             array(
                            //                 'taxonomy' => $taxonomy,
                            //                 'field' => 'slug',
                            //                 'terms' => $term,
                            //             )
                            //         ),
                            //         'order' => get_query_var('order'),
                            //         'orderby' => get_query_var('orderby'),
                            //         'posts_per_page' => -1,
                            //         's' => $_GET['filters']['search'],
                            //     );
                            //     $wp_query = new WP_Query();
                            //     $wp_query->parse_query( $args );
                            //     relevanssi_do_query( $wp_query );
                            //
                            // }

                        ?>

                        <?php if($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post(); ?>

                            <?php

                                $type = $post->post_type;
                                $images = get_field('images', $post->ID);
                                $image = !empty($images[0]['image']) ? $images[0]['image'] : false;
                                if(empty($image)) $image = get_field('image');


                                $link = get_permalink($post->ID);
                                $image_size = 'thumbnail';
                                if(is_tax() && !empty($term->term_id) && ($term->term_id == 967 || $term->parent == 967) ) $image_size = 'medium';//medium for photo news
                            ?>

                              <div class="col tile shadow <?php echo $type; ?>">

                                <?php
                                    $src = '/wp-content/themes/knowledgebank2/img/placeholder-400.png'; //default
                                    if($post->post_type == 'video' && get_field('youtube_id', $post->ID)) $src = sprintf('https://img.youtube.com/vi/%s/0.jpg', get_field('youtube_id', $post->ID));
                                    if(!empty($image['sizes'][$image_size])) $src = $image['sizes'][$image_size];
                                ?>

                                <div class="tile-img lazy" style="background-image:url(/wp-content/themes/knowledgebank2/img/placeholder-400.png)" data-src="<?php echo $src; ?>">
                                    <a href="<?php echo $link; ?>"></a>
                                </div>

                                <div class="tile-copy">
                                    <h4><a href="<?php echo $link; ?>"><?php echo $post->post_title; ?></a></h4>
                                        <?php //the_excerpt(); ?>
                                        <?php
                                            if($type == 'audio') { //see if we have an mp3 and/or ogg
                                                $mp3 = get_field('audio', $post->ID);
                                                $ogg = false;
                                                $master = get_field('master', $post->ID);
                                                if(!empty($master['mime_type']) && $master['mime_type'] == 'audio/ogg'){
                                                    $ogg = $master['url'];
                                                }
                                                if(!empty($mp3) || !empty($ogg)): ?>
                                                <audio controls>
                                                  <?php if($mp3): ?><source src="<?php echo $mp3['url']; ?>" type="<?php echo $mp3['mime_type']; ?>"><?php endif; ?>
                                                  <?php if($ogg): ?><source src="<?php echo $ogg; ?>" type="audio/ogg"><?php endif; ?>
                                                  Your browser does not support the audio element.
                                                </audio>
                                                <?php endif;
                                            }

                                        ?>
                                    <div class="button-group">
                                        <a href="<?php echo $link; ?>" class="button">View Details</a>
                                    </div>
                                </div><!-- .tile-copy -->
                            </div><!-- .col -->

                            <?php endwhile; ?>

                        <?php else: ?>

                            <p>No results found</p>

                        <?php endif; ?>

                    </div><!-- .grid -->
                    <?php if(empty($_GET['filters']['search'])): ?>
                    <ul class="pagination">
                        <?php knowledgebank_numeric_posts_nav(); ?>
                    </ul>
                    <?php endif; ?>

                </div><!-- .inner -->
            </section>

    </main>

<?php get_footer(); ?>
