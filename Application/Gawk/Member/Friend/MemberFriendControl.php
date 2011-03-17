<?php
require_once "Atrox/Core/Data/Data.php";

class MemberFriendControl extends DataControl {
	public $table = "MemberFriend";
	public $key = "Id";
	public $sequence = "MemberFriend_Id_seq";
	public $defaultOrder = "Id";
	public $searchFields = array("Id");

	/**
	 * @param TokenCheck
	 */
	protected $tokenCheck;

	public function __construct() {
		parent::DataControl();

		$this->tokenCheck = Factory::getTokenCheck();
	}

	public function init() {
		$this->fieldMeta["Id"] = new FieldMeta(
			"Id", "", FM_TYPE_INTEGER, null, FM_STORE_NEVER, false);

		$this->fieldMeta["MemberSecureId"] = new FieldMeta(
			"Member Secure ID", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["FriendSecureId"] = new FieldMeta(
			"Friend Secure ID", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["DateCreated"] = new FieldMeta(
			"DateCreated", "", FM_TYPE_DATE, null, FM_STORE_NEVER, false);

		$this->fieldMeta["FriendFacebookId"] = new FieldMeta(
			"Friend Facebook ID", "", FM_TYPE_STRING, 500, FM_STORE_ALWAYS, true);
	}

//	public function syncFacebookFriends(CustomMemberDataEntity $member, Facebook $facebook) {
//		$friendFbIds = $facebook->api(array('method' => 'friends.getappusers'));
//		$currentFriendFbIds = $this->getFriendFbIds($member);
//
//		$newFriendFbIds = array_diff($friendFbIds, $currentFriendFbIds);
//
//		$memberControl = Factory::getMemberControl();
//
//		foreach ($newFriendFbIds as $friendFbId) {
//			if (!$friend = $memberControl->getMemberByFbId($friendFbId)) {
//				$friend = $memberControl->registerFacebookMember($friendFbId);
//			}
//
//			if ($friend) {
//				$this->addFriend($member, $friend);
//			}
//		}
//	}

//	public function getFriendFbIds(CustomMemberDataEntity $member) {
//		$filter = CoreFactory::getFilter();
//
//		$memberControl = Factory::getMemberControl();
//
//		$filter->addConditional($this->table, "MemberId", $member->get("Id"));
//		$filter->addJoin($this->table, "MemberId", $memberControl->table, "Id");
//		$filter->addConditional($memberControl->table, "FbId", null, "IS NOT");
//
//		$this->setFilter($filter);
//
//		$memberFriendFbIds = array();
//
//		while ($memberFriend = $this->getNext()) {
//			$memberFriendFbIds[] = $memberFriend->get("FriendFbId");
//		}
//
//		return $memberFriendFbIds;
//	}

	/**
	 * @param CustomMemberDataEntity $memberDataEntity
	 */
	public function getFriends(CustomMemberDataEntity $memberDataEntity) {
		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "MemberSecureId", $memberDataEntity->get("SecureId"));
		$filter->addOrder("DateCreated", true);

		$this->setFilter($filter);
	}

	/**
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @return array Friends
	 */
	public function getFriendsArray(CustomMemberDataEntity $memberDataEntity) {
		$this->getFriends($memberDataEntity);
		$friends = array();

		$memberControl = Factory::getMemberControl();
		while ($memberFriendDataEntity = $this->getNext()) {
			if ($memberDataEntity = $memberControl->getMemberDataEntityBySecureId($memberFriendDataEntity->get("FriendSecureId"))) {
				$friends[] = $memberDataEntity->toObject();
			}
		}

		return $friends;
	}

	/**
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param string $friendSecureId
	 * @return boolean True if successful
	 */
	public function addFriend(CustomMemberDataEntity $memberDataEntity, $friendSecureId) {
		$memberControl = Factory::getMemberControl();
		if (!$friendDataEntity = $memberControl->getMemberDataEntityBySecureId($friendSecureId)) {
			$this->errorControl->addError("Friend does not exist", "InvalidFriendSecureId");
			return false;
		}

		if ($this->isMemberAFriendOfMemberB($memberDataEntity->get("SecureId"), $friendDataEntity->get("SecureId"))) {
			$this->errorControl->addError("This member is already friends", "AlreadyFriends");
			return false;
		}

		$memberFriendDataEntity = $this->makeNew();
		$memberFriendDataEntity->set("MemberSecureId", $memberDataEntity->get("SecureId"));
		$memberFriendDataEntity->set("FriendSecureId", $friendDataEntity->get("SecureId"));
		$memberFriendDataEntity->set("FriendFacebookId", $friendDataEntity->get("FacebookId"));
		if ($memberFriendDataEntity->save()) {
			return true;
		}
	}

	/**
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param string $friendSecureId
	 * @return boolean True if successful
	 */
	public function removeFriend(CustomMemberDataEntity $memberDataEntity, $friendSecureId) {
		$memberControl = Factory::getMemberControl();
		if (!$friendDataEntity = $memberControl->getMemberDataEntityBySecureId($friendSecureId)) {
			$this->errorControl->addError("Friend does not exist", "InvalidFriendSecureId");
			return false;
		}

		if (!$memberFriendDataEntity = $this->getMemberAFriendOfMemberBDataEntity($memberDataEntity->get("SecureId"), $friendDataEntity->get("SecureId"))) {
			$this->errorControl->addError("Member A is not currently friends with member B", "NotFriends");
			return false;
		}

		if (!$this->delete($memberFriendDataEntity->get("Id"))) {
			$this->errorControl->addError("Unable to delete friendship", "UnableDeleteFriend");
			return false;
		}

		return true;
	}

	/**
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param string $friendSecureId
	 * @return boolean
	 */
	public function isFriend(CustomMemberDataEntity $memberDataEntity, $friendSecureId) {
		return $this->isMemberAFriendOfMemberB($memberDataEntity->get("SecureId"), $friendSecureId);
	}

	/**
	 * @param string $memberASecureId
	 * @param string $memberBSecureId
	 * @return boolean
	 */
	protected function isMemberAFriendOfMemberB($memberASecureId, $memberBSecureId) {
		if ($this->getMemberAFriendOfMemberBDataEntity($memberASecureId, $memberBSecureId)) {
			return true;
		}

		return false;
	}

	/**
	 * @param string $memberASecureId
	 * @param string $memberBSecureId
	 * @return CustomMemberDataEntity
	 */
	public function getMemberAFriendOfMemberBDataEntity($memberASecureId, $memberBSecureId) {
		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "MemberSecureId", $memberASecureId);
		$filter->addConditional($this->table, "FriendSecureId", $memberBSecureId);
		$this->setFilter($filter);

		return $this->getNext();
	}
}