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
$layout->set("Section", "welcome");
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
		<small>By entering this competition, I am agreeing to its <a id="terms-link" href="#">terms and conditions</a>.</small>
	</form>
</div>
<div id="terms" class="overlay" style="display: none">
	<a id="close-link" href="#" class="close">Close</a>
	<h1>Terms &amp; Conditions</h1>
	<ol>
		<li>
			This competition is open to anyone aged 16 years or over, except for employees of Clock Limited or any companies or agencies directly connected with the creation of and administration of this promotion or their families.
		</li>
		<li>
			Multiple entries will be accepted.
		</li>
		<li>
			All entries must be submitted before the end of the exhibition on Wednesday 18 May 2011. No entries whatsoever will be considered after this time.
		</li>
		<li>
			All entrants must provide their email address. Any entry received without this information will not be entered into the competition. All details provided will be verified when the competition closes.
		</li>
		<li>
			Entries will not be acknowledged upon submission.
		</li>
		<li>
			The winner will be picked by random on 23 May and announced that day via @clock on twitter.
		</li>
		<li>
			By entering this competition Clock Limited obtains full copyright of the submitted entries.
		</li>
		<li>
			All entrants grant to Clock Limited a worldwide royalty free perpetual licence to publish and use each entry in any media (including online) for publicity and news purposes. In particular, all entrants licence Clock Limited the right to use their entry on the Clock Limited Facebook Fan page, www.gawkwall.com and www.clock.co.uk and other sites as Clock Limited see fit.
		</li>
		<li>
			Clock Limited will not be responsible for any technical fault or failure which prevents a person from entering the competition.
		</li>
		<li>
			Clock Limited takes no responsibility for any entries that are lost, delayed, corrupted, damaged, incomplete or otherwise invalid.
		</li>
		<li>
			Entries may be rejected in the sole discretion of Clock Limited, including for reasons of obscenity, defamation or invasion of privacy.
		</li>
		<li>
			The Prize Winner must agree to his or her name and general location being used for publicity purposes by Clock Limited in any and all media.
		</li>
		<li>
			Any breach of these competition rules by an entrant will void their entry.
		</li>
		<li>
			Clock Limited's decision is final and no correspondence will be entered into.
		</li>
		<li>
			The prize is an iPad 2 is non-transferable and will be offered on a confirmed basis only. No alternatives will be permitted.
		</li>
		<li>
			The Prize Winner accepts the prize at his or her own risk. 
		</li>
		<li>
			No purchase necessary. 
		</li>
		<li>
			These Terms &amp; Conditions are subject to English Law and the exclusive jurisdiction of the English courts.
		</li>
	</ol>
</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript" src="/resource/js/application/gawk/booth/booth-control.js"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var boothControl = new BoothControl();
	
	$("#terms-link").click(function () {
    $("#terms").show();
  });
	
	$("#close-link").click(function () {
    $("#terms").hide();
  });

});
//]]>
	</script>
<?php
$layout->render();