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
require(__DIR__."/config/config.php");
require(__DIR__."/function/cURL-HTTP-function/curl.php");
$response=cURL_HTTP_Request('https://www.google.com/recaptcha/api/siteverify',array('secret'=>$config['reCAPTCHA']['secret_key'],'response'=>$_POST['g-recaptcha-response']));
if(json_decode($response->html)->success){
	require(__DIR__."/function/facebook-php-sdk-v4/src/Facebook/autoload.php");
	require(__DIR__."/function/SQL-function/sql.php");
	require(__DIR__."/function/fblogin.php");
	if($response=checklogin()){
		$fbid = $response['id'];
		$fbname = $response['name'];
		$datetime = time();
		$token = substr(md5($fbid.$datetime.$config['hash']), 0, 8);

		$query = new query;
		$query->dbname = $config['database']['dbname'];
		$query->table = $config['database']['table'];
		$query->value = array(
		    array('fbid',$fbid),
		    array('fbname',$fbname),
		    array('datetime',date("Y-m-d H:i:s",$datetime)),
		    array('token',$token)
		);
		INSERT($query);

		$url = $config['url'].'?token='.$token;
		echo $fbname."'s Identity Verification<br>";
		echo '<a href="'.$url.'">'.$url.'</a>';
	} else {
		echo 'Not Login';
	}
} else {
	echo 'reCAPTCHA Fail';
}
?>
</center>
</body>
</html>