function MemberFriendControl (config) {
	var global = this;

	function init() {
		$(document).bind("GawkModel.Init", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("GawkModel.AddFriend", onAddFriendRequest);
		$(document).bind("GawkModel.RemoveFriend", onRemoveFriendRequest);
	}

	function onAddFriendRequest(event, friendSecureId) {
		$.post(config.getApiLocation(), {
			Action: "MemberFriend.AddFriend",
			FriendSecureId: friendSecureId
		}, onAddFriendResponse, "json");
	}

	function onAddFriendResponse(response) {
		$(document).trigger("GawkModel.RemoveFriendResponse", [response]);
	}

	function onRemoveFriendRequest(event, friendSecureId) {
		$.post(config.getApiLocation(), {
			Action: "MemberFriend.RemoveFriend",
			FriendSecureId: friendSecureId
		}, onRemoveFriendResponse, "json");
	}

	function onRemoveFriendResponse(response) {
		$(document).trigger("GawkModel.RemoveFriendResponse", [response]);
	}

	init();
}