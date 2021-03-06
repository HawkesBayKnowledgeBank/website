<div class="col field field-marriage field-<?php echo $field['type']; ?>" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <div class="rows">
    <?php foreach($field['value'] as $index => $marriage): ?>
        <div class="row">

            <div class="marriage-date">
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
                    <label>Marriage date</label>
                    <?php echo $_date; ?>
                <?php endif; ?>
            </div>

            <div class="marriage-place">
                <?php if(!empty($marriage['marriageplace'])): ?>
                    <label>Place of Marriage</label>
                    <?php echo $marriage['marriageplace']; ?>
                <?php endif; ?>
            </div>

            <div class="marriage-spouse">
                <?php if(!empty($marriage['spouse'])): ?>
                <label>Spouse</label>
                <?php echo $marriage['spouse']; ?>
                <?php endif; ?>
            </div>


        </div><!-- .row -->

    <?php endforeach; ?>

    </div><!-- .rows -->

</div><!-- .field -->
