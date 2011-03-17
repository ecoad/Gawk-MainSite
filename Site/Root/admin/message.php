<?php
require_once("Application/Bootstrap.php");

/**
 * Only allow users who has access to the specifed Security Resource
 */
$application->securityControl->isAllowed("Admin");

$application->doNotStorePage();
$application->required($_GET["Submit"]);
switch($application->parseSubmit()) {
	case "Delete":
		$application->required($_GET["Ids"]);
		$application->required($_GET["Return"]);
		$title = "Confirm Delete";
		$message = "Are you sure you want to delete the selected items?";
		$buttons = array("Yes", "No");
		$return = $_GET["Return"];
		$data = $_GET["Ids"];
		// Show the Data specifc info
		if (isset($_GET["Type"])) {
			$itemCount = $failedCount = 0;
			switch ($_GET["Type"]) {
				case "StockItem":
					$stockItemControl = BaseFactory::getStockItemControl();
					$itemsMessage = "<ul>\n";
					$a = explode(",", $data);

					foreach($a as $id) {
						if ($stockItem = $stockItemControl->item($id)) {
							if ($stockItemControl->hasDependancies($stockItem)) {
								$itemsMessage .= "<li class=\"error\">" . $stockItemControl->errorControl->getLastError() . "</li>\n";
								$failedCount++;
								$stockItemControl->errorControl->clear();
							} else {
								$itemsMessage .= "<li>" . $stockItem->get("Description") . "</li>\n";
							}
							$itemCount++;
						}
					}
					$itemsMessage .= "</ul>\n";
					break;
			}
			// No Delete is posible
			if ($failedCount == $itemCount) {
				$title = "Unable to Delete";
				$message = "None of the selected items can be deleted";
				$buttons = array("OK");
			}
			$message .= $itemsMessage;
		}

		break;
	case "CancelOrder":
		$application->required($_GET["Id"]);
		$application->required($_GET["Return"]);
		$title = "Confirm Cancel of Order";
		$message = "Are you sure you want to cancel the selected order <br/> (Quantities will be returned to stock)?";
		$buttons = array("Yes", "No");
		$return = $_GET["Return"];
		$data = $_GET["Id"];
		break;
	case "Message":
		$application->required($_GET["Title"]);
		$application->required($_GET["Message"]);
		$application->required($_GET["Return"]);
		$title = $_GET["Title"];
		$message = $_GET["Message"];
		$buttons = array("Back");
		$return = $_GET["Return"];
		$data = "";
		break;
	case "End Poll Now":
		$application->required($_GET["Ids"]);
		$application->required($_GET["Return"]);
		$title = "End Poll Now";
		$message = "Are you sure you want to end selected Poll early?";
		$buttons = array("Confirm", "Back");
		$return = $_GET["Return"];
		$data = $_GET["Ids"];
		break;
	default:
		$application->redirect($_POST["Return"] . "Submit={$_POST["Submit"]}&Data=" . $_POST["Data"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Message / <?php echo $application->registry->get("Title"); ?> Admin</title>
<?php
include("resource/page-component/admin/metadata.php");
?>
	</head>
	<body>
		<div id="container" class="message">
			<div id="main-wrapper">
				<div id="header">
<?php
include("resource/page-component/admin/header.php");
?>
				</div>
				<div id="navigation">
<?php
include("resource/page-component/admin/navigation.php");
?>
				</div>
				<div id="main-content">
<!-- Start of Main Content -->

					<h2><a href="/admin/">Admin</a> <span>/ Message</span></h2>
					<form action="" method="post">
						<div class="contents">
							<h2><?php echo $title; ?></h2>
							<p><?php echo $message; ?></p>
							<div class="controls">
<?php
	foreach($buttons as $button) {
?>
								<input name="Submit" type="submit" class="button" value="<?php echo $button; ?>" />
<?php
	}
?>
								<input name="Data" type="hidden" value="<?php echo $data; ?>" />
								<input name="Return" type="hidden" value="<?php echo $return; ?>?" />
							</div>
						</div>
					</form>

	<!-- End of Main Content -->
				</div>
			</div>
<?php
include("resource/page-component/admin/footer.php");
?>
		</div>
	</body>
</html>