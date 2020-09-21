<?php $acknowledgements = $field['value']; ?>
<?php if(!empty($acknowledgements)): ?>
    <div class="col field field-acknowledgements" data-field-name="<?php echo $field['name']; ?>">
            <h4><?php echo $field['label'];?></h4>
            <?php foreach($acknowledgements as $a): ?>
                <?php switch($a){

                    case 'hbt':
                    ?>
                        <p>Published with permission of Hawke's Bay Today</p>

                    <?php
                    break;

                    default:
                    ?>
                        <p><?php echo $a; ?></p>
                    <?php
                    break;

                } ?>

            <?php endforeach; ?>

    </div>
<?php endif; ?>
