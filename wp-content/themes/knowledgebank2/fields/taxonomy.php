<div class="col field field-taxonomy field-<?php echo $field['type']; ?>" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <ul>
        <?php
            foreach($field['value'] as $term){
                echo sprintf('<li><a href="%s">%s</a></li>', get_term_link($term->term_id), $term->name);
            }
        ?>
    </ul>
</div>
