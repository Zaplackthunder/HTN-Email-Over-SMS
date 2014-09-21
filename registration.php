<?php

	require_once 'vendor/autoload.php';

	$domain = $_SERVER['HTTP_HOST'];

	/************************************************
	  ATTENTION: Fill in these values!
	 ************************************************/
	 $client_id = '144543803350-sbqtalh9g4m8pmpqc3k6dhvaa09vkhb3.apps.googleusercontent.com';
	 $client_secret = 'PIDEfDLhtvzFi3_GHLUI0EF1';
	 $redirect_uri = 'http://' . $domain . '/HTN-Email-Over-SMS/thankyou.php';

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
		<link href="http://bootswatch.com/yeti/bootstrap.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
	</head>
	<body>
		<div class="bg">
			<div class="centered-bg">
				<h2>Get & Send emails via your SMS Inbox without Wifi</h2>
				<form class='big-form' action="registration.php" method="post">
					<label class='text-muted big-label'>Phone Number</label>
					<div class="phone-num-section">
						<input class='big-input' type="text" name="phonenumber" placeholder='e.g. 6479995099'>			
					</div>
					<label class='text-muted big-label'>Email Address</label>
					<div class="phone-num-section">
						<input class='big-input' type="text" name="email_address" placeholder='e.g. mygmail@gmail.com'>			
					</div>
					<div class="submit-section">
						<input class='btn btn-primary big-button' type="submit" value="Connect to Gmail"></input>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>


<?php

	if ( isset($_POST['phonenumber']) and isset($_POST['email_address']) ) {
		$_SESSION['phonenumber'] = $_POST['phonenumber'];
		$_SESSION['email_address'] = $_POST['email_address'];
		header("Location: " . $authUrl);
	}
?>