$(function(){
	var navButton = $('#navButton');
	var topnav = $('#topnav');
	var leftnav = $('#leftnav');
	var rightpnav = $('#rightnav');

/*
	navButton.click(function() {
alert('In navButton click');
		var activeItem = leftnav.find('a.w3-theme-d3');
		if (!activeItem.is(":visible")) {
alert('attempting itemActivate');
			leftnav.smartmenus("itemActivate", activeItem);
alert('attempted itemActivate');
		}
	}).click();


	leftnav.bind('show.smapi', function(e, menu) {
alert('In leftnav show');
		var activeItem = leftnav.find('a.w3-theme-l3');
alert('attempting itemActivate');
		leftnav.smartmenus('itemActivate', activeItem);
alert('attempted itemActivate');
	});

	topnav.bind('activate.smapi', function(e, item) {
		if (!topnav.data('smartmenus').isCollapsible()) {
			return false;
		}
	});

	var navButton = $('#navButton');
	topnav.smartmenus({
		subMenusSubOffsetX: 2,
		subMenusSubOffsetY: -6,
		subIndicators: false,
		collapsibleShowFunction: null,
		collapsibleHideFunction: null,
		rightToLeftSubMenus: topnav.hasClass('navbar-right'),
		bottomToTopSubMenus: topnav.closest('.navbar').hasClass('navbar-fixed-bottom')
	});
 */

/*
	navButton.click(function() {
		var activeItem = topnav.find('a.w3-theme-d3');
		if (activeItem.is(":visible")) {
			topnav.smartmenus("menuHideAll");
		} else {
			topnav.smartmenus("menuHideAll");
			topnav.smartmenus("itemActivate", activeItem);
		}
	}).click();

   $('#navButton').click(function() {
    var $this = $(this),
        $menu = $('#topnav');
    if (!$this.hasClass('collapsed')) {
      if (!$menu.hasClass('collapsed')) {
        $menu.slideUp(250, function() { $(this).addClass('collapsed').css('display', ''); });
      }
      $this.addClass('collapsed');
    } else {
      $menu.slideDown(250, function() { $(this).removeClass('collapsed'); });
      $this.removeClass('collapsed');
    }
    return false;
  }).click();
 */



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

fixHeading();

function changeFavorite(object, id, userId, checked) {
	if (checked) {
		$url = "/music/" + object + "/" + id + "/favoritedBy/" + userId;
	} else {
		$url = "/music/" + object + "/" + id + "/unfavoritedBy/" + userId;
	}

alert($url);
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
	if(e.keyCode === 13){
		refreshWith('search', value);
	}

	return false;
}
