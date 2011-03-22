<div>
	<div class="select-walls" style="float: left; width: 400px; min-height: 200px; padding: 10px;">
		<h1>Select a Wall</h1>
		<p>Take a look at some of the walls that you've bookmarked and appeared on</p>
		<div class="bookmarked" style="float: left; width: 100px; min-height: 200px; padding: 10px;">
			<h2>Bookmarks</h2>
			<ul>
				<li>Wall 1</li>
				<li>Wall 2</li>
			</ul>
		</div>
		<div class="recent-walls" style="float: left; width: 100px; min-height: 200px; padding: 10px;">
			<h2>Recent</h2>
			<ul>
				<li>Wall 1</li>
				<li>Wall 2</li>
			</ul>
		</div>
		<div class="your-walls" style="float: left; width: 100px; min-height: 200px; padding: 10px;">
			<h2>Your Walls</h2>
			<ul>
				<li>Wall 1</li>
				<li>Wall 2</li>
			</ul>
		</div>
	</div>
	<div class="create-wall" style="float: left; width: 450px; min-height: 200px; padding: 10px;">
		<h1>Create your own Wall</h1>
		<p>These are some reasons why...</p>
		<form class="wall" method="post" action="">
			<fieldset>
				<label>
					<strong class="required">Url</strong>
					<?php echo $application->registry->get("Site/Address"); ?>/<input type="text" name="UrlFriendly"
						class="textbox"/><input name="Submit" type="submit"	class="button" value="Create Wall" accesskey="s"
						title="Create a new Wall"/>
					<span class="note">e.g. school-trip-france-2011, jamies-wedding etc.</span>
				</label><br />
			</fieldset>
		</form>
	</div>
</div>
<?php

?>
