<?php
if ($member = $memberAuthentication->getLoggedInMember()) {
	$profileUrl = "/u/" . $member->alias;
} else {
	$profileUrl = "#";
}
?>
<ul id="navigation-widget">
	<li>
		<a class="new-gawk navigation-item <?php echo $this->get("Section") == "wall" ? "selected" : ""; ?>" href="/">
			<span>Gawk</span>
		</a>
	</li>
	<li>
		<a class="wall-select navigation-item <?php echo $this->get("Section") == "wall-select" ? "selected" : ""; ?>" href="/wall/">
			<span>Create Wall</span>
		</a>
	</li>
	<li>
		<a class="yours navigation-item <?php echo $this->get("Section") == "profile" ? "selected" : ""; ?>"
			href="<?php echo $profileUrl; ?>">
			<span>Profile</span>
		</a>
	</li>
</ul>
<hr />