<?php
/**
 * @package Gawk
 * @subpackage Video
 * @version @VERSION-NUMBER@
 */
include_once "Gawk/Video/Video.php";
include_once "Gawk/Member/MemberUrlHelper.php";

/**
 *
 * @author Elliot Coad {@link mailto:elliotcoad@gmail.com}
 * @version @VERSION-NUMBER@
 * @package Gawk
 * @subpackage Video
 */
class VideoUrlHelper {
	/**
	 * @param Video $video
	 * @param Member $member
	 * @return string Url
	 */
	public function getVideoUrl(Video $video, Member $member) {
		$memberUrlHelper = Factory::getMemberUrlHelper();
		return $memberUrlHelper->getProfileUrl($member) . "/gawk/" . $video->secureId;
	}
}