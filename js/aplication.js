$(document).ready(function(){
	// Navigation
	$('.section-navigation').on('click', function(e) {
        $(this).toggleClass("active");
        $(this).parents('.moon').toggleClass("collapsed");
        $('.menu').toggle(300,"swing");
        
		$('body').removeClass('collapsed');
        e.preventDefault();
    });

	var menuNav = $('.navigation').find('.section-navigation');
    var menuSectionContainer = $(menuNav.attr('data-target')).find('a').click(function(e) {
        if (menuNav.is(':visible'))
        {
            menuNav.trigger('click'); 
        }
    });	

	$('.navigation li a').click(function(e) {
		var targetHref = $(this).attr('href');

		$('html, body').animate({
			scrollTop: $(targetHref).offset().top
		}, 1000);

		e.preventDefault();
	});
	
	//Navi active
	var article = $('article')
	  , nav = $('nav')
	  , nav_height = nav.outerHeight();

	$(window).on('scroll', function () {
	  var cur_pos = $(this).scrollTop();
	 
	  article.each(function() {
		var top = $(this).offset().top - nav_height,
			bottom = top + $(this).outerHeight();

		if (cur_pos >= top && cur_pos <= bottom) {
			
			nav.find('a').removeClass('active');
			article.removeClass('active');
		  
			 if(cur_pos + screen.height > $('body').height()) {
				$('#moon-calendar').addClass('active');
				nav.find('a[href="#moon-calendar"]').addClass('active');
			} else {
				$(this).addClass('active');
				nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active');
			}
		  
		}
	  });
	});
});	

$(document).ready(function(){
	$("body").css("display", "none");
	$("body").fadeIn(400); 
	
	//Start animation whit scroll
	wow = new WOW(
		{
			boxClass:     'wow',
			animateClass: 'animated',
			offset:       0,
			mobile:       true,
			live:         true
		}
	)
	wow.init();

	// sticky header
	// var windowWidth=window.innerWidth; 
	// if (320 <= window.innerWidth) {
	// 	$("head").append('<script type="text/javascript" src="js/stickyhead.js"></script>,');
	// }
	
	$("#img-gallery").justifiedGallery({
		lastRow : 'left',
		rowHeight: 130,
		captions: true,
        margins: 5, 
        rel: 'gallery'
    }).on('jg.complete', function () {
        $('.jg-entry').swipebox();
    });	
});

