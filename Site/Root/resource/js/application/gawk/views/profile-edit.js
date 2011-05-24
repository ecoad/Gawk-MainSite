function ProfileEditView(config) {
	var global = this,
	loggedInMember = config.getMember(),
	element = $("#profile-edit-view");

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		$(document).bind("GawkMemberGotLoggedInMember", onGetLoggedInMember);
		$(document).bind("GawkMemberLoggedOut", onLoggedOut);

		$(document).bind("GawkUIAllHide", onHideView);
		$(document).bind("GawkUIProfileEditShow", onShowView);
	}

	function showLoggedInControls() {
		element.find(".logged-in").show();
		element.find(".logged-out").hide();
	}

	function showLoggedOutControls() {
		element.find(".logged-out").show();
		element.find(".logged-in").hide();
	}

	function onGetLoggedInMember(event, response) {
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