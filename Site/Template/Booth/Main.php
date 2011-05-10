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
		<link rel="stylesheet" type="text/css" href="/resource/css/base.css?v=@VERSION-NUMBER@" media="screen" />
		<link rel="stylesheet" type="text/css" href="/resource/css/structure.css?v=@VERSION-NUMBER@" media="screen" />
		<link rel="stylesheet" type="text/css" href="/resource/css/global.css?v=@VERSION-NUMBER@" media="screen" />
		<link rel="stylesheet" type="text/css" href="/resource/css/layout/form.css?v=@VERSION-NUMBER@" media="screen" />
		
		<?php echo $this->get("Style"); ?>
		
	</head>
	<body>
		<div id="container" class="<?php echo $this->get("Section"); ?>">
			<div id="wrapper">
				
				<div id="main-content">
<?php echo $this->get("Main"); ?>
				</div>
				
			</div>
			
			<div id="footer">
				<ul>
					<li class="clock">Presented by <span>Clock</span></li>
					<li class="gawkwall">In association with <span>Gawkwall</span></li>
				</ul>
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