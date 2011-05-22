<?php 
$systemWallFactory = Factory::getSystemWallFactory();
?>
<div class="record-gawk" style="float:left; width: 113px;">
	<a href="#" class="record">RECORD GAWK</a>
</div>
<div class="wall-information" style="float: left;">
	<h3>
		<span class="bookmark" style="display: <?php 
			echo $systemWallFactory->isSystemWall($wall->secureId) ? "none" : "inline"; ?>;">
		<img src="http://www.srkexport.com/images/favourites-icon.gif" /> </span>
		<span class="name"><?php echo $wall->name; ?></span>
	</h3>
	<p class="description"><?php echo $wall->description; ?></p>
</div>
<div class="wall-select" style="float:right; padding: 5px; display: none;">
<?php 
	if ($wallControl->isMemberAuthorizedToEditWall($wall->url)) {
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
				</select><br />
			</label>
		</fieldset>
	</form>
</div>