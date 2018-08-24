
<html>
<head>
</head>
<body>
<?php

require "autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY',"BfQmcJCnIjnOqDxGgSOanObmm");
define('CONSUMER_SECRET','BbUD2Kxvr1sQ3SBtr7l15hyLpATcD6NcC47yB83W71z7msU9iO');
$access_token="4749213192-shAreiWSRWfHEKg0SEYHZCSGaM0QYr0AbhfyKy8";
$access_token_secret="6EdEwbYNKdWP7rCS3ouhdD7nOrLJrx8yuQx0WjmaaqJAo";
define("OAUTH_CALLBACK","http://www.teashirt.in/ds/success.php");

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
//echo "A";
$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
//echo "B";
$content = $connection->get("account/verify_credentials");
//echo "C";
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
//echo "D";
$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
//echo "E";
//echo $url;



?>
<a href="<?php echo $url; ?>"><button>Click Me</button></a>
</body>
</html>
<?php
?>