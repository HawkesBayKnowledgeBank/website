<?php $acknowledgements = $field['value']; ?>
<?php if(!empty($acknowledgements)): ?>
    <div class="col field field-acknowledgements" data-field-name="<?php echo $field['name']; ?>">
            <h4><?php echo $field['label'];?></h4>
            <?php foreach($acknowledgements as $a): ?>

                <p>Published with permission of <em><?php echo $a; ?></em></p>

            <?php endforeach; ?>

    </div>
<?php endif; ?>
