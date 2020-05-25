<section class="field-section layer">
    <div class="inner">
        <div class="col field field-audio" data-field-name="<?php echo $field['name']; ?>">
            <?php
                //check if we have a master ogg
                global $post;
                $master = get_field('master', $post->ID);
                $ogg = false;
                if(!empty($master['mime_type']) && $master['mime_type'] == 'audio/ogg'){
                    $ogg = $master['url'];
                }
            ?>
            <audio controls>
              <source src="<?php echo $field['value']['url']; ?>" type="<?php echo $field['value']['mime_type']; ?>">
              <?php if($ogg): ?><source src="<?php echo $ogg; ?>" type="audio/ogg"><?php endif; ?>
              Your browser does not support the audio element.
            </audio>
        </div><!--.field -->
    </div><!-- .inner -->
</section>
