<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);
$application->doNotStorePage();
$application->required($_GET["Submit"]);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Security Group Admin");
$securityGroupControl = BaseFactory::getSecurityGroupControl();

switch($application->parseSubmit()) {
	case "New":
		$securityGroup = $securityGroupControl->makeNew();
		break;
	case "Edit":
		$application->required($_GET["Id"]);
		if (!$securityGroup = $securityGroupControl->item($_GET["Id"])) {
			$application->gotoLastPage();
		}
		break;
	case "Save":
		$htmlFormControl = CoreFactory::getHtmlFormControl();
		$securityGroup = $securityGroupControl->map($_POST);
		if ($securityGroup->save()) {
			$application->redirect("view.php?Submit=View&Id=" . $securityGroup->get("Id"));
		}
		break;
	case "Delete":
		$application->required($_GET["Ids"]);
		$ids = implode(",", $_GET["Ids"]);
		$securityGroupControl->delete($ids);
		$application->redirect("index.php");
		break;
	case "Cancel":
		$application->redirect($_POST["CancelUrl"]);
		break;
	// Stop badly formed page views
	default:
		$application->gotoLastPage();
}

$htmlSelectOptions = CoreFactory::getHtmlSelectOptions();
$tabIndex = 0;

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", "Advanced / Security Groups / " . $application->registry->get("Title") . " Admin");
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

<h2><a href="/admin/">Admin</a> <span>/ <a href="/admin/advanced/">Advanced</a> <span>/ Security Groups</span></span></h2>
<div class="tab-controls">
	<ul>
		<li><a href="index.php">View List</a></li>
<?php
if ($securityGroup->get("Id") != "") {
?>
		<li><a href="view.php?Submit=View&amp;Id=<?php echo $securityGroup->get("Id"); ?>">View</a></li>
		<li class="active"><a href="#">Edit</a></li>
		<li><a href="control.php?Submit=New">New</a></li>
<?php
} else {
?>
		<li class="inactive">View</li>
		<li class="inactive">Edit</li>
		<li class="active"><a href="control.php?Submit=New">New</a></li>
<?php
}
?>
	</ul>
</div>
<?php
if ($application->errorControl->hasErrors()) {
?>
<div class="form-errors">
	<h3>There was a problem with your form.</h3>
	<p>Please check the following, then try again.</p>
	<ul>
		<?php echo $htmlControl->makeList($application->errorControl->getErrors()); ?>
	</ul>
</div>
<?php
}
?>
<form id="securityresource-form" name="address-form" action="" method="post" enctype="multipart/form-data">
	<fieldset id="basic-details">
		<h3>Basic details</h3>
		<label>
			<strong class="required">Name <span>*</span></strong>
			<input name="Name" type="text" class="textbox medium"
				tabindex="1"
				value="<?php echo $securityGroup->getFormatted("Name"); ?>"
				maxlength="<?php echo $securityGroup->getMaxLength("Name"); ?>" />
		</label><br />
		<label>
			<strong class="required">Description <span>*</span></strong>
			<textarea name="Description" cols="40" rows="15"
				class="textbox wide tall" id="Description"
				onkeypress="return RumbleUI.Form.Textarea.restrictLength(this,
				<?php echo $securityGroup->getMaxLength("Description"); ?>)"><?php echo $securityGroup->getFormatted("Description"); ?></textarea>
		</label>
		<div class="controls">
			<input name="Submit" type="submit" class="button" value="Save" accesskey="s"
				title="Save all changes and return to the last page" tabindex="13" />
			<input name="Submit" type="submit" class="button" value="Cancel" accesskey="c"
				title="Return to the previous page but do not save changes first" tabindex="14" />
			<input name="Id" type="hidden" value="<?php echo $securityGroup->get("Id"); ?>" />
			<input name="CancelUrl" type="hidden" value="<?php echo $application->getLastPage(); ?>" />
		</div>
	</fieldset>
</form>

<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>
<script type="text/javascript">
//<![CDATA[
//]]>
</script>
<?php
$layout->render();