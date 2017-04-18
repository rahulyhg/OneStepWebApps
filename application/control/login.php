<?php
class Login  extends Controller 
{
	public function index()
	{
		parent::__construct();
		$this->view->adminlogin("login/index");
	}	
	public function signup()
	{
		parent::__construct();
		$this->view->adminlogin("login/signup");
	}	
	public function forgetpass()
	{
		parent::__construct();
		$this->view->adminlogin("login/forgetpass");
	}	
	public function __call($method, $args) 
	{
		require 'application/control/error.php';
		$controller=new Error();
		return false;
	}  		
	public function loginvalidate()
	{
		require 'include_classes.php';
		$table="users";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user_name = $_REQUEST['username'];
		$password = md5($_REQUEST['password']);
		$condition = "(email = '{$user_name}' or phonenumber = '{$user_name}') && password = '{$password}'";
		$res = $db->Fetch($table, "*", $condition, null, array(0,1));
		$counter = mysql_num_rows($res);
		if(1 == $counter)
		{
			$a=array("#4285F4","#EA4335","#00695C","#34A853","#009688");
			$random_keys=array_rand($a,3);
			
			$b=array("#009688","#34A853","#EA4335","#00695C","#4285F4");
			$random_keys1=array_rand($b,4);
			
			$obj = mysql_fetch_assoc($res);
			$_SESSION["samajadmin"] = $obj;
			$_SESSION["samajadmin"]["dashdoard"]= BASEPATH."/users/home";
			$_SESSION["samajadmin"]["color"] = $a[$random_keys[0]];
			$_SESSION["samajadmin"]["client_color"] = $b[$random_keys1[0]];
			echo json_encode(array("success"=>"1","msg"=>'Login Successfully.'));
		}
		else
		{
			echo json_encode(array("success"=>"0","msg"=>'Username or Password incorrect.'));
		}
		exit;
	}
	
	public function forgotpass()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
  		$db = new Db();
		$table = "users";
		$table_id = 'id';
		
		$email = $_POST['reset_email'];
		$date = new DateTime();
		$token = $date->getTimestamp();
		
		$condition = "email = '{$email}' ";
		$res = $db->Fetch($table, "*", $condition, null, array(0,1));
		$counter = mysql_num_rows($res);
		if(1 == $counter) 
		{
			$test["user"] = mysql_fetch_assoc($res);
			$result = $db->Update($table, $_POST, $table_id,$test["user"]["id"]);	
			$result = $_POST[$table_id];
			$_SESSION["samajadmin"]['msg']= "Check your mail to reset password.";
			$msg = '<p>Hi,'.$test["user"]["username"].'!</p><p>You recently requested to reset you password for your account. Click on the button below to reset it.</p><p>if you didn\'t request a password reset, please ignore this email or reply to let us know.</p><p>You can reset you password <a href="'.SITE_ROOT.'/users/resetpass?id='.$test["user"]["id"].'">Click Here</a></p>';
			//echo $msg;
			
			sMail($_POST['reset_email'],$test["user"]["username"], "Reset Password", $msg);
			echo json_encode(array("success"=>"1","msg"=>'Check your mail to reset password.'));
		}
		else
		{
			echo json_encode(array("success"=>"0","msg"=>'Username or Email-Id is incorrect.'));
		}
		exit;
	}
	
	public function signupact()	{		
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();	
		$table = "users";
		$table_id = 'id';
		$_POST = $db->FilterParameters($_POST);	
		$date = new DateTime();	
		$token = $date->getTimestamp();		
		$condition = "phonenumber = '".$_REQUEST['phonenumber']."'";	
		$check_name = $db->FunctionFetch($table, 'count', '*', $condition);		
		$condition1 = "email = '".$_REQUEST['email']."'";	
		$check_name1 = $db->FunctionFetch($table, 'count', '*', $condition1);	
		if($check_name > 0)		
		{			
			echo json_encode(array('msg'=>'Phone Number Already Present.'));			
			exit;		
		}	
		else if($check_name1 > 0){			
			echo json_encode(array('msg'=>'User Email-ID Already Present.'));			
			exit;		
		}else{			
			$_POST['password'] = md5($_REQUEST['newpassword']);					
			$result = $db->Insert($table, $_POST, 1);		
			if($result)		
			{		
				$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="viewport" content="width=device-width" /><style type="text/css">@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {body[yahoo] .buttonwrapper { background-color: transparent !important; }body[yahoo] .button { padding: 0 !important; }body[yahoo] .button a { background-color: #1ec1b8; padding: 15px 25px !important; }}@media only screen and (min-device-width: 601px) {.content { width: 600px !important; }	.col387 { width: 387px !important; }}</style></head><body bgcolor="#32323a" style="margin: 0; padding: 0; background: #32323a;" yahoo="fix"><!--[if (gte mso 9)|(IE)]><table width="600" align="center" cellpadding="0" cellspacing="0" border="0"><tr><td><![endif]--><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content"><tr>	<td style="padding: 15px 10px 15px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="display:none;"><tr><td align="center" width="100%" style="color: #999999; font-family: Arial, sans-serif; font-size: 12px;">2016 &copy; <a href="'.SITE_ROOT.'" style="color: #1ec1b8;">5LP Parivar</a></td></tr></table></td></tr><tr>	<td align="center" bgcolor="#1ec1b8" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">		<img src="'.SITE_ROOT.'/images/logo-white.png" alt="ProUI Logo" width="200" height="152" style="display:block;" />	</td></tr><tr>	<td align="center" bgcolor="#ffffff" style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">		<b>Thanks for Registration 5LP Parivar</b>		<p style="margin: 20px 0px; font-size: 15px;">Hi,'.$_POST['first_name'].' '.$_POST['last_name'].'! Thanks for signing up and joining Samaj. You can use our webapp on all of your devices. To learn more about our webapp or log in, go to our website. If you need any help,don\'t hesitate to contact us with your questions.</p>	</td></tr><tr>	<td align="center" bgcolor="#f9f9f9" style="padding: 20px 20px 0 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;"><b>Account:</b> '.$_POST['email'].'	</td></tr><tr style="display:none">	<td align="center" bgcolor="#f9f9f9" style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif; border-bottom: 1px solid #f6f6f6;"><table bgcolor="#1ec1b8" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper"><tr><td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button"></td></tr></table></td></tr><tr style="display:none">	<td align="center" bgcolor="#ffffff" style="padding: 10px 20px 10px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">Help! <a href="#" style="color: #1ec1b8;">I didn\'t request this!</a></td></tr><tr>	<td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;"><b>Customer support</b><br/>Phone: 9022520952 &bull; Email id: contact@5lpparivar.com &bull; Time: 10am to 6pm (IST)</td></tr><tr>	<td style="padding: 15px 10px 15px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" width="100%" style="color: #999999; font-family: Arial, sans-serif; font-size: 12px;">2016 &copy; <a href="'.SITE_ROOT.'" style="color: #1ec1b8;">5LP Parivar</a></td></tr></table>	</td></tr></table><!--[if (gte mso 9)|(IE)]>	</td></tr></table><![endif]--></body></html>';	
				//sMail($_POST['email'],$_POST['first_name']." ".$_POST['last_name'], "Thanks for login 5LP Parivar ", $msg);	
				
				//$_SESSION["samajadmin"]['msg']= "Thank You! You have successfully created an account";
				//$_SESSION["samajadmin"]['msg_type']="1";	
				
				echo json_encode(array('success'=>1,'msg'=>'Thank You! You have successfully created an account','id'=>$result));	
				
				exit;			
			}			
			else		
			{	
				echo json_encode(array('success'=>0,'msg'=>'Problem in data insert.'));	
				exit;		
			}		
		}	
	}
}

?>