<?php
require_once("Application/Bootstrap.php");
$application->contentType = "text/plain";
$application->doNotStorePage();

$response = new stdClass();
$response->success = false;
$response->errors = array();
if (!isset($_REQUEST["Action"])) {
	var_dump($_REQUEST); exit;
}
$method = explode(".", $_REQUEST["Action"]);

$memberWebservice = Factory::getMemberWebService();
$memberWallBookmarkWebservice = Factory::getMemberWallBookmarkWebService();
$memberFriendWebservice = Factory::getMemberFriendWebService();
$wallWebservice = Factory::getWallWebService();
$videoWebservice = Factory::getVideoWebService();

switch ($method[0]) {
	case "Member":
		$response = $memberWebservice->handleRequest($method[1], $_POST, $_GET);
		break;
	case "MemberFriend":
		$response = $memberFriendWebservice->handleRequest($method[1], $_POST, $_GET);
		break;
	case MemberWallBookmarkWebService::SERVICE_NAME_SPACE: //MemberWallBookmark
		$response = $memberWallBookmarkWebservice->handleRequest($method[1], $_POST, $_GET);
		break;
	case WallWebService::SERVICE_NAME_SPACE: //Wall
		$response = $wallWebservice->handleRequest($method[1], $_POST, $_GET);
		break;
	case "Video":
		$response = $videoWebservice->handleRequest($method[1], $_POST, $_GET, $_FILES);
		break;
	case "Flash":
		$response = $flashWebservice->handleRequest($method[1], $_POST, $_GET);
		break;
	default:
		$response->errors[] = "Unknown method: " . $_REQUEST["Action"];
		break;
}

echo json_encode($response);