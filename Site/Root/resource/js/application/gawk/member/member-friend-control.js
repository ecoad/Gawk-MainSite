function MemberFriendControl (config) {
	var global = this;

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("GawkModelAddFriend", onAddFriendRequest);
		$(document).bind("GawkModelRemoveFriend", onRemoveFriendRequest);
	}

	function onAddFriendRequest(event, friendSecureId) {
		$.post(config.getApiLocation(), {
			Action: "MemberFriend.AddFriend",
			FriendSecureId: friendSecureId
		}, onAddFriendResponse, "json");
	}

	function onAddFriendResponse(response) {
		$(document).trigger("GawkModelRemoveFriendResponse", [response]);
	}

	function onRemoveFriendRequest(event, friendSecureId) {
		$.post(config.getApiLocation(), {
			Action: "MemberFriend.RemoveFriend",
			FriendSecureId: friendSecureId
		}, onRemoveFriendResponse, "json");
	}

	function onRemoveFriendResponse(response) {
		$(document).trigger("GawkModelRemoveFriendResponse", [response]);
	}

	init();
}