<?php
class MemberFriendProvider {

	public function getFriends(Member $member) {
		$getData = array(
			"Action" => "MemberFriend.GetFriends",
			"Token" => $member->token
		);

		$memberFriendWebService = Factory::getMemberFriendWebService();
		$apiResponse = $memberFriendWebService->handleRequest("GetFriends", null, $getData);

		return $apiResponse;
	}

	public function isFriend(Member $member, $friendSecureId) {
		$getData = array(
			"Action" => "MemberFriend.IsFriend",
			"Token" => $member->token,
			"FriendSecureId" => $friendSecureId
		);

		$memberFriendWebService = Factory::getMemberFriendWebService();
		$apiResponse = $memberFriendWebService->handleRequest("IsFriend", null, $getData);

		return $apiResponse;
	}

	public static function saveMemberFriend(Member $memberA, Member $memberB) {
		$postData = array(
			"Action" => "MemberFriend.AddFriend",
			"Token" => $memberA->token,
			"FriendSecureId" => $memberB->secureId
		);
		$memberFriendWebService = Factory::getMemberFriendWebService();
		$apiResponse = $memberFriendWebService->handleRequest("AddFriend", $postData, null);

		return $apiResponse;
	}

	public static function removeMemberFriend(Member $memberA, Member $memberB) {
		$postData = array(
			"Action" => "MemberFriend.RemoveFriend",
			"Token" => $memberA->token,
			"FriendSecureId" => $memberB->secureId
		);

		$memberFriendWebService = Factory::getMemberFriendWebService();
		$apiResponse = $memberFriendWebService->handleRequest("RemoveFriend", $postData, null);
		return $apiResponse;
	}

	public static function deleteTemporaryMemberFriends(array $members) {
		$memberFriendControl = Factory::getMemberFriendControl();
		foreach ($members as $memberSecureId) {
			$sql = "DELETE FROM \"MemberFriend\" WHERE \"MemberSecureId\" = '$memberSecureId';";
			$memberFriendControl->runQuery($sql);
		}
	}
}