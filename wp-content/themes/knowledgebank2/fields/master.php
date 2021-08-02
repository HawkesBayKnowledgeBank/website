<div class="col field field-master" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <p class="file-name"><?php echo $field['value']['filename']; ?></p>
    <div class="button-group">

        <?php


            $file_type = $field['value']['type'];
            $file_sub_type = $field['value']['subtype'];
            if($file_sub_type == 'pdf') $file_type = 'pdf';
        ?>

        <a href="<?php echo $field['value']['url']; ?>" class="button download <?php echo $file_type; ?>" target="_blank">Download <span><?php echo formatBytes($field['value']['filesize']);?></span></a>

    </div>
</div>
<div class="col">
    <h4>Licence</h4>
    <?php $licence = get_field('licence'); ?>
    <?php if($licence == 'a-nc'): ?>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cc.png" style="float: right;" alt="Attribution-NonCommercial 3.0 New Zealand (CC BY-NC 3.0 NZ)"/>
        <p>This work is licensed under a <em><a href="https://creativecommons.org/licenses/by-nc/3.0/nz/" target="_blank">Attribution-NonCommercial 3.0 New Zealand (CC BY-NC 3.0 NZ).</a></em></p>

    <?php elseif($licence == 'copyright'): //todo - sort this mess out ?>

        <?php $acknowledgements = get_field('acknowledgements'); ?>

        <?php if(is_array($acknowledgements) && in_array("Hawke's Bay Today",$acknowledgements)): ?>

            <p>Copyright on this material is owned by Hawke's Bay Today and is not available for commercial use without their consent.</p>

            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cc.png" style="float: right;" alt="Attribution-NonCommercial 3.0 New Zealand (CC BY-NC 3.0 NZ)"/>
            <p>For non-commercial use, this work is licensed under a <em><a href="https://creativecommons.org/licenses/by-nc/3.0/nz/" target="_blank">Attribution-NonCommercial 3.0 New Zealand (CC BY-NC 3.0 NZ).</a></em></p>

        <?php elseif(is_array($acknowledgements) && in_array("Wairoa Star",$acknowledgements)): ?>

            <p>Copyright on this material is owned by The Wairoa Star and is not available for commercial use without their consent.</p>

            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cc.png" style="float: right;" alt="Attribution-NonCommercial 3.0 New Zealand (CC BY-NC 3.0 NZ)"/>
            <p>For non-commercial use, this work is licensed under a <em><a href="https://creativecommons.org/licenses/by-nc/3.0/nz/" target="_blank">Attribution-NonCommercial 3.0 New Zealand (CC BY-NC 3.0 NZ).</a></em></p>

        <?php else: ?>

            <p>This copyright for this work belongs to a third party, it is published here by permission.</p>

        <?php endif; ?>

    <?php else:?>

        <p>Unspecified</p>

    <?php endif; ?>

    <?php if(get_field('allow_commercial_licence')): ?>
        <div class="button-group">
            <a href="<?php echo get_permalink(284547); ?>" class="button">Commercial licensing</a><br/>
        </div>
    <?php endif; ?>

</div>
