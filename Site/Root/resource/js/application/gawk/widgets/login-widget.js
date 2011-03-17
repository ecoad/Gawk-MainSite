function LoginWidget() {
	var global = this;

	var element = $("#login-widget");

	var informationElement = element.find(".information");
	var loggedInElement = element.find(".logged-in");
	var loggedOutElement = element.find(".logged-out");

	var siteLoginLink = element.find(".site-login");
	var siteRegisterLink = element.find(".site-register");

	var logOutLink = loggedInElement.find(".logout");

	function assignEventListeners() {
		$(document).bind("Gawk.Member.LoggedIn", onLoggedIn);
		$(document).bind("Gawk.Member.LoggedOut", onLoggedOut);

		siteLoginLink.click(onSiteLoginClick);
		siteRegisterLink.click(onSiteRegisterClick);
		logOutLink.click(onLogOutClick);
	}

	function onSiteLoginClick(event) {
		event.preventDefault;

		$(document).trigger("Gawk.UI.HideAll");
		$(document).trigger("Gawk.UI.LoginShow", ["Login"]);
	}

	function onSiteRegisterClick(event) {
		event.preventDefault;

		$(document).trigger("Gawk.UI.HideAll");
		$(document).trigger("Gawk.UI.LoginShow", ["Register"]);
	}

	function onLogOutClick(event) {
		event.preventDefault;

		$(document).trigger("Gawk.UI.LogoutRequest");
	}

	function onLoggedIn(event, response) {
		showLoggedIn(response);
	}

	function showLoggedIn(response) {

		if (response.success) {
			var profileImage = loggedInElement.find(".profile-image");
			profileImage.attr("src", "https://graph.facebook.com/" + response.member.fbId + "/picture");
			profileImage.show();
		}

		var profileName = loggedInElement.find(".name");
		profileName.html(response.member.name);

		loggedInElement.show();
		loggedOutElement.hide();
		informationElement.hide();
	}

	function onLoggedOut() {
		showLoggedOff();
	}

	function showLoggedOff() {
		loggedOutElement.show();
		loggedInElement.hide();
		informationElement.hide();
	}

	assignEventListeners();
}