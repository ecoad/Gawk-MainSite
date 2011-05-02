<div class="container">
	<hgroup>
		<h1>
			<a href="/" title="Back to the <?php echo $this->get("Name"); ?> home page">
				<span><?php echo $this->get("Name"); ?></span>
			</a>
		</h1>
	</hgroup>
	<div class="utility">
		<div class="upper">
			<div class="login-widget">
				<div id="fb-root"></div>
				<div class="logged-in" style="display:none;">
					Hello <a class="name" href="#"></a> | <a class="logout" href="#">logout</a>
				</div>
				<div class="logged-out" style="display:none;">
					<fb:login-button></fb:login-button> or <a class="site-login" href="#" title="Click here to log on">Login</a> / <a class="site-register" href="#" title="Click here to register">Register</a>
				</div>
			</div>
			<div class="share">
				<iframe class="twitter" frameborder="no" scrolling="no" class="twitter-share" style="height: 20px;"
					src="http://platform.twitter.com/widgets/tweet_button.html?text=Gawk+Wall&amp;url=http%3A%2F%2Fwww.gawkwall.com"></iframe>
				<fb:share-button
					href="<?php echo $application->registry->get("Site/Address"); ?>" type="button_count" class="facebook">
					</fb:share-button>
			</div>
		</div>
		<div class="lower">
			<a href="#" class="app-store">Get the iPhone app on the App Store</a>
		</div>
	</div>
</div>