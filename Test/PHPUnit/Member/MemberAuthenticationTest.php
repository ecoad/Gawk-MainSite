<?php
require_once "Member/Data/MemberProvider.php";

class MemberAuthenticationTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var MemberWebService
	 */
	protected $memberWebService = null;
	/**
	 * @var Member
	 */
	protected $testFacebookRegisteredMember = null;
	/**
	 * @var Member
	 */
	protected $testSiteRegisteredMember = null;
	/**
	 * @var Member
	 */
	protected $memberDataFacebookSuccess = null;
	/**
	 * @var Member
	 */
	protected $memberDataSiteRegisteredSuccess = null;
	protected $publicKey = "787a4aa2778d73f6f2da1598e13668753b5a8010";
	protected $privateKey = "d20533231c09074a07de1cc9f593c1765bdcf146f7efee55abe61e66a2cda80b";

	protected function setup() {
		$this->memberWebService = Factory::getMemberWebService();

		$this->memberDataFacebookSuccess = MemberProvider::getTestMember();
		$this->memberDataFacebookSuccess->password = "";

		$this->memberDataSiteRegisteredSuccess = MemberProvider::getTestMember();

		$this->testSiteRegisteredMember = MemberProvider::getTestMember();
		$originalPassword = $this->testSiteRegisteredMember->password;
		unset($this->testSiteRegisteredMember->facebookId);
		$this->testSiteRegisteredMember = MemberProvider::saveMember($this->testSiteRegisteredMember);
		$this->testSiteRegisteredMember->originalPassword = $originalPassword;

		$this->testFacebookRegisteredMember = MemberProvider::getTestMember();
		unset($this->testFacebookRegisteredMember->password);
		$this->testFacebookRegisteredMember = MemberProvider::saveMember($this->testFacebookRegisteredMember);

		if (isset($_SESSION["Token"])) {
			unset($_SESSION["Token"]);
		}
	}

	public function testLoginSiteRegisteredMemberSuccess() {
		$loginData = array(
			"Action" => "Member.Login",
			"EmailAddress" => $this->testSiteRegisteredMember->emailAddress,
			"Password" => $this->testSiteRegisteredMember->originalPassword);

		$apiResponse = $this->memberWebService->handleRequest("Login", $loginData, null);
		$this->assertTrue($apiResponse->success);
		$this->assertTrue($apiResponse->member->alias == $this->testSiteRegisteredMember->alias);
		$this->assertTrue($apiResponse->member->token != "");

		$apiData = array(
			"Action" => "Member.GetLoggedInMember",
			"Token" => $apiResponse->member->token);

		$apiResponse = $this->memberWebService->handleRequest("GetLoggedInMember", $apiData, null);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue($apiResponse->member->alias == $this->testSiteRegisteredMember->alias);
	}

	public function testLoginSiteRegisteredMemberFailure() {
		$loginData = array(
			"Action" => "Member.Login",
			"EmailAddress" => "false@clock.co.uk",
			"Password" => $this->testSiteRegisteredMember->password);

		$apiResponse = $this->memberWebService->handleRequest("Login", $loginData, null);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);

		$loginData = array(
			"Action" => "Member.Login",
			"EmailAddress" => $this->testSiteRegisteredMember->emailAddress,
			"Password" => "falsefalse");

		$apiResponse = $this->memberWebService->handleRequest("Login", $loginData, null);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) == 1);
	}

	public function testLoginFacebookRegisteredMemberSuccess() {
		$loginData = array(
			"Action" => "Member.Login",
			"FacebookId" => $this->testFacebookRegisteredMember->facebookId,
			"PublicKey" => $this->publicKey,
			"Signature" => hash("sha256", $this->testFacebookRegisteredMember->facebookId . $this->privateKey));

		$apiResponse = $this->memberWebService->handleRequest("Login", $loginData, null);

		$this->assertTrue($apiResponse->success);
		$this->assertTrue($apiResponse->member->alias == $this->testFacebookRegisteredMember->alias);
	}

	public function testLoginFacebookRegisteredMemberFailure() {
		$loginData = array(
			"Action" => "Member.Login",
			"FacebookId" => 123);

		$apiResponse = $this->memberWebService->handleRequest("Login", $loginData, null);

		$this->assertFalse($apiResponse->success);
		$this->assertTrue(count($apiResponse->errors) > 0);
	}

	public function testLogoutFailure() {
		$token = "bad-token";

		//Logout
		$apiData = array("Token" => $token);
		$apiResponse = $this->memberWebService->handleRequest("Logout", $apiData, null);
		$this->assertFalse($apiResponse->success);
	}

	public function testLogoutLoginFirstThenLogoutSuccess() {
		//Login
		$loginData = array("EmailAddress" => $this->testSiteRegisteredMember->emailAddress,
			"Password" => $this->testSiteRegisteredMember->originalPassword);

		$apiResponse = $this->memberWebService->handleRequest("Login", $loginData, null);
		$this->assertTrue($apiResponse->success);
		$this->assertTrue($apiResponse->member->alias == $this->testSiteRegisteredMember->alias);
		$token = $apiResponse->member->token;
		$this->assertTrue($token != "");

		//Logout
		$apiData = array("Token" => $token);
		$apiResponse = $this->memberWebService->handleRequest("Logout", $apiData, null);

		$this->assertTrue($apiResponse->success);

		//Get logged in member
		$apiData = array("Token" => $token);
		$apiResponse = $this->memberWebService->handleRequest("GetLoggedInMember", $apiData, null);
		$this->assertFalse($apiResponse->success);

		//Logout
		$apiData = array("Token" => $token);
		$apiResponse = $this->memberWebService->handleRequest("Logout", $apiData, null);
		$this->assertFalse($apiResponse->success);
	}

	public function tearDown() {
		MemberProvider::deleteTemporaryMembers();
		MemberProvider::logout($this->memberDataFacebookSuccess);
		MemberProvider::logout($this->memberDataSiteRegisteredSuccess);
	}
}