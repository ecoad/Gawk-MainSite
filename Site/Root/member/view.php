<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);

$memberControl = Factory::getMemberControl();
if (!$member = $memberControl->getMemberByRequestUrl($_SERVER["REQUEST_URI"])) {
	include "Site/Root/error/404.php";
}

$memberAuthentication = Factory::getMemberAuthentication();

$memberIsOnOwnMemberPage = false;
if ($loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	if ($loggedInMemberDataEntity->get("SecureId") == $member->secureId) {
		$memberIsOnOwnMemberPage = true;
	}
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $member->alias . " / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div><a href="/">Back to main page</a></div>
<div id="public-profile-view" style="display: none;">
	<h1><?php echo $member->alias; ?></h1>
<?php
if ($memberIsOnOwnMemberPage) {
?>
	<p><a href="/u/<?php echo $member->alias; ?>/edit">Edit your profile</a></p>
<?php
}
?>
	<div class="friendship">
		<a href="#" class="logged-in" style="display: none;">Befriend</a>
		<a href="/member/login/" class="logged-out" style="display: none;">Login to add friends</a>
	</div>
	<?php echo $member->profileVideoLocation; ?>

	<div class="recent-gawks">
		<h2>Recent Gawks</h2>
		<p>(insert mini gawk wall)</p>
	</div>

</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript" src="/resource/js/application/gawk/member/member-friend-control.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/public-profile-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "PublicProfile",
		member: "<?php echo addslashes(json_encode($member)); ?>",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();