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
				<p>{BODY}</p>
				<p>This feedback can be <a href="{SITE_ADDRESS}/admin/feedback/view.php?Submit=View&amp;Id={ID}">viewed</a> on the Web site.</p>
			</div>
			<div id="email-footer">
				<p>---</p>
				<p>To make sure our e-mail notifications isn't eaten up by spam filters, don't forget to add <a href="mailto:{SITE_SUPPORT_EMAIL}">{SITE_SUPPORT_EMAIL}</a> to your e-mail address book.</p>
				<p>If you experiencing any problems with the {SITE_ADDRESS} Web site, please e-mail us at <a href="mailto:{SITE_SUPPORT_EMAIL}">{SITE_SUPPORT_EMAIL}</a>.</p>
			</div>
		</div>
	</body>
</html>