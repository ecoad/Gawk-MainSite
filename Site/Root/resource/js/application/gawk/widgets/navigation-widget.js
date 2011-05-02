function NavigationWidget() {
	var global = this;

	var element = $("#navigation-widget");
	var newGawkElement = element.find(".new-gawk");
	var newWallElement = element.find(".wall-select");
	var yoursElement = element.find(".yours");

	init();

	function init() {
		$(document).bind("GawkModel.Init", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		newGawkElement.click(onNewGawkClick);
		newWallElement.click(onWallSelectClick);
		yoursElement.click(onYoursClick);

		$(document).bind("GawkUI.GawkShow", onViewChangeUpdateNavigation);
		$(document).bind("GawkUI.PublicProfileShow", onViewChangeUpdateNavigation);
		$(document).bind("GawkUI.ProfileEditShow", onViewChangeUpdateNavigation);
		$(document).bind("GawkUI.LoginShow", onViewChangeUpdateNavigation);
		$(document).bind("GawkUI.YoursShow", onViewChangeUpdateNavigation);
		$(document).bind("GawkUI.WallEditShow", onViewChangeUpdateNavigation);
	}

	function onNewGawkClick(event) {
		event.preventDefault();
		$(document).trigger("GawkUI.AllHide");
		$(document).trigger("GawkUI.GawkShow");
	}

	function onWallSelectClick(event) {
		event.preventDefault();
		$(document).trigger("GawkUI.AllHide");
		$(document).trigger("GawkUI.WallSelectShow");
	}

	function onYoursClick(event) {
		event.preventDefault();
		$(document).trigger("GawkUI.AllHide");
		$(document).trigger("GawkUI.PublicProfileShow");
	}

	function onViewChangeUpdateNavigation(event) {
		console.debug(event);
	}
}