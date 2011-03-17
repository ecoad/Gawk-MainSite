<?php
require_once "Video/Data/VideoProvider.php";
require_once "Member/Data/MemberProvider.php";
require_once "Wall/Data/WallProvider.php";

class FlashTest extends PHPUnit_Framework_TestCase {

	protected $apiLocation;
	/**
	 * @var Member
	 */
	protected $member = null;

	/**
	 * @var Wall
	 */
	protected $wall;

	/**
	 * @var Video
	 */
	protected $video;
	/**
	 * @var Application
	 */
	protected $application;

	public function setup() {
		$this->member = MemberProvider::getTestMember();
		$originalPassword = $this->member->password;
		unset($this->member->facebookId);
		$this->member = MemberProvider::saveMember($this->member);
		$this->memberSecureIds[] = $this->member->secureId;

		$this->wall = WallProvider::saveWall($this->member);

		$this->video = VideoProvider::getTestVideo();
		$this->video->memberSecureId = $this->member->secureId;
		$this->video->wallSecureId = $this->wall->secureId;

		$application = CoreFactory::getApplication();
		$file = $application->registry->get("Path") . "/Test/PHPUnit/Video/Data/video-success.flv";
		$type = mime_content_type($file);
		VideoProvider::sendVideo($this->video, $application->registry->get("Site/Api"), $file, $type, $this->member);

		if (isset($_SESSION["Token"])) {
			unset($_SESSION["Token"]);
		}
	}

	public function testGetMainWallSuccess() {
		$flashWebService = Factory::getFlashWebService();
		$response = $flashWebService->handleRequest("GetWallConfig", null, null);

		$this->assertTrue($response->success);

		//binaryLocation
		$this->assertTrue(count($response->wall->videos) == 1);
		$this->assertTrue($response->binaryLocation == ($this->application->registry->get("Site/Address") . "resource/binary/"));
		$this->assertTrue($response->mediaServerLocation == $this->application->registry->get("MediaServer/Address"));
		$this->assertTrue($this->video->filename = $response->wall->videos[0]->filename);
		$this->assertTrue($this->video->memberSecureId = $response->wall->videos[0]->memberSecureId);
	}

	public function tearDown() {
		MemberProvider::deleteTemporaryMembers();
		WallProvider::deleteTemporaryWalls();
		VideoProvider::deleteTemporaryVideos($this->memberSecureIds);
	}
}