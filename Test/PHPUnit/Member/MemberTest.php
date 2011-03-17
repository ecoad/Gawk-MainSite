<?php
require_once "Member/Data/MemberProvider.php";

class MemberTest extends PHPUnit_Framework_TestCase {

	public function testMapMemberSuccess() {
		$memberData = new stdClass();
		$memberData->firstName = "Colin";
		$memberData->lastName = "Carp";
		$memberData->alias = "Carpy";
		$memberData->emailAddress = "test@test.co.uk";
		$memberData->password = "carping";
		$memberData->facebookId = 11101101;
		$memberData->secureId = "wVf098";
		$memberData->token = "098sd09fsd90fs9d0fsd097sdf807";

		$member = Factory::getMember($memberData);

		$this->assertTrue($member->firstName == $memberData->firstName);
		$this->assertTrue($member->lastName == $memberData->lastName);
		$this->assertTrue($member->alias == $memberData->alias);
		$this->assertTrue($member->emailAddress == $memberData->emailAddress);
		$this->assertTrue($member->password == $memberData->password);
		$this->assertTrue($member->facebookId == $memberData->facebookId);
		$this->assertTrue($member->secureId == $memberData->secureId);
		$this->assertTrue($member->token == $memberData->token);
	}

	public function testMapMemberInvalidPropertyFailure() {
		$memberData = new stdClass();
		$memberData->testProperty = "Fish";

		$member = Factory::getMember($memberData);

		$this->assertFalse(isset($member->testProperty));
	}
}