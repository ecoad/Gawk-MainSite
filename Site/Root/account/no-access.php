<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account no-access";

$layout = CoreFactory::getLayout("Site/Template/Default/NoUtility.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "account log-on");
$layout->start("Style");
// Put your stylesheets here.
?>

<link rel="stylesheet" type="text/css" href="/resource/css/layout/form.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

	<h1><?php echo $sectionTitle; ?></h1>
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
