<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("News Admin");

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", "Video / " . $application->registry->get("Title") . " Admin");
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
<h2><a href="/admin/">Admin</a> <span>/ Video </span></h2>

<div id="admin-section-description">
	<p>Welcome to the video section.</p>
	<p>All video articles which appear on the <?php echo $application->registry->get("Name"); ?> Web site are administered from here. You can add new video articles, and edit or delete existing articles.</p>
	<p>You also have the option to add photos and attachment to each article, as well as give them specific tags which they can be filtered and searched by.</p>
</div>
<ul>
	<li><a href="list/">GAWKS</a></li>
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