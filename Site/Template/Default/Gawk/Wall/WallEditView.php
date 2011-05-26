<?php
$tabIndex = 1;
?>
<div class="breadcrumb">
<?php 
if ($wallCreate) {
?>
	<a href="/">home</a> / <a title="create wall" href="/wall/">wall</a> /
		create	
<?php 
} else {
?>
	<a href="/">home</a> / <a title="view wall" href="<?php echo $wall->url; ?>"><?php echo $wall->name; ?></a> /
		edit
<?php 
}
?>
	<hr />
</div>
<div class="create-wall">
<?php 
if ($wallCreate) {
?>
	<h1>create a Wall</h1>
	<p>From here you can create your own custom wall with it's own link that you can share to your friends, family
	and colleagues.</p>
	<p>Some reasons:</p>
	<ul>
		<li>custom URL</li>
		<li>public or invite only</li>
	</ul>
<?php 
} else {
?>
	<h1>edit wall</h1>
	<p>make any changes to th wall here, and press save to continue</p>
<?php 
}
?>
	<form class="wall" method="post" action="">
		<div class="form-errors" style="display:none;">
			<h3>errors</h3>
			<ul></ul>
		</div>
		<fieldset>
			<label>
				<strong class="required">url</strong>
				<?php echo $application->registry->get("Site/Address"); ?>/<input type="text" name="UrlFriendly" 
					class="textbox" tabindex="<?php echo $tabIndex++; ?>" value="<?php echo $wall->url; ?>"/>
				<span class="note">e.g. gawkwall-friends, johns-family, kettle-fish</span>
			</label><br />
			<label>
				<strong class="required">wall name</strong>
				<input type="text" name="Name" class="textbox" tabindex="<?php echo $tabIndex++; ?>" 
					value="<?php echo $wall->name; ?>"/>
				<span class="note">e.g. Friends of Gawkwall, John's Family, Kettle Fish</span>
			</label><br />
			<label>
				<strong class="required">description</strong><br />
				<textarea id="summary" name="Description" cols="40" rows="7" class="textbox wide" 
					tabindex="<?php echo $tabIndex++; ?>"><?php echo $wall->description; ?></textarea>
			</label><br />
			<label class="checkbox">
				<strong>publicness</strong>
				<select name="Public" tabindex="<?php echo $tabIndex++; ?>">
					<option>Public</option>
					<option>Anyone can view it, only friends can Gawk on it</option>
					<option>Private only to friends</option>
				</select><br />
				<span class="note">(You can change this at any time)</span><br />
			</label>
			<div class="controls">
				<input type="hidden" name="SecureId" value="<?php echo $wall->secureId; ?>"/>
				<input name="Submit" type="submit" tabindex="<?php echo $tabIndex++; ?>" class="button" value="save" 
					accesskey="s" title="save this wall" />
<?php 
if (!$wallCreate) {
?>
				<input name="Delete" type="button" tabindex="<?php echo $tabIndex++; ?>" class="button" value="delete wall" 
					accesskey="d" title="delete this wall" />
<?php 
}
?>
			</div>
		</fieldset>
	</form>
</div>