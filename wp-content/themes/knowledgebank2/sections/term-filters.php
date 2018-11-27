<section class="layer controls terms">

    
    <div class="inner">

        <form class="filters" action="" method="get">
            <div class="controls-grid">

                <div class="control-option">
                    <label>Filter results by tags</label>
                    <select class="select2" name="filters[tags]" multiple="multiple">
                      <option value="tag1">Tag 1</option>
                      <option value="tag2">Tag 2</option>
                        <option value="tag3">Tag 3</option>
                    </select>
                </div><!-- .control-option -->

                <div class="control-option">
                    <label>View as</label>
                    <select class="select2-nosearch" name="filters[view_mode]" id="view-select">
                      <option value="tiles" class="tiles-option">Tiles</option>
                      <option value="rows" class="rows-option">Rows</option>
                    </select>
                </div><!-- .control-option -->

                <div class="control-option">
                    <label>Sort by</label>
                    <select class="select2-nosearch" name="filters[orderby]">
                        <option value="name">Name</option>
                        <option value="item-count">Item count</option>
                    </select>
                </div><!-- .control-option -->

                <div class="control-option">
                    <label>Order</label>
                    <select class="select2-nosearch" name="filters[order]">
                      <option value="ascending">Ascending</option>
                      <option value="descending">Descending</option>
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
