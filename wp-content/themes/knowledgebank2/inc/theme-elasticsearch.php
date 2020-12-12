
<?php
global $search_index_fields;
$search_index_fields = array(
    'still_image' => array('people','business','location','format_original','author','notes','accession_number'),
    'audio' => array('people','business','transcript','format_original','author','additional','accession_number'),
    'video' => array('people','business','format_original','transcript','author','additional','accession_number'),
    'person' => array('name','known_as','maiden_name','military_identification','birthplace','parents','partner','children','deathplace','biography','accession_number'),
    'text' => array('people','business','location','format_original','author','notes','publisher','transcript','accession_number'),
    'bibliography' => array('author','description','isbn','other_physical_details','publisher','place_of_publication','accession_number'),
);

/* Pre get posts - caution, this hook is used all over the place */
function knowledgebank_pre_get_posts($query){
    if(empty($query) || is_admin()) return $query;

    global $search_index_fields;

    if($query->is_main_query()){
        $filters = knowledgebank_get_filters();
        //search filtering if applicable
        if(!empty($filters['search'])){
            if(is_archive()){ //we do not want post search on template-terms
                //$query->set('search', $filters['search']);
                $query->set('s', $filters['search']);
                $query->set('ep_integrate',true);
                $query->set('search_fields', array(
                        'post_title',
                        'meta' => $search_index_fields
                    )
                );
            }
        }//$filters['search']

        if ($query->is_search) {
            $query->set('ep_integrate',true);
            $query->set('search_fields', array(
                    'post_title',
                    'meta' => $search_index_fields
                )
            );
        }

        //ordering
        if(!empty($filters['order'])){
            $query->set('order', $filters['order']);
        }
        elseif(is_archive() && $query->queried_object_id != 277873){ //not the news page
            $query->set('order', 'ASC');
        }
        if(!empty($filters['orderby'])){
            $query->set('orderby', $filters['orderby']);
        }
        elseif(is_archive() && $query->queried_object_id != 277873){
            $query->set('orderby', 'name');
        }

        if(!empty($filters['number'])){
            $query->set('posts_per_page', $filters['number']);
        }


        if(is_tag()) $query->set('post_type', array('still_image','audio','video','person','text'));

    }
}//knowledgebank_pre_get_posts()
add_filter('pre_get_posts', 'knowledgebank_pre_get_posts');

function knowledgebank_add_custom_field_elasticpress_weighting( $fields, $post_type ) {

    global $search_index_fields;

    if(in_array($post_type,array_keys($search_index_fields))){
        $fields['meta'] = array(
            'label'    => 'Custom Fields',
            'children' => array(),
        );

        global $search_index_fields;

        foreach($search_index_fields[$post_type] as $field){ //
            // Change my_custom_field here to what you need.
            $key = 'meta.' . $field;

            $fields['meta']['children'][ $key ] = array(
                'key'   => $key,
                'label' => ucwords($field),
            );
        }

    }

    return $fields;
}
add_filter('ep_weighting_fields_for_post_type','knowledgebank_add_custom_field_elasticpress_weighting',    10,    2);

//For fancier meta where we need to prepare it, eg names
function knowledgebank_ep_prepare_meta_data($meta,$post){

    global $search_index_fields;

    $search_fields = kb_get_search_fields(true);
    foreach($meta as $key => $value){
        if(!in_array($key, $search_fields)) unset($meta[$key]);
    }

    //$transcript = get_field('transcript', $post->ID);
    //$meta['transcript'] = array($transcript);

    //name fields are repeaters, each row having first, middle, surname and (possibly) a reference field to a person record
    foreach(['people','author','partner','children','parents'] as $name_field){
        $people = get_field($name_field, $post->ID);
        if(!empty($people)){
            //get an array of names - we can easily do this by stripping the reference field on each row and imploding the remaining name fields
            $names = array_map(function($person){
                if(!empty($person['record'])) unset($person['record']);
                return implode(' ',$person);
            },$people);

            if(!empty($names)) $meta[$name_field] = implode(', ',$names); //eg John Smith, Rosie Jones, Derek Green
        }
    }

    // print_r(array_keys($meta));
    // global $wpdb;
    // $wpdb->query('DELETE FROM wp_options WHERE option_name LIKE "%wpcli_sync%"');
    // exit;

    return $meta;
}
add_filter( 'ep_prepare_meta_data', 'knowledgebank_ep_prepare_meta_data',1,2);

function kb_get_search_fields($raw = false){
    global $search_index_fields;
    $all_fields = ['post_title'];

    foreach($search_index_fields as $post_type => $fields){
        foreach($fields as $field){
            $key = "meta.$field.value";
            if(!in_array($key,$all_fields)) $all_fields[] = ($raw ? $field : $key);
        }
    }

    return $all_fields;
}

function knowledgebank_ep_total_field_limit(){
    return 5000; //this is much too high
}
add_filter('ep_total_field_limit','knowledgebank_ep_total_field_limit',10,1);

function knowledgebank_ep_search_fields($search_fields, $args){
    return kb_get_search_fields();
}
add_filter( 'ep_search_fields', 'knowledgebank_ep_search_fields',10,2);


function knowledgebank_ep_indexable_post_types($types){
    global $search_index_fields;
    //return ['audio'];
    return array_keys($search_index_fields);
}
add_filter('ep_indexable_post_types','knowledgebank_ep_indexable_post_types');

function knowledgebank_ep_formatted_args( $formatted_args, $args ) {
    if (
        ! empty( $formatted_args['query']['bool']['should'] ) &&
        is_array( $formatted_args['query']['bool']['should'] )
    ) {
        global $search_index_fields;
        $all_fields = kb_get_search_fields();
         $simple_query = array(
             'simple_query_string' => array(
                 'query' => $formatted_args['query']['bool']['should'][0]['multi_match']['query'],
                 'fields' => $all_fields,
                 'default_operator' => 'AND',
                 'flags' => 'ALL'
             )
         );

         $formatted_args['query']['bool']['should'] = array($simple_query);

    }
    return $formatted_args;
}
add_filter( 'ep_formatted_args', 'knowledgebank_ep_formatted_args', 10, 2 );
?>
