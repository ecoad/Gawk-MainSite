function RegisterView() {
	var global = this;
	var member = {
		alias: "",
		emailAddress: "",
		password: "",
		confirmPassword: ""
	};

	var element = $("#register-view"), registerForm = element.find("form");

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		console.debug(registerForm);
		registerForm.submit(onFormSubmit);
	}

	function onFormSubmit(event) {
		event.preventDefault();

		$(document).bind("GawkMemberRegisterInvalidCredentials", onRegisterInvalidCredentials);

		member.alias = registerForm.find("input[name=Alias]").val();
		member.emailAddress = registerForm.find("input[name=EmailAddress]").val();
		member.password = registerForm.find("input[name=Password]").val();
		member.confirmPassword = registerForm.find("input[name=ConfirmPassword]").val();

		$(document).trigger("GawkUISiteRegisterRequest", [member]);
	}
	/*
	 */

	function onRegisterInvalidCredentials(event, errors) {
		$(document).unbind("GawkMemberRegisterInvalidCredentials", onRegisterInvalidCredentials);

		var registerErrorsElement = registerForm.find(".form-errors"),
		errorsListElement = registerErrorsElement.find("ul");
		errorsListElement.html("");

		for (var errorLabel in errors) {
			errorsListElement.append($("<li/>").html(errors[errorLabel]));
		}
		registerErrorsElement.show();
	}

	init();
}