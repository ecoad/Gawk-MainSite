console.log("inc");
function Gawk(configData) {
	var global = this;
	var config = new Config(configData);

	var gawkView, memberWallBookmarkControl, wallSelectView, wallEditView, publicProfileView, profileEditView, loginView,
		loginWidget, navigationWidget, memberControl, memberRecentWallsControl;

	function init() {
		console.log("gk init");
		initModels();
		initControllers();

		$(document).trigger("GawkModelInit");
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

		try {
			memberWallBookmarkControl = new MemberWallBookmarkControl(config);
		} catch (e) {}
	}

	function initControllers() {
		loginWidget = new LoginWidget();
		try {
			navigationWidget = new NavigationWidget();
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
		$(document).trigger("GawkUIAllHide");
		$(document).trigger("GawkUI" + config.getInitView() + "Show");
	}

	function onLoginShow(event, type) {
		//TODO reimplement
		$(document).trigger("GawkUI" + type + "Request");
	}

	init();
}