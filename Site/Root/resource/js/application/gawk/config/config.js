function Config(configData) {
	var	apiLocation = configData.apiLocation,
	wall = null, member = null,
	initView = configData.initView,
	fbAppId = configData.fbAppId,
	fbSession = configData.fbSession;

	try {
		wall = $.parseJSON(configData.currentWall);
	} catch (e) {}

	try {
		member = $.parseJSON(configData.member);
	} catch (e) {}

	Config.prototype.getApiLocation = function() {
		return apiLocation;
	};

	Config.prototype.getWall = function() {
		return wall;
	};

	Config.prototype.getMember = function() {
		return member;
	};

	Config.prototype.getFacebookAppId = function() {
		return fbAppId;
	};

	Config.prototype.getFacebookSession = function() {
		return fbSession;
	};

	Config.prototype.getInitView = function() {
		return initView;
	};
}