<?php
class Mail  extends Controller 
{
	public function index()
	{
		parent::__construct();
		$this->view->admin("mail/index");
	}
	
	public function sendmail()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		require_once DOC_ROOT.'/classes/pushnotify/firebase.php';
		require_once DOC_ROOT.'/classes/pushnotify/push.php';
		
		$db = new Db();
		$city_select = array();
		$table = "user";
		$table_id = 'id';
		$users = array();
		$device = "ios";
		$users = $_POST['multiselect'];
		/*$city_select = $_POST['city_multiselect'];
		foreach ($city_select as $value) {
			$value = $value + $value;
			
		echo " Val ".$value;
		}
		exit;*/
		
		$city_users = $db->FetchCellValue("image","path","id = ".$row1['image_id']." AND flag = '1' ");
		
		$event_title = "";
		$event_desc = "";
		$event_loc = "";
		$event_time = "";
		$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<meta name="viewport" content="width=device-width" />
					   <style type="text/css">
							@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
								body[yahoo] .buttonwrapper { background-color: transparent !important; }
								body[yahoo] .button { padding: 0 !important; }
								body[yahoo] .button a { background-color: #1ec1b8; padding: 15px 25px !important; }
							}

							@media only screen and (min-device-width: 601px) {
								.content { width: 600px !important; }
								.col387 { width: 387px !important; }
							}
						</style>
					</head>
					<body bgcolor="#32323a" style="margin: 0; padding: 0; background:#32323a;" yahoo="fix">';
					
		if(isset($_POST['lay']) && $_POST['lay'] != "" && $_POST['lay'] == '2')
		{
			$msg .= $_POST['content2'];
		}
		else
		{
			$msg .= $_POST['content'];
		}
		
		if(isset($_POST['type']) && $_POST['type'] != "" && $_POST['type'] == 'event')
		{
			$table = 'event_details';
			$main_table = array("$table i",array("i.*"));
			$join_tables = array(
			);
			$condition = "i.id = ".$_POST['name'];
		
			$rs = $db->JoinFetch($main_table, $join_tables, $condition);
			while($row = mysql_fetch_object($rs))
			{
				$event_id = $row->id; 
				$event_title = $row->name;
				$event_desc = $row->description;
				$event_loc = $row->location_name;
				$event_date = $row->event_date;				
				$event_time = '';				
			}
			$base_image = $db->Fetch("image_xref","*","ref_id=".$_REQUEST["name"]." AND status = '3' && ref_type = '86' "  );
			while($row1 = mysql_fetch_array($base_image))
			{
				$temparray = array();
				$temparray['src'] = $db->FetchCellValue("image","path","id = ".$row1['image_id']." AND flag = '1' ");
				$temparray['id'] = $row1['id'];
				$temparray['image_id'] = $row1['image_id'];
				$base_image_path[] = $temparray;
			}
			if(isset($_POST['lay']) && $_POST['lay'] != "" && $_POST['lay'] == '2')
			{
				if(isset($base_image_path) && $base_image_path != "")							
				{
					$fimage = SITE_ROOT."/".$base_image_path[0]['src'];
					$myimg .= '<td style="padding: 10px 20px 0 20px;" bgcolor="#ffffff"><table width="128" cellspacing="0" cellpadding="0" border="0" align="left"><tbody><tr>';
					$size = sizeof($base_image_path);
					if($size > 4){ 
						$temp = 4;
					}
					else{
						$temp = $size;
					}
					for($k = 0;$k<=$temp;$k++)
					{	
						$myimg .= '<td style="padding: 0 20px 20px 0;" height="128"><img src="'.SITE_ROOT.'/'.$base_image_path[$k]['src'].'" style="display: block;" width="128" height="128"/></td>';
						
					}
					$myimg .= '</tr></tbody></table></td>';
				}
				else{
					$fimage = "";
					$myimg .= '<td style="padding: 1px;" bgcolor="#ffffff"></td>';
				}
			}
			else
			{
				if(isset($base_image_path) && $base_image_path != "")							
				{
					$fimage = SITE_ROOT."/".$base_image_path[0]['src'];
					$myimg .= '<td bgcolor="#ffffff" style="padding: 10px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;"><img src="'.SITE_ROOT."/".$base_image_path[0]['src'].'" alt="Image" width="100%" style="display: block; height: 300px;" /></td>';
				}
				else{
					$fimage = "";
					$myimg .= '<td style="padding: 1px;" bgcolor="#ffffff"></td>';
				}
			}
			$_POST1 = array();
			$_POST1['title'] = $event_title;
			$_POST1['description'] = $event_desc;
			$_POST1['ref_id'] = $event_id;
			$_POST1['ref_type'] = 'event';;
			$_POST1['notification_date'] = date("m/d/Y");
			$_POST1['notification_date'] = date("m/d/Y");
			$_POST1['created_by'] = $_SESSION['samajadmin']['id'];
			$_POST1['status'] = '1';
			$result2 = $db->insert('user_notification',$_POST1,"1");
		}
		else
		{
			
			$table = 'samaj_funtions';
			$main_table = array("$table i",array("i.*"));
			$join_tables = array(
			);
			$condition = "i.id = ".$_POST['name'];
		
			$rs = $db->JoinFetch($main_table, $join_tables, $condition);
			while($row = mysql_fetch_object($rs))
			{
				$event_id = $row->id;
				$event_title = $row->name;
				$event_desc = $row->description;
				$event_loc = $row->location;
				$event_time = $row->fun_time;
				$event_date = $row->fun_date;
			}
			$base_image = $db->Fetch("image_xref","*","ref_id=".$_REQUEST["name"]." AND status = '3' && ref_type = '87' "  );		
			while($row2 = mysql_fetch_array($base_image))		{			
				$temparray = array();			
				$temparray['src'] = $db->FetchCellValue("image","path","id = ".$row2['image_id']." AND flag = '1' ");			
				$temparray['id'] = $row2['id'];			
				$temparray['image_id'] = $row2['image_id'];			
				$base_image_path[] = $temparray;		
			}	
			if(isset($_POST['lay']) && $_POST['lay'] != "" && $_POST['lay'] == '2')
			{
				if(isset($base_image_path) && $base_image_path != "")							
				{
					$fimage = SITE_ROOT."/".$base_image_path[0]['src'];
					$myimg .= '<td style="padding: 10px 20px 0 20px;" bgcolor="#ffffff"><table width="128" cellspacing="0" cellpadding="0" border="0" align="left"><tbody><tr>';
					$size = sizeof($base_image_path);
					if($size > 4){ 
						$temp = 4;
					}
					else{
						$temp = $size;
					}
					for($k = 0;$k<$temp;$k++)
					{	
						$myimg .= '<td style="padding: 0 20px 20px 0;" height="128"><img src="'.SITE_ROOT.'/'.$base_image_path[$k]['src'].'" style="display: block;" width="128" height="128"/></td>';
						
					}
					$myimg .= '</tr></tbody></table></td>';
				}
				else{
					$fimage = "";
					$myimg .= '<td style="padding: 1px;" bgcolor="#ffffff"></td>';
				}
			}
			else
			{
				if(isset($base_image_path) && $base_image_path != "")							
				{
					$fimage = SITE_ROOT."/".$base_image_path[0]['src'];
					$myimg = '<td bgcolor="#ffffff" style="padding: 10px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;"><img src="'.SITE_ROOT."/".$base_image_path[0]['src'].'" alt="Image" width="100%" style="display: block; height: 300px;" /></td>';
				}
				else{
					$fimage = "";
					$myimg .= '<td style="padding: 1px;" bgcolor="#ffffff"></td>';
					
				}
			}
			$_POST2 = array();
			$_POST2['title'] = $event_title;
			$_POST2['description'] = $event_desc;
			$_POST2['ref_id'] = $event_id;
			$_POST2['ref_type'] = 'function';;
			$_POST2['notification_date'] = date("m/d/Y");
			$_POST2['notification_date'] = date("m/d/Y");
			$_POST2['created_by'] = $_SESSION['samajadmin']['id'];
			$_POST2['status'] = '1';
			$result2 = $db->insert('user_notification',$_POST2,"1");
			/*error_reporting(-1);
			ini_set('display_errors', 'On');
	 
			$firebase = new Firebase();
			$push = new Push();
	 
			$payload = array();
			$payload['team'] = 'India';
			$payload['score'] = '5.6';
			$title = $event_title;
			$message = $db->summary($event_desc,50);
			$push->setTitle($title);
			$push->setImage($fimage);
			$push->setMessage($message);
			$push->setIsBackground(FALSE);
			$push->setPayload($payload);
			$json = '';
			$response = '';
	 
			$table = "notification_response";
			$table_id = 'id';
			
			$json = $push->getPush();
			$response = $firebase->sendToTopic('global', $json);
			
			$adddata['request'] = json_encode($json);
			$adddata['response'] = $response;
			$adddata['created_by'] = $_SESSION["samajadmin"]["id"];
			$result = $db->Insert($table, $adddata, 0);*/
		}
		if(isset($_POST['type']) && $_POST['type'] != ""){
			$msg = str_replace("{Newsletter}",$_POST['type'],$msg);
		}
		else{
			$msg = str_replace("{Newsletter}",'Newsletter',$msg);
		}
		if(isset($_REQUEST['withmail']) && $_REQUEST['withmail'] != "")
		{
			$msg = str_replace("{Title}",$event_title,$msg);
			$msg = str_replace("{Description}",$event_desc,$msg);
			$msg = str_replace("{Location}",$event_loc,$msg);
			$msg = str_replace("{Date}",$event_date,$msg);
			$msg = str_replace("{Time}",$event_time,$msg);
			$msg = str_replace("<td>{image}</td>",$myimg,$msg);
			$msg .= '</body></html>';
			foreach( $users as $key => $n ) {
				$mailid = $db->FetchCellValue("user","email","id = ".$n." AND active_member = '1' ");
				$tokenid = $db->FetchCellValue("user","token","id = ".$n." AND active_member = '1' AND notification = '1' ");
				if($mailid!= "" && !filter_var($mailid, FILTER_VALIDATE_EMAIL) === false) {
					sMail($mailid,"Mail from Samaj Applications", "Thanks for login Samaj", $msg);
				}
				if($tokenid != "") {
					/*sMail($mailid,"Mail from Samaj Applications", "Thanks for login Samaj", $msg);*/
					error_reporting(-1);
					ini_set('display_errors', 'On');
			 
					$firebase = new Firebase();
					$push = new Push();
			 
					$payload = array();
					$payload['team'] = 'India';
					$payload['score'] = '5.6';
					$title = $event_title;
					$message = $db->summary($event_desc,50);
					$push->setTitle($title);
					$push->setImage($fimage);
					$push->setMessage($message);
					$push->setIsBackground(FALSE);
					$push->setPayload($payload);
					$json = '';
					$response = '';
			 
					$table = "notification_response";
					$table_id = 'id';
					
					$json = $push->getPush();
					
					$regId = isset($tokenid) ? $tokenid : '';
					$device = $db->FetchCellValue("user","device","id = ".$n." AND active_member = '1' AND notification = '1' ");
					if($device != "Android") 
						$device = "ios";
					$eve_summary = $db->summary($event_desc,50);
					$response = $firebase->send($regId, $json,$device,$event_title,$eve_summary );
					
					
					$adddata['request'] = json_encode($json);
					$adddata['response'] = $response;
					$adddata['title'] = $event_title;
					$adddata['description'] = $db->summary($event_desc,50);
					$adddata['user_list'] = $n;
					$adddata['type'] = $_REQUEST['type'];
					
					$adddata['created_by'] = $_SESSION["samajadmin"]["id"];
					$result = $db->Insert($table, $adddata, 0);
				}				else{					
				$table = "notification_response";			
				$adddata['title'] = $event_title;		
				$adddata['description'] = $db->summary($event_desc,50);
				$adddata['user_list'] = $n;	
				$adddata['type'] = $_REQUEST['type'];	
				$adddata['created_by'] = $_SESSION["samajadmin"]["id"];					$result = $db->Insert($table, $adddata, 0);				}
			}
			if(isset($_REQUEST['city_multiselect']) && $_REQUEST['city_multiselect'] !=  "")
			{
				$join_tables = array();
				$table = "user";
				$main_table = array("$table i",array("i.*"));
				$condition = "i.active_member = 1 && i.notification = 1 && i.samaj_city_id in ('".join("','",$_REQUEST['city_multiselect'])."')";
				$rs88 = $db->JoinFetch($main_table, $join_tables, $condition);
				while($row88 = mysql_fetch_object($rs88))
				{
					if (filter_var($row88->email, FILTER_VALIDATE_EMAIL)) {
						sMail($row88->email,"Mail from Samaj Applications", "Thanks for login Samaj", $msg);
					}
					if($row88->token != "")
					{
						error_reporting(0);
						$firebase = new Firebase();
						$push = new Push();			 
						$payload = array();
						$payload['team'] = 'India';
						$payload['score'] = '5.6';
						$title = $event_title;
						$message = $db->summary($event_desc,50);
						$push->setTitle($title);
						$push->setImage($fimage);
						$push->setMessage($message);
						$push->setIsBackground(FALSE);
						$push->setPayload($payload);
						$json = '';
						$response = '';
				 
						$table = "notification_response";
						$table_id = 'id';
						
						$json = $push->getPush();
						$tokenid = $row88->token;
						$regId = isset($tokenid) ? $tokenid : '';
						$device = $row88->device;
						if($device != "Android") 
							$device = "ios";
						$eve_summary = $db->summary($event_desc,50);
						$response = $firebase->send($regId, $json,$device,$event_title,$eve_summary);
						
						$adddata['request'] = json_encode($json);
						$adddata['response'] = $response;
						$adddata['title'] = $event_title;
						$adddata['description'] = $db->summary($event_desc,50);
						$adddata['user_list'] = $row88->id;
						$adddata['type'] = $_REQUEST['type'];
						$adddata['created_by'] = $_SESSION["samajadmin"]["id"];
						$result = $db->Insert($table, $adddata, 0);
					}					else{						$table = "notification_response";						$adddata['title'] = $event_title;						$adddata['description'] = $db->summary($event_desc,50);						$adddata['user_list'] = $row88->id;						$adddata['type'] = $_REQUEST['type'];						$adddata['created_by'] = $_SESSION["samajadmin"]["id"];						$result = $db->Insert($table, $adddata, 0);					}
				}
			}
			$_SESSION["samajadmin"]['msg']= "Mail & Notification Send Successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success','message'=>'Mail Send Successfully.','id'=>$result2));
			exit;
		}
		else
		{
			foreach( $users as $key => $n ) {
				$tokenid = $db->FetchCellValue("user","token","id = ".$n." AND active_member = '1' AND notification = '1' ");
				if($tokenid != "") {
					/*sMail($mailid,"Mail from Samaj Applications", "Thanks for login Samaj", $msg);*/
					error_reporting(-1);
					ini_set('display_errors', 'On');
			 
					$firebase = new Firebase();
					$push = new Push();
			 
					$payload = array();
					$payload['team'] = 'India';
					$payload['score'] = '5.6';
					$title = $event_title;
					$message = $db->summary($event_desc,50);
					$push->setTitle($title);
					$push->setImage($fimage);
					$push->setMessage($message);
					$push->setIsBackground(FALSE);
					$push->setPayload($payload);
					$json = '';
					$response = '';
			 
					$table = "notification_response";
					$table_id = 'id';
					
					$json = $push->getPush();
					
					$regId = isset($tokenid) ? $tokenid : '';
					$device = $db->FetchCellValue("user","device","id = ".$n." AND active_member = '1' AND notification = '1' ");
						if($device != "Android") 
							$device = "ios";
					$eve_summary = $db->summary($event_desc,50);
					$response = $firebase->send($regId, $json, $device,$event_title,$eve_summary);
					
					$adddata['request'] = json_encode($json);
					$adddata['response'] = $response;
					$adddata['title'] = $event_title;
					$adddata['description'] = $db->summary($event_desc,50);
					$adddata['user_list'] = $n;
					$adddata['type'] = $_REQUEST['type'];
					$adddata['created_by'] = $_SESSION["samajadmin"]["id"];
					$result = $db->Insert($table, $adddata, 0);
				}					else{						$table = "notification_response";						$adddata['title'] = $event_title;						$adddata['description'] = $db->summary($event_desc,50);						$adddata['user_list'] = $row88->id;						$adddata['type'] = $_REQUEST['type'];						$adddata['created_by'] = $_SESSION["samajadmin"]["id"];						$result = $db->Insert($table, $adddata, 0);					}
			}
			if(isset($_REQUEST['city_multiselect']) && $_REQUEST['city_multiselect'] !=  "")
			{
				$join_tables = array();
				$table = "user";
				$main_table = array("$table i",array("i.*"));
				$condition = "i.active_member = 1 && i.notification = 1 && i.samaj_city_id in ('".join("','",$_REQUEST['city_multiselect'])."')";
				$rs88 = $db->JoinFetch($main_table, $join_tables, $condition);
				while($row88 = mysql_fetch_object($rs88))
				{
					if($row88->token != "")
					{
						error_reporting(-1);
						ini_set('display_errors', 'On');
				 
						$firebase = new Firebase();
						$push = new Push();
				 
						$payload = array();
						$payload['team'] = 'India';
						$payload['score'] = '5.6';
						$title = $event_title;
						$message = $db->summary($event_desc,50);
						$push->setTitle($title);
						$push->setImage($fimage);
						$push->setMessage($message);
						$push->setIsBackground(FALSE);
						$push->setPayload($payload);
						$json = '';
						$response = '';
				 
						$table = "notification_response";
						$table_id = 'id';
						
						$json = $push->getPush();
						$tokenid = $row88->token;
						$regId = isset($tokenid) ? $tokenid : '';
						$device = $row88->device;
						if($device != "Android") 
							$device = "ios";
						$eve_summary = $db->summary($event_desc,50);
						$response = $firebase->send($regId, $json,$device,$event_title,$eve_summary);
						
						$adddata['request'] = json_encode($json);
						$adddata['response'] = $response;
						$adddata['title'] = $event_title;
						$adddata['description'] = $db->summary($event_desc,50);
						$adddata['user_list'] = $row88->id;
						$adddata['type'] = $_REQUEST['type'];
						$adddata['created_by'] = $_SESSION["samajadmin"]["id"];
						$result = $db->Insert($table, $adddata, 0);
					}					else{						$table = "notification_response";						$adddata['title'] = $event_title;						$adddata['description'] = $db->summary($event_desc,50);						$adddata['user_list'] = $row88->id;						$adddata['type'] = $_REQUEST['type'];						$adddata['created_by'] = $_SESSION["samajadmin"]["id"];						$result = $db->Insert($table, $adddata, 0);					}
				}
			}
			$_SESSION["samajadmin"]['msg']= "Notification Send Successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success','message'=>'Mail Send Successfully.','id'=>$result2));
			exit;
		}
		$_SESSION["samajadmin"]['msg']= "Notification Send Successfully.";		
		$_SESSION["samajadmin"]['msg_type']="1";
		echo json_encode(array('msg'=>'success','message'=>'Mail Send Successfully.','id'=>$result2));
		exit;
		
		
	}
	
	public function remote()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$table = "user";
		$table_id = 'id';

		$search = preg_quote(isset($_REQUEST['search']) ? $_REQUEST['search'] : '');
		$main_table = array("$table i",array("i.*"));
		$join_tables = array();
		$condition = " (i.first_name LIKE '%".$search."%' or i.last_name LIKE '%".$search."%') ";
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);

		$result = array();
		while($row = mysql_fetch_assoc($rs))
		{
			$result[] = array('value' => $row['id'], 'text' => $row['first_name']." ".$row['last_name']." ( ".$row['phonenumber']." )");
		}
		echo json_encode($result);
		exit;  
	}
}
?>