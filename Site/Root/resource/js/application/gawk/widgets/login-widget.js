function LoginWidget() {
	var global = this, element = $(".login-widget"),
		loggedInElement = element.find(".logged-in"),
		loggedOutElement = element.find(".logged-out"),
		loginOverlayForm = $("#login-overlay form"),
		logOutLink = loggedInElement.find(".logout");

	function assignEventListeners() {
		$(document).bind("GawkMemberLoggedIn", onLoggedIn);
		$(document).bind("GawkMemberLoggedOut", onLoggedOut);
		$(document).bind("GawkUILoginOverlayShow", onLoginOverlayShow);
		$(document).bind("GawkUILoggingInOverlayShow", onLoggingInOverlayShow);
		$(document).bind("GawkUILoggingOutOverlayShow", onLoggingOutOverlayShow);

		logOutLink.click(onLogOutClick);
		loginOverlayForm.submit(onLoginOverlayFormSubmit);

		if (window.location.search == "?Login") {
			$(document).trigger("GawkUILoginOverlayShow");
		}
	}

	function onLoginOverlayFormSubmit(event) {
		event.preventDefault();

		$(document).bind("GawkMemberLoginInvalidCredentials", onLoginOverlayInvalidCredentials);

		var emailAddress = loginOverlayForm.find("input[name=EmailAddress]").val(),
			password = loginOverlayForm.find("input[name=Password]").val();

		$(document).trigger("GawkUISiteLoginRequest", [emailAddress, password]);
	}

	function onLoginOverlayInvalidCredentials(event, errors) {
		$(document).unbind("GawkMemberLoginInvalidCredentials", onLoginOverlayInvalidCredentials);

		var loginErrorsElement = loginOverlayForm.find(".login-error"),
			errorsListElement = loginErrorsElement.find(".message").html(errors.InvalidLoginCredentials);

		loginErrorsElement.show();
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
		window.trigger("GawkUIOverlayShow");
		$.box.show({content: $("#login-overlay")});
	};

	function onLoggingInOverlayShow() {
		window.trigger("GawkUIOverlayShow");
		$.box.show({content: $("#logging-in-overlay")});
	}

	function onLoggingOutOverlayShow() {
		window.trigger("GawkUIOverlayShow");
		$.box.show({content: $("#logging-out-overlay")});
	}

	assignEventListeners();
}