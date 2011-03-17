<?php
//require_once "PHPUnit/Framework.php";
require_once "Member/Friend/MemberFriendControlTest.php";

/**
 * Suite containing all the tests for the Member package
 */
class MemberFriendTestSuite extends PHPUnit_Framework_TestSuite {

	public static function suite() {
		$suite = new MemberTestSuite();
		$suite->addTestSuite("MemberFriendControlTest");
		return $suite;
	}
}