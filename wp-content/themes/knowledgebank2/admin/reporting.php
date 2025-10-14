<style>

    #dateform { display:flex; align-items:center; padding:20px; background-color:#fff;}
    .collection { padding:20px; background-color:#f8f8f8;}
    .subcollections, .collection-posts { padding:20px; background-color:#fff;margin:10px 0; }
    h3 { font-size:18px; }
    .subcollections h4 { font-size:16px;}
    .subcollections h4, .subcollections h4 ul { margin:0;}
</style>
<div class="kb_reports">


    <h3>At a glance</h3>
    <?php
        $collections = get_terms([
            'taxonomy' => 'collections',
            'hide_empty' => false
        ]);

        $parents = array_filter($collections, function($collection){
            return $collection->parent == 0;
        });

        $subcollections = array_filter($collections, function($collection){
            return $collection->parent != 0;
        });

        $published = array_filter($parents, function($collection){
            return !empty(get_field('public','term_' . $collection->term_id));
        });

        $empty = array_filter($parents, function($collection){
            return empty($collection->count);
        });

    ?>
    <p>
        <b>Collections:</b><?php echo count($parents); ?></br>
        <b>Subcollections:</b><?php echo count($subcollections); ?></br>
    </p>
    <p>
        <b>Public:</b> <?php echo count($published); ?><br/>
        <b>Unpublished:</b>  <?php echo (count($parents) - count($published)); ?>
        <b>Empty:</b> <?php echo count($empty); ?>
    </p>

    <?php

        $oral_history = get_posts([
            'post_type' => 'audio',
            'posts_per_page' => -1,
            'post_status' => 'any',
            'tax_query' => [
                [
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => ['oral-history']
                ]
            ]
        ]);
        $oral_history_published = array_filter($oral_history,function($post){
            return $post->post_status == 'publish';
        });

    ?>
    <p><b>Oral history:</b> <?php echo count($oral_history); ?> (<?php echo count($oral_history_published); ?> published)</b>

    <?php
        global $wpdb;
        foreach(['audio','still_image','text','video','person'] as $post_type){

            $posts_count = $wpdb->get_var("SELECT count(id) FROM $wpdb->posts WHERE post_type = '$post_type'");

            $published_count = $wpdb->get_var("SELECT count(id) FROM $wpdb->posts WHERE post_type = '$post_type' AND post_status= 'publish'");
            echo "<p><b>$post_type:</b> $posts_count ($published_count published)</p>";

        }

    ?>
        

    <?php
        $managed_post_types = array('audio','still_image','text','video','person','revision');
        $managed_post_types_sql = "'" . implode("','", $managed_post_types)  . "'";

        $dt = new DateTime();

        if(!empty($_POST['month'])) {
            $dt->modify($_POST['month']);
        }
    ?>

    <form  id="dateform" action="/wp-admin/admin.php?page=knowledgebank_reporting" method="post"><input type="month" name="month" max="<?php echo date('Y-m'); ?>" value="<?php echo $dt->format('Y-m'); ?>"  /><input type="submit" /></form>


<?php

    global $wpdb;


    $rows = $wpdb->get_results("SELECT * from $wpdb->posts WHERE year(post_modified) = {$dt->format('Y')} and month(post_modified) = {$dt->format('m')} AND post_type IN ($managed_post_types_sql) order by post_modified desc");


    //go through and get any revision parents, which may or may not be in the data already

    $posts = [];
    foreach($rows as $row){
        if($row->post_type == 'revision'){
            $posts[] = $row->post_parent;
        }
        else{
            $posts[] = $row->ID;
        }
    }

    $posts = array_unique($posts); //de-dupe


    //analyse for collections

    $collections = [];

    foreach($posts as $post){
        $post_collections = get_the_terms($post,'collections');
        if(!empty($post_collections)){
            foreach($post_collections as $pc){
                if(empty($collections[$pc->term_id])) $collections[$pc->term_id] = $pc;
            }
        }
    }

    //get any parent collections which might be missing (if we somehow got only a child collection)
    foreach($collections as $c){
        if(!empty($c->parent) && empty($collections[$c->parent])) $collections[$c->parent] = get_the_term($c->parent,'collections');
    }


    // usort($collections, function($a,$b){
    //     return $a->name < $b->name ? -1 : 1;
    // });

    echo count($posts) . ' records updated across ' . count($collections) . ' collections and subcollections';


    //parents

    foreach($collections as $c):

        if(!empty($c->parent)) continue;

        echo '<div class="collection">';

            echo '<h3><a href="' . get_term_link($c) . '" target="_blank">' . $c->name . '</a></h3>';

            $subcollections = [];
            foreach($collections as $_c){
                if($_c->parent == $c->term_id){
                    $subcollections[] = $_c;
                }
            }

            $terms = [$c->term_id];

            if(!empty($subcollections)){
                echo '<div class="subcollections">';
                echo '<h4>Subcollections</h4>';
                echo '<ul>';
                foreach($subcollections as $s){
                    echo '<li><a href="' . get_term_link($s) . '" target="_blank">' . $s->name . '</a></li>';
                    $terms[] = $s->term_id;
                }
                echo '</ul>';
                echo '</div>';
            }

            $collection_posts = get_posts([
                'post_type' => $managed_post_types,
                'post_status' => 'any',
                'posts_per_page' => -1,
                'tax_query' => [
                    [
                        'taxonomy' => 'collections',
                        'field' => 'id',
                        'terms' => $terms
                    ]
                ],
                'post__in' => $posts
            ]);

            if(!empty($collection_posts)){
                echo '<div class="collection-posts">';
                echo '<h4>Records</h4>';
                echo '<ul>';
                foreach($collection_posts as $cp){
                    echo '<li><a href="' . get_permalink($cp->ID) . '" target="_blank">' . $cp->post_title . '</a></li>';
                }
                echo '</ul>';
                echo '</div>';


            }


        echo '</div>';

    endforeach;


 ?>


</div>
