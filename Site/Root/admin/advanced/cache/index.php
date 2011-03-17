<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Cache Admin");

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", "Blogs / Blog Post / " . $application->registry->get("Title") . " Admin");
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
<h2><a href="/admin/">Admin</a> <span>/ <a href="/admin/advanced/">Advanced</a> <span>/ Cache</span></span></h2>

<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>
<?php
$layout->render();