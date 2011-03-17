<?php
require_once "Application/Bootstrap.php";

header("HTTP/1.0 404 Not Found");

$application->doNotStorePage();

$layout = CoreFactory::getLayout("Site/Template/Default/ClientError.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "Error 404");
$layout->start("Style");
// Put your stylesheets here.
?>

<link rel="stylesheet" type="text/css" href="/resource/css/layout/error.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

<div class="panel">
	<div class="inner-panel">
		<h2><span>Error 404: Page Not Found</span></h2>
		<p>Don't worry &ndash; it's not serious, but it looks like the page you've requested isn't available.</p>
		<p><strong>Here's what you can try:</strong></p>
		<ul class="list-items">
			<li>If you typed the page address in the address bar, make sure that it is spelt correctly.</li>
			<li>Click the <a href="#" onclick="history.go(-1)">back button</a> to try another link.</li>
			<li>Make your way back to the <a href="/"><?php echo $application->registry->get("Title"); ?> homepage</a> and look for links to the information you want.</li>
		</ul>
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