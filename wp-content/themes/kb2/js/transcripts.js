var enablescroll = true;
(function ($, root, undefined) {


	$(document).ready(function(){

		//Text record transcript paging

			
			
			if($('.transcript').length && $('.transcript h3:eq(0)').length && $('#textslider').length){

				console.log('Found ' + $('.transcript').find('hr').length + ' hrs');

				console.log('Transcript height:' +  $('.transcript').height());

				console.log('Found ' + $('#textslider li:not(.cloned)').length + ' pages')

				var enablescroll = true;

				console.log('Setting ' + ( $('#textslider').height() || '700px'))
				$('.transcript').css('max-height', ( $('.flexslider .slides img').first().height() || '700px') ).css('overflow-y','scroll').css('position','relative');


				scrollTranscript();

				//when we have multiple consecutive page breaks (no transcript for a series of pages) hide the second and any subsequent breaks so have just one visible line.
				//eg <hr><hr><hr> becomes <hr><hr class="hidehr"><hr class="hidehr">...

				$('.transcript hr').each(function(index){

					$(this).attr('id','transcript-page-' + index);

					if($(this).next().is('hr')) {
						$(this).next().addClass('hidehr'); //hide the next hr along
					}

				});

				if(!$('#autoscroll').length){
					$('.transcript').after('<div id="autoscroll"><input type="checkbox" value="1" name="autoscroll" checked/><label for="autoscroll">Auto scroll transcript</label></div>');
					$('#autoscroll input').click(function(){
						if($(this).is(':checked') == false){
							$('.transcript').css('max-height','').css('overflow-y','visible');
							enablescroll = false;
						}
						else {
							$('.transcript').css('max-height','700px').css('overflow-y','scroll');
							enablescroll = true;
						}
					});
				}


				

			}
			else {
				console.log('no deal')
			}

	});

	
})(jQuery, this);


function scrollTranscript(index){		

	if(typeof enablescroll == 'undefined' || enablescroll == false || $('.transcript h3:eq(0)').length == 0) {
		console.log('no enablescroll')
		return false;
	}

	if(typeof index == 'undefined') {
		index = 0;
	}

	var scrollpos;

	if(index == 0) {
		scrollpos = $('.transcript h3:eq(0)').position().top;
	}
	else {
		console.log('index is ' + index)
		scrollpos = $('.transcript hr:eq(' + (index - 1) + ')').position().top;
	}

	console.log('scrollpos is ' + scrollpos)

	//$('.transcript').scrollTop($('.transcript').scrollTop() + scrollpos);
	jQuery('.transcript').animate({scrollTop: jQuery('.transcript').scrollTop() + scrollpos + 'px'});
};
