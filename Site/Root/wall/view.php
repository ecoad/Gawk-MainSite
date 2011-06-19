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
	$application->redirect("/?Login=1");
}

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $wall->name . " / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", $_SERVER["REQUEST_URI"] == "/wall/" ? "wall-select" : "wall");
$layout->wallPainter = Factory::getWallPainter($wall);
$layout->start("Style");
?>
	<link rel="stylesheet" type="text/css" href="/resource/css/wall-view.css?v=@VERSION-NUMBER@" media="all" />
<?php
$layout->start("Main");
// The main page content goes here.
?>
	<div id="gawk-framework">
		<div id="wall-view">
			<div id="title-area">
<?php
if ($layout->wallPainter->hasLogo()) {
?>
				<div class="wall-logo">
<?php
	if ($layout->wallPainter->hasLink()) {
?>
					<a title="Visit <?php echo $layout->wallPainter->getLink(); ?>"
						href="<?php echo $layout->wallPainter->getLink(); ?>">
						<?php echo $layout->wallPainter->getLogo(); ?>
					</a>
<?php
	} else {
?>
					<?php echo $layout->wallPainter->getLogo(); ?>
<?php
	}
?>
				</div>
<?php
}
?>
				<div class="wall-information">
					<div class="upper clear-fix">
						<h2><?php echo $wall->name; ?></h2>
<?php
if (!$systemWallFactory->isSystemWall($wall->secureId)) {
?>
						<span class="bookmark"></span>
<?php
}
?>
					</div>
					<p class="description"><?php echo $wall->description; ?></p>
				</div>
				<div class="wall-controls">
					<div class="wall-select" style="display: none;">
<?php
	if (false && ($wallControl->isMemberAuthorizedToEditWallBySecureId($wall->secureId))) {
?>
						<a href="/wall/edit/<?php echo $wall->url; ?>">edit</a>
<?php
	}
?>
						<form class="select-wall" method="get" action="">
							<select name="SelectWall">
							</select>
						</form>
					</div>
					<div class="record-gawk">
						<a href="#" class="record"><span>record</span></a>
					</div>
				</div>
			</div>
			<div class="view-container">
				<div id="Gawk">You don't have Flash! <a href="http://get.adobe.com/flashplayer/">Please download Flash</a> or use a browser that supports Flash.</div>
				<div class="share">
					<span class="twitter">
						<iframe allowtransparency="true" frameborder="0" scrolling="no"
							src="http://platform.twitter.com/widgets/tweet_button.html"
							style="width:97px; height:20px;"></iframe>
					</span>
					<span class="facebook">
						<fb:like href="www.gawkwall.com" send="false" layout="button_count" width="83" show_faces="false" font="arial"></fb:like>
					</span>
				</div>
			</div>





		</div>
	</div>
	<div style="display: none;">
		<div class="overlay wall-select" id="gawk-main-wall-overlay">
			<div class="graphic"></div>
			<h3>you can't gawk on this wall</h3>
			<p>the main wall is a collection of the best and latest gawks from other walls, <strong>you can either:</strong></p>
			<div class="options">
				<a class="pick-another" href="/wall/" title="gawk on another wall"><span>another wall</span></a>
				<a class="create-wall" href="/wall/" title="create a new wall"><span>create a wall</span></a>
			</div>
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