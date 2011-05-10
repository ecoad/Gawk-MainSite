function LoginWidget() {
	var global = this;

	var element = $(".login-widget");

	var loggedInElement = element.find(".logged-in");

	var loggedOutElement = element.find(".logged-out");

//	var siteLoginLink = element.find(".site-login");
//	var siteRegisterLink = element.find(".site-register");

	var logOutLink = loggedInElement.find(".logout");

	function assignEventListeners() {
		$(document).bind("GawkMemberLoggedIn", onLoggedIn);
		$(document).bind("GawkMemberLoggedOut", onLoggedOut);
		$(document).bind("GawkUILoginOverlayShow", onLoginOverlayShow);
		$(document).bind("GawkUILoggingInOverlayShow", onLoggingInOverlayShow);
		$(document).bind("GawkUILoggingOutOverlayShow", onLoggingOutOverlayShow);
		$(document).bind("GawkUILoggingOutOverlayShow", onLoggingOutOverlayShow);

//		siteLoginLink.click(onSiteLoginClick);
//		siteRegisterLink.click(onSiteRegisterClick);
		logOutLink.click(onLogOutClick);

		if (window.location.search == "?Login") {
			$(document).trigger("GawkUILoginOverlayShow");
		}
	}

	/*
	function onSiteLoginClick(event) {
		event.preventDefault;

		$(document).trigger("GawkUIHideAll");
		$(document).trigger("GawkUILoginShow", ["Login"]);
	}

	function onSiteRegisterClick(event) {
		event.preventDefault;

		$(document).trigger("GawkUIHideAll");
		$(document).trigger("GawkUILoginShow", ["Register"]);
	}
	*/

	function onLogOutClick(event) {
		event.preventDefault;
		$(document).trigger("GawkUILoggingOutOverlayShow");
		$(document).trigger("GawkUILogoutRequest");
	}

	function onLoggedIn(event, response) {
		showLoggedIn(response);
	}

	function showLoggedIn(response) {
		if (response.success) {
			var profileName = loggedInElement.find(".name");
			profileName.html(response.member.firstName);
			profileName.attr("href", "/u/" + response.member.alias);

			loggedInElement.show();
			loggedOutElement.hide();
		}

	}

	function onLoggedOut() {
		showLoggedOff();
	}

	function showLoggedOff() {
		loggedOutElement.show();
		loggedInElement.hide();
	}

	function onLoginOverlayShow() {
		$.box.show({content: $("#login-overlay")});
	};

	function onLoggingInOverlayShow() {
		$.box.show({content: $("#logging-in-overlay")});
	}

	function onLoggingOutOverlayShow() {
		$.box.show({content: $("#logging-out-overlay")});
	}

	assignEventListeners();
}