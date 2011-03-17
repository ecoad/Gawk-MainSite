<?php
require_once("Application/Bootstrap.php");

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $application->registry->get("Title") . " / About");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->set("BackgroundImage", null); //TODO: Homepage needs to be a channel to retrieve image
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
$captcha = CoreFactory::getCaptcha();
?>
<h2>About Gawk Wall</h2>

<h3>What is Gawk Wall?</h3>
<p>It is a collection of looping 3 second videos submitted by anyone with a webcam</p>

<h3>How do I Gawk?</h3>

<p>If you have a webcam, go on to a wall and press "Gawk Here". Press record and do your thing infront of the camera for 3 seconds.</p>

<h3>How do the Walls work?</h3>

<p>The main wall, when you arrive at the home page, is public to absolutely everyone.<br />
If you wanted something for yourself or to share within your circle of friends, you can create your own wall.<br />
For example if you wanted to commemorate a recent wedding you can have: gawkwall.com/w/daves-wedding<br />
If you didn't want any randomer Gawking on your wall you can add a password to protect submissions.</p>

<h3>A Gawk needs immortalising!/Binning!</h3>

<p>Hover your mouse over individual Gawks and you get the option to rate it up or down. Enough either way will secure its future.</p>

<h3><a name="contact">Contact</a></h3>
<form id="contact-form" action="" method="post" >
	Email Address From (optional): <input type="text" name="FromEmailAddress" /><br />
	<textarea name="Message" rows="5" cols="40"></textarea>
	<input type="submit" name="Submit" value="Submit"/>
	<input type="hidden" name="Action" value="SubmitContact"/>
	(CAPTCHA)
	<?php //echo $captcha->generateCaptchaImage(300, 200); ?>
</form>
<?php
$layout->start("JavaScript");
$layout->render();
?>