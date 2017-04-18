<?php
class Users extends Controller 
{
	/*public function index()
	{
		parent::__construct();
		require 'include_classes.php';
  		$db = new Db();
		$this->view->login("users/index");
	}*/
	
	public function myprofile()
	{
		parent::__construct();
		require 'include_classes.php';
  		$db = new Db();
		$this->view->admin("users/myprofile");
	}

	public function updatemyprofile() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "users";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
  
		$intid = $_REQUEST['id'];
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$result2 = $db->Update($table,$_REQUEST,"id",$intid);
			$_SESSION["samajadmin"]['msg']= "Record updated successfully.";		
			echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
			exit;
		}
		else
		{
			$_SESSION["samajadmin"]['msg']= "Problem in data Update.";	
			echo json_encode(array("success"=>"0",'msg'=>'Problem in data Update.'));
			exit;
		}
	}

	public function settings()
	{
		parent::__construct();
		require 'include_classes.php';
  		$db = new Db();
		$this->view->login("users/settings");
	}
	
	public function __call($method, $args) 
	{
		require 'application/control/error.php';
		$controller=new Error();
		return false;
  	}  	
	public function addEdit()
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			
			$table = "tbl_user_master";
			$table_id = 'id';
			
			$_POST = $db->FilterParameters($_POST);
			$date = new DateTime();
			$token = $date->getTimestamp();
		
			$condition = "email = '".$_POST['email']."'";
			
			$check_name = $db->FunctionFetch($table, 'count', '*', $condition);
		
			$user_id_value = 0;
			
			$new_password = '';
				
				
				
				if(isset($_POST['id']) && $_POST['id']!="")
				{
					$result2 = $db->Update('tbl_user_master',$_POST,"id",$_POST['id']);
					$base_image = $db->FetchCellValue("tbl_user_clinic_relation","id","clinic_id = ".$_SESSION["webadmin1"]["clinic_id"]." AND user_id = '".$_POST['id']."'");
					$relation['role_id'] = $_POST['role_id'];
					if($base_image>0)
						$result1 = $db->Update("tbl_user_clinic_relation", $relation,"id", $base_image);						

					if($result2)
					{
						$_SESSION["samajadmin"]['msg']= "Record updated successfully.";		
						$_SESSION["samajadmin"]['msg_type']="1";
						echo json_encode(array('msg'=>'success'));
						$user_id_value = $_POST['id'];
					}
					else
					{
						echo json_encode(array('msg'=>'Problem in data insert.'));
						exit;
					}
				}
				else
				{
					if($check_name > 0)
					{
						echo json_encode(array('msg'=>'Email Id Already Present.'));
						exit;
					}
					$_POST['status'] = '0';
					$new_password = rand(9999999, 99999999);
					$characters = 'abcdefghkmnoprstwxz34689ABCDEFGHJKLMNPQRTWXY';
					
					for ($i = 0; $i < 10; $i++) {
						$new_password .= $characters[rand(0, strlen($characters) - 1)];
					}
					
					//echo $new_password;
					$_POST['password'] = md5($new_password);
					$_POST['token'] = $token;
					$result1 = $db->Insert('tbl_user_master', $_POST, 1);
					
					$relation['user_id'] = $result1;
					$relation['clinic_id'] = $_SESSION["webadmin1"]["clinic_id"];
					$relation['role_id'] = $_POST['role_id'];
					$result2 = $db->Insert('tbl_user_clinic_relation',$relation,1);
					
					$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";					
					//echo "message";
					if($result1)
					{
						//echo "in if";
						$user_id_value = $result1;
						$_SESSION["samajadmin"]['msg_type']="1";
						
						echo json_encode(array('msg'=>'success'));
						
						
					}
					else
					{
						echo json_encode(array('msg'=>'Problem in data insert.'));
						exit;
					}
				}
				
				if ($_FILES['thumbnail']['size'] > 0 && $_FILES['thumbnail']['error'] == 0 && $user_id_value>0)
				{
					//echo "UPDATE IF:::";
					 $target_dir = "uploads/";
					$file_name = time()."_".str_replace(" ","_",basename($_FILES["thumbnail"]["name"]));
                    $target_file = $target_dir . $file_name;
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					$imageFileType = strtolower($imageFileType);
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
                        if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            $uploadOk = 0;
                            echo json_encode(array('msg'=>'File is not an image.'));
                            exit;
                        }
                    }
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $uploadOk = 0;
                        echo json_encode(array('msg'=>'Sorry, file already exists.'));
                        exit;
                    }
                    // Check file size 5 MB  : 5*1024*1024
                    if ($_FILES["thumbnail"]["size"] > 3010000) {
                        $uploadOk = 0;
                        echo json_encode(array('msg'=>'Sorry, your file is too large. The maximum file size limit is 3 MB.'));
                        exit;
                    }
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        echo json_encode(array('msg'=>'Please upload product\'s image. <br/>Allowed image types JPG, JPEG, PNG & GIF'));
                        $uploadOk = 0;
                        exit;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo json_encode(array('msg'=>'Sorry, your file was not uploaded.'));
                        exit;
                    // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
							//Core::createThumbnail($file_name, $target_dir, $target_dir, IMAGE_WIDTH);
                            //echo "The file has been uploaded.";
                            //echo "The file Name :".$file_name;
							$clinic_post1['profile_image'] = $file_name;
                            $clinic_post1['id'] = $user_id_value;
							$result2 = $db->Update('tbl_user_master',$clinic_post1,"id",$user_id_value);
							//echo "update";
							if($_POST['id']=="")
							{
								//echo "Upadettttt";
								//$msg = "Please click on the verification link:<a href='".SITE_ROOT."/users/verify?clinic_id=".$_SESSION["webadmin1"]["clinic_id"]."&user_id=".$result1."&token=".$token."'>Click Here</a><br/><br/>After verification you can login into the below site:<a href='".SITE_ROOT."'>Click Here</a><br/><br/>You can use the below credentials<br/>Username : ".$_POST['email']."<br/>Password : ".$new_password."<br/><br/>- The Vettree Files Team";
								$msg = '<table cellspacing="0" cellpadding="0" bgcolor="#f6f6f6" style="font-family: Arial,sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0px auto; padding: 0px; max-width: 600px; text-align: center; border: 1px solid rgb(1, 91, 126); background: transparent url(http://vettreefiles.com/images/email_bg.png) no-repeat scroll 0 -210px" class="body-wrap"><tr>	<td colspan=2 style="padding: 20px;"><a href="http://vettreefiles.com/"><img src="http://vettreefiles.com/images/logo.png"  style="float:left;"></a>&nbsp;<a href="http://vettreefiles.com/contact" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">CONTACT</a><a href="http://vettreefiles.com/testimonials" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">TESTIMONIALS</a><a href="http://vettreefiles.com/pricing" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">PRICING</a><a href="http://vettreefiles.com/features" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">FEATURES</a></td></tr><tr ><td colspan=2 ><h1 style="text-align:center;text-transform:uppercase;color:white;margin-top: 15px;margin-bottom:40px;">Vettree Files Login Credentials</h1></td></tr><tr style="background:white;"><td  style="padding: 20px;width:50%;"><p style="margin-top: 40px;color:#333;text-align:left;">Hi,'.$_POST['first_name'].' '.$_POST['last_name'].'!</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>First Name:</b></span>'.$_POST['first_name'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>last name:</b></span>'.$_POST['last_name'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Type:</b></span>'.$_POST['role_id'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Gender:</b></span>'.$_POST['gender'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Date of Birth:</b></span>'.$_POST['dob'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Email Id:</b></span>'.$_POST['email'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Mobile Number:</b></span>'.$_POST['phone_no'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Address:</b></span>'.$_POST['address'].','.$_POST['street'].','.$_POST['city'].','.$_POST['province'].','.$_POST['country'].','.$_POST['pincode'].'</p></td><td  style="width:50%"><p style="color:#333;text-align:left;padding-top:60px;margin:0;"><span style="color:#307A97"><b>Please note:</b></span>Please click on the verification link:<a href="'.SITE_ROOT.'/users/verify?clinic_id='.$_SESSION['webadmin1']['clinic_id'].'&user_id='.$result1.'&token='.$token.'">Click Here</a><br/><br/>After verification you can login into the below site:<a href="'.SITE_ROOT.'">Click Here</a><br/><br/>You can use the below credentials<br/>Username : '.$_POST['email'].'<br/>Password : '.$new_password.'<br/><br/></p></td></tr><tr style="background:white;"><td colspan=2 ><p style="margin-bottom: 70px;text-align:left;color:#333; margin-left: 20px;">View the Terms of Use for this order in your purchase history.</p>	</td></tr><tr><td colspan=2 style="background: transparent url(\'http://vettreefiles.com/images/email_bg.png\') no-repeat scroll 0px 0px / 100% auto;"><img style="width: 300px;height: 150px;margin-top: 10px;float: left;" src="http://vettreefiles.com/images/device.png" alt="banner-image"><p style="float:left;text-align: left;font-size: 12px;color: white;line-height: 16px;width: 245px;margin-top: 35px;margin-left: 25px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p></td></tr><tr bgcolor="#015B7E" style="text-align:center;"><td colspan=2 style="padding-bottom: 20px;padding-top: 20px;"><a href="http://vettreefiles.com/"><img src="http://vettreefiles.com/images/logo.png"></a>		<p><a href="http://vettreefiles.com/features" style="color:white;padding-left:5px;text-decoration:none;">FEATURES</a><a href="http://vettreefiles.com/pricing" style="color:white;padding-left:15px;text-decoration:none;">PRICING</a><a href="http://vettreefiles.com/testimonials" style="color:white;padding-left:15px;text-decoration:none;">TESTIMONIALS</a><a href="http://vettreefiles.com/contact" style="color:white;padding-left:15px;text-decoration:none;">CONTACT</a></p><p style="text-align:center;margin-bottom: 25px;margin-top: 25px;"><a href="https://www.facebook.com/vaultify/"><img src="http://vettreefiles.com/images/fa-facebook-square.png" ></a><a href="https://www.instagram.com/vaultify/"><img src="http://vettreefiles.com/images/fa-instagram.png" style="padding-left:15px;"></a><a href="https://www.twitter.com/Vaultifyapp"><img src="http://vettreefiles.com/images/fa-twitter-.png" style="padding-left:15px;"></a><a href="#"><img src="http://vettreefiles.com/images/fa-google-plus.png" style="padding-left:15px;"></a></p><p style="text-align:center;color:white;">&copy; 2016 <a style="color:white" href="#">vaultify.io</a>  All Rights Reserved</p></td></tr></table>';
								
								//echo $msg."--".$_POST['email']."--";
								//echo $_POST['first_name']." ".$_POST['last_name'];
								$mail1 = sMail($_POST['email'],$_POST['first_name']." ".$_POST['last_name'], "Vettree Files Login Credentials", $msg);
								//echo "Mail:::".$mail1;
							}
						}
					}
				}
				else if($user_id_value>0)
				{
					if($_POST['id']=="")
					{
						//echo "Upadettttt";
						$msg = '<table cellspacing="0" cellpadding="0" bgcolor="#f6f6f6" style="font-family:Arial,sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0px auto; padding: 0px; max-width: 600px; text-align: center; border: 1px solid rgb(1, 91, 126); background: transparent url(http://vettreefiles.com/images/email_bg.png) no-repeat scroll 0 -210px" class="body-wrap"><tr>	<td colspan=2 style="padding: 20px;"><a href="http://vettreefiles.com/"><img src="http://vettreefiles.com/images/logo.png"  style="float:left;"></a>&nbsp;<a href="http://vettreefiles.com/contact" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">CONTACT</a><a href="http://vettreefiles.com/testimonials" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">TESTIMONIALS</a><a href="http://vettreefiles.com/pricing" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">PRICING</a><a href="http://vettreefiles.com/features" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">FEATURES</a></td></tr><tr ><td colspan=2 ><h1 style="text-align:center;text-transform:uppercase;color:white;margin-top: 15px;margin-bottom:40px;">Vettree Files Login Credentials</h1></td></tr><tr style="background:white;"><td  style="padding: 20px;width:50%;"><p style="margin-top: 40px;color:#333;text-align:left;">Hi,'.$_POST['first_name'].' '.$_POST['last_name'].'!</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>First Name:</b></span>'.$_POST['first_name'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>last name:</b></span>'.$_POST['last_name'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Type:</b></span>'.$_POST['role_id'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Gender:</b></span>'.$_POST['gender'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Date of Birth:</b></span>'.$_POST['dob'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Email Id:</b></span>'.$_POST['email'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Mobile Number:</b></span>'.$_POST['phone_no'].'</p><p style="color:#333;text-align:left;margin:0;"><span style="color:#307A97"><b>Address:</b></span>'.$_POST['address'].','.$_POST['street'].','.$_POST['city'].','.$_POST['province'].','.$_POST['country'].','.$_POST['pincode'].'</p></td><td  style="width:50%"><p style="color:#333;text-align:left;padding-top:60px;margin:0;"><span style="color:#307A97"><b>Please note:</b></span>Please click on the verification link:<a href="'.SITE_ROOT.'/users/verify?clinic_id='.$_SESSION['webadmin1']['clinic_id'].'&user_id='.$result1.'&token='.$token.'">Click Here</a><br/><br/>After verification you can login into the below site:<a href="'.SITE_ROOT.'">Click Here</a><br/><br/>You can use the below credentials<br/>Username : '.$_POST['email'].'<br/>Password : '.$new_password.'<br/><br/></p></td></tr><tr style="background:white;"><td colspan=2 ><p style="margin-bottom: 70px;text-align:left;color:#333; margin-left: 20px;">View the Terms of Use for this order in your purchase history.</p>	</td></tr><tr><td colspan=2 style="background: transparent url(\'http://vettreefiles.com/images/email_bg.png\') no-repeat scroll 0px 0px / 100% auto;"><img style="width: 300px;height: 150px;margin-top: 10px;float: left;" src="http://vettreefiles.com/images/device.png" alt="banner-image"><p style="float:left;text-align: left;font-size: 12px;color: white;line-height: 16px;width: 245px;margin-top: 35px;margin-left: 25px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p></td></tr><tr bgcolor="#015B7E" style="text-align:center;"><td colspan=2 style="padding-bottom: 20px;padding-top: 20px;"><a href="http://vettreefiles.com/"><img src="http://vettreefiles.com/images/logo.png"></a>		<p><a href="http://vettreefiles.com/features" style="color:white;padding-left:5px;text-decoration:none;">FEATURES</a><a href="http://vettreefiles.com/pricing" style="color:white;padding-left:15px;text-decoration:none;">PRICING</a><a href="http://vettreefiles.com/testimonials" style="color:white;padding-left:15px;text-decoration:none;">TESTIMONIALS</a><a href="http://vettreefiles.com/contact" style="color:white;padding-left:15px;text-decoration:none;">CONTACT</a></p><p style="text-align:center;margin-bottom: 25px;margin-top: 25px;"><a href="https://www.facebook.com/vaultify/"><img src="http://vettreefiles.com/images/fa-facebook-square.png" ></a><a href="https://www.instagram.com/vaultify/"><img src="http://vettreefiles.com/images/fa-instagram.png" style="padding-left:15px;"></a><a href="https://www.twitter.com/Vaultifyapp"><img src="http://vettreefiles.com/images/fa-twitter-.png" style="padding-left:15px;"></a><a href="#"><img src="http://vettreefiles.com/images/fa-google-plus.png" style="padding-left:15px;"></a></p><p style="text-align:center;color:white;">&copy; 2016 <a style="color:white" href="#">vaultify.io</a>  All Rights Reserved</p></td></tr></table>';
						
						//echo $msg."--".$_POST['email']."--";
						//echo $_POST['first_name']." ".$_POST['last_name'];
						$mail1 = sMail($_POST['email'],$_POST['first_name']." ".$_POST['last_name'], "Vettree Files Login Credentials", $msg);
						//echo "Mail:::".$mail1;
					}
				}
				exit;
		}
		else
		{
			parent::__construct();
			$this->view->render("users/index");
		}
	}
	
	public function resetpass()
	{
		parent::__construct();
		$this->view->login("users/resetpass");
		require 'include_classes.php';
	}
	
	public function appcalender()
	{
		parent::__construct();
		$this->view->login("users/appcalender");
		require 'include_classes.php';
	}
	
	public function payment()
	{
		parent::__construct();
		$this->view->login("users/payment");
		require 'include_classes.php';
	}
	
	public function attachment()
	{
		parent::__construct();
		$this->view->login("users/attachment");
		require 'include_classes.php';
	}
	
	public function upload()
	{
		/* JPEGCam Test Script */
		/* Receives JPEG webcam submission and saves to local file. */
		/* Make sure your directory has permission to write files as your web server user! */
		 require 'include_classes.php';
		$filename = date('YmdHis') . '.jpg';
		$result = file_put_contents( 'webcam/'.$filename, file_get_contents('php://input') );
		if (!$result) {
			print "ERROR: Failed to write data to $filename, check permissions\n";
			exit();
		}

		$url = 'http://'. SITE_ROOT .'/webcam/' . $filename;
		print "$url\n";

	}
	
	public function changepass()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "tbl_user_master";
		$table_id = 'id';
		
		$new_password = $_POST['new_password'];
		$cnf_password = $_POST['cnf_password'];
		$id = $_POST['id'];
		$token = $_POST['token'];
	//	$condition = "token = '".$_POST['token']."' && id= '".$id."' ";
		$condition = " id= '".$id."' ";
			
		$check_name = $db->FunctionFetch($table, 'count', '*', $condition);
	
		if($check_name > 0)
		{
			if($new_password == $cnf_password)
			{
				$data = array();
				$data['password'] = md5($new_password);
				$data['status'] = 1;
				$data['token'] = '';
				
				$result = $db->Update($table,$data,$table_id,$id);
				if($result)
				{
					$_SESSION["samajadmin"]['msg']= "Password Reset successfully.";		
					echo json_encode(array('msg'=>'success'));
					exit;
				}
				else
				{
					echo json_encode(array('msg'=>'Problem in data updation.'));
					exit;
				}
			}
			else
			{
				echo json_encode(array('msg'=>'Password does not match.'));
				exit;
			}
		}
		else
		{
			echo json_encode(array('msg'=>'token is invalid.'));
			exit;
		}
	}
	
	
	public function changepassword()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "tbl_user_master";
		$table_id = 'id';
		
		$new_password = $_POST['new_password'];
		$cnf_password = $_POST['password'];
		$old_password = $_POST['old_password'];
		$id = $_SESSION['webadmin']['id'];
	//	$condition = "token = '".$_POST['token']."' && id= '".$id."' ";
		$condition = " id= '".$id."' && password='".md5($old_password)."'";
			
		$check_name = $db->FunctionFetch($table, 'count', '*', $condition);
	
		if($check_name > 0)
		{
			
			if($new_password == $old_password)
			{	
				echo json_encode(array('msg'=>'New Password and Old Password are same.'));
				exit;
			}
			else if($new_password == $cnf_password)
			{
				$data = array();
				$data['password'] = md5($new_password);
				
				$result = $db->Update($table,$data,$table_id,$id);
				if($result)
				{
					$_SESSION["samajadmin"]['msg']= "Password Change successfully.";		
					$_SESSION["samajadmin"]['msg_type']="1";
					echo json_encode(array('msg'=>'success'));
					exit;
				}
				else
				{	
					echo json_encode(array('msg'=>'Problem in data updation.'));
					exit;
				}
			}
			else
			{	
				echo json_encode(array('msg'=>'New Password and Confirm Password does not match.'));
				exit;
			}
		}
		else
		{	
			echo json_encode(array('msg'=>'Old Password is not correct.'));
			exit;
		}
	}
	
	public function verify()
	{
		$token = $_GET['token'];
		require 'include_classes.php';
  		$db = new Db();
		
		$this->view->login("users/verify");
	}
	public function listing()
	{
		parent::__construct();
		$this->view->login("users/listing");
	}
	
	public function workhistory()
	{
		parent::__construct();
		$this->view->login("users/workhistory");
	}
	
	public function appointment()
	{
		parent::__construct();
		$this->view->login("users/appointment");
	}
	
	public function fetch()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "tbl_user_master";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']." && r.role_id in('3','4') " ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left','tbl_user_clinic_relation r','r.user_id = i.id', array())
		);
		
		$colArray = array('i.first_name','i.last_name','i.email');
	
		$page = $_GET['iDisplayStart'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['iDisplayLength'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['iSortCol_0']) ? strval($colArray[$_GET['iSortCol_0']]) : $default_sort_column;  
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;  
	
		$result = array();
		
		for($i=0;$i<6;$i++)
		{
			if($i==5){
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] = '".$_GET['sSearch_'.$i]."'";
				}
			}else{
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] like '%".$_GET['sSearch_'.$i]."%'";
				}
			}
		}

		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 											// sEcho for display the requested page
		
		$totalRs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));		// count the total no of columns in table		// count the total no of columns in table
		$totalRecords = @mysql_num_rows($totalRs);
		$result["iTotalRecords"] = $totalRecords;									//	iTotalRecords get no of total recors
		$result["iTotalDisplayRecords"]= $totalRecords;									//  iTotalDisplayRecords for display the no of records in data table.
		 
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			//array_push($temp, $count);
			array_push($temp, '<a href="'.SITE_ROOT.'/users/profile?user_id='.$row->id.'"  title="'.$row->first_name." ".$row->last_name.'">'.$row->first_name." ".$row->last_name.'</a>');
			//array_push($temp, $row->last_name);
			array_push($temp, $row->email);
			array_push($temp, $row->phone_no);
			array_push($temp, $row->gender);
			array_push($temp, $row->dob);
			
			$actionCol = "";
			if ($access1->hasPrivilege("AddNewStaff")) {
			$actionCol .='<a href="'.SITE_ROOT.'/users?id='.$row->id.'"  title="Edit"><i class="icon-picture icon-edit"></i>Edit</a>';
			} if ($access1->hasPrivilege("DeleteStaff")) {
			$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteData(\''.$row->id.'\');" title="Delete"><i class="icon-remove-sign"></i>Delete</a>';
			} if ($access1->hasPrivilege("ProfileStaff")) {
			$actionCol .='&nbsp;&nbsp;<a href="'.SITE_ROOT.'/users/profile?user_id='.$row->id.'" title="Profile">Profile</a>';
			}
			array_push($temp, $actionCol);
			array_push($items, $temp);
			//$count++;
		}
		//print_r($items);die;
		$result["aaData"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function fetchpayment()
  	{
  		require 'include_classes.php';
  		$db = new Db();
		$access1 = new PrivilegedUser();
  		$table = "tbl_patient_payments";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		if(isset($_REQUEST['patient_id']))
			$condition = "1=1 && i.patient_id = ".$_REQUEST['patient_id']." && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id'];
		else
			$condition = "1=1 && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id'];
  		
		if(isset($_REQUEST['datetype']))
		{
			if($_REQUEST['datetype']=="today")
				$condition .= "&& STR_TO_DATE(date,'%m/%d/%Y')=CURDATE() ";
			else if($_REQUEST['datetype']=="week")
				$condition .= " && STR_TO_DATE(date,'%m/%d/%Y') between date_sub(now(),INTERVAL 1 WEEK) and now() ";
			else if($_REQUEST['datetype']=="month")
				$condition .= " && STR_TO_DATE(date,'%m/%d/%Y') > (NOW() - INTERVAL 1 MONTH) ";
		}
		
  		$main_table = array("$table i",array("i.*"));
	
		 $join_tables = array(
			array('left','tbl_user_master r','r.id = i.patient_id', array('r.first_name as first_name','r.last_name as last_name','r.email as email','r.phone_no as mobile_no')),
			array('left','tbl_user_master r1','r1.id = i.doctor_id', array('r1.first_name as doc_first_name','r1.last_name as doc_last_name','r1.email as doc_email')),
			array('left','tbl_user_master r2','r2.id = i.created_by', array('r2.first_name as gen_first_name','r2.last_name as gen_last_name'))
		); 
		
		$colArray = array('r.first_name','r.last_name','r.email','r1.first_name','r2.first_name','r2.last_name','r1.last_name','i.status','i.amount','r.phone_no');
	
		$page = $_GET['iDisplayStart'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['iDisplayLength'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['iSortCol_0']) ? strval($colArray[$_GET['iSortCol_0']]) : $default_sort_column;  
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;  
	
		$result = array();
		
		if(isset($_GET['sSearch_0']) && $_GET['sSearch_0']!='')
		{
			$condition .= " && (";
			for($i=0;$i<10;$i++)
			{
					
						if($i == 0)
						$condition .= " $colArray[$i] like '%".$_GET['sSearch_0']."%'";				
						else
						$condition .= " OR $colArray[$i] like '%".$_GET['sSearch_0']."%'";				
					
			}
			$condition .= ")";
		}
		if(isset($_GET['sSearch_2']) && $_GET['sSearch_2']!='')
		{
			$condition .= " && (";
			$condition .= " created_date < ".$_GET['sSearch_2'];
			$condition .= ")";
		}

		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 											// sEcho for display the requested page
		
		$totalRs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));		// count the total no of columns in table		// count the total no of columns in table
		$totalRecords = @mysql_num_rows($totalRs);
		$result["iTotalRecords"] = $totalRecords;									//	iTotalRecords get no of total recors
		$result["iTotalDisplayRecords"]= $totalRecords;									//  iTotalDisplayRecords for display the no of records in data table.
		 
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			//array_push($temp, $count);
			array_push($temp, $row->first_name." ".$row->last_name);
			array_push($temp, $row->mobile_no);
			array_push($temp, $row->amount);
			array_push($temp, $row->item_desc);
			array_push($temp, $row->doc_first_name." ".$row->doc_last_name);
			array_push($temp, $row->gen_first_name." ".$row->gen_last_name);
			array_push($temp, $row->status);
			
			$actionCol = "";
			if ($access1->hasPrivilege("AddNewPayment")) { 
			$actionCol .='<div style="float:left;" class="hideclass" onclick="editbutton('.$row->id.')"><a href="#editpayment" title="Edit" data-toggle="modal"><i class="icon-picture icon-edit"></i></a></div>';
			} if ($access1->hasPrivilege("DeletePayment")) { 
			$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteDataP(\''.$row->id.'\');" title="Delete"><i class="icon-remove-sign"></i></a>';
			}
			$actionCol .='&nbsp;&nbsp;<a target="_blank" href="'.SITE_ROOT.'/invoice/INVOICE'.str_pad($row->id, 8, '0', STR_PAD_LEFT).'.pdf" title="Invoice Download"><i class="icon-download"></i></a>';
			
			
			
			array_push($temp, $actionCol);
			array_push($items, $temp);
			//$count++;
		}
		//print_r($items);die;
		$result["aaData"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function fetchhistory()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "tbl_worked_log";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		if($_SESSION['webadmin1']['role_id']!="2")
		{
			if(isset($_REQUEST['user_id']))
				$condition = "1=1 && i.user_id = ".$_REQUEST['user_id'];
			else
				$condition = "1=1 && i.user_id = ".$_SESSION["samajadmin"]["id"]." && clinic_id = ".$_SESSION['webadmin1']['clinic_id'];
  		}
		else
		{
			$condition = "1=1 && clinic_id = ".$_SESSION['webadmin1']['clinic_id'];
		}
  		$main_table = array("$table i",array("i.*,TIMEDIFF(TIMEDIFF(STR_TO_DATE(i.out_time,'%H:%i'),STR_TO_DATE(i.in_time,'%H:%i')),TIMEDIFF(STR_TO_DATE(i.break_out_time,'%H:%i'),STR_TO_DATE(i.break_in_time,'%H:%i'))) AS hours"));
	
		 $join_tables = array(
			array('left','tbl_user_master r1','r1.id = i.user_id', array('r1.first_name as doc_first_name','r1.last_name as doc_last_name','r1.email as doc_email'))
		); 
		
		$colArray = array('i.first_name','i.last_name','i.email');
		$colArray1 = array('r1.first_name','i.date','i.in_time','i.break_in_time','i.break_out_time','i.out_time');
		$page = $_GET['iDisplayStart'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['iDisplayLength'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['iSortCol_0']) ? strval($colArray1[$_GET['iSortCol_0']]) : $default_sort_column;  
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;  
	
		$result = array();
		
		for($i=0;$i<6;$i++)
		{
			if($i==5){
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] = '".$_GET['sSearch_'.$i]."'";
				}
			}else{
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] like '%".$_GET['sSearch_'.$i]."%'";
				}
			}
		}

		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 											// sEcho for display the requested page
		
		$totalRs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));		// count the total no of columns in table		// count the total no of columns in table
		$totalRecords = @mysql_num_rows($totalRs);
		$result["iTotalRecords"] = $totalRecords;									//	iTotalRecords get no of total recors
		$result["iTotalDisplayRecords"]= $totalRecords;									//  iTotalDisplayRecords for display the no of records in data table.
		 
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			//array_push($temp, $count);
			 if($_SESSION['webadmin1']['role_id']!="3" && $_SESSION['webadmin1']['role_id']!="4"){ 
				array_push($temp, $row->doc_first_name." ".$row->doc_last_name);
			 }
			array_push($temp, $row->date);
			array_push($temp, $row->in_time);
			//array_push($temp, $row->break_in_time);
			//array_push($temp, $row->break_out_time);
			array_push($temp, $row->out_time);
			array_push($temp, $row->hours);
			$actionCol = "";
			if ($access1->hasPrivilege("AddNewWorkHistory")) {
			$actionCol .='<div style="float:left;" class="hideclass" onclick="editbutton('.$row->id.')"><a href="#editpayment" title="Edit" data-toggle="modal"><i class="icon-picture icon-edit"></i></a></div>';
			} if ($access1->hasPrivilege("DeleteWorkHistory")) {
			$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteDataP(\''.$row->id.'\');" title="Delete"><i class="icon-remove-sign"></i></a>';
			}
			array_push($temp, $actionCol);
			array_push($items, $temp);
			//$count++;
		}
		//print_r($items);die;
		$result["aaData"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function fetchprofilehistory()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "tbl_worked_log";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		if(isset($_REQUEST['user_id']))
		$condition = "1=1 && i.user_id = ".$_REQUEST['user_id'];
		else
		$condition = "1=1 && clinic_id = ".$_SESSION['webadmin1']['clinic_id'];
  		
  		$main_table = array("$table i",array("i.*,TIMEDIFF(TIMEDIFF(STR_TO_DATE(i.out_time,'%H:%i'),STR_TO_DATE(i.in_time,'%H:%i')),TIMEDIFF(STR_TO_DATE(i.break_out_time,'%H:%i'),STR_TO_DATE(i.break_in_time,'%H:%i'))) AS hours"));
	
		 $join_tables = array(
			array('left','tbl_user_master r1','r1.id = i.user_id', array('r1.first_name as doc_first_name','r1.last_name as doc_last_name','r1.email as doc_email'))
		); 
		
		$colArray = array('i.first_name','i.last_name','i.email');
	
		$page = $_GET['iDisplayStart'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['iDisplayLength'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['iSortCol_0']) ? strval($colArray[$_GET['iSortCol_0']]) : $default_sort_column;  
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;  
	
		$result = array();
		
		for($i=0;$i<6;$i++)
		{
			if($i==5){
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] = '".$_GET['sSearch_'.$i]."'";
				}
			}else{
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] like '%".$_GET['sSearch_'.$i]."%'";
				}
			}
		}

		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 											// sEcho for display the requested page
		
		$totalRs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));		// count the total no of columns in table		// count the total no of columns in table
		$totalRecords = @mysql_num_rows($totalRs);
		$result["iTotalRecords"] = $totalRecords;									//	iTotalRecords get no of total recors
		$result["iTotalDisplayRecords"]= $totalRecords;									//  iTotalDisplayRecords for display the no of records in data table.
		 
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			//array_push($temp, $count);
			array_push($temp, $row->date);
			array_push($temp, $row->in_time);
			array_push($temp, $row->break_in_time);
			array_push($temp, $row->break_out_time);
			array_push($temp, $row->out_time);
			array_push($temp, $row->hours);
			$actionCol = "";
			if ($access1->hasPrivilege("DeleteWorkHistory")) {
			$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteDataP(\''.$row->id.'\');" title="Delete"><i class="icon-remove-sign"></i></a>';
			}
			array_push($temp, $actionCol);
			array_push($items, $temp);
			//$count++;
		}
		//print_r($items);die;
		$result["aaData"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function fetchhistoryweekly()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$table = "tbl_worked_log";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		if(isset($_REQUEST['user_id']))
		$condition = "1=1 && i.user_id = ".$_REQUEST['user_id'];
		else
		$condition = "1=1 && i.user_id = ".$_SESSION['webadmin']['id']." && clinic_id = ".$_SESSION['webadmin1']['clinic_id'];
  		
  		$main_table = array("$table i",array("i.*,WEEK(STR_TO_DATE(date,'%m/%d/%Y'))AS weeks,SEC_TO_TIME( SUM( TIME_TO_SEC(TIMEDIFF(TIMEDIFF(STR_TO_DATE(out_time,'%H:%i'),STR_TO_DATE(in_time,'%H:%i')),TIMEDIFF(STR_TO_DATE(i.break_out_time,'%H:%i'),STR_TO_DATE(i.break_in_time,'%H:%i')))))) AS hours,adddate(STR_TO_DATE(date,'%m/%d/%Y'), INTERVAL 1-DAYOFWEEK(STR_TO_DATE(date,'%m/%d/%Y')) DAY) WeekStart, adddate(STR_TO_DATE(date,'%m/%d/%Y'), INTERVAL 7-DAYOFWEEK(STR_TO_DATE(date,'%m/%d/%Y')) DAY) WeekEnd"));
	
		 $join_tables = array(
			array('left','tbl_user_master r1','r1.id = i.user_id', array('r1.first_name as doc_first_name','r1.last_name as doc_last_name','r1.email as doc_email'))
		); 
		
		$colArray = array('i.first_name','i.last_name','i.email');
	
		$page = $_GET['iDisplayStart'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['iDisplayLength'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['iSortCol_0']) ? strval($colArray[$_GET['iSortCol_0']]) : $default_sort_column;  
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;  
	
		$result = array();
		
		for($i=0;$i<6;$i++)
		{
			if($i==5){
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] = '".$_GET['sSearch_'.$i]."'";
				}
			}else{
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] like '%".$_GET['sSearch_'.$i]."%'";
				}
			}
		}

		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 											// sEcho for display the requested page
		
		$totalRs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));		// count the total no of columns in table		// count the total no of columns in table
		$totalRecords = @mysql_num_rows($totalRs);
		$result["iTotalRecords"] = $totalRecords;									//	iTotalRecords get no of total recors
		$result["iTotalDisplayRecords"]= $totalRecords;									//  iTotalDisplayRecords for display the no of records in data table.
		 
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			//array_push($temp, $count);
			if($row->hours!="")
			{
			array_push($temp, $row->WeekStart.' to '.$row->WeekEnd);
			array_push($temp, $row->hours);
			
			array_push($items, $temp);
			}
			//$count++;
		}
		//print_r($items);die;
		$result["aaData"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function addhours()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "tbl_worked_log";
		$table_id = 'id';
		$_POST['clinic_id']= $_SESSION["webadmin1"]["clinic_id"];
		$_POST['user_id']= $_SESSION["samajadmin"]['id'];
		$date = new DateTime();
		$modified_date = $date->format('Y-m-d H:i:s');
		$_POST['modified_date']= $modified_date;
		$result1 = $db->Insert($table, $_POST, 1);
		if($result1)
		{
			$_SESSION["samajadmin"]['msg']= "Hours Submitted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg'=>'Problem in data insert.'));
			exit;
		}
	}
	
	public function fetchattachment()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "tbl_attachment";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		if(isset($_REQUEST['patient_id']))
		$condition = "1=1 && i.patient_id = ".$_REQUEST['patient_id'];
		else
		$condition = "1=1 && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id'];
  		
  		$main_table = array("$table i",array("i.*"));
	
		 $join_tables = array(
			array('left','tbl_user_master r','r.id = i.patient_id', array('r.first_name as first_name','r.last_name as last_name','r.email as email','r.phone_no as phone_no')),
			array('left','tbl_user_master r2','r2.id = i.created_by', array('r2.first_name as gen_first_name','r2.last_name as gen_last_name'))
		); 
		
		$colArray = array();
	
		$page = $_GET['iDisplayStart'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['iDisplayLength'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['iSortCol_0']) ? strval($colArray[$_GET['iSortCol_0']]) : $default_sort_column;  
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;  
	
		$result = array();
		
		for($i=0;$i<6;$i++)
		{
			if($i==5){
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] = '".$_GET['sSearch_'.$i]."'";
				}
			}else{
				if(isset($_GET['sSearch_'.$i]) && $_GET['sSearch_'.$i]!='')
				{
					$condition .= " && $colArray[$i] like '%".$_GET['sSearch_'.$i]."%'";
				}
			}
		}

		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 											// sEcho for display the requested page
		
		$totalRs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));		// count the total no of columns in table		// count the total no of columns in table
		$totalRecords = @mysql_num_rows($totalRs);
		$result["iTotalRecords"] = $totalRecords;									//	iTotalRecords get no of total recors
		$result["iTotalDisplayRecords"]= $totalRecords;									//  iTotalDisplayRecords for display the no of records in data table.
		 
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			//array_push($temp, $count);
			array_push($temp, '<div style="float:left;"><input type="checkbox" value="'.$row->id.'" name="attachment_id" ></div>');
			array_push($temp, '<a href="'.BASEPATH.'/attachment/'.$row->attachment.'"  target="_blank" title="Attachment" data-toggle="modal"><i class="icon-picture icon-edit"></i></a>');
			array_push($temp, $row->first_name." ".$row->last_name);
			array_push($temp, $row->created_date);
			//array_push($temp, $row->gen_first_name." ".$row->gen_last_name);
			$actionCol = "";
			if ($access1->hasPrivilege("AddNewAttachment")) {
			$actionCol .='<div style="float:left;" class="hideclass" onclick="editbutton('.$row->id.')"><a href="#editpayment" title="Edit" data-toggle="modal"><i class="icon-picture icon-edit"></i></a></div>';
			} if ($access1->hasPrivilege("DeleteAttachement")) {
			$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteData(\''.$row->id.'\');" title="Delete"><i class="icon-remove-sign"></i></a>';
			}
			array_push($temp, $actionCol);
			array_push($items, $temp);
			//$count++;
		}
		//print_r($items);die;
		$result["aaData"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function addpayment()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		require 'classes/makepdf.php';
		
		
  		$db = new Db();
		$table = "tbl_patient_payments";
		$table_id = 'id';
		$_POST['clinic_id']= $_SESSION["webadmin1"]["clinic_id"];
		$_POST['created_by']= $_SESSION["samajadmin"]['id'];
		$date = new DateTime();
		$modified_date = $date->format('Y-m-d H:i:s');
		$_POST['modified_date']= $modified_date;
		$result1 = $db->Insert($table, $_POST, 1);
		$invoice = 'INVOICE'.str_pad($result1, 8, '0', STR_PAD_LEFT);
		$patientid = 'VTR1'.str_pad($_POST[patient_id], 8, '0', STR_PAD_LEFT);
		$invoicedate = date_create_from_format('m/d/Y', $_REQUEST['date']);
		$temp['start'] = $invoicedate->format('Y-m-d H:i:s');
		$patienobj = $db->FetchToArray("tbl_user_master", "*","id = '$_POST[patient_id]'");
		$html = "";
		if($result1)
		{
			$msg =  '<div class="invoice-box" style="max-width:800px;margin:auto;padding:30px;border:1px solid #eee;box-shadow:0 0 10px rgba(0, 0, 0, .15);font-size:16px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;"><table cellpadding="0" cellspacing="0" style="width:100%;line-height:inherit;text-align:left;"><tr class="top"><td style="padding:5px;vertical-align:top;" colspan="2"><table style="width:100%;line-height:inherit;text-align:left;"><tr><td  style="padding:5px;vertical-align:top;"class="title" style="font-size:45px;line-height:45px;color:#333;"><label style="font-size: 24px;color: #23527c;font-weight: bold;">Vettree Files</label></td><td style="padding:5px;vertical-align:top;text-align:right;">Invoice #: '.$invoice.'<br>Date: '.$date->format('d-M-Y').'<br>Invoice Date:'.$invoicedate->format('d-M-Y').'</td></tr></table></td></tr><tr class="information"><td style="padding:5px;vertical-align:top;" colspan="2"><table style="width:100%;line-height:inherit;text-align:left;"><tr><td style="padding-bottom:40px;">Patient Details</td><td style="padding-bottom:40px;text-align:right;">'.$patienobj[0]['first_name'].' '.$patienobj[0]['last_name'].'('.$patientid.')<br>'.$patienobj[0]['address'].'<br/>'.$patienobj[0]['street'].'<br/>'.$patienobj[0]['city'].' '.$patienobj[0]['province'].'<br/>'.$patienobj[0]['country'].' '.$patienobj[0]['pincode'].'<br>'.$patienobj[0]['phone_no'].'<br>'.$patienobj[0]['email'].'</td></tr></table></td></tr><tr class="heading"><td style="background:#eee;border-bottom:1px solid #ddd;font-weight:bold;padding:5px;">Payment Method</td><td style="background:#eee;border-bottom:1px solid #ddd;font-weight:bold;text-align:right;">'.$_POST['payment_method'].'</td></tr><tr class="details"><td style="padding-bottom:20px;padding:5px;">&nbsp;</td><td style="padding-bottom:20px;text-align:right;padding:5px;">&nbsp;</td></tr><tr class="heading"><td style="padding:5px;background:#eee;border-bottom:1px solid #ddd;font-weight:bold;">Item</td><td style="padding:5px;text-align:right;background:#eee;border-bottom:1px solid #ddd;font-weight:bold;">Price</td></tr><tr class="item"><td style="padding:5px;border-bottom:1px solid #eee;">'.$_POST['item_desc'].'</td><td style="padding:5px;text-align:right;">'.$_REQUEST['amount'].'</td></tr><tr class="total"><td style="padding:5px;"></td><td style="text-align:right;padding:5px;">Total: '.$_REQUEST['amount'].'</td></tr></table></div>';
			
			
			$html= "<div style='max-width:800px;margin:auto;padding:30px;border:1px solid #eee;box-shadow:0 0 10px rgba(0, 0, 0, .15);font-size:16px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;'><table cellpadding='10px' style='width:100%;color:black;'><br><tr><td><h2 style='font-size: 24px;color: #23527c;font-weight: bold;'>Vettree Files</h2></td><td align=right >Invoice #: ".$invoice."<br>Date: ".$date->format('d-M-Y')."<br>Invoice Date:".$invoicedate->format('d-M-Y')."</td></tr><tr><td style='padding-bottom:40px;'>Patient Details</td><td align=right>".$patienobj[0]['first_name']." ".$patienobj[0]['last_name']."(".$patientid.")<br>".$patienobj[0]['address']."<br/>".$patienobj[0]['street']."<br/>".$patienobj[0]['city']." ".$patienobj[0]['province']."<br/>".$patienobj[0]['country']." ".$patienobj[0]['pincode']."<br>".$patienobj[0]['phone_no']."<br>".$patienobj[0]['email']."</td></tr><tr ><td style='background:#eee;border-bottom:1px solid #ddd;font-weight:bold;padding:5px;'>Payment Method</td><td style='background:#eee;border-bottom:1px solid #ddd;font-weight:bold;text-align:right;'>".$_POST['payment_method']."</td></tr><tr><td style='padding-bottom:20px;padding:5px;'>&nbsp;</td><td style='padding-bottom:20px;text-align:right;padding:5px;'>&nbsp;</td></tr><tr><td style='padding:5px;background:#eee;border-bottom:1px solid #ddd;font-weight:bold;'>Item</td><td style='padding:5px;text-align:right;background:#eee;border-bottom:1px solid #ddd;font-weight:bold;'>Price</td></tr><tr><td style='padding:5px;border-bottom:1px solid #eee;'>".$_POST['item_desc']."</td><td style='padding:5px;text-align:right;'>".$_REQUEST['amount']."</td></tr><tr><td style='padding:5px;'></td><td style='text-align:right;padding:5px;'>Total: ".$_REQUEST['amount']."</td></tr></table></div>";
			
			sMail($patienobj[0]['email'],$patienobj[0]['first_name']." ".$patienobj[0]['last_name'], "Invoice", $msg);
			makepdf($html,$invoice);
			$_SESSION["samajadmin"]['msg']= "Payment Submitted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg'=>'Problem in Review.'));
			exit;
		}
	}
	
	public function addattachment()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "tbl_attachment";
		$table_id = 'id';
		$_POST['clinic_id']= $_SESSION['webadmin1']['clinic_id'];
		$date = new DateTime();
		$modified_date = $date->format('Y-m-d H:i:s');
		
				if ($_FILES['thumbnail']['size'] > 0 && $_FILES['thumbnail']['error'] == 0)
				{
					//echo "UPDATE IF:::";
					 $target_dir = SITE_ROOT."/attachment/";
					$file_name = time()."_".str_replace(" ","_",basename($_FILES["thumbnail"]["name"]));
                    $target_file = $target_dir . $file_name;
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					$imageFileType = strtolower($imageFileType);
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
                        if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            $uploadOk = 0;
                            echo json_encode(array('msg'=>'File is not an image.'));
                            exit;
                        }
                    }
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $uploadOk = 0;
                        echo json_encode(array('msg'=>'Sorry, file already exists.'));
                        exit;
                    }
                    // Check file size 5 MB  : 5*1024*1024
                    if ($_FILES["thumbnail"]["size"] > 3010000) {
                        $uploadOk = 0;
                        echo json_encode(array('msg'=>'Sorry, your file is too large. The maximum file size limit is 3 MB.'));
                        exit;
                    }
                    // Allow certain file formats
                    /*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        echo json_encode(array('msg'=>'Please upload product\'s image. <br/>Allowed image types JPG, JPEG, PNG & GIF'));
                        $uploadOk = 0;
                        exit;
                    }*/
                    //echo "Check if $uploadOk is set to 0 by an error";
                    if ($uploadOk == 0) {
                        echo json_encode(array('msg'=>'Sorry, your file was not uploaded.'));
                        exit;
                    // if everything is ok, try to upload file
                    } else {
						$_POST['created_by'] = $_SESSION['webadmin']['id'];
						$result = $db->Update($table, $_POST, $table_id,$_POST[$table_id]);	
						//echo $target_file;
						try
						{	if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
								 $_POST['attachment'] = $file_name;
							} else {
								echo json_encode(array('msg'=>'Sorry, there was an error uploading your file.'));
								exit;
							}
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
						}
					}
					
				} else {
					echo json_encode(array('msg'=>'Sorry, there was an error uploading your file.'));
					exit;
				}
		
		
		$_POST['modified_date']= $modified_date;
		//print_r($_POST);
		//exit;
		$result1 = $db->Insert($table, $_POST, 1);
		if($result1)
		{
			$_SESSION["samajadmin"]['msg']= "Attachment Added successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg'=>'Problem in Review.'));
			exit;
		}
	}
	
	public function editattachemnt()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "tbl_attachment";
		$table_id = 'id';
		
		$date = new DateTime();
		$modified_date = $date->format('Y-m-d H:i:s');
		$data['modified_date']= $modified_date;
		$data['patient_id']= $_REQUEST['edit_patient_id'];
		
		if ($_FILES['edit_thumbnail']['size'] > 0 && $_FILES['edit_thumbnail']['error'] == 0)
		{
			//echo "UPDATE IF:::";
			 $target_dir = SITE_ROOT."/attachment/";
			$file_name = time()."_".str_replace(" ","_",basename($_FILES["edit_thumbnail"]["name"]));
			$target_file = $target_dir . $file_name;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			$imageFileType = strtolower($imageFileType);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["edit_thumbnail"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					$uploadOk = 0;
					echo json_encode(array('msg'=>'File is not an image.'));
					exit;
				}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				$uploadOk = 0;
				echo json_encode(array('msg'=>'Sorry, file already exists.'));
				exit;
			}
			// Check file size 5 MB  : 5*1024*1024
			if ($_FILES["edit_thumbnail"]["size"] > 3010000) {
				$uploadOk = 0;
				echo json_encode(array('msg'=>'Sorry, your file is too large. The maximum file size limit is 3 MB.'));
				exit;
			}
			// Allow certain file formats
			/*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				echo json_encode(array('msg'=>'Please upload product\'s image. <br/>Allowed image types JPG, JPEG, PNG & GIF'));
				$uploadOk = 0;
				exit;
			}*/
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo json_encode(array('msg'=>'Sorry, your file was not uploaded.'));
				exit;
			// if everything is ok, try to upload file
			} else {
				$result = $db->Update($table, $_POST, $table_id,$_POST[$table_id]);	
				if (move_uploaded_file($_FILES["edit_thumbnail"]["tmp_name"], $target_file)) {
					 $data['attachment'] = $file_name;
				}
			}
			
		}
		$data['id'] = $_REQUEST['edit_id'];
		$result2 = $db->Update($table,$data,"id",$_POST['edit_id']);
		if($result2)
		{
			$_SESSION["samajadmin"]['msg']= "Attachment Updated successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg'=>'Problem in Review.'));
			exit;
		}
	}
	
	public function editpayment()
	{
		require 'include_classes.php';
		require 'classes/makepdf.php';
		
  		$db = new Db();
		$table = "tbl_patient_payments";
		$table_id = 'id';
		
		$date = new DateTime();
		$modified_date = $date->format('Y-m-d H:i:s');
		$data['id']= $_POST['edit_id'];
		$data['date']= $_POST['edit_date'];
		$data['amount']= $_POST['edit_amount'];
		$data['doctor_id']= $_POST['edit_doctor_id'];
		$data['patient_id']= $_POST['edit_patient_id'];
		$data['payment_method']= $_POST['edit_payment_method'];
		$data['status']= $_POST['edit_status'];
		$data['item_desc']= $_POST['edit_item_desc'];
		$data['modified_date']= $modified_date;
		$invoice = 'INVOICE'.str_pad($_POST['edit_id'], 8, '0', STR_PAD_LEFT);
		$patienobj = $db->FetchToArray("tbl_user_master", "*","id = '$_POST[edit_patient_id]'");
		$invoicedate = date_create_from_format('m/d/Y', $_REQUEST['edit_date']);
		
		$result2 = $db->Update($table,$data,"id",$_POST['edit_id']);
		if($result2)
		{
			unlink(DOC_ROOT.'/invoice/INVOICE'.str_pad($_POST['edit_id'], 8, '0', STR_PAD_LEFT).'.pdf');
			
			$html= "<div style='max-width:800px;margin:auto;padding:30px;border:1px solid #eee;box-shadow:0 0 10px rgba(0, 0, 0, .15);font-size:16px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;'><table cellpadding='10px' style='width:100%;color:black;'><br><tr><td><h2 style='font-size: 24px;color: #23527c;font-weight: bold;'>Vettree Files</h2></td><td align=right >Invoice #: ".$invoice."<br>Date: ".$date->format('d-M-Y')."<br>Invoice Date:".$invoicedate->format('d-M-Y')."</td></tr><tr><td style='padding-bottom:40px;'>Patient Details</td><td align=right>".$patienobj[0]['first_name']." ".$patienobj[0]['last_name']."(".$_POST[edit_patient_id].")<br>".$patienobj[0]['address']."<br/>".$patienobj[0]['street']."<br/>".$patienobj[0]['city']." ".$patienobj[0]['province']."<br/>".$patienobj[0]['country']." ".$patienobj[0]['pincode']."<br>".$patienobj[0]['phone_no']."<br>".$patienobj[0]['email']."</td></tr><tr ><td style='background:#eee;border-bottom:1px solid #ddd;font-weight:bold;padding:5px;'>Payment Method</td><td style='background:#eee;border-bottom:1px solid #ddd;font-weight:bold;text-align:right;'>".$_POST['edit_payment_method']."</td></tr><tr><td style='padding-bottom:20px;padding:5px;'>&nbsp;</td><td style='padding-bottom:20px;text-align:right;padding:5px;'>&nbsp;</td></tr><tr><td style='padding:5px;background:#eee;border-bottom:1px solid #ddd;font-weight:bold;'>Item</td><td style='padding:5px;text-align:right;background:#eee;border-bottom:1px solid #ddd;font-weight:bold;'>Price</td></tr><tr><td style='padding:5px;border-bottom:1px solid #eee;'>".$_POST['edit_item_desc']."</td><td style='padding:5px;text-align:right;'>".$_POST['edit_amount']."</td></tr><tr><td style='padding:5px;'></td><td style='text-align:right;padding:5px;'>Total: ".$_POST['edit_amount']."</td></tr></table></div>";
			
			makepdf($html,$invoice);
			$_SESSION["samajadmin"]['msg']= "Payment Updated successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg'=>'Problem in update.'));
			exit;
		}
	}
	
	public function editappointment()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "tbl_appointments";
		$table_id = 'id';
		
		$date = new DateTime();
		$modified_date = $date->format('Y-m-d H:i:s');
		$data['id']= $_POST['edit_id'];
		$data['date']= $_POST['edit_date'];
		$data['time_slot_start']= $_POST['edit_time_slot_start'];
		$data['doctor_id']= $_POST['edit_doctor_id'];
		$data['patient_id']= $_POST['edit_patient_id'];
		$data['time_slot_end']= $_POST['edit_time_slot_end'];
	
		if(isset($_POST['edit_flag']) && $_POST['edit_flag']==1)
			$data['flag']= $_POST['edit_flag'];
		else
			$data['flag']= "";
	
		$data['modified_date']= $modified_date;
		
		$result2 = $db->Update($table,$data,"id",$_POST['edit_id']);
		if($result2)
		{
			$_SESSION["samajadmin"]['msg']= "Appointment Updated successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg'=>'Problem in update.'));
			exit;
		}
	}
	
	public function edithours()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "tbl_worked_log";
		$table_id = 'id';
		
		$date = new DateTime();
		$modified_date = $date->format('Y-m-d H:i:s');
		$data['id']= $_POST['edit_id'];
		$data['date']= $_POST['edit_date'];
		$data['in_time']= $_POST['edit_in_time'];
		$data['out_time']= $_POST['edit_out_time'];
		$data['break_in_time']= $_POST['edit_break_in_time'];
		$data['break_out_time']= $_POST['edit_break_out_time'];
		$data['modified_date']= $modified_date;
		
		$result2 = $db->Update($table,$data,"id",$_POST['edit_id']);
		if($result2)
		{
			$_SESSION["samajadmin"]['msg']= "Payment Updated successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg'=>'Problem in Review.'));
			exit;
		}
	}
	public function profile()
	{
		parent::__construct();
		$this->view->login("users/profile");
		require 'include_classes.php';
	}
	
	public function deletepayment()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		
  		$table = "tbl_patient_payments";
		$table_id = 'id';
  		$id = $_GET['id'];
  		
  		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
  		
  		if($db->delete($table,$table_id,$id))
		{
			//$db->captureLog($_SESSION["samajadmin"]["user_id"], $table, $id, $old_data[0], "", "Delete");
			$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
		}
		else
		{
			$_SESSION["samajadmin"]['msg']= "Record deletion fails.";
			$_SESSION["samajadmin"]['msg_type']="0";
		}
		
		$core->RedirectTo(SITE_ROOT."/users/payment");
		
  	}
	
	public function deleteappointment()
  	{
  		require 'include_classes.php';
		require 'classes/sMail.php';
  		$db = new Db();
  		
  		$table = "tbl_appointments";
		$table_id = 'id';
  		$id = $_GET['id'];
  		
  		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
  		$patienobj = $db->FetchToArray("tbl_user_master", "*","id = '".$old_data[0]["patient_id"]."'");
		$doctorobj = $db->FetchToArray("tbl_user_master", "*","id = '".$old_data[0][doctor_id]."'");
		$timestartobj = $db->FetchToArray("tbl_timeslots", "*","id = '".$old_data[0][time_slot_start]."'");
		$timeendobj = $db->FetchToArray("tbl_timeslots", "*","id = '".$old_data[0][time_slot_end]."'");
  		if($db->delete($table,$table_id,$id))
		{
			//$db->captureLog($_SESSION["samajadmin"]["user_id"], $table, $id, $old_data[0], "", "Delete");
			$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
			$msg1 = '<table class="body-wrap" bgcolor="#f6f6f6" style="font-family:  Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0 auto; padding: 0px;max-width:600px;background:url(\'http://vettreefiles.com/images/email_bg.png\');text-align:center; border: 1px solid #015b7e;" cellpadding=0 cellspacing=0><tr><td colspan=2 style="padding: 20px;"><a href="http://www.vettreefiles.com/"><img src="http://vettreefiles.com/images/logo.png"/ style="float:left;"></a><a href="http://www.vettreefiles.com/features" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">FEATURES</a><a href="http://www.vettreefiles.com/pricing" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">PRICING</a><a href="http://www.vettreefiles.com/testimonials" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">TESTIMONIALS</a><a href="http://www.vettreefiles.com/contact" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">CONTACT</a></td></tr><tr style="background:url(\'http://vettreefiles.com/images/email_banner.png\');background-size:100% 100%;"><td colspan=2 ><h1 style="text-align:center;text-transform:uppercase;color:white;margin-top: 75px;">Appointment Cancellation</h1></td></tr><tr style="background:white;"><td colspan=2 style="padding: 20px;"><p style="text-align:center;margin-top: 40px;color:#333;">Hi,'.$patienobj[0]['first_name'].' '.$patienobj[0]['last_name'].'!</p><p style="text-align:center;color:#333;">Your Appointment on the '.$old_data[0]['date'].' at '.$timestartobj[0]['times'].' time is cancelled.</p></td></tr><tr bgcolor="#015B7E" style="text-align:center;"><td colspan=2 style="padding-bottom: 20px;padding-top: 20px;"><img src="http://vettreefiles.com/images/logo.png"/><p><a href="http://www.vettreefiles.com/features" style="color:white;padding-left:5px;text-decoration:none;">FEATURES</a><a href="http://www.vettreefiles.com/pricing" style="color:white;padding-left:15px;text-decoration:none;">PRICING</a><a href="http://www.vettreefiles.com/testimonials" style="color:white;padding-left:15px;text-decoration:none;">TESTIMONIALS</a><a href="http://www.vettreefiles.com/contact" style="color:white;padding-left:15px;text-decoration:none;">CONTACT</a></p><p style="text-align:center;margin-bottom: 25px;margin-top: 25px;"><a href="https://www.facebook.com/vaultify/"><img src="http://vettreefiles.com/images/fa-facebook-square.png" ></a><a href="https://www.instagram.com/vaultify/"><img src="http://vettreefiles.com/images/fa-instagram.png" style="padding-left:15px;"></a><a href="https://www.twitter.com/Vaultifyapp"><img src="http://vettreefiles.com/images/fa-twitter-.png" style="padding-left:15px;"></a><a href="#"><img src="http://vettreefiles.com/images/fa-google-plus.png" style="padding-left:15px;"></a></p><p style="text-align:center;color:white;">&copy; 2016 <a style="color:white" href="http://www.vettreefiles.com/">vaultify.io</a>  All Rights Reserved</p></td></tr></table>';
			
			$msg2 = '<table class="body-wrap" bgcolor="#f6f6f6" style="font-family:  Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0 auto; padding: 0px;max-width:600px;background:url(\'http://vettreefiles.com/images/email_bg.png\');text-align:center; border: 1px solid #015b7e;" cellpadding=0 cellspacing=0><tr><td colspan=2 style="padding: 20px;"><a href="http://www.vettreefiles.com/"><img src="http://vettreefiles.com/images/logo.png"/ style="float:left;"></a><a href="http://www.vettreefiles.com/features" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">FEATURES</a><a href="http://www.vettreefiles.com/pricing" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">PRICING</a><a href="http://www.vettreefiles.com/testimonials" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">TESTIMONIALS</a><a href="http://www.vettreefiles.com/contact" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">CONTACT</a></td></tr><tr style="background:url(\'http://vettreefiles.com/images/email_banner.png\');background-size:100% 100%;"><td colspan=2 ><h1 style="text-align:center;text-transform:uppercase;color:white;margin-top: 75px;">Appointment Cancellation</h1></td></tr><tr style="background:white;"><td colspan=2 style="padding: 20px;"><p style="text-align:center;margin-top: 40px;color:#333;">Hi,'.$doctorobj[0]['first_name'].' '.$doctorobj[0]['last_name'].'!</p><p style="text-align:center;color:#333;">Your Appointment on the '.$old_data[0]['date'].' at '.$timestartobj[0]['times'].' time is cancelled.</p></td></tr><tr bgcolor="#015B7E" style="text-align:center;"><td colspan=2 style="padding-bottom: 20px;padding-top: 20px;"><img src="http://vettreefiles.com/images/logo.png"/><p><a href="http://www.vettreefiles.com/features" style="color:white;padding-left:5px;text-decoration:none;">FEATURES</a><a href="http://www.vettreefiles.com/pricing" style="color:white;padding-left:15px;text-decoration:none;">PRICING</a><a href="http://www.vettreefiles.com/testimonials" style="color:white;padding-left:15px;text-decoration:none;">TESTIMONIALS</a><a href="http://www.vettreefiles.com/contact" style="color:white;padding-left:15px;text-decoration:none;">CONTACT</a></p><p style="text-align:center;margin-bottom: 25px;margin-top: 25px;"><a href="https://www.facebook.com/vaultify/"><img src="http://vettreefiles.com/images/fa-facebook-square.png" ></a><a href="https://www.instagram.com/vaultify/"><img src="http://vettreefiles.com/images/fa-instagram.png" style="padding-left:15px;"></a><a href="https://www.twitter.com/Vaultifyapp"><img src="http://vettreefiles.com/images/fa-twitter-.png" style="padding-left:15px;"></a><a href="#"><img src="http://vettreefiles.com/images/fa-google-plus.png" style="padding-left:15px;"></a></p><p style="text-align:center;color:white;">&copy; 2016 <a style="color:white" href="http://www.vettreefiles.com/">vaultify.io</a>  All Rights Reserved</p></td></tr></table>';
			
			sMail($patienobj[0]['email'],$patienobj[0]['first_name']." ".$patienobj[0]['last_name'], "Appointment Cancellation", $msg1);
			sMail($doctorobj[0]['email'],$doctorobj[0]['first_name']." ".$doctorobj[0]['last_name'], "Appointment Cancellation", $msg2);
			
			
		}
		else
		{
			$_SESSION["samajadmin"]['msg']= "Record deletion fails.";
			$_SESSION["samajadmin"]['msg_type']="0";
		}
		$core->RedirectTo(SITE_ROOT."/users/appointment_details");
		
  	}
	
	public function deletehours()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		
  		$table = "tbl_worked_log";
		$table_id = 'id';
  		$id = $_GET['id'];
  		
  		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
  		
  		if($db->delete($table,$table_id,$id))
		{
			//$db->captureLog($_SESSION["samajadmin"]["user_id"], $table, $id, $old_data[0], "", "Delete");
			$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
		}
		else
		{
			$_SESSION["samajadmin"]['msg']= "Record deletion fails.";
			$_SESSION["samajadmin"]['msg_type']="0";
		}
		
		if(!isset($_REQUEST['user_id']))
		$core->RedirectTo(SITE_ROOT."/users/workhistory");
		echo 
		$core->RedirectTo(SITE_ROOT."/users/profile?user_id=".$_REQUEST['user_id']);
		
  	}
	
	public function deleteattachment()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		
  		$table = "tbl_attachment";
		$table_id = 'id';
  		$id = $_GET['id'];
  		
  		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
  		
  		if($db->delete($table,$table_id,$id))
		{
			//$db->captureLog($_SESSION["samajadmin"]["user_id"], $table, $id, $old_data[0], "", "Delete");
			$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
		}
		else
		{
			$_SESSION["samajadmin"]['msg']= "Record deletion fails.";
			$_SESSION["samajadmin"]['msg_type']="0";
		}
		
		$core->RedirectTo(SITE_ROOT."/users/attachment");
		
  	}
	
	public function fetchPaymentDetails()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		
  		$table = "tbl_patient_payments";
		$table_id = 'id';
  		$id = $_REQUEST['id'];
  		
  		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		echo json_encode($old_data[0]);
		exit;
  	}
	
	public function fetchAppDetails()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		
  		$table = "tbl_appointments";
		$table_id = 'id';
  		$id = $_REQUEST['id'];
  		
  		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		echo json_encode($old_data[0]);
		exit;
  	}
	
	public function fetchlogs()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		
  		$table = "tbl_worked_log";
		$table_id = 'id';
  		$id = $_REQUEST['id'];
  		
  		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		echo json_encode($old_data[0]);
		exit;
  	}
	
	public function fetchAttachmentDetails()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		
  		$table = "tbl_attachment";
		$table_id = 'id';
  		$id = $_REQUEST['id'];
  		
  		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		echo json_encode($old_data[0]);
		exit;
  	}
	
	public function delete()
   {
		require 'include_classes.php';
		$db = new Db();
		
		$table = "tbl_user_master";
		$table_id = 'id';
		$id = $_GET['id'];
		
		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		//$db->delete('tbl_user_clinic_relation','patient_id',$id);
		
	  if($db->delete($table,$table_id,$id))
	  {
	   //$db->captureLog($_SESSION["samajadmin"]["user_id"], $table, $id, $old_data[0], "", "Delete");
	   $_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
	   $_SESSION["samajadmin"]['msg_type']="1";
	  }
	  else
	  {
	   $_SESSION["samajadmin"]['msg']= "Record deletion fails.";
	   $_SESSION["samajadmin"]['msg_type']="0";
	  }
	  
	  $core->RedirectTo(SITE_ROOT."/users/listing");
  
   }
   
   public function fetchAppointment()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "tbl_appointments";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'desc';
		$condition = "1=1 && i.clinic_id = '".$_SESSION['webadmin1']['clinic_id']."' ";
  		if($_SESSION['webadmin1']['role_id'] == PATIENT_ROLE)
			$condition .= " && i.patient_id = '".$_SESSION['webadmin']['id']."' ";
		
		if(isset($_REQUEST['doctor']))
			$condition .= " && i.doctor_id = '".$_REQUEST['doctor']."' ";
		
  		$main_table = array("$table i",array("i.*"));
	
		$join_tables = array(
			array('left','tbl_timeslots r','r.id = i.time_slot_start', array('r.times as starttime')),
			array('left','tbl_timeslots r1','r1.id = i.time_slot_end', array('r1.times as endtime')),
			array('left','tbl_user_master r2','r2.id = i.doctor_id', array('r2.first_name as doc_first_name','r2.last_name as doc_last_name')),
			array('left','tbl_user_master r3','r3.id = i.patient_id', array('r3.first_name as patient_fname','r3.last_name as patient_lname','r3.phone_no as mobile_no','r3.gender as patient_gender','r3.age as patient_age'))
		); 
		
		$page = $_GET['iDisplayStart'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['iDisplayLength'];											// iDisplayLength no of records from the offset
		
		$colArray = array('i.date','r.times','r1.times');
		
		// sort order by column
		$sort = isset($_GET['iSortCol_0']) ? strval($colArray[$_GET['iSortCol_0']]) : $default_sort_column;  
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;  
	
		$result = array();
	
		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 											// sEcho for display the requested page
		
		$totalRs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));		// count the total no of columns in table		// count the total no of columns in table
		$totalRecords = @mysql_num_rows($totalRs);
		$result["iTotalRecords"] = $totalRecords;									//	iTotalRecords get no of total recors
		$result["iTotalDisplayRecords"]= $totalRecords;									//  iTotalDisplayRecords for display the no of records in data table.
		 
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			//array_push($temp, $count);
			array_push($temp, $row->date);
			array_push($temp, $row->starttime." to ".$row->endtime);
			array_push($temp, $row->patient_fname." ".$row->patient_lname);
			array_push($temp, $row->patient_age);
			array_push($temp, $row->patient_gender);
			array_push($temp, $row->doc_first_name." ".$row->doc_last_name);
			$actionCol = "";
			$check = "";
			if($row->flag=="1")
				$check = " checked ";
			if ($access1->hasPrivilege("AddNewAppointment")) {
			$actionCol .='<div style="float:left;" onclick="editbutton('.$row->id.')"><input type="checkbox" '.$check.' value="'.$row->id.'"/></div>';
			}
			array_push($temp, $actionCol);
			$actionCol1 = "";
			if ($access1->hasPrivilege("AddNewAppointment")) { 
			$actionCol1 .='<div style="float:left;" class="hideclass" onclick="editbuttonA('.$row->id.')"><a href="#editAppointment" title="Edit" data-toggle="modal"><i class="icon-picture icon-edit"></i></a></div>';
			} if ($access1->hasPrivilege("DeleteAppointment")) { 
			$actionCol1 .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteDataP(\''.$row->id.'\');" title="Delete"><i class="icon-remove-sign"></i></a>';
			}
			array_push($temp, $actionCol1);
			array_push($items, $temp);
			//$count++;
		}
		//print_r($items);die;
		$result["aaData"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function fetchAppointment2()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "tbl_timeslot_master";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'date';
		$default_sort_order = 'desc';
		$condition = "1=1 && i.clinic_id = '".$_SESSION['webadmin1']['clinic_id']."' && i.user_id = '".$_SESSION['webadmin']['id']."' ";
  	
  		$main_table = array("$table i",array("i.*"));
	
		$join_tables = array(
			array('left','tbl_timeslots r','r.id = i.time_slot_start', array('r.times as starttime')),
			array('left','tbl_timeslots r1','r1.id = i.time_slot_end', array('r1.times as endtime')),
			array('left','tbl_user_master r2','r2.id = i.user_id', array('r2.first_name as doc_first_name','r2.last_name as doc_last_name'))
		); 
		
		$page = $_GET['iDisplayStart'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['iDisplayLength'];											// iDisplayLength no of records from the offset
		
		$colArray = array('i.date','r.times','r1.times');
		
		// sort order by column
		$sort = isset($_GET['iSortCol_0']) ? strval($colArray[$_GET['iSortCol_0']]) : $default_sort_column;  
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;  
	
		$result = array();
	
		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 											// sEcho for display the requested page
		
		$totalRs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));		// count the total no of columns in table		// count the total no of columns in table
		$totalRecords = @mysql_num_rows($totalRs);
		$result["iTotalRecords"] = $totalRecords;									//	iTotalRecords get no of total recors
		$result["iTotalDisplayRecords"]= $totalRecords;									//  iTotalDisplayRecords for display the no of records in data table.
		 
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			//array_push($temp, $count);
			array_push($temp, $row->date);
			array_push($temp, $row->starttime);
			array_push($temp, $row->endtime);
			array_push($items, $temp);
			//$count++;
		}
		//print_r($items);die;
		$result["aaData"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function addappointment()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
  		$db = new Db();
		$table = "tbl_appointments";
		$table_id = 'id';
		$_POST['clinic_id']= $_SESSION["webadmin1"]["clinic_id"];
		$date = new DateTime();
		$modified_date = $date->format('Y-m-d H:i:s');
		$_POST['modified_date']= $modified_date;
		$result1 = $db->Insert($table, $_POST, 1);
		$patienobj = $db->FetchToArray("tbl_user_master", "*","id = '$_POST[patient_id]'");
		$doctorobj = $db->FetchToArray("tbl_user_master", "*","id = '$_POST[doctor_id]'");
		$timestartobj = $db->FetchToArray("tbl_timeslots", "*","id = '$_POST[time_slot_start]'");
		$timeendobj = $db->FetchToArray("tbl_timeslots", "*","id = '$_POST[time_slot_end]'");
		//print_r($patienobj);
		//echo $patienobj[0]['email'];
		if($result1)
		{
			
			$_SESSION["samajadmin"]['msg']= "Appointment Submitted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			$msg1 = '<table class="body-wrap" bgcolor="#f6f6f6" style="font-family:  Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0 auto; padding: 0px;max-width:600px;background:url(\'http://vettreefiles.com/images/email_bg.png\');text-align:center; border: 1px solid #015b7e;" cellpadding=0 cellspacing=0><tr><td colspan=2 style="padding: 20px;"><a href="http://www.vettreefiles.com/"><img src="http://vettreefiles.com/images/logo.png"/ style="float:left;"></a><a href="http://www.vettreefiles.com/features" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">FEATURES</a><a href="http://www.vettreefiles.com/pricing" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">PRICING</a><a href="http://www.vettreefiles.com/testimonials" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">TESTIMONIALS</a><a href="http://www.vettreefiles.com/contact" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">CONTACT</a></td></tr><tr style="background:url(\'http://vettreefiles.com/images/email_banner.png\');background-size:100% 100%;"><td colspan=2 ><h1 style="text-align:center;text-transform:uppercase;color:white;margin-top: 75px;">Appointment Reminders</h1></td></tr><tr style="background:white;"><td colspan=2 style="padding: 20px;"><p style="text-align:center;margin-top: 40px;color:#333;">Hi,'.$patienobj[0]['first_name'].' '.$patienobj[0]['last_name'].'!</p><p style="text-align:center;color:#333;">Please Check your Appointment is starting on the '.$_POST['date'].' '.$timestartobj[0]['times'].'</p></td></tr><tr bgcolor="#015B7E" style="text-align:center;"><td colspan=2 style="padding-bottom: 20px;padding-top: 20px;"><img src="http://vettreefiles.com/images/logo.png"/><p><a href="http://www.vettreefiles.com/features" style="color:white;padding-left:5px;text-decoration:none;">FEATURES</a><a href="http://www.vettreefiles.com/pricing" style="color:white;padding-left:15px;text-decoration:none;">PRICING</a><a href="http://www.vettreefiles.com/testimonials" style="color:white;padding-left:15px;text-decoration:none;">TESTIMONIALS</a><a href="http://www.vettreefiles.com/contact" style="color:white;padding-left:15px;text-decoration:none;">CONTACT</a></p><p style="text-align:center;margin-bottom: 25px;margin-top: 25px;"><a href="https://www.facebook.com/vaultify/"><img src="http://vettreefiles.com/images/fa-facebook-square.png" ></a><a href="https://www.instagram.com/vaultify/"><img src="http://vettreefiles.com/images/fa-instagram.png" style="padding-left:15px;"></a><a href="https://www.twitter.com/Vaultifyapp"><img src="http://vettreefiles.com/images/fa-twitter-.png" style="padding-left:15px;"></a><a href="#"><img src="http://vettreefiles.com/images/fa-google-plus.png" style="padding-left:15px;"></a></p><p style="text-align:center;color:white;">&copy; 2016 <a style="color:white" href="http://www.vettreefiles.com/">vaultify.io</a>  All Rights Reserved</p></td></tr></table>';
			
			$msg2 = '<table class="body-wrap" bgcolor="#f6f6f6" style="font-family:  Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0 auto; padding: 0px;max-width:600px;background:url(\'http://vettreefiles.com/images/email_bg.png\');text-align:center; border: 1px solid #015b7e;" cellpadding=0 cellspacing=0><tr><td colspan=2 style="padding: 20px;"><a href="http://www.vettreefiles.com/"><img src="http://vettreefiles.com/images/logo.png"/ style="float:left;"></a><a href="http://www.vettreefiles.com/features" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">FEATURES</a><a href="http://www.vettreefiles.com/pricing" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">PRICING</a><a href="http://www.vettreefiles.com/testimonials" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">TESTIMONIALS</a><a href="http://www.vettreefiles.com/contact" style="float: right; padding-left: 20px; text-decoration: none; color: white; font-size: 12px; padding-top: 15px;">CONTACT</a></td></tr><tr style="background:url(\'http://vettreefiles.com/images/email_banner.png\');background-size:100% 100%;"><td colspan=2 ><h1 style="text-align:center;text-transform:uppercase;color:white;margin-top: 75px;">Appointment Reminders</h1></td></tr><tr style="background:white;"><td colspan=2 style="padding: 20px;"><p style="text-align:center;margin-top: 40px;color:#333;">Hi,'.$doctorobj[0]['first_name'].' '.$doctorobj[0]['last_name'].'!</p><p style="text-align:center;color:#333;">Please Check your Appointment is starting on the '.$_POST['date'].' '.$timestartobj[0]['times'].'</p></td></tr><tr bgcolor="#015B7E" style="text-align:center;"><td colspan=2 style="padding-bottom: 20px;padding-top: 20px;"><img src="http://vettreefiles.com/images/logo.png"/><p><a href="http://www.vettreefiles.com/features" style="color:white;padding-left:5px;text-decoration:none;">FEATURES</a><a href="http://www.vettreefiles.com/pricing" style="color:white;padding-left:15px;text-decoration:none;">PRICING</a><a href="http://www.vettreefiles.com/testimonials" style="color:white;padding-left:15px;text-decoration:none;">TESTIMONIALS</a><a href="http://www.vettreefiles.com/contact" style="color:white;padding-left:15px;text-decoration:none;">CONTACT</a></p><p style="text-align:center;margin-bottom: 25px;margin-top: 25px;"><a href="https://www.facebook.com/vaultify/"><img src="http://vettreefiles.com/images/fa-facebook-square.png" ></a><a href="https://www.instagram.com/vaultify/"><img src="http://vettreefiles.com/images/fa-instagram.png" style="padding-left:15px;"></a><a href="https://www.twitter.com/Vaultifyapp"><img src="http://vettreefiles.com/images/fa-twitter-.png" style="padding-left:15px;"></a><a href="#"><img src="http://vettreefiles.com/images/fa-google-plus.png" style="padding-left:15px;"></a></p><p style="text-align:center;color:white;">&copy; 2016 <a style="color:white" href="http://www.vettreefiles.com/">vaultify.io</a>  All Rights Reserved</p></td></tr></table>';
			
			//echo "patienobj".$patienobj[0]['email'];
			sMail($patienobj[0]['email'],$patienobj[0]['first_name']." ".$patienobj[0]['last_name'], "Appointment Reminders", $msg1);
			//echo "doctorobj".$doctorobj[0]['email'];
			sMail($doctorobj[0]['email'],$doctorobj[0]['first_name']." ".$doctorobj[0]['last_name'], "Appointment Reminders", $msg2);
			echo json_encode(array('msg'=>'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg'=>'Problem in Review.'));
			exit;
		}
	}
	
	public function addtimeslots()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "tbl_timeslot_master";
		$table_id = 'id';
		$_POST['clinic_id']= $_SESSION["webadmin1"]["clinic_id"];
		$date = new DateTime();
		$modified_date = $date->format('Y-m-d H:i:s');
		$_POST['modified_date']= $modified_date;
		$result1 = $db->Insert($table, $_POST, 1);
		if($result1)
		{
			$_SESSION["samajadmin"]['msg']= "Appointment Submitted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg'=>'Problem in Review.'));
			exit;
		}
	}
	
	public function fetchapp()
	{
		require 'include_classes.php';
  		$db = new Db();
  		$table = "tbl_appointments";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'desc';
		$condition = "1=1 && i.clinic_id = '".$_SESSION['webadmin1']['clinic_id']."' ";
		if($_SESSION['webadmin1']['role_id'] == PATIENT_ROLE)
			$condition .= " && i.patient_id = '".$_SESSION['webadmin']['id']."' ";
		
		if(isset($_REQUEST['doctor']))
			$condition .= " && i.doctor_id = '".$_REQUEST['doctor']."' ";
  		$main_table = array("$table i",array("i.*"));
	
		$join_tables = array(
			array('left','tbl_timeslots r','r.id = i.time_slot_start', array('r.times as starttime')),
			array('left','tbl_timeslots r1','r1.id = i.time_slot_end', array('r1.times as endtime')),
			array('left','tbl_user_master r2','r2.id = i.doctor_id', array('r2.first_name as doc_first_name','r2.last_name as doc_last_name')),
			array('left','tbl_user_master r3','r3.id = i.patient_id', array('r3.first_name as patient_fname','r3.last_name as patient_lname','r3.phone_no as mobile_no','r3.gender as patient_gender','r3.age as patient_age'))
		); 
		
		$page = $_GET['iDisplayStart'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['iDisplayLength'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['iSortCol_0']) ? strval($colArray[$_GET['iSortCol_0']]) : $default_sort_column;  
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;  
	
		
	
		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));
		
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			//array_push($temp, $count);
			$temp['title'] = $row->patient_fname." ".$row->patient_lname;
			$date = date_create_from_format('m/d/Y g:i a', $row->date." ".$row->starttime);
			$temp['start'] = $date->format('Y-m-d H:i:s');
			$date1 = date_create_from_format('m/d/Y g:i a', $row->date." ".$row->endtime);
			$temp['end'] = $date1->format('Y-m-d H:i:s');
			$temp['url'] = "javascript:editbuttonA('".$row->id."')";
			$temp['id'] = $row->id;
			array_push($items, $temp);
		}
		$result = array();
		$result = $items;
		echo json_encode($result);
		exit;
	}
	
	public function appointment_details()
	{
		parent::__construct();
		$this->view->login("users/appointment_details");
		require 'include_classes.php';
	}
	
	public function fetchnotDetails()
	{
		require 'include_classes.php';
  		$db = new Db();
  		
  		$table = "tbl_appointments";
		$table_id = 'id';
  		$id = $_REQUEST['id'];
  		
  		$join_tables_not = array(
			array('left','tbl_user_master r','r.id = i.patient_id', array('r.first_name as first_name','r.last_name as last_name','r.email as email','r.phone_no as mobile_no')),
			array('left','tbl_user_master r1','r1.id = i.doctor_id', array('r1.first_name as doc_first_name','r1.last_name as doc_last_name','r1.email as doc_email')),
			array('left','tbl_timeslots r2','r2.id = i.time_slot_start', array('r2.times as times'))
		);
		$condition_not = " ( i.patient_id = ".$_SESSION['webadmin']['id']." && i.user_not='1' ) OR (i.doctor_id = ".$_SESSION['webadmin']['id']." && i.doc_not='1' ) " ;
		//echo "<script>alert('".$condition_not."');</script>";
		$rsnot = $db->JoinFetch(array("tbl_appointments i",array("i.*")), $join_tables_not, $condition_not);
		$temp['flag'] = false;
		$temp['msg'] = '';
		while($rownot = mysql_fetch_object($rsnot))
		{	
			$temp['flag'] = true;
			$temp['msg'] = "Hey ".$_SESSION['webadmin']['user_name'].", dont forget you have an appointment at ".$rownot->times;
			if(isset($_SESSION['webadmin']['profile_image']) && $_SESSION['webadmin']['profile_image']!=""){ 
				$temp['profile_image'] = UPLOADS.'/'.$_SESSION['webadmin']['profile_image'];
			}else{
				$temp['profile_image'] = IMAGES.'/user_pic.jpg';
			}
			
			
			$data['id'] = $rownot -> id;
			
			if($rownot->patient_id == $_SESSION['webadmin']['id'])
				$data['user_not'] = 0;
			else if($rownot->doctor_id == $_SESSION['webadmin']['id'])
				$data['doc_not'] = 0;
				
			$result2 = $db->Update('tbl_appointments',$data,"id",$rownot -> id);
		}
		echo json_encode($temp);
		exit;
	}
	
	public function verifyappointment()
	{
		require 'include_classes.php';
  		$db = new Db();
  		
  		$table = "tbl_timeslot_master";
		$table_id = 'id';
  		$id = $_REQUEST['id'];
		//print_r($_REQUEST);
		$temp['flag'] = false;
		
		$old_data = $db->FetchToArray("tbl_timeslots", "*","id = '".$_REQUEST['time_slot_start']."'");
		$timedate = $_REQUEST['date']." ".$old_data[0]['times'].":00";
		
		$join_tables_not = array(
			array('left','tbl_timeslots r1','r1.id = i.time_slot_start', array('r1.times as starttime')),
			array('left','tbl_timeslots r2','r2.id = i.time_slot_end', array('r2.times as endtimes'))
		);
		
		$condition_not = " i.user_id = ".$_REQUEST['doctor_id']." AND STR_TO_DATE('".$timedate."', '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(CONCAT(i.date,' ',r1.times), '%m/%d/%Y %h:%i %p') AND STR_TO_DATE(CONCAT(i.date,' ',r2.times), '%m/%d/%Y %h:%i %p') " ;
		
		$rsnot = $db->JoinFetch(array("tbl_timeslot_master i",array("i.*")), $join_tables_not, $condition_not);
		$temp['flag1'] = false;
		$temp['msg'] = '';
		while($rownot = mysql_fetch_object($rsnot))
		{	
			$temp['flag1'] = true;
		}
		
		
		$old_data1 = $db->FetchToArray("tbl_timeslots", "*","id = '".$_REQUEST['time_slot_end']."'");
		$timedate1 = $_REQUEST['date']." ".$old_data1[0]['times'].":00";
		
		$condition_not = " i.user_id = ".$_REQUEST['doctor_id']." AND STR_TO_DATE('".$timedate1."', '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(CONCAT(i.date,' ',r1.times), '%m/%d/%Y %h:%i %p') AND STR_TO_DATE(CONCAT(i.date,' ',r2.times), '%m/%d/%Y %h:%i %p') " ;
		
		$rsnot = $db->JoinFetch(array("tbl_timeslot_master i",array("i.*")), $join_tables_not, $condition_not);
		$temp['flag2'] = false;
		$temp['msg'] = '';
		while($rownot = mysql_fetch_object($rsnot))
		{	
			$temp['flag2'] = true;
		}
		
		echo json_encode($temp);
		exit;
	}
	
	public function lastseencall()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "tbl_user_master";
		$table_id = 'id';
		$data['online_status'] = "1";
		$data['last_seen_time'] = date("Y-m-d h:i:s");
		$result = $db->Update($table,$data,$table_id ,$_SESSION["samajadmin"]["id"]);
		echo json_encode(array('msg'=>'success'));
		exit;
	}
}

?>