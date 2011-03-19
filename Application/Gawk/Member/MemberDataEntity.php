
<?php
require_once "Application/Atrox/Base/Member/Member.php";
class CustomMemberDataEntity extends MemberDataEntity {

	/**
	 * @return Member
	 **/
	function toObject($includePassword = false) {
		$array = array();
		foreach ($this->data as $k => $v) {
			switch($this->control->fieldMeta[$k]->type) {
				case FM_TYPE_BOOLEAN:
					$v = $v == "t" || $v === true || $v == "true";
					break;
			}
			$array[lcfirst($k)] = $v;
		}

		if (!$includePassword) {
			unset($array["Password"]);
		}

		$member = Factory::getMember((object)$array);
		if ($member->profileVideoSecureId != "") {
			$videoControl = Factory::getVideoControl();
			if ($videoDataEntity = $videoControl->itemByField($member->profileVideoSecureId, "SecureId")) {
				$member->profileVideoLocation = $videoDataEntity->get("Filename");
			}
		}
		return $member;
	}

	/**
	 * Set the Field Meta for a Facebook registered member
	 */
	public function setFacebookRegisteredFieldMeta() {
		$this->control->init();
		$this->control->fieldMeta["FacebookId"]->allowNull = false;
		$this->control->fieldMeta["Password"]->allowNull = true;
	}

	/**
	 * Set the Field Meta for a Site registered member
	 */
	public function setSiteRegisterdFieldMeta() {
		$this->control->init();
		$this->control->fieldMeta["EmailAddress"]->allowNull = false;
		$this->control->fieldMeta["Password"]->allowNull = false;
	}
}