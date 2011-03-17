<?php
class VideoProvider {

	protected static $wallIdPrefix;

	/**
	 * @return Video
	 */
	public static function getTestVideo() {
		$videoControl = Factory::getVideoControl();
		$video = Factory::getVideo();
		$video->uploadSource = VideoControl::SOURCE_HTML;
		$video->approved = true;
		return $video;
	}

	public static function sendVideo(Video $video, $apiLocation, $file, $type, Member $member) {
		$ch = curl_init($apiLocation);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array(
			"Action" => "Video.Save",
			"Token" => $member->token,
			"Video" => json_encode($video),
			'VideoFile'=> "@" . $file . ";type=" . $type));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);

		return json_decode($response);
	}

	public static function deleteTemporaryVideos(array $memberSecureIds) {
		$videoControl = Factory::getVideoControl();

		foreach ($memberSecureIds as $memberSecureId) {
			if(!$memberSecureId) {
				throw new Exception("no memberSecureId");
			}
			$sql = "DELETE FROM \"{$videoControl->table}\" WHERE \"MemberSecureId\" = '$memberSecureId';";
			$videoControl->runQuery($sql);
		}
	}
}