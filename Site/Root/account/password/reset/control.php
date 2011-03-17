<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->doNotStorePage();

$application->required($_GET["Id"]);
$memberControl = BaseFactory::getMemberControl();

if (!$member = $memberControl->itemByField($_GET["Id"], "PasswordRequestId")) {
	$memberControl->errorControl->addError("Requested Id not found");
	$noId = 1;
}

switch($application->parseSubmit()) {
	case "Save":
		if (time() < ($member->get("PasswordRequestTime") + EMAIL_VALIDITY_LIMIT)) {
			if ($memberControl->adminChangePassword($member,
					$_POST["NewPassword"], $_POST["ConfirmPassword"])) {
				$application->redirect("./");
			}
		} else {
			$limitPassed = 1;
		}
		break;
	case "Cancel":
		$application->gotoLastPage();
		break;
	default:
		break;
}

$layout = CoreFactory::getLayout("Site/Template/Default/NoUtility.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "account password-request");
$layout->start("Style");
// Put your stylesheets here.
?>

<link rel="stylesheet" type="text/css" href="/resource/css/layout/form.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

	<h1>Request Your Password</h1>

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

	<form action="" method="post">
		<fieldset>
			<h2>Change your password</h2>
			<p>When you have changed your password, you will be redirected to the <a href="/account/log-on.php">log on page</a> where you will be able to log on with your new password.</p>
			<label>
				<strong class="required">Enter New Password <span>*</span></strong>
				<input type="password" class="textbox medium" name="NewPassword" value="" />
			</label><br />
			<label>
				<strong class="required">Confirm New Password <span>*</span></strong>
				<input type="password" class="textbox medium" name="ConfirmPassword" value="" />
			</label><br />
			<div class="controls">
				<input name="Submit" type="submit" class="button" value="Save"
					accesskey="s" title="Save all changes and return to the last page" />
				<input name="Submit" type="submit" class="button" value="Cancel"
					accesskey="c" title="Return to the previous page but do not save changes first" />
				<input name="Id" type="hidden" value="<?php echo $member->get("Id"); ?>" />
			</div>
		</fieldset>
	</form>

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