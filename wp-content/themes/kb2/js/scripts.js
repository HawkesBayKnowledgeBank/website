(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		// DOM ready, take it away
		
		$('#nav-icon1').click(function(){
	        $(this).toggleClass('open');
	        $('.overlay').fadeToggle(250);
	        return false;
    	});

		var  nm = $("#nav-main");
      	var nms = "nav-main-scrolled";
      	var hdr = $('header').height();
      	var nvHght = $('#nav-main').height();
    	$(window).scroll(function() {
	        if( $(this).scrollTop() > (hdr - nvHght)) {
	        nm.addClass(nms);
	        } else {
	        nm.removeClass(nms);
	        }
    	});


	});

    //flexslider
	$(window).load(function() {

			if(typeof flexslider != undefined) {

				if($('#textslider').length) {
				 
					$('#textslider').flexslider({
					    animation: "slide",					    
					    animationLoop: false,
					    slideshow: false,
					    prevText: "",
						nextText: "",					    
						start: function(slider) { // Fires when the slider loads the first slide
					      var slide_count = slider.count - 1;

					      $(slider)
					        .find('img.lazy:eq(0)')
					        .each(function() {
					          var src = $(this).attr('data-src');
					          $(this).attr('src', src).removeAttr('data-src');
					        });
					    },
					    before: function(slider) { // Fires asynchronously with each slider animation
					      var slides     = slider.slides,
					          index      = slider.animatingTo,
					          $slide     = $(slides[index]),
					          $img       = $slide.find('img[data-src]'),
					          current    = index,
					          nxt_slide  = current + 1,
					          prev_slide = current - 1;

					      $slide
					        .parent()
					        .find('img.lazy:eq(' + current + '), img.lazy:eq(' + prev_slide + '), img.lazy:eq(' + nxt_slide + ')')
					        .each(function() {
					          var src = $(this).attr('data-src');
					          $(this).attr('src', src).removeAttr('data-src');
					        });
					    }					    
					});

				}
				else {

					$('.flexslider').flexslider({
					    animation: "slide",
					    prevText: "",
						nextText: "",		    
					});	

				}

			}
			else {
				console.log('no flexslider :(');
			}




  
	});  


	$(document).ready(function(){

		
		//Collections list

		$('.collections-list').find('ul.children').hide().before('<a href="#" class="showchildren">+</a>');
		$('.collections-list').on('click','.showchildren', function(e){
			e.preventDefault();

			var newtext = $(this).text() == '+' ? '-' : '+';
			$(this).text(newtext);			
			$(this).siblings('.children').slideToggle();
		});


		//Quick view links
		$('a.quick_view').click(function(e){

			e.preventDefault();

			$a = $(this);

			var items = [];

			$.get( $a.attr('href'), function(data){

				//console.log(data);

				if( $(data).find('.images').length ) {
					console.log('adding image');
					
					$(data).find('img').each(function(){
						items.push({src: $(this).attr('src'), type : 'image' })
					});
				}

				if( $(data).find('.video').length ) {
					console.log('adding video');
					
					$(data).find('iframe').each(function(){
						items.push({src: $(this).attr('src'), type : 'iframe' })
					});
				}			

				
				if(items.length) {

					$.magnificPopup.open({
					   items:items,
					   gallery: {
					      enabled: true 
					    }
					});

				}

			});

		});		

	});




	
})(jQuery, this);
