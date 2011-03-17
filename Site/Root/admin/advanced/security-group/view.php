<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Security Group Admin");

$application->required($_GET["Submit"]);

$securityGroupControl = BaseFactory::getSecurityGroupControl();
$securityResourceControl = BaseFactory::getSecurityResourceControl();
$securityGroupToSecurityResourceControl = BaseFactory::getSecurityGroupToSecurityResourceControl();

switch($application->parseSubmit()) {
	case "View":
		$application->required($_GET["Id"]);
		if (!$securityGroup = $securityGroupControl->item($_GET["Id"])) {
			$application->gotoLastPage();
		}
		$securityGroupToSecurityResourceControl->retrieveForSecurityGroup($securityGroup);
		break;
	case "Add >":
		$application->doNotStorePage();
		$application->required($_POST["Id"]);
		$application->required($_POST["NewSecurityResourceId"]);

		if (!$securityGroup = $securityGroupControl->item($_POST["Id"])) {
			$application->gotoLastPage();
		}
		@$securityGroupControl->addResource($securityGroup, $_POST["NewSecurityResourceId"]);
		$application->redirect("view.php?Submit=View&Id=" . $_POST["Id"]);
		break;
	case "< Remove":
		$application->doNotStorePage();
		$application->required($_POST["Id"]);
		$application->required($_POST["ExistingSecurityGroupToSecurityResourceId"]);

		if (!$securityGroup = $securityGroupControl->item($_POST["Id"])) {
			$application->gotoLastPage();
		}
		$securityGroupControl->removeResource($_POST["ExistingSecurityGroupToSecurityResourceId"]);
		$application->redirect("view.php?Submit=View&Id=" . $_POST["Id"]);
		break;
	// Stop badly formed page views
	default:
		$application->doNotStorePage();
		$application->redirect("index.php");
}

$securityResources = $securityResourceControl->getResultsAsFieldArray("Name");

$securityGroupSecurityResources = $securityGroupToSecurityResourceControl->getResultsAsFieldArray("SecurityResourceName");
$securityResources = array_diff($securityResources, $securityGroupSecurityResources);

$htmlSelectOptions = CoreFactory::getHtmlSelectOptions();

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", " Advanced / Security Groups" . $application->registry->get("Title") . " Admin");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "blog");

// Layout begins here. Tech only above this line.
$layout->start("Style");
// Put your stylesheets here.
?>

<?php
$layout->start("Main");
// The main page content goes here.
?>

<h2><a href="/admin/">Admin</a> <span>/ <a href="/admin/advanced/">Advanced</a> <span>/ Security Groups</span></span></h2>
<div class="tab-controls">
	<ul>
		<li><a href="index.php">View List</a></li>
		<li class="active"><a href="#">View</a></li>
		<li><a href="control.php?Submit=Edit&amp;Id=<?php echo $securityGroup->get("Id"); ?>">Edit</a></li>
		<li><a href="control.php?Submit=New">New</a></li>
	</ul>
</div>
<h3><?php echo $securityGroup->getFormatted("Name"); ?></h3>
<p><?php echo $securityGroup->getFormatted("Description"); ?></p>

<div>
	<h4 class="expander-switch">&nbsp;Security Resources</h4>
	<form action="" method="post">
		<fieldset id="basic-details">
			<table class="data-control">
				<tr>
					<th>Disallowed Resources</th>
					<th></th>
					<th>Allowed Resources</th>
				</tr>
				<tr>
					<td>
						<select name="NewSecurityResourceId[]" size="20" class="listbox" multiple="multiple">
							<?php echo $htmlControl->createArrayListValues("", $securityResources); ?>
						</select>
					</td>
					<td>
						<div class="controls-center">
							<input name="Submit" type="submit" class="button" value="Add &gt;" accesskey="a" /><br />
							<input name="Submit" type="submit" class="button" value="&lt; Remove" accesskey="r" />
						</div>
					</td>
					<td>
						<select name="ExistingSecurityGroupToSecurityResourceId[]" size="20" class="listbox" multiple="multiple">
							<?php echo $htmlControl->createArrayListValues("", $securityGroupSecurityResources); ?>
						</select>
					</td>
				</tr>
			</table>
			<input name="Id" type="hidden"  value="<?php echo $securityGroup->get("Id"); ?>" />
		</fieldset>
	</form>
</div>
<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>
<?php
$layout->render();

