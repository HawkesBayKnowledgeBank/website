/* Author: Mogul
*/
jQuery(document).ready(function($) {

    //scroll to
    // HTML e.g <a href="#footer" data-offset="100">Go to footer</a>
    $('a[href*="#"]:not([href="#"])').click(function() {

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {

            //lets us set the vertical offest in px e.g data-offset="100"
            var attr = $(this).attr('data-offset');
            if( attr == undefined ){ attr = 0; }

            //console.log(attr);

            $('html,body').animate({ scrollTop: target.offset().top-attr }, 600);
            return false;

            }
        }
    });

    $('a[href="#json"]').click(function(){
        $('#json').slideToggle();
    });


    //Content Tabs
    $('ul.tabs li').click(function(){
      var tab_id = $(this).attr('data-tab');

      $('ul.tabs li').removeClass('current');
      $('.tab-content').removeClass('current');

      $(this).addClass('current');
      $("#"+tab_id).addClass('current');
      window.location.hash = tab_id.substring(4);
    })


    // Accordions
    $('#accordion').find('.accordion-head').click(function(){
      if( $(this).hasClass('open') ){
            $(this).removeClass('open');
            $(this).next().slideToggle('fast');
          }
      else{
        $('.accordion-head').removeClass('open');
        $(this).addClass('open');
        $(this).next().slideToggle('fast');
          $('.accordion-body').not($(this).next()).slideUp('fast');
      }
    });

    // Home intro
    $('.intro-slider').slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      arrows: false,
      fade: true,
      cssEase: 'linear',
      autoplay:true,
      autoplaySpeed: 4000,
      asNavFor: '.intro-background-slider',
    });

    $('.intro-background-slider').slick({
      infinite: true,
      arrows: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      fade: true,
      asNavFor: '.intro-slider',
    });

    if($('.sub-collections .tile').length > 10){

        //$('.sub-collections .tile').wrap('<div class="tileslide"></div>');

        $('.sub-collections').slick({
          dots: false,
          mobileFirst:true,
          infinite:false,
          slidesToShow: 1,
          slidesToScroll:1,
          responsive: [
              {
                breakpoint: 600,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll:5,
                }
          }],
        });
        $('.sub-collections').on('afterChange', function(slick, currentSlide){
            console.log(currentSlide);
            $('.slide-count .current-index').text(Math.ceil(currentSlide.currentSlide) + 1);
        });
    }


    var dots = true;
    if($('.media-slider .media-slide').length == 1) dots = false;
    $('.media-slider').slick({
      dots: dots,
      slidesToShow: 1,
      slidesToScroll: 1,
      adaptiveHeight: true,
    });


    $('.media-slider, .book-slider').on('init', function(event, slick, currentSlide){
        maybe_advance_slider_to_search_term();
    });

    //lazy loading - slick's native version doesn't handle adaptiveHeight o.O
    //unlazy the slide after the one we are viewing
    $('.media-slider, .book-slider').on('afterChange', function(event, slick, currentSlide){
        var nextSlide = currentSlide + 1;
        var $next_image = $('[data-slick-index="' + nextSlide + '"] img[data-lazy-src]');
        if($next_image.length){
            $next_image.attr('src', $next_image.attr('data-lazy-src') );
            $next_image.removeAttr('data-lazy-src');
        }
    });
    //if jumping to a lazy slide, unlazy it
    $('.media-slider, .book-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
        var $next_image = $('[data-slick-index="' + nextSlide + '"] img[data-lazy-src]');
        if($next_image.length){
            $next_image.attr('src', $next_image.attr('data-lazy-src') );
            $next_image.removeAttr('data-lazy-src');
        }
    });

    // Open search mobile filters
    $('.searchbar-toggle').click(function() {
      $('.searchbar-options').slideToggle();
      $(this).toggleClass('active');
    });


    $('.searchbar .top i').click(function(){
        console.log('click')
        $('#main-search form').submit();
    });


    //Search all
    $('#search_all').click(function(e){
        if($(this).is(':checked')){
            $('.searchbar input[name="post_type[]"]').not(':checked').click();
        }
        else{
            $('.searchbar input[name="post_type[]"]').prop('checked',false);
        }
    });
    $('.searchbar input[name="post_type[]"]').click(function(){
        if($('.searchbar input[name="post_type[]"]').not(':checked').length){
            $('#search_all').prop('checked',false);
        }
        else{
            $('#search_all').prop('checked',true);
        }

    });

    // tiles - slider
    if (window.matchMedia("(max-width: 600px)").matches) {
      $('.mobile-slide.tiles .grid').slick({
        infinite: false,
        slidesToShow: 1,
        arrows:false,
        variableWidth: true,
        //centerMode: true,
        dots: true,
      });
    }


    // Select2
    $('.select2').select2();
    $('.select2-nosearch').select2({
      minimumResultsForSearch: -1
    });

    // Alphabet control option
    $('.alphabet button').click(function() {
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
    });

    // Text and image - Magnific (for images)
    $('.book-slider').each(function() {
        $(this).magnificPopup({
            delegate: 'a.zoom',
            type: 'image',
            gallery: {
              enabled:true
            }
        });
    });

    // single image - Magnific (for images)
    $('.media-slider:not(.video), .book-slider:not(.video)').each(function() {
        $(this).magnificPopup({
            delegate: 'a.zoom',
            type: 'image',
            gallery: {
              enabled:true
            }
        });
    });


    // Book slider
    $('.book-slider').slick({
      dots: true,

    });

    //Lazy images
    $('.lazy').lazy({
      effect: "fadeIn",
      effectTime: 300,
      threshold: 0
    });



    var googleMaps = 'iframe[src*="google.com"][src*="map"][src*="embed"]';
    $(googleMaps).wrap('<div class="google-map-wrapper disable-pointer-events"></div>').after('<style>.disable-pointer-events iframe{pointer-events:none;}</style>');
    $('.google-map-wrapper').on('mousedown', function(){ $(this).removeClass('disable-pointer-events'); });
    $('.google-map-wrapper').on('mouseleave', function(){ $(this).addClass('disable-pointer-events'); });


    // Touch enabled dropdown nav - doubletaptogo
	/*
		if ($(window).width() >=800 ){
    	$( 'nav li:has(ul)' ).doubleTapToGo();
		}
	*/

    //Youtube iframe in content
	$('iframe[src*="youtube.com"]').each(function() {
		$(this).wrap('<div class="video-wrapper"/>');
	});



    /** SEARCH **/

    //search results - append search term to search result URLs
	if($('body.search-results').length){

		var searchterm = $('input[name="s"]').val();
		if(searchterm != ''){
			$('.search-results h4 a').each(function(){
				var href = $(this).attr('href');
				$(this).attr('href',href + '?searchterm=' + encodeURIComponent(searchterm));
			});
		}

	}

    function getUrlVars(){
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    //highlight search results
    if(getUrlVars()['searchterm']){
        var searchterm = getUrlVars()['searchterm'];
        searchterm = decodeURIComponent(searchterm);
        var searchwords = searchterm.split(" ");
        if(searchwords.length > 1){ //we have multiple words to highlight
            $.each(searchwords, function(index, value){
                $('.layer').highlight(value);
            });

            //show our own little search bar because ctrl+f can't deal with slick slider
            if($('#searchscroller').length){
                $('#searchscroller .total').text(  );
            }
        }
        else{
            $('.layer:not(.intro)').highlight(searchterm);
        }
    }

    //possibly scroll to a search term when gallery is ready
    function maybe_advance_slider_to_search_term(){

        if(getUrlVars()['searchterm']){
            var searchterm = getUrlVars()['searchterm'];
            console.log('searchterm is ' + searchterm)
            $('.slide-wrap').highlight(searchterm);
            var $first_result = $('.slide-wrap:not(.slick-cloned)').find('span.highlight').first();
            if($first_result.length){
                var $result_wrap = $first_result.parents('.slide-wrap').first();
                if($result_wrap.length){
                    var result_index = $result_wrap.attr('data-slick-index');
                    console.log('result index is ' + result_index)
                    $('.slick-dots button').eq(result_index).click();
                    setTimeout(function(){
                        var scrollpos = $first_result.position().top;
                        $('.caption-inner').animate({scrollTop: $('.caption-inner').scrollTop() + scrollpos + 'px'});
                    },1000);

                }
                else{
                    console.log('no hr')
                    console.log($first_result)
                }
            }
            else{
                console.log('no results')
            }
        }
    }

});
