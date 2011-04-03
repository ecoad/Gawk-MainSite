<?php
!isset($memberAuthentication) ? $memberAuthentication = Factory::getMemberAuthentication() : null;
if ($memberDataEntity = $memberAuthentication->getLoggedInMember()) {
	$profileUrl = $memberDataEntity->getUrl();
} else {
	$profileUrl = "/member/login/";
}
?>
<ul id="navigation-widget">
  <li><a class="new-gawk" href="/">Gawk</a></li>
  <li><a class="wall-select" href="/wall/">Wall</a></li>
  <li><a class="yours" href="<?php echo $profileUrl; ?>">Profile</a></li>
</ul>
<a href="#"><img width="170" style="float:left;" src="http://nekodot.jp/appstore.gif" /></a>
<hr />