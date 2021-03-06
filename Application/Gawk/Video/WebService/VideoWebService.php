<?php
class VideoWebService {

	const SERVICE_NAME_SPACE = "Video";
	const SERVICE_SAVE = "Save";
	const SERVICE_DELETE = "Delete";
	const SERVICE_SAVE_MEDIA_SERVER_UPLOAD = "SaveMediaServerUpload";


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
			$member = $memberDataEntity->toObject();
			switch ($method) {
				case self::SERVICE_SAVE:
					$video = Factory::getVideo(json_decode(stripslashes($postData["Video"])));
					$video->memberSecureId = $member->secureId;
					if ($videoDataEntity = $videoControl->saveVideo($video, $filesData)) {
						$response->success = true;
						$response->video = $videoDataEntity->toObject();
					}
					break;
				case self::SERVICE_DELETE:
					if ($videoDataEntity = $videoControl->getVideoDataEntityBySecureId($postData["VideoSecureId"])) {
						$video = $videoDataEntity->toObject();
						$videoAdministration = Factory::getVideoAdministrationFactory();

						if ($videoAdministration->deleteVideo($video, $member)) {
							$response->success = true;
						}
					} else {
						$this->application->errorControl->addError("Could not find video");
					}
					break;
			}
		}

		$response->errors = array_values($this->application->errorControl->getErrors());

		return $response;
	}
}