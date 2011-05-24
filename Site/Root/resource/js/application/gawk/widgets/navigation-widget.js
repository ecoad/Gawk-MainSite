function NavigationWidget() {
	var global = this;
	var loggedIn = false;

	var element = $("#navigation-widget");
	var newGawkElement = element.find(".new-gawk");
	var newWallElement = element.find(".wall-select");
	var yoursElement = element.find(".yours");
	var viewEventNames = ["GawkUIWallShow", "GawkUIPublicProfileShow", "GawkUIProfileEditShow", "GawkUILoginShow",
		"GawkUIYoursShow", "GawkUIWallEditShow", "GawkUIWallSelectShow"];

	init();

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		$(document).bind("GawkMemberLoggedIn", onLoggedIn);
		$(document).bind("GawkMemberLoggedOut", onLoggedOut);

		newWallElement.click(function(event) {
			if (!loggedIn) {
				$(document).trigger("GawkUILoginOverlayShow", ["/wall"]);
				event.preventDefault();
			}
		});

		yoursElement.click(function(event) {
			if (!loggedIn) {
				$(document).trigger("GawkUILoginOverlayShow", ["/profile"]);
				event.preventDefault();
			}
		});
	}

	function onLoggedIn(event, logInResponse) {
		loggedIn = true;
	}

	function onLoggedOut() {
		loggedIn = false;
	}
}