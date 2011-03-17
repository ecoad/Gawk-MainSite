<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->doNotStorePage();
$application->required($_GET["Id"]);

$memberControl = BaseFactory::getMemberControl();
if ($member = $memberControl->confirm($_GET["Id"])) {
	$message = "Account Confirmed &ndash; you may now use the site unhindered";
} else {
	$message = "Confirmed";
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
		<div id="container" class="<?php echo $section; ?> confrim">
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
					<h3>Account Confirmed</h3>
					<p>You are now confirmed as the owner of this account.</p>

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