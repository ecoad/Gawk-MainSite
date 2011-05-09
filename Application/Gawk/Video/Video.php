<?php
require_once "Gawk/Member/Member.php";

class Video {
	public $secureId = "";
	public $filename = "";
	public $wallSecureId = "";
	public $memberSecureId = "";
	/**
	 * @var Member
	 */
	public $member = null;
	public $hash = "";
	public $uploadSource = "";
	public $approved = false;
	public $rating = 0;
	public $dateCreated = "";
	public $newVideoAfterInit = false;

	public function __construct($videoData = null) {
		$this->member = new Member();
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