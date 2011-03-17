/**
 * Checkbox for controlling multiple other checkboxes.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Dom Udall <dom.udall@clock.co.uk>
 * @version 1.0
 */
(function($) {
	$.fn.organiser = function(settings) {
		// Default settings
		var config = {
			collapsible: true,
			columnSelector: ".column",
			dragboxSelector: ".dragbox",
			dragboxContent: ".dragbox-content",
			configElement: ".configure",
			headerElement: "h2",
			opacity: 0.4,
			callback: updateWidgetData,
			serviceUrl: ""
		};

		// Variable to stop double requests being made on collapse
		var dragged = false;

		// Merge settings
		if (settings) $.extend(true, config, settings);

		// Initialising interface
		var columns = $(this).find(config.columnSelector);
		var dragboxes = $(this).find(config.dragboxSelector);

		// Sets up the collapsible elements (if enabled)
		function setupcollapsible(element) {
			var headerElement = element.find(config.headerElement);
			element.data("collapsed", element.find(config.dragboxContent).css("display") == "none");

			headerElement.click(function() {
				element.children(config.dragboxContent).toggle();
				if (!dragged) {
					element.data("collapsed", !element.data("collapsed"));
					config.callback();
				}
				dragged = false;
			}).end();
		}

		// Sets up configuration button (currently not implemented)
		function setupConfigButton(element) {
			element.find(config.headerElement).hover(function() {
				element.find(config.configElement).css("visibility", "visible");
			}, function() {
				element.find(config.configElement).css("visibility", "hidden");
			}).find(config.configElement).css("visibility", "hidden");
		}

		// Default AJAX call
		function updateWidgetData() {
			var items = [];

			columns.each(function() {
				var columnId = $(this).attr("id");
				$(config.dragboxSelector, this).each(function(i){
					items.push({
						id: $(this).attr("id"),
						collapsed: $(this).data("collapsed"),
						order : i,
						column: columnId
					});
				});
			});

			var data = {
				Order: $.toJSON(items)
			};

			$.post(config.serviceUrl, data, function(response) {
				console.debug(response);
			});
		}

		// Sets up the dragboxes to allow for collapsable
		function setupDragbox(index, element) {
			if (config.collapsible) {
				setupcollapsible($(element));
			}
			setupConfigButton($(element));
		}

		return this.each(function() {
			dragboxes.each(setupDragbox);

			columns.sortable({
				connectWith: config.columnSelector,
				handle: config.headerElement,
				cursor: "move",
				placeholder: "placeholder",
				forcePlaceholderSize: true,
				opacity: config.opacity,
				start: function(event, ui) {
					dragged = true;
				},
				stop: function(event, ui){
					config.callback();

					//Firefox, Safari/Chrome fire click event after drag is complete, fix for that
					if ($.browser.mozilla || $.browser.safari) {
						$(ui.item).find(config.dragboxContent).toggle();
					}
					//Opera fix
					ui.item.css({
						"top": 0,
						"left": 0
					});
				}
			}).disableSelection();
		});
	};
})(jQuery);