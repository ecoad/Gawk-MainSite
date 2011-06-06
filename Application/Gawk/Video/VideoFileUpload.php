<?php
class VideoFileUpload {

	/**
	 * @var VideoControl
	 */
	protected $videoControl;

	/**
	 * @param Video $video
	 * @param VideoControl $videoControl
	 * @param array $filesData
	 * @param string $sourceDevice
	 */
	public function saveFile(Video $video, VideoControl $videoControl, array $filesData, $sourceDevice) {
		$this->videoControl = $videoControl;

		switch ($sourceDevice) {
			case VideoControl::SOURCE_FLASH:
				$fileName = $video->filename;
				break;
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
				return;
				break;
		}

		$this->createVideoStills($fileName);

		return $fileName;
	}

	public function optimiseFlashVideo(VideoControl $videoControl, Video $video) {
		return $video->filename; //Temporary
		$fileLocation = $videoControl->application->registry->get("Binary/Path") . "/";

		$fullPathFile = $fileLocation . $video->filename;

		$newFileName = substr($video->filename, 0, strripos($video->filename, ".")) . ".mp4";
		$fullPathNewFile = $fileLocation . $newFileName;

		shell_exec("ffmpeg -i $fullPathFile -s 320x230 -an -vcodec libx264 -vpre hq -crf 22 -threads 0 $fullPathNewFile");

		unlink($fullPathFile);

		return $newFileName;
	}

	protected function mapIphoneUpload(array $fileData) {
		$fileName = $this->moveTemporaryFile($fileData["tmp_name"], $fileData["type"]);
		$fileLocation = $this->videoControl->application->registry->get("Binary/Path") . "/";

		$fullPathFile = $fileLocation . $fileName;

		$newFileName = substr($fileName, 0, strripos($fileName, ".")) . ".mp4";
		$fullPathNewFile = $fileLocation . $newFileName;

		shell_exec("ffmpeg -i $fullPathFile -s 320x230 -an -vcodec libx264 -vpre hq -crf 22 -threads 0 $fullPathNewFile");
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

	protected function createVideoStills($filename) {
		$application = CoreFactory::getApplication();

		$stillsLocation = $application->registry->get("Binary/Path") . "/frames/" . $filename;

		$mkdirCommand = "ssh -p 17510 " . $application->registry->get("MediaServer/Location") .
			" ' mkdir -p $stillsLocation '";
		$exitCode = shell_exec($mkdirCommand .  " > /dev/null; $?");

		if ($exitCode != 0) {
			throw new Exception("Unable to mkdir: " . $mkdirCommand);
		}

		$videoLocation = $application->registry->get("Binary/Path") . "/" . $filename;
		$dimensions = $application->registry->get("Video/Dimensions");

		$splitVideoCommand = "ssh -p 17510 " . $application->registry->get("MediaServer/Location") .
			" 'ffmpeg -i $videoLocation -r 15 -s {$dimensions[0]}x{$dimensions[1]} -f image2 {$stillsLocation}/frames-%d.jpg'";

		//echo $mkdirCommand, " ... ", $splitVideoCommand; exit;

		$exitCode = shell_exec($splitVideoCommand . " > /dev/null; $?");

		if ($exitCode != 0) {
			throw new Exception("Error with: " . $splitVideoCommand);
		}
	}
}