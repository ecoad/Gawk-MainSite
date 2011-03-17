<?php
require_once "Member/Data/MemberProvider.php";
require_once "Wall/Data/WallProvider.php";
require_once "Member/WallBookmark/Data/MemberWallBookmarkProvider.php";

class MemberWallBookmarkControlTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var MemberWallBookmarkWebService
	 */
	protected $memberWallBookmarkWebService = null;
	/**
	 * @var Member
	 */
	protected $member;

	/**
	 * @var Wall
	 */
	protected $wall;

	/**
	 * @var array
	 */
	protected $memberSecureIds = array();

	protected function setup() {
		$this->memberWallBookmarkWebService = Factory::getMemberWallBookmarkWebService();

		$this->member = MemberProvider::saveMember(MemberProvider::getTestMember());
		$this->wall = WallProvider::saveWall($this->member);
		$this->memberSecureIds[] = $this->member->secureId;

		if (isset($_SESSION["Token"])) {
			unset($_SESSION["Token"]);
		}
	}

	public function testSaveBookmarkSuccess() {
		$apiResponse = MemberWallBookmarkProvider::saveWallBookmark($this->member, $this->wall);

		if ($apiResponse->success == false) {
			var_dump($apiResponse); exit;
		}
		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);
	}

	public function testGetMemberWallBookmarksSuccess() {
		$apiResponse = MemberWallBookmarkProvider::saveWallBookmark($this->member, $this->wall);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);

		$apiResponse = MemberWallBookmarkProvider::getWallBookmarks($this->member);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->walls) == 1);
	}

	public function testSaveBookmarkInvalidWallSecureIdFailure() {
		$this->wall->secureId = "invalid-secure-id";
		$apiResponse = MemberWallBookmarkProvider::saveWallBookmark($this->member, $this->wall);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testRemoveWallBookmarkSuccess() {
		$apiResponse = MemberWallBookmarkProvider::saveWallBookmark($this->member, $this->wall);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);

		$apiResponse = MemberWallBookmarkProvider::removeWallBookmark($this->member, $this->wall);
		$this->assertTrue($apiResponse->success);

		$apiResponse = MemberWallBookmarkProvider::removeWallBookmark($this->member, $this->wall);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testRemoveWallBookmarkWhenNoWallBookmarkExistsFailure() {
		$apiResponse = MemberWallBookmarkProvider::removeWallBookmark($this->member, $this->wall);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testAddWallBookmarkAlreadyInDatabaseFailure() {
		$apiResponse = MemberWallBookmarkProvider::saveWallBookmark($this->member, $this->wall);
		$this->assertTrue($apiResponse->success);

		$apiResponse = MemberWallBookmarkProvider::saveWallBookmark($this->member, $this->wall);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testMemberHasWallBookmarkSuccess() {
		$apiResponse = MemberWallBookmarkProvider::saveWallBookmark($this->member, $this->wall);
		$this->assertTrue($apiResponse->success);

		$apiResponse = MemberWallBookmarkProvider::isBookmarked($this->member, $this->wall);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);
	}

	public function testMemberHasWallBookmarkFailure() {
		$apiResponse = MemberWallBookmarkProvider::isBookmarked($this->member, $this->wall);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);
	}

	public function tearDown() {
		MemberProvider::deleteTemporaryMembers();
		MemberWallBookmarkProvider::deleteTemporaryMemberWallBookmarks($this->memberSecureIds);

		WallProvider::deleteTemporaryWalls();
	}
}