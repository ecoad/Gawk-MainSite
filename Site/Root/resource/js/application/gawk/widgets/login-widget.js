function LoginWidget() {
	var global = this, element = $(".member-navigation"),
		loggedInElement = element.find(".logged-in"),
		loggedOutElement = element.find(".logged-out"),
		loginOverlayForm = $("#login-overlay form"),
		loginOverlayFormSubmitButton = loginOverlayForm.find(".login-button"),
		loginOverlayErrorsElement = loginOverlayForm.find(".login-error"),
		loginOverlayRegisterButton = $("#login-overlay .register-button"),
		registerOverlayForm = $("#register-overlay form"),
		registerOverlaySubmitButton = $("#register-overlay form a.register-button"),
		registerOverlayErrorsElement = registerOverlayForm.find(".register-error"),
		logOutLink = loggedInElement.find("a.logout"),
		logInLink = loggedOutElement.find("a.login"),
		registerLink = $("a.register"),
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
		loginOverlayFormSubmitButton.click(onLoginOverlayFormSubmit);
		loginOverlayRegisterButton.click(onRegisterClick);
		registerOverlayForm.submit(onRegisterOverlayFormSubmit);
		registerOverlaySubmitButton.click(onRegisterOverlayFormSubmit);

		checkForLoginPrompt();
	}

	function checkForLoginPrompt() {
		if (getUrlVars()["Login"] !== undefined) {
			$(document).trigger("GawkUILoginOverlayShow");
		}
	}

	function checkForReturnUrl(forceReload) {
		var getParamReturnUrl = getUrlVars()["ReturnUrl"];
		if (getParamReturnUrl !== undefined) {
			urlAfterLogin = getParamReturnUrl;
		}

		if (urlAfterLogin) {
			if (urlAfterLogin == "/profile") {
				urlAfterLogin = "/u/" + member.alias;
			}
			window.location = urlAfterLogin;
		} else {
			if (forceReload) {
				window.location.reload();
			}
		}
	}

	function getUrlVars() {
		var vars = {}, hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars[hash[0]] = hash[1];
		}
		return vars;
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

		checkForReturnUrl(true);
	}

	function onLoginOverlayInvalidCredentials(event, errors) {
		$(document).unbind("GawkMemberLoginInvalidCredentials", onLoginOverlayInvalidCredentials);

		loginOverlayForm.find("input.textbox").addClass("error");
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

		if (errors[0] == undefined) {
			errors[0] = "Unknown error";
		}
		registerOverlayErrorsElement.html(errors[0]);
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
		$.box.show({content: $("#logging-in-overlay"), allowClose: false});
	}

	function onLoggingOutOverlayShow(event, returnUrl) {
		urlAfterLogout = returnUrl;
		$(document).trigger("GawkUIOverlayShow");
		$.box.show({content: $("#logging-out-overlay"), allowClose: false});
	}

	assignEventListeners();
}