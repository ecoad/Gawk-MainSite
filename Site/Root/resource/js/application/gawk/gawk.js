function Gawk(configData) {
	var global = this;
	var config = new Config(configData);

	var gawkView, wallSelectView, wallEditView, yoursView, loginView, loginWidget, navigationWidget, memberControl;

	function init() {
		memberControl  = new MemberControl(config);
		wallControl = new WallControl(config, memberControl);

		gawkView = new GawkView(config);
		wallSelectView = new WallSelectView();
		wallEditView = new WallEditView();
		yoursView = new YoursView();
		loginView = new LoginView();

		loginWidget = new LoginWidget();
		navigationWidget = new NavigationWidget();

		$(document).trigger("Gawk.Model.Init");
		showCurrentView();
	}

	function showCurrentView() {
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI." + config.getInitView() + "Show");
	}

	function onLoginShow(event, type) {
		//TODO reimplement
		$(document).trigger("Gawk.UI." + type + "Request");
	}

	init();
}