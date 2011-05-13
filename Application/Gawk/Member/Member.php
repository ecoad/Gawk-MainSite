<?php
class Member {
	public $firstName = "";
	public $lastName = "";
	public $alias = "";
	public $facebookId = "";
	public $friends = "";
	public $wallBookmarks = "";
	public $password = "";
	public $emailAddress = "";
	public $token = "";
	public $secureId = "";
	public $profileVideoSecureId = "";
	public $profileVideoLocation = "";
	public $website = "";
	public $description = "";

	public function __construct($memberData = null) {
		if ($memberData) {
			$this->mapData($memberData);
		}
	}

	public function mapData($memberData) {
		foreach ((array)$memberData as $key => $value) {
			if (isset($this->$key)) {
				$this->$key = $value;
			}
		}
	}
}