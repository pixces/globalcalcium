<?php
/**
* basic bootstraping
*/
require_once("config.inc.php");

if ($_POST){

	#create a mail to be sent
	$mailMsg = "A new sample has been requested. The details are as following\n\n";
	$mailMsg .= "Name:\n";
	$mailMsg .= $_POST['name']."\n\n";
	$mailMsg .= "Organization:\n";
	$mailMsg .= $_POST['organisation']."\n\n";
	$mailMsg .= "Email Address:\n";
	$mailMsg .= $_POST['email']."\n\n";
	$mailMsg .= "Postal Address\n";
	$mailMsg .= $_POST['address']."\n\n";
	$mailMsg .= "Phone No.\n";
	$mailMsg .= $_POST['phone']."\n\n";
	$mailMsg .= "Fax No.\n";	
	$mailMsg .= $_POST['fax']."\n\n";
	$mailMsg .= "Tell us details of sample requried:\n";
	$mailMsg .= $_POST['details']."\n\n";	
	
	/* sending simple php email */
	$subject  = "[Global Calcium] New Sample form Submitted";
	$to = "info@globalcalcium.com";
	$from = "samples@globalcalciumpharma.com ";
	$headers = "From:" . $from;
	
	mail($to,$subject,$mailMsg,$headers);
	echo "Mail Sent.";
	
	/*
	#initalize php mailer and send email	
	$mail = new PHPMailer(true);
	$mail->IsSMTP(); // telling the class to use SMTP
	
	try {
	  $mail->Host       = "mail.globalcalcium.com"; // SMTP server
	  $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
	  $mail->SMTPAuth   = true;                  // enable SMTP authentication
	  $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	  $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	  $mail->Username   = "yourusername@gmail.com";  // GMAIL username
	  $mail->Password   = "yourpassword";            // GMAIL password
	  $mail->AddReplyTo('info@globalcalcium.com', 'Global Calcium');
	  $mail->AddAddress('pixces@gmail.com', 'Zainul');
	  $mail->SetFrom('info@globalcalcium.com', 'Global Calcium');
	  $mail->AddReplyTo('info@globalcalcium.com', 'Global Calcium');
	  $mail->Subject  = "[Global Calcium] New Sample form Submitted";
	  //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
	  $mail->MsgHTML($mailMsg);
	  $mail->Send();
	  echo "Message Sent OK</p>\n";
	} catch (phpmailerException $e) {
	  echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  echo $e->getMessage(); //Boring error messages from anything else!
	}	
	*/
	
}

$sidebar = "home-sidebar.html";
$content = "sample_form.html";
require_once("loadTemplate.php");
?>