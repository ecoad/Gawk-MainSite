<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "contact / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "contact");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div class="breadcrumb">
	<a href="/">home</a> / <a title="contact us" href="/contact">contact</a> / thanks
</div>
<div id="contact-view">
	<h1>contact</h1>
	<p>thanks for getting in touch</p>
</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "ContactView",
		member: "<?php echo addslashes(json_encode($member)); ?>",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();