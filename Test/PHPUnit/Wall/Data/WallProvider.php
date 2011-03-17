<?php
class WallProvider {

	public static $testUrlPrefix = "testwall";
	/**
	 * @return Wall
	 */
	public static function getTestWall() {
		$wall = Factory::getWall();
		$wall->url = uniqid(self::$testUrlPrefix);
		$wall->publicGawk = true;
		$wall->publicView = true;
		return $wall;
	}

	public static function saveWall(Member $member) {
		$wall = WallProvider::getTestWall();
		$wall->memberSecureId = $member->secureId;
		$wall->secureId = uniqid(self::$testUrlPrefix);

		$apiData = array(
			"Token" => $member->token,
			"WallData" => json_encode($wall)
		);

		$wallWebService = Factory::getWallWebService();
		$apiResponse = $wallWebService->handleRequest("Save", $apiData, null);

		if (!$apiResponse->success) {
			var_dump($apiResponse);
		}
		$wall = Factory::getWall($apiResponse->wall);

		return $wall;
	}

	public static function deleteTemporaryWalls() {
		$wallControl = Factory::getWallControl();
		$sql = "DELETE FROM \"Wall\" WHERE \"Url\" LIKE '" . self::$testUrlPrefix . "%';";
		$wallControl->runQuery($sql);
	}
}