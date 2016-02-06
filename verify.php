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
	require("function/SQL-function/sql.php");
	require("config/config.php");
	$query = new query;
	$query->dbname = $config['database']['dbname'];
	$query->table = $config['database']['table'];
	$query->where = array(
	    array('token',$_GET["token"])
	);
	$row = fetchone(SELECT($query));
	if($row){
		echo 'ID: '.$row['fbid'].'<br>';
		echo 'Name: '.$row['fbname'].'<br>';
		echo 'Time: '.$row['datetime'].'<br>';
		echo '<a href="//www.facebook.com/'.$row['fbid'].'">Facebook Profile Page</a>';
	} else {
		echo 'Not found token';
	}
}
?>
</center>
</body>
</html>