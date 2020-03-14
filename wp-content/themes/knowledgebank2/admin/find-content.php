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
    .results .result-row .result-col { width:10%;}

    .results .result-row .result-col.title { width:25%;}

    .results .result-row .result-col.created,
    .results .result-row .result-col.author,
    .results .result-row .result-col.modified_by,
    .results .result-row .result-col.modified { width:10%;}

    .results .result-row .result-col.type,
    .results .result-row .result-col.edit { width:5%; }

    .results .result-row .result-col.checkbox { width: 40px;}
    #select2-collections-results .select2-results__option[aria-disabled=true] { display:none; }
    #filters input[type="submit"] { padding:10px; margin:10px 0; }

</style>

<div id="find-content">
    <h2>Find content</h2>

    <form id="filters" method="get" action="">

        <div class="search-controls">

            <div class="search-control">

                <label>Title</label>
                <input name="fc[post_title_like]" value="<?php echo !empty($_GET['fc']['post_title']) ? htmlentities($_GET['fc']['post_title']) : ''; ?>" type="text" />

                <label>Type</label>
                <select multiple=true name="fc[post_type][]">
                    <?php $allowed = array('audio','still_image','text','video','person'); ?>
                    <?php foreach(get_post_types(['public' => true],'objects') as $content_type): ?>
                        <?php if(!in_array($content_type->name, $allowed)) continue; ?>
                        <?php $selected = !empty($_GET['fc']['post_type']) && in_array($content_type->name, $_GET['fc']['post_type']) ? 'selected' : ''; ?>
                        <option value="<?php echo $content_type->name; ?>" <?php echo $selected; ?>><?php echo $content_type->labels->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!-- .search-control -->
            <div class="search-control">
                <label>Status</label>
                <select name="fc[post_status]">
                    <?php foreach(array('any' => 'Any', 'publish' => 'Published', 'draft' => 'Draft', 'pending' => 'Pending') as $status => $label): ?>
                        <?php $selected = !empty($_GET['fc']['post_status']) && $_GET['fc']['post_status'] == $status ? 'selected' : ''; ?>
                        <option value="<?php echo $status; ?>"><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!-- .search-control -->
            <div class="search-control">
                <label>Author</label>
                <select name="fc[author__in][]" multiple="true">
                    <?php $users = get_users(); ?>
                    <?php foreach($users as $user): ?>
                        <?php $selected = !empty($_GET['fc']['author__in']) && in_array($user->ID, $_GET['fc']['author__in']) ? 'selected' : ''; ?>
                        <option value="<?php echo $user->ID; ?>" <?php echo $selected; ?>><?php echo $user->display_name; ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Edited by</label>
                <select name="fc[editor][]" multiple="true">
                    <?php $users = get_users(); ?>
                    <?php foreach($users as $user): ?>
                        <?php $selected = !empty($_GET['fc']['editor']) && in_array($user->ID, $_GET['fc']['editor']) ? 'selected' : ''; ?>
                        <option value="<?php echo $user->ID; ?>" <?php echo $selected; ?>><?php echo $user->display_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!-- .search-control -->

            <div class="search-control">
                <label>Collection(s)</label>
                <select name="fc[collection][]" id="collections" multiple="true">
                    <?php if(!empty($_GET['fc']['collection'])): foreach($_GET['fc']['collection'] as $collection_id): ?>
                        <?php
                            $collection = get_term_by('id',$collection_id,'collections');
                            if(empty($collection)) continue;
                        ?>
                        <option value="<?php echo $collection->term_id; ?>" selected><?php echo $collection->name; ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div><!-- .search-control -->

        </div><!-- .search-controls -->
        <div class="search-control">
            <input type="submit" value="Search" />
        </div><!-- .search-control -->

        <input type="hidden" name="page" value="knowledgebank_content_manager" /><!-- ensure we reload this same page when submitting the form -->
        <input type="hidden" name="kbsearch" value="1" />

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

        $kb_args = array_filter($_GET['fc']);


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


        //editor
        if(!empty($kb_args['editor'])){
            $editor_ids = $kb_args['editor'];
            unset($kb_args['editor']);
            $kb_args['meta_query'][] = array(
                'key' => '_edit_last',
                'value' => $editor_ids,
                'compare' => 'IN'
            );
        }

        if(!empty($kb_args['collection'])){

            $collections = $kb_args['collection'];
            unset($kb_args['collection']);
            $kb_args['tax_query'] = array(
                array(
                    'taxonomy' => 'collections',
                    'field' => 'term_id',
                    'terms' => $collections
                )
            );

        }


        //...

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
                'author' => 'Author',
                'status' => 'Status',
                'collections' => 'Collections',
                'created' => 'Created',
                'modified' => 'Last modified',
                'modified_by' => 'Modified by'
            );

        ?>

        <?php if($results->have_posts()): global $post; ?>

            <div class="result-row headers">
                <?php foreach($columns as $name => $label): ?>
                        <?php
                            $link_args = $_GET;
                            $link_args['fc']['orderby'] = $name;
                            $link_args['fc']['order'] = (!empty($_GET['fc']['order']) && $_GET['fc']['order'] == 'DESC' ? 'ASC' : 'DESC');
                            $link = '/wp-admin/admin.php?' . http_build_query($link_args);
                        ?>
                    <?php echo sprintf('<div class="result-col %s"><a href="%s">%s</a></div>',$name,$link,$label); ?>
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

                                case 'status':
                                    $value = $post->post_status;
                                break;

                                case 'collections':
                                    $collections = wp_get_post_terms( $post->ID, 'collections');
                                    $values = [];
                                    $value = '';
                                    if(!empty($collections)){
                                        foreach($collections as $collection){
                                            $values[] = sprintf('<a href="%s">%s</a>', get_term_link($collection), $collection->name);
                                        }
                                        $value = implode(', ', $values);
                                    }
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


            $('select:not(#collections)').select2();

            $('#collections').select2({
                ajax: {
                    url: '/wp-admin/admin-ajax.php',
                    data: function (params) {
                        var query = {
                            action: 'ucm_get_collections',
                            search: params.term,
                            parents: $('#collections').val()
                        }
                        return query;
                    }
                }
            });
        });

    });

</script>
