<?php
require_once "Video/Data/VideoProvider.php";
require_once "Member/Data/MemberProvider.php";
require_once "Wall/Data/WallProvider.php";

class VideoControlTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var HttpRequest
	 */
	protected $httpRequest = null;
	protected $apiLocation;
	/**
	 * @var Member
	 */
	protected $member = null;

	/**
	 * @var array()
	 */
	protected $memberSecureIds = array();

	/**
	 * @var Wall
	 */
	protected $wall;
	/**
	 * @var Application
	 */
	protected $application;

	public function setup() {
		$this->application = CoreFactory::getApplication();
		$this->apiLocation = $this->application->registry->get("Site/Api");
		$this->httpRequest = CoreFactory::getHttpRequest();
		$this->httpRequest->setUrl($this->apiLocation);

		$this->member = MemberProvider::getTestMember();
		$originalPassword = $this->member->password;
		unset($this->member->facebookId);
		$this->member = MemberProvider::saveMember($this->member);
		$this->memberSecureIds[] = $this->member->secureId;
		$this->member->originalPassword = $originalPassword;

		$this->wall = WallProvider::saveWall($this->member);

		if (isset($_SESSION["Token"])) {
			unset($_SESSION["Token"]);
		}
	}

	public function testSavingFlvVideoSuccess() {
 		$file = $this->application->registry->get("Path") . "/Test/PHPUnit/Video/Data/video-success.flv";
		$type = mime_content_type($file);

		$video = VideoProvider::getTestVideo();
		$video->memberSecureId = $this->member->secureId;
		$video->wallSecureId = $this->wall->secureId;
		$video->hash = sha1_file($file);

		$apiResponse = VideoProvider::sendVideo($video, $this->apiLocation, $file, $type, $this->member);

		if (!$apiResponse->success) {
			var_dump($apiResponse);
		}
		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);

		$memberControl = Factory::getMemberControl();
		$memberDataEntity = $memberControl->getMemberDataEntityBySecureId($video->memberSecureId);
		if ($memberDataEntity) {
			$apiResponse->video->member = $memberDataEntity->toObject();
		}

		$video = Factory::getVideo($apiResponse->video);
		$this->assertTrue($video->member->secureId == $this->member->secureId);
	}

	public function testSavingFlvVideoInvalidWallSecureIdFailure() {
 		$file = $this->application->registry->get("Path") . "/Test/PHPUnit/Video/Data/video-success.flv";
		$type = mime_content_type($file);

		$video = VideoProvider::getTestVideo();
		$video->memberSecureId = $this->member->secureId;
		$video->wallSecureId = "bad-wall-id";
		$video->hash = sha1_file($file);

		$apiResponse = VideoProvider::sendVideo($video, $this->apiLocation, $file, $type, $this->member);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testSavingFlvVideoInvalidMimeTypeFailure() {
 		$file = $this->application->registry->get("Path") . "/Test/PHPUnit/Video/Data/video-success.flv";
		$type = mime_content_type($file);

		$video = VideoProvider::getTestVideo();
		$video->memberSecureId = $this->member->secureId;
		$video->wallSecureId = $this->wall->secureId;
		$video->hash = sha1_file($file);

		$apiResponse = VideoProvider::sendVideo($video, $this->apiLocation, $file, "unknown-type", $this->member);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testSavingIphoneVideoSuccess() {
 		$file = $this->application->registry->get("Path") . "/Test/PHPUnit/Video/Data/iphone-success.MOV";
		$type = mime_content_type($file);

		$videoControl = Factory::getVideoControl();
		$video = VideoProvider::getTestVideo();
		$video->uploadSource = VideoControl::SOURCE_IPHONE;
		$video->memberSecureId = $this->member->secureId;
		$video->wallSecureId = $this->wall->secureId;
		$video->hash = sha1_file($file);

		$apiResponse = VideoProvider::sendVideo($video, $this->apiLocation, $file, $type, $this->member);
		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);

		$video = $apiResponse->video;

		$fileFullPath = $this->application->registry->get("Binary/Path") . "/" . $video->filename;
		$this->assertTrue(file_exists($fileFullPath));
		$this->assertTrue(substr($video->filename, strripos($video->filename, "."), 4) == ".mp4");
	}
	public function tearDown() {
		MemberProvider::deleteTemporaryMembers();
		VideoProvider::deleteTemporaryVideos($this->memberSecureIds);
	}
}