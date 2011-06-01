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
		<meta property="og:title" content="Gawk Wall"/>
		<meta property="og:description" content=""/>
		<meta property="og:site_name" content="Gawk Wall"/>
		<meta property="og:image" content=""/>

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
		<link rel="stylesheet" type="text/css" href="/resource/css/layout/social-media.css?v=@VERSION-NUMBER@" media="all" />
		<link rel="stylesheet" type="text/css" href="/resource/css/box.css?v=@VERSION-NUMBER@" media="all" />
  	<link rel="stylesheet" type="text/css" href="/resource/css/gawk.css?v=@VERSION-NUMBER@" media="all" />
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
include "Site/Template/Default/Widget/Header.php";
?>
				</div>
				<div id="main-content">
					<div class="navigation">
<?php
include "Site/Template/Default/Widget/Navigation.php";
?>
					</div>
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
			<div class="overlay" id="login-overlay">
				<h3>login to gawkwall</h3>
				<p>have an account with Facebook?</p>
				<form method="post" class="login">
					<label>
						<strong>login with Facebook</strong>
						<fb:login-button></fb:login-button><br />
					</label>
				</form>
				<hr/>
				<p>alternatively, log in or <a href="#" title="register to the gawkwall"
					class="register underline">register</a> with your gawkwall account</p>
				<form method="post" class="login">
					<div class="login-error" style="display: none;">
						<h4>login error</h4>
						<p class="message"></p>
					</div>
					<label>
						<strong>email address</strong>
						<input class="textbox" type="email" name="EmailAddress" /><br />
					</label><br />
					<label>
						<strong>password</strong>
						<input class="textbox" type="password" name="Password" /> <a href="#">forgotten password?</a><br />
					</label><br />
					<label>
						<strong>&nbsp;</strong>
						<input type="submit" class="button right" name="Login" value="login"/>
					</label><br />
				</form>
			</div>
			<div class="overlay" id="register-overlay">
				<h3>register to gawkwall</h3>
				<p>have an account with Facebook? <br />
				connect with Facebook: <fb:login-button></fb:login-button></p>
				<hr/>
				<p>alternatively: register a new account with gawkwall
				<form method="post" class="register">
					<div class="register-error" style="display: none;">
						<h4>register error</h4>
						<ul></ul>
					</div>
					<label>
						<strong>email address</strong>
						<input type="email" name="EmailAddress" /><br />
					</label><br />
					<label>
						<strong>username</strong>
						<input type="text" name="Alias" /><br />
					</label><br />
					<label>
						<strong>password</strong>
						<input type="password" name="Password" /><br />
					</label><br />
					<label>
						<strong>confirm password</strong>
						<input type="password" name="ConfirmPassword" /><br />
					</label><br />
					<label>
						<strong>&nbsp;</strong>
						<input type="submit" class="button right" name="Register" value="register"/><br />
					</label><br />

				</form>
			</div>
			<div class="overlay" id="logging-in-overlay">
				<h3>logging in&hellip;</h3>
				<p>please wait a moment while we log you in</p>
			</div>
			<div class="overlay" id="logging-out-overlay">
				<h3>logging out&hellip;</h3>
				<p>please wait a moment while we log you out</p>
			</div>
			<div class="overlay" id="welcome-overlay">
				<h3>welcome to gawkwall</h3>
				<p>there are only a few things you need to know about gawking</p>
				<img src="http://dummyimage.com/800x400/abc/123" />
			</div>
		</div>
		<script type="text/javascript" src="/resource/js/jquery/jquery.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/jquery/jquery.json-2.2.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="/resource/js/jquery/jquery.cookie.js?v=@VERSION-NUMBER@"></script>
		<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
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