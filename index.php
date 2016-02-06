<?php
session_start();
?>
<html>
<?php
if(isset($_GET["token"]))header("Location: verify.php?token=".$_GET["token"]);
require(__DIR__."/config/config.php");
?>
<head>
	<title>Third-Party Verification</title>
	<meta charset="UTF-8">
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<center>
<h2>Third-Party Verification</h2>
<hr>
<script>
  function statusChangeCallback(response) {
    if (response.status === 'connected') {
      document.getElementById('createbtn').disabled = '';
      loginaction();
      return true;
    } else if (response.status === 'not_authorized') {
      document.getElementById('status').innerHTML = 'Please log into this app.';
      return false;
    } else {
      document.getElementById('status').innerHTML = 'Please log into Facebook.';
      return false;
    }
  }

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      if(statusChangeCallback(response))document.location = 'login.php';
      else document.location = 'logout.php';
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '<?php echo $config['facebook']['app_id']; ?>',
    cookie     : true,
    xfbml      : true,
    version    : 'v2.5'
  });

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  function loginaction() {
    FB.api('/me', function(response) {
      document.getElementById('status').innerHTML = 'Login as ' + response.name + '.';
    });
  }

function logout(){
	FB.logout(function(response) {
	});
}
</script>

<div id="status"></div>
<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="true" onlogin="checkLoginState();"></div>
<br><br>
<form action="create.php" method="POST">
	<div class="g-recaptcha" data-sitekey="<?php echo $config['reCAPTCHA']['site_key']; ?>"></div>
	<input id="createbtn" type="submit" value="Create Your Identity Verification" disabled>
</form>
<hr>
<?php
	require(__DIR__.'/function/fblogin.php');
	if($data = checklogin()){
		?>
<table>
<tr><td>time</td><td>token</td><td>tool</td></tr>
		<?php
		require(__DIR__.'/function/SQL-function/sql.php');
		$query = new query;
		$query->dbname = 'xiplus';
		$query->table = 'tpv';
		$query->where = array(
			array('fbid',$data['id'])
		);
		$row = SELECT($query);
		foreach ($row as $temp) {
			echo '<tr><td>'.$temp['datetime'].'</td><td>'.$temp['token'].'</td><td></td></tr>';
		}
		?>
</table>
		<?php
	}
?>
</center>
</body>
</html>