<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);
$wallControl = Factory::getWallControl();
$memberAuthentication = Factory::getMemberAuthentication();
if (!$memberAuthentication->isLoggedIn()) {
	$application->redirect("/?Login&ReturnUrl=" . $application->getCurrentUrl());
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "wall-select");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
	<div id="gawk-framework">
		<div id="wall-select-view">
<?php include "Site/Template/Default/Gawk/Wall/WallSelectView.php"; ?>
		</div>
	</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript" src="/resource/js/application/gawk/wall/wall-control.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/member/member-recent-walls-control.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/member/member-wall-bookmark-control.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/login-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/wall-select-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/wall-edit-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "WallSelect",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();