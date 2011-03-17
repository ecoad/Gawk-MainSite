function NavigationWidget() {
	var global = this;

	var element = $("#navigation-widget");
	var newGawkElement = element.find(".new-gawk");
	var newWallElement = element.find(".new-wall");
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
		newWallElement.click(onNewWallClick);
		yoursElement.click(onYoursClick);
	}

	function onNewGawkClick() {
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.GawkShow");
	}

	function onNewWallClick() {
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.NewWallShow");
	}

	function onYoursClick() {
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.YoursShow");
	}
}