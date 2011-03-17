function WallView() {
	var global = this, element = $("#wall-view");

	function assignEventListeners() {
		$(document).bind("Gawk.UI.AllHide", onHideView);
		$(document).bind("Gawk.UI.NewWallShow", onShowView);
	}

	function onShowView() {
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	assignEventListeners();
}