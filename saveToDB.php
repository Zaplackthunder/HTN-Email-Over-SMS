<?php
	function toDB($object){
		$con=mysqli_connect($_SERVER['HTTP_HOST'], "HTN","1234","my_db");
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$pnum=$object['phone_number'];
		$mailaddr=$object['email_address'];
		$accesstoken=$object['access_token'];
		$renewtoken=$object['refresh_token'];
		$timestamp = date('Y-m-d G:i:s');
		$sql = "INSERT INTO MailList (Phone, Mail, RefreshToken, AccessToken, LastUpdated) VALUES ('$pnum', '$mailaddr', '$renewtoken', '$accesstoken', '$timestamp')
		/*ON DUPLICATE KEY UPDATE Phone = '$pnum' for maillists table*/";
		if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
		mysqli_close($con);
	}
?>