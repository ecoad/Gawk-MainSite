/**
 * Sorting Order Controller
 *
 * Remember to to include jquery-ui-1.8.2.js otherwise this doesnt work.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Elliot Coad <elliot.coad@clock.co.uk>
 * @version 1.0
 */
(function($) {
	$.fn.sortingOrder = function(serviceUrl) {
		var serviceUrl = serviceUrl;

		return this.each(function() {

			var itemCollection = $(this);

			function init() {
				itemCollection.sortable({ axis : "y", update: onSortUpdate });
			}

			function onSortUpdate() {
				$.post(
					serviceUrl,
					{
						Data: $(itemCollection.sortable("toArray"))
					}
				);
			}

			init();
		});
	};

})(jQuery);


/**
 * Serialized Sorting Order Controller
 *
 * Remember to to include jquery-ui-1.8.2.js otherwise this doesnt work.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Tom Smith <thomas.smith@clock.co.uk>
 * @version 1.0
 */
(function($) {
$.fn.serializedSortingOrder = function(serviceUrl) {
	var serviceUrl = serviceUrl;

	return this.each(function() {

		var itemCollection = $(this);

		function init() {
			itemCollection.sortable({ axis : "y", update: onSortUpdate });
		}

		function onSortUpdate() {

			var separator = (serviceUrl.indexOf("?") == -1) ? "?" : "&";

			$.post(
				serviceUrl + separator + itemCollection.sortable("serialize")
			);
		}

		init();
	});
};

})(jQuery);