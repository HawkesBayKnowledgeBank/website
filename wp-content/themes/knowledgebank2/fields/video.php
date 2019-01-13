<section class="layer video">
    <div class="inner">
        <div class="videoWrapper">

                <?php $youtube_id = get_field('youtube_id'); ?>
                <?php if(!empty($youtube_id)): ?>
                    <iframe width="1903" height="701" src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <?php else: ?>
                    <video controls>
                        <source src="<?php echo $field['value']['url']; ?>" type="<?php echo $field['value']['mime_type']; ?>">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
        </div>
    </div>
</section>
