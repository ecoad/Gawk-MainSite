<?php
$tabIndex = 1;
?>
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
	<fieldset>
		<label>
			<strong class="required">Name</strong>
			<input type="text" name="Name" class="textbox" tabindex="<?php echo $tabIndex++; ?>"/>
		</label><br />
		<label>
			<strong class="required">Url</strong>
			http://www.gawkwall.com/w/<input type="text" name="UrlFriendly" class="textbox" tabindex="<?php echo $tabIndex++; ?>"/>
		</label><br />
		<label>
			<strong class="required">Description</strong>
			<textarea id="summary" name="Description" cols="40" rows="15" class="textbox wide" tabindex="<?php echo $tabIndex++; ?>"></textarea>
		</label><br />
		<label class="checkbox">
			<strong>Publicness</strong>
			<select name="Public" tabindex="<?php echo $tabIndex++; ?>">
				<option>Public</option>
				<option>Private</option>
			</select><br />
			<span>Public - Anyone can Gawk on your wall that finds the link to your wall</span><br />
			<span>Private - Gawking on this wall is for people who are either invited or request access</span>
		</label>
		<div class="controls">
			<input name="Submit" type="submit" tabindex="<?php echo $tabIndex++; ?>" class="button" value="Create Wall" accesskey="s" title="Create a new Wall" />
			<input name="Submit" type="submit" tabindex="<?php echo $tabIndex++; ?>" class="button" value="Cancel" accesskey="c" title="Cancel creating a Wall" />
		</div>
	</fieldset>
</form>