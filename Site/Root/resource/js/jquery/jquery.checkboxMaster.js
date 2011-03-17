/**
 * Checkbox for controlling multiple other checkboxes.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Dom Udall <dom.udall@clock.co.uk>
 * @version 1.0
 */
(function($) {
	$.fn.checkboxMaster = function(selection) {

		function onChange(event) {
			var checkboxes = selection;

			if (!checkboxes) {
				checkboxes = $(this).parents().filter("form").find("input[type='checkbox']");
			}

			checkboxes.filter("input[type='checkbox']").attr("checked", $(event.target).is(":checked"));
		}

		return this.each(function() {
			$(this).change(onChange);
		});
	};
})(jQuery);