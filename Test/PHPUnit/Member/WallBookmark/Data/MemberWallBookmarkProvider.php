<?php
class MemberWallBookmarkProvider {

	public function getWallBookmarks(Member $member) {
		$getData = array(
			"Token" => $member->token
		);

		$memberWallBookmarkWebService = Factory::getMemberWallBookmarkWebService();
		$apiResponse = $memberWallBookmarkWebService->handleRequest(
			MemberWallBookmarkWebService::SERVICE_GET_WALL_BOOKMARKS, null, $getData);

		return $apiResponse;
	}

	public function isBookmarked(Member $member, Wall $wall) {
		$getData = array(
			"Token" => $member->token,
			"WallSecureId" => $wall->secureId
		);

		$memberWallBookmarkWebService = Factory::getMemberWallBookmarkWebService();
		$apiResponse = $memberWallBookmarkWebService->handleRequest(
			MemberWallBookmarkWebService::SERVICE_IS_BOOKMARKED, null, $getData);

		return $apiResponse;
	}

	public static function saveWallBookmark(Member $member, Wall $wall) {
		$postData = array(
			"Token" => $member->token,
			"WallSecureId" => $wall->secureId
		);
		$memberWallBookmarkWebService = Factory::getMemberWallBookmarkWebService();
		$apiResponse = $memberWallBookmarkWebService->handleRequest(
			MemberWallBookmarkWebService::SERVICE_ADD_WALL_BOOKMARK, $postData, null);

		return $apiResponse;
	}

	public static function removeWallBookmark(Member $member, Wall $wall) {
		$postData = array(
			"Token" => $member->token,
			"WallSecureId" => $wall->secureId
		);

		$memberWallBookmarkWebService = Factory::getMemberWallBookmarkWebService();
		$apiResponse = $memberWallBookmarkWebService->handleRequest(
			MemberWallBookmarkWebService::SERVICE_REMOVE_WALL_BOOKMARK, $postData, null);
		return $apiResponse;
	}

	public static function deleteTemporaryMemberWallBookmarks(array $members) {
		$memberWallBookmarkControl = Factory::getMemberWallBookmarkControl();
		foreach ($members as $memberSecureId) {
			$sql = "DELETE FROM \"MemberWallBookmark\" WHERE \"MemberSecureId\" = '$memberSecureId';";
			$memberWallBookmarkControl->runQuery($sql);
		}
	}
}