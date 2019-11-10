jQuery(document).ready(function($) {

    //If you are viewing a collection (taxonomy term) and click the 'new post' button in the wp admin bar...
    //...pre-populate the collection on the new post with the one you were viewing. QoL request.

    if(typeof knowledgebank_collections != 'undefined' && $('#wpadminbar a[href^="https://knowledgebank.org.nz/wp-admin/post-new.php?post_type="]').length){

        $('#wpadminbar a[href^="https://knowledgebank.org.nz/wp-admin/post-new.php?post_type="]').each(function(){
            var href = $(this).attr('href') + '&' + knowledgebank_collections;
            $(this).attr('href',href);
        });

    }

});
