<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Member Admin");

$memberControl = BaseFactory::getMemberControl();

// Page Defaults
$_GET["Filter"] = $application->defaultValue($_GET["Filter"], "");
$_GET["CurrentPage"] = $application->defaultValue($_GET["CurrentPage"], 1);
$_GET["Order"] = $application->securityControl->getSetting(
	"Admin::Member::Order", $_GET["Order"], $memberControl->getDefaultOrder());
$_GET["Desc"] = $application->securityControl->getSetting(
	"Admin::Member::Desc", $_GET["Desc"], "");
$_GET["PageLength"] = $application->securityControl->getSetting(
	"Admin::Member::ListSize", $_GET["PageLength"], $application->registry->get("ListSize"));

$filter = CoreFactory::getFilter();
$filter->addOrder($_GET["Order"], $_GET["Desc"] == "True");
$memberControl->setFilter($filter);

switch($application->parseSubmit()) {
	case "Clear":
		$_GET["Filter"] = "";
		break;
	case "Submit":
	case "Filter":
		$memberControl->search($_GET["Filter"], false);
		break;
}

$_GET = $htmlControl->sanitise($_GET);

$queryStringControl = CoreFactory::getQueryString();
$htmlMultiPageControlResultsFormatter = CoreFactory::getHtmlMultiPageControlResultsFormatter();
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
		<li class="active"><a href="#">View List</a></li>
		<li class="inactive">View</li>
		<li class="inactive">Edit</li>
		<li><a href="control.php?Submit=New">New</a></li>
	</ul>
</div>
<form action="" method="get">
	<fieldset class="filter">
		<input name="Filter" type="text" class="textbox medium"
			value="<?php echo $_GET["Filter"]; ?>"
			title="Enter the word or phrase you wish to filter the results by then click the 'Filter' button" />
		<input name="Submit" type="submit" class="button" value="Filter"
			title="Filter the results by a given word or phrase" />
		<input name="Submit" type="submit" class="button" value="Clear"
			title="Clear results filter and show all results" />
	</fieldset>
</form>

<form action="control.php" method="get">
<table class="data-entity" summary="Members">
	<tr>
		<th class="selector"><input id="select-all" type="checkbox" /></th>
		<th class="button">&nbsp;</th>
		<th class="thumbnail">&nbsp;</th>
		<th class="text"><a href="?<?php echo $queryStringControl->getValues("Order", "Alias"); ?>"
			class="sortstate<?php echo $queryStringControl->getStat(); ?>" title="Order by Alias">Alias</a></th>
		<th class="text"><a href="?<?php echo $queryStringControl->getValues("Order", "LastName"); ?>"
			class="sortstate<?php echo $queryStringControl->getStat(); ?>" title="Order by Last Name">Name</a></th>
		<th class="text"><a href="?<?php echo $queryStringControl->getValues("Order", "EmailAddress"); ?>"
			class="sortstate<?php echo $queryStringControl->getStat(); ?>" title="Order by Email Address">E-mail</a></th>
		<th class="date"><a href="?<?php echo $queryStringControl->getValues("Order", "LastVisit"); ?>"
			class="sortstate<?php echo $queryStringControl->getStat(); ?>" title="Order by Last Visit">Last Visit</a></th>
	</tr>
<?php
while ($member = $memberControl->getPage($_GET["CurrentPage"], $_GET["PageLength"])) {
?>
	<tr>
		<td class="selector">
			<input name="Ids[]" id="Id<?php echo $member->get("Id"); ?>" type="checkbox" value="<?php echo $member->get("Id"); ?>" />
		</td>
		<td class="button">
			<a href="control.php?Submit=Edit&amp;Id=<?php echo $member->get("Id"); ?>">Edit</a>
		</td>
		<td class="thumbnail">
<?php
if (!$member->isNull("ImageId")) {
?>
		<a href="view.php?Submit=View&amp;Id=<?php echo $member->get("Id"); ?>">
		<?php echo $htmlControl->showImageBinary($member->getRelation("ImageId"), $member->get("Alias"), 50, 40, false, true); ?></a>
<?php
}
?>
		</td>
		<td class="text">
			<a href="view.php?Submit=View&amp;Id=<?php echo $member->get("Id"); ?>"><?php echo $member->getFormatted("Alias"); ?></a>
		</td>
		<td class="text">
			<?php echo $member->getFormatted("FirstName"); ?> <?php echo $member->getFormatted("LastName"); ?>
		</td>
		<td class="text">
			<?php echo $member->getFormatted("EmailAddress"); ?>
		</td>
		<td class="date">
			<?php echo $member->getFormatted("LastVisit"); ?>
		</td>
	</tr>
<?php
}
?>
</table>
	<div class="controls">
		<input name="Submit" type="submit" class="button" value="Delete" onclick="applicationControl.confirmDelete(); return false;" accesskey="d"
			title="Delete the current selection rows. (Warning once deleted there is no way to retrieve the data)" />
		<input class="button control-separator" type="submit" value="New" name="Submit"
			title="Create a new member" />
	</div>
</form>
<form action="" method="get">
	<div class="multipage-controls">
		<?php echo $htmlMultiPageControlResultsFormatter->display($memberControl, $queryStringControl); ?>
	</div>
</form>

<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>
<script type="text/javascript" src="/resource/js/jquery/jquery.checkboxmaster.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$("#select-all").checkboxMaster();
});
//]]>
</script>

<?php
$layout->render();