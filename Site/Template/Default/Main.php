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
		<meta property="og:title" content="<?php echo $application->registry->get("Name"); ?>"/>
		<meta property="og:description" content="<?php echo $application->registry->get("Description"); ?>"/>
		<meta property="og:site_name" content="Gawk Wall"/>
		<meta property="og:image" content="<?php echo $application->registry->get("Name"); ?>"/>

		<link rel="shortcut icon" href="/favicon.ico?v=@VERSION-NUMBER@" />
<?php
/*
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
*/
?>
		<link rel="stylesheet" type="text/css" href="/resource/css/reset.css?v=@VERSION-NUMBER@" media="all" />
		<link rel="stylesheet" type="text/css" href="/resource/css/base.css?v=@VERSION-NUMBER@" media="all" />
  	<link rel="stylesheet" type="text/css" href="/resource/css/global.css?v=@VERSION-NUMBER@" media="all" />
  	<link rel="stylesheet" type="text/css" href="/resource/css/overlay.css?v=@VERSION-NUMBER@" media="all" />
  	<link rel="stylesheet" type="text/css" href="/resource/css/header.css?v=@VERSION-NUMBER@" media="all" />
		<link rel="stylesheet" type="text/css" href="/resource/css/box.css?v=@VERSION-NUMBER@" media="all" />
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
<?php
if (isset($this->wallPainter)) {
?>
			<div id="wrapper" style="<?php echo $this->wallPainter->getBackgroundStyle(); ?>">
<?php
} else {
?>
			<div id="wrapper">
<?php
}
?>

				<div id="main-header">
<?php
include "Site/Template/Default/Widget/Header.php";
?>
				</div>
				<div id="main-content">
<?php echo $this->get("Main"); ?>
				</div>

				<div id="footer">
<?php
include "Site/Template/Default/Widget/Footer.php";
?>
				</div>
			</div>
		</div>
		<div style="display: none;">
			<div class="overlay form" id="login-overlay">
				<h2><span>sign in</span></h2>
				<div class="site-registered">
					<form method="post" class="login">
						<div class="login-error" style="display: none;">
							<h4>login error</h4>
							<p class="message"></p>
						</div>
						<label>
							<strong>email address</strong>
							<input class="textbox" type="email" name="EmailAddress" /><br />
						</label>
						<label>
							<strong>password</strong>
							<input class="textbox" type="password" name="Password" />
						</label>
						<a href="#" class="login-button"><span>login</span></a>
					</form>
				</div>
				<div class="facebook-registered">
					<fb:login-button></fb:login-button>
					<p class="note">easy, fast and simple login with facebook.</p>
				</div>
				<div class="register">
					<p>not a member yet?</p>
					<a href="#" class="register-button" title="register to gawkwall"><span>register</span></a>
				</div>
			</div>
			<div class="overlay form" id="register-overlay">
				<h2><span>register to gawkwall</span></h2>
				<form method="post" class="register">
					<label>
						<strong>username</strong>
						<input type="text" class="textbox" name="Alias" />
					</label>
					<label>
						<strong>email address</strong>
						<input type="email" class="textbox" name="EmailAddress" />
					</label>
					<label>
						<strong>password</strong>
						<input type="password" class="textbox" name="Password" />
					</label>
					<label>
						<strong>confirm password</strong>
						<input type="password" class="textbox" name="ConfirmPassword" />
					</label>
					<div class="register-error" style="display: none;">
					</div>
					<label>
						<a href="#" class="register-button"><span>register</span></a>
					</label>
				</form>
			</div>
			<div class="overlay" id="logging-in-overlay">
				<div class="message"></div>
			</div>
			<div class="overlay" id="logging-out-overlay">
				<div class="message"></div>
			</div>
			<div class="overlay" id="welcome-overlay">
				<h3>welcome to gawkwall</h3>
				<p>there are only a few things you need to know about gawking</p>
				<img src="http://dummyimage.com/800x400/abc/123" />
			</div>
		</div>
		<div id="fb-root"></div>
		<script type="text/javascript" src="/resource/js/jquery/jquery.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/jquery/jquery.json-2.2.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/jquery/jquery.cookie.js?v=@VERSION-NUMBER@"></script>
		<!-- <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script> -->
		<!-- <script type="text/javascript" src="http://static.ak.fbcdn.net/connect/en_US/core.debug.js"></script> -->

		<script type="text/javascript" src="/resource/js/application/gawk/config/config.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/application/gawk/widgets/login-widget.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/application/gawk/widgets/navigation-widget.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/application/gawk/member/member-control.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/application/gawk/gawk.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/swfobject/swfobject.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/jquery/jquery.placeholder.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/jquery/jquery.box.js?v=@VERSION-NUMBER@"></script>
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