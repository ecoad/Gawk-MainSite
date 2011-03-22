function Config(configData) {
	var	apiLocation = configData.apiLocation,
	wallSecureId = configData.currentWallSecureId,
	initView = configData.initView,
	fbAppId = configData.fbAppId,
	fbSession = configData.fbSession;

	Config.prototype.getApiLocation = function() {
		return apiLocation;
	};

	Config.prototype.getWallSecureId = function() {
		return wallSecureId;
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