<?php
require_once("Application/Bootstrap.php");

$facebook = Factory::getFacebook($application);
$wallControl = Factory::getWallControl();
$memberAuthentication = Factory::getMemberAuthentication();
if (!$memberAuthentication->isLoggedIn()) {
	$application->redirect("/?Login=1&ReturnUrl=" . $_SERVER["SCRIPT_NAME"]);
}

$createRequestUrl = "/wall/create";
$wallCreate = substr($_SERVER["REQUEST_URI"], 0, strlen($createRequestUrl)) == $createRequestUrl;

$urlParts = explode("/", $_SERVER["REQUEST_URI"]);
$urlName = isset($urlParts[3]) ? $urlParts[3] : "";
if ($wallCreate) {
	$wall = Factory::getWall();
	$wall->url = $urlName;
} else {
	if ((!$wall = $wallControl->getWallByUrlFriendlyName($urlName)) || !$wallControl->isMemberAuthorizedToEditWallBySecureId($wall->secureId)) {
		$application->displayErrorPage("Site/Root/error/404.php", 404);
	}
}
$formSubmitLabel = "save";
$tabIndex = 1;

$layout = CoreFactory::getLayout("Site/Template/Default/Main.php");
$layout->set("Title", "wall " . ($wallCreate ? "create" : "edit") . " / " . $application->registry->get("Title"));
$layout->set("Name", $application->registry->get("Title"));
$layout->set("Section", "wall-select");
$layout->start("Style");
?>
<link media="all" href="/resource/css/basic-form.css?v=@VERSION-NUMBER@" type="text/css" rel="stylesheet"/>
<?php
$layout->start("Main");
// The main page content goes here.
?>
	<div id="gawk-framework">
		<div id="wall-edit-view">
			<div id="title-area">
				<div class="breadcrumb">
<?php
if ($wallCreate) {
?>
					<a href="/">home</a> / <a title="create wall" href="/wall/">wall</a> /
						create
<?php
} else {
?>
					<a href="/">home</a> / <a title="view wall" href="<?php echo $wall->url; ?>"><?php echo $wall->name; ?></a> /
						edit
<?php
}
?>
				</div>
			</div>
			<div class="view-container create-wall">
<?php
if ($wallCreate) {
?>
				<h1 class="page-title">create wall</h1>
				<p>From here you can create your own custom wall with it's own link that you can share to your friends, family
				and colleagues.</p>
				<p>Some reasons:</p>
				<ul>
					<li>custom URL</li>
					<li>public or invite only</li>
				</ul>
<?php
} else {
?>
				<h1 class="page-title">edit wall</h1>
				<p>make any changes to th wall here, and press save to continue</p>
<?php
}
?>
				<form method="post" action="" class="wall basic-form wide">
					<div class="form-errors" style="display:none;">
						<h3>errors</h3>
						<ul></ul>
					</div>
					<fieldset>
						<label>
							<strong class="required">wall name</strong>
							<input type="text" name="Name" class="textbox" tabindex="<?php echo $tabIndex++; ?>"
								value="<?php echo $wall->name; ?>"/><br />
							<span class="note">e.g. Friends of Gawkwall, John's Family, Kettle Fish</span>
						</label>
						<label>
							<strong class="required">url</strong>
							<?php echo $application->registry->get("Site/Address"); ?>/<input type="text" name="UrlFriendly"
								class="textbox" tabindex="<?php echo $tabIndex++; ?>" value="<?php echo $wall->url; ?>"/><br />
							<span class="note">e.g. gawkwall-friends, johns-family, kettle-fish</span>
						</label>
						<label>
							<strong class="required">description</strong>
							<textarea id="summary" name="Description" cols="40" rows="7" class="textbox wide"
								tabindex="<?php echo $tabIndex++; ?>"><?php echo $wall->description; ?></textarea>
						</label>
						<label class="checkbox">
							<strong>publicness</strong>
							<select name="Public" tabindex="<?php echo $tabIndex++; ?>">
								<option>Public</option>
								<option>Anyone can view it, only friends can Gawk on it</option>
								<option>Private only to friends</option>
							</select><br />
							<span class="note">(You can change this at any time)</span>
						</label>
						<div class="controls">
							<input type="hidden" name="SecureId" value="<?php echo $wall->secureId; ?>"/>
							<a href="#" onclick="$(this).parents('form').submit();" class="submit" title="submit the form">
								<span><?php echo $formSubmitLabel; ?></span>
							</a>
							<input type="hidden" name="Submit" value="<?php echo $formSubmitLabel; ?>"/>
<?php
if (!$wallCreate) {
?>
							<input name="Delete" type="button" tabindex="<?php echo $tabIndex++; ?>" class="button" value="delete wall"
								accesskey="d" title="delete this wall" />
<?php
}
?>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
<?php
$layout->start("JavaScript");
?>
	<script type="text/javascript" src="/resource/js/application/gawk/wall/wall-control.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/member/member-recent-walls-control.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/member/member-wall-bookmark-control.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/login-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/wall-select-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript" src="/resource/js/application/gawk/views/wall-edit-view.js?v=@VERSION-NUMBER@"></script>
	<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	var gawk = new Gawk({
		initView: "WallEdit",
		apiLocation: "<?php echo $application->registry->get("Site/Address"); ?>/api/",
		fbAppId: "<?php echo $facebook->getAppId(); ?>",
		fbSession: <?php echo json_encode($facebook->getSession()); ?>
	});
});
	</script>
<?php
$layout->render();