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
	<div class="view-container">
		<h1 class="page-title">contact us</h1>
		<p class="white-normal">Just enter your email and your message and we’ll get back to you as soon as we can.</p>
		<form method="post" action="" class="basic-form">
			<div class="contact-graphic"></div>
			<label>
				<strong class="required">email<span>*</span></strong>
				<input name="<?php echo $postEmailAddress; ?>" type="email" class="textbox medium"/>
			</label>
			<label>
				<strong class="required">message<span>*</span></strong>
				<textarea class="textbox wide tall" rows="10" cols="40" name="<?php echo $postMessage; ?>"></textarea>
			</label>
			<a href="#" onclick="$(this).parents('form').submit();" class="submit" title="submit the form">
				<span><?php echo $postAction; ?></span>
			</a>
			<input type="hidden" name="Submit" value="<?php echo $postAction; ?>"/>
		</form>
	</div>
</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "ContactView",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();