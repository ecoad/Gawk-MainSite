<html lang="en" >
	<head>
		<title>Gawk Wall</title>
	</head>
	<body style="background-color: #111111;">
<?php
require_once("Application/Bootstrap.php");
// The main page content goes here.
?>
		<div id="gawk-container"></div>
<?php
//$layout->start("JavaScript");
?>
		<script type="text/javascript" src="/resource/js/jquery/jquery.js?v=@VERSION-NUMBER@"></script>
		<link rel="stylesheet" type="text/css" href="/resource/css/base.css?v=@VERSION-NUMBER@" media="screen" />
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

		swfobject.embedSWF("/resource/flash/GawkBoothWallProjector.swf?v=@VERSION-NUMBER@", "gawk-container",
			"1024", "768", "10.0.0", false, gawkFlashVars, params, {id: "gawk-swf"});
});
//]]>
		</script>
	</body>
</html>