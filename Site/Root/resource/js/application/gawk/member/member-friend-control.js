function MemberFriendControl (config) {
	var global = this;

	function init() {
		$(document).bind("Gawk.Model.Init", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("Gawk.Model.AddFriend", onAddFriendRequest);
		$(document).bind("Gawk.Model.RemoveFriend", onRemoveFriendRequest);
	}

	function onAddFriendRequest(event, friendSecureId) {
		$.post(config.getApiLocation(), {
			Action: "MemberFriend.AddFriend",
			FriendSecureId: friendSecureId
		}, onAddFriendResponse, "json");
	}

	function onAddFriendResponse(response) {
		$(document).trigger("Gawk.Model.RemoveFriendResponse", [response]);
	}

	function onRemoveFriendRequest(event, friendSecureId) {
		$.post(config.getApiLocation(), {
			Action: "MemberFriend.RemoveFriend",
			FriendSecureId: friendSecureId
		}, onRemoveFriendResponse, "json");
	}

	function onRemoveFriendResponse(response) {
		$(document).trigger("Gawk.Model.RemoveFriendResponse", [response]);
	}

	init();
}