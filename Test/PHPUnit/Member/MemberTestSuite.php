<?php
//require_once "PHPUnit/Framework.php";
require_once "Member/MemberAuthenticationTest.php";
require_once "Member/MemberControlTest.php";

/**
 * Suite containing all the tests for the Member package
 */
class MemberTestSuite extends PHPUnit_Framework_TestSuite {

	public static function suite() {
		$suite = new MemberTestSuite();
		$suite->addTestSuite("MemberAuthenticationTest");
		$suite->addTestSuite("MemberControlTest");
		return $suite;
	}
}