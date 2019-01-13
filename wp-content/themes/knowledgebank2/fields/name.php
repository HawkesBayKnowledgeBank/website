<div class="col field field-name" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
        <?php foreach($field['value'] as $name): ?>
            <?php echo implode(' ', $name); ?>
        <?php endforeach; ?>
</div>
