<?php
    require_once('../wp-load.php');

    $audio = get_posts(array(
        'post_type' => 'audio',
        'posts_per_page' => -1,
        'post_status' => 'any'
    ));

    foreach($audio as $post){
        knowledgebank_audio_create_web_from_master($post->ID);
        echo "Done {$post->ID}\n";
    }
