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
		return Factory::getVideo((object)$array);
	}
}