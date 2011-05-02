function MemberRecentWallsControl (config) {

	var global = this,
		recentActivity = null,
		loading = false;

	init();

	function init() {
		$(document).bind("GawkModel.Init", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("GawkModel.GetRecentWallActivity", onGetRecentWallActivityRequest);
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
		$(document).trigger("GawkModel.GetRecentWallActivityResponse", [recentActivity]);
	}
}