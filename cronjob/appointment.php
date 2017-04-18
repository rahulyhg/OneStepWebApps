<?php
include("conn.php");
//$query = " SELECT *,A.id app_id FROM tbl_appointments A LEFT JOIN tbl_timeslots T ON A.time_slot_start=T.id where TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),NOW()) < 0 AND TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),NOW()) > -15 AND A.mail_sent!=1";
$query = " SELECT *,A.id app_id FROM tbl_appointments A LEFT JOIN tbl_timeslots T ON A.time_slot_start=T.id where TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),CONVERT_TZ(NOW(),'+00:00','-05:00')) < 0 AND TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),CONVERT_TZ(NOW(),'+00:00','-05:00')) > -15 AND A.mail_sent!=1";


require '/home/vettreefiles/public_html/classes/twilio-twilio-php-ba6dbca/Services/Twilio.php';
require '/home/vettreefiles/public_html/classes/sMail.php';

echo "<pre>";

if($result = $mysqli->query($query)){
        //echo mysqli_num_rows($result);
	while($row = $result->fetch_assoc()){
		//process your transaction
		
		$seller_data_obj = $mysqli->query("SELECT * FROM tbl_user_master where id = ".$row['doctor_id']);
		$seller_data = $seller_data_obj->fetch_object();
		
		$seller_data_obj1 = $mysqli->query("SELECT * FROM tbl_user_master where id = ".$row['patient_id']);
		$seller_data1 = $seller_data_obj1->fetch_object();
		// Download the library and copy into the folder containing this file.
		$account_sid = "ACb357e6391b5ad050d388ed81eb8294ff"; // Your Twilio account sid
		$auth_token = "f3f2ddaba164e9877d782434da153018"; // Your Twilio auth token
		$twilio_number= "201-429-7481";
		$message = '';
		$mail_sent = '';
		$message_sent = '';
		 $client = new Services_Twilio($account_sid, $auth_token);
		 $people = array(
			"+1".$seller_data->phone_no => $seller_data->first_name." ".$seller_data->last_name,
			"+1".$seller_data1->phone_no => $seller_data1->first_name." ".$seller_data1->last_name
		);
		
		try
		{
			foreach ($people as $number => $name) {
				$sms = $client->account->messages->sendMessage(
					$twilio_number,
					$number,
					"Hey ".$name.", don’t forget you have an appointment at ".$row['date']." ".$row['times']
				);
				$message_sent .= "Sent message to $name";
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		try
		{
			$sql12 = "UPDATE tbl_appointments SET mail_sent='1',user_not='1',doc_not='1' WHERE id=".$row['app_id'];
			$r2 = $mysqli->query($sql12);
			
			$msg = "Hello ".$seller_data->first_name." ".$seller_data->last_name.",<br/><br/>Please Check your Appointment is starting on the ".$row['date']." ".$row['times'];
			$mail_sent = sMail($seller_data->email,$seller_data->first_name." ".$seller_data->last_name, "Appointment Reminder", $msg);
	
			$msg = "Hello ".$seller_data1->first_name." ".$seller_data1->last_name.",<br/><br/>Please Check your Appointment is starting on the ".$row['date']." ".$row['times'];
			$mail_sent = sMail($seller_data1->email,$seller_data1->first_name." ".$seller_data1->last_name, "Appointment Reminder", $msg);
		} catch (Exception $e) {
			echo $e->getMessage();
		}	

		$sql13 = "INSERT INTO tbl_app_logs (id, app_id, mail_sent, sms_sent) VALUES (NULL, ".$row['app_id'].", '".$mail_sent."', '".$message_sent."')";
		$r3 = $mysqli->query($sql13);
	}
}

$query1 = "SELECT *,A.id app_id FROM tbl_appointments A LEFT JOIN tbl_timeslots T ON A.time_slot_start=T.id where (TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),CONVERT_TZ(NOW(),'+00:00','-05:00')) > 0 OR TIMESTAMPDIFF(MINUTE,STR_TO_DATE(CONCAT(A.date,' ',T.times), '%m/%d/%Y %h:%i %p'),CONVERT_TZ(NOW(),'+00:00','-05:00')) < -15) AND ( A.user_not=1 or A.doc_not=1)";
if($result1 = $mysqli->query($query1)){
	while($row1 = $result1->fetch_assoc()){
		$sql121 = "UPDATE tbl_appointments SET user_not='0',doc_not='0' WHERE id=".$row1['app_id'];
		$r21 = $mysqli->query($sql121);
	}
}
?>