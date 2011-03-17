<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->doNotStorePage();

switch($application->parseSubmit()) {
	case "GO":
	case "Log On":
		$application->isSecure();
		if ($application->securityControl->logon($_POST["EmailAddress"],
			$_POST["Password"])) {

			// Should an autologon be created
			if (isset($_POST["AutoLogon"])) {
				$application->securityControl->createAutoLogon();
			}
			$application->gotoLastPage();
			$application->redirect("/");
		}

		break;
	case "Register":
		$application->redirect("register.php");
		break;
	case "Log Off":
	case "LogOff":
		$application->securityControl->logOff();
		break;
	default:
		$_POST["EmailAddress"] = "";
		break;
}
$_POST = $htmlControl->sanitise($_POST);

$layout = CoreFactory::getLayout("Site/Template/Default/NoUtility.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "account log-on");
$layout->start("Style");
// Put your stylesheets here.
?>

<link rel="stylesheet" type="text/css" href="/resource/css/layout/form.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

	<h1>Log in</h1>

<?php
if ($application->errorControl->hasErrors()) {
?>

	<div class="form-errors">
		<h2>There was a problem with your form submission</h2>
		<p>Please check the following, then correct your form accordingly before submitting again.</p>
		<ul>
			<?php echo $htmlControl->makeList($application->errorControl->getErrors()); ?>
		</ul>
	</div>

<?php
}
?>

<!--

	Temporarily taken out until I have time to style the rest of the Register section - Dev 20/07/2010

	<p>If you are not already a member, then please take the time to <a href="register.php">register here</a>.</p>

-->

	<form action="<?php echo $application->createUrl(); ?>" method="post">
		<fieldset id="log-on-control">
			<h2>For further access, please log in</h2>
			<label>
				<strong>Email Address</strong>
				<input type="text" class="textbox medium" name="EmailAddress"
					value="<?php echo $_POST["EmailAddress"]; ?>" />
			</label><br />
			<label>
				<strong>Password</strong>
				<input type="password" id="enter-password" class="textbox medium" name="Password" value="" />
				<span class="side-note">
					<a href="/account/password/reset/">lost password?</a>
				</span>
			</label><br />
			<label class="checkbox">
				<strong>Remember me on this computer?</strong>
				<input type="checkbox" name="AutoLogon" value="true"
					title="Using this option you will remain logged in when every you return to the site on this computer" />
			</label><br />
			<div class="controls">
				<input name="Submit" type="submit" class="button" value="Log On" />
				<input name="Submit" type="submit" class="button" value="Register" />
			</div>
		</fieldset>
	</form>

<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>
<script type="text/javascript" src="/resource/js/jquery/jquery.dPassword.js?v=@VERSION-NUMBER@"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$("#enter-password").dPassword();
});
//]]>
</script>
<?php
$layout->render();
