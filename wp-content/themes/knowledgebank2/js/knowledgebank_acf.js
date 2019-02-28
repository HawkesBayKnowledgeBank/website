// function to merge two Javavascipt objects IE compatible, from prototype.js http://prototypejs.org/doc/latest/language/Object/extend/
function extend(destination, source) {
	for (var property in source)
		destination[property] = source[property];
	return destination;
}

// Acf hook -> Hooks -> Filters -> date_picker_args
// see https://www.advancedcustomfields.com/resources/adding-custom-javascript-fields/
acf.add_filter('date_picker_args', function( args, $field ){

	// do something to args

	var custom_args = {
	  yearRange:			"-300:+100", // value to change
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

    // return
    return data;

});
