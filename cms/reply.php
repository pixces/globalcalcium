<?php

	if (file_exists("config.inc.php")){
		require_once("config.inc.php");
		} 
		else {
		die ("cannot initialize configuration");
	}

	//check for loggedIn 
	isLoggedIn();

	//get the list of all quote list
	$id = $_POST['quote_id'];
	$qtObj = new Quote($id);
	$qtDet = $qtObj->quote_details();
	
	//setting mail parameters and sending reply
	$to = $qtDet->cms_quote_email;
	$subject = "Query reply";
	$msg = $_POST['replyMessage'];
	$header = "From:preetha@tvcsp.com ";
		
	if (mail($to, $subject, $msg, $header)) {
		// If mail delivery success Update quote status into 1 (Mail Sent)
		$quoteSend = $qtObj->quote_reply(1);
		$_SESSION['message'] = "Reply message has been sent successfully";
		} 
		else {
		// If mail delivery fails Update quote status into 2 (Sending failed)
		$quoteSend = $qtObj->quote_reply(2);
		$_SESSION['error'] = "Message delivery failed...";
	}

	header("location:quote.php");
	exit; 
	
  ?>