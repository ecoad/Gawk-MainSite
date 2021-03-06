<?php
class MemberAuthentication {

	/**
	 * @var CustomMemberControl
	 */
	protected $memberControl;

	/**
	 * @var ErrorControl
	 */
	protected $errorControl;

	/**
	 * @var Application
	 */
	protected $application;

	/**
	 * @var TokenCheck
	 */
	protected $tokenCheck;

	public function __construct() {
		$this->memberControl = Factory::getMemberControl();
		$this->application = CoreFactory::getApplication();
		$this->errorControl = CoreFactory::getErrorControl();
		$this->tokenCheck = Factory::getTokenCheck();
	}

	public function login(array $loginData) {
		$facebookLogin = isset($loginData["FacebookId"]);
		if ($facebookLogin) {
			$loginData["PublicKey"] = $this->application->defaultValue($loginData["PublicKey"], null);
			$loginData["Signature"] = $this->application->defaultValue($loginData["Signature"], null);
			$memberDataEntity = $this->getFacebookRegisteredWithLoginData($loginData["FacebookId"], $loginData["PublicKey"], $loginData["Signature"]);
		} else {
			$memberDataEntity = $this->getSiteRegisteredWithLoginData($loginData["EmailAddress"], $loginData["Password"]);
		}

		if ($memberDataEntity) {
			$this->setAuthenticatedSession($memberDataEntity);
		} else {
			if ($facebookLogin) {
				$this->errorControl->addError("Unable to log in with provided credentials", "InvalidLoginCredentials");
			} else {
				$this->errorControl->addError("Incorrect email address or password", "InvalidLoginCredentials");
			}
		}

		return $memberDataEntity;
	}

	/**
	 * @param string $facebookId
	 * @param string $publicKey
	 * @return CustomMemberDataEntity
	 */
	protected function getFacebookRegisteredWithLoginData($facebookId, $publicKey = null, $signature = null) {
		if (!$publicKey) {
			if (!$facebookId = $this->getLoggedInFacebookId()) {
				$this->errorControl->addError("Cannot retrieve FacebookId");
				return false;
			}
		} else {
			if (!$this->authenticateFacebookIdWithSignature($facebookId, $publicKey, $signature)) {
				$this->errorControl->addError("Cannot authenticate FacebookId with supplied Public Key");
				return false;
			}
		}

		$memberDataEntity = $this->memberControl->getMemberDataEntityByFacebookId($facebookId);
		if (!$memberDataEntity && ($facebookData = $this->getFacebookData($facebookId))) {
			$member = Factory::getMember($facebookData);
			$memberDataEntity = $this->memberControl->registerMember($member);
		}

		return $memberDataEntity;
	}

	/**
	 * @return CustomMemberDataEntity
	 */
	protected function getSiteRegisteredWithLoginData($emailAddress, $password) {
		return $this->memberControl->getMemberDataEntityByEmailAddressPassword($emailAddress, $password);
	}

	/**
	 * Return true if able to log out
	 * @param string $token
	 * @return boolean
	 */
	public function logoutToken($token = null) {
		return $this->revokeAuthenticatedSession($token);
	}

	/**
	 * @param MemberDataEntity $memberDataEntity
	 * @return boolean True if successful
	 */
	public function setAuthenticatedSession(MemberDataEntity $memberDataEntity) {
		$memberDataEntity->set("Token", $this->generateToken());
		$this->memberControl->updateField($memberDataEntity, "Token", $memberDataEntity->get("Token"));
		$_SESSION["Token"]  = $memberDataEntity->get("Token");
		return true;
	}

	/**
	 * @param string $facebookId
	 * @param string $publicKey
	 * @param string $signature
	 * @return boolean True if FacebookId is authenticated
	 */
	protected function authenticateFacebookIdWithSignature($facebookId, $publicKey, $signature) {
		//TODO: Obviously the public/private key lookup will need to be stored in a DB
		if ($publicKey != "787a4aa2778d73f6f2da1598e13668753b5a8010") {
			$this->errorControl->addError("Public key not found", "InvalidPublicKey");
			return false;
		}

		if ($signature != hash("sha256", $facebookId . "d20533231c09074a07de1cc9f593c1765bdcf146f7efee55abe61e66a2cda80b")) {
			$this->errorControl->addError("Invalid signature", "InvalidSignature");
			return false;
		}

		return true;
	}

	/**
	 * @param string $token
	 * @return boolean True if able to revoke session
	 */
	protected function revokeAuthenticatedSession($token) {
		if (!$token) {
			if (isset($_SESSION["Token"])) {
				$token = $_SESSION["Token"];
			}
		}
		if ($token) {
			if ($memberDataEntity = $this->memberControl->getMemberDataEntityByToken($token, false)) {
				$this->memberControl->updateField($memberDataEntity, "Token", "");
			} else {
				$this->errorControl->addError("Could not find Member by token", "InvalidToken");
			}
		}

		@session_destroy();
		$this->revokeFacebookSession();

		return true;
	}

	/**
	 * Remove Facebook cookie set locally
	 */
	public function revokeFacebookSession() {
		if ($this->isFacebookSessionSet()) {
			setcookie($this->getFacebookCookieName(), "", time() - 300, "/", $this->application->registry->get("Site/CommonDomain"));
		}
		return true;
	}

	public function isFacebookSessionSet() {
		return isset($_COOKIE[$this->getFacebookCookieName()]);
	}

	/**
	 * @return string
	 */
	protected function getFacebookCookieName() {
		return "fbs_" . $this->application->registry->get("Facebook/AppId");
	}

	/**
	 * @param string Token
	 * @return CustomMemberDataEntity
	 */
	public function getLoggedInMemberDataEntity($token = null) {
		if ($memberDataEntity = TokenCheck::validateToken($token, true)) {
			return $memberDataEntity;
		}
	}

	/**
	 * @param string $token
	 * @return Member
	 */
	public function getLoggedInMember($token = null) {
		if ($memberDataEntity = $this->getLoggedInMemberDataEntity($token)) {
			return $memberDataEntity->toObject();
		}
	}

	protected function getLoggedInFacebookId() {
		$facebook = Factory::getFacebook(CoreFactory::getApplication());
		if ($facebook->getSession()) {
			return $facebook->getUser();
		}
	}

	/**
	 * Return a new token string
	 * @return string Token
	 */
	protected function generateToken() {
		return sha1(uniqid());
 	}

 	/**
 	 * @param string $facebookId
 	 * @return stdClass FacebookData
 	 */
	protected function getFacebookData($facebookId) {
		$facebook = Factory::getFacebook(CoreFactory::getApplication());

		if ($facebook->getSession()) {
			try {
				$facebookMember = $facebook->api(
					array(
					"method" => "users.getinfo",
						"uids" => $facebookId,
						"fields" => "first_name,last_name"
					)
				);

				$facebookData = new stdClass();
				$facebookData->firstName = $facebookMember[0]["first_name"];
				$facebookData->lastName = $facebookMember[0]["last_name"];
				$facebookData->facebookId = $facebookId;

				$prettyUrlFormatter = CoreFactory::getPrettyUrlFormatter();
				$alias = $prettyUrlFormatter->format(strtolower($facebookData->firstName . " " . $facebookData->lastName));

				if ($existingAliasMemberDataEntity = $this->memberControl->getMemberDataEntityByAlias($alias)) {
					$alias .= "+" . uniqid();
				}

				$facebookData->alias = $alias;
				return $facebookData;
			} catch (FacebookApiException $error) {
				$this->errorControl->addError($error->getMessage());
			}
		} else {
			$this->errorControl->addError("Could not get Facebook session");
		}
	}

	/**
	 * @return boolean
	 */
	public function isLoggedIn() {
		$loggedIn = isset($_SESSION["Token"]);

		if (!$loggedIn && $this->isFacebookSessionSet()) {
			$this->revokeFacebookSession();
		}
		return $loggedIn;
	}

	public function isRequestLogInOnly($requestUri) {
		switch (true) {
			case ($requestUri == "/starred"):
			case ($requestUri == "/friends"):
				return true;
				break;
		}

		return false;
	}
}
