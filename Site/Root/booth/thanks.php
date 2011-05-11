<?php
require_once("Application/Bootstrap.php");

$layout = CoreFactory::getLayout("Site/Template/Booth/Main.php");
$layout->set("Title", "Gawk Booth");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "thanks");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>

<h1>You're on the wall!</h1>
<div class="column primary">
	<h2>Thanks for taking part</h2>
	<p>
		It's been a <b>pleasure</b>, and we hope you've enjoyed it too. You can go outside and <b>see your Gawk</b> on the wall with all the others.
	</p>
	<p>
		We'll be in touch to let you know if you're the <b>lucky winner</b>. Don't forget to follow <b>@clock</b> on Twitter to find out first.
	</p>
	<p>
		This page will redirect <b>back to the start</b> shortly, but if you'd like to <a href="welcome.php">go there now, you can</a>.
	</p>
</div>
<div class="column secondary">
	<img src="/resource/image/booth/ipad.png" alt="Sketch of an iPad" />
</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript">
//<![CDATA[
setTimeout(function(){window.location = "/booth/welcome.php"; }, 30000);
//]]>
	</script>
<?php
$layout->render();