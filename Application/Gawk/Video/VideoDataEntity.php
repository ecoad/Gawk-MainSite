<?php
require_once "Application/Atrox/Core/Data/DataEntity.php";
class VideoDataEntity extends DataEntity {

	/**
	 * @return Video
	 **/
	public function toObject($previousRunTime = null) {
		$array = array();
		foreach ($this->data as $k => $v) {
			switch($this->control->fieldMeta[$k]->type) {
				case FM_TYPE_BOOLEAN:
					$v = $v == "t" || $v === true || $v == "true";
					break;
			}
			$array[lcfirst($k)] = $v;
		}
		$memberControl = Factory::getMemberControl();

		$video = Factory::getVideo((object)$array);
		$memberDataEntity = $memberControl->getMemberDataEntityBySecureId($video->memberSecureId);
		if ($memberDataEntity) {
			$video->member = $memberDataEntity->toObject();
		}


		$this->control->application->log("ZZZ ..." . $previousRunTime . "...", "sql");
		if ($previousRunTime !== null) {
			$date = new DateTime($video->dateCreated, new DateTimeZone("UTC"));
			$this->control->application->log("JIM " . $video->dateCreated . " " . $date->format("U") . " " . $previousRunTime . "+++JOHN", "sql");
			$video->newVideoAfterInit = ($date->format("U") > $previousRunTime); //Convert times to same timezone
		}
		return $video;
	}
}