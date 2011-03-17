<?php
class VideoWebService {

	/**
	 * @var Application
	 */
	protected $application = null;

	public function __construct() {
		$this->application = CoreFactory::getApplication();
	}

	public function handleRequest($method, array $postData = null, array $getData = null, array $filesData = null) {
		$videoControl = Factory::getVideoControl();
		$response = new stdClass();
		$response->success = false;
		$response->errors = array();

		$getData["Token"] = $this->application->defaultValue($getData["Token"], null);
		$postData["Token"] = $this->application->defaultValue($postData["Token"], null);
		if ($getData["Token"]) {
			$postData["Token"] = $getData["Token"];
		}

		if ($memberDataEntity = TokenCheck::validateToken($postData["Token"], true)) {
			switch ($method) {
				case "Save":
					$video = Factory::getVideo(json_decode(stripslashes($postData["Video"])));
					if ($videoDataEntity = $videoControl->saveVideo($video, $filesData)) {
						$response->success = true;
						$response->video = $videoDataEntity->toObject();
					}
					break;
			}
		}

		$response->errors = $this->application->errorControl->getErrors();

		return $response;
	}
}