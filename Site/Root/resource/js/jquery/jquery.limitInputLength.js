/**
 * Function to limit input length.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Tom Gallacher <tom.gallacher@clock.co.uk>
 * @version 1.0
 */
(function($) {
	$.fn.limitInputLength = function(options) {
	var errorMessage = $($("<p>")[0]);

		function onKeyUp(event) {
			inputElementContainer = $(this);
			maxLength = options.length;
			inputElement = $(this).parents().filter("form").find("textarea").val();
			var inputAreaLength = inputElement.length - 1;
			if (inputAreaLength >= maxLength) {
				inputElement = inputElement.substring(0, maxLength);
				$(this).prepend(errorMessage);
				inputElementContainer.find("p.input-error").html("You have exceeded the limit of " + maxLength + " characters").show();
			} else {
				inputElementContainer.find("p.input-error").remove();
			}
		}

		return this.each(function() {
			if ($(this).find("input").is(".medium")) {
				errorMessage.addClass("medium");
			} else if ($(this).find("input").is(".wide")) {
				errorMessage.addClass("wide");
			}
			errorMessage.addClass("input-error form-errors");

			//$(this).find("p.input-error").hide();
			$(this).keyup(onKeyUp);
		});
	};
})(jQuery);