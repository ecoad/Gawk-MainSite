<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("News Admin");

$videoControl = Factory::getVideoControl();

$application->required($_GET["Submit"]);
switch($application->parseSubmit()) {
	case "View":
		$application->required($_GET["Id"]);
		if (!$video = $videoControl->item($_GET["Id"])) {
			$application->gotoLastPage();
		}
		break;
	// Stop badly formed page views
	default:
		$application->doNotStorePage();
		$application->redirect("index.php");
}
$htmlSelectOptions = CoreFactory::getHtmlSelectOptions();

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", "Video Videos / Video / " . $application->registry->get("Title") . " Admin");
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "video");

// Layout begins here. Tech only above this line.
$layout->start("Style");
// Put your stylesheets here.
?>

<?php
$layout->start("Main");
// The main page content goes here.
?>
<h2><a href="/admin/">Admin</a> <span>/ <a href="/admin/video/">Video</a> <span>/ Video Videos</span></span></h2>
<div class="tab-controls">
	<ul>
		<li><a href="index.php">View List</a></li>
		<li class="active"><a href="#">View</a></li>
		<li><a href="control.php?Submit=Edit&amp;Id=<?php echo $video->get("Id"); ?>">Edit</a></li>
		<li><a href="control.php?Submit=New">New</a></li>
	</ul>
</div>
<h3><?php echo $video->getFormatted("Subject"); ?></h3>
<dl>
	<dt>Summary</dt>
	<dd><?php echo $video->getFormatted("Summary"); ?></dd>
<?php
if (!$video->isNull("Image1Id")) {
?>
	<dt>Images</dt>
	<dd>
	<?php echo $htmlControl->showImageBinary($video->getRelation("Image1Id"), $video->get("Subject"), 140, 130); ?>
<?php
}
if (!$video->isNull("Image2Id")) {
?>
	<?php echo $htmlControl->showImageBinary($video->getRelation("Image2Id"), $video->get("Subject"), 140, 130); ?>
<?php
}
if (!$video->isNull("Image3Id")) {
?>
	<?php echo $htmlControl->showImageBinary($video->getRelation("Image3Id"), $video->get("Subject"), 140, 130); ?>
<?php
}
if (!$video->isNull("Image4Id")) {
?>
	<?php echo $htmlControl->showImageBinary($video->getRelation("Image4Id"), $video->get("Subject"), 140, 130); ?>
<?php
}
if (!$video->isNull("Image1Id")) {
?>
	</dd>
<?php
}
?>
	<dt>Body</dt>
	<dd><?php echo $video->getFormatted("Body"); ?></dd>
<?php
if (!$video->isNull("Attachment1Id")) {
?>
	<dt>Attachment 1</dt>
	<dd><?php echo $htmlControl->createBinaryDownloadLink($video->getRelation("Attachment1Id"), $video->get("Subject")); ?></dd>
<?php
}
if (!$video->isNull("Attachment2Id")) {
?>
	<dt>Attachment 2</dt>
	<dd><?php echo $htmlControl->createBinaryDownloadLink($video->getRelation("Attachment2Id"), $video->get("Subject")); ?></dd>
<?php
}
if (!$video->isNull("Attachment3Id")) {
?>
	<dt>Attachment 3</dt>
	<dd><?php echo $htmlControl->createBinaryDownloadLink($video->getRelation("Attachment3Id"), $video->get("Subject")); ?></dd>
<?php
}
if (!$video->isNull("Attachment4Id")) {
?>
	<dt>Attachment 4</dt>
	<dd><?php echo $htmlControl->createBinaryDownloadLink($video->getRelation("Attachment4Id"), $video->get("Subject")); ?></dd>
<?php
}
?>
</dl>

<h4>Additional Information</h4>
<dl>
	<dt>Created On</dt>
	<dd><?php echo $video->getFormatted("DateCreated"); ?></dd>
	<dt>Created By</dt>
	<dd><?php echo $video->getRelationValue("AuthorId", "Alias"); ?></dd>
	<dt>Live Date</dt>
	<dd><?php echo $video->getFormatted("LiveDate"); ?></dd>
	<dt>Expiry Date</dt>
	<dd><?php echo $video->getFormatted("ExpiryDate"); ?></dd>
	<dt>Active</dt>
	<dd><?php echo $video->getFormatted("Active"); ?></dd>
	<dt>Tags</dt>
	<dd><?php echo $video->getFormatted("Tags"); ?></dd>
</dl>
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