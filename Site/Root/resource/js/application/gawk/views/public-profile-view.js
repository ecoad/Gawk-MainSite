function PublicProfileView(config) {
	var global = this,
		viewMember = config.getMember(),
		member = null,
		element = $("#public-profile-view"),
		aliasElement = element.find("h1"),
		friendLink = $(element.find("a.logged-in"));

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		$(document).bind("GawkMemberLoggedIn", onLoggedIn);
		$(document).bind("GawkMemberLoggedOut", onLoggedOut);

		$(document).bind("GawkUIAllHide", onHideView);
		$(document).bind("GawkUIPublicProfileShow", onShowView);
	}

	function showLoggedInControls() {
		if (member.friends[viewMember.secureId]) {
			setFriendLink(true);
		} else {
			setFriendLink(false);
		}
		element.find(".logged-in").show();
		element.find(".logged-out").hide();
	}

	function showLoggedOutControls() {
		element.find(".logged-out").show();
		element.find(".logged-in").hide();
	}

	function setFriendLink(isFriend) {
		friendLink.unbind("click");
		if (isFriend) {
			friendLink.html("Unfriend");
			friendLink.click(onUnfriendClick);
		} else {
			friendLink.html("Befriend");
			friendLink.click(onBefriendClick);
		}
	}

	function onBefriendClick(event) {
		event.preventDefault();

		$(document).trigger("GawkModelAddFriend", [viewMember.secureId]);
		setFriendLink(true);

	}

	function onUnfriendClick(event) {
		event.preventDefault();

		$(document).trigger("GawkModelRemoveFriend", [viewMember.secureId]);
		setFriendLink(false);
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