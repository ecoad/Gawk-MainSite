<?php
class FlashWebService {

	const SERVICE_NAME_SPACE = "Flash";

	const SERVICE_INIT_APPLICATION = "InitApplication";
	/**
	 * @var Application
	 */
	protected $application;

	public function __construct() {
		$this->application = CoreFactory::getApplication();
	}

	public function handleRequest($method, array $postData = null, array $getData = null) {
		$response = new stdClass();
		$response->success = false;
		$response->errors = array();

		switch($method) {
			case self::SERVICE_INIT_APPLICATION:
				$getData["PreviousRunTime"] = $this->application->defaultValue($getData["PreviousRunTime"], null);
				$wallControl = Factory::getWallControl();

				switch ($getData["WallSecureId"]) {
					case "main-wall":
						$response->videos = $wallControl->getVideosByMainWall();
						break;
					case "favourite-gawks":
						$response->videos = $wallControl->getVideosByFriends();
						break;
					default:
						$response->videos = $wallControl->getVideosByWallSecureId($getData["WallSecureId"], $getData["PreviousRunTime"]);
						break;
				}

				$response->previousRunTime = strtotime($this->application->getCurrentUtcDateTime());
				if (is_array($response->videos)) {
					$response->success = true;

					//$response->updatePollLength = $this->application->registry->get("Wall/DefaultWallPollLength");
					$response->updatePollLength = 10000;

					$response->mediaServerLocation = $this->application->registry->get("MediaServer/Address");
					$response->binaryLocation = $this->application->registry->get("Site/Address") . "/resource/binary/";
				}
				break;
		}

		$response->errors = $this->application->errorControl->getErrors();

		return $response;
	}
}