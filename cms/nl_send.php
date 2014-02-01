<?php
/**
* sends the newsletter to subscribers
* Message Id
* List of all Subscribers
* send limit
* type of letter
*/
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}

//check for loggedIn 
isLoggedIn();

//get the basic configurations
$config = getConfiguration();

//the message id as refered to as nl_id as in Newseletter Id
$nl_id = (!empty($_GET['msg_id'])) ? $_GET['msg_id'] : "";


//required option -> Blank & Send
$op = (!empty($_GET['op'])) ? $_GET['op'] : '';

//set the begining of the emails retrival in the database
$begin = (!empty($_GET['begin'])) ? $_GET['begin'] : 0;

//total count of email address in the system
$sn = (!empty($_GET['sn'])) ? $_GET['sn'] : '';

//error status
$error = (!empty($_GET['error'])) ? $_GET['error'] : '';

if (!$op)
	{
	//mark this message as send in the databse
	//then self redirect with parameters to send the newsletter in loop
	$newsletter = new Newsletter($nl_id);
	
	//add newsletter sent record
	$newsletter->nl_mark_sent();

	//get subscribers count
	$num = $newsletter->nl_subscriber_count();
	if($num == 0){
		$_SESSION['error'] = "There are no email address to send newsletter.";
		header("location: newsletter.php");
		return false;
	}
	// open log file
	$dontlog = 0;
   	if ( !$handler = @fopen('./logs/'.date("Ymd").'-msg'.$nl_id.'.log', 'a+') )
	
    $dontlog = 1;
	//open a log file to note down the progress
	$errstr = "=======================================================================================================\r\n";
	$errstr.= date("d M Y")."\r\n";
	$errstr.= "Started at ".date("H:i:s")."\r\n";
	$errstr.= "N° \t\t Recipient \t\t\t Status \r\n";	
	$errstr.= "-------------------------------------------------------------------------------------------------------\r\n";
	if(!$dontlog) fwrite($handler, $errstr, strlen($errstr));
	if(!$dontlog) fclose($handler);   	
   	header("location:nl_send.php?op=send&begin=0&msg_id=$nl_id&sn=$num&error=0");
	}
	
if ($op == 'send')
	{
	
		// open log file and write to it
		$dontlog = 0;
		if ( !$handler = @fopen('./logs/'.date("Ymd").'-msg'.$nl_id.'.log', 'a+'))
		$dontlog = 1;
		
		//check for the config parameters
		//and setup the PHPMailer with it
		$limit = $config['send_limit'];

		$mail = new PHPMailer();
		$mail->CharSet= $config['charset'];
		$mail->PluginDir= "classes/";
 

		//check for the sending method
		//and configure the mailer
		$sending_method = $config['send_method'];

		switch($sending_method){
				case "smtp":
					$mail->IsSMTP();	
					$mail->Host =  $config['smtp_host'];
				 	if( $config['smpt_auth'] )
						{
							$mail->SMTPAuth = $config['smpt_auth'];
							$mail->Username = $config['smtp_user'];
							$mail->Password = $config['smtp_pass'];
						}
 				break;
				
				case "php_mail":
					$mail->IsMail();
				break;
				
				case "online_mail":
					$mail->IsOnlineEMail();
				break;
 				default:
				break;
 		}
 		
		//initialize the newseletter class
		//get the newseletter data
		//for a particular message id
		$newsletter = new Newsletter($nl_id);
		$msg = $newsletter->newsletter_details();
		
		$mail->From = stripslashes($msg->from_addr);
		$mail->FromName = $msg->from_name;
		
		$format = $config['mail_format'];
		
		$subject = "[WENXT Newsletter] ".stripslashes($msg->subject);
		$message = urldecode($msg->message);
	
		//get the email address of the recepients
		$newsletter->get_address($begin,$limit);
		$addr = $newsletter->emailList;
		
		//add newsletter template
		//to wrap the message
		$msg_body = file_get_contents("HTML/nl_template.tpl");
		$msg_body = str_replace("{##MSG_BODY##}",$message,$msg_body);
	
		
		if($format == "html") 
		 	{
		 	$unsub = "<b>Click here to unsubscribe newsletters</b>\r\n";
			$mail->IsHTML(true);  //send as HTML
			}
		// $mail->WordWrap = 50;    
		
		 for ($i=0; $i<count($addr) ; $i++)
		 {
			$unsubLink = "";
			$mail->to = array();
			$mail->AddAddress($addr[$i]);
			
			if ($format=="html")
				{
				$unsubLink .= "<a style=\"color:#FFF; text-decoration:none \" href=\"".$config['base_url'].$config['path']."subscription.php?op=unsubscribe&email_addr=".urlencode($addr[$i])."\" alt=\"Unsubscribe Newsletter\">";
				$unsubLink .= $unsub;
				//$unsubLink .= $config['base_url'].$config['path']."/subscription.php?op=leave&email_addr=".urlencode($addr[$i]);
				$unsubLink .="</a>";
				}
				
		  $body = "";
		   
		   if ($format == "html")
		   		{ 
		   		$body.= str_replace("{##UNSUBSCRIBE##}",$unsubLink,$msg_body);				 
				}
		   $subj = $subject;
		   //$body .= $body;	
		   //$body;
		   	   
		   $mail->Subject = $subj;
		   $mail->Body = $body;		 
		   
		   @set_time_limit(150); 
		   
		   if(!$mail->Send()){
		   		$errstr = ($begin+$i+1)."\t".date("H:i:s")." \t".$addr[$i]."\t".$mail->ErrorInfo."\r\n";	
		   		}else {
			 		$errstr = ($begin+$i+1)."\t".date("H:i:s")." \t".$addr[$i]."\t OK \r\n";
					}
		   if(!$dontlog) fwrite($handler, $errstr, strlen($errstr));
		 } 
	
		 $begin+=$limit;
		 
		 if($begin<$sn)
		 	{
				header("location:nl_send.php?op=send&begin=$begin&msg_id=$nl_id&sn=$sn&error=$error");
		 	} else {
				$errstr = "-------------------------------------------------------------------------------------------------------\r\n";
				$errstr.= "Finished at ".date("H:i:s")."\r\n";
				$errstr .= "=======================================================================================================\r\n";
				if(!$dontlog) fwrite($handler, $errstr, strlen($errstr));
				if(!$dontlog) fclose($handler);
			
			   	$_SESSION['message'] = "The newsletter has been successfully sent to all the subscribers.";
				header("location: newsletter.php");
		 		
				}	
	}
?>