$(function(){
	$(window).scroll(function() {
		fixTopNav();
	});

	$(window).resize(function() {
		fixHeading();
		fixTopNav();
		fixSwipeBar();
	});

	$(window).on({ 'touchmove' : function(){
		fixTopNav();
	} });

	$(window).load(function() {
		fixHeading();
		fixTopNav();
		fixSwipeBar();

		var setFocusId = $("#setFocusId");
		if (setFocusId) {
			$("#" + setFocusId.val()).focus();
		}
	});
});

function fixSwipeBar() {
	$("table").each(function() {
		if ($(this).width() > $(this).parent().width()) {
			$("[id^=" + $(this).attr("id") + "Swipe]").addClass("w3-show");
		} else {
			$("[id^=" + $(this).attr("id") + "Swipe]").removeClass("w3-show");
		}
	})
}

function fixHeading() {
	var headingImage = $("#heading_image");
	var headingText = $("#heading_text");
	if (headingText.offset().top > headingImage.offset().top) {
		$("#heading_text").height("auto");
	} else {
		$("#heading_text").height($("#heading_image").height());
	}
}

function fixTopNav() {
	var topNav = $('#topnav');
	var headingImage = $("#heading_image");
	var headingText = $("#heading_text");
	var top = $(window).scrollTop();
	var width = $(window).width();
	if (headingText.offset().top > headingImage.offset().top) {
		var topOffset = headingImage.height() + headingText.height();
	} else {
		var topOffset = headingImage.height();
	}
	if (top > topOffset) {
		topNav.addClass('navbar-fixed-top');
	} else {
		topNav.removeClass('navbar-fixed-top');
	}
}
