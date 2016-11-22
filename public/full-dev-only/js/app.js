function getInfo() {
	var msg = 'Showing stats:\n\n';

	var win = $(window);
	msg += 'window scrollTop = ' + win.scrollTop() + '\n';
	msg += 'window height = ' + win.height() + '\n';
	msg += '\n';

	var topnav = $('#topnav');
	msg += 'topnav top = ' + topnav.position().top + '\n';
	msg += 'topnav height = ' + topnav.height() + '\n';
	msg += '\n';

	var footer = $('#footer');
	msg += 'footer top = ' + footer.position().top + '\n';
	msg += 'footer height = ' + footer.height() + '\n';
	msg += '\n';

	var selectDiv = $('div.dropdown-menu.open');
	if (selectDiv.length) {
		if (selectDiv.is(':visible')) {
			msg += 'selectDiv is visible\n';
		} else {
			msg += 'selectDiv is NOT visible\n';
		}
		msg += 'selectDiv top = ' + selectDiv.position().top + '\n';
		msg += 'selectDiv height = ' + selectDiv.height() + '\n';
		msg += '\n';
	} else {
		msg += 'selectDiv does not exist\n';
	}
	alert(msg);
	return false;
}

function timeFromSeconds(seconds) {
    var mins,
        secs;

	// does the same job as parseInt truncates the float
	mins = (seconds / 60) | 0;
	secs = (seconds % 60) | 0;
	return mins + ":" + (secs.toString().length > 1 ? secs : '0' + secs);
}

function startTimer(duration, name) {
    var start = Date.now(),
        diff,
		element,
		timer_id;

    function timer() {
        // get the number of seconds that have elapsed since
        // startTimer() was called
        diff = duration - (((Date.now() - start) / 1000) | 0);

        if (diff <= 0) {
			window.location.replace('/logout?timeout=1');
        }

		element = $('#' + name);
		if (element.length && element.is(':visible')) {
			element.html(timeFromSeconds(diff));
		} else {
			clearInterval(timer_id);
			return;
		}
    }

    // we don't want to wait a full second before the timer starts
    timer_id = setInterval(timer, 1000);
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
	var topNav = $('#topnav'),
		topNavL2 = $('#topnavL2'),
		topNavL3 = $('#topnavL3'),
		headingImage = $("#heading_image"),
		headingText = $("#heading_text"),
		top = $(window).scrollTop(),
		topOffset;
	if (headingText.offset().top > headingImage.offset().top) {
		topOffset = headingImage.height() + headingText.height();
	} else {
		topOffset = headingImage.height();
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

$(function() {
	var navButton = $('#navButton'),
		topnav = $('#topnav'),
		leftnav = $('#leftnav'),
		rightpnav = $('#rightnav');

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

	fixHeading();
	fixTopNav();
	fixSwipeBar();

	var setFocusId = $("#set_focus_id");
	if (setFocusId.length) {
		$("#" + setFocusId.val()).focus();
	}
});
