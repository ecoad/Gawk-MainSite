<?php
$tabIndex = 1;
?>
<div class="create-wall" style="padding: 30px;">
	<h1>Create a Wall</h1>
	<h2>Create your own wall to share to your friends</h2>
	<p>From here you can create your own custom wall with it's own link that you can share to your friends, family
	and colleagues.</p>
	<p>Some reasons:</p>
	<ul>
		<li>Custom URL</li>
		<li>Public or invite only</li>
	</ul>
	<form class="wall" method="post" action="">
		<div class="form-errors" style="display:none;">
			<h3>Errors</h3>
			<ul></ul>
		</div>
		<fieldset>
			<label>
				<strong class="required">Url</strong>
				<?php echo $application->registry->get("Site/Address"); ?>/<input type="text" name="UrlFriendly" class="textbox" tabindex="<?php echo $tabIndex++; ?>"/>
			</label><br />
			<label>
				<strong class="required">Name</strong>
				<input type="text" name="Name" class="textbox" tabindex="<?php echo $tabIndex++; ?>"/>
			</label><br />
			<label>
				<strong class="required">Description</strong><br />
				<textarea id="summary" name="Description" cols="40" rows="7" class="textbox wide" tabindex="<?php echo $tabIndex++; ?>"></textarea>
			</label><br />
			<label class="checkbox">
				<strong>Publicness</strong>
				<select name="Public" tabindex="<?php echo $tabIndex++; ?>">
					<option>Public</option>
					<option>Anyone can view it, only friends can Gawk on it</option>
					<option>Private only to friends</option>
				</select><br />
				<span class="note">(You can change this at any time)</span><br />
			</label>
			<div class="controls">
				<input name="Submit" type="submit" tabindex="<?php echo $tabIndex++; ?>" class="button" value="Create Wall" accesskey="s" title="Create a new Wall" />
			</div>
		</fieldset>
	</form>
</div>