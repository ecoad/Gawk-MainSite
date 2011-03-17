function Config(configData) {
	var apiLocation = configData.apiLocation;
	var currentWallId = configData.currentWallId;
	var fbAppId = configData.fbAppId;
	var fbSession = configData.fbSession;
	
	
	Config.prototype.getApiLocation = function() {
		return apiLocation;
	};
	
	Config.prototype.getCurrentWallId = function() {
		return currentWallId;
	};
	
	Config.prototype.getFacebookAppId = function() {
		return fbAppId;
	};
	
	Config.prototype.getFacebookSession = function() {
		return fbSession;
	};
}