<?php
class VideoFileUpload {

	/**
	 * @var VideoControl
	 */
	protected $videoControl;

	/**
	 * @param VideoControl $videoControl
	 * @param array $filesData
	 * @param string $sourceDevice
	 */
	public function saveFile(VideoControl $videoControl, array $filesData, $sourceDevice) {
		$this->videoControl = $videoControl;

		switch ($sourceDevice) {
			case VideoControl::SOURCE_IPHONE:
				$fileName = $this->mapIphoneUpload($filesData["VideoFile"]);
				break;
			case VideoControl::SOURCE_HTML:
				$fileName = $this->mapHtmlUpload($filesData["VideoFile"]);
				break;
			case VideoControl::SOURCE_ANDROID:
				$fileName = $this->mapAndroidUpload($filesData["VideoFile"]);
				break;
			default:
				$this->videoControl->errorControl->addError("Unknown source type", "InvalidSource");
				break;
		}

		return $fileName;
	}

	protected function mapIphoneUpload(array $fileData) {
		$fileName = $this->moveTemporaryFile($fileData["tmp_name"], $fileData["type"]);
		$fileLocation = $this->videoControl->application->registry->get("Binary/Path") . "/";

		$fullPathFile = $fileLocation . $fileName;

		$newFileName = substr($fileName, 0, strripos($fileName, ".")) . ".mp4";
		$fullPathNewFile = $fileLocation . $newFileName;

		shell_exec("ffmpeg -i $fullPathFile -f mp4 -vcodec copy -acodec copy $fullPathNewFile");
		unlink($fullPathFile);

		return $newFileName;
	}

	protected function mapHtmlUpload(array $fileData) {
		return $this->moveTemporaryFile($fileData["tmp_name"], $fileData["type"]);
	}

	protected function mapAndroidUpload(array $fileData) {
		throw new Exception("Android not implemented");
		//return $this->moveTemporaryFile($fileData["tmp_name"], $fileData["type"]);
	}

	protected function moveTemporaryFile($temporaryName, $fileMimeType) {
		if (file_exists($temporaryName)) {
			$fileName = $this->videoControl->getRandomSecureId() . "." . $this->videoControl->getFileExtensionByMimeType($fileMimeType);
			$fileLocation = $this->videoControl->application->registry->get("Binary/Path") . "/" .	$fileName;

			move_uploaded_file($temporaryName, $fileLocation);

			return $fileName;
		} else {
			$this->videoControl->errorControl->addError("Cannot find temporary file: " . $temporaryName);
		}
	}
}