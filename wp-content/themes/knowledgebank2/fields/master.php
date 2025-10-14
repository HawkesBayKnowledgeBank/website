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
    <h4>Non-commercial use</h4>

    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cc.png" style="float: right;" alt="Attribution-NonCommercial 3.0 New Zealand (CC BY-NC 3.0 NZ)"/>
    <p>This work is licensed under a <em><a href="https://creativecommons.org/licenses/by-nc/3.0/nz/" target="_blank">Attribution-NonCommercial 3.0 New Zealand (CC BY-NC 3.0 NZ).</a></em></p>


    <?php $commercial_licence = get_field('commercial_licence');  ?>
    <?php if(!empty($commercial_licence->post_content)): ?>
        <p>&nbsp;</p>
        <h4>Commercial Use</h4>
        <?php echo $commercial_licence->post_content; ?>
    <?php endif; ?>

</div>
<div id="donation-request">
        <div class="mfp-close">✖</div>
        <div class="donation-modal">            
            <h2>Can you help?</h2>
            <p>The Hawke's Bay Knowledge Bank relies on donations to make this material available. Please consider making a donation towards preserving our local history.</p>
            <p>Visit our <a href="https://knowledgebank.org.nz/about-us/donate/">donations</a> page for more information.</p>

        </div>


    </div>