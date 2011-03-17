<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->doNotStorePage();
$application->securityControl->isAllowed("Member Update");

$memberControl = BaseFactory::getMemberControl();

switch($application->parseSubmit()) {
	case "Save Changes":
		$htmlFormControl = CoreFactory::getHtmlFormControl();
		$member = $memberControl->map($htmlFormControl->mapFormSubmission($_POST, $_FILES));

		if ($member->save()) {
			$application->redirect("./");
		}
		break;
	default:
		if (!$member = $memberControl->item($application->securityControl->getMemberId())) {
			$application->securityControl->LogOff();
		}
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
		<div id="container" class="<?php echo $section; ?> control">
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
					<h3>Edit your account details</h3>
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
					<form action="<?php echo $application->createUrl(); ?>" method="post" enctype="multipart/form-data">
						<fieldset id="basic-details">
							<h4><span>About you</span></h4>
							<label><strong class="required">E-mail Address <span>*</span></strong>
								<input name="EmailAddress" type="text" class="textbox medium"
									value="<?php echo $member->get("EmailAddress"); ?>"
									maxlength="<?php echo $member->getMaxLength("EmailAddress"); ?>" /></label><br />
							<label><strong class="required">Username <span>*</span></strong>
								<input name="Alias" type="text" class="textbox medium"
									value="<?php echo $member->get("Alias"); ?>"
									maxlength="<?php echo $member->getMaxLength("Alias"); ?>" /></label><br />
							<label><strong>Password</strong>
								<input type="password" class="textbox medium" value="**********" disabled="disabled" />
								<a href="/account/password/control.php">change password</a></label><br />
							<label><strong class="required">First Name <span>*</span></strong>
								<input name="FirstName" type="text" class="textbox medium"
									value="<?php echo $member->get("FirstName"); ?>"
									maxlength="<?php echo $member->getMaxLength("FirstName"); ?>" /></label><br />
							<label><strong class="required">Last Name <span>*</span></strong>
								<input name="LastName" type="text" class="textbox medium"
									value="<?php echo $member->get("LastName"); ?>"
									maxlength="<?php echo $member->getMaxLength("LastName"); ?>" /></label><br />
							<label><strong class="required">Your Birthday <span>*</span></strong>
									<?php echo $htmlControl->createDateControl("DateOfBirth", $member->get("DateOfBirth"), false, "listbox_custom"); ?></label><br />
						</fieldset>

						<fieldset id="profile">
							<h4><span>Your profile</span></h4>
							<label><strong>Your Website</strong>
								<input name="WebSite" type="text" class="textbox medium"
									value="<?php echo $member->get("WebSite"); ?>"
									maxlength="<?php echo $member->getMaxLength("WebSite"); ?>" /></label><br />
							<label><strong>Your Sgnature</strong>
								<textarea name="Signature" cols="40" rows="15" class="textbox medium" onchange="maxTextLength(<?php echo $member->getMaxLength("Signature"); ?>)"><?php echo $member->get("Signature"); ?></textarea></label><br />
							<label><strong>Your Avatar</strong>
								<input name="Image" type="file" class="textbox medium" />
								<input name="ImageId" type="hidden"
									value="<?php echo $member->get("ImageId"); ?>" />
								<span class="note">Images should be approx. <?php echo $memberControl->imageSize["MaxHeight"]; ?>px by <?php echo $memberControl->imageSize["MaxWidth"]; ?>px. Larger images will be resized and cropped.</span>
							</label><br />
<?php
if (!$member->isNull("ImageId")) {
?>
							<label><strong>Your Avatar</strong>
								<?php echo $htmlControl->showImageBinary($member->get("ImageId"), $member->get("Alias"), 100, 100); ?>
							</label><br />
							<label class="checkbox">
								<strong>Do you want to remove this avatar?</strong>
								<input name="RemoveImage" type="checkbox" value="1" />
							</label><br />
<?php
}
?>
						</fieldset>

						<fieldset id="keep-up-to-date">
							<h4><span>Keep up-to-date?</span></h4>
							<label class="checkbox">
								<strong>Please send me email updates</strong>
								<input name="ReceiveEmailUpdates" type="checkbox" value="t" <?php echo $htmlControl->check($member->get("ReceiveEmailUpdates")); ?>/>
							</label><br />
							<label class="checkbox">
								<strong>Receive related promotions</strong>
								<input name="ReceiveRelatedPromotions" type="checkbox" value="t" <?php echo $htmlControl->check($member->get("ReceiveRelatedPromotions")); ?>/>
							</label><br />
						</fieldset>

						<div class="controls">
							<input name="Submit" type="submit" class="button" value="Save Changes" accesskey="s" />
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