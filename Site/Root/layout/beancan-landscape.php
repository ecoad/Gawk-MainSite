<?php
require_once "Application/Bootstrap.php";

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
// Put your stylesheets here.
?>
<link rel="stylesheet" type="text/css" href="/resource/css/layout/beancan-landscape.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

	<h1>Beancan Landscape Layout</h1>

	<div id="headline">
		<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		<h4>This is my headline item</h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="beancan">
		<img src="http://dummyimage.com/140x105/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		<h4>This is my first item</h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="beancan">
		<img src="http://dummyimage.com/140x105/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		<h4>This is my second item</h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="beancan">
		<img src="http://dummyimage.com/140x105/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		<h4>This is my third item</h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="beancan">
		<img src="http://dummyimage.com/140x105/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		<h4>This is my fourth item</h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="beancan">
		<img src="http://dummyimage.com/140x105/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		<h4>This is my fifth item</h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc.
		</p>
		<p>
			<a href="#">Read More &rarr;</a>
		</p>
	</div>

	<div class="beancan">
		<img src="http://dummyimage.com/140x105/ccc/333.gif?v=@VERSION-NUMBER@" alt="Headline Placeholder" />
		<h4>This is my sixth item</h4>
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