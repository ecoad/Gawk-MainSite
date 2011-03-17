<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

$application->doNotStorePage();

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("News Admin");

$videoControl = Factory::getVideoControl();

switch($application->parseSubmit()) {
	case "New":
		$video = $videoControl->makeNew();
		break;
	case "Edit":
		$application->required($_GET["Id"]);
		if (!$video = $videoControl->item($_GET["Id"])) {
			$application->gotoLastPage();
		}
		break;
	case "Save":
		$htmlFormControl = CoreFactory::getHtmlFormControl();
		$video = $videoControl->map($htmlFormControl->mapFormSubmission($_POST, $_FILES));
		if ($video->save()) {
			$application->redirect("view.php?Submit=View&Id=" . $video->get("Id"));
		}
		break;
	case "Delete":
		$application->required($_GET["Ids"]);
		$ids = implode(",", $_GET["Ids"]);
		$videoControl->delete($ids);
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
$layout->set("Title", "Video Videos / Video / " . $application->registry->get("Title") . " Admin");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "video");

// Layout begins here. Tech only above this line.
$layout->start("Style");
// Put your stylesheets here.
?>
<link rel="stylesheet" type="text/css" href="/resource/css/jquery-ui.css" media="all" />
<?php
$layout->start("Main");
// The main page content goes here.
?>
<h2><a href="/admin/">Admin</a> <span>/ <a href="/admin/video/">Video</a> <span>/ Video Videos</span></span></h2>
<div class="tab-controls">
	<ul>
		<li><a href="index.php">View List</a></li>
<?php
if ($video->get("Id") != "") {
?>
		<li><a href="view.php?Submit=View&amp;Id=<?php echo $video->get("Id"); ?>">View</a></li>
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
<form id="video-form" name="video-form" action="" method="post" enctype="multipart/form-data">
	<fieldset id="basic-details">
		<h3>Basic details</h3>
		<label>
			<strong class="required">Subject <span>*</span></strong>
			<input name="Subject" type="text" class="textbox wide"
				tabindex="<?php echo $tabIndex++; ?>"
				value="<?php echo $video->getFormatted("Subject"); ?>"
				maxlength="<?php echo $video->getMaxLength("Subject"); ?>" />
		</label><br />
		<label>
			<strong class="required">Summary <span>*</span></strong>
			<textarea id="summary" name="Summary" cols="40" rows="15" class="textbox wide"><?php echo $video->get("Summary"); ?></textarea>
		</label><br />
		<label>
			<strong class="required">Body <span>*</span></strong>
			<textarea id="body" name="Body" cols="40" rows="15" class="textbox wide"><?php echo $video->get("Body"); ?></textarea>
		</label><br />
	</fieldset>
	<fieldset id="video-date-details">
		<h3>Video date details</h3>
		<label>
			<strong class="required">Live date <span>*</span></strong>
			<span id="live-date"></span>
		</label>
		<label>
			<strong class="required">Expiry date</strong>
			<span id="expiry-date"></span>
		</label>
		<label class="checkbox">
			<strong>Active</strong>
			<input name="Active" type="checkbox"
				value="t" <?php echo $htmlControl->check($video->get("Active")); ?>/>
		</label>
	</fieldset>

	<fieldset id="image-details">
		<h3>Image details</h3>
		<p><strong>Please note:</strong> uploaded images cannot be larger than <?php echo $videoControl->imageSize["MaxWidth"] ?>px by <?php echo $videoControl->imageSize["MaxHeight"] ?>px.</p>
		<h4>Image 1</h4>
		<label>
			<strong>Add new image</strong>
			<input name="Image1Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Image1Id[Current]" type="hidden" value="<?php echo $video->get("Image1Id"); ?>" />
		</label><br />
<?php
if (!$video->isNull("Image1Id")) {
?>
		<label>
			<strong>Current image</strong>
			<?php echo $htmlControl->showImageBinary($video->getrelation("Image1Id"), "Video Image", 100, 100); ?>
		</label><br />
		<label class="checkbox">
			<strong>Remove this image</strong>
			<input name="Image1Id[Remove]" type="checkbox" tabindex="<?php echo $tabIndex++; ?>" value="1" />
		</label><br />
<?php
}
if (!$video->isNull("Image2Id")) {
?>
		<h4>Image 2</h4>
		<label>
			<strong>Add new image</strong>
			<input name="Image2Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Image2Id[Current]" type="hidden"
				value="<?php echo $video->get("Image2Id"); ?>" />
		</label><br />
		<label>
			<strong>Current image</strong>
			<?php echo $htmlControl->showImageBinary($video->getrelation("Image2Id"), "Video Image", 100, 100); ?>
		</label><br />
		<label class="checkbox">
			<strong>Remove this image</strong>
			<input name="Image2Id[Remove]" type="checkbox" tabindex="<?php echo $tabIndex++; ?>" value="1" />
		</label><br />
<?php
}
if (!$video->isNull("Image3Id")) {
?>
		<h4>Image 3</h4>
		<label>
			<strong>Add new image</strong>
			<input name="Image3Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Image3Id[Current]" type="hidden"
				value="<?php echo $video->get("Image3Id"); ?>" />
		</label><br />
		<label>
			<strong>Current image</strong>
			<?php echo $htmlControl->showImageBinary($video->getrelation("Image3Id"), "Video Image", 100, 100); ?>
		</label><br />
		<label class="checkbox">
			<strong>Remove this image</strong>
			<input name="Image3Id[Remove]" type="checkbox" tabindex="<?php echo $tabIndex++; ?>" value="1" />
		</label><br />
<?php
}
if (!$video->isNull("Image4Id")) {
?>
		<h4>Image 4</h4>
		<label>
			<strong>Add new image</strong>
			<input name="Image4Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Image4Id[Current]" type="hidden"
				value="<?php echo $video->get("Image4Id"); ?>" />
		</label><br />
		<label>
			<strong>Current image</strong>
			<?php echo $htmlControl->showImageBinary($video->getrelation("Image1Id"), "Video Image", 100, 100); ?>
		</label><br />
		<label class="checkbox">
			<strong>Remove this image</strong>
			<input name="Image4Id[Remove]" type="checkbox" tabindex="<?php echo $tabIndex++; ?>" value="1" />
		</label><br />
<?php
}
?>
		<h4>More Attachments</h4>
<?php
if ($video->isNull("Image2Id")) {
?>
		<label>
			<strong>Add image 2</strong>
			<input name="Image2Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Image2Id[Current]" type="hidden"
				value="<?php echo $video->get("Image2Id"); ?>" />
		</label><br />
<?php
}
if ($video->isNull("Image3Id")) {
?>
		<label>
			<strong>Add image 3</strong>
			<input name="Image3Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Image3Id[Current]" type="hidden"
				value="<?php echo $video->get("Image3Id"); ?>" />
		</label><br />
<?php
}
if ($video->isNull("Image4Id")) {
?>
		<label>
			<strong>Add image 4</strong>
			<input name="Image4Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Image4Id[Current]" type="hidden"
				value="<?php echo $video->get("Image4Id"); ?>" />
		</label><br />
<?php
}
?>
	</fieldset>

	<fieldset id="attachment-details">
		<h3>Attachment details</h3>
		<h4>Attachment 1</h4>
		<label>
			<strong>Add new attachment</strong>
			<input name="Attachment1Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Attachment1Id[Current]" type="hidden"
				value="<?php echo $video->get("Attachment1Id"); ?>" />
		</label><br />
<?php
if (!$video->isNull("Attachment1Id")) {
?>
		<label>
			<strong>Current attachment</strong>
			<?php echo $htmlControl->createBinaryDownloadLink($video->getRelation("Attachment1Id"), "Attachment 1"); ?>
		</label><br />
		<label class="checkbox">
			<strong>Remove this attachment</strong>
			<input name="Attachment1Id[Remove]" type="checkbox" tabindex="<?php echo $tabIndex++; ?>" value="1" />
		</label><br />
<?php
}
if (!$video->isNull("Attachment2Id")) {
?>
		<h4>Attachment 2</h4>
		<label>
			<strong>Add new attachment</strong>
			<input name="Attachment2Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Attachment2Id[Current]" type="hidden"
				value="<?php echo $video->get("Attachment2Id"); ?>" />
		</label><br />
		<label>
			<strong>Current attachment</strong>
			<?php echo $htmlControl->createBinaryDownloadLink($video->getRelation("Attachment2Id"), "Attachment 2"); ?>
		</label><br />
		<label class="checkbox">
			<strong>Remove this attachment</strong>
			<input name="Attachment2Id[Remove]" type="checkbox" tabindex="<?php echo $tabIndex++; ?>" value="1" />
		</label><br />
<?php
}
if (!$video->isNull("Attachment3Id")) {
?>
		<h4>Attachment 3</h4>
		<label>
			<strong>Add new attachment</strong>
			<input name="Attachment3Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Attachment3Id[Current]" type="hidden"
				value="<?php echo $video->get("Attachment3Id"); ?>" />
		</label><br />
		<label>
			<strong>Current attachment</strong>
			<?php echo $htmlControl->createBinaryDownloadLink($video->getRelation("Attachment3Id"), "Attachment 3"); ?>
		</label><br />
		<label class="checkbox">
			<strong>Remove this attachment</strong>
			<input name="Attachment3Id[Remove]" type="checkbox" tabindex="<?php echo $tabIndex++; ?>" value="1" />
		</label><br />
<?php
}
if (!$video->isNull("Attachment4Id")) {
?>
		<h4>Attachment 4</h4>
		<label>
			<strong>Add new attachment</strong>
			<input name="Attachment4Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Attachment4Id[Current]" type="hidden"
				value="<?php echo $video->get("Attachment4Id"); ?>" />
		</label><br />
		<label>
			<strong>Current attachment</strong>
			<?php echo $htmlControl->createBinaryDownloadLink($video->getRelation("Attachment4Id"), "Attachment 4"); ?>
		</label><br />
		<label class="checkbox">
			<strong>Remove this attachment</strong>
			<input name="Attachment4Id[Remove]" type="checkbox" tabindex="<?php echo $tabIndex++; ?>" value="1" />
		</label><br />
<?php
}
?>
		<h4>More Attachments</h4>
<?php
if ($video->isNull("Attachment2Id")) {
?>
		<label>
			<strong>Add attachment 2</strong>
			<input name="Attachment2Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Attachment2Id[Current]" type="hidden"
				value="<?php echo $video->get("Attachment2Id"); ?>" />
		</label><br />
<?php
}
if ($video->isNull("Attachment3Id")) {
?>
		<label>
			<strong>Add attachment 3</strong>
			<input name="Attachment3Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Attachment3Id[Current]" type="hidden"
				value="<?php echo $video->get("Attachment3Id"); ?>" />
		</label><br />
<?php
}
if ($video->isNull("Attachment4Id")) {
?>
		<label>
			<strong>Add attachment 4</strong>
			<input name="Attachment4Id_File" type="file" tabindex="<?php echo $tabIndex++; ?>" class="textbox" />
			<input name="Attachment4Id[Current]" type="hidden"
				value="<?php echo $video->get("Attachment4Id"); ?>" />
		</label><br />
<?php
}
?>
	</fieldset>
	<fieldset id="miscellaneous-details">
		<h3>Video Tags</h3>
		<p><strong>Please note:</strong> tags must be seperated by a comma.</p>
		<label>
			<strong>Tags</strong>
			<input type="text" name="Tags" value="<?php echo $video->get("Tags"); ?>" tabindex="<?php echo $tabIndex++; ?>" class="textbox wide" />
		</label><br />
	</fieldset>
	<div class="controls">
		<input name="Submit" type="submit" tabindex="<?php echo $tabIndex++; ?>" class="button" value="Save" accesskey="s" title="Save all changes and return to the last page" />
		<input name="Submit" type="submit" tabindex="<?php echo $tabIndex++; ?>" class="button" value="Cancel" accesskey="c" title="Return to the previous page but do not save changes first" />
		<input name="Id" type="hidden" value="<?php echo $video->get("Id"); ?>" />
		<input name="CancelUrl" type="hidden" value="<?php echo $application->getLastPage(); ?>" />
	</div>
</form>
<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>
<script src="/resource/js/jquery/jquery-ui-1.8.2.js" type="text/javascript"></script>
<script src="/resource/js/jquery/jquery.dateTimePicker.js" type="text/javascript"></script>
<script src="/resource/js/jquery/jquery.resetTabIndex.js" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
$(function() {
	$("#live-date").dateTimePicker( {
		timeValue: "<?php echo $application->customFormatDateTime($video->get("LiveDate"), "%R", null);?>",
		startHour: 5,
		endHour: 23,
		name: "LiveDate",
		dateValue: "<?php echo $application->customFormatDateTime($video->get("LiveDate"), "%Y-%m-%d",  null); ?>",
		dateValueFormatted: "<?php echo $video->getFormatted("LiveDate"); ?>"
	});
	$("#expiry-date").dateTimePicker( {
		timeValue: "<?php echo $application->customFormatDateTime($video->get("ExpiryDate"), "%R", null);?>",
		startHour: 5,
		endHour: 23,
		name: "ExpiryDate",
		dateValue: "<?php echo $application->customFormatDateTime($video->get("ExpiryDate"), "%Y-%m-%d",  null); ?>",
		dateValueFormatted: "<?php echo $video->getFormatted("ExpiryDate"); ?>"
	});
	$("#video-form").resetTabIndex();
});
//]]>
</script>
<?php
$layout->render();