<?php
include("conn.php");
$query = " SELECT *,A.id app_id FROM tbl_appointments A LEFT JOIN tbl_timeslots T ON A.time_slot_start=T.id where TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),NOW()) < 0 AND TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),NOW()) > -15 ";

echo "call";
require '/home/vettreefiles/public_html/classes/twilio-twilio-php-ba6dbca/Services/Twilio.php';
require '/home/vettreefiles/public_html/classes/sMail.php';

echo "<pre>";

$account_sid = "ACb357e6391b5ad050d388ed81eb8294ff"; // Your Twilio account sid
		$auth_token = "f3f2ddaba164e9877d782434da153018"; // Your Twilio auth token
		$message = '';
		$mail_sent = '';
		
		echo  "now";
		    // Step 3: instantiate a new Twilio Rest Client
    $client = new Services_Twilio($account_sid, $auth_token);
 
    // Step 4: make an array of people we know, to send them a message. 
    // Feel free to change/add your own phone number and name here.
    $people = array(
        "+16478983194" => "Curious George"
    );
 
	echo  "now 2";
    // Step 5: Loop over all our friends. $number is a phone number above, and 
    // $name is the name next to it
	try
		{
    foreach ($people as $number => $name) {
		echo  "now foreach";
        $sms = $client->account->messages->sendMessage(
 
        // Step 6: Change the 'From' number below to be a valid Twilio number 
        // that you've purchased, or the (deprecated) Sandbox number
            "201-429-7481",
 
            // the number we are sending to - Any phone number
            $number,
 
            // the sms body
            "Hey $name, Appointment at 6PM. Bring Bananas!"
        );
 
        // Display a confirmation message on the screen
        echo "Sent message to $name";
    }
	} catch (Exception $e) {
			echo $e->getMessage();
		}
?>