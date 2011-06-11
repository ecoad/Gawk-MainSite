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

	public function addFavouriteRating(CustomMemberDataEntity $memberDataEntity, $videoSecureId) {
		if ($rating = $this->getMemberRating($memberDataEntity->get("SecureId"), $videoSecureId)) {
			$this->errorControl->addError("MemberRating for this video aleady is set", "DuplicateRating");
			return false;
		}

		$videoControl = Factory::getVideoControl();

		$rating = $this->makeNew();
		$rating->set("VideoSecureId", $videoSecureId);
		$rating->set("MemberSecureId", $memberDataEntity->get("SecureId"));
		$rating->set("PositiveRating", "t");

		if ($rating->save()) {
			$sql = "UPDATE \"{$videoControl->table}\" SET \"Rating\" = \"Rating\" + 1 WHERE \"SecureId\" = '{$videoSecureId}'";
			$videoControl->runQuery($sql);
			return true;
		}
	}

	public function removeFavouriteRating(CustomMemberDataEntity $memberDataEntity, $videoSecureId) {
		if (!$rating = $this->getMemberRating($memberDataEntity->get("SecureId"), $videoSecureId)) {
			$this->errorControl->addError("MemberRating is not set", "NoCurrentRating");
			return false;
		}

		$videoControl = Factory::getVideoControl();

		$this->delete($rating->get("Id"));

		$sql = "UPDATE \"{$videoControl->table}\" SET \"Rating\" = \"Rating\" - 1 WHERE \"SecureId\" = '{$videoSecureId}'";
		$videoControl->runQuery($sql);
		return true;
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