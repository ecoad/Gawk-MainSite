function ProfileEditView(config) {
	var global = this,
	loggedInMember = config.getMember(),
	element = $("#profile-edit-view");

	function init() {
		$(document).bind("GawkModel.Init", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		$(document).bind("Gawk.Member.LoggedIn", onLoggedIn);
		$(document).bind("Gawk.Member.LoggedOut", onLoggedOut);

		$(document).bind("GawkUI.AllHide", onHideView);
		$(document).bind("GawkUI.ProfileEditShow", onShowView);
	}

	function showLoggedInControls() {
		element.find(".logged-in").show();
		element.find(".logged-out").hide();
	}

	function showLoggedOutControls() {
		element.find(".logged-out").show();
		element.find(".logged-in").hide();
	}

	function onLoggedIn(event, response) {
		member = response.member;
		showLoggedInControls();
	}

	function onLoggedOut() {
		member = null;
		showLoggedOutControls();
	}

	function onShowView() {
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	init();
}