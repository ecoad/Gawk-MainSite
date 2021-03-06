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
			"email", "", FM_TYPE_EMAILADDRESS, 255, FM_STORE_ALWAYS, true,	FM_OPTIONS_UNIQUE);

		$this->fieldMeta["SecureId"] = new FieldMeta(
			"Secure ID", "", FM_TYPE_STRING, 50, FM_STORE_ALWAYS, false,	FM_OPTIONS_UNIQUE);

		$this->fieldMeta["Alias"] = new FieldMeta(
			"username", "", FM_TYPE_STRING, 20, FM_STORE_ALWAYS, false, FM_OPTIONS_UNIQUE);

		$this->fieldMeta["Password"] = new FieldMeta(
			"password", "", FM_TYPE_PASSWORD, 20, FM_STORE_ADD, true);

		$this->fieldMeta["FirstName"] = new FieldMeta(
			"first name", "", FM_TYPE_STRING, 50, FM_STORE_ALWAYS, true);

		$this->fieldMeta["LastName"] = new FieldMeta(
			"last name", "", FM_TYPE_STRING, 50, FM_STORE_ALWAYS, true);

		$this->fieldMeta["TermsAgreed"] = new FieldMeta(
			"terms", "t", FM_TYPE_BOOLEAN, null, FM_STORE_ALWAYS, true);

		$this->fieldMeta["ReceiveEmailUpdates"] = new FieldMeta(
			"Receive Email Updates", "f", FM_TYPE_BOOLEAN, 1, FM_STORE_ALWAYS, true);

		$this->fieldMeta["FacebookId"] = new FieldMeta(
			"Facebook ID", "", FM_TYPE_STRING, 500, FM_STORE_ALWAYS, true, FM_OPTIONS_UNIQUE);

		$this->fieldMeta["GawksPublic"] = new FieldMeta(
			"Gawks are Public", 0, FM_TYPE_INTEGER, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["GawksFavouritePublic"] = new FieldMeta(
			"Favourite Gawks are Public", 0, FM_TYPE_INTEGER, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Twitter"] = new FieldMeta(
			"twitter", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, true);

		$this->fieldMeta["Website"] = new FieldMeta(
			"website", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, true);

		$this->fieldMeta["Description"] = new FieldMeta(
			"description", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, true);

		$this->fieldMeta["Token"] = new FieldMeta(
			"token", "", FM_TYPE_STRING, null, FM_STORE_NEVER, true);

		$this->fieldMeta["ProfileVideoSecureId"] = new FieldMeta(
			"Profile Video SecureId", "", FM_TYPE_STRING, null, FM_STORE_NEVER, true);
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
			$memberDataEntity->setSiteRegisteredFieldMeta();
		}

		$memberDataEntity->validate();
		$memberDataEntity->set("Password", $member->password); //validate sha1 the password

		if ($member->facebookId == "") {
			if (!isset($member->confirmPassword) || ($member->confirmPassword == "")) {
				$this->application->errorControl->addError("'confirm password' must not be empty");
			} else {
				if ($member->password != $member->confirmPassword) {
					$this->application->errorControl->addError("passwords do no match");
				}
			}
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
		$filter->addConditional($this->table, "EmailAddress", $emailAddress, "ILIKE");
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
	 * @param string $secureId
	 * @return Member
	 */
	public function getMemberBySecureId($secureId) {
		if ($memberDataEntity = $this->getMemberDataEntityBySecureId($secureId)) {
			return $memberDataEntity->toObject();
		}
	}

	/**
	 * Update a member's profile
	 * @param CustomMemberDataEntity $memberDataEntity
	 * @param Member $updatedMemberData
	 * @return CustomMemberDataEntity
	 */
	public function updateProfile(CustomMemberDataEntity $memberDataEntity, array $profileData) {

		$textFields = array("Website", "Description", "Alias");
		foreach ($textFields as $textField) {
			if (isset($profileData[$textField])) {
				$memberDataEntity->set($textField, $profileData[$textField]);
			}
		}
		if (isset($profileData["RemoveProfileGawk"])) {
			$memberDataEntity->set("ProfileVideoSecureId", null);
		}

		if ($memberDataEntity->validate()) {
			foreach ($textFields as $textField) {
				$this->updateField($memberDataEntity, $textField, $memberDataEntity->get($textField));
			}
			if (isset($profileData["RemoveProfileGawk"])) {
				$this->updateField($memberDataEntity, "ProfileVideoSecureId", null);
			}
		}

		return $memberDataEntity;
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
				$fieldMetaKey = ucfirst($key);
				if (isset($this->fieldMeta[$fieldMetaKey])) {
					$memberDataEntity->set($fieldMetaKey, $value);
				}
			}
		}

		return $memberDataEntity;
	}

	/**
	 * Get Member by request URL
	 * @param string $requestUrl
	 * @return Member
	 */
	public function getMemberByRequestUrl($requestUrl, $includeFriends = false) {
		$requestPieces = explode("/", trim($requestUrl));
		$alias = $requestPieces[2];
		if (!$memberDataEntity = $this->getMemberDataEntityByAlias($alias)) {
			return false;
		}

		return $memberDataEntity->toObject(false, $includeFriends);
	}

	/**
	 * @param string $alias
	 * @return CustomMemberControl
	 */
	public function getMemberDataEntityByAlias($alias) {
		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "Alias", $alias, "ILIKE");
		$this->setFilter($filter);

		return $this->getNext();
	}

	/**
	 * @param string $alias
	 * @return Member
	 */
	public function getMemberByAlias($alias) {
		if ($member = $this->getMemberDataEntityByAlias($alias)) {
			return $member->toObject();
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Application/Atrox/Core/Data/DataControl::validate()
	 */
	public function validate(CustomMemberDataEntity $member) {
		$valid = parent::validate($member);

		if (($member->get("Alias") != "") && !preg_match('/^[\da-z-+]+$/', $member->get("Alias"))) {
			$this->errorControl->addError("'username' must be only a-Z, 0-9, and hyphens e.g. 'joe-bloggs', 'Ben33'", "InvalidAlias");
			$valid = false;
		}

		$member->set("Website",
			str_replace("http://", "", $member->get("Website")));

		return $valid;
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