<div class="col field field-master" data-field-name="<?php echo $field['name']; ?>">
    <h4><?php echo $field['label'];?></h4>
    <p class="file-name"><?php echo $field['value']['filename']; ?></p>
    <div class="button-group">
        <a href="<?php echo $field['value']['url']; ?>" class="button download pdf" target="_blank">Download <span><?php echo formatBytes($field['value']['filesize']);?></span></a>
        <!--<a href="#" class="button download image">Download <span>1.3MB</span></a>
        <a href="#" class="button download video">Download <span>1.3MB</span></a>
        <a href="#" class="button download audio">Download <span>1.3MB</span></a> -->
    </div>
</div>
<div class="col">
    <h4>License:</h4>
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cc.png" style="float: right;" alt="Creative Commons Attribution-NonCommercial 4.0 International License">
    <p>This work is licensed under a <a href="https://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License.</a></p>
    <p><a href="#">About commercial licensing</a></p>
    <div class="button-group">
        <a href="#" class="button">Purchase commercial license</a>
    </div>
</div>
