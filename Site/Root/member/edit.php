<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);
$memberUrlHelper = Factory::getMemberUrlHelper();

$memberControl = Factory::getMemberControl();
if (!$member = $memberControl->getMemberByRequestUrl($_SERVER["REQUEST_URI"])) {
	$application->displayErrorPage("Site/Root/error/404.php", 404);
}

$memberAuthentication = Factory::getMemberAuthentication();
if ((!$loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) ||
	($loggedInMemberDataEntity->get("SecureId") != $member->secureId)) {

	$application->displayErrorPage("Site/Root/error/403.php", 403);
}

$formWebsiteLabel = "Website";
$formAliasLabel = "Alias";
$formDescriptionLabel = "Description";
$formRemoveProfileGawkLabel = "RemoveProfileGawk";
$formSubmitLabel = "save";

if ($application->parseSubmit() == $formSubmitLabel) {
	$memberWebService = Factory::getMemberWebService();
	$response = $memberWebService->handleRequest(MemberWebService::SERVICE_UPDATE_PROFILE, $_POST);
	$application->errorControl->addErrors($response->errors);
	$member = $response->member;
	if ($response->success) {
		$application->redirect($memberUrlHelper->getProfileUrl($response->member));
	}
}

$tabIndex = 0;

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "edit profile / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "profile");
$layout->start("Style");
?>
<link media="all" href="/resource/css/basic-form.css?v=@VERSION-NUMBER@" type="text/css" rel="stylesheet"/>
<?php
$layout->start("Main");
// The main page content goes here.
?>
<div id="title-area">
	<div class="breadcrumb">
		<a href="/">home</a> / <a title="View profile" href="<?php echo $memberUrlHelper->getProfileUrl($member); ?>">profile</a> /
			edit
	</div>
</div>
<div id="profile-edit-view">
	<div class="view-container">
		<h1 class="page-title">edit your profile</h1>
<?php
if ($application->errorControl->hasErrors()) {
?>
		<div class="form-errors">
			<h2>form error</h2>
			<ul>
<?php
	foreach ($application->errorControl->getErrors() as $errorLabel => $errorDescription) {
?>
				<li><?php echo $errorDescription; ?></li>
<?php
	}
?>
			</ul>
		</div>
<?php
}
?>
		<form method="post" action="" class="basic-form wide">
			<div class="edit-profile-graphic"></div>
			<fieldset>
				<label>
					<strong>alias</strong>
					<input name="ProfileData[<?php echo $formAliasLabel; ?>]" type="text" class="textbox wide"
						tabindex="<?php echo $tabIndex++; ?>" value="<?php echo $member->alias; ?>"/>
				</label>
				<label>
					<strong>website</strong>
					<input name="ProfileData[<?php echo $formWebsiteLabel; ?>]" type="text" class="textbox wide"
						tabindex="<?php echo $tabIndex++; ?>" value="<?php echo $member->website; ?>"/>
				</label>
				<label>
					<strong>about</strong>
					<textarea tabindex="<?php echo $tabIndex++; ?>" class="textbox wide" rows="7" cols="40"
						name="ProfileData[<?php echo $formDescriptionLabel; ?>]"><?php echo $member->description; ?></textarea>
				</label>
				<div class="controls">
					<a href="#" onclick="$(this).parents('form').submit();" class="submit" title="submit the form">
						<span><?php echo $formSubmitLabel; ?></span>
					</a>
					<input type="hidden" name="Submit" value="<?php echo $formSubmitLabel; ?>"/>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<?php
$layout->start("JavaScript");
?>
<script type="text/javascript" src="/resource/js/application/gawk/views/profile-edit.js?v=@VERSION-NUMBER@"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "ProfileEdit",
		member: "<?php echo addslashes(json_encode($member)); ?>",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
</script>
<?php
$layout->render();