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

					$('.slidernav').flexslider({
					    animation: "slide",
					    controlNav: false,
					    animationLoop: false,
					    slideshow: false,
					    itemWidth: 150,
					    itemMargin: 15,
					    prevText: "",
						nextText: "",					    
					    asNavFor: '#textslider',					    
					});

				 
					$('#textslider').flexslider({
					    animation: "slide",
					    controlNav: false,					    
					    animationLoop: false,
					    slideshow: false,
					    prevText: "",
						nextText: "",
						sync: '.slidernav',					    
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
					    	console.log('bang')
					    	

					      var slides     = slider.slides,
					          index      = slider.animatingTo,
					          $slide     = $(slides[index]),
					          $img       = $slide.find('img[data-src]'),
					          current    = index,
					          nxt_slide  = current + 1,
					          prev_slide = current - 1;

							console.log($slide.parent().find('img:eq(' + current + ')'));

					      	$slide
					        .parent()
					        .find('img:eq(' + current + '), img:eq(' + prev_slide + '), img:eq(' + nxt_slide + ')')
					        .each(function() {
					          var src = $(this).attr('data-src');
					          $(this).attr('src', src).removeAttr('data-src');
					        });
					      
					        scrollTranscript(index);				       
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

		//magnific images
		$('.magnific').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			mainClass: 'mfp-img-mobile',
			image: {
				verticalFit: false
			}
			
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
