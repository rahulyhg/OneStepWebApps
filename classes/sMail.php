<?php
/*require 'PHPMailer/PHPMailerAutoload.php';

function sMail($to, $toname, $sub, $msg) {
	try {
		$mail = new PHPMailer;

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mailer->SMTPSecure = 'ssl';
		$mailer->Host = 'smtp.gmail.com';
		$mailer->Port = 465;
		$mailer->SMTPAuth = true;
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		//$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		//$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = stripslashes("joesmithphp@gmail.com");                 // SMTP username
		$mail->Password = stripslashes("maruti@php");                           // SMTP password
		//$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		//$mail->Port = 465;                                    // TCP port to connect to
		//$mail->FromName   = stripslashes("admin@vettreefiles.com");	
		
		$mail->AddAddress($to,$toname);     // Add a recipient
		$mail->addCC('divsinfotech@gmail.com');
		//$mail->addReplyTo('info@example.com', 'Information');
		/*$mail->addCC('cc@example.com');
		$mail->addBCC('bcc@example.com');*/
		/*
		$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		*/

/*		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $sub;
		$mail->Body    = $msg;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";

		if(!$mail->send()) {
		   echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
		} else {
			echo "Success";
		   return true;
		}
	} catch (phpmailerException $e) {
		return false;
	}
}
*/
?>



<?php
require_once 'Mail/class.phpmailer.php';
require 'PHPMailer/PHPMailerAutoload.php';

/*function sMail($to, $toname, $sub, $msg) {
	try {
	
		

		$mail = new PHPMailer;

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.mailgun.org';                     // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'postmaster@sandboxee1f916dfeec44559bb45f46adac0e8f.mailgun.org';   // SMTP username
		$mail->Password = 'ff312f6d889243bc9fc72af2dbc605d1';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted

		$mail->FromName   = "admin@vettreefiles.com";	
		$mail->AddAddress($to);           // Add a recipient
		//$mail->AddReplyTo("admin@vettreefiles.com","Admin");
		//$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->IsHTML(true);
		
		$mail->Subject = $sub;
		$mail->Body    = $msg;

		if(!$mail->send()) {
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		return true;
	} catch (phpmailerException $e) {
		return false;
	}
}*/


function sMail($to, $toname, $sub, $msg) {
	try {
		$to = $to;
		$subject = $sub;
		$message = $msg;
		$header = "From:admin@divsinfotech.com \r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$retval = mail ($to,$subject,$message,$header);
		if( $retval == true )
		{			return true;
		}
		else
		{			return false;
		}
	} catch (phpmailerException $e) {
		return false;
	}
}

/*
function sMail($to, $toname, $sub, $msg) {
	try {
	
		$data = array('to'=>$to,
              'toname'=>$toname,
              'sub'=>$sub,
              'msg'=>$msg);
		
		$output = file_get_contents('http://www.iroid-apps.com/divs/testmail.php?'.http_build_query($data));
		/*
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
	
		$mail->IsSMTP();                           // tell the class to use SMTP
		$mailer->SMTPSecure = 'ssl';
		$mailer->Host = 'smtp.gmail.com';
		$mailer->Port = 465;
		$mailer->SMTPAuth = true;		
		$mail->Username   = stripslashes("joesmithphp@gmail.com");     // SMTP server username
		$mail->Password   = stripslashes("maruti@php");            // SMTP server password					
		$mail->AddReplyTo("admin@vettreefiles.com","Admin");
		$mail->FromName   = stripslashes("admin@vettreefiles.com");		
		$mail->AddAddress($to,$toname);
		
		//$mail->AddAddress('ankit@ithinksoft.com','Ankit');*/
		/*
		$mail->AddAddress($to1email,$to1name);
		if($to2name!=null && $to2email!=null)
			$mail->AddAddress($to2email,$to2name);
		$mail->AddCC($ccemail,$ccname);
		*/
		/*
		$mail->Subject  = $sub;
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		//$mail->WordWrap = 80; // set word wrap
		//$mail->MsgHTML(nl2br($msg));
		$mail->Body    = $msg;
		
		$mail->IsHTML(true); // send as HTML
	
		if(!$mail->send()) {
		  // echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
		} else {
			//echo "Success";
		   return true;
		}
		*/
	/*	return $output;
	} catch (phpmailerException $e) {
		return false;
	}
}*/

?>