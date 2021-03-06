<?php
/**
 * @package Gawk
 * @subpackage Member
 * @version @VERSION-NUMBER@
 */
include_once "Gawk/Member/Member.php";

/**
 *
 * @author Elliot Coad {@link mailto:elliotcoad@gmail.com}
 * @version @VERSION-NUMBER@
 * @package Gawk
 * @subpackage Member
 */
class MemberUrlHelper {
	/**
	 * @param Member $member
	 * @return string Url
	 */
	public function getProfileUrl(Member $member) {
		return "/u/" . $member->alias;
	}

	public function getProfilePictureUrl(Member $member, $size) {
		$application = CoreFactory::getApplication();

		return $application->registry->get("Site/Address") . "/u/" . $member->alias . "/profile/img/$size";
	}
}