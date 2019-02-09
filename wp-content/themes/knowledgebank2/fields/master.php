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
    <h4>License</h4>
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cc.png" style="float: right;" alt="Creative Commons Attribution-NonCommercial 4.0 International License">
    <p>This work is licensed under a <em><a href="https://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License.</a></em></p>
    <div class="button-group">
        <a href="<?php echo get_permalink(284547); ?>" class="button">Commercial licensing</a><br/>
    </div>
</div>
