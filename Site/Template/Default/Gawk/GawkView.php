<?php
$systemWallFactory = Factory::getSystemWallFactory();
?>
<div id="title-area">
	<div class="wall-information">
		<div class="upper clear-fix">
			<h2><?php echo $wall->name; ?></h2>
<?php
if (!$systemWallFactory->isSystemWall($wall->secureId)) {
?>
			<span class="bookmark"></span>
<?php
}
?>
		</div>
		<p class="description"><?php echo $wall->description; ?></p>
	</div>
	<div class="wall-controls">
		<div class="wall-select" style="display: none;">
<?php
	if ($wallControl->isMemberAuthorizedToEditWallBySecureId($wall->secureId)) {
?>
			<a href="/wall/edit/<?php echo $wall->url; ?>">edit</a>
<?php
	}
?>
			<form class="select-wall" method="get" action="">
				<select name="SelectWall">
				</select>
			</form>
		</div>
		<div class="record-gawk">
			<a href="#" class="record"><span>record</span></a>
		</div>
	</div>
</div>
<div class="view-container">
	<div id="Gawk">You don't have Flash! <a href="http://get.adobe.com/flashplayer/">Please download Flash</a> or use a browser that supports Flash.</div>
	<div class="share">
		<span class="twitter">
			<iframe allowtransparency="true" frameborder="0" scrolling="no"
				src="http://platform.twitter.com/widgets/tweet_button.html"
				style="width:97px; height:20px;"></iframe>
		</span>
		<span class="facebook">
			<fb:like href="www.gawkwall.com" send="false" layout="button_count" width="83" show_faces="false" font="arial"></fb:like>
		</span>
	</div>
</div>
