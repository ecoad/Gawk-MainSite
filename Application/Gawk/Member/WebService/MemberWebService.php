<?php
class MemberWebService {

	const SERVICE_NAME_SPACE = "Member";

	const SERVICE_LOGIN = "Login";
	const SERVICE_LOGOUT = "Logout";
	const SERVICE_GET_LOGGED_IN_MEMBER = "GetLoggedInMember";
	const SERVICE_REGISTER_MEMBER = "RegisterMember";
	const SERVICE_UPDATE_PROFILE = "UpdateProfile";
	const SERVICE_SEND_MEMBER_PANEL_ACTION = "SendMemberPanelAction";

	/**
	 * @var Application
	 */
	protected $application;

	/**
	 * @var MemberAuthentication
	 */
	protected $memberAuthentication;

	/**
	 * @var CustomMemberControl
	 */
	protected $memberControl;

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
			case self::SERVICE_LOGIN:
				if ($member = $this->memberAuthentication->login($postData)) {
					$response->member = $member->toObject(true);
					$response->success = true;
				}
				break;
			case self::SERVICE_LOGOUT:
				$postData["Token"] = $this->application->defaultValue($postData["Token"], "");
				$response->success = $this->memberAuthentication->logoutToken($postData["Token"]);
				break;
			case self::SERVICE_GET_LOGGED_IN_MEMBER:
				$getData["Token"] = $this->application->defaultValue($getData["Token"], "");
				if ($memberDataEntity = $this->memberAuthentication->getLoggedInMemberDataEntity($getData["Token"])) {
					$response->success = true;
					$response->member = $memberDataEntity->toObject(false, true);
				}
				break;
			case self::SERVICE_REGISTER_MEMBER:
				$member = Factory::getMember(json_decode(stripslashes($postData["MemberData"])));
				if ($memberDataEntity = $this->memberControl->registerMember($member)) {
					$response->member = $memberDataEntity->toObject(true);
					$response->success = true;
				}
				break;
			case self::SERVICE_UPDATE_PROFILE:
				$postData["Token"] = $this->application->defaultValue($postData["Token"], "");
				if ($memberDataEntity = $this->memberAuthentication->getLoggedInMemberDataEntity($postData["Token"])) {
					if ($memberDataEntity = $this->memberControl->updateProfile($memberDataEntity, $postData["ProfileData"])) {
						$response->success = !$this->application->errorControl->hasErrors();
						$response->member = $memberDataEntity->toObject(false, true);
					}
				}
				break;
			case self::SERVICE_SEND_MEMBER_PANEL_ACTION:
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