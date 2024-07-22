jQuery(function($){

    // function to merge two Javavascipt objects IE compatible, from prototype.js http://prototypejs.org/doc/latest/language/Object/extend/
    function extend(destination, source) {
        for (var property in source)
            destination[property] = source[property];
        return destination;
    }

    if(typeof acf != 'undefined'){
        // Acf hook -> Hooks -> Filters -> date_picker_args
        // see https://www.advancedcustomfields.com/resources/adding-custom-javascript-fields/
        acf.add_filter('date_picker_args', function( args, $field ){

            var custom_args = {
              yearRange:            "-300:+100", // value to change
            };

            args = extend(args, custom_args)

            // return
            return args;

        });

        acf.add_filter('select2_ajax_data', function( data, args, $input, field, instance ){

            if($('.acf-field[data-key="' + data.field_key + '"]').attr('data-name') == 'collections'){
                var field_selector = '[name="acf[' + data.field_key + '][]"]'; //the select field holding the values chosen
                if($(field_selector).val()){
                    var collections = $(field_selector).val();
                    parent_id = collections.pop(); //parent of available options will be set to the last term selected
                }
                else{
                    parent_id = 0; //nothing chosen yet, offer only top-level terms
                }
                data.parent = parent_id;
            }

            if($('.acf-field[data-key="' + data.field_key + '"]').attr('data-name') == 'related_collections'){
                var field_selector = '[name="acf[' + data.field_key + '][]"]'; //the select field holding the values chosen
                if($(field_selector).val()){
                    var parents = $(field_selector).val();
                }
                else{
                    parents = 0; //nothing chosen yet, offer only top-level terms
                }
                data.related_collection_parents = parents;
            }

            // return
            return data;

        });

        window.first_names = [];
        window.middle_names = [];
        window.family_names = [];
        //Autocomplete for family names on people records
        acf.add_action('append', function( $el ){

            if($el.find('[data-name="family_name"]').length){
                autocomplete_first_names();
            }
            if($el.find('[data-name="family_name"]').length){
                autocomplete_middle_names();
            }
            if($el.find('[data-name="family_name"]').length){
                autocomplete_family_names();
            }

        });

        $(document).ready(function(){

            autocomplete_first_names();
            autocomplete_middle_names();
            autocomplete_family_names();


        });

        function autocomplete_first_names(){
            $('.postbox .acf-field[data-name="first_name"] input').each(function(){
                var val = $(this).val();
                if(val != '' && $.inArray(val,window.first_names) == -1){    window.first_names.push(val); }
                $(this).autocomplete({source: window.first_names, minLength: 0});
            });
        }
        function autocomplete_middle_names(){
            $('.postbox .acf-field[data-name="middle_names"] input').each(function(){
                var val = $(this).val();
                if(val != '' && $.inArray(val,window.middle_names) == -1){    window.middle_names.push(val); }
                $(this).autocomplete({source: window.middle_names, minLength: 0});
            });
        }
        function autocomplete_family_names(){
            $('.postbox .acf-field[data-name="family_name"] input').each(function(){
                var val = $(this).val();
                if(val != '' && $.inArray(val,window.family_names) == -1){    window.family_names.push(val); }
                $(this).autocomplete({source: window.family_names, minLength: 0});
            });
        }


        if($('#conversion-status').length){
            
            let current_status = $('#conversion-status').text();
            let $field = $('#conversion-status').parents('.acf-field').first();

            let id = contextData.postId; //contextData.postId is localised in functions.php
            if(current_status.trim() != 'Complete'){

                $('.conversion-status-wrap').addClass('working')
                $field.find('.acf-input').hide();

                let updater = setInterval(function(){
                    $.get('/wp-admin/admin-ajax.php?action=conversion_status&post_id=' + id, function(response){
                        $('#conversion-status').html(response);                    
                        if(String(response).trim() == 'Complete'){ //we finished

                            clearInterval(updater); //stop updating
                            $('.conversion-status-wrap').removeClass('working')
                            $('.conversion-status-wrap .cancel').remove();
                            //ajax replace image html
                            $.get(window.location.href, function(data){
                                let new_field = $($.parseHTML(data)).find('.acf-field[data-name="' + $field.attr('data-name') + '"]');
                                if(new_field){
                                    $field.replaceWith(new_field);
                                }
                            })
                            
                        }
                    });                    
                },5000);
            }
            

        }


        
        $('.acf-field[data-name="images"] > .acf-label').append('<button class="remove">Remove all images</button><button class="cancel" style="display:none;">Cancel</button>')

        $('.acf-field[data-name="images"] .acf-label button.remove').click(function(e){
            e.preventDefault();
            $(this).text('Confirm deletion').addClass('confirm');  
            $(this).siblings('.cancel').show();

            $(this).bind('click',removeImages);

        });
        $('.acf-field[data-name="images"] .acf-label button.cancel').click(function(e){
            e.preventDefault();
            $(this).hide();
            $(this).siblings('.confirm').text('Remove all images').removeClass('confirm').unbind('click',removeImages);              
        });

        function removeImages(){

            $('.acf-field[data-name="images"] .acf-label button.cancel').hide();
            $('.acf-field[data-name="images"] .acf-label button.confirm').text('Remove all images').removeClass('confirm').unbind('click',removeImages);            

            let id = contextData.postId; //contextData.postId is localised in functions.php
            $.get('/wp-admin/admin-ajax.php?action=kb_remove_generated_images&id=' + id);
            $('.acf-field[data-name="images"] .acf-table .acf-row').not('.acf-clone').remove();   
        }
        


    }//if acf is defined
    
});
