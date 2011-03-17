<?php
require_once("Application/Bootstrap.php");

$friendAppUsers = array();

// We may or may not have this data based on a $_GET or $_COOKIE based session.
//
// If we get a session here, it means we found a correctly signed session using
// the Application Secret only Facebook and the Application know. We dont know
// if it is still valid until we make an API call using the session. A session
// can become invalid if it has already expired (should not be getting the
// session back in this case) or if the user logged out of Facebook.
$session = $application->facebook->getSession();

$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $application->facebook->getUser();
    $me = $application->facebook->api('/me');

    $memberFriendControl = Factory::getMemberFriendControl();
		$memberControl = Factory::getMemberControl();
		$member = $memberControl->getMemberByFbId($me["id"]);
		$memberFriendControl->syncFacebookFriends($member, $application->facebook);

    $friendAppUsers = $application->facebook->api(array('method' => 'friends.getappusers'));
  } catch (FacebookApiException $e) {
    error_log($e);
    $friendAppUsers = array();
  }
}

// login or logout url will be needed depending on current user state.
if ($me) {
  $logoutUrl = $application->facebook->getLogoutUrl();
} else {
  $loginUrl = $application->facebook->getLoginUrl();
}
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <!--
      We use the JS SDK to provide a richer user experience. For more info,
      look here: http://github.com/facebook/connect-js
    -->
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $application->facebook->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });

        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>


    <h1><a href="example.php">php-sdk</a></h1>

    <?php if ($me): ?>
    <a href="<?php echo $logoutUrl; ?>">
      <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
    </a>
    <?php else: ?>
    <div>
      Using JavaScript &amp; XFBML: <fb:login-button></fb:login-button>
    </div>
    <div>
      Without using JavaScript &amp; XFBML:
      <a href="<?php echo $loginUrl; ?>">
        <img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif">
      </a>
    </div>
    <?php endif ?>

    <h3>Session</h3>
    <?php if ($me): ?>
    <pre><?php print_r($session); ?></pre>

    <h3>You</h3>
    <img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
    <?php echo $me['name']; ?>

    <h3>Your User Object</h3>
    <pre><?php print_r($me); ?></pre>
    <?php else: ?>
    <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <h3>Friends of Gawk Wall</h3>
    <ul>
<?php
foreach ($friendAppUsers as $friendId) {
	$friendInfo = $application->facebook->api(
		array('method' => 'users.getinfo', 'uids' => $friendId,
		'fields' => 'first_name,last_name'));



	$name = $friendInfo[0]["first_name"] . " " . $friendInfo[0]["last_name"];
?>
			<li><?php echo $name; ?> <img src="https://graph.facebook.com/<?php echo $friendId; ?>/picture"></li>
<?php
}
?>
		</ul>
  </body>
</html>
