function NavigationWidget() {
	var global = this;

	var element = $("#navigation-widget");
	var newGawkElement = element.find(".new-gawk");
	var newWallElement = element.find(".wall-select");
	var yoursElement = element.find(".yours");
	var viewEventNames = ["GawkUIGawkShow", "GawkUIPublicProfileShow", "GawkUIProfileEditShow", "GawkUILoginShow",
		"GawkUIYoursShow", "GawkUIWallEditShow", "GawkUIWallSelectShow"];

	init();

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		$(viewEventNames).each(function(index, eventName) {
			$(document).bind(eventName, onViewChangeUpdateNavigation);
		});
	}

	function onViewChangeUpdateNavigation(event) {
		console.debug(event.type);
		$(".navigation-item").removeClass("selected");

		switch (event.type) {
			case "GawkUIGawkShow":
				newGawkElement.addClass("selected");
				break;
			case "GawkUIPublicProfileShow":
			case "GawkUIProfileEditShow":
			case "GawkUILoginShow":
			case "GawkUIYoursShow":
				yoursElement.addClass("selected");
				break;
			case "GawkUIWallEditShow":
			case "GawkUIWallSelectShow":
				newWallElement.addClass("selected");
				break;
		}
	}
}