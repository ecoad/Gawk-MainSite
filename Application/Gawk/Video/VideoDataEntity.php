<?php
require_once "Application/Atrox/Core/Data/DataEntity.php";
class VideoDataEntity extends DataEntity {

	/**
	 * @return Video
	 **/
	public function toObject() {
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

		$video->dateCreatedTime = strtotime($video->dateCreated);

		return $video;
	}
}