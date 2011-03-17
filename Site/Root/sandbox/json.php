<?php
require_once("Application/Bootstrap.php");
$application->contentType = "text/plain";

$httpRequest = CoreFactory::getHttpRequest();
		$httpRequest->setUrl("http://furnace.gawkwall.com/api/");

		$o = new stdClass();
		$o->name = "oink";

		$loginData = array(
			"Action" => "Member.RegisterMember",
			"MemberData" => addslashes(json_encode($o)));

		$httpRequest->setPostData($loginData);
		$response = $httpRequest->send();
		if (!$apiResponse = json_decode($response->body)) {
			var_dump($response); exit;
		}