<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->securityControl->isAllowed("Member");

$memberControl = BaseFactory::getMemberControl();
$addressControl = BaseFactory::getAddressControl();

if (!$member = $memberControl->item($application->securityControl->getMemberId())) {
	$application->securityControl->LogOff();
}

switch($application->parseSubmit()) {
	case "Log Off":
		$application->doNotStorePage();
		$application->securityControl->logOff();
		break;
	case "Yes":
		$application->doNotStorePage();
		$application->required($_GET["Data"]);
		$addressControl->delete($_GET["Data"]);
		$application->gotoLastPage();
	default:
		$addressControl = $member->getManyToManyControl("Addresses");
		break;
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
		<div id="container" class="<?php echo $section; ?> index">
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
					<p>Need to make a change to any of the below details? You can <a href="/account/control.php">update your details here</a>.</p>

					<h3>About you</h3>
					<dl>
						<dt>Your Name</dt>
						<dd><?php echo $member->get("FirstName"); ?> <?php echo $member->get("LastName"); ?></dd>
						<dt>Username</dt>
						<dd><?php echo $member->get("Alias"); ?></dd>
						<dt>E-mail Address</dt>
						<dd><?php echo $member->get("EmailAddress"); ?></dd>
						<dt>Your Birthday</dt>
						<dd><?php echo $member->getFormatted("DateOfBirth"); ?></dd>
						<dt>Password</dt>
						<dd>**********</dd>
					</dl>

					<h3>Your profile</h3>
					<dl>
						<dt>Your Website</dt>
						<dd><?php echo $member->get("WebSite"); ?></dd>
						<dt>Your Signature</dt>
						<dd><?php echo $member->getFormatted("Signature"); ?></dd>
<?php
if ($member->get("ImageId") != null) {
?>
						<dt>Your Avatar</dt>
						<dd><?php echo $htmlControl->showImageBinary($member->get("ImageId"), $member->get("Alias"), 100, 100); ?></dd>
<?php
}
?>
						<dt>Member Since</dt>
						<dd><?php echo $member->getFormatted("DateCreated"); ?></dd>
						<dt>Last Visit</dt>
						<dd><?php echo $member->getFormatted("LastVisit"); ?></dd>
					</dl>

					<h3>Your address details</h3>
<?php
if ($addressControl->getNumRows() > 0) {
	while ($address = $addressControl->getNext()) {
?>
					<dl>
						<dt>Description</dt>
						<dd><?php echo $address->get("Description"); ?> <a href="/message.php?Submit=Delete&amp;Ids=<?php echo $address->get("Id"); ?>&amp;Return=index.php">(delete)</a></dd>
						<dt>Name</dt>
						<dd><?php echo $address->get("FirstName") . " " . $address->get("LastName"); ?></dd>
						<dt>Address</dt>
						<dd><?php echo AddressFormatter::create($address); ?> <a href="control-address.php?Submit=Edit&amp;AddressId=<?php echo $address->get("Id"); ?>&amp;ReturnUrl=index.php">(edit)</a></dd>
					</dl>
<?php
	}
} else {
?>
					<p>There are currently no addresses linked to this contact. You can <a href="control-address.php?Submit=New">add a new address here</a>.</p>
<?php
}
?>

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