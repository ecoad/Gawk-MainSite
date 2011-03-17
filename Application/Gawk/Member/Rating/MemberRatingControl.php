<?php
require_once "Atrox/Core/Data/Data.php";
require_once "Gawk/Member/Rating/MemberRatingDataEntity.php";

class MemberRatingControl extends DataControl {
	public $table = "MemberRating";
	public $key = "Id";
	public $sequence = "MemberRating_Id_seq";
	public $defaultOrder = "Id";
	public $searchFields = array("Id");

	public function init() {
		$this->fieldMeta["Id"] = new FieldMeta(
			"Id", "", FM_TYPE_INTEGER, null, FM_STORE_NEVER, false);

		$this->fieldMeta["VideoSecureId"] = new FieldMeta(
			"Video Secure ID", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["MemberSecureId"] = new FieldMeta(
			"Member Secure ID", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["PositiveRating"] = new FieldMeta(
			"Positive Rating", "", FM_TYPE_BOOLEAN, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["DateCreated"] = new FieldMeta(
			"DateCreated", "", FM_TYPE_DATE, null, FM_STORE_NEVER, false);

		$this->fieldMeta["IpAddress"] = new FieldMeta(
			"IP Address", "", FM_TYPE_IP, null, FM_STORE_ALWAYS, false);
	}

	/**
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param string $videoSecureId
	 * @param string $positiveRating i.e. "t" or "f"
	 * @return boolean True if saved
	 */
	public function addRating(CustomMemberDataEntity $memberDataEntity, $videoSecureId, $positiveRating) {
		$positiveRatingFormatted = $positiveRating ? "t" : "f";
		$videoControl = Factory::getVideoControl();
		if ($video = $videoControl->itemByField($videoSecureId, "SecureId")) {
			$rating = null;
			if ($rating = $this->getMemberRating($memberDataEntity->get("SecureId"), $videoSecureId)) {
				$newRating = false;
				if ($rating->get("PositiveRating") == $positiveRatingFormatted) {
					$this->errorControl->addError("MemberRating for this video aleady is set", "DuplicateRating");
					return false;
				}
			} else {
				$newRating = true;
				$rating = $this->makeNew();
				$rating->set("VideoSecureId", $video->get("SecureId"));
				$rating->set("MemberSecureId", $memberDataEntity->get("SecureId"));
			}
			$rating->set("PositiveRating", $positiveRating);

			if ($rating->save()) {
				$modificationValue = $newRating ? 1 : 2;
				$sql = "UPDATE \"{$videoControl->table}\" SET \"Rating\" = \"Rating\" " . ($positiveRating ? "+" : "-") . "$modificationValue WHERE \"SecureId\" = '{$video->get("SecureId")}'";
				$videoControl->runQuery($sql);
				return true;
			}
		} else {
			$this->errorControl->addError("Cannot find video: $videoSecureId", "InvalidVideoSecureId");
			return false;
		}
	}

	/**
	 * Return the video rating a member has submitted
	 * @param integer $memberSecureId
	 * @param string $videoSecureId
	 * @return DataEntity Member rating
	 */
	public function getMemberRating($memberSecureId, $videoSecureId) {
		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "VideoSecureId", $videoSecureId);
		$filter->addConditional($this->table, "MemberSecureId", $memberSecureId);
		$this->setFilter($filter);

		return $this->getNext();
	}

	/**
	 * (non-PHPdoc)
	 * @see Application/Atrox/Core/Data/DataControl::getDataEntity()
	 */
	public function getDataEntity() {
		return new MemberRatingDataEntity($this);
	}
}