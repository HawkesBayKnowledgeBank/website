<div class="col field field-collections field-<?php echo $field['type']; ?>" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <?php
        global $post;
        //get hierarchical collection list
        $collections = knowledgebank_get_collections($post->ID);
        //grab one... could potentially deal with multiple though
        if(!empty($collections)){
            $collection = array_shift($collections);
            echo sprintf('<a href="%s">%s</a>', get_term_link($collection->term_id), $collection->name);
            if(!empty($collection->children)){
                $children = $collection->children;
                do{
                    $child = array_shift($children);
                    echo sprintf(' > <a href="%s">%s</a>', get_term_link($child->term_id), $child->name);
                    $children = $child->children;
                } while (!empty($children));
            }
        }
    ?>
</div>
