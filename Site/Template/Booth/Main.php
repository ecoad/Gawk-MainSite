<?php
$application = CoreFactory::getApplication();
?>
<!DOCTYPE html>
<html lang="en" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title><?php echo $this->get("Title"); ?></title>
		<meta name="imagetoolbar" content="no" />
		<meta name="description" content="<?php echo $application->registry->get("Description"); ?>" />
		<meta name="keywords" content="" />
		<meta charset="utf-8" />

		<link rel="shortcut icon" href="/favicon.ico?v=@VERSION-NUMBER@" />
<?php
$cssAggregator = CoreFactory::getCssAggregator(
	$application->registry->get("Path") . "/Site/Root",
	$application->registry->get("Cache/Resource/Path"),
	"/resource/cache/resource");

if ($_SESSION["Style"] != "high-contrast") {
	// If you need to add stylesheets add them below.
	$cssAggregator->collect(
		array(
			"/resource/css/reset.css",
			"/resource/css/structure.css",
			"/resource/css/global.css"
		)
	);
} else {
	$cssAggregator->collect(
		array(
			"/resource/css/accessibility/high-contrast.css"
		)
	);
}
if ($_SESSION["Style"] == "large") {
	$cssAggregator->collect(
		array(
			"/resource/css/accessibility/large.css"
		)
	);
}
?>
<?php
echo $cssAggregator->output();
?>
		<link rel="stylesheet" type="text/css" href="/resource/css/layout/social-media.css?v=@VERSION-NUMBER@" media="all" />
		<!--[if lt IE 7]>
			<script src="/resource/js/browser/internet-explorer/DD_roundies/DD_roundies.js?v=@VERSION-NUMBER@" type="text/javascript"></script>
		<![endif]-->

		<!--[if lt IE 8]>
			<link rel="stylesheet" type="text/css" href="/resource/css/internet-explorer.css?v=@VERSION-NUMBER@" media="all" />
		<![endif]-->
<?php echo $this->get("Style"); ?>
	</head>
	<body>
		<div id="container" class="<?php echo $this->get("Section"); ?>">
			<div id="wrapper">

				<div id="main-header">
<?php
//include "Site/Template/Booth/Widget/Header.php";
?>
				</div>
				<div id="main-content">
					<div class="navigation">
<?php
//include "Site/Template/Booth/Widget/Navigation.php";
?>
					</div>
<?php echo $this->get("Main"); ?>
				</div>

			</div>

			<div id="utility">
<?php echo $this->get("Utility"); ?>
				<hr />
			</div>

			<div id="footer">
<?php
//include "Site/Template/Booth/Widget/Footer.php";
?>
			</div>

		</div>
		<script type="text/javascript" src="/resource/js/jquery/jquery.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/swfobject/swfobject.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript">
//<![CDATA[
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-20124921-1']);
_gaq.push(['_setDomainName', '.gawkwall.com']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
//]]>
		</script>
<?php echo $this->get("JavaScript"); ?>
	</body>
</html>