<?php
 
 session_start();
 echo "success";
 echo "<pre>";
 print_r($_POST);
 print_r($_SESSION);
 print_r($_GET);

 require "autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
define('CONSUMER_KEY',"BfQmcJCnIjnOqDxGgSOanObmm");
define('CONSUMER_SECRET','BbUD2Kxvr1sQ3SBtr7l15hyLpATcD6NcC47yB83W71z7msU9iO');
$access_token="4749213192-shAreiWSRWfHEKg0SEYHZCSGaM0QYr0AbhfyKy8";
$access_token_secret="6EdEwbYNKdWP7rCS3ouhdD7nOrLJrx8yuQx0WjmaaqJAo";
define("OAUTH_CALLBACK","http://www.teashirt.in/ds/success.php");


 $connection = new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET,$access_token,$access_token_secret);
 
// print_r($connection);
 $oautharray=array("oauth_verifier"=>$oauth_verifier);
 //echo "B";
 //print_r($oautharray);
// $token = $connection->oauth('oauth/access_token',['oauth_verifier' => "$oauth_verifier"]);
print_r($token);
	echo "C";

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);

$user = $twitter->get('account/verify_credentials');
// if something's wrong, go and log in again
if(isset($user->error)) {
    header('Location: ' . $config['url_login']);
}
// post a tweet
/*$status = $twitter->post(
    "statuses/update", [
        "status" => "Jai Mahakaal"
    ]
);*/
//echo ('Created new status with #' . $status->id . PHP_EOL);
//print_r($status);

 $result = $twitter->get("statuses/user_timeline", array());
 //Retrieves Tweets
 
// print_r($result);
// 	[oauth_token] => YWPAywAAAAAA8U3pAAABZWbyFHo
//    [oauth_verifier] => 5rcR1IA0LLRPbQlfbVyb98YpUoFkcudZ
  $count=0;
  foreach($result as $key=>$value)
  {

  	while(( $count++ ) >=10)
  		{break;}
  	
  	echo $key."Array begins"."<br>";
  	
  	echo $value->text."count : "."$count";
  	
  }//Display Tweets


  $resultfollower= $twitter->get("followers/list", array());

  $count=0;
  foreach ($resultfollower as $key => $value) {
  	# code...
  	
  	foreach($value as $key2 =>$value2)
  	{

  	if(( $count++ )>=10)
  		{break;}

     //	print_r($value2);
  	echo "<br><br><br>"."username : ".$value2->screen_name;
    echo $count;
    }
}


?>