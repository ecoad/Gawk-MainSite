<?php
require_once "Atrox/Core/Data/Data.php";
require_once "MemberWallBookmarkDataEntity.php";

class MemberWallBookmarkControl extends DataControl {
	public $table = "MemberWallBookmark";
	public $key = "Id";
	public $sequence = "MemberWallBookmark_Id_seq";
	public $defaultOrder = "Id";
	public $searchFields = array("Id");

	public function init() {
		$this->fieldMeta["Id"] = new FieldMeta(
			"Id", "", FM_TYPE_INTEGER, null, FM_STORE_NEVER, false);

		$this->fieldMeta["WallSecureId"] = new FieldMeta(
			"Wall ID", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["MemberSecureId"] = new FieldMeta(
			"Member ID", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["DateCreated"] = new FieldMeta(
			"DateCreated", "", FM_TYPE_DATE, null, FM_STORE_NEVER, false);
	}

	/**
	 * Get Wall Bookmarks
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param integer $limit
	 */
	public function getWallBookmarks(CustomMemberDataEntity $memberDataEntity, $limit = 10) {
		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "MemberSecureId", $memberDataEntity->get("SecureId"));
		$filter->addOrder("DateCreated", true);
		$filter->addLimit($limit);
		$this->setFilter($filter);
	}

	/**
	 * Get Wall Bookmarks as array
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param integer $limit
	 * @return array Wall bookmarks
	 */
	public function getWallBookmarksArray(CustomMemberDataEntity $memberDataEntity, $limit = 10) {
		$this->getWallBookmarks($memberDataEntity, $limit);
		$walls = array();

		$wallControl = Factory::getWallControl();
		while ($wallBookmarkDataEntity = $this->getNext()) {
			if ($wallDataEntity = $wallControl->itemByField($wallBookmarkDataEntity->get("WallSecureId"), "SecureId")) {
				$walls[] = $wallDataEntity->toObject();
			}
		}

		return $walls;
	}

	/**
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param string $wallSecureId
	 * @return boolean
	 */
	public function addWallBookmark(CustomMemberDataEntity $memberDataEntity, $wallSecureId) {
		if ($this->isWallBookmarked($memberDataEntity, $wallSecureId)) {
			$this->errorControl->addError("Already bookmarked", "BookmarkDuplicate");
			return false;
		}

		$wallControl = Factory::getWallControl();
		if (!$wallDataEntity = $wallControl->getWallWithSecureId($wallSecureId)) {
			$this->errorControl->addError("Invalid Wall secure ID", "InvalidWallSecureId");
			return false;
		}

		$memberWallBookmarkDataEntity = $this->makeNew();
		$memberWallBookmarkDataEntity->set("MemberSecureId", $memberDataEntity->get("SecureId"));
		$memberWallBookmarkDataEntity->set("WallSecureId", $wallDataEntity->get("SecureId"));
		if ($memberWallBookmarkDataEntity->save()) {
			return true;
		}

		return false;
	}

	/**
	 * Has member already bookmarked a wall
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param string $wallSecureId
	 * @param boolean
	 */
	public function isWallBookmarked(CustomMemberDataEntity $memberDataEntity, $wallSecureId) {
		if ($this->getWallBookmarked($memberDataEntity, $wallSecureId)) {
			return true;
		}

		return false;
	}

	/**
	 * Get bookmark
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param string $wallSecureId
	 * @param boolean
	 */
	public function getWallBookmarked(CustomMemberDataEntity $memberDataEntity, $wallSecureId) {
		$wallControl = Factory::getWallControl();
		if (!$wallDataEntity = $wallControl->getWallWithSecureId($wallSecureId)) {
			$this->errorControl->addError("Invalid Wall secure ID", "InvalidWallSecureId");
			return false;
		}

		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "WallSecureId", $wallDataEntity->get("SecureId"));
		$filter->addConditional($this->table, "MemberSecureId", $memberDataEntity->get("SecureId"));
		$this->setFilter($filter);

		return $this->getNext();
	}

	/**
	 * Remove bookmark
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param string $wallSecureId
	 * @param boolean
	 */
	public function removeWallBookmark(CustomMemberDataEntity $memberDataEntity, $wallSecureId) {
		if (!$wallBookmarkDataEntity = $this->getWallBookmarked($memberDataEntity, $wallSecureId)) {
			$this->errorControl->addError("Unable to retrieve bookmark", "NoBookmark");
			return false;
		}

		if ($this->delete($wallBookmarkDataEntity->get("Id"))) {
			return true;
		}

		return false;
	}

	/**
	 * Return recent wall activity for a given member
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @return stdClass Activity
	 */
	public function getRecentWallActivity(CustomMemberDataEntity $memberDataEntity) {
		$activity = new stdClass();
		$activity->bookmarks = $this->getWallBookmarksArray($memberDataEntity);
		$activity->recentWallParticipation = $this->getRecentWallParticipation($memberDataEntity);
		$activity->wallsCreatedByMember = $this->getWallsCreatedByMember($memberDataEntity);

		return $activity;
	}

	/**
	 * Get recent walls created by Member
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param integer $limit
	 * @return array Walls member has created
	 */
	public function getWallsCreatedByMember(CustomMemberDataEntity $memberDataEntity, $limit = 10) {
		$recentWalls = array();

		$wallControl = Factory::getWallControl();

		$filter = CoreFactory::getFilter();
		$filter->addConditional($wallControl->table, "MemberSecureId", $memberDataEntity->get("SecureId"));
		$filter->addOrder("DateCreated", true);
		$filter->addLimit($limit);

		$wallControl->setFilter($filter);

		while ($wallDataEntity = $wallControl->getNext()) {
			$recentWalls[] = $wallDataEntity->toObject();
		}

		return $recentWalls;
	}


	/**
	 * Get recent participation
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param integer $limit
	 * @return array Walls member has featured on recently
	 */
	public function getRecentWallParticipation(CustomMemberDataEntity $memberDataEntity, $limit = 10) {
		//TODO: Finish

		$recentActivity = array();
		$sql = <<<SQL
SELECT DISTINCT "Video"."WallSecureId"
	FROM "Video"
	WHERE "MemberSecureId" = '{$memberDataEntity->get("SecureId")}' AND
		"Approved" = 't'
		GROUP BY "WallSecureId"
		LIMIT {$limit};
SQL;
		$videoControl = Factory::getVideoControl();
		$videoControl->runQuery($sql);

		$wallControl = Factory::getWallControl();

		while ($videoDataEntity = $videoControl->getNext()) {
			if ($wallDataEntity = $wallControl->itemByField($videoDataEntity->get("WallSecureId"), "SecureId")) {
				$recentActivity[] = $wallDataEntity->toObject();
			}
		}

		return $recentActivity;
	}

	/**
	 * (non-PHPdoc)
	 * @see Application/Atrox/Core/Data/DataControl::getDataEntity()
	 */
	public function getDataEntity() {
		return new MemberWallBookmarkDataEntity($this);
	}
}