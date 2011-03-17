<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Member Admin");
$memberControl = BaseFactory::getMemberControl();

$application->required($_GET["Submit"]);
switch($application->parseSubmit()) {
	case "Add New Address":
		$application->required($_POST["Id"]);
		$application->redirect("/admin/member/address/control.php?Submit=New&MemberId=" . $_POST["Id"]);
		break;
	case "View":
		$application->required($_GET["Id"]);
		if (!$member = $memberControl->item($_GET["Id"])) {
			$application->gotoLastPage();
		}
		break;
	case "Update":
		$application->required($_GET["Id"]);
		if (!$member = $memberControl->item($_GET["Id"])) {
			$application->gotoLastPage();
		}

		$securityGroupControl = BaseFactory::getSecurityGroupControl();
		$securityGroups = $securityGroupControl->getResultsAsFieldArray("Id");
		foreach($securityGroups as $securityGroup){
			$member->removeManyRelation("SecurityGroup", $securityGroup);
		}

		foreach($_GET["Ids"] as $securityGroupId){
			$member->addManyRelation("SecurityGroup", $securityGroupId);
		}
		break;

	// Stop badly formed page views
	default:
		$application->doNotStorePage();
		$application->redirect("index.php");
}

$securityGroupControl = BaseFactory::getSecurityGroupControl();
$memberToSecurityGroupControl = $member->getManyToManyControl("SecurityGroup");

$memberToSecurityGroup = $memberToSecurityGroupControl->getResultsAsFieldArray("Id");
$securityGroups = $securityGroupControl->getResultsAsFieldArray("Id");

$settingControl = BaseFactory::getSettingControl();
$settingControl->retrieveForMember($member);

$htmlSelectOptions = CoreFactory::getHtmlSelectOptions();

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", "Advanced / Member Details / " . $application->registry->get("Title") . " Admin");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "advanced");

// Layout begins here. Tech only above this line.
$layout->start("Style");
// Put your stylesheets here.
?>

<?php
$layout->start("Main");
// The main page content goes here.
?>

<h2><a href="/admin/">Admin</a> <span>/ <a href="/admin/advanced/">Advanced</a> <span>/ Member Details</span></span></h2>
<div class="tab-controls">
	<ul>
		<li><a href="index.php">View List</a></li>
		<li class="active"><a href="#">View</a></li>
		<li><a href="control.php?Submit=Edit&amp;Id=<?php echo $member->get("Id"); ?>">Edit</a></li>
		<li><a href="control.php?Submit=New">New</a></li>
	</ul>
</div>
<h3><?php echo $member->getFormatted("Alias"); ?></h3>
<dl>
	<dt>Name</dt>
	<dd><?php echo $member->getFormatted("FirstName"); ?> <?php echo $member->getFormatted("LastName"); ?> &ndash; <a href="mailto:<?php echo $member->getFormatted("EmailAddress"); ?>"><?php echo $member->getFormatted("EmailAddress"); ?></a></dd>
<?php
if (!$member->isNull("ImageId")) {
?>
	<dt>Avatar</dt>
	<dd><?php echo $htmlControl->showImageBinary($member->getRelation("ImageId"), $member->get("Alias"), 140, 130, false, true); ?></dd>
<?php
}

if (!$member->isNull("DateOfBirth")) {
?>
	<dt>Date of Birth</dt>
	<dd><?php echo $member->getFormatted("DateOfBirth"); ?></dd>
<?php
}
?>
	<dt>Date Registered</dt>
	<dd><?php echo $member->getFormatted("DateCreated"); ?></dd>
	<dt>Last Visit</dt>
	<dd><?php echo $member->getFormatted("LastVisit"); ?></dd>
	<dt>Blocked</dt>
	<dd><?php echo $member->getFormatted("Blocked"); ?></dd>
</dl>

<div class="expandable">
<h4 class="expander-switch"><strong>&#9658;</strong><span>&#9660;</span>&nbsp;More Info</h4>
	<div class="expander-panel">
<?php
if (!$member->isNull("MobileNumber")) {
?>
	<h5>Mobile Info</h5>
	<dl>
		<dt>Mobile Number</dt>
		<dd><?php echo $member->getFormatted("MobileNumber"); ?></dd>
		<dt>Mobile Operator</dt>
		<dd><?php echo $member->getFormatted("MobileOperator"); ?></dd>
		<dt>Mobile Confirmed</dt>
		<dd><?php echo $member->getFormatted("MobileConfirmed"); ?></dd>
	</dl>
<?php
}
?>
	<h5>Site</h5>
	<dl>
		<dt>Visits</dt>
		<dd><?php echo $member->getFormatted("Visits"); ?></dd>
		<dt>Forum Posts</dt>
		<dd><?php echo $member->getFormatted("Posts"); ?></dd>
<?php
if (!$member->isNull("WebSite")) {
?>
		<dt>Web Site</dt>
		<dd><?php echo $member->getFormatted("WebSite"); ?></dd>
<?php
}

if (!$member->isNull("Signature")) {
?>
		<dt>Signature</dt>
		<dd><?php echo $member->getFormatted("Signature"); ?></dd>
<?php
}
?>
		</dl>

		<h5>Privacy</h5>
		<dl>
			<dt>Receive E-mail Updates</dt>
			<dd><?php echo $member->getFormatted("ReceiveEmailUpdates"); ?></dd>
			<dt>Receive Related Promotions</dt>
			<dd><?php echo $member->getFormatted("ReceiveRelatedPromotions"); ?></dd>
		</dl>
	</div>
</div>

<div class="expandable">
	<h4 class="expander-switch"><strong>&#9658;</strong><span>&#9660;</span>&nbsp;Settings</h4>
	<div class="expander-panel">
<?php
if ($settingControl->getNumRows()  > 0) {
?>
	<dl>
<?php
	while ($setting = $settingControl->getNext()) {
?>
		<dt><?php echo $setting->get("Name"); ?></dt>
		<dd><?php echo $setting->get("Value"); ?></dd>
<?php
	}
?>
	</dl>
<?php
} else {
?>
	<p>There are no settings for this member</p>
<?php
}
?>
	</div>
</div>

<div class="expandable">
	<h4 class="expander-switch"><strong>&#9658;</strong><span>&#9660;</span>&nbsp;Security Privileges</h4>
	<div class="expander-panel">
		<div id="privileges">
			Users privileges...
<?php
//$currentSecurityGroups = array_diff($securityGroups, $memberToSecurityGroup);

//echo $htmlControl->createArrayListValues("", $securityGroups);
?>
			<form action="" method="get">
<?php
//echo $htmlControl->createArrayListValues("Name", $memberToSecurityGroup);
foreach ($securityGroups as $securityGroup) {
	$securityGroup = $securityGroupControl->item($securityGroup);
	$checked = in_array($securityGroup->get("Id"), $memberToSecurityGroup);
?>
				<label class="checkbox">
					<strong><?php echo $securityGroup->get("Name"); ?></strong>
					<input name="Ids[]" id="Id<?php echo $securityGroup->get("Id"); ?>" type="checkbox"
						value="<?php echo $securityGroup->get("Id"); ?>" <?php echo $htmlControl->check($checked) ?> />
				</label>
<?php
}
?>
				<input type="hidden" name="Id" value="<?php echo $member->get("Id") ?>" />
				<div class="controls">
					<input name="Submit" type="submit" class="button" value="Update" />
				</div>
			</form>
		</div>
	</div>
</div>

<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>

<script type="text/javascript" src="/resource/js/jquery/jquery.expander.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$("div.expandable").makeExpander();
});
//]]>
</script>
<?php
$layout->render();