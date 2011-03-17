<?php
class MemberWebService {
	/**
	 * @var Application
	 */
	protected $application = null;

	/**
	 * @var MemberAuthentication
	 */
	protected $memberAuthentication = null;

	/**
	 * @var MemberControl
	 */
	protected $memberControl = null;

	public function __construct() {
		$this->application = CoreFactory::getApplication();
		$this->memberAuthentication = Factory::getMemberAuthentication();
		$this->memberControl = Factory::getMemberControl();
	}

	public function handleRequest($method, array $postData = null, array $getData = null) {
		$response = new stdClass();
		$response->success = false;
		$response->errors = array();

		switch ($method) {
			case "Login":
				if ($member = $this->memberAuthentication->login($postData)) {
					$response->member = $member->toObject(true);
					$response->success = true;
				}
				break;
			case "Logout":
				$postData["Token"] = $this->application->defaultValue($postData["Token"], "");
				$response->success = $this->memberAuthentication->logoutToken($postData["Token"]);
				break;
			case "GetLoggedInMember":
				$getData["Token"] = $this->application->defaultValue($getData, "");
				if ($memberDataEntity = $this->memberAuthentication->getLoggedInMember($getData["Token"])) {
					$response->success = true;
					$response->member = $memberDataEntity->toObject();
				}
				break;
			case "RegisterMember":
				$member = Factory::getMember(json_decode(stripslashes($postData["MemberData"])));
				if ($memberDataEntity = $this->memberControl->registerMember($member)) {
					$response->member = $memberDataEntity->toObject(true);
					$response->success = true;
				}
				break;
			case "SendMemberPanelAction":
				throw new Exception("Needs reimplementing");
				/*
				switch ($postData["MemberAction"]) {
					case "GawkPositiveRating":
					case "GawkNegativeRating":
						$ratingControl = Factory::getMemberRatingControl();
						$response->success = (bool)$ratingControl->addRating($postData["VideoId"],
							($postData["MemberAction"] == "GawkPositiveRating"), $postData["MemberId"]);
						break;
					case "GawkRemove":
						$videoControl = Factory::getVideoControl();
						if ($videoControl->deleteBySecureId($postData["VideoId"])) {
							$response->success = true;
						}
						break;
					default:
						$this->application->errorControl->getErrors("Member action \"{$postData["MemberAction"]}\" unknown");
						break;
				}
				*/
				break;
			default;
				$this->application->errorControl->addError("Member method \"$method\" unknown");
				break;
		}

		$response->errors = $this->application->errorControl->getErrors();

		return $response;
	}
}