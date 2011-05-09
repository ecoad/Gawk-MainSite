<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);

$postAction = "Submit";
$postMessage = "Message";
$postEmailAddress = "EmailAddress";

if ($application->parseSubmit() == $postAction) {
	mail("elliotcoad+gawk@gmail.com", "New contact on the Gawk Wall from: " . $_POST[$postEmailAddress], $_POST[$postMessage]);
	$application->redirect("/contact/thanks");
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "contact / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "contact");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div class="breadcrumb">
	<a href="/">home</a> / <a title="contact us" href="/contact">contact</a>
</div>
<div id="contact-view">
	<h1>contact</h1>
	<form method="post" action="">
		<label>
			<strong class="required">email<span>*</span></strong><br />
			<input name="<?php echo $postEmailAddress; ?>" type="email" class="textbox medium"/>
		</label><br />
		<label>
			<strong class="required">message<span>*</span></strong><br />
			<textarea class="textbox wide tall" rows="10" cols="40" name="<?php echo $postMessage; ?>"></textarea>
		</label>
		<input type="submit" name="Submit" value="<?php echo $postAction; ?>">
	</form>
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