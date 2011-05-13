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
					hello <a class="name" href="#"></a> | <a class="logout" href="#">logout</a>
				</div>
				<div class="logged-out" style="display:none;">
					login or register <fb:login-button></fb:login-button>
				</div>
			</div>
			<div class="share">
				<iframe class="twitter" frameborder="no" scrolling="no" class="twitter-share" style="height: 20px;"
					src="http://platform.twitter.com/widgets/tweet_button.html?text=Gawk+Wall&amp;url=http%3A%2F%2Fwww.gawkwall.com"></iframe>
				<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="" send="false" layout="button_count" width="50" show_faces="false" font="arial"></fb:like>
			</div>
		</div>
		<div class="lower">
			<a href="#" class="app-store">Get the iPhone app on the App Store</a>
		</div>
	</div>
</div>