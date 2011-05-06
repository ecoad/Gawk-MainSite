<?php
require_once "Atrox/Core/Data/Data.php";
require_once "Gawk/Video/VideoDataEntity.php";

class VideoControl extends DataControl {
	public $table = "Video";
	public $key = "Id";
	public $sequence = "Video_Id_seq";
	public $defaultOrder = "Id";
	public $searchFields = array("Id");

	const SOURCE_FLASH = "flash";
	const SOURCE_IPHONE = "iphone";
	const SOURCE_HTML = "html";
	const SOURCE_ANDROID = "android";

	public function init() {
		$this->fieldMeta["Id"] = new FieldMeta(
			"Id", "", FM_TYPE_INTEGER, null, FM_STORE_NEVER, false);

		$this->fieldMeta["SecureId"] = new FieldMeta(
			"Secure ID", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["WallSecureId"] = new FieldMeta(
			"Wall Secure ID", "main", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["MemberSecureId"] = new FieldMeta(
			"Member Secure ID", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Filename"] = new FieldMeta(
			"Filename", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["DateCreated"] = new FieldMeta(
			"DateCreated", "", FM_TYPE_DATE, null, FM_STORE_NEVER, false);

		$this->fieldMeta["Approved"] = new FieldMeta(
			"Approved", "t", FM_TYPE_BOOLEAN, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Banned"] = new FieldMeta(
			"Banned", "", FM_TYPE_BOOLEAN, null, FM_STORE_ALWAYS, true);

		$this->fieldMeta["IpAddress"] = new FieldMeta(
			"IP Address", "", FM_TYPE_IP, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["UploadSource"] = new FieldMeta(
			"Upload Source", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Rating"] = new FieldMeta(
			"Rating", 0, FM_TYPE_INTEGER, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Hash"] = new FieldMeta(
			"Hash", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);
	}

	public function saveVideo(Video $video, array $filesData = null) {
		$wallControl = Factory::getWallControl();

		$wallId = $video->wallSecureId ? $video->wallSecureId : "main";

		if (!$wall = $wallControl->itemByField($wallId, "SecureId")) {
			$this->errorControl->addError("Wall not found: {$video->wallSecureId}");
			return false;
		}

		if ($video->uploadSource == self::SOURCE_FLASH) {
			// Wowza places FLV in correct location
		} else {
			$videoFileUpload = Factory::getVideoFileUpload();
			if (!$fileName = $videoFileUpload->saveFile($this, $filesData, $video->uploadSource)) {
				return false;
			}
			$video->filename = $fileName;
		}

		$videoDataEntity = $this->mapVideoToVideoDataEntity($video);
		if ($videoDataEntity->save()) {
			return $videoDataEntity;
		}
	}

	public function validateHash(VideoDataEntity $video) {
		$hash = sha1_file($this->application->registry->get("Binary/Path") . "/" . $video->get("Filename"));
		if ($hash != $video->get("Hash")) {
			$this->errorControl->addError("Hash does not match", "InvalidHash");
			return false;
		}
		return true;
	}

	/**
	 * Map a Video to VideoDataEntity
	 * @param Video $video
	 * @param VideoDataEntity $videoDataEntity
	 * @return VideoDataEntity
	 */
	public function mapVideoToVideoDataEntity(Video $video, VideoDataEntity $videoDataEntity = null) {
	if (!$videoDataEntity) {
			$videoDataEntity = $this->makeNew();
		}
		foreach ((array)$video as $key => $value) {
			if (($value !== null) && ($value !== "") && is_scalar($value)) {
				$videoDataEntity->set(ucfirst($key), $value);
			}
		}

		return $videoDataEntity;
	}

	public function makeNew() {
		$videoDataEntity = parent::makeNew();
		$videoDataEntity->set("SecureId", $this->getRandomSecureId());
		return $videoDataEntity;
	}

	public function isVideoFilePresent($fileName) {
		return file_exists($this->application->registry->get("Binary/Path") . "/" . $fileName);
	}

	public function getRandomSecureId() {
		return uniqid();
	}

	public function getFileExtensionByMimeType($mimeType) {
		switch ($mimeType) {
			case "video/quicktime":
				return "mov";
			case "video/x-flv":
				return "flv";
			case "video/mp4":
				return "mp4";
			default:
				$this->errorControl->addError("Unsupported mime type $mimeType");
				break;
		}
	}

	public function deleteBySecureId($secureId) {
		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "SecureId", $secureId);
		$this->setFilter($filter);

		if ($video = $this->getNext()) {
			$this->delete($video->get("Id"));
			return true;
		}

		return false;
	}

	public function getNext() {
		if ($video = parent::getNext()) {
			if ($this->isVideoFilePresent($video->get("Filename"))) {
				return $video;
			} else {
				$this->updateField($video, "Approved", "f");
			}
		}
	}

	public function getDataEntity() {
		return new VideoDataEntity($this);
	}
}