<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $this->get("Title"); ?></title>
		<meta name="author" content="Clock - www.clock.co.uk" />
		<meta name="imagetoolbar" content="no" />
		<meta name="description" content="The starting point for all our sites" />
		<meta name="keywords" content="" />
		<meta charset="utf-8" />
		<meta name="revised" content="Ben Gourley, 01/10/2010" />

		<link rel="shortcut icon" href="/favicon.ico?v=@VERSION-NUMBER@" />

<?php
$application = CoreFactory::getApplication();
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
include("Site/Template/Default/Widget/Header.php");
?>
				</div>

				<div id="accessibility-options">
<?php
include("Site/Template/Default/Widget/AccessibilityOptions.php");
?>
				</div>

				<div id="main-content">
<?php echo $this->get("Main"); ?>
				</div>

			</div>

			<div id="utility">
<?php echo $this->get("Utility"); ?>
				<hr />
			</div>

			<div id="footer">
<?php
include("Site/Template/Default/Widget/Footer.php");
?>
			</div>

		</div>
		<script type="text/javascript" src="/resource/js/jquery/jquery.js"></script>
<?php echo $this->get("JavaScript"); ?>
	</body>
</html>