<?php
!isset($memberAuthentication) ? $memberAuthentication = Factory::getMemberAuthentication() : null;
if ($memberDataEntity = $memberAuthentication->getLoggedInMemberDataEntity()) {
	$profileUrl = $memberDataEntity->getUrl();
} else {
	$profileUrl = "/member/login/";
}
?>
<ul id="navigation-widget">
	<li>
		<a class="new-gawk" href="/">
			<span>Gawk</span>
		</a>
	</li>
	<li>
		<a class="wall-select" href="/wall/">
			<span>Create Wall</span>
		</a>
	</li>
	<li>
		<a class="yours" href="<?php echo $profileUrl; ?>">
			<span>Profile</span>
		</a>
	</li>
</ul>
<hr />