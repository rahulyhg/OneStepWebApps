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

function sMail($to, $toname, $sub, $msg) {
	try {
	
		require 'PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.mailgun.org';                     // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'postmaster@sandboxee1f916dfeec44559bb45f46adac0e8f.mailgun.org';   // SMTP username
		$mail->Password = 'ff312f6d889243bc9fc72af2dbc605d1';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted

		$mail->From = 'YOU@sandboxee1f916dfeec44559bb45f46adac0e8f.com';
		$mail->FromName = 'Mailer';
		$mail->addAddress('dvs_gajjar3127@yahoo.com');                 // Add a recipient

		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters

		$mail->Subject = 'Hello';
		$mail->Body    = 'Testing some Mailgun awesomness';

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
		return true;
	} catch (phpmailerException $e) {
		return false;
	}
}
sMail("dvs_gajjar3127@yahoo.com","Divs", "Check 123", "Test Mail 123 456 456");
?>