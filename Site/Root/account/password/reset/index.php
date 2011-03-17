<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->doNotStorePage();

$memberControl = BaseFactory::getMemberControl();

switch($application->parseSubmit()) {
	case "Submit":
	case "Request":
		if ($memberControl->requestPassword($_POST["EmailAddress"])) {
			$application->redirect("sent.php?Email=" . $_POST["EmailAddress"]);
		} else {
			$application->errorControl->addError("No Account found");
		}
		break;
	case "Cancel":
		$application->gotoLastPage();
		break;
	default:
		$_POST["EmailAddress"] = "";
		break;
}

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

	<h1>Request Your Password</h1>

<?php
if ($application->errorControl->hasErrors()) {
?>

	<div class="form-errors">
		<h2>There was a problem with your form submission</h2>
		<p>Please check the following, then correct your form accordingly before submitting again.</p>
		<ul>
			<?php echo $htmlControl->makeList($application->errorControl->getErrors()); ?>
		</ul>
	</div>

<?php
}
?>

	<form action="" method="post">
		<fieldset>
			<h2>To request a new password please enter your email address</h2>
			<label>
				<strong class="required">Email Address <span>*</span></strong>
				<input type="text" class="textbox medium" name="EmailAddress"
					value="<?php echo $_POST["EmailAddress"]; ?>" />
			</label><br />
			<div class="controls">
				<input name="Submit" type="submit" class="button" value="Request" />
				<input name="Submit" type="submit" class="button" value="Cancel" />
			</div>
		</fieldset>
	</form>

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