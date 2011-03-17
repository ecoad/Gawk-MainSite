<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

$application->doNotStorePage();

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Member Admin");

$memberControl = BaseFactory::getMemberControl();

switch($application->parseSubmit()) {
	case "New":
		$member = $memberControl->makeNew();
		break;
	case "Edit":
		$application->required($_GET["Id"]);
		if (!$member = $memberControl->item($_GET["Id"])) {
			$application->gotoLastPage();
		}
		break;
	case "Save":
		$htmlFormControl = CoreFactory::getHtmlFormControl();
		$_POST["EmailAddress"] = $_POST["EmailAddressStopAutoComplete"];
		if ($_POST["PasswordStopAutoComplete"] == "") {
			$member = $memberControl->map($htmlFormControl->mapFormSubmission($_POST, $_FILES));
			if ($member->save()) {
				$application->redirect("view.php?Submit=View&Id=" . $member->get("Id"));
			}
		} else {
			$_POST["Password"] = $_POST["PasswordStopAutoComplete"];
			$member = $memberControl->map($htmlFormControl->mapFormSubmission($_POST, $_FILES));
			if ($memberControl->adminSave($member, $_POST["Password"], $_POST["ConfirmPassword"])) {
				$application->redirect("view.php?Submit=View&Id=" . $member->get("Id"));
			}
		}
		break;
	case "Delete":
		$application->required($_GET["Ids"]);
		$ids = implode(",", $_GET["Ids"]);
		$memberControl->delete($ids);
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
$layout->set("Title", "Advanced / Member Details / " . $application->registry->get("Title") . " Admin");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "advanced");

// Layout begins here. Tech only above this line.
$layout->start("Style");
// Put your stylesheets here.
?>
<link rel="stylesheet" type="text/css" href="/resource/css/jquery-ui.css" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

<h2><a href="/admin/">Admin</a> <span>/ <a href="/admin/advanced/">Advanced</a> <span>/ Member Details</span></span></h2>
<div class="tab-controls">
	<ul>
		<li><a href="index.php">View List</a></li>
<?php
if ($member->get("Id") != "") {
?>
		<li><a href="view.php?Submit=View&amp;Id=<?php echo $member->get("Id"); ?>">View</a></li>
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
<form id="member-form" name="member-form" action="" method="post" enctype="multipart/form-data">
	<fieldset id="basic-details">
		<h3>Basic details</h3>
		<label>
			<strong class="required">Email Address <span>*</span></strong>
			<input name="EmailAddressStopAutoComplete" type="text" class="textbox medium"
				tabindex="<?php echo ++$tabIndex; ?>"
				value="<?php echo $member->getFormatted("EmailAddress"); ?>"
				maxlength="<?php echo $member->getMaxLength("EmailAddress"); ?>" />
		</label>
		<label>
			<strong class="required">Username <span>*</span></strong>
			<input name="Alias" type="text" class="textbox medium"
				tabindex="<?php echo ++$tabIndex; ?>"
				value="<?php echo $member->getFormatted("Alias"); ?>"
				maxlength="<?php echo $member->getMaxLength("Alias"); ?>" />
		</label>
		<label>
			<strong class="required">First Name <span>*</span></strong>
			<input name="FirstName" type="text" class="textbox medium"
				tabindex="<?php echo ++$tabIndex; ?>"
				value="<?php echo $member->getFormatted("FirstName"); ?>"
				maxlength="<?php echo $member->getMaxLength("FirstName"); ?>" />
		</label>
		<label>
			<strong class="required">Last Name <span>*</span></strong>
			<input name="LastName" type="text" class="textbox medium"
				tabindex="<?php echo ++$tabIndex; ?>"
				value="<?php echo $member->getFormatted("LastName"); ?>"
				maxlength="<?php echo $member->getMaxLength("LastName"); ?>" />
		</label>
		<label>
			<strong class="required">Date of Birth <span>*</span></strong>
			<span id="dateOfBirthPicker"> <input type="text" id="datepicker"
			class="textbox medium" tabindex="<?php echo ++$tabIndex;?>"
			value="<?php echo $member->getFormatted("DateOfBirth"); ?>"/>
			<input type="text" name="DateOfBirth" id="dateOfBirth" />
			</span>
		</label>
	</fieldset>

	<fieldset id="image-details">
		<h3>Avatar</h3>
		<p>Member avatars cannot be larger than <?php echo $memberControl->imageSize["MaxWidth"] ?>px by <?php echo $memberControl->imageSize["MaxHeight"] ?>px. Large images will be resized and cropped.</p>
		<label>
			<strong>Add new image</strong>
			<input name="ImageId_File" type="file" tabindex="<?php echo ++$tabIndex; ?>" class="textbox" />
			<input name="ImageId[Current]" type="hidden" value="<?php echo $member->get("ImageId"); ?>" />
		</label>
<?php
if (!$member->isNull("ImageId")) {
?>
		<label>
			<strong>Current image</strong>
			<?php echo $htmlControl->showImageBinary($member->getRelation("ImageId"), $member->get("Alias"), 100, 100, false, true); ?>
		</label>
		<label class="checkbox">
			<strong>Remove this image</strong>
			<input name="ImageId[Remove]" type="checkbox" tabindex="<?php echo ++$tabIndex; ?>" value="1" />
		</label>
<?php
}
?>
	</fieldset>

	<fieldset id="site-details">
		<h3>Misc. Details</h3>
		<label>
			<strong>Web Site</strong>
			<input name="WebSite" type="text" class="textbox medium"
				tabindex="<?php echo ++$tabIndex; ?>"
				value="<?php echo $member->getFormatted("WebSite"); ?>"
				maxlength="<?php echo $member->getMaxLength("WebSite"); ?>" />
		</label>
		<label>
			<strong>Signature</strong>
			<input name="Signature" type="text" class="textbox medium"
				tabindex="<?php echo ++$tabIndex; ?>"
				value="<?php echo $member->getFormatted("Signature"); ?>"
				maxlength="<?php echo $member->getMaxLength("Signature"); ?>" />
		</label>
		<label class="checkbox">
			<strong>Blocked</strong>
			<input name="Blocked" type="checkbox"
				tabindex="<?php echo ++$tabIndex; ?>"
				value="t" <?php echo $htmlControl->check($member->getFormatted("Blocked")); ?>/>
		</label>
	</fieldset>

	<fieldset id="security-details">
		<h3>Security Details</h3>
		<label>
			<strong>New Password</strong>
			<input name="PasswordStopAutoComplete" onkeyup="checkPassword();" type="password" class="textbox medium"
				tabindex="<?php echo ++$tabIndex; ?>" value="" />
		</label>
		<label>
			<strong>Confirm Password</strong>
			<input name="ConfirmPassword" onkeyup="checkPassword();" type="password" class="textbox medium"
				tabindex="<?php echo ++$tabIndex; ?>" value="" />
			<span id="password-information" class="note"></span>
		</label>
	</fieldset>

	<fieldset id="privacy-details">
		<h3>Privacy Details</h3>
		<label class="checkbox">
			<strong>Receive E-Mail Updates</strong>
			<input name="ReceiveEmailUpdates" type="checkbox"
				value="t" <?php echo $htmlControl->check($member->getFormatted("ReceiveEmailUpdates")); ?>/>
		</label>
		<label class="checkbox">
			<strong>Receive Related Promotions</strong>
			<input name="ReceiveRelatedPromotions" type="checkbox"
				tabindex="<?php echo ++$tabIndex; ?>"
				value="t" <?php echo $htmlControl->check($member->getFormatted("ReceiveRelatedPromotions")); ?>/>
		</label>
	</fieldset>

	<div class="controls">
		<input name="Submit" type="submit" tabindex="<?php echo ++$tabIndex; ?>" class="button" value="Save" accesskey="s" title="Save all changes and return to the last page" />
		<input name="Submit" type="submit" tabindex="<?php echo ++$tabIndex; ?>" class="button" value="Cancel" accesskey="c" title="Return to the previous page but do not save changes first" />
		<input name="Id" type="hidden" value="<?php echo $member->get("Id"); ?>" />
		<input name="CancelUrl" type="hidden" value="<?php echo $application->getLastPage(); ?>" />
	</div>
</form>
<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>
<script src="/resource/js/jquery/jquery-ui-1.8.2.js" type="text/javascript"></script>
<script src="/resource/js/jquery/jquery.dateTimePicker.js" type="text/javascript"></script>

<script type="text/javascript">
//	<![CDATA[

//This still works. No need to update
function checkPassword() {
	if (document.forms[0].PasswordStopAutoComplete.value == document.forms[0].ConfirmPassword.value) {
		new Ajax.Request("/resource/application/service/validation.php", {
			method: "get",
			parameters: {
				Action: "CheckPassword",
				Password: document.forms[0].ConfirmPassword.value
			},
			onSuccess: (function(response) {
				var response = response.responseText.evalJSON();
				if (response.success) {
					$('password-information').innerHTML = "<span class=\"success\">Success! Your password is valid.</span>";
				} else {
					$('password-information').innerHTML = "<span class=\"fail\">" + response.message + "</span>";
				}
			}).bind(this)
		});
	} else {
		$('password-information').innerHTML = "<span class=\"fail\">Oops, your passwords do not match. Please try again.</span>";
	}
}

$(document).ready(function(){
	$("#datepicker").datepicker({altField: '#dateOfBirth', altFormat: 'yy-mm-dd'});
});

// ]]>
		</script>
<?php
$layout->render();