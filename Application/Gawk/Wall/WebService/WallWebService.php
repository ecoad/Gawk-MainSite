<?php
class WallWebService {

	/**
	 * @var Application
	 */
	protected $application = null;

	const SERVICE_NAME_SPACE = "Wall";
	const SERVICE_GET_VIDEOS_BY_WALL = "GetWallVideos";
	const SERVICE_GET_VIDEOS_BY_MAIN_WALL = "GetMainWallVideos";
	const SERVICE_SAVE = "Save";

	public function __construct() {
		$this->application = CoreFactory::getApplication();
	}

	public function handleRequest($method, array $postData = null, array $getData = null) {
		$response = new stdClass();
		$response->success = false;
		$response->errors = array();

		$getData["Token"] = $this->application->defaultValue($getData["Token"], null);
		$postData["Token"] = $this->application->defaultValue($postData["Token"], null);
		if ($getData["Token"]) {
			$postData["Token"] = $getData["Token"];
		}

		switch ($method) {
			/*
			 *
			 * SEE Platform/Flash/Webservice/FlashWebService.php
			 *
			case self::SERVICE_GET_VIDEOS_BY_MAIN_WALL:
			case self::SERVICE_GET_VIDEOS_BY_WALL:
				$wallControl = Factory::getWallControl();
				if ($method == self::SERVICE_GET_VIDEOS_BY_MAIN_WALL) {
					$videos = $wallControl->getVideosByMainWall();
				} else {
					$videos = $wallControl->getVideosByWallSecureId($getData["WallSecureId"]);
				}
				if (is_array($videos)) {
					$response->videos = $videos;
					$response->videosHash = md5(json_encode($videos));
					$response->success = true;
					$response->updatePollLength = $this->application->registry->get("Wall/DefaultWallPollLength");
				}
				break;
			*/
			case self::SERVICE_SAVE:
				if ($memberDataEntity = TokenCheck::validateToken($postData["Token"], true)) {
					$wallControl = Factory::getWallControl();
					$wall = Factory::getWall(json_decode(stripslashes($postData["WallData"])));
					if ($wallDataEntity = $wallControl->saveWall($memberDataEntity, $wall)) {
						$response->success = true;
						$response->wall = $wallDataEntity->toObject();
					}
				}
				break;
		}

		$response->errors = $this->application->errorControl->getErrors();

		return $response;
	}
}