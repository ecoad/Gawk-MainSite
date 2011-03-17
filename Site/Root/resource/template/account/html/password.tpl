<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>{SITE_NAME}</title>
		<link href="{SITE_ADDRESS}/resource/css/email/email.css?v=@VERSION-NUMBER@" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="email">
			<div id="email-header">
				<h1><a href="{SITE_ADDRESS}"><span>{SITE_NAME}</span></a></h1>
			</div>
			<div id="email-body">
				<a href="{SITE_ADDRESS}"><img src="{SITE_ADDRESS}/resource/image/email/logo.gif?v=@VERSION-NUMBER@" title="{SITE_NAME} logo" alt="{SITE_NAME} logo" class="logo" /></a>
				<h2>Hello {EMAIL},</h2>
				<h3>Password Reset</h3>
				<p>We have received a password reset request from this e-mail address.</p>
				<p>To change your password please <a href="{SITE_ADDRESS}/account/password/reset/control.php?Id={ID}">click here</a></p>
				<p>If you did not place this request or have remembered your password, please ignore this e-mail.</p>
				<p><strong>N.B.</strong> The above link is only valid for 60 minutes from the request. If you do not follow the link in time you will have to place another request to change your password.</p>
			</div>
			<div id="email-footer">
				<p>---</p>
				<p>To make sure our e-mail notifications isn't eaten up by spam filters, don't forget to add <a href="mailto:{SITE_SUPPORT_EMAIL}">{SITE_SUPPORT_EMAIL}</a> to your e-mail address book.</p>
				<p>If you experiencing any problems with the {SITE_ADDRESS} Web site, please e-mail us at <a href="mailto:{SITE_SUPPORT_EMAIL}">{SITE_SUPPORT_EMAIL}</a>.</p>
			</div>
		</div>
	</body>
</html>