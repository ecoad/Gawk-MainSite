/**
 * Script for converting all on page anchor links to a scrolling javascript behavior
 *
 * @author Cedric Dugas http://www.position-absolute.com
 * @author Luke Wilde <luke.wilde@clock.co.uk>
 */
jQuery.fn.scrollTo = function(settings) {

	settings = jQuery.extend({
		speed : 500,
		beforeAction: "none"
	}, settings);

	function initAnchorScroll(element) {
		element.click(function(event) {

			event.preventDefault();

			if (typeof settings.beforeAction == "function") {
				settings.beforeAction(event);
			}

			// take target from anchor's href
			var fullTargetUrl = $(this).attr("href");
			var target = fullTargetUrl.split("#")[1];

			var destination = $("#" + target).offset().top;

			$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination }, settings.speed, null, function() {
				window.location.hash = target;
			});

			return false;
		})
	}

	return this.each(function() {
		return $(this).find("a[href*=#]").each(function() {
			initAnchorScroll($(this));
		});
	})
}