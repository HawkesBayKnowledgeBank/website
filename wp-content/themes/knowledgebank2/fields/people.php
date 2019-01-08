<div class="col field field-people field-<?php echo $field['type']; ?>" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <?php
        if(!empty($field['value'])):
            echo '<ul>';            
            foreach($field['value'] as $person): ?>
                <li>
                    <?php
                        $record = false;
                        if(!empty($person['record'])) {
                            $record = $person['record'];
                            unset($person['record']);
                        }
                        $name = implode(' ', $person);
                        if(!empty($record)){
                            echo sprintf('<a href="%s">%s</a>', get_permalink($record->ID), $name);
                        }
                        else{
                            echo $name;
                        }
                    ?>
                </li>
                <?php
            endforeach;
            echo '</ul>';
        endif;
    ?>
</div>
