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
if(!isset($_GET['token']))echo 'No given token';
else {
	require(__DIR__."/function/facebook-php-sdk-v4/src/Facebook/autoload.php");
	require(__DIR__."/function/SQL-function/sql.php");
	require(__DIR__."/function/fblogin.php");
	require(__DIR__."/config/config.php");
	$data = checklogin();
	if(!$data){
		echo 'Not Login';
	} else {
		$fbid = $data['id'];
		$fbname = $data['name'];
		$token = urldecode($_GET['token']);

		$query = new query;
		$query->dbname = $config['database']['dbname'];
		$query->table = $config['database']['table'];
		$query->where = array(
		    array('token',$token)
		);
		$row = fetchone(SELECT($query));
		if(!$row){
			echo 'Not found token';
		} else if($row['fbid'] !== $fbid){
			echo 'Not Your Identity Verification';
		} else {
			$query = new query;
			$query->dbname = $config['database']['dbname'];
			$query->table = $config['database']['table'];
			$query->where = array(
			    array('token',$token)
			);
			DELETE($query);

			echo 'Delete '.$fbname."'s Identity Verification<br>token=".$token;
		}
	}
}
?>
</center>
</body>
</html>