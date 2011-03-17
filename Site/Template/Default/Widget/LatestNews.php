<?php
$cacheControl = &CoreFactory::getCacheControl();
if (!$cacheControl->isCached("LatestNews", true, time() + 1800)) {
	$newsControl = BaseFactory::getNewsControl();
	$newsControl->retrieveForSection(SECTION_MAIN, true);
?>
<div id="latest-news">
	<h3><a href="/article/" title="View the latest news"><span>Latest News</span></a></h3>
<?php
	while ($news = $newsControl->getPage(1, 1)) {
?>
	<h4><a href="/article/view.php?Id=<?php echo $news->get("Id"); ?>"><?php echo $news->get("Subject"); ?></a></h4>
	<p class="date"><?php echo $news->getFormatted("LiveDate"); ?></p>
	<p><?php echo $news->getFormatted("Summary"); ?></p>
<?php
	}
?>
	<p><a href="/article/" title="Browse more news stories">Browse more news stories</a></p>
</div>
<?php
}
$cacheControl->showCached("LatestNews");