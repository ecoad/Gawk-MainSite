<?php
require_once "Member/Data/MemberProvider.php";
require_once "Member/Friend/Data/MemberFriendProvider.php";

class MemberFriendControlTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var MemberFriendWebService
	 */
	protected $memberFriendWebService = null;
	/**
	 * @var Member
	 */
	protected $memberA;
	/**
	 * @var Member
	 */
	protected $memberB;

	/**
	 * @var array
	 */
	protected $memberSecureIds = array();

	protected function setup() {
		$this->memberFriendWebService = Factory::getMemberFriendWebService();

		$this->memberA = MemberProvider::saveMember(MemberProvider::getTestMember());
		$this->memberB = MemberProvider::saveMember(MemberProvider::getTestMember());
		$this->memberSecureIds[] = $this->memberA->secureId;
		$this->memberSecureIds[] = $this->memberB->secureId;

		if (isset($_SESSION["Token"])) {
			unset($_SESSION["Token"]);
		}
	}

	public function testGetMemberFriendsSuccess() {
		$apiResponse = MemberFriendProvider::saveMemberFriend($this->memberA, $this->memberB);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);

		$apiResponse = MemberFriendProvider::getFriends($this->memberA);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->memberFriends) == 1);
	}

	public function testAddFriendSuccess() {
		$apiResponse = MemberFriendProvider::saveMemberFriend($this->memberA, $this->memberB);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);
	}

	public function testAddFriendInvalidFriendSecureIdFailure() {
		$this->memberB->secureId = "invalid-secure-id";
		$apiResponse = MemberFriendProvider::saveMemberFriend($this->memberA, $this->memberB);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testRemoveFriendWhenNoFriendExistsFailure() {
		$apiResponse = MemberFriendProvider::removeMemberFriend($this->memberA, $this->memberB);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testRemoveFriendSuccess() {
		$apiResponse = MemberFriendProvider::saveMemberFriend($this->memberA, $this->memberB);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);

		$apiResponse = MemberFriendProvider::removeMemberFriend($this->memberA, $this->memberB);
		$this->assertTrue($apiResponse->success);

		$apiResponse = MemberFriendProvider::removeMemberFriend($this->memberA, $this->memberB);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testAddFriendAlreadyInDatabaseFailure() {
		$apiResponse = MemberFriendProvider::saveMemberFriend($this->memberA, $this->memberB);
		$this->assertTrue($apiResponse->success);

		$apiResponse = MemberFriendProvider::saveMemberFriend($this->memberA, $this->memberB);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testMemberHasFriendSuccess() {
		$apiResponse = MemberFriendProvider::saveMemberFriend($this->memberA, $this->memberB);
		$this->assertTrue($apiResponse->success);

		$apiResponse = MemberFriendProvider::isFriend($this->memberA, $this->memberB->secureId);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);
	}

	public function testMemberHasFriendFailure() {
		$apiResponse = MemberFriendProvider::isFriend($this->memberA, $this->memberB->secureId);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 0);
	}

	public function tearDown() {
		MemberProvider::deleteTemporaryMembers();
		MemberFriendProvider::deleteTemporaryMemberFriends($this->memberSecureIds);
	}
}