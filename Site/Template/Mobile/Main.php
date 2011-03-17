<!doctype html>
<html>
	<head>
		<title>Mobile</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="author" content="Clock - www.clock.co.uk" />
		<meta http-equiv="imagetoolbar" content="no" />
		<meta http-equiv="description" content="The starting point for all our sites" />
		<meta http-equiv="keywords" content="" />

	<!-- iPad/iPhone specific css below, add after your main css >
	<link rel="stylesheet" media="only screen and (max-device-width: 1024px)" href="ipad.css" type="text/css" />
	<link rel="stylesheet" media="only screen and (max-device-width: 480px)" href="iphone.css" type="text/css" />
	-->

	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="apple-touch-startup-image" href="tbc.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/>

	<link rel="stylesheet" type="text/css" href="jqtouch/jqtouch.min.css?v=@VERSION-NUMBER@" media="all" />
	<link rel="stylesheet" type="text/css" href="main.css?v=@VERSION-NUMBER@" media="all" />



	<?php echo $this->get("Style"); ?>
	</head>
	<body>
<?php
include("Site/Template/Mobile/Widget/Navigation.php");
?>
		<section id="main">
			<?php echo $this->get("Main"); ?>
		</section>
		<script src="/resource/js/jquery/jquery.js?v=@VERSION-NUMBER@" type="text/javascript"></script>
		<script src="mobile.js?v=@VERSION-NUMBER@" type="text/javascript"></script>
<?php echo $this->get("JavaScript"); ?>
	</body>
</html>