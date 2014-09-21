<?php
// Install the library via PEAR or download the .zip file to your project folder.
// This line loads the library
require_once 'vendor/autoload.php';

$sid = "ACfc895e4f2319f69581a40658f514041d"; // Your Account SID from www.twilio.com/user/account
$token = "3b81ae4c392d069e98442f47d004d1d5"; // Your Auth Token from www.twilio.com/user/account
$twilio_phone_number = "6474962390";

$client = new Services_Twilio($sid, $token);


$from = $_GET['From'];
$body = $_GET['Body'];

function getMessage($user, $messageId) {
	$email = $user['Mail'];
	$access_token = $user['AccessToken'];
	//$firstMessageId = $messageArray['messages'][0]['id'];
	$url = "https://www.googleapis.com/gmail/v1/users/$email/messages/$messageId?access_token=$access_token";

	$crl = curl_init();
    curl_setopt($crl, CURLOPT_HTTPGET, true);
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    $stringResponse = curl_exec($crl);
    if ($stringResponse) {
    	$arrayResponse = json_decode($stringResponse, true);
    	return $arrayResponse;
    } else {
    	return false;
    }
}

function getNMessageList($user, $N) {
	$mail = $user['Mail'];
	$access_token = $user['AccessToken'];
	$url = "https://www.googleapis.com/gmail/v1/users/$mail/messages?access_token=$access_token&maxResults=$N";

	$crl = curl_init();
    curl_setopt($crl, CURLOPT_HTTPGET, true);
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    $stringResponse = curl_exec($crl);
    
    if ($stringResponse) {
    	$arrayResponse = json_decode($stringResponse, true);
    	return $arrayResponse;
    } else {
    	return false;
    }
}

function getUser($from) {
	$con = mysqli_connect($_SERVER['HTTP_HOST'], "root", "", "my_db");
	$query = "SELECT * FROM maillist WHERE phone='$from'";
	$matches = mysqli_query($con, $query);
	if ( $matches ) {
		$user = mysqli_fetch_assoc($matches);
		return $user;
	} else {
		return false;
	}
}

function getMessageHeaderField($message, $fieldName) {
	$headers = $message['payload']['headers'];
	for( $x = 0; $x < count($headers); $x++ ) {
		$name = $headers[$x]['name'];
		if ($name == $fieldName) return $headers[$x]['value'];
	}
	return false;
}

if ($body == 'GET') {
	$user = getUser($from);
	$messageList = getNMessageList($user, 5)['messages'];
	for ( $x=0; $x<5; $x++ ) {
		$messageId = $messageList[$x]['id'];
		$message = getMessage($user, $messageId);
		$subject = getMessageHeaderField($message, 'Subject');

		$message = $client->account->messages->sendMessage(
		  $twilio_phone_number, // From a valid Twilio number
		  $from, // Text this number
		  $subject
		);
	}

}

?>