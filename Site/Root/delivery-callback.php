<?php
set_time_limit(0);
require_once("Application/Bootstrap.php");

$messagePath = $application->registry->get("Log/Path") . "/feedback-messages/";

if (isset($_FILES) && array_key_exists("message", $_FILES)) {
	copy($_FILES["message"]["tmp_name"], $messagePath . "new/" . uniqid(date("Y-m-d") . "T" . date("H:i:sO") . "-") . ".mail");
}

function logError($description, $filelocation, $logPath) {
	$errorLog = $logPath . "/feedback-messages/error.log";
	$content = date("Y-m-d H:i:s") . "\t" . $description . "\t" . basename($filelocation) . "\n";

	if ($handle = fopen($errorLog, "a")) {
		@fwrite($handle, $content);
	}

	fclose($handle);
}

function parseDsnMessageArray($contents) {

	$result = array(
		"Reply-To:" => null,
		"Reference" => null,
		"Body" => null,
		"IpAddress" => 0,
	);

	$matches = array();

	// Parse the DSN header.
	while (list($lineNumber, $line) = each($contents)) {
		$line = trim($line);

		// Blank line indicates end of header.
		if ($line == "") break;
		preg_match("/^Subject: *(.*)/", $line, $matches);
		if (isset($matches[1])) {
			$result["Reference"] = substr(strstr($matches[1], "Feedback Reference: "), 20);
		}

		preg_match("/^Reply-To: *(.*)/", $line, $matches);
		if (isset($matches[1])) {
			$result["Reply-To"] = $matches[1];
		} else {
			preg_match("/^From: *(.*)/", $line, $matches);
			if (isset($matches[1])) {
				$result["Reply-To"] = $matches[1];
			}
		}
		if (isset($matches[1])) {
			if (strpos($result["Reply-To"], "<")) {
				$result["Reply-To"] = substr(strstr($result["Reply-To"], "<"), 1, -1);
			}
		}
		preg_match("/^X-SA-Exim-Connect-IP: *(.*)/", $line, $matches);
		if (isset($matches[1])) {
			$result["IpAddress"] = $matches[1];
		}
	}

	$body = "";

	while (list($lineNumber, $line) = each($contents)) {
		$body .= $line;
	}

	$result["Body"] = $body;

	return $result;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Clock DSN Admin</title>
	</head>
	<body>
<?php
foreach (glob($messagePath . "new/*.mail") as $filelocation) {
	$filename = str_replace($messagePath . "new/", "", $filelocation);

	$contents = file($filelocation);
	$result = parseDsnMessageArray($contents);
	$error = false;

	if(!isset($result["Reply-To"])) {
		$error = true;
		$message = "Email missing\t";
	}

	if(!isset($result["Body"])) {
		$error = true;
		$message = "Body missing\t";
	}

	if (!$error) {
		$feedbackControl = BaseFactory::getFeedbackControl();
		$feedbackNoteControl = BaseFactory::getFeedbackNoteControl();

		$feedback = $feedbackControl->makeNew();
		$feedback->set("Reference", $result["Reference"]);
		$feedback->set("Body", $result["Body"]);
		$feedback->set("IpAddress", $result["IpAddress"]);
		$feedback->set("Status", FBK_NEW);
		$feedback->set("EmailAddress", $result["Reply-To"]);

		if ($referenceFeedback = $feedbackControl->itemByField($result["Reference"], "Reference")) {
			$feedbackSubject = $referenceFeedback->get("Subject");
			$feedbackName = $referenceFeedback->get("FullName");
		} else {
			$feedbackSubject = "(New Feedback)";
			$feedbackName = "(No Name Given)";
		}
		$feedback->set("Subject", $feedbackSubject);
		$feedback->set("FullName", $feedbackName);

		if ($feedback->save()) {
			$feedbackNote = $feedbackNoteControl->makeNew();
			$feedbackNote->set("Body", "Response received: \n\r" . $result["Body"]);
			$feedbackNote->set("Status", FBK_NEW);
			$feedbackNote->set("FeedbackId", $feedback->get("Id"));

			if  ($feedbackNote->save()) {
				$emailTemplate = CoreFactory::getTemplate();
				$emailTemplate->setTemplateFile("/resource/template/feedback/html/response.tpl");
				$emailTemplate->set("SITE_NAME", $application->registry->get("Name"));
				$emailTemplate->set("SITE_ADDRESS", $application->registry->get("Site/Address"));
				$emailTemplate->set("SITE_SUPPORT_EMAIL", $application->registry->get("EmailAddress/Support"));
				$emailTemplate->set("FULL_NAME", $feedbackName);
				$emailTemplate->set("EMAIL_ADDRESS", $result["Reply-To"]);
				$emailTemplate->set("SUBJECT", $feedbackSubject);
				$emailTemplate->set("ID", $feedback->get("Id"));
				$emailTemplate->set("BODY", nl2br($result["Body"]));

				$plainEmailTemplate = CoreFactory::getTemplate();
				$plainEmailTemplate->setTemplateFile("/resource/template/feedback/plain/response.tpl");
				$plainEmailTemplate->set("SITE_NAME", $application->registry->get("Name"));
				$plainEmailTemplate->set("SITE_ADDRESS", $application->registry->get("Site/Address"));
				$plainEmailTemplate->set("SITE_SUPPORT_EMAIL", $application->registry->get("EmailAddress/Support"));
				$plainEmailTemplate->set("FULL_NAME", $feedbackName);
				$plainEmailTemplate->set("EMAIL_ADDRESS", $result["Reply-To"]);
				$plainEmailTemplate->set("SUBJECT", $feedbackSubject);
				$plainEmailTemplate->set("ID", $feedback->get("Id"));
				$plainEmailTemplate->set("BODY", $result["Body"]);

				$email = CoreFactory::getEmail();
				$email->setTo($application->registry->get("EmailAddress/Support"));
				$email->setFrom($application->registry->get("EmailAddress/Support"));
				$email->setSubject("Feedback Response - Reference: " . $result["Reference"]);
				$email->setBody($emailTemplate->parseTemplate(), false);
				$email->setPlainBody($plainEmailTemplate->parseTemplate(), false);
				$email->sendMail();
			} else {
				logError("Feedback note not saved", $filelocation, $application->registry->get("Log/Path"));
			}
		} else {
			logError("Feedback not saved", $filelocation, $application->registry->get("Log/Path"));
		}
	} else {
		logError("Required field(s) missing\t" . $message, $filelocation, $application->registry->get("Log/Path"));
	}

	//move file
	rename($filelocation, $application->registry->get("Log/Path") . "/feedback-messages/old/" . $filename);
}
?>
	</body>
</html>