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
	public function isMemberAuthorisedForVideoAdmin(Video $video, Wall $wall = null, Member $member = null) {
		$application = CoreFactory::getApplication();
		if ($member === null) {
			$memberAuthentication = Factory::getMemberAuthentication();
			if (!$member = $memberAuthentication->getLoggedInMember()) {
				$application->errorControl->addError("No member provided");
				return false;
			}
		}

		if ($member->secureId == $video->memberSecureId) {
			return true;
		}

		if (($wall !== null) && ($member->secureId == $wall->memberSecureId)) {
			return true;
		}

		if ($application->securityControl->isAllowed("Admin", false)) {
			return true;
		}
		return false;
	}

	/**
	 * @param Video $video
	 * @param Member $member
	 * @return boolean
	 */
	public function deleteVideo(Video $video, Member $member) {
		$videoControl = Factory::getVideoControl();
		if ($this->isMemberAuthorisedForVideoAdmin($video, null, $member)) {
			if ($videoControl->deleteBySecureId($video->secureId)) {
				return true;
			}
		} else {
			$application = CoreFactory::getApplication();
			$application->errorControl->addError("Member unauthorised to delete video");
		}

		return false;
	}
}