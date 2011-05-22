<?php
class MemberRatingWebService {

	const SERVICE_NAME_SPACE = "MemberRating";

	const SERVICE_GET_RATING = "GetRating";
	const SERVICE_ADD_RATING = "AddRating";
	/**
	 * @var Application
	 */
	protected $application;

	/**
	 * @var MemberRatingControl
	 */
	protected $memberRatingControl;

	public function __construct() {
		$this->application = CoreFactory::getApplication();
		$this->memberRatingControl = Factory::getMemberRatingControl();
	}

	/**
	 * @param string $method
	 * @param array $postData
	 * @param array $getData
	 * @return stdClass Response
	 */
	public function handleRequest($method, array $postData = null, array $getData = null) {
		$response = new stdClass();
		$response->success = false;
		$response->errors = array();

		$getData["Token"] = $this->application->defaultValue($getData["Token"], null);
		$postData["Token"] = $this->application->defaultValue($postData["Token"], null);
		if ($getData["Token"]) {
			$postData["Token"] = $getData["Token"];
		}

		if ($memberDataEntity = TokenCheck::validateToken($postData["Token"], true)) {
			switch($method) {
				case self::SERVICE_GET_RATING:
					if ($memberRatingDataEntity = $this->memberRatingControl->getMemberRating(
						$memberDataEntity->get("SecureId"), $getData["VideoSecureId"])) {
							
						$response->success = true;
						$response->positiveRating = $memberRatingDataEntity->isPositiveRating();
					}
					break;
				case self::SERVICE_ADD_RATING:
					if ($this->memberRatingControl->addRating($memberDataEntity, $postData["VideoSecureId"], $postData["PositiveRating"])) {
						$response->success = true;
					}
					break;
				default;
					$this->application->errorControl->addError("Member method \"$method\" unknown");
					break;
			}
		}

		$response->errors = $this->application->errorControl->getErrors();

		return $response;
	}
}