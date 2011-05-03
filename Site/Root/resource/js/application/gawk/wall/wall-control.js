function WallControl (config, memberControl) {
	var global = this, wall = config.getWall();

	init();

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("GawkModelSaveWall", onSaveWallRequest);
	}

	function onSaveWallRequest(event, wall) {
		wall.memberSecureId = memberControl.getMember().secureId;
		$.post(config.getApiLocation(), {Action: "Wall.Save", Token: memberControl.getMember().token, WallData: $.toJSON(wall)},
				onSaveWallResponse, "json");
	}

	function onSaveWallResponse(response) {
		$(document).trigger("GawkModelSaveWallResponse", [response]);
	}
}