<?php
$fileLocation = "/var/application/Gawk/MainSite/";

ini_set("include_path",
	// Site specific includes
	$fileLocation . PATH_SEPARATOR .
	$fileLocation . "Application/" . PATH_SEPARATOR .
	$fileLocation . "Test/PHPUnit/" . PATH_SEPARATOR .
	PEAR_INSTALL_DIR
);

require_once("Application/Bootstrap.php");
$wallControl = Factory::getWallControl();
$videoControl = Factory::getVideoControl();
$memberControl = Factory::getMemberControl();

$john =  shell_exec("ls -la /var/data/application/Gawk/MainSite/Binary/");
$johnBits = explode("\n", $john);

$i = 0;

$memberDataEntity = $memberControl->item(485);
$member = $memberDataEntity->toObject();

foreach ($johnBits as $ls) {

	$fileName = substr($ls, 59);
	if ((strlen($fileName) > 5) && (strpos($fileName, ".") != false)) {

		if (($i % 30) == 0) {
			$wallIndex = $i / 30;
			echo "Creating wall" . PHP_EOL;
			$wallDataEntity = $wallControl->makeNew();
			$wallDataEntity->set("Description", "gawks from the archive: $wallIndex");
			$wallDataEntity->set("Name", "Auto Wall $wallIndex");
			$wallDataEntity->set("Url", "auto-wall-$wallIndex");
			$wallDataEntity->set("MemberSecureId", $member->secureId);

			if (!$wallDataEntity->save()) {
				var_dump($application->errorControl->getErrors()); exit;
			}
		}
		echo $fileName . PHP_EOL;
		$videoDataEntity = $videoControl->makeNew();
		$videoDataEntity->set("Filename", $fileName);
		$videoDataEntity->set("Approved", "f");
		$videoDataEntity->set("MemberSecureId", $member->secureId);
		$videoDataEntity->set("WallSecureId", $wallDataEntity->get("SecureId"));
		$videoDataEntity->set("IpAddress", "127.0.0.1");
		$videoDataEntity->set("UploadSource", "Unknown");
		$videoDataEntity->set("Hash", "Unknown");

		if (!$videoDataEntity->save()) {
			var_dump($application->errorControl->getErrors()); exit;
		}

		$i++;


	}
}

var_dump(count($johnBits)); exit;