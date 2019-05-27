jQuery(document).ready(function($){
      
    $('.myslide').slick({
    	lazyLoad: 'ondemand',
    	dots: false,
        // infinite: true,
	    speed: 500,
	    slidesToShow: 1,
	    // variableWidth: true,
    	cssEase: 'ease',
    });

});