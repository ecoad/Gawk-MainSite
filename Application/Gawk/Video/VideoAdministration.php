<?php
include_once "Gawk/Video/Video.php";
include_once "Gawk/Wall/Wall.php";

class VideoAdministration {
	public function __construct() {

	}

	/**
	 * @param Video $video
	 * @param Wall $wall
	 * @param Member $member
	 * @return boolean
	 */
	public function isMemberAuthorisedForVideoAdmin(Video $video, Wall $wall, Member $member = null) {
		if ($member === null) {
			$memberAuthentication = Factory::getMemberAuthentication();
			if (!$member = $memberAuthentication->getLoggedInMember()) {
				$application = CoreFactory::getApplication();
				$application->errorControl->addError("No member provided");
				return false;
			}
		}

		if ($member->secureId == $video->memberSecureId) {
			return true;
		}

		if ($member->secureId == $wall->memberSecureId) {
			return true;
		}

		if ($application->securityControl->isAllowed("Admin")) {
			return true;
		}
		return false;
	}
}