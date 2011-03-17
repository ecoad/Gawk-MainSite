function MemberControl (config) {

	var global = this;
	var member = {};

	var config = config;

	var loggedIn = false;

	init();

	function init() {
		$(document).bind("Gawk.Model.Init", onModelInit);
	}

	function onModelInit() {
		initFacebook();

		addEventListeners();
		getLoggedInMember();
	}

	function addEventListeners() {
		$(document).bind("Gawk.UI.LogoutRequest", logOut);
		$(document).bind("Gawk.UI.ProfileUpdate", onProfileUpdate);
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
		$.post(config.getApiLocation(), {Action: "Member.Login", FacebookId: facebookId}, onLoginResponse, "json");
	}

	function logInSiteRegisteredMember(emailAddress, password) {
		$.post(config.getApiLocation(), {
				Action: "Member.Login",
				EmailAddress: emailAddress,
				Password: password
			}, onLoginResponse, "json");
	}

	function getLoggedInMember() {
		$.post(config.getApiLocation(), {Action: "Member.GetLoggedInMember"}, onLoginResponse, "json");
	}

	function onLoginResponse(response) {
		if (response.success) {
			member = response.member;
			loggedIn = true;
			$(document).trigger("Gawk.Member.LoggedIn", [response]);
		} else {
			$(document).trigger("Gawk.Member.LoggedOut");
		}
	}

	function logOut() {
		$.getJSON(config.getApiLocation(), {Action: "Member.LogOut"});
		FB.logout(function () {
			$(document).trigger("Gawk.Member.LoggedOut");
		});
	}

	function onProfileUpdate() {
		$.post(config.getApiLocation(), {Action: "Member.UpdateProfile", Member: $.toJSON(getSkinnyMember())});
	}

	function getSkinnyMember() {
		var skinnyMember = jQuery.extend({}, member);
		delete skinnyMember.friends;
		delete skinnyMember.wallBookmarks;

		return skinnyMember;
	}
}