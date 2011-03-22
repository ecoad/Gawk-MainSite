function GawkView(config) {
	var config = config;
	var element = $("#gawk-view");
	var swfObjectId = "gawk-swf";
	var gawkFlashContainerElement = $("<div>").attr("id", "Gawk");
	var loggedIn = false;
	var wall = {};
	element.append(gawkFlashContainerElement);

	function init() {
		$(document).bind("Gawk.Model.Init", onModelInit);
	}

	function setupView() {
		element.find("h3").html(wall.name);
	}

	function onModelInit() {
		addView();
		assignEventListeners();
	}

	function assignEventListeners() {
		$(document).bind("Gawk.Member.LoggedIn", onLoggedIn);
		$(document).bind("Gawk.Member.LoggedOut", onLoggedOut);

		$(document).bind("Gawk.UI.AllHide", onHideView);
		$(document).bind("Gawk.UI.GawkShow", onShowView);

		$("#view-utility .record").bind("click", function () {
			document.getElementById(swfObjectId).recordNewFromExternal();
		});
	}

	function addView() {
		element.show();
		gawkFlashVars = {
			apiLocation: window.location.host + config.getApiLocation(),
			wallSecureId: config.getWallSecureId(),
			loggedIn: loggedIn
		};

		swfobject.embedSWF("/resource/flash/Gawk.swf?v=@VERSION-NUMBER@", gawkFlashContainerElement.attr("id"), "1050", "655", "9.0.0", false,
				gawkFlashVars, {}, {id: swfObjectId});
	}

	function onLoggedIn() {
		loggedIn = true;
		document.getElementById(swfObjectId).logInFromExternal();
	}

	function onLoggedOut() {
		loggedIn = false;
		document.getElementById(swfObjectId).logOutFromExternal();
	}

	function onShowView(event, loadedWall) {
		if (loadedWall) {
			wall = loadedWall;
		}

		setupView();
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	init();
}