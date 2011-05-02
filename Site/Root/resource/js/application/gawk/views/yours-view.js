function YoursView() {
	var global = this;
	var member = {};

	var element = $("#yours-view");
	var loggedInView = element.find(".logged-in-view");
	var loggedOutView = element.find(".logged-out-view");
	var friendsListElement = element.find(".friends-list");
	var bookmarkedListElement = element.find(".bookmarked-list");

	var profileElement = element.find(".profile");
	var gawksPublicSelect = profileElement.find("select[name=GawksPublic]");
	var gawksFavouritePublicSelect = profileElement.find("select[name=GawksFavouritePublic]");

	function init() {
		$(document).bind("GawkModel.Init", onModelInit);
	}

	function onModelInit() {
		assignEventListeners();
	}

	function assignEventListeners() {
		element.find(".login").click(onLoginClick);
		gawksPublicSelect.change(onProfileSettingsChange);
		gawksFavouritePublicSelect.change(onProfileSettingsChange);

		$(document).bind("Gawk.Member.LoggedIn", onLoggedIn);
		$(document).bind("Gawk.Member.LoggedOut", onLoggedOut);

		$(document).bind("GawkUI.AllHide", onHideView);
		$(document).bind("GawkUI.YoursShow", onShowView);
	}

	function updateView() {
		updateFriendsView();
		updateWallBookmarksView();
		updateProfileView();
	}

	function updateFriendsView() {
		friendsListElement.html("");
		$(member.friends).each(function (index, friend) {
			var li = $("<li>");
			var link = $("<a>").attr("href", "#");
			if (friend.fbId !== undefined) {
				var image = $("<img>");
				image.attr("src", "https://graph.facebook.com/" + friend.fbId + "/picture");
				link.append(image);
			}

			var name = $("<span>").html(friend.name);
			link.append(name);
			li.append(link);
			friendsListElement.append(li);
		});
	}

	function updateWallBookmarksView() {
		bookmarkedListElement.html("");

		$(member.wallBookmarks).each(function (index, bookmark) {
			var li = $("<li>");
			var link = $("<a>").attr("href", "#");
			link.html(bookmark.wall.secureId);
			li.append(link);
			bookmarkedListElement.append(li);
		});
	}

	function updateProfileView() {
		gawksPublicSelect.attr("selectedIndex", member.privacy.gawksPublic);
		gawksFavouritePublicSelect.attr("selectedIndex", member.privacy.gawksFavouritePublic);
	}

	function onLoginClick() {
		$(document).trigger("GawkUI.HideAll");
		$(document).trigger("GawkUI.LoginShow", ["Login"]);
	}

	function onLoggedIn(event, response) {
		member = response.member;
		loggedInView.show();
		loggedOutView.hide();

		updateView();
	}

	function onLoggedOut() {
		loggedOutView.show();
		loggedInView.hide();
	}

	function onProfileSettingsChange() {
		member.privacy.gawksPublic = gawksPublicSelect.attr("selectedIndex");
		member.privacy.gawksFavouritePublic = gawksFavouritePublicSelect.attr("selectedIndex");
		$(document).trigger("GawkUI.ProfileUpdate");
	}

	function onShowView() {
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	init();
}