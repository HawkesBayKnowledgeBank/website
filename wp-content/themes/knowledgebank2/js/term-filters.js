jQuery(function($){

    $(document).ready(function(){

        if($('.layer.controls.terms').length){

            $('form.filters').on('change', 'select',function(){
                $('form.filters').submit();
            });

        }//if

    });

});
