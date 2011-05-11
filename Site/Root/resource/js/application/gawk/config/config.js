function Config(configData) {
	var	apiLocation = configData.apiLocation,
	wall = null, profileMember = null,
	initView = configData.initView,
	fbAppId = configData.fbAppId,
	fbSession = configData.fbSession;

	try {
		wall = $.parseJSON(configData.currentWall);
	} catch (e) {}

	try {
		profileMember = $.parseJSON(configData.profileMember);
	} catch (e) {}

	Config.prototype.getApiLocation = function() {
		return apiLocation;
	};

	Config.prototype.getWall = function() {
		return wall;
	};

	Config.prototype.getProfileMember = function() {
		return profileMember;
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

	Config.prototype.isWallSecureIdSystem = function(wallSecureId) {
		switch (wallSecureId) {
			case "main-wall":
			case "favourite-gawks":
				return true;
				break;
		};
		return false;
	};
}