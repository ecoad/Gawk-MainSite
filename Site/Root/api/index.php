<?php
require_once("Application/Bootstrap.php");
$application->contentType = "text/plain";
$application->doNotStorePage();

$response = new stdClass();
$response->success = false;
$response->errors = array();
$method = explode(".", $_REQUEST["Action"]);

$memberWebService = Factory::getMemberWebService();
$memberWallBookmarkWebService = Factory::getMemberWallBookmarkWebService();
$memberFriendWebService = Factory::getMemberFriendWebService();
$wallWebService = Factory::getWallWebService();
$videoWebService = Factory::getVideoWebService();
$flashWebService = Factory::getFlashWebService();

switch ($method[0]) {
	case "Member":
		$response = $memberWebService->handleRequest($method[1], $_POST, $_GET);
		break;
	case "MemberFriend":
		$response = $memberFriendWebService->handleRequest($method[1], $_POST, $_GET);
		break;
	case MemberWallBookmarkWebService::SERVICE_NAME_SPACE: //MemberWallBookmark
		$response = $memberWallBookmarkWebService->handleRequest($method[1], $_POST, $_GET);
		break;
	case WallWebService::SERVICE_NAME_SPACE: //Wall
		$response = $wallWebService->handleRequest($method[1], $_POST, $_GET);
		break;
	case "Video":
		$response = $videoWebService->handleRequest($method[1], $_POST, $_GET, $_FILES);
		break;
	case FlashWebService::SERVICE_NAME_SPACE:
		$response = $flashWebService->handleRequest($method[1], $_POST, $_GET);
		break;
	default:
		$response->errors[] = "Unknown method: " . $_REQUEST["Action"];
		break;
}

echo json_encode($response);