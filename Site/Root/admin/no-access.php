<?php
require_once("Application/Bootstrap.php");

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", "No Access / " . $application->registry->get("Title"));
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
<h2>No Access</h2>
<p>Sorry, you do not have sufficient privileges to access this area. If you think you should have access to this part of the site please contact the system administrator.</p>
<p>Go <a href="/" title="Go back to the home page">back to the home page</a>.</p>
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