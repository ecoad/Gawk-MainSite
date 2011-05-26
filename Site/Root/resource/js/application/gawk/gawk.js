function Gawk(configData) {
	var global = this;
	var config = new Config(configData);

	var gawkView, memberWallBookmarkControl, wallSelectView, wallEditView, publicProfileView, profileEditView, loginView,
		loginWidget, navigationWidget, memberControl, memberRecentWallsControl, registerView;

	function init() {
		addEventListeners();

		initModels();
		initControllers();

		$(document).trigger("GawkModelInit");
		showCurrentView();
	}

	function addEventListeners() {
		$(document).bind("GawkUIWelcomeOverlayShow", onWelcomeOverlayShow);
		$(document).bind("GawkUIOverlayShow", onOverlayShow);
		$(".box-close-button").click(onOverlayClose);
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
		} catch (e) { }

		try {
			registerView = new RegisterView();
		} catch (e) { }
	}

	function showCurrentView() {
		$(document).trigger("GawkUIAllHide");
		$(document).trigger("GawkUI" + config.getInitView() + "Show");
	}

	function onLoginShow(event, type) {
		//TODO reimplement
		$(document).trigger("GawkUI" + type + "Request");
	}

	function onWelcomeOverlayShow() {
		$(document).trigger("GawkUIOverlayShow");
		$.box.show({content: $("#welcome-overlay")});
	}
	
	function onOverlayShow() {
		$("object").hide();
	}
	
	function onOverlayClose() {
		$("object").show();
	}

	init();
}