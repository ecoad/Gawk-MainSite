<?php
$facebook = Factory::getFacebookContentSharing();
$twitter = Factory::getTwitterContentSharing();
$email = Factory::getEmailContentSharing();
$digg = Factory::getDiggContentSharing();
$delicious = Factory::getDeliciousContentSharing();
$shareTitle = "Gawk on this wall";
?>
<div id="social">
	<ul id="social-media">
		<li id="twitter">
			<a href="<?php echo $twitter->getPostUrl($application->getCurrentUrl(), $shareTitle, $application->registry->get("TwitterAccount")); ?>" title="Share this on Twitter" target="_blank">Tweet</a>
		</li>
		<li id="digg">
			<a href="<?php echo $digg->getPostUrl($application->getCurrentUrl(), $shareTitle, $shareTitle); ?>" title="Digg this" target="_blank">Digg</a>
		</li>
		<li id="facebook-like">
			<?php echo $facebook->getLikeButton($application->getCurrentUrl()); ?>
		</li>
		<li id="contact">
			<a href="/about/#contact">contact</a>
		</li>
	</ul>
	<div style="float: right;">Design by <a href="http://yeyah.co.uk">Yeyah</a> and powered by <a href="http://clock.co.uk">Clock</a></div>
</div>