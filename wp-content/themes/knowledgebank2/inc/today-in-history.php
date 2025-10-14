<div class="today-in-history">
    <?php



    //Gather some information about today in history. 
    //Our dates are all over the place so this isn't as easy as it could be.

    //date fields

    //birthdate
    //deathdate
    //marriage_%_marriage_date

    //TEXT
    //yearpublished




    global $wpdb;

    date_default_timezone_set('Pacific/Auckland');
    $today = date('md');
    if (!empty($_GET['md'])) {
        $today = $_GET['md'];
    }


    //$sql = "SELECT * FROM wp_postmeta WHERE meta_key = 'yearpublished' LIMIT 100";

    //people
    $sql = "SELECT * FROM wp_postmeta WHERE meta_key IN ('birthdate', 'deathdate', 'marriage_0_marriage_date', 'marriage_1_marriage_date', 'marriage_2_marriage_date', 'marriage_3_marriage_date' ) AND (meta_value LIKE '%$today')";
    $results = $wpdb->get_results($sql);

    $done = [];

    if (!empty($results)) {

        $births = array();
        $deaths = array();
        $marriages = array();

        foreach ($results as $result) {

            $post_type = get_post_type($result->post_id);
            if ($post_type != 'person') {
                continue;
            }

            if ($result->meta_key == 'birthdate') {
                $births[] = $result;
            } elseif ($result->meta_key == 'deathdate') {
                $deaths[] = $result;
            } else {
                $marriages[] = $result;
            }
        }

        if (!empty($births)) {
            echo '<div class="section-wrap">';
            echo '<h4>Births</h4>';
            echo '<table>';
            echo '<tr>
        <th>Name</th>
        <th>Born</th>
    </tr>';
            foreach ($births as $birth) {
                if (in_array($birth->post_id, $done)) {
                    continue;
                }
                $done[] = $birth->post_id;
                $person = get_post($birth->post_id);
                $date = DateTime::createFromFormat('Ymd', $birth->meta_value);

                echo '<tr>';

                echo sprintf('<td><a href="%s">%s</a></td>', get_permalink($birth->post_id), $person->post_title);
                echo '<td>' . $date->format('d F Y') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        }

        if (!empty($deaths)) {
            echo '<div class="section-wrap">';
            echo '<h4>Deaths</h4>';
            echo '<table>';
            echo '<tr>
        <th>Name</th>
        <th>Died</th>
    </tr>';
            foreach ($deaths as $death) {
                if (in_array($death->post_id, $done)) {
                    continue;
                }
                $done[] = $death->post_id;
                $person = get_post($death->post_id);
                $date = DateTime::createFromFormat('Ymd', $death->meta_value);

                echo '<tr>';

                echo sprintf('<td><a href="%s">%s</a></td>', get_permalink($death->post_id), $person->post_title);
                echo '<td>' . $date->format('d F Y') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        }

        if (!empty($marriages)) {
            echo '<div class="section-wrap">';
            echo '<h4>Marriages</h4>';
            echo '<table>';
            echo '<tr>
        <th>Name</th>
        <th>Married</th>
    </tr>';
            foreach ($marriages as $marriage) {
                if (in_array($marriage->post_id, $done)) {
                    continue;
                }
                $done[] = $marriage->post_id;
                $person = get_post($marriage->post_id);
                $date = DateTime::createFromFormat('Ymd', $marriage->meta_value);

                echo '<tr>';

                echo sprintf('<td><a href="%s">%s</a></td>', get_permalink($marriage->post_id), $person->post_title);
                echo '<td>' . $date->format('d F Y') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        }
    }


    //Text and still images
    $today_dm = date('d F');
    if (!empty($_GET['md'])) {
        $dt = DateTime::createFromFormat('md', $_GET['md']);
        $today_dm = $dt->format('d F');
    }

    $sql = "SELECT * FROM wp_postmeta WHERE meta_key = 'yearpublished' AND meta_value LIKE '$today_dm%'";

    $results = $wpdb->get_results($sql);

    if (!empty($results)) {

        $post_type_labels = [];

        echo '<div class="section-wrap">';
        echo '<h4>Published material</h4>';
        echo '<table>';
        echo '<tr>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
    </tr>';
        foreach ($results as $result) {

            $type = get_post_type($result->post_id);
            if ($type != 'still_image' && $type != 'text') {
                continue;
            }

            $post = get_post($result->post_id);

            if (empty($post_type_labels[$post->post_type])) {
                $post_type_obj = get_post_type_object($post->post_type);
                $post_type_labels[$post->post_type] = $post_type_obj->labels->singular_name;
            }

            echo '<tr>';
            echo sprintf('<td><a href="%s">%s</a></td>', get_permalink($result->post_id), $post->post_title);
            echo '<td>' . $post_type_labels[$post->post_type] . '</td>';
            echo '<td>' . $result->meta_value . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
    }



    ?>
</div>