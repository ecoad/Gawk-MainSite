<?php
require_once("Application/Bootstrap.php");

if ($application->parseSubmit() == "Enter") {
	$httpRequest = CoreFactory::getHttpRequest();
	$httpRequest->setUrl("http://clockgaming.com/save.php");

	$xml = <<<DATA
<save>
<game>FutureOfWebDesign2011GawkBooth</game>
<data>{$_POST["EmailAddress"]}</data>
</save>
DATA;
	$httpRequest->setRawPostData($xml);
	$httpRequest->addHeader("Content-type", "text/xml");
	$httpRequest->send();
	$application->redirect("record.php");
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