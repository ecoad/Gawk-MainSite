function MemberRecentWallsControl (config) {

	var global = this, recentActivity;

	init();

	function init() {
		$(document).bind("Gawk.Model.Init", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("Gawk.Model.GetRecentWallActivity", onGetRecentWallActivityRequest);
	}

	function onGetRecentWallActivityRequest() {
		if (!recentActivity) {
			$.get(config.getApiLocation(), {Action: "MemberWallBookmark.GetRecentWallActivity"}, onRecentWallActivityResponse, "json");
		} else {
			onRecentWallActivityResponse(recentActivity);
		}
	}

	function onRecentWallActivityResponse(response) {
		recentActivity = response;
		$(document).trigger("Gawk.Model.GetRecentWallActivityResponse", [recentActivity]);
	}
}