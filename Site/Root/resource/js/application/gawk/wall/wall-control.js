function WallControl (config, memberControl) {
	var global = this, wall = config.getWall();

	init();

	function init() {
		$(document).bind("GawkModel.Init", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("GawkModel.SaveWall", onSaveWallRequest);
	}

	function onSaveWallRequest(event, wall) {
		wall.memberSecureId = memberControl.getMember().secureId;
		$.post(config.getApiLocation(), {Action: "Wall.Save", Token: memberControl.getMember().token, WallData: $.toJSON(wall)},
				onSaveWallResponse, "json");
	}

	function onSaveWallResponse(response) {
		$(document).trigger("GawkModel.SaveWallResponse", [response]);
	}
}