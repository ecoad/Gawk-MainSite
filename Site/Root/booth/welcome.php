<?php
require_once("Application/Bootstrap.php");

if ($application->parseSubmit() == "Start") {
	$httpRequest = CoreFactory::getHttpRequest();
	$httpRequest->setUrl("http://clockgaming.com/save.php");

	$xml = <<<DATA
<save>
<game>FutureOfWebDesign2011GawkBooth</game>
<data>{$_POST["EmailAddress"]}</data>
</save>
DATA;
	$httpRequest->setRawPostData($xml);
	$httpRequest->addHeader("Content-type", "text/xml");
	$httpRequest->send();
	$application->redirect("record.php");
}

$layout = CoreFactory::getLayout("Site/Template/Booth/Main.php");
$layout->set("Title", "Gawk Booth");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<h1>Welcome to the Clock Gawk Booth!</h1>
<div class="column primary">
	<h2>Why are you in a wooden box?</h2>
	<p>
		Well, you've got a chance to <b>win an iPad2</b>, you see&hellip;
	</p>
	<p>
		All you need to do is record your <b>3 seconds of fun</b>, submit it and it will be added to our wall &ndash; it's that simple. 
		We'll be announcing the winner on <b>23rd May</b> through <b>@clock on Twitter</b>. The more entertaining your are, the better your chances of winning!
	</p>
</div>
<div class="column secondary">
	<form action="" method="post" class="portal">
		<h2>Let's get going&hellip;</h2>
		<fieldset>
			<div class="invalid-email-address error" style="display: none;">
				<p>
					Oops, that's not a valid email address. Please try again.
				</p>
			</div>
			<label for="email">
				<strong>Enter your email address:</strong>
			</label>
			<input id="email" class="textbox wide" name="EmailAddress" type="text" placeholder="Please enter your email address" autocomplete="off" />
			<input class="button start" type="submit" name="Submit" value="Start" />
		</fieldset>
		<small>By entering this competition, I am agreeing to its <a href="#">terms and conditions</a>.</small>
	</form>
</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript" src="/resource/js/application/gawk/booth/booth-control.js"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var boothControl = new BoothControl();
});
//]]>
	</script>
<?php
$layout->render();