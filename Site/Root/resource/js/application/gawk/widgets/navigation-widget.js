function NavigationWidget() {
	var global = this;
	var loggedIn = false;
	var member;

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

		$(viewEventNames).each(function(index, eventName) {
			$(document).bind(eventName, onViewChangeUpdateNavigation);
		});

		newWallElement.click(function(event) {
			if (!loggedIn) {
				$(document).trigger("GawkUILoginOverlayShow");
				event.preventDefault();
			}
		});

		yoursElement.click(function(event) {
			if (!loggedIn) {
				$(document).trigger("GawkUILoginOverlayShow");
				event.preventDefault();
			}
		});
	}

	function onViewChangeUpdateNavigation(event) {
		$(".navigation-item").removeClass("selected");

		switch (event.type) {
			case "GawkUIWallShow":
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

	function onLoggedIn(event, logInResponse) {
		loggedIn = true;
		member = logInResponse.member;

		yoursElement.attr("href", "/u/" + member.alias);
	}

	function onLoggedOut() {
		loggedIn = false;
	}
}