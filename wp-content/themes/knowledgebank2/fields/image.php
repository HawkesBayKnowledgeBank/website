<div class="col field field-image field-<?php echo $field['type']; ?>" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <?php
        $src = !empty($field['value']['sizes']['medium']) ? $field['value']['sizes']['medium'] : $field['value']['url'];
        $title = !empty($field['value']['title']) ? $field['value']['title'] : '';
        $alt = !empty($field['value']['alt']) ? $field['value']['alt'] : '';
        $link = $field['value']['url'];
    ?>
    <a href="<?php echo $link; ?>"><img src="<?php echo $src; ?>" title="<?php echo $title; ?>" alt="<?php echo $alt; ?>" /></a>
</div>
