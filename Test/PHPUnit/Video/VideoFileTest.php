<?php
require_once "Video/Data/VideoProvider.php";
require_once "Member/Data/MemberProvider.php";
require_once "Wall/Data/WallProvider.php";

class VideoFileTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var Application
	 */
	protected $application;

	public function setup() {
		$this->application = CoreFactory::getApplication();
	}

	public function testMoveFileFromTmpToBinarySuccess() {
		$fileFrom = "/tmp/testfile";

		echo shell_exec("touch $fileFrom");
		$fileLocation = $this->application->registry->get("Binary/Path") . "/" .	"test-file-" . uniqid();
		shell_exec("mv $fileFrom $fileLocation");

		$this->assertTrue(file_exists($fileLocation));
	}

	public function tearDown() {
	}
}
