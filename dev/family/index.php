
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

        //array - keys are person IDs, values are an array of referrers
        $raw_persons = array();

        //final master array of graph nodes
        $graph_nodes = array();


        $people = get_posts(array(
            'type' => 'person',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));

        if (!empty($people)) {

            $person_ids = array(); //note who we've already added in a flat array for easier checking

            foreach ($people as $index => $person) {

                //creage a graph node from each person

                $graphnode = new StdClass();

                $graphnode->id = $person->ID;
                $graphnode->name = $person->post_title;

                $graphnode->data = new stdClass();
                $graphnode->data->{'$color'} = '#557EAA';
                $graphnode->data->{'$type'} = 'circle';
                $graphnode->data->{'$dim'} = '10';
                $graphnode->adjacencies = array();

                $parents = get_field('parents', $person->ID);
                $partners = get_field('partner', $person->ID); //singular
                $children = get_field('children', $person->ID);



                //parents
                if(!empty($parents)) {

                    foreach($parents as $parent){

                        if(!is_array($raw_persons[$parent->ID])) { //add the parent node to our $raw_persons
                            $raw_persons[$parent->ID] = array();
                        }

                        $raw_persons[$parent->ID][] = $person->ID;

                        $adjacency = new stdClass();

                        $adjacency->nodeTo = $parent->ID;
                        $adjacency->nodeFrom = $person->ID;

                        $adjacency->data = new stdClass();
                        $adjacency->data->{'$color'} = "#557EAA";

                        $graphnode->adjacencies[] = $adjacency;

                    }

                }//end if parents


                //children
                if($children) {

                    foreach($children as $child){

                        if(!is_array($raw_persons[$child->ID])) { //add this node to our $raw_persons
                            $raw_persons[$child->ID] = array();
                        }
                        $raw_persons[$child->ID][] = $person->ID; //add this person as a referrer

                        $adjacency = new stdClass();

                        $adjacency->nodeTo = $child->ID;
                        $adjacency->nodeFrom = $person->ID;

                        $adjacency->data = new stdClass();
                        $adjacency->data->{'$color'} = "#FFFFFF";

                        $graphnode->adjacencies[] = $adjacency;

                    }  //end foreach

                } //end if children

                //children
                if($partners) {

                    foreach($partners as $partner){

                        if(!is_array($raw_persons[$child->ID])) { //add this node to our $raw_persons
                            $raw_persons[$child->ID] = array();
                        }
                        $raw_persons[$child->ID][] = $person->ID; //add this person as a referrer

                        $adjacency = new stdClass();

                        $adjacency->nodeTo = $child->ID;
                        $adjacency->nodeFrom = $person->ID;

                        $adjacency->data = new stdClass();
                        $adjacency->data->{'$color'} = "#FFFFFF";

                        $graphnode->adjacencies[] = $adjacency;

                    }  //end foreach

                } //end if children

                if($parents || $children || $partners){
                    $graph_nodes[] = $graphnode;
                    $person_ids[] = $person->ID;
                }

            } //end foreach nids


            //final formatting

            foreach($raw_persons as $pid => $referrers) {

                if(!in_array($pid,$person_ids)) { //we don't already have this node

                    $person = get_post($pid);

                    $graphnode = new StdClass();

                    $graphnode->id = $person->ID;
                    $graphnode->name = $person->post_title;

                    $graphnode->data = new stdClass();
                    $graphnode->data->{'$color'} = '#557EAA';
                    $graphnode->data->{'$type'} = 'circle';
                    $graphnode->data->{'$dim'} = '10';
                    $graphnode->adjacencies = array();

                    foreach($referrers as $referrer_id) {

                            $adjacency = new stdClass();

                            $adjacency->nodeTo = $referrer_id;
                            $adjacency->nodeFrom = $person->ID;

                            $adjacency->data = new stdClass();
                            $adjacency->data->{'$color'} = "#FFFFFF";

                            $graphnode->adjacencies[] = $adjacency;

                    }


                    $graph_nodes[] = $graphnode;

                    $person_ids[] = $person->ID;
                }

            }


            echo json_encode($graph_nodes);


        }//end if !empty nodes



    ?>
; //end json

</script>


<!-- Example File -->
<script language="javascript" type="text/javascript" src="family.js"></script>
</head>

<body onload="init();">
<div id="container">


    <div id="infovis"></div>




<div id="inner-details"></div>



<div id="log"></div>


</div>
</body>
</html>
