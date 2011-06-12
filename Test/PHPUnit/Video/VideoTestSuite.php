<?php
//require_once "PHPUnit/Framework.php";
require_once "Video/VideoControlTest.php";
require_once "Video/VideoFileTest.php";

/**
 * Suite containing all the tests for the Video package
 */
class VideoTestSuite extends PHPUnit_Framework_TestSuite {

	public static function suite() {
		$suite = new VideoTestSuite();
		$suite->addTestSuite("VideoControlTest");
		$suite->addTestSuite("VideoFileTest");
		return $suite;
	}
}