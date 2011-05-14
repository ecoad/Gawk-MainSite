<?php
require_once("Application/Bootstrap.php");

$layout = CoreFactory::getLayout("Site/Template/Booth/Main.php");
$layout->set("Title", "Gawk Booth");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "wall");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div id="gawk-container"></div>
<?php
//$layout->start("JavaScript");
?>
	<script type="text/javascript" src="/resource/js/jquery/jquery.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/swfobject/swfobject.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	gawkFlashVars = {
			apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
			wallId: "gawk"
		};

		var params = {};
		params.allowscriptaccess = "always";
		params.wmode = "direct";

		swfobject.embedSWF("/resource/flash/GawkBoothWall.swf?v=@VERSION-NUMBER@", "gawk-container",
			"1920", "1150", "10.0.0", false, gawkFlashVars, params, {id: "gawk-swf"});
});
//]]>
	</script>
<?php
$layout->render();