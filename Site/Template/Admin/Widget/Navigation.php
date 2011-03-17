<div id="menu-main" class="navigation">
	<ul class="log-off">
		<li class="main-menu"><a href="/account/log-on.php?Submit=LogOff">Log Off</a></li>
	</ul>
	<ul class="home">
		<li class="main-menu"><a href="/admin/">Home</a></li>
		<li class="sub-menu">
			<ul>
				<li><a href="/admin/">Admin Home</a></li>
				<li><a href="/">Site Home</a></li>
			</ul>
		</li>
	</ul>
<?php
	$application  = CoreFactory::getApplication();
	$htmlControl  = CoreFactory::getHtmlControl();
	if ($application->securityControl->isAllowed("Advanced Admin", false)) {
?>
	<ul class="<?php echo $htmlControl->inPath("/admin/advanced","pinned") ;?>">
		<li class="main-menu"><a href="/admin/advanced/">Advanced</a></li>
		<li class="sub-menu">
			<ul>
<?php
	}
?>
<?php
	if ($application->securityControl->isAllowed("Member Admin", false)) {
?>
				<li class="<?php echo $htmlControl->inPath("/admin/advanced/member-detail","active") ;?>"><a href="/admin/advanced/member-detail/">Member Details</a></li>
<?php
	}
?>
<?php
	if ($application->securityControl->isAllowed("Security Group Admin", false)) {
?>
				<li class="<?php echo $htmlControl->inPath("/admin/advanced/security-group","active") ;?>"><a href="/admin/advanced/security-group/">Security Groups</a></li>
<?php
	}
?>
<?php
	if ($application->securityControl->isAllowed("Security Resource Admin", false)) {
?>
				<li class="<?php echo $htmlControl->inPath("/admin/advanced/security-resource","active") ;?>"><a href="/admin/advanced/security-resource/">Security Resources</a></li>
<?php
	}
?>
<?php
	if ($application->securityControl->isAllowed("Cache Admin", false)) {
?>
				<li class="<?php echo $htmlControl->inPath("/admin/advanced/cache","active") ;?>"><a href="/admin/advanced/cache/">Cache</a></li>
<?php
	}
?>
<?php
	if ($application->securityControl->isAllowed("Advanced Admin", false)) {
?>
			</ul>
		</li>
	</ul>
<?php
	}
?>
<?php
	if ($application->securityControl->isAllowed("News Admin", false)) {
?>
	<ul class="<?php echo $htmlControl->inPath("/admin/video","pinned") ;?>">
		<li class="main-menu"><a href="/admin/video/">Video</a></li>
	</ul>
<?php
	}
?>
</div>
<hr />
