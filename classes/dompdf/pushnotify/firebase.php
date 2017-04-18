<?php
 
/**
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class Firebase {
 
    public function send($to, $message,$device = null,$not_title = null,$not_desc  = null) {
        $fields = array(
            'to' => $to,
            'data' => $message,
        );			
		if($device == "ios")			
		{
			$ch = curl_init("https://fcm.googleapis.com/fcm/send");				
			$token = $to; 				
			$title = $not_title;				
			$body = $not_desc;				
			$data = array('title' =>$title,'text' => $body);				
			$notification = array('title' =>$title , 'text' => $body);				
			$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');				
			$json = json_encode($arrayToSend);				
			$headers = array();				
			$headers[] = 'Content-Type: application/json';				
			$headers[] = 'Authorization: key= AIzaSyCKV5UnIZRxiwn5Fx236ODQSAyc1dZ9Jr0';				
			curl_setopt($ch, CURLOPT_POST, true);               
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);				
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);				
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);      	
			/*$response = curl_exec($ch);				curl_close($ch);*/				
			return curl_exec($ch);			
		}		
		else
			return $this->sendPushNotification($fields);
    }
 
    public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }
 
    public function sendMultiple($registration_ids, $message) {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
        );
 
        return $this->sendPushNotification($fields);
    }
 
    private function sendPushNotification($fields) {
         
        require_once __DIR__ . '/config.php';
 
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        curl_close($ch);
 
        return $result;
    }
}
?>