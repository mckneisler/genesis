var small = 601;

$(function(){
	$("input").focus(function() {
		var sideNav = $("#sidenav");
		if (sideNav.is(':visible')) {
			sideNav.addClass("w3-hide");
		}
	});

	$(window).scroll(function() {
		fixTopNav();
		fixSideNav();
	});

	$(window).resize(function() {
		fixHeading();
		fixTopNav();
		fixSideNav();
		fixSwipeBar();
	});

	$(window).on({ 'touchmove' : function(){
		fixTopNav();
		fixSideNav();
	} });

	$(window).load(function() {
		fixHeading();
		fixTopNav();
		fixSideNav();
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
	if ($(window).width() < 601) {
		$("#heading_text").height("auto");
	} else {
		$("#heading_text").height($("#heading_image").height());
	}
}

function fixTopNav() {
	var topNav = $('#topnav');
	var topNavSub = $('#topnavsub');
	var headingImage = $("#heading_image");
	var headingText = $("#heading_text");
	var top = $(window).scrollTop();
	var width = $(window).width();
	if (width < small) {
		if (top > headingImage.height() + headingText.height()) {
			topNav.addClass('w3-top');
		} else {
			topNav.removeClass('w3-top');
		}
	} else {
		if (top > headingImage.height()) {
			topNav.addClass('w3-top');
//			topNav.css('top', '0');
//			topNavSub.css('position', 'fixed');
//			topNavSub.css('width', '100%');
			topNavSub.addClass('top');
			topNavSub.css('top', topNav.height() + 'px');
		} else {
			topNav.removeClass('w3-top');
//			topNav.css('top', 'auto');
//			topNavSub.css('position', 'relative');
			topNavSub.removeClass('top');
			topNavSub.css('top', 'auto');
		}
	}
}

function fixSideNav() {
	var sideNav = $("#sidenav");
	if (sideNav.is(':visible')) {
		var topNav = $("#topnav");
		var headingImage = $("#heading_image");
		var headingText = $("#heading_text");
    var width = $(window).width();
    var top = $(window).scrollTop();
		if (width < small) {
			if (top > headingImage.height() + headingText.height()) {
				sideNav.css("top", (topNav.height()) + "px");
			} else {
				sideNav.css("top", (headingImage.height() + headingText.height() + topNav.height() - top) + "px");
			}
		} else {
			sideNav.addClass("w3-hide");
		}
	}
}

function toggleSideNav() {
	$("#sidenav").toggleClass("w3-hide");
	fixSideNav();
}
