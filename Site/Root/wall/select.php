<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);
$wallControl = Factory::getWallControl();
$memberAuthentication = Factory::getMemberAuthentication();
$memberWallBookmarkControl = Factory::getMemberWallBookmarkControl();

if (!$memberAuthentication->isLoggedIn()) {
	$application->redirect("/?Login=1&ReturnUrl=" . $_SERVER["SCRIPT_NAME"]);
}

if (!$loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	throw new Exception("Cannot retrieve logged in member");
}

$loggedInMember = $loggedInMemberDataEntity->toObject();

$recentWallActivity = $memberWallBookmarkControl->getRecentWallActivity($loggedInMember);

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "wall-select");
$layout->start("Style");
?>
<link rel="stylesheet" type="text/css" href="/resource/css/wall-select.css?v=@VERSION-NUMBER@" media="all" />
<?php
$layout->start("Main");
// The main page content goes here.
?>
<div id="wall-select-view">
	<div id="title-area">
		<div class="breadcrumb">
			<a href="/">home</a> / <a href="/wall/">wall</a> / create wall
		</div>
	</div>
	<div class="view-container" >
		<div class="clear-fix">
			<div class="create-wall">
				<h1 class="page-title">create a wall</h1>
				<h2>why create a wall?</h2>
				<ul>
					<li><span>share amongst a group of friends</span></li>
					<li><span>remember a wedding or birthday by sending your wall to your guests</span></li>
					<li><span>get out and about with the <a href="#">iPhone app</a></span></li>
					<li><span>choose between public and private walls</span></li>
				</ul>
				<form class="url-select" method="post" action="">
					<label>
						<input type="text" name="UrlFriendly"
							class="textbox"/><a href="#" class="button" title="create a new wall"><span>create wall</span></a>
					</label>
				</form>
			</div>
			<div class="select-walls">
				<h1 class="page-title">select a wall</h1>
				<h2>your walls and bookmarks</h2>
				<div class="wall-list clear-fix">
					<ul>
						<li class="title">
							<h3>walls created</h3>
						</li>
<?php
if (count($recentWallActivity->wallsCreatedByMember) == 0) {
?>
						<li>no walls (<a class="underline" href="/wall/create">create a wall</a>)</li>
<?php
}
foreach ($recentWallActivity->wallsCreatedByMember as $memberWall) {
?>
						<li>
							<a title="<?php echo $memberWall->description; ?>"
								class="underline" href="/<?php echo $memberWall->url; ?>"><?php echo $memberWall->name; ?></a>
						</li>
<?php
}
?>
					</ul>
				</div>
				<div class="wall-list">
					<ul>
						<li class="title">
							<h3>bookmarked</h3>
						</li>
<?php
if (count($recentWallActivity->bookmarks) == 0) {
?>
						<li>no bookmarks</li>
<?php
}
foreach ($recentWallActivity->bookmarks as $memberBookmark) {
?>
						<li>
							<a title="<?php echo $memberBookmark->description; ?>"
								href="/<?php echo $memberBookmark->url; ?>"><?php echo $memberBookmark->name; ?></a>
						</li>
<?php
}
?>
					</ul>
				</div>
			</div>
		</div>
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