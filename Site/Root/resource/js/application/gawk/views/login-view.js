function LoginView() {
	var global = this;

	var element = $("#login-view");
//	var siteLoginView = element.find(".site-login-view");
//	var siteRegisterView = element.find(".site-register-view");

	function assignEventListeners() {
		$(document).bind("GawkUILoginClick", onShowLoginClick);
		$(document).bind("GawkUIRegisterClick", onShowRegisterClick);

		$(document).bind("GawkUIAllHide", onHideView);
		$(document).bind("GawkUILoginShow", onShowView);

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
		$(document).trigger("GawkUIHideAll");
		$(document).trigger("GawkUILoginShow", ["Register"]);
	}

	function onShowView() {
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	assignEventListeners();
}