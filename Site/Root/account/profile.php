<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->securityControl->isAllowed("Member");

$application->required($_GET["Id"]);

$memberControl = BaseFactory::getMemberControl();

if (!$member = $memberControl->item($_GET["Id"])) {
	$application->gotoLastPage();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $sectionTitle; ?> / <?php echo $application->registry->get("Title"); ?></title>
<?php
include("resource/page-component/metadata.php");
?>
		<link rel="stylesheet" type="text/css" href="/resource/css/section/<?php echo $section; ?>.css?v=@VERSION-NUMBER@" media="all" />
	</head>
	<body>
		<div id="container" class="<?php echo $section; ?> profile">
			<div id="wrapper">
				<div id="header">
<?php
include("resource/page-component/header.php");
?>
				</div>
				<div id="navigation">
<?php
include("resource/page-component/navigation.php");
?>
				</div>
				<div id="main-content">
<!-- Start of Main Content -->

					<h2><span><?php echo $sectionTitle; ?></span></h2>
<?php
include("resource/page-component/account/section-navigation.php");
?>
					<h3>Member profile</h3>
					<dl>
						<dt>Username</dt>
						<dd><?php echo $member->get("Alias"); ?></dd>
						<dt>Website</dt>
						<dd><?php echo $member->get("WebSite"); ?></dd>
						<dt>Signature</dt>
						<dd><?php echo $member->getFormatted("Signature"); ?></dd>
<?php
	if ($member->get("ImageId") != null) {
?>
						<dt>Avatar</dt>
						<dd><?php echo $htmlControl->showImageBinary($member->get("ImageId"), $member->get("Alias"), 100, 100); ?></dd>
<?php
}
?>
						<dt>Member Since</dt>
						<dd><?php echo $member->getFormatted("DateCreated"); ?></dd>
						<dt>Last Visit</dt>
						<dd><?php echo $member->getFormatted("LastVisit"); ?></dd>
					</dl>

<!-- End of Main Content -->
				</div>
			</div>
			<div id="utility">
<?php
include("resource/page-component/utility.php");
?>
			</div>
<?php
include("resource/page-component/footer.php");
?>
		</div>
	</body>
</html>