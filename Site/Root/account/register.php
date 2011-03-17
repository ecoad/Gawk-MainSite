<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->doNotStorePage();

$memberControl = BaseFactory::getMemberControl();
$binaryControl = CoreFactory::getBinaryControl();

switch($application->parseSubmit()) {
	case "Save":
		$htmlFormControl = CoreFactory::getHtmlFormControl();
		$member = $memberControl->map($_POST);
		if ($memberControl->register($member, $_POST["ConfirmPassword"])) {
			$application->redirect("view.php?Submit=View&Id=" . $member->get("Id"));
		}
		break;
	default:
		$member = $memberControl->makeNew();
		break;
}
$htmlSelectOptions = CoreFactory::getHtmlSelectOptions();

$lists = CoreFactory::getLists();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $sectionTitle; ?> / <?php echo $application->registry->get("Title"); ?></title>
<?php
include("resource/page-component/metadata.php");
?>
		<script type="text/javascript">
//	<![CDATA[
Event.observe(window, "dom:loaded", function() {
	new RumbleUI.Form.DateControl("date-of-birth", "DateOfBirth", "<?php echo $member->get("DateOfBirth"); ?>", { allowNull: true } )
});

function checkPassword() {
	if (document.forms[0].Password.value == document.forms[0].ConfirmPassword.value) {
		new Ajax.Request("/resource/application/service/validation.php", {
			method: "get",
			parameters: {
				Action: "CheckPassword",
				Password: document.forms[0].ConfirmPassword.value
			},
			onSuccess: (function(response) {
				var response = response.responseText.evalJSON();
				if (response.success) {
					$('password-information').innerHTML = "<span class=\"success\">Success! Your password is valid.</span>";
				} else {
					$('password-information').innerHTML = "<span class=\"fail\">" + response.message + "</span>";
				}
			}).bind(this)
		});
	} else {
		$('password-information').innerHTML = "<span class=\"fail\">Oops, your passwords do not match. Please try again.</span>";
	}
}
// ]]>
		</script>
		<link rel="stylesheet" type="text/css" href="/resource/css/section/<?php echo $section; ?>.css?v=@VERSION-NUMBER@" media="all" />
	</head>
	<body>
		<div id="container" class="<?php echo $section; ?> register">
			<div id="header">
<?php
include("resource/page-component/header.php");
?>
			</div>
			<div id="wrapper">
				<div id="navigation">
<?php
include("resource/page-component/navigation.php");
?>
				</div>
				<div id="main-content">
<!-- Start of Main Content -->

					<h2><span><?php echo $sectionTitle; ?></span></h2>
					<h3>Register</h3>
<?php
if ($application->errorControl->hasErrors()) {
?>
					<div class="form-errors">
						<h3>There was a problem with your form.</h3>
						<p>Please check the following, then try again.</p>
						<ul>
							<?php echo $htmlControl->makeList($application->errorControl->getErrors()); ?>
						</ul>
					</div>
<?php
}
?>
					<form id="article-form" name="article-form" action="" method="post" enctype="multipart/form-data">
						<fieldset id="basic-details">
							<h3>About you</h3>
							<label>
								<strong class="required">First Name <span>*</span></strong>
								<input name="FirstName" type="text" class="textbox medium"
									tabindex="3"
									value="<?php echo $member->get("FirstName"); ?>"
									maxlength="<?php echo $member->getMaxLength("FirstName"); ?>" />
							</label><br />
							<label>
								<strong class="required">Last Name <span>*</span></strong>
								<input name="LastName" type="text" class="textbox medium"
									tabindex="4"
									value="<?php echo $member->get("LastName"); ?>"
									maxlength="<?php echo $member->getMaxLength("LastName"); ?>" />
							</label><br />
							<label>
								<strong class="required">E-mail Address <span>*</span></strong>
								<input name="EmailAddress" type="text" class="textbox medium"
									tabindex="1"
									value="<?php echo $member->get("EmailAddress"); ?>"
									maxlength="<?php echo $member->getMaxLength("EmailAddress"); ?>" />
							</label><br />
							<label>
								<strong class="required">Choose Your Username <span>*</span></strong>
								<input name="Alias" type="text" class="textbox medium"
									tabindex="2"
									value="<?php echo $member->get("Alias"); ?>"
									maxlength="<?php echo $member->getMaxLength("Alias"); ?>" />
									<span class="note">Your name as it will appear to other users.</span>
							</label><br />
							<span class="label">
								<strong>Your Birthday</strong><span id="date-of-birth"></span>
							</span>
						</fieldset>

						<fieldset id="security-details">
							<h3>Choose a password</h3>
							<label>
								<strong>Password</strong>
								<input name="Password" type="password" class="textbox medium"
									tabindex="5" value="" onkeyup="checkPassword();"/>
							</label><br />
							<label>
								<strong>Confirm Your Password</strong>
								<input name="ConfirmPassword" type="password" class="textbox medium"
									tabindex="6" value="" onkeyup="checkPassword();"/>
								<span id="password-information" class="note"></span>
							</label><br />
						</fieldset>

						<fieldset id="privacy-details">
							<h3>Keep up-to-date?</h3>
							<label class="checkbox">
								<strong>Please send me email updates.</strong>
								<input name="ReceiveEmailUpdates" type="checkbox"
									tabindex="11"
									value="t" <?php echo $htmlControl->check($member->get("ReceiveEmailUpdates")); ?>/>
							</label><br />
							<label class="checkbox">
								<strong>Please send me related promotions.</strong>
								<input name="ReceiveRelatedPromotions" type="checkbox"
									tabindex="12"
									value="t" <?php echo $htmlControl->check($member->get("ReceiveRelatedPromotions")); ?>/>
							</label><br />
						</fieldset>
<script type="text/javascript">
// <![CDATA[
Event.observe(window, "dom:loaded", function() {
	$("account-terms-and-conditions").onclick = function() {
		window.open("/legal/terms-and-conditions.php", "Terms And Conditions", "width=400 height=500");
		return false;
	}
});
// ]]>
</script>
						<fieldset id="terms-and-conditions">
							<label class="checkbox">
								<strong>I have read and agree to the <a id="account-terms-and-conditions" href="/legal/terms-and-conditions.php" target="_blank" tabindex="14">terms and conditions</a>.</strong>
								<input name="TermsAgreed" type="checkbox"
									tabindex="13"
									value="t" <?php echo $htmlControl->check($member->get("TermsAgreed")); ?>/>
							</label>
						</fieldset>

						<div class="controls">
							<input name="Submit" tabindex="15" type="submit" class="button" value="Save" accesskey="s" title="Save all changes and return to the last page" />
							<input name="Submit" tabindex="16" type="submit" class="button" value="Cancel" accesskey="c" title="Return to the previous page but do not save changes first" />
							<input name="Id" type="hidden" value="<?php echo $member->get("Id"); ?>" />
							<input name="CancelUrl" type="hidden" value="<?php echo $application->getLastPage(); ?>" />
						</div>
					</form>

<!-- End of Main Content -->
				</div>
			</div>
			<div id="utility">
<?php
include("resource/page-component/utility.php");
?>
			</div>
<?php
include("resource/page-component/footer.php");
?>
		</div>
	</body>
</html>