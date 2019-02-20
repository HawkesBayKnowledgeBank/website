<?php
    //maybe output a caption with each image
    $transcript = get_field('transcript');
    if(!empty($transcript)){
        $captions = preg_split('/<hr ?\/?>/', $transcript);//pages are delimited by <hr /> (match variations <hr> and <hr/>)
    }
?>

<?php if(count($images) > 1): ?>

    <section class="layer book-slider-wrap">
        <div class="inner">
            <div class="book-slider">

                <?php foreach($images as $index => $image): $image = $image['image']; //image :) ?>

                <div class="slide-wrap">

                    <div class="book-slide">
                        <div class="caption">
                            <div class="caption-inner">
                                <?php if(!empty($captions[$index])): ?>
                                <?php echo $captions[$index]; ?>
                                <?php endif; ?>
                            </div><!-- .caption-inner -->
                        </div><!-- .caption -->
                        <?php
                            if($index > 3){ //lazy load everything after image 3
                                $src = sprintf('src="" data-lazy-src="%s"',$image['sizes']['large']);
                            }
                            else{
                                $src = sprintf('src="%s"',$image['sizes']['large']);
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

<?php else: ?>
    <section class="layer media-slider-wrap">
            <div class="inner">
                <div class="media-slider">

                    <?php foreach($images as $index => $image): $image = $image['image']; //image :) ?>

                    <div class="media-slide">
                        <div class="media-slide-inner">
                            <?php
                                if($index > 3){ //lazy load everything after image 3
                                    $src = sprintf('src="" data-lazy-src="%s"',$image['sizes']['large']);
                                }
                                else{
                                    $src = sprintf('src="%s"',$image['sizes']['large']);
                                }
                            ?>
                            <img <?php echo $src; ?> alt="<?php echo $image['alt']; ?>" />
                            <a href="<?php echo $image['url']; ?>" class="zoom">
                                <i class="mdi mdi-magnify"></i>
                            </a>
                        </div>
                        <?php if(!empty($captions[$index])): ?>
                        <div class="caption">
                            <?php echo $captions[$index]; ?>
                        </div>
                    <?php endif; ?>
                    </div><!-- .media-slide -->

                    <?php endforeach; ?>

                </div><!-- .media-slider -->
            </div>
        </section>


<?php endif; //count)$images) ?>