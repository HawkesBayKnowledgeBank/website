<?php
    if(!empty($field['value'][0]->ID)):
        $links = array_map(function($related_post){
            if(get_post_status($related_post->ID) != 'publish') return false;
            return sprintf('<a href="%s" target="_blank">%s</a>',get_permalink($related_post->ID),$related_post->post_title);
        },$field['value']);

        $links = array_filter($links);

        if(!empty($links)):
?>
            <div class="col field field-default" data-field-name="<?php echo $field['name']; ?>">
                <h4><?php echo $field['label'];?></h4>
                <ul>
                    <li>
                        <?php echo implode('</li><li>', $links); ?>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
<?php endif; ?>
