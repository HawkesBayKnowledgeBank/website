<?php acf_form_head(); ?>
<?php if(!empty($_GET['kbsearch'])): ?>


    <?php

        $managed_post_types = array('audio','still_image','text','video','person');

    ?>



<?php endif; ?>

<style>
    .results { }
    .results .result-row { display:flex; flex-wrap: wrap; padding:10px; }
    .results .result-row:nth-of-type(2n) { background-color:#ddd;}
    .results .result-row .result-col { width:20%;}

    .results .result-row .result-col.title { width:30%;}

    .results .result-row .result-col.created,
    .results .result-row .result-col.author,
    .results .result-row .result-col.modified_by,
    .results .result-row .result-col.modified { width:10%;}

    .results .result-row .result-col.type,
    .results .result-row .result-col.edit { width:5%; }

    .results .result-row .result-col.checkbox { width: 40px;}

</style>

<div id="find-content">
    <h2>Find content</h2>

    <form id="filters" method="get" action="">

        <div class="search-controls">

            <div class="search-control">

                <label>Title</label>
                <input name="xxx[post_title_like]" value="<?php echo !empty($_GET['xxx']['post_title']) ? htmlentities($_GET['xxx']['post_title']) : ''; ?>" type="text" />

                <label>Type</label>
                <select multiple=true name="xxx[post_type][]">
                    <?php $allowed = array('audio','still_image','text','video','person'); ?>
                    <?php foreach(get_post_types(['public' => true],'objects') as $content_type): ?>
                        <?php if(!in_array($content_type->name, $allowed)) continue; ?>
                        <?php $selected = !empty($_GET['xxx']['post_type']) && in_array($content_type->name, $_GET['xxx']['post_type']) ? 'selected' : ''; ?>
                        <option value="<?php echo $content_type->name; ?>" <?php echo $selected; ?>><?php echo $content_type->labels->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!-- .search-control -->
            <div class="search-control">
                <label>Status</label>
                <select name="xxx[post_status]">
                    <?php foreach(array('any' => 'Any', 'publish' => 'Published', 'draft' => 'Draft', 'pending' => 'Pending') as $status => $label): ?>
                        <?php $selected = !empty($_GET['xxx']['post_status']) && $_GET['xxx']['post_status'] == $status ? 'selected' : ''; ?>
                        <option value="<?php echo $status; ?>"><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!-- .search-control -->
            <div class="search-control">
                <label>Author / Editor</label>
                <select name="xxx[user][]" multiple="true">
                    <?php $users = get_users(); ?>
                    <?php foreach($users as $user): ?>
                        <?php $selected = !empty($_GET['xxx']['user']) && in_array($user->ID, $_GET['xxx']['user']) ? 'selected' : ''; ?>
                        <option value="<?php echo $user->ID; ?>" <?php echo $selected; ?>><?php echo $user->display_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!-- .search-control -->

        </div><!-- .search-controls -->

        <input type="hidden" name="page" value="knowledgebank_content_manager" /><!-- ensure we reload this same page when submitting the form -->
        <input type="hidden" name="kbsearch" value="1" />

        <input type="submit" value="Submit" />

    </form>

    <?php

        $default_args = array(
            'post_type' => array('still_image','audio','video', 'text', 'person'),
            'posts_per_page' => 100,
            'post_status' => 'any',
            'orderby' => 'modified',
            'order' => 'DESC',
            'meta_query' => array(),
            'tax_query' => array(),
        );

        $kb_args = array_filter($_GET['xxx']);


        //transform some of our args for Wordpress

        //post title needs a query filter temprarily added for our search query
        if(!empty($kb_args['post_title'])){
            add_filter( 'posts_where', 'title_like_posts_where', 10, 2 );
            function title_like_posts_where( $where, $wp_query ) {
                global $wpdb;
                if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
                    $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $post_title_like ) ) . '%\'';
                }
                return $where;
            }
        }

        //users - authors or revision authors
        if(!empty($kb_args['user'])){

            $user_ids = $kb_args['user'];
            unset($kb_args['user']);

            //author
            $kb_args['author'] = $user_ids; //include all specified users as possible authors

            //last edited by
            $kb_args['meta_query'][] = array(
                'key' => '_edit_last',
                'value' => $user_ids,
                'compare' => 'IN'
            );

        }


        //...

        //Stop; query time.
        $args = wp_parse_args($kb_args, $default_args);

        $results = new WP_Query($args);

        echo $results->post_count . ' results';


        //Remove the post title filter if we added it. Still fine to run if we didn't.
        remove_filter( 'posts_where', 'title_like_posts_where', 10, 2 );


    ?>

    <div class="results">

        <?php

            $columns = array(
                'checkbox' => '',
                'type' => 'Type',
                'edit' => 'Edit',
                'title' => 'Title',
                'created' => 'Created',
                'author' => 'Author',
                'modified' => 'Last modified',
                'modified_by' => 'Modified by',
            );

        ?>

        <?php if($results->have_posts()): global $post; ?>

            <div class="result-row headers">
                <?php foreach($columns as $name => $label): ?>
                    <?php echo sprintf('<div class="result-col %s">%s</div>',$name,$label); ?>
                <?php endforeach; ?>
            </div>

            <?php while($results->have_posts()): $results->the_post(); ?>

                <div class="result-row">


                    <?php foreach($columns as $name => $label): ?>

                        <?php

                            $value = '';

                            switch($name):

                                case 'checkbox':
                                    $value = sprintf('<input type="checkbox" name="bulk_edit_posts[]" value="%d" />', $post->ID);
                                break;

                                case 'type':
                                    $value = $post->post_type;
                                break;

                                case 'title':
                                    $value = sprintf('<a href="%s">%s</a>', get_the_permalink(), $post->post_title);
                                break;

                                case 'author':
                                    $value = get_the_author_link();
                                break;

                                case 'created':
                                    $value = $post->post_date;
                                break;

                                case 'modified':
                                    $value = $post->post_modified;
                                break;

                                case 'modified_by':
                                    $value = get_the_modified_author();
                                break;

                                case 'edit':
                                    $value = sprintf('<a href="%s">edit</a>', get_edit_post_link());
                                break;

                            endswitch;

                        ?>

                        <?php echo sprintf('<div class="result-col %s">%s</div>',$name,$value); ?>

                    <?php endforeach; ?>

                </div><!-- .result -->

            <?php endwhile; ?>
        <?php  endif; ?>

    </div><!-- .results -->

</div><!-- #find-content -->
<script>

    jQuery(function($){

        $(document).ready(function(){

            $('select').select2();

        });

    });

</script>
