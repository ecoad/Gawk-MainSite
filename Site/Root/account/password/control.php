<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->doNotStorePage();
$application->securityControl->isAllowed("Member Update");

$memberControl = BaseFactory::getMemberControl();
switch($application->parseSubmit()) {
	case "Save":
		$member = $memberControl->item($application->securityControl->getMemberId());

		if ($memberControl->changePassword($member, $_POST["OldPassword"],
				$_POST["NewPassword"], $_POST["ConfirmPassword"])) {
			$application->redirect("/account/password/confirm.php");
		}
		break;
	case "Cancel":
		$application->gotoLastPage();
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $sectionTitle; ?> / <?php echo $application->registry->get("Title"); ?></title>
<?php
include("resource/page-component/metadata.php");
?>
		<link rel="stylesheet" type="text/css" href="/resource/css/section/<?php echo $section; ?>.css?v=@VERSION-NUMBER@" media="all" />
	</head>
	<body>
		<div id="container" class="<?php echo $section; ?> password-control">
			<div id="wrapper">
				<div id="header">
<?php
include("resource/page-component/header.php");
?>
				</div>
				<div id="navigation">
<?php
include("resource/page-component/navigation.php");
?>
				</div>
				<div id="main-content">
<!-- Start of Main Content -->

					<h2><span><?php echo $sectionTitle; ?></span></h2>
<?php
include("resource/page-component/account/section-navigation.php");
?>
					<h3>Change Your Password</h3>
					<p>You can use this section to change your password.</p>
<?php
if ($application->errorControl->hasErrors()) {
?>
					<div class="form-errors">
						<h4><span>There was a problem with your form submission</span></h4>
						<p>Please check the following, then correct your form accordingly before submitting again.</p>
						<ul>
							<?php echo $htmlControl->makeList($application->errorControl->getErrors()); ?>
						</ul>
					</div>
<?php
}
?>
					<form action="<?php echo $application->createUrl(); ?>" method="post">
						<fieldset>
							<label>
								<strong class="required">Your OLD Password <span>*</span></strong>
								<input type="password" class="textbox medium" name="OldPassword" value="" />
							</label><br />
							<label>
								<strong class="required">Enter New Password <span>*</span></strong>
								<input type="password" class="textbox medium" name="NewPassword" value="" />
							</label><br />
							<label>
								<strong class="required">Confirm New Password <span>*</span></strong>
								<input type="password" class="textbox medium" name="ConfirmPassword" value="" />
							</label><br />
						</fieldset>
						<div class="controls">
							<input name="Submit" type="submit" class="button" value="Save" />
							<input name="Submit" type="submit" class="button" value="Cancel" />
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