function LoginView() {
	var global = this;

	var element = $("#login-view");
	var siteLoginView = element.find(".site-login-view");
	var siteRegisterView = element.find(".site-register-view");

	function assignEventListeners() {
		$(document).bind("Gawk.UI.LoginClick", onShowLoginClick);
		$(document).bind("Gawk.UI.RegisterClick", onShowRegisterClick);

		$(document).bind("Gawk.UI.AllHide", onHideView);
		$(document).bind("Gawk.UI.LoginShow", onShowView);

		element.find(".register").click(onRegisterClick);
	}

	function onShowLoginClick() {
		siteLoginView.show();
		siteRegisterView.hide();
	}

	function onShowRegisterClick() {
		siteRegisterView.show();
		siteLoginView.hide();
	}

	function onRegisterClick() {
		$(document).trigger("Gawk.UI.HideAll");
		$(document).trigger("Gawk.UI.LoginShow", ["Register"]);
	}

	function onShowView() {
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	assignEventListeners();
}