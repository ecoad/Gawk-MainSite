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
			"URL", "", FM_TYPE_STRING, 100, FM_STORE_ALWAYS, false, FM_OPTIONS_UNIQUE);

		$this->fieldMeta["Name"] = new FieldMeta(
			"Name", "", FM_TYPE_STRING, 100, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Description"] = new FieldMeta(
			"Description", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

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
		$filter->addLimit($this->application->registry->get("Wall/DefaultLength"));
		$videoControl->setFilter($filter);
		$videos = array();
		while ($videoDataEntity = $videoControl->getPage($currentPage, $pageLength)) {
			$videos[] = $videoDataEntity->toObject();
		}

		return $videos;
	}

	/**
	 * Get main wall
	 * @param integer $timePeriodDays
	 * @param integer $currentPage
	 * @param integer $pageLength
	 * @return array Videos
	 */
	public function getVideosByMainWall($timePeriodDays = 1, $currentPage = 1, $pageLength = -1) {
		if ($pageLength == -1) {
			$pageLength = $this->application->registry->get("Wall/DefaultLength");
		}

		$videoControl = Factory::getVideoControl();
		$filter = $this->getVideoFilter();
		$filter->addConditional($videoControl->table, "Rating", $this->application->registry->get("Wall/MainWallMinimumRating"), ">=");
//		if ($timePeriodDays !== -1) {
//			$dateTimeSince = date("Y-m-d H:i:s", time() - (SECONDS_IN_DAY * $timePeriodDays));
//			$filter->addConditional($videoControl->table, "DateCreated", $dateTimeSince, ">=");
//		}

		$filter->addOrder("Rating", true);
		$filter->addLimit($this->application->registry->get("Wall/DefaultLength"));

		$videoControl->setFilter($filter);
		$videos = array();
		while ($videoDataEntity = $videoControl->getPage($currentPage, $pageLength)) {
			$videos[] = $videoDataEntity->toObject();
		}

//		if (($timePeriodDays !== -1) && (count($videos) < $this->application->registry->get("Wall/DefaultLength"))) {
//			$this->getVideosByMainWall(-1);
//		}

		return $videos;
	}

	protected function getVideoFilter(Filter $filter = null) {
		if (!$filter) {
			$filter = CoreFactory::getFilter();
		}
		$videoControl = Factory::getVideoControl();

		//$filter->addConditional($videoControl->table, "Approved", "t");
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
		if (!preg_match('/^[\da-z-]+$/', $url)) {
			$this->errorControl->addError("'Url' must be only lowercase a-z, 0-9 and hyphens", "InvalidUrl");
			return false;
		}
		return true;
	}

	/**
	 * @param string $wallSecureId
	 * @return WallDataEntity Wall
	 */
	public function getWallWithSecureId($wallSecureId) {
		return $this->itemByField($wallSecureId, "SecureId");
	}

	public function getWallByRequestUrl($requestUrl) {
		$wallUrl = str_replace("/", "", $requestUrl);
		switch ($wallUrl) {
			case "":
			case "wall":
				return $this->getMainWall();
				break;
		}

		if ($wallDataEntity = $this->itemByField($wallUrl, "Url")) {
			return $wallDataEntity->toObject();
		}
	}

	/**
	 * @see Application/Atrox/Core/Data/DataControl::makeNew()
	 * @return WallDataEntity
	 */
	public function makeNew() {
		$wallDataEntity = parent::makeNew();
		$wallDataEntity->set("SecureId", uniqid("wall-"));

		return $wallDataEntity;
	}

	/**
	 * @see Application/Atrox/Core/Data/DataControl::getDataEntity()
	 * @return WallDataEntity
	 */
	public function getDataEntity() {
		return new WallDataEntity($this);
	}

	/**
	 * @return Wall
	 */
	public function getMainWall() {
		$wall = Factory::getWall();
		$wall->description = <<<DESCR
This is the main wall, where highly rated Gawks appear from other walls. Visit another wall or create your own.
DESCR;
		$wall->url = "/";
		$wall->name = "Main Wall";
		return $wall;
	}
}