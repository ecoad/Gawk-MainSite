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
	 * @param Member $member
	 * @param integer $limit
	 */
	public function getWallBookmarks(Member $member, $limit = 10) {
		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "MemberSecureId", $member->secureId);
		$filter->addOrder("DateCreated", true);
		$filter->addLimit($limit);
		$this->setFilter($filter);
	}

	/**
	 * Get Wall Bookmarks as array
	 * @param Member $member
	 * @param integer $limit
	 * @return array Wall bookmarks
	 */
	public function getWallBookmarksArray(Member $member, $limit = 10) {
		$this->getWallBookmarks($member, $limit);
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
	 * @param Member $member
	 * @param string $wallSecureId
	 * @return boolean
	 */
	public function addWallBookmark(Member $member, $wallSecureId) {
		if ($this->isWallBookmarked($member, $wallSecureId)) {
			$this->errorControl->addError("Already bookmarked", "BookmarkDuplicate");
			return false;
		}

		$wallControl = Factory::getWallControl();
		if (!$wall = $wallControl->getWallWithSecureId($wallSecureId)) {
			$this->errorControl->addError("Invalid Wall secure ID", "InvalidWallSecureId");
			return false;
		}

		$memberWallBookmarkDataEntity = $this->makeNew();
		$memberWallBookmarkDataEntity->set("MemberSecureId", $member->secureId);
		$memberWallBookmarkDataEntity->set("WallSecureId", $wall->secureId);
		if ($memberWallBookmarkDataEntity->save()) {
			return true;
		}

		return false;
	}

	/**
	 * Has member already bookmarked a wall
	 * @param Member $member
	 * @param string $wallSecureId
	 * @param boolean
	 */
	public function isWallBookmarked(Member $member, $wallSecureId) {
		if ($this->getWallBookmarked($member, $wallSecureId)) {
			return true;
		}

		return false;
	}

	/**
	 * Get bookmark
	 * @param Member $member
	 * @param string $wallSecureId
	 * @param boolean
	 */
	public function getWallBookmarked(Member $member, $wallSecureId) {
		$wallControl = Factory::getWallControl();
		if (!$wall = $wallControl->getWallWithSecureId($wallSecureId)) {
			$this->errorControl->addError("Invalid Wall secure ID", "InvalidWallSecureId");
			return false;
		}

		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "WallSecureId", $wall->secureId);
		$filter->addConditional($this->table, "MemberSecureId", $member->secureId);
		$this->setFilter($filter);

		return $this->getNext();
	}

	/**
	 * Remove bookmark
	 * @param Member $member
	 * @param string $wallSecureId
	 * @param boolean
	 */
	public function removeWallBookmark(Member $member, $wallSecureId) {
		if (!$wallBookmarkDataEntity = $this->getWallBookmarked($member, $wallSecureId)) {
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
	 * @param Member $member
	 * @return stdClass Activity
	 */
	public function getRecentWallActivity(Member $member) {
		$activity = new stdClass();
		$activity->bookmarks = $this->getWallBookmarksArray($member);
		$activity->recentWallParticipation = $this->getRecentWallParticipation($member);
		$activity->wallsCreatedByMember = $this->getWallsCreatedByMember($member);

		return $activity;
	}

	/**
	 * Get recent walls created by Member
	 * @param Member $member
	 * @param integer $limit
	 * @return array Walls member has created
	 */
	public function getWallsCreatedByMember(Member $member, $limit = 10) {
		$recentWalls = array();

		$wallControl = Factory::getWallControl();

		$filter = CoreFactory::getFilter();
		$filter->addConditional($wallControl->table, "MemberSecureId", $member->secureId);
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
	 * @param Member $member
	 * @param integer $limit
	 * @return array Walls member has featured on recently
	 */
	public function getRecentWallParticipation(Member $member, $limit = 10) {
		//TODO: Finish

		$recentActivity = array();
		$sql = <<<SQL
SELECT DISTINCT "Video"."WallSecureId"
	FROM "Video"
	WHERE "MemberSecureId" = '{$member->secureId}' AND
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