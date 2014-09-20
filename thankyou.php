<?php

require_once 'saveToDB.php';

if ( !isset($_SESSION) ) {
	session_start();
}

function getData() {
	if ( isset($_REQUEST['code']) ) {
		$url = "https://accounts.google.com/o/oauth2/token";
		$ch = curl_init();
		$post_data = array(
			"code" => $_REQUEST['code'],
			"client_id" => "1088708870228-e23b8avbg0v1dfc20b44ltmsksm2048m.apps.googleusercontent.com",
			"client_secret" => "peH484fr-FyGhisJodNLLqz3",
			"redirect_uri" => "http://" . $_SERVER['HTTP_HOST'] . "/HTN-Email-Over-SMS/thankyou.php",
			"grant_type" => "authorization_code"
		);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$stringResult = curl_exec($ch);
		$result = json_decode($stringResult, true);
		$result['phonenumber'] = $_SESSION['phonenumber'];
		return $result;
	}
	return false;
}

toDB(getData());
?>
<html>
	<head>
		<link href="http://bootswatch.com/yeti/bootstrap.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
	</head>
	<body>
		<div class="bg">
			<div class="centered-bg">
				<h2>Thanks for trying it out!</h2>
			</div>
		</div>
	</body>
</html>
