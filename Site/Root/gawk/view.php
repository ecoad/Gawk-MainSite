<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);
$memberControl = Factory::getMemberControl();
$videoControl = Factory::getVideoControl();
$wallControl = Factory::getWallControl();

if (!$member = $memberControl->getMemberByRequestUrl($_SERVER["REQUEST_URI"])) {
	include "Site/Root/error/404.php";
}

if (!$video = $videoControl->getVideoByRequestUrl($_SERVER["REQUEST_URI"])) {
	include "Site/Root/error/404.php";
}

if (!$wall = $wallControl->getWallWithSecureId($video->wallSecureId)) {
	throw new RuntimeException("Video SecureID: " . $video->wallSecureId . " linking to non-existing wall");
}

$memberAuthentication = Factory::getMemberAuthentication();
$memberUrlHelper = Factory::getMemberUrlHelper();

$memberIsVideoAuthor = false;
if ($loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	if ($loggedInMemberDataEntity->get("SecureId") == $video->memberSecureId) {
		$memberIsVideoAuthor = true;
	}
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "Gawk by " . $member->alias . " / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "profile");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div><a href="/">Back to Wall</a></div>
<div id="gawk-view">
	Insert gawk here
	<ul>
		<li>
			<a href="<?php echo $memberUrlHelper->getProfileUrl($member); ?>">
				view <?php echo $member->firstName; ?>'s profile
			</a>
		</li>
		<li>

		</li>
	</ul>
	<?php var_dump($wall); ?>
	<?php var_dump($video); ?>
	<?php var_dump($member); ?>
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