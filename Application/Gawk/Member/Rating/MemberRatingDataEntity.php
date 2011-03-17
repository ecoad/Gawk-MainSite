<?php
require_once "Application/Atrox/Core/Data/DataEntity.php";
class MemberRatingDataEntity extends DataEntity {
	/**
	 * Return boolean of the positive rating value
	 * @return boolean True if positive
	 */
	public function isPositiveRating() {
		return $this->get("PositiveRating") == "t";
	}
}