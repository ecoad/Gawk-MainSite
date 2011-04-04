<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);

$memberControl = Factory::getMemberControl();
if (!$member = $memberControl->getMemberByRequestUrl($_SERVER["REQUEST_URI"])) {
	include "Site/Root/error/404.php";
}

$memberAuthentication = Factory::getMemberAuthentication();
if ($loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	if ($loggedInMemberDataEntity->get("SecureId") != $member->secureId) {
		include "Site/Root/error/403.php";
	}
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "Edit Profile / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div><a href="/u/<?php echo $member->alias; ?>">View your profile</a></div>
<div id="profile-edit-view" style="display: none;">
	<h1>Edit Profile</h1>
	<form method="post" action="">
		<fieldset>
			<label>
				<strong class="required">Password <span>*</span></strong>
				<input name="Password" type="password" class="textbox wide"
					tabindex="<?php echo $tabIndex++; ?>" value=""/>
			</label><br />
			<div class="controls">
				<input name="Submit" type="submit" tabindex="<?php echo $tabIndex++; ?>" class="button" value="Save" accesskey="s" title="Save all changes and return to the last page" />
				<input name="Submit" type="submit" tabindex="<?php echo $tabIndex++; ?>" class="button" value="Cancel" accesskey="c" title="Return to the previous page but do not save changes first" />
			</div>
		</fieldset>
	</form>
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