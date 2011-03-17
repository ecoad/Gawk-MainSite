<?php
//require_once "PHPUnit/Framework.php";
require_once "Member/MemberTestSuite.php";
require_once "Member/Friend/MemberFriendTestSuite.php";
require_once "Member/WallBookmark/MemberWallBookmarkTestSuite.php";
require_once "Member/Rating/MemberRatingTestSuite.php";
require_once "Video/VideoTestSuite.php";
require_once "Wall/WallTestSuite.php";
require_once "Platform/Flash/FlashTest.php";

/**
 * Suite containing all the tests for the Video package
 */
class GawkTestSuite extends PHPUnit_Framework_TestSuite {

	public static function suite() {
		$suite = new GawkTestSuite();
		$suite->addTestSuite("MemberTestSuite");
		$suite->addTestSuite("MemberFriendTestSuite");
		$suite->addTestSuite("WallTestSuite");
		$suite->addTestSuite("VideoTestSuite");
		$suite->addTestSuite("MemberWallBookmarkTestSuite");
		$suite->addTestSuite("MemberRatingTestSuite");
		//$suite->addTestSuite("FlashTest");
		return $suite;
	}
}