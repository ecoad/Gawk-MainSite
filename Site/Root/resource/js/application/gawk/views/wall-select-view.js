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
		newWallUrlFriendlyName.placeholder("your-wall-name-here");
	}

	function assignEventListeners() {
		element.find("form").submit(onFormSubmit);
		element.find("a.button").click(onFormSubmit);
	}

	function onFormSubmit(event) {
		window.location = "/wall/create/" + newWallUrlFriendlyName.val();
		event.preventDefault();
	}

	init();
}