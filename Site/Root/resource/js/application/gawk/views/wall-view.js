function GawkView(config) {
	var element = $("#wall-view");
	var swfObjectId = "gawk-swf";
	var gawkFlashContainerElement = $("#Gawk");
	var recordButton = element.find(".record");
	var loggedIn = false;
	var wallLoaded = false;
	var wall = config.getWall();
	var bookmarkLink = element.find("span.bookmark"), bookmarkLabelAdd = "add bookmark",
		bookmarkLabelRemove = "remove bookmark";

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
		$(document).bind("GawkUIFlashLoaded", onFlashLoaded);
	}

	function onModelInit() {
		addView();
		assignEventListeners();
	}

	function onFlashLoaded() {
		wallLoaded = true;
		checkFirstWallVisit();
	}

	function assignEventListeners() {
		$(document).bind("GawkMemberGotLoggedInMember", onGotLoggedInMember);

		$(document).bind("GawkUIAllHide", onHideView);
		$(document).bind("GawkUIWallShow", onShowView);
		$(document).bind("GawkModelGetWallResponse", onGetWallResponse);
		$(document).bind("GawkModelGetRecentWallActivityResponse", onRecentWallActivityResponse);
		$(document).bind("GawkUIMainWallDenyOverlayShow", onGawkMainWallDenyOverlay);
		$(document).bind("GawkUINoWebcamOverlayShow", onNoWebcamOverlayShow);
		$(document).bind("GawkUIOverlayShow", onOverlayShow);
		$(".box-close-button").click(onOverlayClose);

		recordButton.bind("click", onRecordClick);
		bookmarkLink.click(onBookmarkClick);

		$("select[name=SelectWall]").change(onWallSelectChange);
	}

	function addView() {
		element.show();
		gawkFlashVars = {
			apiLocation: config.getApiLocation(),
			wallId: wall.secureId,
			useStageVideo: "false",
			useDebugOverlay: "false"
		};

		var params = {};
		params.allowscriptaccess = "always";
		params.wmode = "transparent";

		swfobject.embedSWF("/resource/flash/GawkFlash.swf?v=@VERSION-NUMBER@", gawkFlashContainerElement.attr("id"),
			"1050", "655", "9.0.0", false, gawkFlashVars, params, {id: swfObjectId});
	}

	function onRecordClick(event) {
		if (loggedIn) {
			if (config.isSystemWall()) {
				$(document).trigger("GawkUIMainWallDenyOverlayShow");
			} else {
				document.getElementById(swfObjectId).recordNewFromExternal();
			}
		} else {
			$(document).trigger("GawkUILoginOverlayShow");
		}

		event.preventDefault();
	}

	function onGetWallResponse(event, response) {
		wall = response;
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

		var createWallOption = $("<option />").attr("value", "/wall/create").html("create a wall&hellip;");
		select.append(createWallOption);

		setWallBookmarkState(recentActivity.bookmarks);
	}

	function setWallBookmarkState(memberBookmarks) {
		bookmarkLink.attr("title", bookmarkLabelAdd);
		$(memberBookmarks).each(function(index, bookmark) {
			if (bookmark.secureId == wall.secureId) {
				bookmarkLink.addClass("selected");
				bookmarkLink.attr("title", bookmarkLabelRemove);
				return false;
			}
		});
	}

	function onBookmarkClick(event) {
		event.preventDefault();

		if (!loggedIn) {
			$(document).trigger("GawkUILoginOverlayShow");
			return;
		}

		var isAlreadyBookmarked = bookmarkLink.hasClass("selected");

		if (isAlreadyBookmarked) {
			bookmarkLink.removeClass("selected");
			bookmarkLink.attr("title", bookmarkLabelAdd);
			$(document).trigger("GawkUIMemberWallBookmarkRemoveRequest", wall.secureId);
		} else {
			bookmarkLink.addClass("selected");
			bookmarkLink.attr("title", bookmarkLabelRemove);
			$(document).trigger("GawkUIMemberWallBookmarkAddRequest", wall.secureId);
		}
	}

	function onGotLoggedInMember() {
		loggedIn = true;
		if (wallLoaded) {
			try {
				document.getElementById(swfObjectId).logInFromExternal();
			} catch (error) {
			}
		} else {
			setTimeout(onGotLoggedInMember, 500);
		}
	}

	function onShowView(event, loadedWall) {
		if (loadedWall) {
			wall = loadedWall;
		}

		element.show();
	}

	function onHideView() {
		//element.hide();
	}

	function onGawkMainWallDenyOverlay() {
		$(document).trigger("GawkUIOverlayShow");
		$.box.show({content: $("#gawk-main-wall-overlay")});

		$("#gawk-main-wall-overlay").find("form").submit(function(event) {
			event.preventDefault();
			var wallName = wallCreateName.val();
			window.location = "/wall/create/" + wallName;
		});

		var wallCreateName = $("#gawk-main-wall-overlay").find("input[name=WallCreateName]");
		wallCreateName.placeholder("your-wall-name-here");
	}

	function onNoWebcamOverlayShow() {
		$(document).trigger("GawkUIOverlayShow");
		$.box.show({content: $("#gawk-no-webcam-overlay")});
	}

	function onWallSelectChange() {
		window.location = $('select[name=SelectWall]').val();
	}

	function checkFirstWallVisit() {
		if ($.cookie("Rt") == null) {
//			$(document).trigger("GawkUIOverlayShow");
//			$.box.show({content: $("#welcome-overlay")});
//			$.cookie("Rt", "true", {expires: 3650});
		}
	}

	function onOverlayShow() {
		//$("object").hide(); //TODO: not needed any more
	}

	function onOverlayClose() {
		//$("object").show();
	}

	init();
}
