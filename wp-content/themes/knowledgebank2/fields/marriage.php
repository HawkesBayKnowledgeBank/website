<div class="col field field-marriage field-<?php echo $field['type']; ?>" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <div class="rows">
    <?php foreach($field['value'] as $index => $marriage): ?>
        <div class="row">

            <?php if(!empty($marriage['marriage_date'])): ?>

                <?php
                    $_date = $marriage['marriage_date'];
                    $_date_accuracy = $marriage['marriage_date_accuracy'];
                    $_date_dt = DateTime::createFromFormat('Ymd', $marriage['marriage_date']);
                    if(!empty($_date_dt)){

                        switch($_date_accuracy){

                            case '365':
                                $_date = $_date_dt->format('Y');
                            break;

                            case '30':
                                $_date = $_date_dt->format('F Y');
                            break;

                            default:
                                $_date = $_date_dt->format('d F Y');
                            break;

                        }
                    }

                ?>
                <div class="marriage-date">
                    <label>Marriage date</label>
                    <?php echo $_date; ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($marriage['marriageplace'])): ?>
                <div class="marriage-place">
                    <label>Place of Marriage</label>
                    <?php echo $marriage['marriageplace']; ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($marriage['spouse'])): ?>
                <div class="marriage-spouse">
                    <label>Spouse</label>
                    <?php echo $marriage['spouse']; ?>
                </div>
            <?php endif; ?>

        </div><!-- .row -->

    <?php endforeach; ?>

    </div><!-- .rows -->

</div><!-- .field -->
