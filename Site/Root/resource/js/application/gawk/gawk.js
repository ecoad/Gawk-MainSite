function Gawk(configData) {
	var global = this;
	var config = new Config(configData);

	var gawkView, wallView, yoursView, loginView, loginWidget, navigationWidget, memberControl, views;

	function init() {
		memberControl  = new MemberControl(config);

		gawkView = new GawkView(config);
		wallView = new WallView();
		yoursView = new YoursView();
		loginView = new LoginView();
		views = [gawkView, loginView, yoursView];

		loginWidget = new LoginWidget();
		navigationWidget = new NavigationWidget();

		$(document).trigger("Gawk.Model.Init");
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.NewWallShow");
	}

	function onLoginShow(event, type) {
		//TODO reimplement
		$(document).trigger("Gawk.UI." + type + "Request");
	}

	function switchView(focusView) {
		$(views).each(function (key, view) {
			view.hideView();
		});

		focusView.showView();
	}

	init();
}