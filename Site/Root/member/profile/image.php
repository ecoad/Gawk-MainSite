<?php
require_once("Application/Bootstrap.php");
$urlParts = explode("/", $_SERVER["REQUEST_URI"]);
$memberSecureId = $urlParts[2];
$imageDimensions = explode("x", $urlParts[5]);
$ads = Factory::getMemberControl();
/*
$memberControl = Factory::getMemberControl();
if ($memberDataEntity = $memberControl->getMemberDataEntityBySecureId($memberSecureId)) {
	$profileImagePath = "http://capa.clockhosting.com/resource/binary/frames/test-gawk/frames-30.jpeg";
}
*/
$profileImagePath = "http://capa.clockhosting.com/resource/binary/frames/test-gawk/frames-30.jpeg";
//$profileImageHandle = fopen($profileImagePath, "rb");

header('Content-Type: image/png');
readfile($profileImagePath);