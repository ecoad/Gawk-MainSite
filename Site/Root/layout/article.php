<?php
require_once "Application/Bootstrap.php";

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
// Put your stylesheets here.
?>
<link rel="stylesheet" type="text/css" href="/resource/css/layout/article.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

	<div id="article">
		<h1>Article Title</h1>
		<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Article Placeholder" />
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc. Nam tortor dui, rhoncus et faucibus id, aliquam eu neque.
			Cras pellentesque iaculis suscipit. Etiam laoreet tempor varius. Nulla sollicitudin semper nulla, vel egestas purus
			placerat vitae. Mauris egestas, est vitae pretium ornare, dolor nunc malesuada arcu, vestibulum mollis elit lacus
			pellentesque orci. Proin at mauris vulputate velit tempor malesuada. Nunc placerat auctor feugiat. Sed vestibulum
			dignissim mi, rhoncus luctus lectus pretium sed. Suspendisse vulputate tortor ac odio ornare viverra.
		</p>
		<h2>This is my sub header</h2>
		<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Article Placeholder" />
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc. Nam tortor dui, rhoncus et faucibus id, aliquam eu neque.
			Cras pellentesque iaculis suscipit. Etiam laoreet tempor varius. Nulla sollicitudin semper nulla, vel egestas purus
			placerat vitae. Mauris egestas, est vitae pretium ornare, dolor nunc malesuada arcu, vestibulum mollis elit lacus
			pellentesque orci. Proin at mauris vulputate velit tempor malesuada. Nunc placerat auctor feugiat. Sed vestibulum
			dignissim mi, rhoncus luctus lectus pretium sed. Suspendisse vulputate tortor ac odio ornare viverra.
		</p>
		<h2>This is my sub header</h2>
		<img src="http://dummyimage.com/340x191/ccc/333.gif?v=@VERSION-NUMBER@" alt="Article Placeholder" />
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc. Nam tortor dui, rhoncus et faucibus id, aliquam eu neque.
			Cras pellentesque iaculis suscipit. Etiam laoreet tempor varius. Nulla sollicitudin semper nulla, vel egestas purus
			placerat vitae. Mauris egestas, est vitae pretium ornare, dolor nunc malesuada arcu, vestibulum mollis elit lacus
			pellentesque orci. Proin at mauris vulputate velit tempor malesuada. Nunc placerat auctor feugiat. Sed vestibulum
			dignissim mi, rhoncus luctus lectus pretium sed. Suspendisse vulputate tortor ac odio ornare viverra.
		</p>
		<h2>This is my sub header</h2>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam bibendum, sapien nec tincidunt mollis, velit purus
			fermentum massa, et scelerisque nulla dolor a nunc. Nam tortor dui, rhoncus et faucibus id, aliquam eu neque.
			Cras pellentesque iaculis suscipit. Etiam laoreet tempor varius. Nulla sollicitudin semper nulla, vel egestas purus
			placerat vitae. Mauris egestas, est vitae pretium ornare, dolor nunc malesuada arcu, vestibulum mollis elit lacus
			pellentesque orci. Proin at mauris vulputate velit tempor malesuada. Nunc placerat auctor feugiat. Sed vestibulum
			dignissim mi, rhoncus luctus lectus pretium sed. Suspendisse vulputate tortor ac odio ornare viverra.
		</p>
		<div class="footer">
			<p>
				Download documents to go here.
			</p>
		</div>
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