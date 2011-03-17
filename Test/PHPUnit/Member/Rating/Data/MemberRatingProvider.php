<?php
class MemberRatingProvider {

	public function getRating(Member $member, Video $video) {
		$getData = array(
			"Token" => $member->token,
			"VideoSecureId" => $video->secureId
		);

		$memberRatingWebService = Factory::getMemberRatingWebService();
		$apiResponse = $memberRatingWebService->handleRequest(
			MemberRatingWebService::SERVICE_GET_RATING, null, $getData);

		return $apiResponse;
	}

	public static function saveRating(Member $member, $video, $positiveRating) {
		$postData = array(
			"Token" => $member->token,
			"VideoSecureId" => $video->secureId,
			"PositiveRating" => $positiveRating
		);
		$memberRatingWebService = Factory::getMemberRatingWebService();
		$apiResponse = $memberRatingWebService->handleRequest(
			MemberRatingWebService::SERVICE_ADD_RATING, $postData, null);

		return $apiResponse;
	}

	public static function deleteTemporaryMemberRatings(array $members) {
		$memberRatingControl = Factory::getMemberRatingControl();
		foreach ($members as $memberSecureId) {
			$sql = "DELETE FROM \"{$memberRatingControl->table}\" WHERE \"MemberSecureId\" = '$memberSecureId';";
			$memberRatingControl->runQuery($sql);
		}
	}
}