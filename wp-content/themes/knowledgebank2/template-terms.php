<?php /* Template Name: Term listing */ ?>
<?php
/**
* This template is for listing terms in a specified taxonomy, or subterms of a specified term.
*/
?>

<?php get_header();  ?>

    <?php

        $mode = get_field('mode');

        //arguments for get_terms()
        $args = array(
            'hide_empty' => 1,
            'offset' => 0,
            //'number' => 20,
            'meta_query' => array(),
        );

        $description = '';

        if($mode == 'Taxonomy'):
            $taxonomy = get_field('display_taxonomy');
            $description = $taxonomy[0]->description;

            if($taxonomy[0]->name == 'post_tag'){
                $description = 'Tags are informal subjects or topics used to group related material.';
            }

            $args['taxonomy'] = $taxonomy[0]->name;
            $args['parent'] = 0;  //NB this makes wp_term_query ignore number and offset params, but we will fake them with array_slice on the full result set

            if($taxonomy[0]->name == 'collections') :

                $args['meta_query'][] = array(
                    'key' => 'public',
                    'value' => 1,
                );

            endif;

        else:
            $display_term = get_field('display_term');
            $description = $display_term[0]->description;
            $args['taxonomy'] = $display_term[0]->taxonomy;
            $args['child_of'] = $display_term[0]->term_id;
        endif;

    ?>
    <main role="main">

            <section class="layer intro intro-default">
                <div class="inner">
                    <div class="intro-copy dark inner-700">
                        <?php //get_template_part('sections/breadcrumbs'); ?>
                        <h1><?php the_title(); ?></h1>
                        <p><?php echo $description; ?></p>
                    </div><!-- .intro-copy -->
                </div><!-- .inner -->
            </section>
            <?php $filters = knowledgebank_get_filters(); ?>
            <?php include_once(get_template_directory() . '/sections/term-filters.php'); ?>

            <?php

                //search filtering if applicable
                if(!empty($filters['search'])){
                    $args['name__like'] = $filters['search'];
                }//$filters['search']

                //ordering
                if(!empty($filters['order'])){
                    $args['order'] = $filters['order'];
                }
                if(!empty($filters['orderby'])){
                    $args['orderby'] = $filters['orderby'];
                }


                //Get terms - note this will likely return all of them
                $term_query = new WP_Term_Query( $args );


                //Pagination - we fake this with array_slice on the whole term result set, because reasons
                if(!empty($filters['number']) && is_numeric($filters['number'])){
                    $args['number'] = $filters['number']; //per page
                }
                else{
                    $args['number'] = 20;
                }


                if(!empty($_GET['term_page']) && is_numeric($_GET['term_page'])){
                    $offset = $args['number'] * ($_GET['term_page'] - 1); //eg on page 2, with 20 posts per page, we skip 20 * (2-1)
                    $args['offset'] = $offset;
                }
                else{
                    $args['offset'] = 0;
                }

                $all_terms = !empty($term_query->terms) ? count($term_query->terms) : 0;

                $terms = !empty($term_query->terms) ? array_slice($term_query->terms,$args['offset'],$args['number']) : [];


            ?>
            <section class="layer results tiles <?php echo $args['taxonomy']; ?> ">
                <div class="inner">

                    <div class="grid column-4 ">

                        <?php if(!empty($terms)): ?>

                            <?php foreach($terms as $term): ?>

                                <?php

                                    $link = get_term_link($term);
                                    $image = get_field('image',$term->taxonomy . '_' . $term->term_id);

                                ?>

                                <div class="col tile shadow">

                                    <?php if($term->taxonomy == 'collections'): ?>
                                        <?php $src = !empty($image['sizes']['thumbnail']) ? $image['sizes']['thumbnail'] : '/wp-content/themes/knowledgebank2/img/placeholder-400.png';    ?>
                                        <div class="tile-img lazy" style="background-image:url(/wp-content/themes/knowledgebank2/img/placeholder-400.png)" data-src="<?php echo $src; ?>">
                                            <a href="<?php echo $link; ?>"></a>
                                        </div>
                                    <?php endif; ?>

                                    <div class="tile-copy">
                                        <h4><a href="<?php echo $link; ?>"><?php echo $term->name; ?></a></h4>
                                        <p><div class="term-item-count"><?php echo $term->count; ?> items</div><div class="term-content-types"><?php echo knowledgebank_term_content_type_icons($term); ?></div></p>
                                        <?php if(!empty($term->description)): ?><p><?php echo $term->description; ?></p><?php endif; ?>
                                        <div class="button-group">
                                            <a href="<?php echo $link; ?>" class="button">View</a>
                                        </div>
                                    </div><!-- .tile-copy -->
                                </div><!-- .col -->

                            <?php endforeach; ?>

                        <?php else: ?>

                            <p>No results found</p>

                        <?php endif; ?>


                    </div><!-- .grid -->



                    <ul class="pagination">
                        <?php
                            //pagination
                            $total_terms = !empty($term_query->terms) ? count($term_query->terms) : 0;
                            $max_pages = ceil($total_terms / $args['number']);
                            if($max_pages > 1):
                                foreach(range(1,$max_pages) as $page_number):
                                    if($page_number == 0) continue;
                                    $term_page = !empty($_GET['term_page']) ? $_GET['term_page'] : 1;
                                    $current_page = $term_page == $page_number ? 'active' : '';
                                    $url_params = array('term_page' => $page_number, 'filters' => $filters);
                                    $url = get_permalink() . '?' . http_build_query($url_params);

                            ?>
                                <li class="<?php echo $current_page; ?>"><a href="<?php echo $url; ?>"><?php echo $page_number; ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>



                </div><!-- .inner -->
            </section>

    </main>

<?php get_footer(); ?>
