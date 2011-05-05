function GawkView(config) {
	var element = $("#gawk-view");
	var swfObjectId = "gawk-swf";
	var gawkFlashContainerElement = $("<div>").attr("id", "Gawk");
	var loggedIn = false;
	var wall = config.getWall();
	element.append(gawkFlashContainerElement);

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function setupView() {
		element.find(".wall-information").show();
		element.find("h3").html(wall.name);
		element.find("p.description").html(wall.description);
	}

	function onModelInit() {
		addView();
		assignEventListeners();
	}

	function assignEventListeners() {
		$(document).bind("GawkMemberLoggedIn", onLoggedIn);
		$(document).bind("GawkMemberLoggedOut", onLoggedOut);

		$(document).bind("GawkUIAllHide", onHideView);
		$(document).bind("GawkUIGawkShow", onShowView);
		$(document).bind("GawkModelGetWallResponse", onGetWallResponse);
		$(document).bind("GawkModelGetRecentWallActivityResponse", onRecentWallActivityResponse);
		$(document).bind("GawkMainWallDenyOverlayShow", onGawkMainWallDenyOverlay);

		element.find(".record").bind("click", function () {
			if (loggedIn) {
				if (wall.url == "/") {
					$(document).trigger("GawkMainWallDenyOverlayShow");
				} else {
					document.getElementById(swfObjectId).recordNewFromExternal();
				}
			} else {
				$(document).trigger("GawkUILoginOverlayShow");
			}
		});
	}

	function addView() {
		element.show();
		gawkFlashVars = {
			apiLocation: config.getApiLocation(),
			wallId: config.getWall().secureId
		};

		swfobject.embedSWF("/resource/flash/GawkFlash.swf?v=@VERSION-NUMBER@", gawkFlashContainerElement.attr("id"),
			"1050", "655", "9.0.0", false, gawkFlashVars, {}, {id: swfObjectId});
	}

	function onGetWallResponse(event, response) {
		wall = response;
		setupView();
	}

	function onRecentWallActivityResponse(event, response) {
		var recentActivity = response.recentActivity;
		element.find("div.wall-select").show();
		var select = element.find("div.wall-select").find("select[name=SelectWall]");
		select.html("");

		var currentOption = $("<option>").attr("value", wall.url).html(wall.name);
		select.append(currentOption);

		var mainOptionGroup = $("<optgroup>").attr("label", "main");
		select.append(mainOptionGroup);

		var mainOption = $("<option>").attr("value", "/").html("Main");
		mainOptionGroup.append(mainOption);

		var friendsOption = $("<option>").attr("value", "/friends").html("Friends");
		mainOptionGroup.append(friendsOption);

		select.append(mainOptionGroup);

		var myWallsOptionGroup = $("<optgroup>").attr("label", "my walls");

		if (recentActivity.wallsCreatedByMember.length > 0) {
			$(recentActivity.wallsCreatedByMember).each(function(index, value) {
				var wallOption = $("<option>").attr("value", value.url).html(value.name);
				myWallsOptionGroup.append(wallOption);
			});
		}
		select.append(myWallsOptionGroup);

		if (recentActivity.bookmarks.length > 0) {
			var bookmarksOptionGroup = $("<optgroup>").attr("label", "bookmarks");

			$(recentActivity.bookmarks).each(function(index, value) {
				var option = $("<option>").attr("value", value.url).html(value.name);
				bookmarksOptionGroup.append(option);
			});
			select.append(bookmarksOptionGroup);
		}

		if (recentActivity.recentWallParticipation.length > 0) {
			var recentOptionGroup = $("<optgroup>").attr("label", "walls i'm on");

			$(recentActivity.recentWallParticipation).each(function(index, value) {
				var option = $("<option>").attr("value", value.url).html(value.name);
				recentOptionGroup.append(option);
			});
			select.append(recentOptionGroup);
		}
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

	function onGawkMainWallDenyOverlay() {
		$.box.show({content: $("#gawk-main-wall-overlay")});
	}

	init();
}