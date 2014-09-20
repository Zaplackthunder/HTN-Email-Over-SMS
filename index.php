<?xml version="1.0" encoding="UTF-8" ?>
<Response>
	<?php
		//some functions that don't do anything yet
		function check_unread($email, $AccessToken){
			echo "<Message>";
			echo "Your email is".$email;
			echo "1-MessageA, 2-MessageB,etc";
			echo "</Message>";
		}
		function send($phonenum, $to, $subject, $body){
		}
		function open($phonenum, $msgnum){
			echo "From: ";
			echo "Subject: ";
			echo "Body: ";
		}
		///////////
				
		//Connection to DB
		$con=mysqli_connect("localhost","root","1234","my_db");
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		//Retrieving information from text
		$phonenum=$_GET["From"];
			//echo "<Message> Your phone number is:";
			//echo $phonenum;
			//echo "</Message>";
		$input=$_GET["Body"];
		//Clean it up
		$phonenum=strtolower($phonenum);
		$input=rtrim($input);
		$input=strtolower($input);
		
		//Finding the texter in the database
		$db_result=mysqli_query($con, "SELECT * FROM MailList WHERE Phone=$phonenum");

		//If they are not in the database...
		if($db_result==false){
			echo "<Message> Please register your phone number online at geoffhack.ddns.net/registration.</Message>";

		//If they ARE in the database
		}else{
			//Load all profile values from database.
			$firstrow=mysqli_fetch_assoc($db_result);
			$email=$firstrow['Mail'];
			$password=$firstrow['Password'];
			$token=$firstrow['AccessToken'];
			//$menu_status=$firstrow['MenuStatus'];
			//$recipient=$firstrow['Recipient'];
			//$subject=$firstrow['Subject'];
			//$body=$firstrow['MailBody'];
			check_unread($email,$token);
			//Menu System
			/*
			switch($menu_status){
				
				case 1:
					//Check recipient is valid email address
					mysqli_query($con,"UPDATE MailList SET MenuStatus=2, Recipient=$input WHERE Phone='$phonenum' AND Mail='$email'"); 
				break;
				case 2:
					//Add Subject to DB
					mysqli_query($con,"UPDATE MailList SET MenuStatus=3, Subject=$input WHERE Phone='$phonenum' AND Mail='$email'"); 
				break;
				case 3:
					//Add Body to DB
					mysqli_query($con,"UPDATE MailList SET MenuStatus=0, MailBody=$input WHERE Phone='$phonenum' AND Mail='$email'");
					$body=$input;
					send($phonenum, $recipient, $subject, $body);
				break;
				case 4:
				
				default:
					if($input=="check"){
						echo "<Message>";
						check_unread($phonenum);
						echo "</Message>";
					}else if($input=="send"){
						echo "<Message>";
						echo "Please enter the recipient's email";
						echo "</Message>";
						mysqli_query($con,"UPDATE MailList SET MenuStatus=1 WHERE Phone='$phonenum' AND Mail='$email'"); 
					}else if($input=="open"){
						echo "<Message>";
						open($phonenum, $msgnum);
						echo "</Message>";
					}else{
						echo "<Message>";
						echo "Please enter one of the following commands: check, send, open.";
						echo "</Message>";
					}
				break;

			}
			*/
		}

		
	?>


</Response>
