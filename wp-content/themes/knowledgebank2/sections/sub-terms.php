<?php
    $filters = knowledgebank_get_filters();
    $term_args = array( 'taxonomy' => $taxonomy_name, 'child_of' => $term_id, 'orderby' => 'name' );
    if(!empty($filters['search'])) $term_args['name__like'] = $filters['search'];
    $child_terms = get_terms($term_args);

?>
<?php if(!empty($child_terms)): ?>
<div class="sub-terms-wrap">
    <div class="grid column-5 sub-collections">

        <?php if(count($child_terms) > 10): ?>

            <?php foreach($child_terms as $child_term): ?>
                <?php
                    $link = get_term_link($child_term);
                    $image = get_field('image',$child_term->taxonomy . '_' . $child_term->term_id);
                ?>

                    <div class="col tile shadow">

                        <div class="tile-copy">
                            <h4><a href="<?php echo $link; ?>"><?php echo $child_term->name; ?></a></h4>
                            <p class="term-item-count"><?php echo $child_term->count; ?> items</p>
                            <?php if(!empty($child_term->description)): ?><p><?php echo $child_term->description; ?></p><?php endif; ?>

                        </div><!-- .tile-copy -->
                    </div><!-- .col -->

            <?php endforeach; ?>


        <?php else: ?>

            <?php foreach($child_terms as $child_term): ?>
                <?php
                    $link = get_term_link($child_term);
                    $image = get_field('image',$child_term->taxonomy . '_' . $child_term->term_id);
                ?>

                    <div class="col tile shadow">

                        <div class="tile-copy">
                            <h4><a href="<?php echo $link; ?>"><?php echo $child_term->name; ?></a></h4>
                            <p class="term-item-count"><?php echo $child_term->count; ?> items</p>
                            <?php if(!empty($child_term->description)): ?><p><?php echo $child_term->description; ?></p><?php endif; ?>

                        </div><!-- .tile-copy -->
                    </div><!-- .col -->

            <?php endforeach; ?>

        <?php endif; ?>


    </div><!-- .sub-collections -->
    <?php if(count($child_terms) > 10): ?>
        <span class="slide-count"><span class="current-index">1</span> / <?php echo count($child_terms); ?>
    <?php endif; ?>
</div><!-- .sub-collections-wrap -->



<?php endif; ?>
