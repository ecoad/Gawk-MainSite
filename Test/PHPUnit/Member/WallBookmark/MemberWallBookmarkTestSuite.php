<?php
require_once "Member/WallBookmark/MemberWallBookmarkControlTest.php";

/**
 * Suite containing all the tests for the Member package
 */
class MemberWallBookmarkTestSuite extends PHPUnit_Framework_TestSuite {
	public static function suite() {
		$suite = new MemberWallBookmarkTestSuite();
		$suite->addTestSuite("MemberWallBookmarkControlTest");
		return $suite;
	}
}