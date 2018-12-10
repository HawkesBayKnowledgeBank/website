<div class="col field field-<?php echo $field['type']; ?>" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <?php global $post; ?>
    <?php echo knowledgebank_get_date($field['name'], $post->ID); ?>
</div>
