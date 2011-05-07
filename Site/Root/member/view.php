<?php
require_once("Application/Bootstrap.php");
$facebook = Factory::getFacebook($application);
$memberUrlHelper = Factory::getMemberUrlHelper();
$videoUrlHelper = Factory::getVideoUrlHelper();

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
$layout->start("Main");
// The main page content goes here.
?>
<div class="breadcrumb">
	<a href="/">home</a> / <a title="View profile" href="<?php echo $memberUrlHelper->getProfileUrl($member); ?>">profile</a> /
		<?php echo $member->alias; ?>
</div>
<div id="public-profile-view" style="display: none;">
	<h1><?php echo $member->alias; ?></h1>
<?php
if ($memberIsOnOwnMemberPage) {
	/*
?>
	<p><a href="/u/<?php echo $member->alias; ?>/edit">edit your profile</a></p>
<?php
	*/
} else {
?>
	<div class="friendship">
		<a href="#" class="logged-in" style="display: none;">Befriend</a>
		<a href="/member/login/" class="logged-out" style="display: none;">Login to add friends</a>
	</div>
<?php
}
?>
	<div class="friends">
		<h2>friends</h2>
		<ul>
<?php
foreach ($member->friends as $friend) {
?>
			<li>
				<a href="<?php echo $memberUrlHelper->getProfileUrl($friend); ?>" title="View profile">
					<?php echo $friend->alias; ?>
				</a>
			</li>
<?php
}
?>
		</ul>
	</div>
	<div class="walls">
		<h2>walls</h2>
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
				<a href="/<?php echo $memberBookmark->url; ?>"><?php echo $memberBookmark->name; ?></a> [x]
			</li>
<?php
}
?>
		</ul>
		<h3>walls created by <?php echo $member->alias; ?></h3>
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
		<h3>walls <?php echo $member->alias; ?> has participated on</h3>
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

	<div class="recent-gawks">
		<h2>Recent Gawks</h2>
		<p>(insert mini gawk wall)</p>
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