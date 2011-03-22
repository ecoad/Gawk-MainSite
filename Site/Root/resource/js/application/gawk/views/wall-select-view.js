function WallSelectView() {
	var global = this,
		element = $("#wall-select-view"),
		newWallUrlFriendlyName = $(".create-wall input[name=UrlFriendly]");

	function init() {
		assignEventListeners();
		newWallUrlFriendlyName.placeholder("your-wall-here");
	}

	function assignEventListeners() {
		$(document).bind("Gawk.UI.AllHide", onHideView);
		$(document).bind("Gawk.UI.WallSelectShow", onShowView);

		element.find("form").submit(onFormSubmit);
	}

	function onFormSubmit(event) {
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.WallEditShow", [newWallUrlFriendlyName.val()]);
		event.preventDefault();
	}

	function onShowView() {
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	init();
}