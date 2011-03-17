/**
 * Checkbox for controlling multiple other checkboxes.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Dom Udall <dom.udall@clock.co.uk>
 * @version 1.0
 */
(function($) {
	$.fn.resetTabIndex = function(options) {

		var tabIndex = 0;
		tagFormElement = $(this);

		return this.each(function() {
			var tabInputs = tagFormElement.find("input,select,textarea,button");

			initalise();

			function initalise() {
				$.each(tabInputs, resetTabIndex);
			}

			function resetTabIndex(index, input) {
				if (this.type != "hidden") {
					input = $($(input)[0]);
					input.attr("tabindex", ++index);
					tabIndex++;
				}
			}
		});
	};
})(jQuery);