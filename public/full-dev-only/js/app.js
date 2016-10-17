$(function(){
	var navButton = $('#navButton');
	var topnav = $('#topnav');
	var leftnav = $('#leftnav');
	var rightpnav = $('#rightnav');

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
			$("#" + setFocusId.val()).focus();
		}
	});
});

function showState() {
	var msg = 'Showing stats:\n\n';
	var topnav = $('#leftnav');
	if (topnav.is(':visible')) {
		msg += 'Is visible' + '\n';
	} else {
		msg += 'Is NOT visible' + '\n';
	}
	var activeItem = topnav.find('a.w3-theme-l3');
	msg += 'Active item = ' + activeItem.text().trim() + '\n';

	obj = topnav.data('smartmenus');
	if (obj.isCollapsible()) {
		msg += 'Is collapsible' + '\n';
	} else {
		msg += 'Is NOT collapsible' + '\n';
	}
	alert(msg);
	topnav.smartmenus('itemActivate', activeItem);
	return false;
/*
*/
}

function fixSwipeBar() {
	$("table").each(function() {
		if ($(this).width() > $(this).parent().width()) {
			$("[id^=" + $(this).attr("id") + "Swipe]").addClass("w3-show");
		} else {
			$("[id^=" + $(this).attr("id") + "Swipe]").removeClass("w3-show");
		}
	});
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
	var topNavL2 = $('#topnavL2');
	var topNavL3 = $('#topnavL3');
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
		if (topNavL2.is(':visible')) {
			topNavL2.addClass('top');
			topNavL2.css('top', topNav.height() + 'px');
		}
		if (topNavL3.is(':visible')) {
			topNavL3.addClass('top');
			topNavL3.css('top', (topNav.height() + topNavL2.height()) + 'px');
		}
	} else {
		topNav.removeClass('navbar-fixed-top');
		if (topNavL2.is(':visible')) {
			topNavL2.removeClass('top');
			topNavL2.css('top', 'auto');
		}
		if (topNavL3.is(':visible')) {
			topNavL3.removeClass('top');
			topNavL3.css('top', 'auto');
		}
	}
}

function changeFavorite(object, id, userId, checked) {
	if (checked) {
		$url = "/music/" + object + "/" + id + "/favoritedBy/" + userId;
	} else {
		$url = "/music/" + object + "/" + id + "/unfavoritedBy/" + userId;
	}

	$.ajax({
		type: "GET",
		url: $url,
		success: function(response) {
			$("#return_" + id).html(response);
			$("#return_" + id).removeClass("w3-hide");
		}
	});
}

function refreshWith(name, value) {
	if (name == 'sort') {
		var values = value.split(":");
		$("#refresh input[name=sort]").val(values[0]);
		$("#refresh input[name=order]").val(values[1]);
	} else {
		$("#refresh input[name=" + name + "]").val(value);
	}
	$("#refresh").submit();
}

function search(e, value) {
	if (e.keyCode === 13) {
		refreshWith('search', value);
	}

	return false;
}

function setSelectField(select, field) {
	var value = $(select).find(":selected").text().trim();
	$('#' + field).val(value);
}

function formActionUpdateAndSubmit(select, form_name) {
	var value = $(select).val();
	var form = $(form_name);
	var new_action = form.prop('action').replace('{select_id}', value);
	form.prop('action', new_action);
	select.remove();
	form.submit();
}
