function MemberControl (config) {

	var global = this;
	var member = {};

	var loggedIn = false;

	init();

	function init() {
		$(document).bind("GawkModelInit", onModelInit);
	}

	function onModelInit() {
		initFacebook();

		addEventListeners();
		getLoggedInMember();
	}

	function addEventListeners() {
		$(document).bind("GawkUILogoutRequest", logOut);
		$(document).bind("GawkUIProfileUpdate", onProfileUpdate);
	}

	function initFacebook() {
		window.fbAsyncInit = function() {
			FB.init({
				appId: config.getFacebookAppId(),
				session: config.getFacebookSession(),
				status: true,
				cookie: true,
				xfbml: true
			});

			FB.Event.subscribe("auth.login", function() {
				logInFacebookRegisteredMember(-1);
			});
		};

		(function() {
			var e = document.createElement('script');
			e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
			e.async = true;
			document.getElementById('fb-root').appendChild(e);
		}());
	}

	function logInFacebookRegisteredMember(facebookId) {
		$.post(config.getApiLocation(), {
			Action: "Member.Login",
			FacebookId: facebookId
		}, function() {
			$(document).trigger("GawkUILoggingInOverlayShow");
			window.location.reload();
		}, "json");
	}

	/*
	function logInSiteRegisteredMember(emailAddress, password) {
		$.post(config.getApiLocation(), {
				Action: "Member.Login",
				EmailAddress: emailAddress,
				Password: password
			}, onLoginResponse, "json");
	}
	*/

	function getLoggedInMember() {
		$.get(config.getApiLocation(), {Action: "Member.GetLoggedInMember"}, onLoginResponse, "json");
	}

	function onLoginResponse(response) {
		if (response.success) {
			member = response.member;
			loggedIn = true;
			$(document).trigger("GawkMemberLoggedIn", [response]);
			$(document).trigger("GawkModelGetRecentWallActivity");
		} else {
			$(document).trigger("GawkMemberLoggedOut");
		}
	}

	function logOut() {
		$.getJSON(config.getApiLocation(), {Action: "Member.Logout"}, function () {
			FB.logout(function () {
				window.location.reload();
			});
		});

	}

	function onProfileUpdate() {
		$.post(config.getApiLocation(), {Action: "Member.UpdateProfile", Member: $.toJSON(getSkinnyMember())});
	}

	this.getMember = function() {
		return member;
	};
}