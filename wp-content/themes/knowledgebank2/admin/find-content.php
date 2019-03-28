<div id="find-content">
    <h2>Find content</h2>

    <h4>Coming soon...</h4>


    <form id="filters" method="get" action="">
        <input type="hidden" name="page" value="knowledgebank_content_manager" />

        <div class="search-controls">

            <div class="search-control">
                <label>Type</label>
                <select multiple=true name="post_type[]">
                    <?php $allowed = array('audio','still_image','text','video','person'); ?>
                    <?php foreach(get_post_types(['public' => true],'objects') as $content_type): ?>
                        <?php if(!in_array($content_type->name, $allowed)) continue; ?>
                        <?php $selected = !empty($_GET['post_type']) && in_array($content_type->name, $_GET['post_type']) ? 'selected' : ''; ?>
                        <option value="<?php echo $content_type->name; ?>" <?php echo $selected; ?>><?php echo $content_type->labels->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!-- .search-control -->
            <div class="search-control">
                <label>Status</label>
                <select name="post_status">                    
                    <?php foreach(array('any' => 'Any', 'publish' => 'Published', 'draft' => 'Draft', 'pending' => 'Pending') as $status => $label): ?>
                        <?php $selected = !empty($_GET['post_status']) && $_GET['post_status'] == $status ? 'selected' : ''; ?>
                        <option value="<?php echo $status; ?>"><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!-- .search-control -->
            <div class="search-control">

            </div><!-- .search-control -->

        </div><!-- .search-controls -->

        <input type="submit" value="Submit" />

    </form>



</div>
