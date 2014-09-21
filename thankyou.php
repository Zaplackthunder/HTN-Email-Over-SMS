<?php

require_once 'saveToDB.php';


$domain = "localhost";

if ( !isset($_SESSION) ) {
	session_start();
}

function getData() {
	if ( isset($_REQUEST['code']) ) {
		global $domain;
		$url = "https://accounts.google.com/o/oauth2/token";
		$ch = curl_init();
		$post_data = array(
			"code" => $_REQUEST['code'],
			"client_id" => "144543803350-sbqtalh9g4m8pmpqc3k6dhvaa09vkhb3.apps.googleusercontent.com",
			"client_secret" => "PIDEfDLhtvzFi3_GHLUI0EF1",
			"redirect_uri" => "http://" . $domain . "/HTN-Email-Over-SMS/thankyou.php",
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
		$result['phone_number'] = $_SESSION['phonenumber'];
		$result['email_address'] = $_SESSION['email_address'];
		return $result;
	}
	return false;
}

$dataArray = getData();
if ($dataArray) {
	toDB($dataArray);
} else {
	echo "I failed";
}


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
