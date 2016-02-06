<?php
session_start();
?>
<html>
<head>
<title>Third-Party Verification</title>
<meta charset="UTF-8">
</head>
<body>
<center>
<h2>Third-Party Verification</h2>
<hr>
<a href="/">Home Page</a><br><br>
<?php
require(__DIR__."/function/facebook-php-sdk-v4/src/Facebook/autoload.php");
require(__DIR__."/config/config.php");
$fb = new Facebook\Facebook([
	'app_id' => $config['facebook']['app_id'],
	'app_secret' => $config['facebook']['app_secret'],
	'default_graph_version' => 'v2.5',
	]);

$helper = $fb->getJavaScriptHelper();

$success = true;
try {
	$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	$success=false;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	$success=false;
}
if ($success && ! isset($accessToken)) {
	echo 'No cookie set or no OAuth data could be obtained from cookie.';
	$success=false;
}

if ($success) {
	$_SESSION['fb_access_token'] = (string) $accessToken;
	echo "Login Success";
}
?>
</center>
</body>
</html>