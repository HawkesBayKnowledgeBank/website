<section class="layer searchbar-wrap" id="main-search">
    <div class="inner">
        <div class="searchbar">

            <form class="" action="/" method="get">
                <div class="top">
                    <i class="mdi mdi-magnify"></i>
                    <input type="text" name="s" value="<?php echo get_search_query(); ?>" placeholder="Keyword Search">
                    <button type="submit">Search</button>
                </div>
                <div class="bottom">
                    <button class="searchbar-toggle" type="button" name="Show options">Filter</button>
                    <div class="searchbar-options">
                        <?php $post_type = !empty($_GET['post_type']) ? $_GET['post_type'] : array(); ?>
                        <ul>
                            <li id="search_all_li">
                                <input type="checkbox" name="" id="search_all" value="all" <?php if(empty($post_type) || count($post_type) == 6) echo 'checked'; ?>>
                                <label for="search_all">All</label>
                            </li>
                            <li>
                                <input type="checkbox" id="check_images" name="post_type[]" value="still_image" <?php if(empty($post_type) || in_array('still_image',$post_type)) echo 'checked'; ?>>
                                <label for="check_images">Images</label>
                            </li>
                            <li>
                                <input type="checkbox" id="check_audio" name="post_type[]" value="audio"  <?php if(empty($post_type) || in_array('audio',$post_type)) echo 'checked'; ?>>
                                <label for="check_audio">Audio</label>
                            </li>
                            <li>
                                <input type="checkbox" id="check_video" name="post_type[]" value="video"  <?php if(empty($post_type) || in_array('video',$post_type)) echo 'checked'; ?>>
                                <label for="check_video">Video</label>
                            </li>
                            <li>
                                <input type="checkbox" id="check_text" name="post_type[]" value="text"  <?php if(empty($post_type) || in_array('text',$post_type)) echo 'checked'; ?>>
                                <label for="check_text">Text</label>
                            </li>
                            <li>
                                <input type="checkbox" id="check_people" name="post_type[]" value="person"  <?php if(empty($post_type) || in_array('person',$post_type)) echo 'checked'; ?>>
                                <label for="check_people">People</label>
                            </li>
                            <li>
                                <input type="checkbox" id="check_books" name="post_type[]" value="bibliography"  <?php if(empty($post_type) || in_array('bibliography',$post_type)) echo 'checked'; ?>>
                                <label for="check_books">Books</label>
                            </li>
                        </ul>
                        <span class="grow"></span>

                        <a href="<?php echo get_permalink(347205); ?>" class="search-tips"><span class="mdi mdi-help-circle"></span> <?php echo get_the_title('347205'); ?></a>

                    </div>
                </div>
            </form>

        </div>
    </div>
</section>
