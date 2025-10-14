<?php
class KB_Custom_Post_Status {

    public $post_types = array('text', 'still_image', 'video', 'audio', 'person', 'bibliography');

    public function __construct() {
        add_action('init', array($this, 'register_post_status'), 8);
        add_action('admin_print_footer_scripts', array($this, 'append_post_status_list'), 8);
        add_filter('display_post_states', array($this, 'display_status_label'));
    }

    // Registering custom post status
    // Max length of post status is 20 characters
    public function register_post_status() {
        register_post_status('sample', array(
            'label'                     => _x('Sample', 'post'),
            'public'                    => true,
            'exclude_from_search'       => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Sample <span class="count">(%s)</span>', 'Sample <span class="count">(%s)</span>'),
        ));
    }

    // Using jQuery to add it to post status dropdown
    public function append_post_status_list() {
        // Must be a valid WP_Post object
        global $post;
        if (!isset($post)) return;
        if (!($post instanceof WP_Post)) return;
        if (!in_array($post->post_type, $this->post_types)) return;

        $is_selected = $post->post_status == 'sample';

?>
        <script type="text/javascript">
            // Single post edit screen, add dropdowns and text to publihs box:
            jQuery(function() {
                var sample_selected = <?php echo $is_selected ? 1 : 0; ?>;

                var $post_status = jQuery("#post_status");
                var $post_status_display = jQuery("#post-status-display");

                $post_status.append('<option value="sample">Sample</option>');

                if (sample_selected) {
                    $post_status.val('sample');
                    $post_status_display.text('Sample');
                }
            });

            // Post listing screen: Add quick edit functionality:
            jQuery(function() {
                // See: /wp-admin/js/inline-edit-post.js -> Window.inlineEditPost.edit
                var insert_sample_status_to_inline_edit = function(t, post_id, $row) {
                    // t = window.inlineEditPost
                    // post_id = post_id of the post (eg: div#inline_31042 -> 31042)
                    // $row = The original post row <tr> which contains the quick edit button, post title, columns, etc.
                    var $editRow = jQuery('#edit-' + post_id); // The quick edit row that appeared.
                    var $rowData = jQuery('#inline_' + post_id); // A hidden row that contains relevant post data

                    var status = jQuery('._status', $rowData).text(); // Current post status

                    var $status_select = $editRow.find('select[name="_status"]'); // Dropdown to change status

                    // Add sample status to dropdown, if not present
                    if ($status_select.find('option[value="sample"]').length < 1) {
                        $status_select.append('<option value="sample">Sample</option>');
                    }

                    // Select sample from dropdown if that is the current post status
                    if (status === 'sample') $status_select.val('sample');

                    // View information:
                    // console.log( id, $row, $editRow, $rowData, status, $status_select );
                };

                // On click, wait for default functionality, then apply our customizations
                var inline_edit_post_status = function() {

                    console.log('inline_edit_post_status');
                    var t = window.inlineEditPost;
                    var $row = jQuery(this).closest('tr');
                    var id = t.getId(this);

                    // Use next frame if browser supports it, or wait 0.25 seconds
                    if (typeof requestAnimationFrame === 'function') {
                        requestAnimationFrame(function() {
                            return insert_sample_status_to_inline_edit(t, id, $row);
                        });
                    } else {
                        setTimeout(function() {
                            return insert_sample_status_to_inline_edit(t, id, $row);
                        }, 250);
                    }
                };

                // Bind click event before inline-edit-post.js has a chance to bind it
                jQuery('#the-list').on('click', '.editinline', inline_edit_post_status);

            });

            //add to bulk edit form post status

            jQuery(function() {
                var $bulk_edit = jQuery('#bulk-edit');
                var $bulk_edit_status = jQuery('select[name="_status"]', $bulk_edit);

                if ($bulk_edit_status.find('option[value="sample"]').length < 1) {
                    $bulk_edit_status.append('<option value="sample">Sample</option>');
                }
            });
        </script>
<?php
    }

    // Display "— Sample" after post name on the dashobard, like you would see "— Draft" for draft posts.
    // Not shown when viewing only sample posts because that would be redundant.
    function display_status_label($statuses) {
        global $post; // we need it to check current post status

        if (get_query_var('post_status') != 'sample') { // not for pages with all posts of this status
            if ($post->post_status == 'sample') { // если статус поста - Архив
                return array('Sample'); // returning our status label
            }
        }

        return $statuses; // returning the array with default statuses
    }
}
new KB_Custom_Post_Status();
