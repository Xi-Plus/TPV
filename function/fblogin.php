<?php
function checklogin(){
	session_start();
	if(isset($_SESSION['fb_access_token'])){
		require_once(__DIR__."/facebook-php-sdk-v4/src/Facebook/autoload.php");
		require(__DIR__."/../config/config.php");
		$fb = new Facebook\Facebook([
			'app_id' => $config['facebook']['app_id'],
			'app_secret' => $config['facebook']['app_secret'],
			'default_graph_version' => 'v2.5',
			]);
		try {
			$response = $fb->get('/me',$_SESSION['fb_access_token'])->getDecodedBody();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// echo 'Graph returned an error: ' . $e->getMessage();
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// echo 'Facebook SDK returned an error: ' . $e->getMessage();
		}
		return $response;
	} else {
		return false;
	}
}
?>