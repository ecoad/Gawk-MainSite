<?php
require_once("Application/Bootstrap.php");
// Force SSL.
$application->isSecure(true, true);

$application->doNotStorePage();

switch($application->parseSubmit()) {
	case "GO":
	case "Log On":
		if ($application->securityControl->logon($_POST["EmailAddress"],
			$_POST["Password"])) {

			// Should an autologon be created
			if (isset($_POST["AutoLogon"])) {
				$application->securityControl->createAutoLogon();
			}
			$application->gotoLastPage();
			$application->redirect("/");
		}
		break;
	case "Log Off":
	case "LogOff":
		$application->securityControl->logOff();
		break;
	default:
		$_POST["EmailAddress"] = "";
		break;
}
$_POST = $htmlControl->sanitise($_POST);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Log On / <?php echo $application->registry->get("Title"); ?> Admin</title>
<?php
include("resource/page-component/admin/metadata.php");
?>
	</head>
	<body>
		<div id="container" class="log-on">
			<div id="header">
<?php
include("resource/page-component/admin/header.php");
?>
			</div>
			<div id="wrapper">
				<div id="main-content">
<!-- Start of Main Content -->


<?php
if ($application->errorControl->hasErrors()) {
?>
					<div class="form-errors">
						<h4><span>There was a problem with your form submission</span></h4>
						<p>Please check the following, then correct your form accordingly before submitting again.</p>
						<ul>
							<?php echo $htmlControl->makeList($application->errorControl->getErrors()); ?>
						</ul>
					</div>
<?php
}
?>
					<form action="<?php echo $application->createUrl(); ?>" method="post">
						<fieldset id="log-on-control">
							<h2>Log On</h2>
							<p>For further access, you must first log on below:</p>
							<label>
								<strong>E-mail Address</strong>
								<input type="text" class="textbox medium" name="EmailAddress"
									value="<?php echo $_POST["EmailAddress"]; ?>" />
							</label><br />
							<label>
								<strong>Password</strong>
								<input type="password" class="textbox medium" name="Password" value="" />
							</label><br />
							<label class="checkbox">
								<strong>Remember me on this computer?</strong>
								<input type="checkbox" name="AutoLogon" value="true"
									title="Using this option you will remain logged in when every you return to the site on this computer" />
							</label><br />
							<div class="controls">
								<input name="Submit" type="submit" class="button" value="Log On" />
							</div>
						</fieldset>
					</form>


<!-- End of Main Content -->
				</div>
<?php
include("resource/page-component/admin/footer.php");
?>
			</div>
		</div>
	</body>
</html>