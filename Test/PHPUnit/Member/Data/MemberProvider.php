<?php
class MemberProvider {

	public static $emailPrefix = "test-site-registered";

	/**
	 * @return Member
	 */
	public static function getTestMember() {
		$member = Factory::getMember();
		$member->emailAddress = self::$emailPrefix . uniqid() . "@gawkwall.com";
		$member->facebookId = rand(1, 100000000);
		$member->password = uniqid("pass-");
		$member->alias = uniqid("alias-");
		$member->firstName = uniqid("first-name");
		$member->lastName = uniqid("last-name");
		return $member;
	}

	/**
	 * @param Member $member
	 * @return Member
	 */
	public static function saveMember(Member $member) {
		$apiData = array(
			"Action" => "Member.RegisterMember",
			"MemberData" => json_encode($member));

		$memberWebService = Factory::getMemberWebService();
		$apiResponse = $memberWebService->handleRequest("RegisterMember", $apiData, null);

		if(!isset($apiResponse->member)) {
			var_dump($response);
		}
		$member = Factory::getMember($apiResponse->member);

		return $member;
	}

	public static function logout(Member $member) {
		$apiData = array(
			"Action" => "Member.Logout",
			"Token" => $member->token);

		$memberWebService = Factory::getMemberWebService();
		$apiResponse = $memberWebService->handleRequest("Logout", $apiData, null);
	}

	public static function deleteTemporaryMembers() {
		$memberControl = Factory::getMemberControl();
		$sql = "DELETE FROM \"Member\" WHERE \"EmailAddress\" LIKE 'test-site-registered-%';";
		$memberControl->runQuery($sql);
	}
}