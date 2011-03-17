<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>{SITE_NAME}</title>
		<link href="{SITE_ADDRESS}/resources/css/email/email.css?v=@VERSION-NUMBER@" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="email">
			<div id="emailheader">
				<h1><a href="{SITE_ADDRESS}"><span>{SITE_NAME}</span></a></h1>
			</div>
			<div id="emailbody">
				<h2><a href="mailto:{EMAILADDRESS}">{FULLNAME}</a> has sent the following feedback:</h2>
				<h3><strong>Subject:</strong>&#09;{SUBJECT}</h3>
				<p><strong>Body:</strong></p>
				<p>{BODY}</p>
				<p>This feedback can be <a href="{SITE_ADDRESS}/admin/feedback/control.php?Submit=Edit&amp;Id={ID}">viewed</a> on the Web site.</p>
			</div>
			<div id="emailfooter">
				<p>If you experience any problems, please e-mail us <a href="mailto:{SITE_SUPPORT_EMAIL}">{SITE_SUPPORT_EMAIL}</a>.</p>
			</div>
		</div>
	</body>
</html>