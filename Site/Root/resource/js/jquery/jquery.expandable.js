/**
 *	Makes Divs expandable when toggle switch is clicked.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Tom Gallacher <tom.gallacher@clock.co.uk>
 * @version 1.0
 */

(function ($) {
	$.fn.expandable = function (options) {
		var defaults = {
				expandableElement : $(this).attr("class"),
				toggleElement : $(this),
				visible : true,
				downArrow: "&#9660;",
				rightArrow: "&#9658;"
			};

		var lastItem = "";

		if (options.accordion) {
			options.visible = false;
		}

		var options = $.extend(defaults, options);

		var global = this,
		toggleIndicators = [];

		return global.each(function () {
			var visible = options.visible;
			var expandableElement = $(this).parent().children(":not(." + options.expandableElement.replace(" ", " .") + ")");
			arrowPosition = (visible == false) ? "arrow-down" : "arrow-right";
			var toggleIndicator = $("<span>").addClass(arrowPosition);
			toggleIndicators.push(toggleIndicator);
			if ($(this).hasClass("visible") && (visible == false)) {
				visible = true;
				if (!$(this).hasClass("hidden")){
					$(this).addClass("visible");
					visible = true;
				}
			}
			if ($(this).hasClass("hidden") && (visible == true)) {
				visible = false;
				if (!$(this).hasClass("visible")) {
						$(this).addClass("hidden");
						visible = false;
				}
			}

			if (!visible) {
				expandableElement.hide();
				onToggle();
			} else {
				onToggle();
			}

			$(this).prepend(toggleIndicator);

			$(this).click(function(event) {
				expandableElement.slideToggle();
				onToggle();
				event.preventDefault();
			});

			function onToggle() {
				if (visible == true) {
					toggleIndicator.html(options.downArrow);
					toggleIndicator.switchClass("arrow-right", "arrow-down");
					visible = false;
				} else if (visible == false){
					toggleIndicator.html(options.rightArrow);
					toggleIndicator.switchClass("arrow-down", "arrow-right");
					visible = true;
				}
			}
			$(this).css('cursor','pointer');
		});
	};
})(jQuery);