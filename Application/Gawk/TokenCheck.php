<?php
class TokenCheck {

	/**
	 * Validate provided token
	 * @param string $token
	 * @param boolean $returnMember
	 * @return CustomMemberDataEntity
	 */
	public static function validateToken($token, $returnMember = true) {
		if ((!$token) && (isset($_SESSION["Token"]))) {
			$token = $_SESSION["Token"];
		}
		$errorControl = CoreFactory::getErrorControl();
		$memberAuthentication = Factory::getMemberAuthentication();

		if (!$token) {
			$errorControl->addError("Could not log in without token", "InvalidToken");
			$memberAuthentication->revokeFacebookSession();
			return false;
		}

		$memberControl = Factory::getMemberControl();
		if ($memberDataEntity = $memberControl->getMemberDataEntityByToken($token)) {
			if ($returnMember) {
				return $memberDataEntity;
			}

			return true;
		}

		$errorControl->addError("Invalid token", "InvalidToken");
		$memberAuthentication->revokeFacebookSession();
		return false;
	}
}