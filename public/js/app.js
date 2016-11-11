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

		var setFocusId = $("#set_focus_id");
		if (setFocusId) {
			$("#" + set_focus_id.val()).focus();
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

function setNotSaved() {
	document.getElementById("chgs_not_saved").value = 1;
	window.onbeforeunload = function() {
		return "Changes have been made and not saved.  Leaving this page will lose these changes.";
	}
}

function overrideNotSaved() {
	window.onbeforeunload = null;
}
