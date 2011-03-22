function WallControl (config, memberControl) {
	var global = this, wall = {}, memberControl;

	init();

	function init() {
		$(document).bind("Gawk.Model.Init", onModelInit);
	}

	function onModelInit() {
		addEventListeners();
	}

	function addEventListeners() {
		$(document).bind("Gawk.Model.SaveWall", onSaveWallRequest);
	}

	function onSaveWallRequest(event, wall) {
		wall.memberSecureId = memberControl.getMember().secureId;
		$.post(config.getApiLocation(), {Action: "Wall.Save", Token: memberControl.getMember().token, WallData: $.toJSON(wall)},
				onSaveWallResponse, "json");
	}

	function onSaveWallResponse(response) {
		$(document).trigger("Gawk.Model.SaveWallResponse", [response]);
	}
}