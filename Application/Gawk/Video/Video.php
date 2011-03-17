<?php
class Video {
	public $secureId = "";
	public $filename = "";
	public $memberSecureId = "";
	public $wallSecureId = "";
	public $hash = "";
	public $uploadSource = "";
	public $approved = false;
	public $rating = 0;
	public $dateCreated = "";

	public function __construct($videoData = null) {
		if ($videoData) {
			$this->mapData($videoData);
		}
	}

	public function mapData($videoData) {
		foreach ((array)$videoData as $key => $value) {
			if (isset($this->$key)) {
				$this->$key = $value;
			}
		}
	}
}