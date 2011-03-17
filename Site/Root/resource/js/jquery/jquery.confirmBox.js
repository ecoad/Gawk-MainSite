/**
 * Confirm box for asking the user for confirmation before submitting an input button click.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Dom Udall <dom.udall@clock.co.uk>, Tom Gallacher <tom.gallacher@clock.co.uk>
 * @version 1.0
 */
(function($) {
	$.fn.confirmBox = function(message) {

		function onClick() {
			var answer = confirm(message);

			if (answer) {
				document.form.submit();
			}

			return false;
		}

		return this.each(function() {
			$(this).click(onClick);
		});
	};
})(jQuery);