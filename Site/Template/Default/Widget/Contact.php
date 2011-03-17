<?php
$feedbackControl = Factory::getFeedbackControl();
$memberControl = BaseFactory::getMemberControl();
$captcha = CoreFactory::getCaptcha();

switch($application->parseSubmit()) {
	case "Send":
		$feedback = $feedbackControl->map($_POST);
		$feedback->set("Type", "Feedback");
		$feedback->set("Parent", true);
		if ($feedback->get("SportStatusType") == FBK_SPORTSTATUS_OTHER &&
			(!isset($_POST["SportStatus"]) || ($_POST["SportStatus"] == ""))) {
			$application->errorControl->addError("'Status' must not be empty");
		} else if ($feedback->get("SportStatusType") != FBK_SPORTSTATUS_OTHER && isset($_POST["SportStatus"])) {
			$_POST["SportStatus"] = "";
		}

		if ($_POST["Captcha"] == "") {
			$application->errorControl->addError("Please enter the code shown below.");
		} else if (!$captcha->check($_POST["Captcha"])) {
			$application->errorControl->addError("You did not enter the correct code. Please try again.");
		}

		if ($feedback->isNull("FullName")) {
			$application->errorControl->addError("'Full Name' must not be empty");
			$feedbackControl->validate($feedback);
			break;
		}	else if ($feedbackControl->submit($feedback)) {
			$application->redirect($redirectPage);
		}

		break;
	default:
		$feedback = $feedbackControl->makeNew();
		break;
}

if ($member = $memberControl->item($application->securityControl->getMemberId())) {
	$feedback->set("FullName", $member->getFormatted("FirstName") . " " . $member->getFormatted("LastName"));
	$feedback->set("EmailAddress", $member->getFormatted("EmailAddress"));
}

?>
<script type="text/javascript">
//	<![CDATA[
Event.observe(window, "dom:loaded", function() {
	var actions = [
		new RumbleUI.ConditionalAction("<?php echo FBK_SPORTSTATUS_OTHER; ?>", function() { $("other-status").show(); }),
	];

	var conditionalListener = new RumbleUI.ConditionalListener($("status"), actions, function() { $("other-status").hide(); }, true);
});
// ]]>
</script>
<?php
if ($feedbackControl->errorControl->hasErrors()) {
?>
<div class="form-errors">
	<h4><span>There was a problem with your form submission</span></h4>
	<p>Please check the following, then correct your form accordingly before submitting again.</p>
	<ul>
		<?php echo $htmlControl->makeList($feedbackControl->errorControl->getErrors()); ?>
	</ul>
</div>
<?php
}
?>
<form action="" method="post">
	<fieldset id="contact-form">
		<label>
			<strong class="required">Full Name <span>*</span></strong>
			<input name="FullName" type="text" class="textbox medium"
				value="<?php echo $feedback->get("FullName"); ?>"
				maxlength="<?php echo $feedback->getMaxLength("FullName"); ?>" />
		</label><br />
		<label>
			<strong class="required">E-mail Address <span>*</span></strong>
			<input name="EmailAddress" type="text" class="textbox medium"
				value="<?php echo $feedback->get("EmailAddress"); ?>"
				maxlength="<?php echo $feedback->getMaxLength("EmailAddress"); ?>" />
		</label><br />
		<label>
			<strong class="required">Status <span>*</span></strong>
			<select id="status" name="SportStatusType" class="listbox medium">
				<?php echo $htmlControl->createArrayListValues($feedback->get("SportStatusType"), $feedbackControl->sportStatus); ?>
			</select>
		</label><br />
		<label id="other-status">
			<strong>Other</strong>
			<input name="SportStatus" type="text" class="textbox medium"
				value="<?php echo isset($_POST["SportStatus"]) ? $_POST["SportStatus"] : ""; ?>"
				maxlength="<?php echo $feedback->getMaxLength("SportStatus"); ?>" />
		</label><br />
		<label>
			<strong class="required">Subject Category <span>*</span></strong>
			<select id="subject" name="SubjectCategory" class="listbox medium">
				<?php echo $htmlControl->createArrayListValues($feedback->get("SubjectCategory"), $feedbackControl->category); ?>
			</select>
		</label><br />
		<label>
			<strong class="required">Subject <span>*</span></strong>
			<input name="Subject" type="text" class="textbox medium"
				value="<?php echo $feedback->get("Subject"); ?>"
				maxlength="<?php echo $feedback->getMaxLength("SportStatus"); ?>" />
		</label><br />
		<label>
			<strong class="required">Message <span>*</span></strong>
			<textarea name="Body" cols="40" rows="6"
				class="textbox medium tall" id="Body"
				onchange="return RumbleUI.Form.Textarea.restrictLength(this,
					<?php echo $feedback->getMaxLength("Body"); ?>)"
				onkeypress="return RumbleUI.Form.Textarea.restrictLength(this,
					<?php echo $feedback->getMaxLength("Body"); ?>)"
				onkeyup="return RumbleUI.Form.Textarea.restrictLength(this,
					<?php echo $feedback->getMaxLength("Body"); ?>)"><?php echo $feedback->get("Body"); ?></textarea>
		</label><br />

	<div class="bot-prevent">
		<div class="bot-prevent-description">
			<p><strong>Are you human?</strong> By asking you to enter the five characters you see in the below image, we know that you are human and not an automated computer program.</p>
			<img src="/captcha-code.php" title="Captcha" alt="Captcha" />
		</div>
			<label>
				<strong class="required">Enter characters <span>*</span></strong>
				<input name="Captcha" type="text" class="textbox" value="" />
				<span class="note">All characters are case sensitive</span>
			</label><br />
		</div>


	</fieldset>
	<div class="controls">
		<input name="Submit" type="submit" class="button" value="Send" accesskey="s" />
		<input name="CancelUrl" type="hidden" value="<?php echo $application->getLastPage(); ?>" />
	</div>
</form>