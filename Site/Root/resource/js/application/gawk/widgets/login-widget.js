function LoginWidget() {
	var global = this, element = $(".login-widget"),
		loggedInElement = element.find(".logged-in"),
		loggedOutElement = element.find(".logged-out"),
		loginOverlayForm = $("#login-overlay form"),
		loginOverlayErrorsElement = loginOverlayForm.find(".login-error"),
		loginOverlayErrorsListElement = loginOverlayErrorsElement.find(".message"),
		registerOverlayForm = $("#register-overlay form"),
		registerOverlayErrorsElement = registerOverlayForm.find(".register-error"),
		registerOverlayErrorsListElement = registerOverlayForm.find("ul"),
		logOutLink = loggedInElement.find("a.logout"),
		logInLink = loggedOutElement.find("a.login"),
		registerLink = loggedOutElement.find("a.register"),
		urlAfterLogin, urlAfterLogout;

	function assignEventListeners() {
		$(document).bind("GawkMemberLoggedIn", onLoginSuccess);
		$(document).bind("GawkMemberLoggedOut", onLoggedOut);
		$(document).bind("GawkUILoginOverlayShow", onLoginOverlayShow);
		$(document).bind("GawkUIRegisterOverlayShow", onRegisterOverlayShow);
		$(document).bind("GawkUILoggingInOverlayShow", onLoggingInOverlayShow);
		$(document).bind("GawkUILoggingOutOverlayShow", onLoggingOutOverlayShow);

		logOutLink.click(onLogOutClick);
		logInLink.click(onLoginClick);
		registerLink.click(onRegisterClick);
		loginOverlayForm.submit(onLoginOverlayFormSubmit);
		registerOverlayForm.submit(onRegisterOverlayFormSubmit);

		if (window.location.search == "?Login") {
			$(document).trigger("GawkUILoginOverlayShow");
		}
	}

	function onLoginClick(event) {
		event.preventDefault();
		$(document).trigger("GawkUILoginOverlayShow");
	}

	function onRegisterClick(event) {
		event.preventDefault();
		$(document).trigger("GawkUIRegisterOverlayShow", ["/profile"]);
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
				urlAfterLogin = "/u/" + member.alias;
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

	function onRegisterOverlayFormSubmit(event) {
		event.preventDefault();
		registerOverlayErrorsElement.hide();

		$(document).bind("GawkMemberRegisterInvalidCredentials", onRegisterOverlayInvalidCredentials);

		var emailAddress = registerOverlayForm.find("input[name=EmailAddress]").val(),
		password = registerOverlayForm.find("input[name=Password]").val(),
		confirmPassword = registerOverlayForm.find("input[name=ConfirmPassword]").val(),
		alias = registerOverlayForm.find("input[name=Alias]").val(),
		registerMember = {};

		registerMember.emailAddress = emailAddress;
		registerMember.password = password;
		registerMember.confirmPassword = confirmPassword;
		registerMember.alias = alias;

		$(document).trigger("GawkUISiteRegisterRequest", [registerMember]);
	}

	function onRegisterOverlayInvalidCredentials(event, errors) {
		$(document).unbind("GawkMemberRegisterInvalidCredentials", onRegisterOverlayInvalidCredentials);

		registerOverlayErrorsListElement.html("");
		$(errors).each(function(index, item){
			registerOverlayErrorsListElement.append($("<li />").html(item));
		});
		registerOverlayErrorsElement.show();
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

	function onRegisterOverlayShow(event, returnUrl) {
		urlAfterLogin = returnUrl;
		$(document).trigger("GawkUIOverlayShow");
		$.box.show({content: $("#register-overlay")});
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