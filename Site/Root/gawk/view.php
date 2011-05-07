<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);

if (!$member = $memberControl->getMemberByRequestUrl($_SERVER["REQUEST_URI"])) {
	include "Site/Root/error/404.php";
}

$videoControl = Factory::getMemberControl();
if (!$video = $videoControl->getVideoByRequestUrl($_SERVER["REQUEST_URI"])) {
	include "Site/Root/error/404.php";
}

$memberAuthentication = Factory::getMemberAuthentication();

$memberIsVideoAuthor = false;
if ($loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	if ($loggedInMemberDataEntity->get("SecureId") == $video->memberSecureId) {
		$memberIsVideoAuthor = true;
	}
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "Gawk by " . $member->alias . " / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div><a href="/">Back to Wall</a></div>
<div id="gawk-view" style="display: none;">
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
		initView: "GawkView",
		member: "<?php echo addslashes(json_encode($member)); ?>",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();