<?php
class MemberFriendWebService {
	/**
	 * @var Application
	 */
	protected $application;

	/**
	 * @var MemberFriendControl
	 */
	protected $memberFriendControl;

	public function __construct() {
		$this->application = CoreFactory::getApplication();
		$this->memberFriendControl = Factory::getMemberFriendControl();
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

		if ($memberDataEntity = TokenCheck::validateToken($postData["Token"], true)) {
			switch ($method) {
				case "GetFriends":
					$memberFriends = $this->memberFriendControl->getFriendsArray($memberDataEntity->toObject());
					if (is_array($memberFriends)) {
						$response->memberFriends = $memberFriends;
						$response->success = true;
					}
					break;
				case "AddFriend":
					$response->success = $this->memberFriendControl->addFriend($memberDataEntity, $postData["FriendSecureId"]);
					break;
				case "RemoveFriend":
					$response->success = $this->memberFriendControl->removeFriend($memberDataEntity, $postData["FriendSecureId"]);
					break;
				case "IsFriend":
					$response->success = $this->memberFriendControl->isFriend($memberDataEntity, $getData["FriendSecureId"]);
					break;
				default;
					$this->application->errorControl->getErrors("Member method \"$method\" unknown");
					break;
			}
		}

		$response->errors = $this->application->errorControl->getErrors();

		return $response;
	}
}