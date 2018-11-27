jQuery(function($){

    $(document).ready(function(){

        if($('.layer.controls.terms').length){

            $('form.filters').on('change', 'input, select',function(){
                $('form.filters').submit();
            });

        }//if

    });

});
