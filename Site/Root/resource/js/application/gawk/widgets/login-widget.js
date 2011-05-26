function LoginWidget() {
	var global = this, element = $(".login-widget"),
		loggedInElement = element.find(".logged-in"),
		loggedOutElement = element.find(".logged-out"),
		loginOverlayForm = $("#login-overlay form"),
		loginOverlayErrorsElement = loginOverlayForm.find(".login-error"),
		loginOverlayErrorsListElement = loginOverlayErrorsElement.find(".message"),
		logOutLink = loggedInElement.find(".logout"),
		urlAfterLogin, urlAfterLogout;

	function assignEventListeners() {
		$(document).bind("GawkMemberLoggedIn", onLoginSuccess);
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
		loginOverlayErrorsElement.hide();

		$(document).bind("GawkMemberLoginInvalidCredentials", onLoginOverlayInvalidCredentials);

		var emailAddress = loginOverlayForm.find("input[name=EmailAddress]").val(),
			password = loginOverlayForm.find("input[name=Password]").val();

		$(document).trigger("GawkUISiteLoginRequest", [emailAddress, password]);
	}
	
	function onLoginSuccess(event, member) {
		$(document).trigger("GawkUILoggingInOverlayShow");
		
		if (urlAfterLogin) {
			if (urlAfterLogin == "/profile") {
				urlAfterLogin = "/u/" + member.alias
			}
			window.location = urlAfterLogin;
		} else {
			window.location.reload();
		}
	}

	function onLoginOverlayInvalidCredentials(event, errors) {
		$(document).unbind("GawkMemberLoginInvalidCredentials", onLoginOverlayInvalidCredentials);

		loginOverlayErrorsListElement.html(errors.InvalidLoginCredentials);
		loginOverlayErrorsElement.show();
	}
	

	function onLoggedOut() {
		if (urlAfterLogout) {
			window.location = urlAfterLogout;
		} else {
			window.location.reload();
		}
	}

	function onLogOutClick(event) {
		event.preventDefault;
		$(document).trigger("GawkUILoggingOutOverlayShow");
		$(document).trigger("GawkUILogoutRequest");
	}

	function onLoginOverlayShow(event, returnUrl) {
		urlAfterLogin = returnUrl;
		$(document).trigger("GawkUIOverlayShow");
		$.box.show({content: $("#login-overlay")});
	};

	function onLoggingInOverlayShow() {
		$(document).trigger("GawkUIOverlayShow");
		$.box.show({content: $("#logging-in-overlay")});
	}

	function onLoggingOutOverlayShow(event, returnUrl) {
		urlAfterLogout = returnUrl; 
		$(document).trigger("GawkUIOverlayShow");
		$.box.show({content: $("#logging-out-overlay")});
	}

	assignEventListeners();
}