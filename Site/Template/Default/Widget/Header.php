<?php
$memberAuthentication = Factory::getMemberAuthentication();
if ($member = $memberAuthentication->getLoggedInMember()) {
	$profileUrl = "/u/" . $member->alias;
} else {
	$profileUrl = "#";
}
?>
<div class="container">
	<h1>
		<a href="/" title="Back to the <?php echo $this->get("Name"); ?> home page">
			<span><?php echo $this->get("Name"); ?></span>
		</a>
	</h1>
	<div class="utility">
		<ul class="member-navigation">
<?php
$memberAuthentication = Factory::getMemberAuthentication();
if ($memberAuthentication->isLoggedIn() && ($member = $memberAuthentication->getLoggedInMember())) {
?>
			<li class="member logged-in"><a class="name" href="/u/<?php echo $member->alias; ?>"><?php echo $member->alias; ?></a> | <a class="logout" href="#">logout</a></li>
<?php
} else {
?>
			<li class="member logged-out"><a href="#" class="login" title="login to gawkwall">login</a></li>
<?php
}
?>
		</ul>
		<ul class="navigation">
			<li class="<?php echo $this->get("Section") == "wall" ? "selected" : ""; ?>">
				<a class="new-gawk navigation-item" href="/">
					<span>gawk</span>
				</a>
			</li>
			<li class="wide <?php echo $this->get("Section") == "wall-select" ? "selected" : ""; ?>">
				<a class="wall-select navigation-item" href="/wall/">
					<span>create wall</span>
				</a>
			</li>
			<li class="<?php echo $this->get("Section") == "profile" ? "selected" : ""; ?>">
				<a class="yours navigation-item"
					href="<?php echo $profileUrl; ?>">
					<span>profile</span>
				</a>
			</li>
		</ul>
	</div>
</div>