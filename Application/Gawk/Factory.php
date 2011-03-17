<?php
class Factory {

	/**
	 * @return ApplicationPageComponents
	 */
	static function getApplicationPageComponents() {
		require_once("ApplicationPageComponents.php");
		return new ApplicationPageComponents();
	}

	/**
	 * @return CustomArticleControl
	 */
	static function getArticleControl($type = null) {
		require_once("Article.php");
		return new CustomArticleControl($type);
	}

	/**
	 * @return StaticContentControl
	 */
	static function getStaticContentControl() {
		require_once("StaticContent/StaticContentControl.php");
		return new StaticContentControl();
	}

/**
	 * @var CroppedImageControl
	 */
	static function getCroppedImageControl() {
		require_once("CroppedImage.php");
		return new CroppedImageControl();
	}

	/**
	 * @return WallControl
	 */
	public static function getWallControl() {
		require_once "Wall/WallControl.php";
		return new WallControl();
	}

	/**
	 * @return Wall
	 */
	public static function getWall($wallData = null) {
		require_once "Wall/Wall.php";
		return new Wall($wallData);
	}

	/**
	 * @return VideoControl
	 */
	public static function getVideoControl() {
		require_once "Video/VideoControl.php";
		return new VideoControl();
	}

	/**
	 * @return Video
	 */
	static function getVideo($videoData = null) {
		require_once "Gawk/Video/Video.php";
		return new Video($videoData);
	}

	/**
	 * @return VideoFileUpload
	 */
	public static function getVideoFileUpload() {
		require_once "Video/VideoFileUpload.php";
		return new VideoFileUpload();
	}

	/**
	 * @return Facebook
	 */
	static function getFacebookContentSharing() {
		require_once("ContentSharing.php");
		return new FacebookShare();
	}

	/**
	 * @return Twitter
	 */
	static function getTwitterContentSharing() {
		require_once("ContentSharing.php");
		return new Twitter();
	}

	/**
	 * @return Email
	 */
	static function getEmailContentSharing() {
		require_once("ContentSharing.php");
		return new Email();
	}

	/**
	 * @return Digg
	 */
	static function getDiggContentSharing() {
		require_once("ContentSharing.php");
		return new Digg();
	}

	/**
	 * @return Delicious
	 */
	static function getDeliciousContentSharing() {
		require_once("ContentSharing.php");
		return new Delicious();
	}
	/**
	 * @return MemberRatingControl
	 */
	static function getMemberRatingControl() {
		require_once "Member/Rating/MemberRatingControl.php";
		return new MemberRatingControl();
	}

	/**
	 * @return MemberRatingWebService
	 */
	static function getMemberRatingWebService() {
		require_once("Member/Rating/WebService/MemberRatingWebService.php");
		return new MemberRatingWebService();
	}

	/**
	 * @return ErrorLogControl
	 */
	static function getErrorLogControl() {
		require_once "ErrorLog/ErrorLogControl.php";
		return new ErrorLogControl();
	}

	/**
	 * @return CustomMemberControl
	 */
	static function getMemberControl() {
		require_once "Gawk/Member/MemberControl.php";
		return new CustomMemberControl();
	}

	/**
	 * @return Member
	 */
	static function getMember($memberData = null) {
		require_once "Gawk/Member/Member.php";
		return new Member($memberData);
	}

	/**
	 * @return MemberFriendControl
	 */
	static function getMemberFriendControl() {
		require_once("Member/Friend/MemberFriendControl.php");
		return new MemberFriendControl();
	}

	/**
	 * @return MemberFriendWebService
	 */
	static function getMemberFriendWebService() {
		require_once("Member/Friend/WebService/MemberFriendWebService.php");
		return new MemberFriendWebService();
	}

	/**
	 * @return MemberWallBookmarkControl
	 */
	static function getMemberWallBookmarkControl() {
		require_once("Member/WallBookmark/MemberWallBookmarkControl.php");
		return new MemberWallBookmarkControl();
	}

	static function getMemberWallBookmarkWebService() {
		require_once "Member/WallBookmark/WebService/MemberWallBookmarkWebService.php";
		return new MemberWallBookmarkWebService();
	}

	/**
	 * @return MemberWebService
	 */
	static function getMemberWebService() {
		require_once("Member/WebService/MemberWebService.php");
		return new MemberWebService();
	}

	/**
	 * @return WallWebService
	 */
	static function getWallWebService() {
		require_once("Wall/WebService/WallWebService.php");
		return new WallWebService();
	}

	/**
	 * @return VideoWebService
	 */
	static function getVideoWebService() {
		require_once("Video/WebService/VideoWebService.php");
		return new VideoWebService();
	}

	/**
	 * @param Application $application
	 *
	 * @return UserHandler
	 */
	static function getFacebook(Application $application) {
		require_once "Facebook/Facebook.php";
		$facebook = new Facebook(array(
			"appId"  => $application->registry->get("Facebook/AppId"),
			"secret" => $application->registry->get("Facebook/Secret"),
			"cookie" => true
		));

		return $facebook;
	}

	/**
	 * @return MemberAuthentication
	 */
	public static function getMemberAuthentication() {
		require_once "Gawk/Member/MemberAuthentication.php";
		return new MemberAuthentication();
	}

	/**
	 * @return MessageAuthentication
	 */
	public static function getMessageAuthentication() {
		require_once "Gawk/MessageAuthentication/MessageAuthentication.php";
		return new MessageAuthentication();
	}

	/**
	 * @return TokenCheck
	 */
	public static function getTokenCheck() {
		require_once "Gawk/TokenCheck.php";
		return new TokenCheck();
	}

	/**
	 * @return FlashWebService
	 */
	public static function getFlashWebService() {
		require_once "Gawk/Platform/Flash/WebService/FlashWebService.php";
		return new FlashWebService();
	}

}