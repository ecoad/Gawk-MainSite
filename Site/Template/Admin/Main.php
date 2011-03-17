<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $this->get("Title"); ?> / <?php echo $this->get("Name"); ?> Admin</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="author" content="Clock - www.clock.co.uk" />
		<meta http-equiv="imagetoolbar" content="no" />
		<link rel="shortcut icon" href="/favicon.ico?v=@VERSION-NUMBER@" />
		<link rel="stylesheet" type="text/css" href="/resource/css/admin/reset.css?v=@VERSION-NUMBER@" media="all" />
		<link rel="stylesheet" type="text/css" href="/resource/css/admin/structure.css?v=@VERSION-NUMBER@" media="all" />
		<link rel="stylesheet" type="text/css" href="/resource/css/admin/data-entity.css?v=@VERSION-NUMBER@" media="all" />
		<link rel="stylesheet" type="text/css" href="/resource/css/admin/form.css?v=@VERSION-NUMBER@" media="all" />
		<link rel="stylesheet" type="text/css" href="/resource/css/admin/main.css?v=@VERSION-NUMBER@" media="all" />
		<link rel="stylesheet" type="text/css" href="/resource/css/admin/general.css?v=@VERSION-NUMBER@" media="all" />

		<!--[if lt IE 8]>
			<link rel="stylesheet" type="text/css" href="/resource/css/admin/internet-explorer.css?v=@VERSION-NUMBER@" media="all" />
		<![endif]-->

		<?php echo $this->get("Style"); ?>
	</head>
	<body>
		<div id="container" class="<?php echo $this->get("Section"); ?>">
			<div id="header">
				<h1><a href="/admin/" title="Back to the  ${name} homepage"><span>Back to the <?php echo $this->get("Name"); ?> Homepage</span></a></h1>
				<p class="powered-by-clock-logo">	<a href="http://www.clock.co.uk" target="_blank"><img src="/resource/image/admin/powered-by-clock-logo.png?v=@VERSION-NUMBER@" width="89" height="44" /><span> This Website is developed by Clock</span></a></p>
				<hr />
			</div>
			<div id="wrapper">
				<div id="navigation">
<?php
include("Site/Template/Admin/Widget/Navigation.php");
?>
				</div>
				<div id="main-content">
<?php echo $this->get("Main"); ?>
				</div>
				<hr />
				<div id="footer">
					<h2><span>Footer</span></h2>
					<p>Copyright &copy; <?php echo strftime("%Y");?> <a href="http://www.clock.co.uk" title="...smart thinking">Clock</a>. If you have any problems with this administration system please call Clock on <strong>+44 1923 261166</strong> or e-mail <a href="mail:support@clock.co.uk">support@clock.co.uk</a>.</p>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/resource/js/jquery/jquery.js"></script>
<?php echo $this->get("JavaScript"); ?>
	</body>
</html>