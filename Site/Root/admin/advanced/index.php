<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Advanced Admin");

$layout = CoreFactory::getLayout("Site/Template/Admin/Main.php");
$layout->set("Title", "Advanced / " . $application->registry->get("Title") . " Admin");
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
<h2><a href="/admin/">Admin</a> <span>/ Advanced </span></h2>
<div id="admin-section-description">
	<p>Only Clock staff members should have access to this part of the admin.</p>
	<p>If you are not a Clock employee, please contact Clock using the information in the footer and inform Clock of this error.</p>
	<p>Please be aware that altering any of the values within this section may seriously effect what members have / do not have access to.</p>
	<p><strong>Only edit these pages if you know what you are doing:</strong></p>
</div>
<ul>
	<li><a href="member-detail/">Member Details</a></li>
	<li><a href="security-group/">Security Groups</a></li>
	<li><a href="security-resource/">Security Resources</a></li>
	<li><a href="cache/">Cache</a></li>
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