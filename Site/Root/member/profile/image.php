<?php
require_once("Application/Bootstrap.php");
$urlParts = explode("/", $_SERVER["REQUEST_URI"]);
$memberAlias = $urlParts[2];
$imageDimensions = explode("x", $urlParts[5]);
$memberControl = Factory::getMemberControl();
if (!$member = $memberControl->getMemberByAlias($memberAlias)) {
	$application->displayErrorPage("/error/404.php", 404);
}

//if ($member->facebookId != "") {
//	header("Location: http://graph.facebook.com/elliot.coad/picture");
//	exit;
//}

$profileImagePath = "http://capa.clockhosting.com/resource/binary/frames/gk-fMUQgzDNI1.flv/frames-30.jpg";

header("Location: $profileImagePath");