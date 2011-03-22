<?php
require_once("Application/Bootstrap.php");

$facebook = Factory::getFacebook($application);
$wallControl = Factory::getWallControl();
if (!$wall = $wallControl->getWallByRequestUrl($_SERVER["REQUEST_URI"])) {
	include "Site/Root/error/404.php";
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
	<div id="gawk-framework">
		<div id="gawk-view" style="display: none;">
<?php include "Site/Template/Default/Gawk/GawkView.php"; ?>
		</div>
		<div id="wall-select-view" style="display: none;">
<?php include "Site/Template/Default/Gawk/Wall/WallSelectView.php"; ?>
		</div>
		<div id="wall-edit-view" style="display: none;">
<?php include "Site/Template/Default/Gawk/Wall/WallEditView.php"; ?>
		</div>
		<div id="yours-view" style="display: none;">
<?php include "Site/Template/Default/Gawk/YoursView.php"; ?>
		</div>
		<div id="login-view" style="display: none;">
<?php include "Site/Template/Default/Gawk/LoginView.php"; ?>
		</div>
	</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript" src="/resource/js/jquery/jquery.json-2.2.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/config/config.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/widgets/login-widget.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/widgets/navigation-widget.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/login-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/wall-select-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/wall-edit-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/yours-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/gawk-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/member/member-control.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/wall/wall-control.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/gawk.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/swfobject/swfobject.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/jquery/jquery.placeholder.js"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "Gawk",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		currentWallId: "<?php echo $wall->secureId; ?>",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();