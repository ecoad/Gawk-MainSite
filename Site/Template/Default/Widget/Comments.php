<?php
$commentControl = BaseFactory::getCommentControl();


$blogEntryControl = Factory::getBlogEntryControl();
$blogControl = Factory::getBlogControl();

if (!$blog = $blogControl->item($_GET["BlogId"])) {
	$application->gotoLastPage();
}

if (!$blogEntry = $blogEntryControl->item($_GET["Id"])) {
	$application->gotoLastPage();
}

switch($application->parseSubmit()) {
	case "Post Comment":
		if (isset($_POST["EmailAddress"])) {
			$application->securityControl->logon($_POST["EmailAddress"], $_POST["Password"]);
		}
		if (!$application->errorControl->hasErrors()) {
			$comment = $commentControl->map($_POST);
			if ($comment->get("Body") == "Enter your comment here") {
				$comment->set("Body", "");
			}
			$comment->set("RelationId", $relationId);
			$comment->set("RelationType", $relationType);
			$comment->save();
		}
		break;
	case "Delete Comment":
		$application->required($_REQUEST["CommentId"]);
		$commentControl->delete($_REQUEST["CommentId"]);
		break;
	case "Delete All Comment":
		$application->required($_REQUEST["CommentId"]);
		$commentControl->deleteAllCommentByAuthor($_REQUEST["CommentId"]);
		break;
	case "":
		break;
}

$commentControl->retrieveForType($relationType, $relationId);
?>
							<script type="text/javascript">
// <![CDATA[
Event.observe(window, "dom:loaded", function() {

	$("email-address") && new RumbleUI.Form.AutoClear("email-address", "E-mail Address");
	$("password") && new RumbleUI.Form.AutoClear("password", "Password");
	new RumbleUI.Form.AutoClear("comment-body", "Enter your comment here");

});

var comments = {

	confirmDelete: function() {
		return confirm("Are you sure you wish to delete this comment?");
	},

	confirmDeleteAllAuthorComments: function() {
		return confirm("Are you sure you wish to delete all comments by this author in this section?");
	}

}
// ]]>
							</script>
							<div id="comments" class="stand-out">
								<h3><span>Comments</span></h3>
<?php
while ($comment = $commentControl->getNext()) {
?>
								<div class="comment">
<?php
	if ($comment->isMemberAllowedToModify()) {
?>
									<ul class="controls">
										<li><a onclick="return comments.confirmDelete();" href="?Id=<?php echo $blogEntry->get("Id"); ?>&amp;BlogId=<?php echo $blog->get("Id"); ?>&amp;Submit=Delete%20Comment&amp;CommentId=<?php echo $comment->get("Id"); ?>#comments">Delete</a></li>
										<li><a onclick="return comments.confirmDeleteAllAuthorComments();" href="?Id=<?php echo $blogEntry->get("Id"); ?>&amp;BlogId=<?php echo $blog->get("Id"); ?>&amp;Submit=Delete%20All%20Comment&amp;CommentId=<?php echo $comment->get("Id"); ?>#comments">Delete all comments by this user</a></li>
									</ul>
<?php
	}
?>
									<h4><?php echo $comment->getAuthor(); ?></h4>

									<p class="date"><?php echo $comment->getFormatted("DateCreated"); ?></p>
									<p><?php echo $comment->getFormatted("Body"); ?></p>
								</div>
<?php
}
?>
<?php
if ($application->errorControl->hasErrors()) {
?>
								<div class="form-errors">
									<h4>There was a problem with your form.</h4>
									<p>Please check the following, then try again.</p>
									<ul>
										<?php echo $htmlControl->makeList($application->errorControl->getErrors()); ?>
									</ul>
								</div>
<?php
}
?>
								<form id="post-comment" action="#post-comment" method="post" >
									<fieldset>
<?php
if ($application->securityControl->isLoggedOn()) {
?>
<?php
} else {
?>
										<label class="adjacent">
											<strong class="required">E-mail Address: <span>*</span></strong>
											<input id="email-address" name="EmailAddress" type="text" class="textbox medium"
												value="E-mail Address"
												maxlength="255" />
										</label><br />
										<label class="adjacent">
											<strong class="required">Password: <span>*</span></strong>
											<input id="password" name="Password" type="text" class="textbox medium"
												value="Password"
												maxlength="255" />
										</label><br /><p class="adjacent"><a href="/membership/">Not Registered Yet?</a></p>

<?php
}
?>
										<label>
											<strong class="required">Enter your comment: <span>*</span></strong>
											<textarea id="comment-body" name="Body" cols="40" rows="6" class="textbox max tall">Enter your comment here</textarea>
										</label>
										<label>
											<strong class="left">Post as anonymous?</strong><input name="Anonymous" type="checkbox" value="t" class="checkbox" />
										</label>
									</fieldset>
									<div class="controls">
										<input type="hidden" name="Submit" value="Submit" />
										<input name="Submit" type="submit" class="button" value="Post Comment" />
									</div>
								</form>
							</div>