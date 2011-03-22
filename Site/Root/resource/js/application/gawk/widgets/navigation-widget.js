function NavigationWidget() {
	var global = this;

	var element = $("#navigation-widget");
	var newGawkElement = element.find(".new-gawk");
	var newWallElement = element.find(".wall-select");
	var yoursElement = element.find(".yours");

	init();

	function init() {
		$(document).bind("Gawk.Model.Init", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		newGawkElement.click(onNewGawkClick);
		newWallElement.click(onWallSelectClick);
		yoursElement.click(onYoursClick);
	}

	function onNewGawkClick() {

		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.GawkShow");
	}

	function onWallSelectClick() {
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.WallSelectShow");
	}

	function onYoursClick() {
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.YoursShow");
	}
}