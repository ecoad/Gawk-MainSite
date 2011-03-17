<?php
require_once("Application/Bootstrap.php");
require_once("Atrox/Core/Data/Validation.php");

$application->doNotStorePage();

if (!isset($_POST["Action"])) {
	if (isset($_GET["Action"])) {
		$_POST["Action"] = $_GET["Action"];
	} else {
		exit;
	}
}

$response = new stdClass();
$response->success = false;

$application->contentType = "text/plain";

switch($_POST["Action"]) {
	case "CheckPassword":
		if (Validation::isStrongPassword($_REQUEST["Password"])) {
			$response->success = true;
		} else {
			$response->message = "Must be at least 8 characters and a mixture of characters and digits.";
		}
		$response = json_encode($response);
		break;
}
echo $response;