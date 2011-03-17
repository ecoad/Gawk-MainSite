/**
 * Allows text inputs to display a placeholder message until it gets focus, at which point the input
 * is set to empty.
 *
 * This simulated the placeholder attribute in html5.
 * http://dev.w3.org/html5/spec/Overview.html#the-placeholder-attribute
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Paul Serby <paul.serby@clock.co.uk>
 * @version 1.0
 */
(function($) {
	$.fn.textAreaCounter = function(remainingSelector, maxLength) {

		function update(event) {
			if ($(this).val().length >= maxLength) {
				$(this).val($(this).val().substring(0, maxLength));
			}
			remainingSelector.html(maxLength - $(this).val().length);
		}

		return this.each(function() {
			$(this).keyup(update);
		});
	};
})(jQuery);