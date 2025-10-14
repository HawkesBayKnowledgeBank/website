
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ForceDirected - Force Directed Static Graph</title>

<!-- CSS Files -->
<link type="text/css" href="base.css" rel="stylesheet" />
<link type="text/css" href="ForceDirected.css" rel="stylesheet" />

<!-- JIT Library File -->
<script language="javascript" type="text/javascript" src="jit-yc.js"></script>

<script>


var json =
/*
      {
        "adjacencies": [
            "graphnode1",
            {
              "nodeTo": "graphnode1",
              "nodeFrom": "graphnode0",
              "data": {
                "$color": "#557EAA"
              }
            }
        ],
        "data": {
          "$color": "#557EAA",
          "$type": "circle",
          "$dim": 10
        },
        "id": "graphnode0",
        "name": "graphnode0"
      }, {
        "adjacencies": [],
        "data": {
          "$color": "#557EAA",
          "$type": "circle",
          "$dim": 11
        },
        "id": "graphnode1",
        "name": "graphnode1"
      }, {
        "adjacencies": [
          "graphnode2",
            {
              "nodeTo": "graphnode1",
              "nodeFrom": "graphnode2",
              "data": {
                "$color": "#557EAA"
              }
            }
        ],
        "data": {
          "$color": "#557EAA",
          "$type": "circle",
          "$dim": 11
        },
        "id": "graphnode2",
        "name": "graphnode2"
      }
*/

    <?php

        require_once('../../wp-load.php');

        //we require a person id
        //if(empty($_GET['id'])) die('No id specified');

        global $graph_nodes;
        $graph_nodes = array();


        $pid = !empty($_GET['id']) ? $_GET['id'] : 37606; //JAMES WOODHOUSE BIBBY https://knowledgebank.org.nz/wp-admin/post.php?post=37606&action=edit
        $person = get_post($pid);
        if(empty($person->post_type) || $person->post_type != 'person') die('invalid id');
        kb_get_relatives($pid);



        // $people = get_posts([
        //     'post_type' => 'person',
        //     'posts_per_page' => 100,
        //
        // ]);
        // foreach($people as $person){
        //
        //     kb_get_relatives($person->ID); //populate $graph_nodes
        //
        // }







        $min = 0;
        $max = 0;
        foreach($graph_nodes as $node){
            if($node->data->birthdate > $max) $max = $node->data->birthdate;
            if($min == 0 || $node->data->birthdate < $min) $min =  $node->data->birthdate;
        }

        foreach ($graph_nodes as &$node) {
            $node->data->ypos = ($node->data->birthdate - $min);//calculate a relative value for our oldest (zero) to youngest persons
        }


        echo json_encode(array_values($graph_nodes));


        /**
         * Get a person's relatives, up to a certain depth
         * @param  integer $pid  WordPress post ID for a 'person'
         * @return string JSON array of graph nodes for the plugin
         */
        function kb_get_relatives($pid){

            global $graph_nodes;

            if(empty($graph_nodes[$pid])){
                add_graph_node($pid);
            }

            $relations = array();
            $relations['parents'] = get_field('parents', $pid);
            $relations['partners'] = get_field('partner', $pid);
            $relations['children'] = get_field('children', $pid);
            $relations = array_filter($relations); //remove empty relation types

            if(empty($relations)) return false; //found no relations at all

            foreach($relations as $relative_type => $relatives){ //$relatives is an array, hopefully with an element named 'record' containing a WP_Post object

                //1. Extract the post IDs of related person records
                $relatives = array_map(function($relative){
                    return !empty($relative['record']->ID) ? $relative['record']->ID : false;
                },$relatives);

                //2. Filter out any without record ids
                $relatives = array_filter($relatives, function($p){
                    if(empty($p)) return false;
                    $_birthdate = get_field('birthdate', $p);
                    //birthdates have some odd values brought over from Drupal - might be Y or Y-m or Y-m-d
                    $birthdate_dt = DateTime::createFromFormat('Ymd', (string)$_birthdate);
                    if (!empty($birthdate_dt)) $birthdate = $birthdate_dt->format('Y');
                    if ($birthdate) {
                        return $p;
                    } else {
                        return false;
                    }
                });

                //add relations between $pid and relative id
                if(!empty($relatives)){
                    foreach($relatives as $relative_id){
                        if(empty($graph_nodes[$relative_id])){ //add relative node and relations
                            kb_get_relatives($relative_id);
                        }

                        //add adjacencies

                        //1. add person -> relative adjacency
                        $adjacency = new stdClass();
                        $adjacency->nodeTo = $relative_id;
                        $adjacency->nodeFrom = $pid;
                        $adjacency->data = new stdClass();
                        $colours = array('parents' => '#FF0000','children' => '#00FF00', 'partners' => '#0000FF');
                        $colour = $colours[$relative_type];
                        $adjacency->data->{'$color'} = $colour;

                        $graph_nodes[$pid]->adjacencies[] = $adjacency;

                        //2. add relative -> person adjacency

                        //flip $relative_type for the related party if parents or children
                        if($relative_type == 'parents'){
                            $relative_type = 'children';
                        }
                        elseif($relative_type == 'children'){
                            $relative_type = 'parents';
                        }

                        $adjacency = new stdClass();
                        $adjacency->nodeFrom = $relative_id;
                        $adjacency->nodeTo = $pid;
                        $adjacency->data = new stdClass();
                        $colours = array('parents' => '#FF0000','children' => '#00FF00', 'partners' => '#00FF00');
                        $colour = $colours[$relative_type];
                        $adjacency->data->{'$color'} = $colour;
                        $graph_nodes[$relative_id]->adjacencies[] = $adjacency;

                    }
                }

            }

        }//kb_get_relatives()


        function add_graph_node($pid){
            global $graph_nodes;
            $graphnode = new StdClass();
            $person = get_post($pid);
            if(empty($person)) return false;

            $graphnode->id = $person->ID;
            $graphnode->name = $person->post_title;

            $graphnode->data = new stdClass();
            $graphnode->data->{'$color'} = '#557EAA';
            $graphnode->data->{'$type'} = 'circle';
            $graphnode->data->{'$dim'} = empty($graph_nodes) ? '3' : '3';

            $_birthdate = $person->birthdate;
            //birthdates have some odd values brought over from Drupal - might be Y or Y-m or Y-m-d
            $birthdate_dt = DateTime::createFromFormat('Ymd', $_birthdate);
            if (!empty($birthdate_dt)) $birthdate = $birthdate_dt->format('Y');
            if ($birthdate) {
                $graphnode->data->birthdate = $birthdate;
            }
            else{
                return false;
            }


            $graphnode->adjacencies = array();
            $graph_nodes[$pid] = $graphnode;

        }//add_graph_node()

        //print_r($people); exit;


    ?>
; //end json
/*
    <?php echo $min . ' / ' . $max; ?>
*/
</script>


<!-- Example File -->
<script language="javascript" type="text/javascript" src="family.js?v=<?php echo filemtime('family.js'); ?>"></script>
</head>

<body onload="init();">
<div id="container">


    <div id="infovis"></div>




<div id="inner-details"></div>



<div id="log"></div>


</div>
</body>
</html>
