<?php
include("conn.php");

$query = "SELECT *,date_sub(created_date, interval 1 month) FROM tbl_clinic_master where now() > date_add(created_date, interval 1 month) && status=1";

require '/home/vettreefiles/public_html/classes/twilio-twilio-php-ba6dbca/Services/Twilio.php';
require '/home/vettreefiles/public_html/classes/sMail.php';

echo "<pre>";

if($result = $mysqli->query($query)){
        //echo mysqli_num_rows($result);
	while($row = $result->fetch_assoc()){
		//process your transaction
		$user_clinic_data_obj = $mysqli->query("SELECT * FROM tbl_user_clinic_relation where role_id = 2 && clinic_id = ".$row['id']);
		$user_clinic_data = $user_clinic_data_obj->fetch_object();
		
		if($user_clinic_data->user_id>0)
		{
			$seller_data_obj = $mysqli->query("SELECT * FROM tbl_user_master where id = ".$user_clinic_data->user_id);
			$seller_data = $seller_data_obj->fetch_object();
			// Download the library and copy into the folder containing this file.
			$account_sid = "ACb357e6391b5ad050d388ed81eb8294ff"; // Your Twilio account sid
			$auth_token = "f3f2ddaba164e9877d782434da153018"; // Your Twilio auth token
			$message = '';
			$mail_sent = '';
			try
			{	
				$client = new Services_Twilio($account_sid, $auth_token);
				$message = $client->account->messages->sendMessage(
				  '+19513224295', // From a Twilio number in your account
				  '+91'.$seller_data->phone_no, // Text any number
				  "Check Message!"
				);
			
			} catch (Exception $e) {
				//echo $e->getMessage();
			}
			try
			{
				$sql12 = "UPDATE tbl_clinic_master SET status='0' WHERE id=".$row['id'];
				$r2 = $mysqli->query($sql12);
				
				$msg = "Hello ".$seller_data->first_name." ".$seller_data->last_name.",<br/><br/>Your Free trial period is over please upgrade it for further use vettrree files application. ";
				$mail_sent = sMail($seller_data->email,$seller_data->first_name." ".$seller_data->last_name, "Trial Version Expired", $msg);
		
				//echo $seller_data->email;
				
			} catch (Exception $e) {
				echo $e->getMessage();
			}	
		}
		//$sql13 = "INSERT INTO tbl_app_logs (id, app_id, mail_sent, sms_sent) VALUES (NULL, ".$row['app_id'].", '".$mail_sent."', '".$message->sid."')";
		//$r3 = $mysqli->query($sql13);
	}
}

?>