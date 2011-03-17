<?php
require_once("Application/Bootstrap.php");

$application->doNotStorePage();

if (!isset($_POST["Action"])) {
	if (isset($_GET["Action"])) {
		$_POST["Action"] = $_GET["Action"];
	} else {
		exit;
	}
}

$application->contentType = "text/plain";
switch ($_POST["Action"]) {
	case "Load":
		$response = new stdClass();
		$response->success = false;
		if ($_REQUEST["Id"] != "") {
			$excludeTags = array();
			if (isset($_GET["Exclude"])) {
				$excludeTags = explode(";", $_GET["Exclude"]);
			}
			$tagToDataControl = BaseFactory::getTagToDataControl();
			$htmlControl = CoreFactory::getHtmlControl();
			$_GET = $htmlControl->sanitise($_GET);
			$tagToDataControl->retrieveTagsForEntities($_GET["Id"], $_GET["Type"]);
			$response->data = array();
			while ($tagToData = $tagToDataControl->getNext()) {
				if (!in_array($tagToData->get("Tag"), $excludeTags)) {
					$response->data[] = $tagToData->get("Tag");
				}
			}
			$response->success = true;
			$response = json_encode($response);
		}
		break;
	case "ListAutoCompleteTags":
		$tagControl = BaseFactory::getTagControl();
		$tagControl->search($_POST["TagField"]);
		$response = "<ul>";
		//Only show ten matches
		$stringControl = CoreFactory::getString();
		while ($tag = $tagControl->getPage(1, 10)) {
			$response .= "<li>" . $stringControl->caseInsensitiveWrap($_POST["TagField"], $tag->get("Tag"), "<strong>", "</strong>") . "</li>";
		}
		$response .= "</ul>";
		break;
	case "UpdateSetting":
		$response = new stdClass();
		$response->success = false;
		$application->securityControl->getSetting($_POST["Setting"], $_POST["Value"], "f");
		$response->success = true;
		$response = json_encode($response);
		break;
}
echo $response;