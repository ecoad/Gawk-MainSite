function PublicProfileView(config) {
	var global = this,
		profileMember = config.getProfileMember(),
		member = null,
		element = $("#public-profile-view"),
		aliasElement = element.find("h1"),
		friendLink = $(element.find("a.friend-control"));

	console.debug(profileMember);

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
		showProfileGawkAndRecentGawks();
	}

	function assignEventListeners() {
		$(document).bind("GawkMemberGotLoggedInMember", onGetLoggedInMember);

		$(document).bind("GawkUIAllHide", onHideView);
		$(document).bind("GawkUIPublicProfileShow", onShowView);

		friendLink.bind("click", function () {
			$(document).trigger("GawkUILoginOverlayShow");
		});
	}

	function showProfileGawkAndRecentGawks() {
		var params = {};
		params.allowscriptaccess = "always";
		params.wmode = "transparent";

		gawkFlashVars = {
			apiLocation: config.getApiLocation(),
			wallId: "profile-recent",
			profileSecureId: profileMember.secureId
		};

		swfobject.embedSWF("/resource/flash/GawkProfileRecentFlash.swf?v=@VERSION-NUMBER@", "recent-swf-container",
			"1050", "131", "9.0.0", false, gawkFlashVars, params, {id: "recent-swf"});

		gawkFlashVars = {
			apiLocation: config.getApiLocation(),
			wallId: "profile-gawk",
			profileSecureId: profileMember.secureId
		};

		swfobject.embedSWF("/resource/flash/GawkProfileGawkFlash.swf?v=@VERSION-NUMBER@", "profile-swf-container",
				"175", "131", "9.0.0", false, gawkFlashVars, params, {id: "profile-swf"});
	}

	function allowLoggedInControls() {
		if (member.friends[profileMember.secureId]) {
			setFriendLink(true);
		} else {
			setFriendLink(false);
		}
		element.find(".logged-in").show();
		element.find(".logged-out").hide();
	}

	function disallowLoggedOutControls() {
		element.find(".logged-out").show();
		element.find(".logged-in").hide();
	}

	function setFriendLink(isFriend) {
		friendLink.unbind("click");
		if (isFriend) {
			friendLink.removeClass("add-friend");
			friendLink.addClass("remove-friend");
			friendLink.html("Unfriend");
			friendLink.click(onUnfriendClick);
		} else {
			friendLink.addClass("add-friend");
			friendLink.removeClass("remove-friend");
			friendLink.html("Befriend");
			friendLink.click(onBefriendClick);
		}
		friendLink.show();
	}

	function onBefriendClick(event) {
		event.preventDefault();

		$(document).trigger("GawkModelAddFriend", [profileMember.secureId]);
		setFriendLink(true);

	}

	function onUnfriendClick(event) {
		event.preventDefault();

		$(document).trigger("GawkModelRemoveFriend", [profileMember.secureId]);
		setFriendLink(false);
	}

	function onGetLoggedInMember(event, response) {
		member = response.member;
		allowLoggedInControls();
	}

	function onShowView() {
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	init();
}