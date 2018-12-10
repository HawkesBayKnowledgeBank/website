<div class="col field field-default" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <?php if(!empty($field['value'][0]->ID)): ?>

        <?php
            $links = array_map(function($related_post){
                return sprintf('<a href="%s" target="_blank">%s</a>',get_permalink($related_post->ID),$related_post->post_title);
            },$field['value']);
            echo implode(', ', $links);
        ?>

    <?php endif; ?>
</div>
