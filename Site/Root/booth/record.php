<?php
require_once("Application/Bootstrap.php");

	$httpRequest = CoreFactory::getHttpRequest();
	$httpRequest->setUrl("http://clockgaming.com/save.php");
	$httpRequest->setPostData(array("Game" => "FutureOfWebDesignCompetition2011", "Data" => "sdf@sdf.com"));

	$xml = <<<DATA
<?xml version="1.0" encoding="UTF-8" ?>
<item>
<game>FutureOfWebDesignCompetition2011</game>
<data>elliot@clock.co.uk</data>
</item>
DATA;


			$p = xml_parser_create();
		$vals = "";
		$index = "";
		xml_parse_into_struct($p, $xml, $vals, $index);
		xml_parser_free($p);
		var_dump($vals); exit;

	exit;


	$httpRequest->setRawPostData($xml);
	$response = $httpRequest->send();
	var_dump($response); exit;
if ($application->parseSubmit() == "Enter") {
	$_POST["EmailAddress"];
}

$layout = CoreFactory::getLayout("Site/Template/Booth/Main.php");
$layout->set("Title", "Gawk Booth");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div>
	<h1>Welcome to the Booth</h1>
	<p>Introduction to why you are in a wooden box&hellip;</p>

	<form action="" method="post">
		<div class="invalid-email-address" style="display: none;">
			Please enter a valid email address and try again.
		</div>
		Enter your email address: <input name="EmailAddress" type="text" /> <input type="submit" name="Submit" value="Enter"/>
	</form>
</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript" src="/resource/js/application/gawk/booth/booth-control.js"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var boothControl = new BoothControl();
});
//]]>
	</script>
<?php
$layout->render();