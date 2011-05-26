<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);
$memberUrlHelper = Factory::getMemberUrlHelper();
$videoUrlHelper = Factory::getVideoUrlHelper();
$videoControl = Factory::getVideoControl();
$memberWallBookmarkControl = Factory::getMemberWallBookmarkControl();
$memberAuthentication = Factory::getMemberAuthentication();

$memberControl = Factory::getMemberControl();
if (!$profileMember = $memberControl->getMemberByRequestUrl($_SERVER["REQUEST_URI"], true)) {
	include "Site/Root/error/404.php";
}


$memberIsOnOwnMemberPage = false;
if ($loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	if ($loggedInMemberDataEntity->get("SecureId") == $profileMember->secureId) {
		$memberIsOnOwnMemberPage = true;
	}
}

$recentWallActivity = $memberWallBookmarkControl->getRecentWallActivity($profileMember);

$memberVideoCount = $videoControl->getVideoCountByMember($profileMember);

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $profileMember->alias . " / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "profile");
$layout->start("Style");
?>
<link media="all" href="/resource/css/profile.css?v=@VERSION-NUMBER@" type="text/css" rel="stylesheet"/>
<?php
$layout->start("Main");
// The main page content goes here.
?>
<div class="breadcrumb">
	<a href="/">home</a> / <a title="View profile" href="<?php echo $memberUrlHelper->getProfileUrl($profileMember); ?>">profile</a> /
		<?php echo $profileMember->alias; ?>
	<hr />
</div>
<div id="public-profile-view">
	<div class="profile-main">
		<div class="profile-gawk" style="display: <?php echo $memberVideoCount > 0 ? "block": "none"; ?>;">
			<div id="profile-swf-container">&nbsp;</div>
		</div>
		<div class="details">
			<div class="name">
				<h1><?php echo $profileMember->alias; ?></h1>
				<span class="gawk-count"><?php echo $memberVideoCount; ?> gawk<?php
					echo ($memberVideoCount != 1) ? "s" : ""; ?></span>
				<div class="controls">
<?php
if ($memberIsOnOwnMemberPage) {
?>
					<a class="button edit-profile" href="/u/<?php echo $profileMember->alias; ?>/edit">edit your profile</a>
<?php
} else {
?>
					<a class="button add-friend friend-control" href="#" style="display: none;">add friend</a>
<?php
}
?>
				</div>
			</div>
			<p class="website"><a href="http://<?php echo $profileMember->website; ?>"><?php echo $profileMember->website; ?></a></p>
			<p class="description"><?php echo $profileMember->description; ?></p>
		</div>
	</div>
	<div class="recent-gawks" style="display: <?php echo $memberVideoCount > 1 ? "block": "none"; ?>;">
		<h2>most recent gawks</h2>
		<div id="recent-swf-container">&nbsp;</div>
	</div>
	<div class="profile-other">
		<div class="friends beancan">
			<h2><?php echo $profileMember->alias; ?>'s friends</h2>
<?php
if (count($profileMember->friends) > 0) {
?>
			<ul>
<?php
	foreach ($profileMember->friends as $friend) {
?>
				<li class="friend">
					<a href="<?php echo $memberUrlHelper->getProfileUrl($friend); ?>" title="View profile">
						<img src="http://dummyimage.com/109x82/000/fff.png&text=<?php echo $friend->alias; ?>" />
					</a>
				</li>
<?php
	}
?>
			</ul>
<?php
} else {
?>
			<p>this person is a loner</p>
<?php
}
?>
		</div>
		<div class="walls beancan">
			<h2>walls</h2>
			<div class="wall-list">
				<h3>bookmarks</h3>
				<ul>
<?php
if (count($recentWallActivity->bookmarks) == 0) {
?>
					<li>no bookmarks</li>
<?php
}
foreach ($recentWallActivity->bookmarks as $memberBookmark) {
?>
					<li>
						<a href="/<?php echo $memberBookmark->url; ?>"><?php echo $memberBookmark->name; ?></a>
					</li>
<?php
}
?>
				</ul>
			</div>
			<div class="wall-list">
				<h3>walls created</h3>
				<ul>
<?php
if (count($recentWallActivity->wallsCreatedByMember) == 0) {
?>
					<li>no walls<?php echo $memberIsOnOwnMemberPage ? " (<a href=\"/wall/create\">create a wall</a>)" : ""; ?></li>
<?php
}
foreach ($recentWallActivity->wallsCreatedByMember as $memberWall) {
?>
					<li>
						<a href="/<?php echo $memberWall->url; ?>"><?php echo $memberWall->name; ?></a>
					</li>
<?php
}
?>
				</ul>
			</div>
			<div class="wall-list">
				<h3>recent walls</h3>
				<ul>
<?php
if (count($recentWallActivity->recentWallParticipation) == 0) {
?>
					<li>no walls</li>
<?php
}
foreach ($recentWallActivity->recentWallParticipation as $memberWallParticipation) {
?>
					<li>
						<a href="/<?php echo $memberWallParticipation->url; ?>"><?php echo $memberWallParticipation->name; ?></a>
					</li>
<?php
}
?>
				</ul>
			</div>
		</div>
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
		profileMember: "<?php echo addslashes(json_encode	($profileMember)); ?>",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();