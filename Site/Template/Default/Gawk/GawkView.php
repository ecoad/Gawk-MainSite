<?php
$systemWallFactory = Factory::getSystemWallFactory();
?>
<div id="title-area">
	<div class="wall-information" style="float: left;">
		<h2><?php echo $wall->name; ?></h2>
		<p class="description"><?php echo $wall->description; ?></p>
	</div>
	<div class="wall-controls">
		<div class="record-gawk" style="float:left; width: 113px;">
			<a href="#" class="record"><span>record</span></a>
		</div>
		<div class="wall-select" style="float:right; padding: 5px; display: none;">
<?php
	if ($wallControl->isMemberAuthorizedToEditWallBySecureId($wall->secureId)) {
?>
			<a href="/wall/edit/<?php echo $wall->url; ?>">edit</a>
<?php
	}
?>
			<form class="select-wall" method="get" action="">
				<fieldset>
					<label>
						<strong>select wall</strong>
						<select name="SelectWall">
							<option>Test</option>
						</select><br />
					</label>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<div class="wall-container">
	<div id="Gawk">You don't have Flash! <a href="http://get.adobe.com/flashplayer/">Please download Flash</a> or use a browser that supports Flash.</div>
</div>