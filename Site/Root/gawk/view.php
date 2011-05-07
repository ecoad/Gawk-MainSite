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
$video->dateCreatedFormatted = date("jS M Y H:i", strtotime($video->dateCreated));

if (!$wall = $wallControl->getWallWithSecureId($video->wallSecureId)) {
	throw new RuntimeException("Video SecureID: " . $video->wallSecureId . " linking to non-existing wall");
}

$memberAuthentication = Factory::getMemberAuthentication();
$memberUrlHelper = Factory::getMemberUrlHelper();
$videoUrlHelper = Factory::getVideoUrlHelper();

$memberIsVideoAuthor = false;
if ($loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	if ($loggedInMemberDataEntity->get("SecureId") == $video->memberSecureId) {
		$memberIsVideoAuthor = true;
	}
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "gawk by " . $member->alias . " / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "profile");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
<div class="breadcrumb">
	<a href="/">home</a> / <a title="View profile" href="<?php echo $memberUrlHelper->getProfileUrl($member); ?>">
		<?php echo $member->alias; ?></a> / <a href="<?php echo $videoUrlHelper->getVideoUrl($video, $member); ?>">view gawk</a> /
		<?php echo $video->secureId; ?>
</div>
<div id="gawk-view">
	<div><img src="http://dummyimage.com/175x131/000/fff.png&text=video+here" /></div>
	<ul>
		<li>
			by: <a title="View profile" href="<?php echo $memberUrlHelper->getProfileUrl($member); ?>">
			<?php echo $member->alias; ?></a> on <?php echo $video->dateCreatedFormatted; ?>
		</li>
		<li>from: <a href="/<?php echo $wall->url; ?>"><?php echo $wall->name; ?></a></li>
	</ul>
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