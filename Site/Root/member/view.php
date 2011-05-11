<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);
$memberUrlHelper = Factory::getMemberUrlHelper();
$videoUrlHelper = Factory::getVideoUrlHelper();
$videoControl = Factory::getVideoControl();

$memberControl = Factory::getMemberControl();
if (!$member = $memberControl->getMemberByRequestUrl($_SERVER["REQUEST_URI"], true)) {
	include "Site/Root/error/404.php";
}

$memberAuthentication = Factory::getMemberAuthentication();

$memberIsOnOwnMemberPage = false;
if ($loggedInMemberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	if ($loggedInMemberDataEntity->get("SecureId") == $member->secureId) {
		$memberIsOnOwnMemberPage = true;
	}
}

$memberWallBookmarkWebService = Factory::getMemberWallBookmarkWebService();
$recentWallActivityResponse = $memberWallBookmarkWebService->handleRequest(
	MemberWallBookmarkWebService::SERVICE_GET_RECENT_WALL_ACTIVITY, null, array("Token" => $member->token));
$recentWallActivity = $recentWallActivityResponse->recentActivity;

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $member->alias . " / " . $application->registry->get("Title"));
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
	<a href="/">home</a> / <a title="View profile" href="<?php echo $memberUrlHelper->getProfileUrl($member); ?>">profile</a> /
		<?php echo $member->alias; ?>
	<hr />
</div>
<div id="public-profile-view">
	<div class="profile-main">
		<div class="profile-gawk">
			<img src="http://dummyimage.com/175x131/000/fff.png&text=profile+here" />
		</div>
		<div class="details">
			<div class="name">
				<h1><?php echo $member->alias; ?></h1>
				<span class="gawk-count"><?php echo $videoControl->getVideoCountByMember($member); ?> gawks</span>
				<div class="controls">
<?php
if ($memberIsOnOwnMemberPage) {
?>
					<a class="button edit-profile" href="/u/<?php echo $member->alias; ?>/edit">edit your profile</a>
<?php
} else {
?>
					<a class="button add-friend" href="#">add friend</a>
<?php
}
?>
				</div>
			</div>
			<p class="website"><a href="<?php echo $member->website; ?>"><?php echo $member->website; ?></a></p>
			<p class="description"><?php echo $member->description; ?></p>
		</div>
		</div>
	</div>
	<div class="recent-gawks">
		<h2>most recent gawks</h2>
		<img src="http://dummyimage.com/175x131/000/fff.png&text=recent+gawks" /><img src="http://dummyimage.com/175x131/000/fff.png&text=recent+gawks" /><img src="http://dummyimage.com/175x131/000/fff.png&text=recent+gawks" /><img src="http://dummyimage.com/175x131/000/fff.png&text=recent+gawks" /><img src="http://dummyimage.com/175x131/000/fff.png&text=recent+gawks" /><img src="http://dummyimage.com/175x131/000/fff.png&text=recent+gawks" />
	</div>
	<div class="profile-other">
		<div class="friends beancan">
			<h2><?php echo $member->alias; ?>'s friends</h2>
			<ul>
<?php
foreach ($member->friends as $friend) {
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
					<li>no walls<?php echo $memberIsOnOwnMemberPage ? " (<a href=\"/wall/\">create a wall</a>)" : ""; ?></li>
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
		member: "<?php echo addslashes(json_encode($member)); ?>",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();