<section class="layer controls terms">


    <div class="inner">
        <?php
            global $wp;
            $current_url =  home_url( $wp->request );
            $position = strpos( $current_url , '/page' );
            $nopaging_url = ( $position ) ? substr( $current_url, 0, $position ) : $current_url;
            $nopaging_url = trailingslashit( $nopaging_url );

            if(is_page('photo-news')) $nopaging_url = '/collections/967/';
        ?>
        <form class="filters" action="<?php echo $nopaging_url; ?>" method="get">
            <div class="controls-grid">

                <div class="control-option searchfilter">
                    <?php
                        $term = get_queried_object();
                        $label = 'Search in <em>' . (!empty($term->name) ? $term->name :  get_the_title()) . '</em>';
                        if(!empty($mode) && $mode == 'Taxonomy') $label = 'Search <em>' . (!empty($term->name) ? $term->name :  get_the_title()) . '</em> by name';
                        if(is_post_type_archive()) $label = 'Search in <em>' . (!empty($term->label) ? $term->label :  get_the_title()) . '</em>';

                    ?>
                    <label><?php echo $label; ?></label>
                    <div class="searchfilter-wrap">
                        <input type="text" name="filters[search]" class="searchfilter" value="<?php if(!empty($filters['search'])) echo htmlspecialchars(stripslashes($filters['search'])); ?>" />
                        <input type="submit" value="Search" />
                    </div>
                </div><!-- .control-option -->

                <div class="control-option">
                    <label>Sort by</label>
                    <select class="select2-nosearch" name="filters[orderby]">
                        <?php $active_filter = !empty($filters['orderby']) ? $filters['orderby'] : ''; ?>
                        <option value="name" <?php if($active_filter == 'name') echo 'selected'; ?>>Name</option>
                        <?php /* <option value="date" <?php if($active_filter == 'date') echo 'selected'; ?>>Date Created</option> */ ?>
                    </select>
                </div><!-- .control-option -->

                <div class="control-option">
                    <label>Order</label>
                    <select class="select2-nosearch" name="filters[order]">
                      <?php $active_filter = !empty($filters['order']) ? $filters['order'] : ''; ?>
                      <option value="ASC" <?php if($active_filter == 'ASC') echo 'selected'; ?>>Ascending</option>
                      <option value="DESC" <?php if($active_filter == 'DESC') echo 'selected'; ?>>Descending</option>
                    </select>
                </div><!-- .control-option -->

                <div class="control-option">
                    <label>Items per page</label>
                    <select class="select2-nosearch" name="filters[number]">
                        <?php
                            foreach(range(20,80,20) as $number):
                                $selected = !empty($filters['number']) && $filters['number'] == $number ? 'selected' : '';
                                if(empty($selected) && $number == 20) $selected = 'selected';
                                echo sprintf('<option %s value="%d">%d</option>', $selected, $number, $number);
                            endforeach;
                        ?>
                    </select>
                </div><!-- .control-option -->


            </div>
        </form>

    </div>
</section>
