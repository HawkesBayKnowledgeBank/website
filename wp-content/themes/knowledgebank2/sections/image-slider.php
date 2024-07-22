<?php
//maybe output a caption with each image
$transcript = (string)get_field('transcript');
if (!empty($transcript)) {
    $captions = preg_split('/<hr ?\/?>/', $transcript); //pages are delimited by <hr /> (match variations <hr> and <hr/>)
}
global $post;
?>

<?php if (count($images) > 1 && $post->post_type != 'still_image') : ?>

    <section class="layer book-slider-wrap">
        <div class="inner">
            <div class="book-slider">

                <?php foreach ($images as $index => $image_row) :
                    $image = $image_row['image'];
                    if (!is_array($image)) continue;
                ?>

                    <div class="slide-wrap">
                        <?php
                        $caption_class = 'nocaption'; //unless we find otherwise
                        if (!empty($captions[$index])) $caption_class = '';
                        if (!empty($image_row['caption']) && !empty($image_row['show_caption'])) $caption_class = '';;
                        ?>
                        <div class="book-slide <?php echo $caption_class; ?>">
                            <?php if (!empty($captions[$index])) : ?>
                                <div class="caption">
                                    <div class="caption-inner">
                                        <?php echo $captions[$index]; ?>
                                    </div><!-- .caption-inner -->
                                </div><!-- .caption -->
                            <?php elseif (!empty($image_row['caption']) && !empty($image_row['show_caption'])) : ?>
                                <div class="caption">
                                    <div class="caption-inner">
                                        <?php echo $image_row['caption']; ?>
                                    </div><!-- .caption-inner -->
                                </div><!-- .caption -->
                            <?php endif; ?>
                            <?php
                            if ($index > 3) { //lazy load everything after image 3
                                $src = sprintf('src="" data-lazy-src="%s"', $image['sizes']['large']);
                            } else {
                                $src = sprintf('src="%s"', $image['sizes']['large']);
                            }
                            ?>
                            <img <?php echo $src; ?> alt="<?php echo $image['alt']; ?>" />
                            <a href="<?php echo $image['url']; ?>" class="zoom">
                                <i class="mdi mdi-magnify"></i>
                            </a>

                        </div><!-- .book-slide -->

                    </div><!--.slide-wrap -->

                <?php endforeach; ?>

            </div><!-- .book-slider -->
        </div>
    </section>

<?php else : ?>
    <section class="layer media-slider-wrap">
        <div class="inner">
            <div class="media-slider <?php if (count($images) == 1) echo 'singular'; ?>">

                <?php foreach ($images as $index => $image) :

                    //single captions from the image, not from transcript
                    $caption = !empty($image['caption']) && !empty($image['show_caption']) ? $image['caption'] : false;

                    if (empty($image['image'])) continue;
                    $image = $image['image']; //image :) 

                ?>

                    <div class="media-slide">
                        <div class="media-slide-inner">
                            <?php
                            if ($index > 3) { //lazy load everything after image 3
                                $src = sprintf('src="" data-lazy-src="%s"', $image['sizes']['large']);
                            } else {
                                $src = sprintf('src="%s"', $image['sizes']['large']);
                            }
                            ?>
                            <img <?php echo $src; ?> alt="<?php echo $image['alt']; ?>" />
                            <a href="<?php echo $image['url']; ?>" class="zoom">
                                <i class="mdi mdi-magnify"></i>
                            </a>
                        </div>

                        <?php if (!empty($captions[$index]) || !empty($caption)) : ?>
                            <div class="caption">
                                <?php if (!empty($captions[$index])) echo $captions[$index]; ?>
                                <?php if (!empty($caption)) echo $caption; ?>
                            </div>
                        <?php endif; ?>
                    </div><!-- .media-slide -->

                <?php endforeach; ?>

            </div><!-- .media-slider -->
        </div>
    </section>


<?php endif; //count)$images) 
?>