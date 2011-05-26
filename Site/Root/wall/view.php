<?php
require_once("Application/Bootstrap.php");

$facebook = Factory::getFacebook($application);
$wallControl = Factory::getWallControl();
$systemWallFactory = Factory::getSystemWallFactory();

if (!$wall = $wallControl->getWallByRequestUrl($_SERVER["REQUEST_URI"])) {
	include "Site/Root/error/404.php";
}
$memberAuthentication = Factory::getMemberAuthentication();
if ($memberAuthentication->isRequestLogInOnly($_SERVER["REQUEST_URI"]) &&  !$memberAuthentication->isLoggedIn()) {
	$application->redirect("/?Login");
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", $_SERVER["REQUEST_URI"] == "/wall/" ? "wall-select" : "wall");
$layout->start("Style");
$layout->start("Main");
// The main page content goes here.
?>
	<div id="gawk-framework">
		<div id="wall-view">
<?php include "Site/Template/Default/Gawk/GawkView.php"; ?>
		</div>
	</div>
	<div style="display: none;">
		<div class="overlay" id="gawk-main-wall-overlay">
			<h3>you can't gawk on this wall</h3>
			<p>the main wall is a collection of the best and latest gawks from other walls</p>
			<ul>
				<li>pick <a href="/wall/">another wall</a></li>
				<li>create one<br />
					<form method="post" action="">
						<?php echo $application->registry->get("Site/Address"); ?>/<input 
							type="text" name="WallCreateName"/> <input type="submit" name="Submit" value="create wall" />
					</form>
				</li>
			</ul>
		</div>
		<div class="overlay" id="gawk-no-webcam-overlay">
			<h3>you don't seem to have a webcam!</h3>
			<p>you need a webcam or the <a href="#">iPhone app</a> to record gawks</p>
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
	<script type="text/javascript" src="/resource/js/application/gawk/views/wall-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "Wall",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		currentWall: "<?php echo addslashes(json_encode($wall)); ?>",
		systemWall: "<?php echo $systemWallFactory->isSystemWall($wall->secureId); ?>",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();