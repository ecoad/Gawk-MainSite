function LoginView() {
	var global = this;

	var element = $("#login-view");
	var siteLoginView = element.find(".site-login-view");
	var siteRegisterView = element.find(".site-register-view");

	function assignEventListeners() {
		$(document).bind("GawkUI.LoginClick", onShowLoginClick);
		$(document).bind("GawkUI.RegisterClick", onShowRegisterClick);

		$(document).bind("GawkUI.AllHide", onHideView);
		$(document).bind("GawkUI.LoginShow", onShowView);

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
		$(document).trigger("GawkUI.HideAll");
		$(document).trigger("GawkUI.LoginShow", ["Register"]);
	}

	function onShowView() {
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	assignEventListeners();
}