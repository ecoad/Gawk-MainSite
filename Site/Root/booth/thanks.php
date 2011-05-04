<?php
require_once("Application/Bootstrap.php");

$layout = CoreFactory::getLayout("Site/Template/Booth/Main.php");
$layout->set("Title", "Gawk Booth");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div>
	<h1>Thanks</h1>
	<p>This page will redirect to the start shortly. Alternatively, <a href="welcome.php">go now</a></p>
</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript">
//<![CDATA[
setTimeout(function(){window.location = "/booth/welcome.php"; }, 5000);
//]]>
	</script>
<?php
$layout->render();