function PublicProfileView(config) {
	var global = this,
		viewMember = config.getMember(),
		member = null,
		element = $("#public-profile-view"),
		aliasElement = element.find("h1"),
		friendLink = $(element.find("a.logged-in"));

	function init() {
		$(document).bind("Gawk.Model.Init", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		$(document).bind("Gawk.Member.LoggedIn", onLoggedIn);
		$(document).bind("Gawk.Member.LoggedOut", onLoggedOut);

		$(document).bind("Gawk.UI.AllHide", onHideView);
		$(document).bind("Gawk.UI.PublicProfileShow", onShowView);
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

		$(document).trigger("Gawk.Model.AddFriend", [viewMember.secureId]);
		setFriendLink(true);

	}

	function onUnfriendClick(event) {
		event.preventDefault();

		$(document).trigger("Gawk.Model.RemoveFriend", [viewMember.secureId]);
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