<?php
	$con=mysqli_connect("localhost","root","1234","my_db");
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$pnum=$_POST['phonenumber'];
	$mailaddr=$_POST['email'];
	$pword=$_POST['emailpassword'];
	
	$sql="INSERT INTO MailList (Phone, Mail, Password, MenuStatus) VALUES ('$pnum', '$mailaddr','$pword', 0)";
	if (!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error($con));
	}
	mysqli_close($con);
	?>
	