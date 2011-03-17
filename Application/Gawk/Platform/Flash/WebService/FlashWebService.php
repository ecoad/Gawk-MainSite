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
				$videos = $wallControl->getMainWallVideos();
				if (is_array($videos)) {
					$response->success = true;
					$response->videos = $videos;
					$response->mediaServerLocation = $this->application->registry->get("Site/Address");
					$response->binaryLocation = $this->application->registry->get("Site/Address") . "resource/binary/";
				}
				break;
		}

		$response->errors = $this->application->errorControl->getErrors();

		return $response;
	}
}