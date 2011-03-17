<?php
	require_once("Application/Bootstrap.php");
	// Force Non-SSL.
	$application->isSecure(false, true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $application->registry->get("Title"); ?></title>

<!--[if lt IE 7]>
	<script src="/resource/javascript/browser/internet-explorer/DD_roundies/DD_roundies.js?v=@VERSION-NUMBER@" type="text/javascript"></script>
<![endif]-->

		<script src="DOMAssistantCompressed-2.7.4.js?v=@VERSION-NUMBER@" type="text/javascript"></script>
		<script src="ie-css3.js?v=@VERSION-NUMBER@" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="style.css?v=@VERSION-NUMBER@" media="all" />
	</head>
	<body>
		<div id="container" class="index">
			<div id="wrapper">
				<div id="main-content">
<!-- Start of Main Content -->

					<ul id="test1" class="test-area">
						<li>1 <span>:first-child</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>
					
					<ul id="test2" class="test-area">
						<li>1 <span>:last-child</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>
					
					<ul id="test3" class="test-area">
						<li>1 <span>:nth-child(2)</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>
					
					<ul id="test4" class="test-area">
						<li>1 <span>:nth-last-child(2)</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>
					
					<ul id="test5" class="test-area">
						<li>1 <span>:nth-of-type(odd)</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>
					
					<ul id="test6" class="test-area">
						<li>1 <span>:nth-of-type(even)</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>
					
					<ul id="test7" class="test-area">
						<li>1 <span>:nth-of-type(2n+5)</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>
					
					<ul id="test8" class="test-area">
						<li>1 <span>:nth-last-child(2n+5)</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>
					
					<ul id="test9" class="test-area">
						<li>1 <span>:nth-of-type(n+2):nth-last-of-type(n+2)</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>

					<ul id="test10" class="test-area">
						<li>1 <span>:only-child</span></li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>6</li>
						<li>7</li>
						<li>8</li>
						<li>9</li>
						<li>10</li>
					</ul>

					<ul id="test11" class="test-area">
						<li>1 <span>:only-child</span></li>
					</ul>

<!-- End of Main Content -->
				</div>		
			</div>
		</div>
	</body>
</html>