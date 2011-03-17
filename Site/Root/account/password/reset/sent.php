<?php
require_once("Application/Bootstrap.php");
// Force Non-SSL.
$application->isSecure(false, true);
// Page variables.
$sectionTitle = "Account";
$section = "account";

$layout = CoreFactory::getLayout("Site/Template/Default/NoUtility.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "account password-request");
$layout->start("Style");
// Put your stylesheets here.
?>

<link rel="stylesheet" type="text/css" href="/resource/css/layout/form.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

	<h1>Password Reset Sent</h1>
	<h2>We have sent you an email to allow you reset your password.</h2>
	<p><a href="/account/">Return to your profile page.</a></p>

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