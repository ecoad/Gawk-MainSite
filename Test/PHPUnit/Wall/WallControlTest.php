<?php
require_once "Wall/Data/WallProvider.php";
require_once "Member/Data/MemberProvider.php";
require_once "Member/Rating/Data/MemberRatingProvider.php";
require_once "Video/Data/VideoProvider.php";

class WallControlTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Member
	 */
	protected $member = null;

	/**
	 * @var WallWebService
	 */
	protected $wallWebService;

	/**
	 * @var array
	 */
	protected $memberSecureIds = array();

	public function setup() {

		$wallWebService = Factory::getWallWebService();

		$this->wallWebService = Factory::getWallWebService();

		$this->member = MemberProvider::getTestMember();
		unset($this->member->facebookId);
		$this->member = MemberProvider::saveMember($this->member);
		$this->memberSecureIds[] = $this->member->secureId;

		if (isset($_SESSION["Token"])) {
			unset($_SESSION["Token"]);
		}

		$_SERVER["REMOTE_ADDR"] = "10.0.0.1";
	}

	public function testGetWallWithRequestUrl() {
		$wall = WallProvider::getTestWall();
		$wall->memberSecureId = $this->member->secureId;

		$apiData = array(
			"Token" => $this->member->token,
			"WallData" => json_encode($wall)
		);

		$apiResponse = $this->wallWebService->handleRequest("Save", $apiData, null);

		if (!$apiResponse->success) {
			var_dump($apiResponse);
		}

		$wall = $apiResponse->wall;

		$this->assertTrue($apiResponse->success);

		$wallControl = Factory::getWallControl();
		$loadedWall = $wallControl->getWallByRequestUrl("/" . $wall->url);

		$this->assertTrue($wall->secureId === $loadedWall->secureId);

		$wallControl = Factory::getWallControl();
		$loadedWall = $wallControl->getWallByRequestUrl("/bad123");

		$this->assertNull($loadedWall);

		$wallControl = Factory::getWallControl();
		$loadedWall = $wallControl->getWallByRequestUrl("/");

		$this->assertTrue($loadedWall->url === $wallControl->getMainWall()->url);
	}

	public function testSavingWallSuccess() {
		$wall = WallProvider::getTestWall();
		$wall->memberSecureId = $this->member->secureId;

		$apiData = array(
			"Token" => $this->member->token,
			"WallData" => json_encode($wall)
		);

		$apiResponse = $this->wallWebService->handleRequest("Save", $apiData, null);

		if (!$apiResponse->success) {
			var_dump($apiResponse);
		}

		$this->assertTrue($apiResponse->success);
	}

	public function testSavingWallNoMemberFailure() {
		$wall = WallProvider::	getTestWall();

		$apiData = array(
			"WallData" => json_encode($wall)
		);

		$apiResponse = $this->wallWebService->handleRequest("Save", $apiData, null);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testSavingWallNoTokenFailure() {
		$wall = WallProvider::getTestWall();
		$wall->memberSecureId = $this->member->secureId;

		$apiData = array(
			"WallData" => json_encode($wall)
		);

		$apiResponse = $this->wallWebService->handleRequest("Save", $apiData, null);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testSavingWallInvalidTokenFailure() {
		$wall = WallProvider::getTestWall();
		$wall->memberSecureId = $this->member->secureId;

		$apiData = array(
			"Token" => "bad-token",
			"WallData" => json_encode($wall)
		);

		$apiResponse = $this->wallWebService->handleRequest("Save", $apiData, null);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testSavingWallInvalidUrlFailure() {
		$wall = WallProvider::getTestWall();
		$wall->memberSecureId = $this->member->secureId;
		$wall->url = WallProvider::$testUrlPrefix . "%";

		$apiData = array(
			"Action" => "Wall.Save",
			"WallData" => json_encode($wall)
		);

		$apiResponse = $this->wallWebService->handleRequest("Save", $apiData, null);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testGetVideosByWall() {
		$wall = WallProvider::saveWall($this->member);

		$video = VideoProvider::getTestVideo();
		$video->wallSecureId = $wall->secureId;
		$video->memberSecureId = $this->member->secureId;

		$application = CoreFactory::getApplication();
		$file = $application->registry->get("Path") . "/Test/PHPUnit/Video/Data/video-success.flv";
		$video->hash = sha1_file($file);
		$type = mime_content_type($file);
		$apiResponse = VideoProvider::sendVideo($video, $application->registry->get("Site/Api"), $file, $type, $this->member);

		$this->assertTrue($apiResponse->success);

		if (!$apiResponse->success) {
		}

		$apiData = array(
			"Token" => $this->member->token,
			"WallSecureId" => $wall->secureId
		);

		$apiResponse = $this->wallWebService->handleRequest(WallWebService::SERVICE_GET_VIDEOS_BY_WALL, null, $apiData);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->videos) == 1);
	}

	public function testMainWallSuccess() {
		$wall = WallProvider::saveWall($this->member);

		$video = VideoProvider::getTestVideo();
		$video->wallSecureId = $wall->secureId;
		$video->memberSecureId = $this->member->secureId;

		$application = CoreFactory::getApplication();
		$file = $application->registry->get("Path") . "/Test/PHPUnit/Video/Data/video-success.flv";
		$video->hash = sha1_file($file);
		$type = mime_content_type($file);
		$apiResponse = VideoProvider::sendVideo($video, $application->registry->get("Site/Api"), $file, $type, $this->member);
		$video = $apiResponse->video;

		$this->assertTrue($apiResponse->success);

		$apiResponse = MemberRatingProvider::saveRating($this->member, $video, true);
		$this->assertTrue($apiResponse->success);

		$apiResponse = $this->wallWebService->handleRequest(WallWebService::SERVICE_GET_VIDEOS_BY_MAIN_WALL, null, null);

		$this->assertTrue($apiResponse->success);
		//$this->assertTrue(count($apiResponse->videos) == 0);

		$memberB = MemberProvider::saveMember(MemberProvider::getTestMember());
		$this->memberSecureIds[] = $memberB->secureId;
		$apiResponse = MemberRatingProvider::saveRating($memberB, $video, true);
		$this->assertTrue($apiResponse->success);

		$apiResponse = $this->wallWebService->handleRequest(WallWebService::SERVICE_GET_VIDEOS_BY_MAIN_WALL, null, null);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->videos) >= 1);
	}

	public function tearDown() {
		MemberProvider::deleteTemporaryMembers();
		MemberProvider::logout($this->member);
		WallProvider::deleteTemporaryWalls();
		VideoProvider::deleteTemporaryVideos($this->memberSecureIds);
	}
}