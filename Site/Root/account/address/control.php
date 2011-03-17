<?php
require_once("Application/Bootstrap.php");
// Page variables.
$sectionTitle = "Account";
$section = "account";

$application->doNotStorePage();

$application->securityControl->isAllowed("Member");

$memberControl = BaseFactory::getMemberControl();

if (!$member = $memberControl->item($application->securityControl->getMemberId())) {
	$application->securityControl->LogOff();
}

$addressControl = $member->getManyToManyControl("Addresses");
$memberAddresses = $addressControl->getResultsAsArray();
switch($application->parseSubmit()) {
	case "New":
		$address = $addressControl->makeNew();
		break;
	case "Edit":
		$application->required($_GET["AddressId"]);
		if (isset($_GET["AddressId"])) {
			if (isset($memberAddresses[$_GET["AddressId"]])) {
				$address = $memberAddresses[$_GET["AddressId"]];
			} else {
				$application->gotoLastPage();
			}
		}
		break;
	case "Save":
		$address = $addressControl->map($_POST);
		if ($memberControl->addAddress($member, $address)) {
			$application->gotoLastPage();
		}
		break;
	case "Cancel":
	default:
		$application->gotoLastPage();
		break;
}
$lists = CoreFactory::getLists();
$htmlSelectOptions = CoreFactory::getHtmlSelectOptions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $sectionTitle; ?> / <?php echo $application->registry->get("Title"); ?></title>
<?php
include("resource/page-component/metadata.php");
?>
		<link rel="stylesheet" type="text/css" href="/resource/css/section/<?php echo $section; ?>.css?v=@VERSION-NUMBER@" media="all" />
	</head>
	<body>
		<div id="container" class="<?php echo $section; ?> address-control">
			<div id="wrapper">
				<div id="header">
<?php
include("resource/page-component/header.php");
?>
				</div>
				<div id="navigation">
<?php
include("resource/page-component/navigation.php");
?>
				</div>
				<div id="main-content">
<!-- Start of Main Content -->

					<h2><span><?php echo $sectionTitle; ?></span></h2>
<?php
include("resource/page-component/account/section-navigation.php");
?>
					<h3>Your Address Details</h3>
					<p>You can use this section to add or change addresses stored on your account.</p>
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
						<fieldset id="address">
							<h4><span>Address Details</span></h4>
							<label>
								<strong class="required">Description <span>*</span></strong>
									<input name="Description" type="text" class="textbox medium"
										value="<?php echo $address->get("Description"); ?>"
										maxlength="<?php echo $address->getMaxLength("Description"); ?>" />
								<span class="note">(i.e. 'my home address' or 'work')</span>
							</label><br />
							<label>
								<strong class="required">Title <span>*</span></strong>
								<select name="NamePrefix" class="listbox">
									<option>Please Select</option>
									<?php echo $htmlControl->createArrayListValues($address->get("NamePrefix"),
										$lists->getTitles(), true); ?>
								</select>
							</label><br />
							<label>
								<strong class="required">First Name <span>*</span></strong>
								<input name="FirstName" type="text" class="textbox medium"
									value="<?php echo $address->get("FirstName"); ?>"
									maxlength="<?php echo $address->getMaxLength("FirstName"); ?>" />
							</label><br />
							<label>
								<strong class="required">Last Name <span>*</span></strong>
								<input name="LastName" type="text" class="textbox medium"
									value="<?php echo $address->get("LastName"); ?>"
									maxlength="<?php echo $address->getMaxLength("LastName"); ?>" />
							</label><br />
							<label>
								<strong>Company/House Name </strong>
								<input name="CompanyOrHouseName" type="text" class="textbox medium"
									value="<?php echo $address->get("CompanyOrHouseName"); ?>"
									maxlength="<?php echo $address->getMaxLength("CompanyOrHouseName"); ?>" />
							</label><br />
							<label>
								<strong class="required">Address Line 1 <span>*</span></strong>
								<input name="AddressLine1" type="text" class="textbox medium"
									value="<?php echo $address->get("AddressLine1"); ?>"
									maxlength="<?php echo $address->getMaxLength("AddressLine1"); ?>" />
							</label><br />
							<label>
								<strong>Address Line 2</strong>
								<input name="AddressLine2" type="text" class="textbox medium"
									value="<?php echo $address->get("AddressLine2"); ?>"
									maxlength="<?php echo $address->getMaxLength("AddressLine2"); ?>" />
							</label><br />
							<label>
								<strong class="required">Town <span>*</span></strong>
								<input name="Town" type="text" class="textbox medium"
									value="<?php echo $address->get("Town"); ?>"
									maxlength="<?php echo $address->getMaxLength("Town"); ?>" />
							</label><br />
							<label>
								<strong class="required">County/State <span>*</span></strong>
								<input name="Region" type="text" class="textbox medium"
									value="<?php echo $address->get("Region"); ?>"
									maxlength="<?php echo $address->getMaxLength("Region"); ?>" />
							</label><br />
							<label>
									<strong class="required">Country <span>*</span></strong>
									<select name="CountryId" class="listbox">
										<?php echo $htmlSelectOptions->create($address->getRelationControl("CountryId"), "Name",
											$address->get("CountryId")); ?>
									</select>
							</label><br />
							<label>
								<strong class="required">Postcode <span>*</span></strong>
								<input name="Postcode" type="text" class="textbox medium"
									value="<?php echo $address->get("Postcode"); ?>"
									maxlength="<?php echo $address->getMaxLength("Postcode"); ?>"
									onchange="this.value = formatUpper(this.value);" />
							</label><br />
							<label>
								<strong class="required">Telephone Number <span>*</span></strong>
								<input name="TelephoneNumber" type="text" class="textbox medium"
									value="<?php echo $address->get("TelephoneNumber"); ?>"
									maxlength="<?php echo $address->getMaxLength("TelephoneNumber"); ?>"
									onchange="this.value = formatTelephoneNumber(this.value)" />
							</label><br />
							<label>
								<strong class="required">E-mail Address <span>*</span></strong>
								<input name="EmailAddress" type="text" class="textbox medium"
									value="<?php echo $address->get("EmailAddress"); ?>"
									maxlength="<?php echo $address->getMaxLength("EmailAddress"); ?>"
									onchange="this.value = formatLower(this.value);" />
							</label><br />
						</fieldset>

						<div class="controls">
							<input name="Submit" type="submit" class="button" value="Save"
								accesskey="s" title="Save all changes and return to the last page" />
							<input name="Submit" type="submit" class="button" value="Cancel"
								accesskey="c" title="Return to the previous page but do not save changes first" />
							<input name="Id" type="hidden" value="<?php echo $address->get("Id"); ?>" />
							<input name="ReturnUrl" type="hidden"
								value="<?php echo $application->getLastPage($_REQUEST["ReturnUrl"]); ?>" />
						</div>
					</form>

<!-- End of Main Content -->
				</div>
			</div>
			<div id="utility">
<?php
include("resource/page-component/utility.php");
?>
			</div>
<?php
include("resource/page-component/footer.php");
?>
		</div>
	</body>
</html>