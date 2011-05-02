function NavigationWidget() {
	var global = this;

	var element = $("#navigation-widget");
	var newGawkElement = element.find(".new-gawk");
	var newWallElement = element.find(".wall-select");
	var yoursElement = element.find(".yours");

	init();

	function init() {
		$(document).bind("Gawk.Model.Init", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		newGawkElement.click(onNewGawkClick);
		newWallElement.click(onWallSelectClick);
		yoursElement.click(onYoursClick);
		console.debug("hi");

		$(document).bind("Gawk.UI.GawkShow", onViewChangeUpdateNavigation);
		$(document).bind("Gawk.UI.PublicProfileShow", onViewChangeUpdateNavigation);
		$(document).bind("Gawk.UI.ProfileEditShow", onViewChangeUpdateNavigation);
		$(document).bind("Gawk.UI.LoginShow", onViewChangeUpdateNavigation);
		$(document).bind("Gawk.UI.YoursShow", onViewChangeUpdateNavigation);
		$(document).bind("Gawk.UI.WallEditShow", onViewChangeUpdateNavigation);
	}

	function onNewGawkClick(event) {
		event.preventDefault();
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.GawkShow");
	}

	function onWallSelectClick(event) {
		event.preventDefault();
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.WallSelectShow");
	}

	function onYoursClick(event) {
		event.preventDefault();
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.PublicProfileShow");
	}

	function onViewChangeUpdateNavigation(event) {
		console.debug(event);
	}
}