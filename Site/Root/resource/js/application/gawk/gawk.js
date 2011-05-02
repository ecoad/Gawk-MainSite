function Gawk(configData) {
	var global = this;
	var config = new Config(configData);

	var gawkView, wallSelectView, wallEditView, publicProfileView, profileEditView, loginView, loginWidget, navigationWidget, memberControl,
		memberRecentWallsControl;

	function init() {
		initModels();
		initControllers();

		$(document).trigger("GawkModel.Init");
		showCurrentView();
	}

	function initModels() {
		memberControl  = new MemberControl(config);
		try {
			memberRecentWallsControl  = new MemberRecentWallsControl(config);
		} catch (e) {}

		try {
			memberFriendControl = new MemberFriendControl(config);
		} catch (e) {}

		try {
			wallControl = new WallControl(config, memberControl);
		} catch (e) {}
	}

	function initControllers() {
		loginWidget = new LoginWidget();
		try {
			navigationWidget = new NavigationWidget();
			console.debug("nav");
		} catch (e) {}

		try {
			gawkView = new GawkView(config);
		} catch (e) {}

		try {
			wallSelectView = new WallSelectView();
		} catch (e) {}

		try {
			wallEditView = new WallEditView();
		} catch (e) {}

		try {
			yoursView = new YoursView();
		} catch (e) {}

		try {
			profileEditView = new ProfileEditView(config);
		} catch (e) {}

		try {
			loginView = new LoginView();
		} catch (e) {}

		try {
			publicProfileView = new PublicProfileView(config);
		} catch (e) {}
	}

	function showCurrentView() {
		$(document).trigger("GawkUI.AllHide");
		$(document).trigger("GawkUI." + config.getInitView() + "Show");
	}

	function onLoginShow(event, type) {
		//TODO reimplement
		$(document).trigger("GawkUI." + type + "Request");
	}

	init();
}