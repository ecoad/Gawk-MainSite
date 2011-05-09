function MemberWallBookmarkControl (config) {
	var global = this;

	init();

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("GawkUIMemberWallBookmarkAddRequest", onGetRecentWallActivityRequest);
		$(document).bind("GawkUIMemberWallBookmarkRemoveRequest", onGetRecentWallActivityRequest);
	}

	function onGetRecentWallActivityRequest(event, wallSecureId) {
		var action;
		if (event.type == "GawkUIMemberWallBookmarkAddRequest") {
			action = "AddWallBookmark";
		} else {
			action = "RemoveWallBookmark";
		}

		$.post(config.getApiLocation(), {
			Action: "MemberWallBookmark." + action,
			WallSecureId: wallSecureId
		}, onMemberWallBookmarkResponse, "json");
	}

	function onMemberWallBookmarkResponse(response) {
		$(document).trigger("GawkModelMemberWallBookmarkResponse", [response]);
	}
}