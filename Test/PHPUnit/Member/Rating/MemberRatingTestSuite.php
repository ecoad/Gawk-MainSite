<?php
require_once "Member/Rating/MemberRatingControlTest.php";

/**
 * Suite containing all the tests for the Member package
 */
class MemberRatingTestSuite extends PHPUnit_Framework_TestSuite {
	public static function suite() {
		$suite = new MemberRatingTestSuite();
		$suite->addTestSuite("MemberRatingControlTest");
		return $suite;
	}
}