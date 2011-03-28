function WallSelectView() {
	var global = this,
		element = $("#wall-select-view"),
		newWallUrlFriendlyName = $(".create-wall input[name=UrlFriendly]"),
		loggedIn = false,
		bookmarksList = $("#wall-select-view").find(".bookmarks ul"),
		recentWallsList = $("#wall-select-view").find(".recent-walls ul"),
		createdList = $("#wall-select-view").find(".your-walls ul");

	function init() {
		assignEventListeners();
		newWallUrlFriendlyName.placeholder("your-wall-here");
	}

	function assignEventListeners() {
		$(document).bind("Gawk.UI.AllHide", onHideView);
		$(document).bind("Gawk.UI.WallSelectShow", onShowView);
		$(document).bind("Gawk.Model.GetRecentWallActivityResponse", onRecentWallActivityResponse);
		$(document).bind("Gawk.Member.LoggedIn", onLoggedIn);
		$(document).bind("Gawk.Member.LoggedOut", onLoggedOut);

		element.find("form").submit(onFormSubmit);
	}

	function onFormSubmit(event) {
		$(document).trigger("Gawk.UI.AllHide");
		$(document).trigger("Gawk.UI.WallEditShow", [newWallUrlFriendlyName.val()]);
		event.preventDefault();
	}

	function showLoggedInView(recentActivity) {
		recentWallsList.html("");
		$(recentActivity.recentWallParticipation).each(function (index, wall) {
			addItemToList(wall, recentWallsList);
		});

		bookmarksList.html("");
		$(recentActivity.bookmarks).each(function (index, wall) {
			addItemToList(wall, bookmarksList);
		});

		createdList.html("");
		$(recentActivity.wallsCreatedByMember).each(function (index, wall) {
			addItemToList(wall, createdList);
		});
	}

	function addItemToList(wall, ul) {
		var li, link;

		link = $("<a>").attr("href", wall.url).html(wall.name).attr("title", wall.description);

		li = $("<li>").html(link);
		ul.append(li);
	}

	function loadRecentWallActivity() {
		$(document).trigger("Gawk.Model.GetRecentWallActivity");
	}

	function onRecentWallActivityResponse(event, response) {
		showLoggedInView(response.recentActivity);
	}

	function onLoggedIn() {
		loggedIn = true;
		loadRecentWallActivity();
	}

	function onLoggedOut() {
		loggedIn = false;
		//TODO: Show logged out
	}

	function onShowView() {
		if (loggedIn) {
			loadRecentWallActivity();
		}
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	init();
}