<?php
require_once("Application/Bootstrap.php");

$facebook = Factory::getFacebook($application);
$wallControl = Factory::getWallControl();
$memberAuthentication = Factory::getMemberAuthentication();
if (!$memberAuthentication->isLoggedIn()) {
	$application->redirect("/?Login&ReturnUrl=" . $application->getCurrentUrl());
}

$createRequestUrl = "/wall/create";
$wallCreate = substr($_SERVER["REQUEST_URI"], 0, strlen($createRequestUrl)) == $createRequestUrl;

$urlParts = explode("/", $_SERVER["REQUEST_URI"]);
$urlName = $urlParts[3];
if ($wallCreate) {
	$wall = Factory::getWall();
	$wall->url = $urlName;
} else {
	if ((!$wall = $wallControl->getWallByUrlFriendlyName($urlName)) || !$wallControl->isMemberAuthorizedToEditWallBySecureId($wall->secureId)) {
		$application->displayErrorPage("Site/Root/error/404.php", 404);
	}
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "wall " . ($wallCreate ? "create" : "edit") . " / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "wall-edit");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
	<div id="gawk-framework">
		<div id="wall-edit-view">
<?php include "Site/Template/Default/Gawk/Wall/WallEditView.php"; ?>
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
		initView: "WallEdit",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();