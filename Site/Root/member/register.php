<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);

$memberAuthentication = Factory::getMemberAuthentication();
if ($loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	$application->redirect("/");
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "register / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "profile");
$layout->start("Style");
?>
<link media="all" href="/resource/css/register.css?v=@VERSION-NUMBER@" type="text/css" rel="stylesheet"/>
<?php
$layout->start("Main");
// The main page content goes here.
?>
<div class="breadcrumb">
	<a href="/">home</a> / register
	<hr />
</div>
<div id="register-view">
	<h1>register</h1>

	<form method="post" action="">
		<div class="form-errors" style="display: none;">
			<h4>there was a problem&hellip;</h4>
			<p>please check the following and try again:</p>
			<ul>
			</ul>
		</div>
		email <input name="EmailAddress" type="email"/><br />
		username <input name="Alias" type="text"/><br />
		password <input name="Password" type="password"/><br />
		confirm password <input name="ConfirmPassword" type="password"/><br />
		<input type="submit" name="Submit" value="submit" />
	</form>
	<p>or register with gawkwall by logging in to Facebook <fb:login-button></fb:login-button></p>
</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript" src="/resource/js/application/gawk/views/register-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "Register",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();