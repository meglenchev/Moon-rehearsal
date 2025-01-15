$(document).ready(function() {
  var wrap = $(".moon");

  $(window).on("scroll", function(e) {

	if ($(this).scrollTop() > 40) {
	  wrap.addClass("fix-header");
	} else {
	  wrap.removeClass("fix-header");
	}

  });
});
