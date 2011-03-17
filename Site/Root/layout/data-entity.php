<?php
require_once "Application/Bootstrap.php";

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "home");
$layout->start("Style");
// Put your stylesheets here.
?>
<link rel="stylesheet" type="text/css" href="/resource/css/layout/data-entity.css?v=@VERSION-NUMBER@" media="all" />

<?php
$layout->start("Main");
// The main page content goes here.
?>

	<h1>Data Entity Information</h1>

	<h2>Tables</h2>
	<table class="data-entity" cellpadding="0" cellspacing="0" title="A description of the table">
		<caption>A summary of the table's contents</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th class="action">Action</th>
				<th>Name</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="integer">1</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
			<tr>
				<td class="integer">2</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
			<tr>
				<td class="integer">3</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
			<tr>
				<td class="integer">4</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
			<tr>
				<td class="integer">5</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
			<tr>
				<td class="integer">6</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
			<tr>
				<td class="integer">7</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
			<tr>
				<td class="integer">8</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
			<tr>
				<td class="integer">9</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
			<tr>
				<td class="integer">10</td>
				<td class="action"><a href="#">Edit</a></td>
				<td>Some text would appear here</td>
				<td class="date">20 July 2010</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4">Statistics manufactured manually by Clock Ltd.</td>
			</tr>
		</tfoot>
	</table>

	<h2>Definition Lists</h2>

	<p>
		Definition lists, created using the DL element, generally consist of a series of term/definition pairs (although definition lists may have other applications).
		Thus, when advertising a product, one might use a definition list:
	</p>

	<dl>
		<dt>Lower cost</dt>
		<dd>The new version of this product costs significantly less than the previous one!</dd>
		<dt>Easier to use</dt>
		<dd>We've changed the product so that it's much easier to use!</dd>
		<dt>Safe for kids</dt>
		<dd>You can leave your kids alone in a room with this product and they won't get hurt (not a guarantee).</dd>
		<dt>We can define a term</dt>
		<dd>And possibly assign it a value</dd>
		<dt>Or show a result option</dt>
		<dd>And show 70% of people voted for it</dd>
	</dl>

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