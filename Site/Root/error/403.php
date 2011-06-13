<?php
require_once "Application/Bootstrap.php";

header("HTTP/1.0 403 Access Denied");

$application->doNotStorePage();

$layout = CoreFactory::getLayout("Site/Template/Default/ClientError.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "Error 403");
$layout->start("Style");
// Put your stylesheets here.
?>

<link rel="stylesheet" type="text/css" href="/resource/css/layout/error.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>
<div id="title-area">
	<div class="breadcrumb">
		<a href="/">home</a> / error 404
	</div>
</div>
<div class="view-container">
	<div class="panel">
		<div class="inner-panel">
			<h1 class="page-title">Error 403: Access Denied</h1>
			<p>Unfortunately this page is unavailable.</p>
		</div>
	</div>
</div>
<?php
$layout->start("Utility");
?>

<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>

<script type="text/javascript">
//<![CDATA[

//]]>
</script>
<?php
$layout->render();
exit;