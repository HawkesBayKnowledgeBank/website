<div class="col field field-parents field-<?php echo $field['type']; ?>" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <ul>
    <?php
        foreach($field['value'] as $person): ?>
            <li>
                <?php
                    $record = false;
                    if(!empty($person['record'])) {
                        $record = $person['record'];
                        unset($person['record']);
                    }
                    $name = implode(' ', $person);
                    if(!empty($record->ID) && get_post_status($record->ID) == 'publish'){
                        echo sprintf('<a href="%s" target="_blank">%s</a>', get_permalink($record->ID), $name);
                    }
                    else{
                        echo $name;
                    }
                ?>
            </li>
            <?php
        endforeach;
    ?>
    </ul>
</div>
