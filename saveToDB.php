<?php
	function toDB($object){
		$con=mysqli_connect($_SERVER['HTTP_HOST'],"root","1234","my_db");
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$pnum=$object->$phone;
		$mailaddr=$object->$email;
		$accesstoken=$object->$accesstoken;
		$renewtoken=$object->$refreshtoken;
		$phpdate=date_create();
		$mysqldate = date( 'Y-m-d H:i:s', $phpdate );
		$sql = "INSERT INTO MailList (Phone, Mail, RefreshToken, AccessToken, LastUpdated) VALUES ('$pnum', '$mailaddr', '$renewtoken', '$accesstoken', '$mysqldate')";
		if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
		mysqli_close($con);
	}
?>