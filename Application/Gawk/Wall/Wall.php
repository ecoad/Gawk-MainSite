<?php
class Wall {
	public $secureId = "";
	public $memberSecureId = "";
	public $url = "";
	public $description = "";
	public $dateCreated = "";
	public $publicView = false;
	public $publicGawk = false;

	public function __construct($wallData = null) {
		if ($wallData) {
			$this->mapData($wallData);
		}
	}

	public function mapData($wallData) {
		foreach ((array)$wallData as $key => $value) {
			if (isset($this->$key)) {
				$this->$key = $value;
			}
		}
	}
}