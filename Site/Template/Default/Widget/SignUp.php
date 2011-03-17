<div id="newsletter">
	<h3><span>Subscribe to our newsletter</span></h3>
	<form action="/newsletter_register.php" method="post">
		<fieldset>
			<label><strong>E-mail Address:</strong>
				<input name="EmailAddress" type="text" class="textbox" value="Email Address" size="20"
					onfocus="toggleDefaultValue(this, 'Email Address', '', true)"
					onblur="toggleDefaultValue(this, '', 'Email Address', false)"/>
			</label>
		</fieldset>
		<div class="controls">
			<input name="Submit" type="submit" class="button" value="Sign Up" />
		</div>
	</form>
</div>