<?php
/**
 * @package Gawk
 * @subpackage Member
 * @copyright Clock Limited 2010
 * @version @VERSION-NUMBER@
 */

/**
 * Include Data.php so that DataControl can be extended.
 * Include DataEntity.php so that DataEntity can be extended.
 */
require_once "Atrox/Base/Member/Member.php";
require_once "Gawk/Member/MemberDataEntity.php";

/**
 *
 * @author Elliot Coad {@link mailto:elliot.coad@clock.co.uk}
 * @copyright Clock Limited 2010
 * @version @VERSION-NUMBER@
 * @package Gawk
 * @subpackage Member
 */
class CustomMemberControl extends MemberControl {
	/**
	 * @see Application/Atrox/Base/Member/MemberControl::init()
	 */
	public function init() {
		parent::init();

		$this->fieldMeta["EmailAddress"] = new FieldMeta(
			"E-mail Address", "", FM_TYPE_EMAILADDRESS, 255, FM_STORE_ALWAYS, true,	FM_OPTIONS_UNIQUE);

		$this->fieldMeta["SecureId"] = new FieldMeta(
			"Secure ID", "", FM_TYPE_STRING, 50, FM_STORE_ALWAYS, false,	FM_OPTIONS_UNIQUE);

		$this->fieldMeta["Alias"] = new FieldMeta(
			"Name", "", FM_TYPE_STRING, 20, FM_STORE_ALWAYS, false, FM_OPTIONS_UNIQUE);

		$this->fieldMeta["Password"] = new FieldMeta(
			"Password", "", FM_TYPE_PASSWORD, 20, FM_STORE_ADD, true);

		$this->fieldMeta["FirstName"] = new FieldMeta(
			"First Name", "", FM_TYPE_STRING, 50, FM_STORE_ALWAYS, true);

		$this->fieldMeta["LastName"] = new FieldMeta(
			"Last Name", "", FM_TYPE_STRING, 50, FM_STORE_ALWAYS, true);

		$this->fieldMeta["TermsAgreed"] = new FieldMeta(
			"Terms Agreed", "t", FM_TYPE_BOOLEAN, null, FM_STORE_ALWAYS, true);

		$this->fieldMeta["ReceiveEmailUpdates"] = new FieldMeta(
			"Receive Email Updates", "f", FM_TYPE_BOOLEAN, 1, FM_STORE_ALWAYS, true);

		$this->fieldMeta["FacebookId"] = new FieldMeta(
			"Facebook ID", "", FM_TYPE_STRING, 500, FM_STORE_ALWAYS, true, FM_OPTIONS_UNIQUE);

		$this->fieldMeta["GawksPublic"] = new FieldMeta(
			"Gawks are Public", 0, FM_TYPE_INTEGER, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["GawksFavouritePublic"] = new FieldMeta(
			"Favourite Gawks are Public", 0, FM_TYPE_INTEGER, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Twitter"] = new FieldMeta(
			"Twitter", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, true);

		$this->fieldMeta["Token"] = new FieldMeta(
			"Token", "", FM_TYPE_STRING, null, FM_STORE_NEVER, true);

		$this->fieldMeta["ProfileVideoSecureId"] = new FieldMeta(
			"Token", "", FM_TYPE_STRING, null, FM_STORE_NEVER, true);
	}

	/**
	 * Register a Member
	 * @param Member $memberData
	 * @return CustomMemberDataEntity $member
	 */
	public function registerMember(Member $member) {
		$memberDataEntity = $this->mapMemberToMemberDataEntity($member);
		if ($memberDataEntity->get("FacebookId") !== "") {
			$memberDataEntity->setFacebookRegisteredFieldMeta();
		} else {
			$memberDataEntity->setSiteRegisterdFieldMeta();
		}

		if ($memberDataEntity->save()) {
			$memberAuthentication = Factory::getMemberAuthentication();
			$memberAuthentication->setAuthenticatedSession($memberDataEntity);
			return $memberDataEntity;
		}
	}

	/**
	 * @param MemberDataEntity $memberDataEntity
	 * @param string $videoSecureId
	 * @return MemberDataEntity $memberDataEntity
	 */
	public function setProfileVideoGawk(MemberDataEntity $memberDataEntity, $videoSecureId) {
		$videoControl = Factory::getVideoControl();
		if ($videoDataEntity = $videoControl->itemByField($videoSecureId, "SecureId")) {
			$memberDataEntity->set("ProfileVideoDataEntity", $videoDataEntity->get("SecureId"));
			if ($this->updateField($memberDataEntity, "ProfileVideoSecureId", $memberDataEntity->get("ProfileVideoSecureId"))) {
				return $memberDataEntity;
			}
		}
	}

	public function getMemberDataEntityByEmailAddressPassword($emailAddress, $password) {
		$this->reset();
		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "EmailAddress", $emailAddress);
		$filter->addConditional($this->table, "Password", sha1($password));
		$this->setFilter($filter);

		return $this->getNext();
	}

	/**
	 * @param string $token
	 * @param boolean $useCache
	 * @return CustomMemberDataEntity
	 */
	public function getMemberDataEntityByToken($token, $useCache = true) {
		return $this->itemByField($token, "Token", "", false, $useCache);
	}

	/**
	 * @param string $facebookId
	 * @return CustomMemberDataEntity
	 */
	public function getMemberDataEntityByFacebookId($facebookId) {
		return $this->itemByField($facebookId, "FacebookId");
	}

	/**
	 * @param string $secureId
	 * @return CustomMemberDataEntity
	 */
	public function getMemberDataEntityBySecureId($secureId) {
		return $this->itemByField($secureId, "SecureId");
	}

	/**
	 * Update a member's profile
	 * @param stdClass $memberData
	 * @return boolean True if successfully
	 * @deprecated
	 */
	public function updateProfile(stdClass $memberData) {
		$memberAuthentication = Factory::getMemberAuthentication();
		if ($member = $memberAuthentication->getLoggedInUser()) {
			$member->set("GawksPublic", $memberData->privacy->gawksPublic);
			$member->set("GawksFavouritePublic", $memberData->privacy->gawksFavouritePublic);

			return (boolean)$member->save();
		} else {
			$this->application->errorControl->addError("Member not logged in");
		}
	}

	/**
	 * Map a member to Member DataEntity
	 * @param Member $member
	 * @param MemberDataEntity $memberDataEntity
	 * @return MemberDataEntity
	 */
	public function mapMemberToMemberDataEntity(Member $member, MemberDataEntity $memberDataEntity = null) {
		if (!$memberDataEntity) {
			$memberDataEntity = $this->makeNew();
		}
		foreach ((array)$member as $key => $value) {
			if (($value !== null) && ($value !== "")) {
				$memberDataEntity->set(ucfirst($key), $value);
			}
		}
		return $memberDataEntity;
	}

	/**
	 * Get Member by request URL
	 * @param string $requestUrl
	 * @return Member
	 */
	public function getMemberByRequestUrl($requestUrl) {
		$alias = substr($requestUrl, 3);
		if (!$memberDataEntity = $this->itemByField($alias, "Alias")) {
			return false;
		}

		return $memberDataEntity->toObject();
	}

	public function afterInsert(DataEntity $dataEntity) {
	}

	public function afterUpdate(DataEntity $dataEntity) {
	}

	/**
	 * @see Application/Atrox/Base/Member/MemberControl::getDataEntity()
	 */
	public function getDataEntity() {
		return new CustomMemberDataEntity($this);
	}

	public function makeNew() {
		$memberDataEntity = parent::makeNew();
		$memberDataEntity->set("SecureId", uniqid("u-"));

		return $memberDataEntity;
	}
}