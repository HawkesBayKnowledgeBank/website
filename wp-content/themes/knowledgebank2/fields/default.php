<div class="col field field-default field-<?php echo $field['type']; ?>" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <?php
        if(is_array($field['value']) || is_object($field['value'])) {
            print_r($field['value']);
        }else{
            echo $field['value'];
        }
    ?>
</div>
