<?php
require_once "Member/Data/MemberProvider.php";
require_once "Wall/Data/WallProvider.php";
require_once "Video/Data/VideoProvider.php";
require_once "Member/Rating/Data/MemberRatingProvider.php";

class MemberRatingControlTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var MemberRatingWebService
	 */
	protected $memberRatingWebService = null;
	/**
	 * @var Member
	 */
	protected $member;

	/**
	 * @var array
	 */
	protected $memberSecureIds = array();

	/**
	 * @var Wall
	 */
	protected $wall;

	/**
	 * @var Video
	 */
	protected $video;

	protected function setup() {
		$this->memberRatingWebService = Factory::getMemberRatingWebService();
		$application = CoreFactory::getApplication();

		$this->member = MemberProvider::saveMember(MemberProvider::getTestMember());
		$this->memberSecureIds[] = $this->member->secureId;

		$this->wall = WallProvider::saveWall($this->member);

 		$file = $application->registry->get("Path") . "/Test/PHPUnit/Video/Data/video-success.flv";
		$type = mime_content_type($file);

		$this->video = VideoProvider::getTestVideo();
		$this->video->memberSecureId = $this->member->secureId;
		$this->video->wallSecureId = $this->wall->secureId;
		$this->video->hash = sha1_file($file);

		$apiResponse = VideoProvider::sendVideo($this->video, $application->registry->get("Site/Api"), $file, $type, $this->member);
		$this->video = Factory::getVideo($apiResponse->video);

		$this->memberSecureIds[] = $this->member->secureId;

		if (isset($_SESSION["Token"])) {
			unset($_SESSION["Token"]);
		}

		$_SERVER["REMOTE_ADDR"] = "10.0.0.1";
	}

	public function testSaveMemberPositiveRatingSuccess() {
		$apiResponse = MemberRatingProvider::saveRating($this->member, $this->video, true);

		if ($apiResponse->success == false) {
			var_dump($apiResponse); exit;
		}
		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);
	}

	public function testSaveMemberNegativeRatingSuccess() {
		$apiResponse = MemberRatingProvider::saveRating($this->member, $this->video, false);

		if ($apiResponse->success == false) {
			var_dump($apiResponse); exit;
		}
		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);
	}

	public function testSaveMemberRatingNoTokenFailure() {
		$this->member->token = "";
		$apiResponse = MemberRatingProvider::saveRating($this->member, $this->video, true);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testGetMemberRatingSuccess() {
		$apiResponse = MemberRatingProvider::saveRating($this->member, $this->video, true);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);

		$apiResponse = MemberRatingProvider::getRating($this->member, $this->video);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue($apiResponse->positiveRating == true);
	}

	public function testCountVideoRatingSuccess() {
		$apiResponse = MemberRatingProvider::saveRating($this->member, $this->video, true);

		$videoControl = Factory::getVideoControl();
		$video = $videoControl->itemByField($this->video->secureId, "SecureId", false);
		$this->assertTrue($video->get("Rating") == 1);

		$apiResponse = MemberRatingProvider::saveRating($this->member, $this->video, false);

		$video = $videoControl->itemByField($this->video->secureId, "SecureId", "", false, false);
		$this->assertTrue($video->get("Rating") == -1);

		$apiResponse = MemberRatingProvider::saveRating($this->member, $this->video, true);

		$video = $videoControl->itemByField($this->video->secureId, "SecureId", "", false, false);
		$this->assertTrue($video->get("Rating") == 1);

		$apiResponse = MemberRatingProvider::saveRating($this->member, $this->video, true);

		$video = $videoControl->itemByField($this->video->secureId, "SecureId", "", false, false);
		$this->assertTrue($video->get("Rating") == 1);

		$memberB = MemberProvider::saveMember(MemberProvider::getTestMember());

		$apiResponse = MemberRatingProvider::saveRating($memberB, $this->video, false);

		$video = $videoControl->itemByField($this->video->secureId, "SecureId", "", false, false);
		$this->assertTrue($video->get("Rating") == 0);

		$apiResponse = MemberRatingProvider::saveRating($memberB, $this->video, true);

		$video = $videoControl->itemByField($this->video->secureId, "SecureId", "", false, false);
		$this->assertTrue($video->get("Rating") == 2);
	}

	public function tearDown() {
		MemberProvider::deleteTemporaryMembers();
		MemberRatingProvider::deleteTemporaryMemberRatings($this->memberSecureIds);

		WallProvider::deleteTemporaryWalls();
		VideoProvider::deleteTemporaryVideos($this->memberSecureIds);
	}
}