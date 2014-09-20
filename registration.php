<?php

	require_once 'vendor/autoload.php';

	/************************************************
	  ATTENTION: Fill in these values!
	 ************************************************/
	 $client_id = '144543803350-sbqtalh9g4m8pmpqc3k6dhvaa09vkhb3.apps.googleusercontent.com';
	 $client_secret = 'PIDEfDLhtvzFi3_GHLUI0EF1';
	 $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/HTN-Email-Over-SMS/thankyou.php';

	/************************************************
	  Make an API request on behalf of a user. In
	  this case we need to have a valid OAuth 2.0
	  token for the user, so we need to send them
	  through a login flow. To do this we need some
	  information from our API console project.
	 ************************************************/
	$client = new Google_Client();
	$client->setApplicationName("Hack The North - SMS Email");
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->setAccessType('offline');
	$client->addScope("https://www.googleapis.com/auth/gmail.readonly");
	$client->addScope("https://www.googleapis.com/auth/gmail.compose");

	$authUrl = $client->createAuthUrl();

	if ( !isset($_SESSION) ) {
		session_start();
	}

?>

<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h2>Please fill in your information</h2>
		<form action="registration.php" method="post">
			Phone Number: <input type="text" name="phonenumber"><br>
			<input type="submit" value="submit">Submit</input>
		</form>
	</body>
</html>


<?php


	if ( isset($_POST['phonenumber']) ) {
		$_SESSION['phonenumber'] = $_POST['phonenumber'];
		header("Location: " . $authUrl);
	}
?>