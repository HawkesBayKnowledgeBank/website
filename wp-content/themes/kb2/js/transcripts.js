(function ($, root, undefined) {


	$(document).ready(function(){

		//Text record transcript paging

			
			
			if($('.field--name-field-transcript').length && $('.gallery-thumbs').length){

				console.log('Found ' + $('.field--name-field-transcript').find('hr').length + ' hrs');

				console.log('Transcript height:' +  $('.field--name-field-transcript').height());

				console.log('Found ' + $('.gallery-thumbs li:not(.cloned)').length + ' pages')

				var enablescroll = true;


				$('.field--name-field-transcript').css('max-height',$('.flexslider').height()).css('overflow-y','scroll').css('position','relative');

				$('.gallery-thumbs li:not(.cloned)').click(function(){		

					if(enablescroll == false) {
						return false;
					}

					var index = $(this).index('.gallery-thumbs li:not(.cloned)'); //index of this slide

					var scrollpos;

					if(index == 0) {
						scrollpos = 0;
					}
					else {
						scrollpos = $('.field--name-field-transcript hr:eq(' + (index - 1) + ')').position().top;
					}

					//$('.field--name-field-transcript').scrollTop($('.field--name-field-transcript').scrollTop() + scrollpos);
					$('.field--name-field-transcript').animate({scrollTop: $('.field--name-field-transcript').scrollTop() + scrollpos + 'px'});
				});

				//when we have multiple consecutive page breaks (no transcript for a series of pages) hide the second and any subsequent breaks so have just one visible line.
				//eg <hr><hr><hr> becomes <hr><hr class="hidehr"><hr class="hidehr">...

				$('.field--name-field-transcript hr').each(function(index){

					$(this).attr('id','transcript-page-' + index);

					if($(this).next().is('hr')) {
						$(this).next().addClass('hidehr'); //hide the next hr along
					}

				});

				if(!$('#autoscroll').length){
					$('.field--name-field-transcript').after('<div id="autoscroll"><input type="checkbox" value="1" name="autoscroll" checked/><label for="autoscroll">Auto scroll transcript</label></div>');
					$('#autoscroll input').click(function(){
						if($(this).is(':checked') == false){
							$('.field--name-field-transcript').css('max-height','').css('overflow-y','');
							enablescroll = false;
						}
						else {
							$('.field--name-field-transcript').css('max-height','600px').css('overflow-y','scroll');
							enablescroll = true;
						}
					});
				}


				

			}

	});

	
})(jQuery, this);
