<?php
require_once "Application/Atrox/Base/Member/Member.php";
class CustomMemberDataEntity extends MemberDataEntity {

	/**
	 * @return Member
	 **/
	function toObject($includePassword = false, $includeFriends = false) {
		$array = array();
		foreach ($this->data as $k => $v) {
			switch($this->control->fieldMeta[$k]->type) {
				case FM_TYPE_BOOLEAN:
					$v = $v == "t" || $v === true || $v == "true";
					break;
			}
			$array[lcfirst($k)] = $v;
		}

		unset($array["confirmPassword"]);
		if (!$includePassword) {
			unset($array["password"]);
		}

		$member = Factory::getMember((object)$array);

		if ($includeFriends) {
			$memberFriendControl = Factory::getMemberFriendControl();
			$friends = $memberFriendControl->getFriendsArray($member);
			$member->friends = $friends;
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
	public function setSiteRegisteredFieldMeta() {
		$this->control->init();
		$this->control->fieldMeta["EmailAddress"]->allowNull = false;
		$this->control->fieldMeta["Password"]->required = FM_STORE_ALWAYS;
		$this->control->fieldMeta["Password"]->allowNull = false;
	}

	/**
	 * @return string URL
	 */
	public function getUrl() {
		return "/u/" . $this->get("Alias");
	}
}