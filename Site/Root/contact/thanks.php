<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "contact / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "contact");
$layout->start("Style");
?>
<link media="all" href="/resource/css/basic-form.css?v=@VERSION-NUMBER@" type="text/css" rel="stylesheet"/>
<?php
$layout->start("Main");
// The main page content goes here.
?>
<div id="title-area">
	<div class="breadcrumb">
		<a href="/">home</a> / <a title="contact us" href="/contact">contact</a>
	</div>
</div>
<div id="contact-view">
	<div class="view-container" style="min-height: 300px;">
		<h1 class="page-title">contact us</h1>
		<p class="white-normal">
			thanks for getting in contact, <a href="/">go back home</a>
		</p>
	</div>
</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "ContactThanks",
		apiLocation	: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();