jQuery(document).ready(function($) {

    if(typeof knowledgebank_collections != 'undefined' && $('#wpadminbar a[href^="https://knowledgebank.org.nz/wp-admin/post-new.php?post_type="]').length){

        $('#wpadminbar a[href^="https://knowledgebank.org.nz/wp-admin/post-new.php?post_type="]').each(function(){
            var href = $(this).attr('href') + '&' + knowledgebank_collections;
            $(this).attr('href',href);
        });

    }

});
