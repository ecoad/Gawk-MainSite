function GawkView(config) {
	var config = config;
	var element = $("#gawk-view");
	var swfObjectId = "gawk-swf";
	var gawkFlashContainerElement = $("<div>").attr("id", "Gawk");
	var loggedIn = false;
	var wall = config.getWall();
	element.append(gawkFlashContainerElement);

	function init() {
		$(document).bind("Gawk.Model.Init", onModelInit);
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
		$(document).bind("Gawk.Member.LoggedIn", onLoggedIn);
		$(document).bind("Gawk.Member.LoggedOut", onLoggedOut);

		$(document).bind("Gawk.UI.AllHide", onHideView);
		$(document).bind("Gawk.UI.GawkShow", onShowView);
		$(document).bind("Gawk.Model.GetWallResponse", onGetWallResponse);
		$(document).bind("Gawk.Model.GetRecentWallActivityResponse", onRecentWallActivityResponse);

		$("#record-gawk").bind("click", function () {
			document.getElementById(swfObjectId).recordNewFromExternal();
		});
	}

	function addView() {
		element.show();
		gawkFlashVars = {
			apiLocation: config.getApiLocation(),
			wallId: config.getWall().secureId
		};

		swfobject.embedSWF("/resource/flash/Gawk.swf?v=@VERSION-NUMBER@", gawkFlashContainerElement.attr("id"), "1050", "655", "9.0.0", false,
				gawkFlashVars, {}, {id: swfObjectId});
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

		var mainOptionGroup = $("<optgroup>").attr("label", "Main");
		select.append(mainOptionGroup);

		var mainOption = $("<option>").attr("value", "/").html("Main");
		mainOptionGroup.append(mainOption);

		var friendsOption = $("<option>").attr("value", "/friends").html("Friends");
		mainOptionGroup.append(friendsOption);

		select.append(mainOptionGroup);

		var myWallsOptionGroup = $("<optgroup>").attr("label", "My Walls");

		if (recentActivity.wallsCreatedByMember.length > 0) {
			$(recentActivity.wallsCreatedByMember).each(function(index, value) {
				var wallOption = $("<option>").attr("value", value.url).html(value.name);
				myWallsOptionGroup.append(wallOption);
			});
		}
		select.append(myWallsOptionGroup);

		if (recentActivity.bookmarks.length > 0) {
			var bookmarksOptionGroup = $("<optgroup>").attr("label", "Bookmarks");

			$(recentActivity.bookmarks).each(function(index, value) {
				var option = $("<option>").attr("value", value.url).html(value.name);
				bookmarksOptionGroup.append(option);
			});
			select.append(bookmarksOptionGroup);
		}

		if (recentActivity.recentWallParticipation.length > 0) {
			var recentOptionGroup = $("<optgroup>").attr("label", "Walls I'm On");

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

	init();
}