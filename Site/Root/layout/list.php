<?php
require_once("Application/Bootstrap.php");
// Force Non-SSL.
$application->isSecure(false, true);

// Controller code goes here.

// Put things needed for the view here.
$articleControl = Factory::getArticleControl();
$articleControl->getLiveAndActive();

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "News / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");

// Layout begins here. Tech only above this line.
$layout->start("Style");
// Put your stylesheets here.
?>
<link rel="stylesheet" type="text/css" href="/resource/css/layout/list.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

	<h1><span>List</span></h1>

	<div class="list-entry">
		<a href="#" class="image-link">
			<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		</a>
		<h4><a href="#">This is my item title</a></h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="list-entry">
		<a href="#" class="image-link">
			<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		</a>
		<h4><a href="#">This is my item title</a></h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="list-entry">
		<a href="#" class="image-link">
			<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		</a>
		<h4><a href="#">This is my item title</a></h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="list-entry">
		<a href="#" class="image-link">
			<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		</a>
		<h4><a href="#">This is my item title</a></h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="list-entry">
		<a href="#" class="image-link">
			<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		</a>
		<h4><a href="#">This is my item title</a></h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="list-entry">
		<a href="#" class="image-link">
			<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		</a>
		<h4><a href="#">This is my item title</a></h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="list-entry">
		<a href="#" class="image-link">
			<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		</a>
		<h4><a href="#">This is my item title</a></h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

<?php
$layout->start("Utility");
?>

	<h2>This is my utility</h2>
	<p>
		This content should be tangentially related to the page content.
	</p>

<?php
$layout->start("JavaScript");
// All JavaScript goes here
?>
<script type="text/javascript">
//<![CDATA[

//]]>
</script>
<?php
$layout->render();