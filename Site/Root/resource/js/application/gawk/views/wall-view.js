function GawkView(config) {
	var element = $("#wall-view");
	var swfObjectId = "gawk-swf";
	var gawkFlashContainerElement = $("<div>").attr("id", "Gawk");
	var loggedIn = false;
	var wallLoaded = false;
	var wall = config.getWall();
	var bookmarkLink = element.find("h3").find("span.bookmark");

	function init() {
		element.append(gawkFlashContainerElement);
		$(document).bind("GawkModelInit", onModelInit);
		$(document).bind("GawkUIFlashLoaded", onFlashLoaded);
	}

	function setupView() {
		element.find(".wall-information").show();
		element.find("h3").find("span.name").html(wall.name);
		element.find("p.description").html(wall.description);

		if (config.isWallSecureIdSystem(wall.secureId)) {
			bookmarkLink.hide();
		} else {
			bookmarkLink.show();
		}
	}

	function onModelInit() {
		addView();
		assignEventListeners();
	}

	function onFlashLoaded() {
		wallLoaded = true;
	}

	function assignEventListeners() {
		$(document).bind("GawkMemberLoggedIn", onLoggedIn);
		$(document).bind("GawkMemberLoggedOut", onLoggedOut);

		$(document).bind("GawkUIAllHide", onHideView);
		$(document).bind("GawkUIWallShow", onShowView);
		$(document).bind("GawkModelGetWallResponse", onGetWallResponse);
		$(document).bind("GawkModelGetRecentWallActivityResponse", onRecentWallActivityResponse);
		$(document).bind("GawkUIMainWallDenyOverlayShow", onGawkMainWallDenyOverlay);
		$(document).bind("GawkUINoWebcamOverlayShow", onNoWebcamOverlayShow);

		element.find(".record").bind("click", function (event) {
			if (loggedIn) {
				if (config.isWallSecureIdSystem(wall.secureId)) {
					$(document).trigger("GawkUIMainWallDenyOverlayShow");
				} else {
					document.getElementById(swfObjectId).recordNewFromExternal();
				}
			} else {
				$(document).trigger("GawkUILoginOverlayShow");
			}

			event.preventDefault();
		});
		element.find("h3").find("span.bookmark").click(onBookmarkClick);
		$("select[name=SelectWall]").change(onWallSelectChange);
	}

	function addView() {
		element.show();
		gawkFlashVars = {
			apiLocation: config.getApiLocation(),
			wallId: wall.secureId,
			useStageVideo: "false"
		};

		var params = {};
		params.allowscriptaccess = "always";
		params.wmode = "direct";

		swfobject.embedSWF("/resource/flash/GawkFlash.swf?v=@VERSION-NUMBER@", gawkFlashContainerElement.attr("id"),
			"1050", "655", "9.0.0", false, gawkFlashVars, params, {id: swfObjectId});
	}

	function onGetWallResponse(event, response) {
		wall = response;
		setupView();
	}

	function onRecentWallActivityResponse(event, response) {
		//TODO: Refactor

		var recentActivity = response.recentActivity;
		element.find("div.wall-select").show();
		var select = element.find("div.wall-select").find("select[name=SelectWall]");
		select.html("");

		var currentOption = $("<option>").attr("value", wall.url).html(wall.name);
		select.append(currentOption);

		var mainOptionGroup = $("<optgroup>").attr("label", "main");
		select.append(mainOptionGroup);

		var mainOption = $("<option>").attr("value", "/").html("main wall");
		mainOptionGroup.append(mainOption);
		var friendsOption = $("<option>").attr("value", "/friends").html("friends");
		mainOptionGroup.append(friendsOption);
		var favouritedOption = $("<option>").attr("value", "/favourited").html("favourites");
		mainOptionGroup.append(favouritedOption);

		select.append(mainOptionGroup);

		if (recentActivity.wallsCreatedByMember.length > 0) {
			var myWallsOptionGroup = $("<optgroup>").attr("label", "my walls");
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

		var createWallOption = $("<option>").attr("value", "/wall/").html("create a wall&hellip;");
		select.append(createWallOption);

		setWallBookmarkState(recentActivity.bookmarks);
	}

	function setWallBookmarkState(memberBookmarks) {
		element.find("h3").find("span.bookmark").removeClass("selected");
		$(memberBookmarks).each(function(index, bookmark) {
			if (bookmark.secureId == wall.secureId) {
				element.find("h3").find("span.bookmark").addClass("selected");
				return false;
			}
		});
	}

	function onBookmarkClick(event) {
		event.preventDefault();

		var isAlreadyBookmarked = element.find("h3").find("span.bookmark").hasClass("selected");

		if (isAlreadyBookmarked) {
			element.find("h3").find("span.bookmark").removeClass("selected");
			$(document).trigger("GawkUIMemberWallBookmarkRemoveRequest", wall.secureId);
		} else {
			element.find("h3").find("span.bookmark").addClass("selected");
			$(document).trigger("GawkUIMemberWallBookmarkAddRequest", wall.secureId);
		}
	}

	function onLoggedIn() {
		loggedIn = true;
		if (wallLoaded) {
			document.getElementById(swfObjectId).logInFromExternal();
		} else {
			setTimeout(onLoggedIn, 500);
		}
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

	function onNoWebcamOverlayShow() {
		$.box.show({content: $("#gawk-no-webcam-overlay")});
	}

	function onWallSelectChange() {
		window.location = $('select[name=SelectWall]').val();
	}

	init();
}