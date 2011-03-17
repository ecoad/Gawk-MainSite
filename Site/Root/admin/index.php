<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Admin");

$memberControl = BaseFactory::getMemberControl();
$memberControl->reset();
$memberControl->retrieveAll();
$memberCount = $memberControl->getNumRows();
$member = $memberControl->getNewestMember();
$currentMember = $application->securityControl->getCurrentMember();

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
// Put your stylesheets here.
?>
<link rel="stylesheet" type="text/css" href="/resource/css/section/home.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

<?php
if (!$currentMember->isNull("ImageId")) {
?>
<span class="admin-thumb"><a href="/admin/advanced/member-detail/view.php?Submit=View&Id=<?php echo $currentMember->getFormatted("Id"); ?>">
	<?php echo $htmlControl->showImageBinary($currentMember->getRelation("ImageId"), $currentMember->getFormatted("Alias"), 62, 62); ?></a>
</span>
<?php
}
?>
<h2 class="welcome">Welcome <a href="/admin/advanced/member-detail/view.php?Submit=View&Id=<?php echo $currentMember->getFormatted("Id"); ?>"><?php echo $currentMember->getFormatted("FirstName"); ?></a></h2>
<p class="description">&hellip;to the <?php echo $application->registry->get("Name"); ?> administration area.</p>
<p>You can use these pages to control various elements of the <?php echo $application->registry->get("Name"); ?> Web site.</p>
<br />
<h3>Common Tasks</h3>
<ul>
	<li><a href="article/control.php?Submit=New">Add a new news article</a></li>
	<li><a href="blog/control.php?Submit=New">Create a new blog entry</a></li>
	<li><a href="#">View Web site statistics</a></li>
</ul>

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