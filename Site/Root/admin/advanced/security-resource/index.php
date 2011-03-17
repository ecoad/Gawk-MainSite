<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Security Resource Admin");
$securityResourceControl = BaseFactory::getSecurityResourceControl();

// Page Defaults
$_GET["Filter"] = $application->defaultValue($_GET["Filter"], "");
$_GET["CurrentPage"] = $application->defaultValue($_GET["CurrentPage"], 1);
$_GET["Order"] = $application->securityControl->getSetting(
	"Admin::SecurityResource::Order", $_GET["Order"], $securityResourceControl->getDefaultOrder());
$_GET["Desc"] = $application->securityControl->getSetting(
	"Admin::SecurityResource::Desc", $_GET["Desc"], "");
$_GET["PageLength"] = $application->securityControl->getSetting(
	"Admin::SecurityResource::ListSize", $_GET["PageLength"], $application->registry->get("ListSize"));

$filter = CoreFactory::getFilter();
$filter->addOrder($_GET["Order"], $_GET["Desc"] == "True");

$securityResourceControl->setFilter($filter);

switch($application->parseSubmit()) {
	case "Clear":
		$_GET["Filter"] = "";
		break;
	case "Filter":
		$securityResourceControl->search($_GET["Filter"]);
		break;
}

$_GET = $htmlControl->sanitise($_GET);
$queryStringControl = CoreFactory::getQueryString();
$htmlMultiPageControlResultsFormatter = CoreFactory::getHtmlMultiPageControlResultsFormatter();

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", "Advanced / Security Resources / " . $application->registry->get("Title") . " Admin");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "news");

// Layout begins here. Tech only above this line.
$layout->start("Style");
// Put your stylesheets here.
?>

<?php
$layout->start("Main");
// The main page content goes here.
?>

<h2><a href="/admin/">Admin</a> <span>/ <a href="/admin/advanced/">Advanced</a> <span>/ Security Resources</span></span></h2>
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
	<table class="data-entity" summary="Security Resource">
		<tr>
			<th class="selector"><input id="select-all" type="checkbox"/></th>
			<th class="button">&nbsp;</th>
			<th class="text"><a href="?<?php echo $queryStringControl->getValues("Order", "Name"); ?>" class="sortstate<?php echo $queryStringControl->getStat(); ?>" title="Order by Name">Name</a></th>
			<th class="text"><a href="?<?php echo $queryStringControl->getValues("Order", "Description"); ?>" class="sortstate<?php echo $queryStringControl->getStat(); ?>" title="Order by Description">Description</a></th>
		</tr>
<?php
while ($securityResource = $securityResourceControl->getPage($_GET["CurrentPage"], $_GET["PageLength"])) {
?>
		<tr>
			<td class="selector">
				<input name="Ids[]" id="Id<?php echo $securityResource->get("Id"); ?>" type="checkbox" value="<?php echo $securityResource->get("Id"); ?>" />
			</td>
			<td class="button"><a href="control.php?Submit=Edit&amp;Id=<?php echo $securityResource->get("Id"); ?>">Edit</a></td>
			<td class="text">
				<?php echo $securityResource->getFormatted("Name"); ?>
			</td>
			<td class="text">
				<?php echo $securityResource->getFormatted("Description"); ?>
			</td>
		</tr>
<?php
}
?>
	</table>
	<div class="controls">
		<input name="Submit" type="submit" class="button" value="Delete" onclick="applicationControl.confirmDelete(); return false;" accesskey="d"
			title="Delete the current selection rows. (Warning once deleted there is no way to retrieve the data)" />
	</div>
</form>
<form action="" method="get">
	<div class="multipage-controls">
		<?php echo $htmlMultiPageControlResultsFormatter->display($securityResourceControl, $queryStringControl); ?>
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