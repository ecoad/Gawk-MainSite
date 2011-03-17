<?php
//require_once "PHPUnit/Framework.php";
require_once "Wall/WallControlTest.php";

/**
 * Suite containing all the tests for the Wall package
 */
class WallTestSuite extends PHPUnit_Framework_TestSuite {

	public static function suite() {
		$suite = new WallTestSuite();
		$suite->addTestSuite("WallControlTest");
		return $suite;
	}
}