function MemberRecentWallsControl (config) {

	var global = this,
		recentActivity = null,
		loading = false;

	init();

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("GawkModelGetRecentWallActivity", onGetRecentWallActivityRequest);
	}

	function onGetRecentWallActivityRequest() {
		if (loading) {
			return false;
		}

		if (!recentActivity) {
			loading = true;
			$.get(config.getApiLocation(), {Action: "MemberWallBookmark.GetRecentWallActivity"}, onRecentWallActivityResponse, "json");
		} else {
			onRecentWallActivityResponse(recentActivity);
		}
	}

	function onRecentWallActivityResponse(response) {
		recentActivity = response;
		loading = false;
		$(document).trigger("GawkModelGetRecentWallActivityResponse", [recentActivity]);
	}
}