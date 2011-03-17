<?php
require_once "Atrox/Core/Data/Data.php";
require_once "Gawk/Wall/WallDataEntity.php";

class WallControl extends DataControl {
	public $table = "Wall";
	public $key = "Id";
	public $sequence = "Wall_Id_seq";
	public $defaultOrder = "Id";
	public $searchFields = array("Id");

	public function init() {
		$this->fieldMeta["Id"] = new FieldMeta(
			"Id", "", FM_TYPE_INTEGER, null, FM_STORE_NEVER, false);

		$this->fieldMeta["SecureId"] = new FieldMeta(
			"Secure ID", "", FM_TYPE_STRING, 50, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Url"] = new FieldMeta(
			"URL", "", FM_TYPE_STRING, 100, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Description"] = new FieldMeta(
			"Description", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, true);

		$this->fieldMeta["DateCreated"] = new FieldMeta(
			"DateCreated", "", FM_TYPE_DATE, null, FM_STORE_NEVER, false);

		$this->fieldMeta["MemberSecureId"] = new FieldMeta(
			"Member Secure ID", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["PublicView"] = new FieldMeta(
			"Public View", "f", FM_TYPE_BOOLEAN, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["PublicGawk"] = new FieldMeta(
			"Public Gawk", "f", FM_TYPE_BOOLEAN, null, FM_STORE_ALWAYS, false);
	}

	/**
	 * @param string $wallSecureId
	 * @param integer $currentPage
	 * @param integer $pageLength
	 * @return array Videos
	 */
	public function getVideosByWallSecureId($wallSecureId, $currentPage = 1, $pageLength = -1) {
		if ($pageLength == -1) {
			$pageLength = $this->application->registry->get("Wall/DefaultLength");
		}

		$wallControl = Factory::getWallControl();
		if (!$wallDataEntity = $wallControl->getWallWithSecureId($wallSecureId)) {
			$this->errorControl->addError("Invalid Wall secure ID", "InvalidWall");
			return false;
		}

		$videoControl = Factory::getVideoControl();
		$filter = $this->getVideoFilter();
		$filter->addOrder("DateCreated", true);
		$filter->addConditional($videoControl->table, "WallSecureId", $wallSecureId);
		$videoControl->setFilter($filter);
		$videos = array();
		while ($videoDataEntity = $videoControl->getPage($currentPage, $pageLength)) {
			$videos[] = $videoDataEntity->toObject();
		}

		return $videos;
	}

	/**
	 * Get main wall
	 *
	 * @param integer $currentPage
	 * @param integer $pageLength
	 * @return array Videos
	 */
	public function getVideosByMainWall($currentPage = 1, $pageLength = -1) {
		if ($pageLength == -1) {
			$pageLength = $this->application->registry->get("Wall/DefaultLength");
		}

		$videoControl = Factory::getVideoControl();
		$filter = $this->getVideoFilter();
		$filter->addConditional($videoControl->table, "Rating", 2, ">=");
		$filter->addConditional($videoControl->table, "DateCreated", date("Y-m-d H:i:s", time() - SECONDS_IN_DAY), ">=");
		$filter->addOrder("Rating", true);
		$videoControl->setFilter($filter);
		$videos = array();
		while ($videoDataEntity = $videoControl->getPage($currentPage, $pageLength)) {
			$videos[] = $videoDataEntity->toObject();
		}

		return $videos;
	}

	protected function getVideoFilter(Filter $filter = null) {
		if (!$filter) {
			$filter = CoreFactory::getFilter();
		}
		$videoControl = Factory::getVideoControl();

		$filter->addConditional($videoControl->table, "Approved", "t");
		$filter->addConditional($videoControl->table, "Rating", -2, ">=");

		return $filter;
	}

	/**
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param Wall $wall
	 * @return WallDataEntity
	 */
	public function saveWall(CustomMemberDataEntity $memberDataEntity, Wall $wall) {
		$wallDataEntity = $this->mapWallToWallDataEntity($memberDataEntity, $wall);

		$this->validateUrl($wall->url);
		if ($wallDataEntity->save()) {
			return $wallDataEntity;
		}
	}

	/**
	 * Map a Wall to WallDataEntity
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param Wall $wall
	 * @param WallDataEntity $wallDataEntity
	 * @return WallDataEntity
	 */
	public function mapWallToWallDataEntity(CustomMemberDataEntity $memberDataEntity,	Wall $wall,
		WallDataEntity $wallDataEntity = null) {

		if (!$wallDataEntity) {
			$wallDataEntity = $this->makeNew();
		}

		foreach ((array)$wall as $key => $value) {
			if (($value !== null) && ($value !== "")) {
				$wallDataEntity->set(ucfirst($key), $value);
			}
		}
		$wall->memberSecureId  = $memberDataEntity->get("SecureId");

		return $wallDataEntity;
	}

	public function validateUrl($url) {
		//TODO: Allow hyphens and underscores
		if (!ctype_alnum($url)) {
			$this->errorControl->addError("Invalid URL", "InvalidUrl");
			return false;
		}
		return true;
	}

	public function getWallWithSecureId($wallSecureId) {
		return $this->itemByField($wallSecureId, "SecureId");
	}

	public function makeNew() {
		$wall = parent::makeNew();
		$wall->set("SecureId", uniqid("wall-"));

		return $wall;
	}

	public function getDataEntity() {
		return new WallDataEntity($this);
	}
}