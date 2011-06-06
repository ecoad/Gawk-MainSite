<?php
require_once "Member/Data/MemberProvider.php";

class MemberControlTest extends PHPUnit_Framework_TestCase {

	protected $apiLocation;
	protected $memberDataFacebookSuccess = null;
	protected $memberDataSiteRegisteredSuccess = null;

	protected function setup() {
		$this->memberDataFacebookSuccess = MemberProvider::getTestMember();
		$this->memberDataFacebookSuccess->password = "";

		$this->memberDataSiteRegisteredSuccess = MemberProvider::getTestMember();
		unset($this->memberDataSiteRegisteredSuccess->facebookId);

		if (isset($_SESSION["Token"])) {
			unset($_SESSION["Token"]);
		}
	}

	public function testRegisterFacebookUserSuccess() {
		unset($this->memberDataFacebookSuccess->password);

		$apiData = array(
			"Action" => "Member.RegisterMember",
			"MemberData" => json_encode($this->memberDataFacebookSuccess));

		$memberWebService = Factory::getMemberWebService();
		$apiResponse = $memberWebService->handleRequest("RegisterMember", $apiData, null);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue($apiResponse->member->firstName == $this->memberDataFacebookSuccess->firstName);
		$this->assertTrue($apiResponse->member->emailAddress == $this->memberDataFacebookSuccess->emailAddress);
		$this->assertTrue($apiResponse->member->alias == $this->memberDataFacebookSuccess->alias);
		$this->assertTrue($apiResponse->member->facebookId == $this->memberDataFacebookSuccess->facebookId);
		$this->assertTrue(count($apiResponse->errors) == 0);

		$memberControl = Factory::getMemberControl();
		$memberControl->deleteWhere("EmailAddress", $this->memberDataFacebookSuccess->emailAddress);
	}

	public function testRegisterFacebookUserFailure() {
		$this->memberDataFacebookFailure = $this->memberDataFacebookSuccess;
		$this->memberDataFacebookFailure->alias = "";
		unset($this->memberDataFacebookFailure->password);
		$apiData = array(
			"Action" => "Member.RegisterMember",
			"MemberData" => json_encode($this->memberDataFacebookFailure));

		$memberWebService = Factory::getMemberWebService();
		$apiResponse = $memberWebService->handleRequest("RegisterMember", $apiData, null);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testRegisterSiteRegisteredSuccess() {
		$this->memberDataSiteRegisteredSuccess->confirmPassword = $this->memberDataSiteRegisteredSuccess->password;
		$apiData = array(
			"Action" => "Member.RegisterMember",
			"MemberData" => json_encode($this->memberDataSiteRegisteredSuccess));

		$memberWebService = Factory::getMemberWebService();
		$apiResponse = $memberWebService->handleRequest("RegisterMember", $apiData, null);
		var_dump($apiResponse); exit;

		$this->assertTrue($apiResponse->success);
		$this->assertTrue($apiResponse->member->firstName == $this->memberDataSiteRegisteredSuccess->firstName);
		$this->assertTrue($apiResponse->member->emailAddress == $this->memberDataSiteRegisteredSuccess->emailAddress);
		$this->assertTrue($apiResponse->member->alias == $this->memberDataSiteRegisteredSuccess->alias);
		$this->assertTrue(count($apiResponse->errors) == 0);
	}

	public function testRegisterSiteRegisteredBasicDataSuccess() {

		$member = new stdClass();
		$member->alias = uniqid();
		$member->emailAddress = MemberProvider::$emailPrefix . uniqid() . "@gawkwall.com";
		$member->password = "timbosdf9";

		$apiData = array(
			"Action" => "Member.RegisterMember",
			"MemberData" => json_encode($member));

		$memberWebService = Factory::getMemberWebService();
		$apiResponse = $memberWebService->handleRequest("RegisterMember", $apiData, null);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue($apiResponse->member->emailAddress == $member->emailAddress);
		$this->assertTrue($apiResponse->member->alias == $member->alias);
		$this->assertTrue(count($apiResponse->errors) == 0);

		$memberControl = Factory::getMemberControl();
		$memberControl->deleteWhere("EmailAddress", $this->memberDataFacebookSuccess->emailAddress);
	}

	public function testRegisterSiteRegisteredFailure() {
		$this->memberDataSiteRegisteredSuccess->alias = "";
		$apiData = array(
			"Action" => "Member.RegisterMember",
			"MemberData" => json_encode($this->memberDataSiteRegisteredSuccess));

		$memberWebService = Factory::getMemberWebService();
		$apiResponse = $memberWebService->handleRequest("RegisterMember", $apiData, null);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);

		$memberControl = Factory::getMemberControl();
		$memberControl->deleteWhere("EmailAddress", $this->memberDataFacebookSuccess->emailAddress);
	}

	public function tearDown() {
		MemberProvider::deleteTemporaryMembers();
	}
}