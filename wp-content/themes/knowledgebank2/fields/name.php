<div class="col field field-default" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <?php if(!empty($field['value'][0])): ?>
        <?php foreach($field['value'] as $name): ?>
            <?php echo implode(' ', $name); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
