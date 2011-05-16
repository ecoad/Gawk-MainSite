<?php
require_once("Application/Bootstrap.php");

$layout = CoreFactory::getLayout("Site/Template/Booth/Main.php");
$layout->set("Title", "Gawk Booth");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "record");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>

<h1>Let's Record!</h1>
<div class="column primary">
	<h2>Hit that button</h2>
	<p>
		Okay, so hopefully this is all fairly self-explanatory, really. <b>Hit the record button</b> to, er, record&hellip;
	</p>
	<p>
		Once that's done, you can watch your video to <b>make sure you're happy</b> with it &ndash; if you're not then you
		can choose to <b>re-record</b>.
	</p>
	<p>
		If you are, then <b>add it to the wall</b> and you're done!
	</p>
	<p>
		Or if you'd like to go back to the start, you <a href="welcome.php">can do so here<a/>&hellip;
	</p>
</div>
<div class="column secondary">
	<div id="gawk-container"></div>
</div>
<?php
$layout->start("JavaScript");
?>
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
		params.wmode = "transparent";

		swfobject.embedSWF("/resource/flash/GawkBooth.swf?v=@VERSION-NUMBER@", "gawk-container",
			"611", "458", "9.0.0", false, gawkFlashVars, params, {id: "gawk-swf"});
});
//]]>
	</script>
<?php
$layout->render();