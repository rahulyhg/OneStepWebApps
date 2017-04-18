<?php
class Api extends Controller 
{
	private $httpVersion = "HTTP/1.1";

	public function setHttpHeaders($contentType, $statusCode){
		
		$statusMessage = $this -> getHttpStatusMessage($statusCode);
		
		header($this->httpVersion. " ". $statusCode ." ". $statusMessage);		
		header("Content-Type:". $contentType);
	}
	
	public function getHttpStatusMessage($statusCode){
		$httpStatus = array(
			100 => 'Continue',  
			101 => 'Switching Protocols',  
			200 => 'OK',
			201 => 'Created',  
			202 => 'Accepted',  
			203 => 'Non-Authoritative Information',  
			204 => 'No Content',  
			205 => 'Reset Content',  
			206 => 'Partial Content',  
			300 => 'Multiple Choices',  
			301 => 'Moved Permanently',  
			302 => 'Found',  
			303 => 'See Other',  
			304 => 'Not Modified',  
			305 => 'Use Proxy',  
			306 => '(Unused)',  
			307 => 'Temporary Redirect',  
			400 => 'Bad Request',  
			401 => 'Unauthorized',  
			402 => 'Payment Required',  
			403 => 'Forbidden',  
			404 => 'Not Found',  
			405 => 'Method Not Allowed',  
			406 => 'Not Acceptable',  
			407 => 'Proxy Authentication Required',  
			408 => 'Request Timeout',  
			409 => 'Conflict',  
			410 => 'Gone',  
			411 => 'Length Required',  
			412 => 'Precondition Failed',  
			413 => 'Request Entity Too Large',  
			414 => 'Request-URI Too Long',  
			415 => 'Unsupported Media Type',  
			416 => 'Requested Range Not Satisfiable',  
			417 => 'Expectation Failed',  
			500 => 'Internal Server Error',  
			501 => 'Not Implemented',  
			502 => 'Bad Gateway',  
			503 => 'Service Unavailable',  
			504 => 'Gateway Timeout',  
			505 => 'HTTP Version Not Supported');
		return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
	}
	
	
	public $_allow = array();
	public $_content_type = "application/json";
	public $_request = array();
	
	private $_method = "";		
	private $_code = 200;

	public function get_referer(){
		return $_SERVER['HTTP_REFERER'];
	}
	
	public function response1($data,$status){
		echo "only.....11";
		$this->_code = ($status)?$status:200;
		$this->set_headers();

		echo $data;
		exit;
	}
	
	private function get_status_message(){
		$status = array(
					200 => 'OK',
					201 => 'Created',  
					204 => 'No Content',  
					404 => 'Not Found',  
					406 => 'Not Acceptable');
		return ($status[$this->_code])?$status[$this->_code]:$status[500];
	}
	
	public function get_request_method(){
		return $_SERVER['REQUEST_METHOD'];
	}
	
	private function inputs(){
		switch($this->get_request_method()){
			case "POST":
				$this->_request = $this->cleanInputs($_POST);
				break;
			case "GET":
			case "DELETE":
				$this->_request = $this->cleanInputs($_GET);
				break;
			case "PUT":
				parse_str(file_get_contents("php://input"),$this->_request);
				$this->_request = $this->cleanInputs($this->_request);
				break;
			default:
				$this->response('',406);
				break;
		}
	}		
	
	private function cleanInputs($data){
		$clean_input = array();
		if(is_array($data)){
			foreach($data as $k => $v){
				$clean_input[$k] = $this->cleanInputs($v);
			}
		}else{
			if(get_magic_quotes_gpc()){
				$data = trim(stripslashes($data));
			}
			$data = strip_tags($data);
			$clean_input = trim($data);
		}
		return $clean_input;
	}		
	
	private function set_headers(){
		echo "1::".$this->_code;
		echo "::2::".$this->get_status_message();
		header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
		header("Content-Type:".$this->_content_type);
	}
	protected $fh;
	private $transaction_id = "";
	private $page = 0;
	private $rows = 12;
	
	public function __construct() {
		if(isset($_REQUEST['page']) && isset($_REQUEST['rows'])){
			$_REQUEST['page'] = $_REQUEST['page']*$_REQUEST['rows'];
		}
		$this->inputs();
	}
   
	public function index() {
		parent::__construct();
		$this->log("Index");
		echo json_encode(array("success"=>"0",'msg'=>'Error'));
		exit;
	}
	
	public function log($method) {
		$msg = "****************".date("d-m-Y H:i:s")."****************\nIP : ".$_SERVER['REMOTE_ADDR']."\nMethod : ".$method." - ".json_encode($_REQUEST)."\n***************************************************\n";
		$this->fh = fopen('log/'.date("Y-m-d").'_log.txt', 'a+');
		if(!$this->fh) {
			throw new Exception('Unable to open log file for writing');
		}
		if(fwrite($this->fh, $msg . "\n") === false) {
			throw new Exception('Unable to write to log file.');
		}
		fclose($this->fh);
	}
	
	/*public function __call($method, $args) {
		$this->log("Method Not Found : $method ");
		echo json_encode(array("success"=>"0",'msg'=>'Invalid request'));
		exit;
  	}  */	

	public function loginobjvalidate2() {
		$user_id = $this->validateobjuser2();
		
		if($user_id == 0)
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));	
		else
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'user'=>$user_id)));
		
		exit;
	}
	
	public function forgotpass()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
  		$db = new Db();
		$table = "users";
		$table_id = 'id';
		
		$email = $_REQUEST['reset_email'];
		$date = new DateTime();
		$token = $date->getTimestamp();
		
		$condition = "email = '{$email}' or phonenumber = '{$email}' ";
		$res = $db->Fetch($table, "*", $condition, null, array(0,1));
		$counter = mysql_num_rows($res);
		$result1 = mysql_fetch_array($res);
		if(1 == $counter) 
		{
			$new_password = rand(9999999, 99999999);
			$characters = 'abcdefghkmnoprstwxz34689ABCDEFGHJKLMNPQRTWXY';
			
			for ($i = 0; $i < 10; $i++) {
				$new_password .= $characters[rand(0, strlen($characters) - 1)];
			}
			//echo $new_password;
			$_POST['password'] = md5($new_password);
			$test["user"] = mysql_fetch_assoc($res);
			$result = $db->Update($table, $_POST,'id',$result1['id']);	
			$result = $_REQUEST[$table_id];
			$msg = 'Hi,'.$test["user"]["username"].'Your password has been changed. please check it out'.$_POST['password'];
			
			sMail($_REQUEST['reset_email'],$test["user"]["username"], "Reset Password", $msg);
			echo json_encode(array("success"=>"1","msg"=>'Check your mail to reset password.'));
		}
		else
		{
			echo json_encode(array("success"=>"0","msg"=>'Email-Id or Mobile number is incorrect.'));
		}
		exit;
	}
	
	public function signupact(){
		
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		
		$table = "users";
		$table_id = 'id';
		
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$date = new DateTime();
		$token = $date->getTimestamp();
	
		$condition = "phonenumber = '".$_REQUEST['phonenumber']."'";
		$check_name = $db->FunctionFetch($table, 'count', '*', $condition);
	
		$condition1 = "email = '".$_REQUEST['email']."'";
		$check_name1 = $db->FunctionFetch($table, 'count', '*', $condition1);
	
		if($check_name > 0)
		{
			echo json_encode(array("success"=>"0",'msg'=>'Phone Number Already Present.'));
			exit;
		}
		else if($check_name1 > 0)
		{
			echo json_encode(array("success"=>"0",'msg'=>'User Email-ID Already Present.'));
			exit;
		}
		else
		{
			$_REQUEST['password'] = md5($_REQUEST['password']);
			$_REQUEST['status'] = '1';
			$result = $db->Insert($table, $_REQUEST, 1);
			
			if($result > 0)
			{
				//$result2 = $db->Insert('user_address_xref',$relation,1);			
				$msg = 'Hi,'.$_REQUEST['first_name'].' '.$_REQUEST['last_name'].'!Thanks for signing up and joining One Step Application.';
				//echo $msg;
				sMail($_REQUEST['email'],$_REQUEST['first_name']." ".$_REQUEST['last_name'], "Thanks for joining One Step", $msg);
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'Please check the your mail. We have sent you on your email.','id'=>$result)));
				exit;
			}
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				exit;
			}
		}
	}
	
	
	
	public function createnewproject(){
		
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		
		$table = "users";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$intid = $_REQUEST['id'];
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$dateeve = date_create($_REQUEST['Date']);
			$_REQUEST['Date'] = date_format($dateeve,"jS F Y");
			$result2 = $db->Update('projects',$_REQUEST,"id",$intid);
			$client_id = $db->FetchCellValue("projects",'Client_id','id ="'.$_REQUEST['id'].'"');
			echo $client_id;
			$client['name'] = $_REQUEST['name']; 
			$client['phonenumber'] = $_REQUEST['phonenumber']; 
			$client['email'] = $_REQUEST['email']; 
			$result2 = $db->Update('client',$client,"id",$client_id);
			echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
			exit;
		}
		else
		{
			if(isset($_REQUEST['name']) && $_REQUEST['name']!="")
			{	
				
				$data['name'] = $_REQUEST['name'];
				$data['phonenumber'] = $_REQUEST['phonenumber'];
				$data['email'] = $_REQUEST['email'];
				$result = $db->Insert('client', $data, 1);
				
				$_REQUEST['deposit_percent'] = '10';
				$_REQUEST['maximum_deposit'] = '1000000';
				$_REQUEST['levels_of_prep'] = '0';
				$_REQUEST['Client_id'] = $result;
				$_REQUEST['created_by'] = $user[0]['id'];
				$_REQUEST['status'] = 1;
				$dateeve = date_create($_REQUEST['Date']);
				$_REQUEST['Date'] = date_format($dateeve,"jS F Y");
				$result55 = $db->Insert('projects', $_REQUEST, 1);
				$result66 = $db->Query("INSERT INTO default_production_rate(production_item,description,rate,unit,coat_1,coat_2,coat_3,coat_4,spread,factor,class,section,project_id,client_id)SELECT production_item,description,rate,unit,coat_1,coat_2,coat_3,coat_4,spread,factor,class,section,'".$result55."','".$user[0]['id']."' FROM default_production_rate WHERE project_id = '0'");
				
				$result67 = $db->Query("INSERT INTO Interior_Rate (rate_type,interior,exterior,project_id)SELECT rate_type,interior,exterior,'".$result55."' FROM Interior_Rate WHERE project_id = '0'");
				
				$result68 = $db->Query("INSERT INTO level_of_preparation (level,percentage,project_id)SELECT level,percentage,'".$result55."' FROM level_of_preparation WHERE project_id = '0'");

				if($result55 > 0)
				{
					echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'New Project is created.','id'=>$result55)));
					exit;
				}
				else
				{
					echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
					exit;
				}
				
			}
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert123.'));
				exit;
			}
		}
		
	}
	
	
	public function addintest() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "internal_estimate";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		$_REQUEST['created_by'] = $user[0]['id'];
		
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$id = $_REQUEST['id'];
				$result2 = $db->Update("int_estimates", $_REQUEST,"id",$id);
				$result21 = $db->Update($table,$_REQUEST,"estimate_id",$id);
				if($result2)
				{
					echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
					exit;
				}
				else
				{
					echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
					exit;
				}
			}
			else
			{ 
				
				$_REQUEST['estimate_id'] = $db->Insert("int_estimates", $_REQUEST, 1);
				if($_REQUEST['estimate_id'] > 0)
				{
					$result55 = $db->Insert($table, $_REQUEST, 1);
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
				}
				else
				{
					 echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				}
				exit;
			}
		}
		else{	
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function addextest() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "external_estimate";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		$_REQUEST['created_by'] = $user[0]['id'];
		
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$id = $_REQUEST['id'];
				$result2 = $db->Update("ext_estimates", $_REQUEST,"id",$id);
				$result21 = $db->Update($table,$_REQUEST,"estimate_id",$id);
				if($result2)
				{
					echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
					exit;
				}
				else
				{
					echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
					exit;
				}
			}
			else
			{ 
				
				$_REQUEST['estimate_id'] = $db->Insert("ext_estimates", $_REQUEST, 1);
				if($_REQUEST['estimate_id'] > 0)
				{
					$result55 = $db->Insert($table, $_REQUEST, 1);
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
				}
				else
				{
					 echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				}
				exit;
			}
		}
		else{	
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function fetch_intest()
	{
		 include_once('include_classes.php');
		 
		$db = new Db();
		$result = array();
		$table88 = "int_estimates";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		
		$user = $this->validateobjuser2();
		if($user == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		if(isset($_REQUEST['id'])){
			$condition88 = "i.id = '".$_REQUEST['id']."' ";
			$main_table88 = array("$table88 i",array("i.*"));
			$join_tables88 = array(
				array('left','internal_estimate c','c.estimate_id = i.id', array('c.*')),
				array('left','room_types c1','c1.id = i.SpaceType', array('c1.name as spacetype'))
			);
			$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
			$result = mysql_fetch_array($rs1);
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	
	public function fetch_extest()
	{
		 include_once('include_classes.php');
		 
		$db = new Db();
		$result = array();
		$table88 = "ext_estimates";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		
		$user = $this->validateobjuser2();
		if($user == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		
		if(isset($_REQUEST['id'])){
			$condition88 = "i.id = '".$_REQUEST['id']."' ";
			$main_table88 = array("$table88 i",array("i.*"));
			$join_tables88 = array(
				array('left','external_estimate c','c.estimate_id = i.id', array('c.*'))
			);
			$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
			$result = mysql_fetch_array($rs1);
			//print_r($row);
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	private function validateobjuser2(){
  
		  include_once('include_classes.php');
		  
		  $db = new Db();
		  $table="users";
		  
		  $_REQUEST = $db->FilterParameters($_REQUEST);  
		  
		  
		  
		  if(empty($_REQUEST['username'])){
		   echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
		   exit;
		  }else{
		   $user_name = $_REQUEST['username'];
		  }
		  
		  if(empty($_REQUEST['password'])){
		   echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect456'));
		   exit;
		  }else{
		   $password = md5($_REQUEST['password']);
		  }
		  $main_table = array("$table i",array("i.*"));
		
		  $join_tables = array();
		  $condition = "(i.email = '{$user_name}' or i.phonenumber = '{$user_name}') && i.password = '{$password}'";
		  $rs = $db->JoinFetch($main_table, $join_tables, $condition);
		  
		  while($row = mysql_fetch_assoc($rs))
		  {
				$row['city_name'] = $row['city'];
				$row['state_name'] = $row['state'];
				$row['country_name'] = $row['country'];
				$result[] = $row;
		  }
			
			
		  $counter = @mysql_num_rows($rs);
		  if($counter > 0){
		   return $result;
		  }else{
		   return 0;
		  }
	}
	
	public function test(){

		// Push The notification with parameters
		require_once('PushBots.class.php');
		$pb = new PushBots();
		// Application ID
		$appID = '518d187xx';
		// Application Secret
		$appSecret = '25e8507956b62d81xxx';
		$pb->App($appID, $appSecret);
		 

		// Notification Settings
		$pb->Alert("test Mesage");
		$pb->Platform(array("0","1"));
		$pb->Badge("+2");

		// Update Alias 
		/**
		 * set Alias Data
		 * @param	integer	$platform 0=> iOS or 1=> Android.
		 * @param	String	$token Device Registration ID.
		 * @param	String	$alias New Alias.
		 */
		 
		$pb->AliasData(1, "APA91bFpQyCCczXC6hz4RTxxxxx", "test");
		// set Alias on the server
		$pb->setAlias();

		// Push it !
		$pb->Push();

		// Push to Single Device
		// Notification Settings
		$pb->AlertOne("test Mesage");
		$pb->PlatformOne("0");
		$pb->TokenOne("3dfc8119fedeb90d1b8a9xxxxxx");

		//Push to Single Device
		$pb->PushOne();

		//Remove device by Alias
		$pb->removeByAlias("myalias");

		echo json_encode(array("success"=>"1",'msg'=>'its working'));
		exit;
	}
	
	public function fetchdropdown(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$param = $_REQUEST['param'];
			$parent_id = "";
			if(isset($_REQUEST['parent_id']))
			$parent_id = $_REQUEST['parent_id'];
			
			if($param=="Country")
				echo $db->CreateOptions("json", "location", array("location_id","name"),"","","location_type='0'");
			else if($param=="State")
				echo $db->CreateOptions("json", "location", array("location_id","name"),"","","location_type='1' && parent_id=$parent_id ");
			else if($param=="city")
				echo $db->CreateOptions("json", "location", array("location_id","name"),"","","location_type='2' && parent_id=$parent_id ");
			else if($param=="room_types")
				echo $db->CreateOptions("json", "room_types", array("id","name"),"",array("name"=>'asc'),"");
			else if($param=="estimates_jobs")
				echo $db->CreateOptions("json", "estimates_jobs", array("id","jobs_name"),"","","jobs_type='$parent_id'");
			else if($param=="ext_estimates_jobs")
				echo $db->CreateOptions("json", "ext_estimates_jobs", array("id","jobs_name"),"","","jobs_type='$parent_id'");
			else if($param=="ext_room_type")
				echo $db->CreateOptions("json", "exterior_descript", array("id","name"),"",array("name"=>'asc'),"");
			else if($param=="Finish_desc")
				echo $db->CreateOptions("json", "Finish_desc", array("id","description"),"","","");
			else if($param=="gen_note")
				echo $db->CreateOptions("json", "lov", array("id","value"),"","","type='notes_type'");
			
			exit;
	}
	
	public function fetchalldropdown(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			/*
			
			$param = $_REQUEST['param'];
			$parent_id = $_REQUEST['parent_id'];
			
			if($param=="Married")
				echo $db->CreateOptions("json", "lov", array("id","value"),"","","type='married'");
			else if($param=="Samaj_City")
				echo $db->CreateOptions("json", "samaj_city", array("id","name"));
			else if($param=="Samaj_Caste")
				echo $db->CreateOptions("json", "cast", array("id","name"));
			else if($param=="Village")
				echo $db->CreateOptions("json", "vilage", array("id","name"));
			else if($param=="Mosad_Village")
				echo $db->CreateOptions("json", "vilage", array("id","name"));
			else if($param=="Country")
				echo $db->CreateOptions("json", "location", array("location_id","name"),"","","location_type='0'");
			else if($param=="State")
				echo $db->CreateOptions("json", "location", array("location_id","name"),"","","location_type='1' && parent_id=$parent_id ");
			else if($param=="city")
				echo $db->CreateOptions("json", "location", array("location_id","name"),"","","location_type='2' && parent_id=$parent_id ");
			*/	
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'Country'=>$db->CreateOptionsJson("json", "location", array("location_id","name"),"","","location_type='0'"))));
			exit;
			
	}
	public function fetchdroptype(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			
			$res = $db->Fetch("estimates_jobs", "DISTINCT jobs_type");
			
			while($row = mysql_fetch_array($res))
			{
				$result[] = $row[0];
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function fetchextdroptype(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			
			$res = $db->Fetch("ext_estimates_jobs", "DISTINCT jobs_type");
			
			while($row = mysql_fetch_array($res))
			{
				$result[] = $row[0];
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function insertestimate(){
		
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		
		$table = "job_estimates_id";
		$table_id = 'id';
		$result = "";
		$rate = "";
		$arr= array();
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		
		if(isset($_REQUEST['job_id']) && $_REQUEST['job_id']!="")
		{	

			$coat = $_REQUEST['Coats'];
			switch ($coat) {
				case "1":
					$rate = $db->FetchCellValue("default_rate",'coat_1','job_id ="'.$_REQUEST['job_id'].'" && type= "int_type"');
					$_REQUEST['Rates'] = $rate;
					break;
				case "2":
					$rate = $db->FetchCellValue("default_rate",'coat_2','job_id ="'.$_REQUEST['job_id'].'" && type= "int_type"');
					$_REQUEST['Rates'] = $rate;
					break;
				case "3":
					$rate = $db->FetchCellValue("default_rate",'coat_3','job_id ="'.$_REQUEST['job_id'].'" && type= "int_type"');
					$_REQUEST['Rates'] = $rate;
					break;
				case "4":
					$rate = $db->FetchCellValue("default_rate",'coat_4','job_id ="'.$_REQUEST['job_id'].'" && type= "int_type"');
					$_REQUEST['Rates'] = $rate;
					break;
			}
			$lnft = $db->FetchCellValue("int_estimates",'LN_FT','id ="'.$_REQUEST['estimate_id'].'"');
			$wft = $db->FetchCellValue("int_estimates",'W_FT','id ="'.$_REQUEST['estimate_id'].'"');
			$cft = $db->FetchCellValue("int_estimates",'C_FT','id ="'.$_REQUEST['estimate_id'].'"');
			$unit = $db->FetchCellValue("estimates_jobs",'unit','id ="'.$_REQUEST['job_id'].'"');
			$unit = trim($unit);
			$_REQUEST['Unit'] = $unit;
			if($unit == "Hours"){
				$_REQUEST['Time'] = $_REQUEST['Quantity'];
			}
			else if($unit == "Each"){
				$_REQUEST['Time'] = $_REQUEST['Quantity'] * $rate;
			}
			else if(isset($unit) && ($unit = "Ln. Ft." || $unit = "Sq. Ft.")){
				$job = $_REQUEST['job_id'];
					switch ($job) {
						case "4":
						case "8":
						case "10":
						case "11":
						case "37":
							$_REQUEST['Quantity'] = $wft;
							break;
						case "38":
						case "39":
							$_REQUEST['Quantity'] = $cft;
							break;
						case "21":
						case "22":
						case "23":
							$_REQUEST['Quantity'] = $lnft;
							break;
						case "9":
							$rate = $db->FetchCellValue("default_rate",'coat_1','job_id ="'.$_REQUEST['job_id'].'" && type= "int_type"');
							$_REQUEST['Rates'] = $rate;
							break;
					}
					$_REQUEST['Time'] = $_REQUEST['Quantity'] / $rate;
			}
			$arr = $db->CreateOptions("array", "default_rate", array("id","job_id"),"","","type='int_type'");
			if(isset($_REQUEST['Gals']) && $_REQUEST['Gals'] != "")
			{
				$gals = $_REQUEST['Gals'] ;
			}
			else{
				if(in_array($_REQUEST['job_id'], $arr)){
					if(isset($_REQUEST['job_id']) && $_REQUEST['job_id'] == 8){
						$spread = $db->FetchCellValue("default_rate",'coat_1','job_id ="10" && type= "int_type"');
					} 
					else {
						$spread = $db->FetchCellValue("default_rate",'spread','job_id ="'.$_REQUEST['job_id'].'" && type= "int_type"');
					}
					$_REQUEST['Gals'] = ($_REQUEST['Quantity'] * $_REQUEST['Coats']) / $spread;
				}
			}
			
			$intid = $_REQUEST['id'];
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$result2 = $db->Update($table,$_REQUEST,"id",$intid);
				$sumoftime = $db->FetchCellValue("job_estimates_id","SUM(Time)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."' && job_id not in ('32')");
				$sumofalltime = $db->FetchCellValue("job_estimates_id","SUM(Time)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."'");
				$faux_mural = $db->FetchCellValue("job_estimates_id","Time"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."' && job_id = '32' ");
				$sumofgals = $db->FetchCellValue("job_estimates_id","SUM(Gals)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."'");
				$paint_rate = $db->FetchCellValue("rate_list","interior_rate"," id = '1'");
				$cost_per_gallon = $db->FetchCellValue("rate_list","interior_rate"," id = '3'");
				$cost_per_percent = $db->FetchCellValue("rate_list","interior_rate"," id = '4'");
				$sumoftime = isset($sumoftime) ? $sumoftime : 0 ; 
				$faux_mural = isset($faux_mural) ? $faux_mural : 0 ; 
				$sumofgals = isset($sumofgals) ? $sumofgals : 0 ; 
				$$sumofalltime = isset($$sumofalltime) ? $$sumofalltime : 0 ; 
				if(isset($_REQUEST['cost_type']) && $_REQUEST['cost_type'] == "percent"){
					$cost_percent = ($sumoftime*$paint_rate + $faux_mural*$paint_rate)*($cost_per_percent/100);
					$cost = $sumoftime*$paint_rate + $faux_mural*$paint_rate + $cost_percent;
				}
				else{
					$cost = $sumoftime*$paint_rate + $faux_mural*$paint_rate + $sumofgals*$cost_per_gallon;
				}
				
				$adddata['Gallons'] = $sumofgals;
				$adddata['Hours'] = $sumofalltime;
				$adddata['Cost'] = $cost;
				$result3 = $db->Update('int_estimates',$adddata,"id",$_REQUEST['estimate_id']);
				echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
				exit;
			}
			$_REQUEST['status'] = 1;
			$result55 = $db->Insert('job_estimates_id', $_REQUEST, 1);
			$sumoftime = $db->FetchCellValue("job_estimates_id","SUM(Time)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."' && job_id not in ('32')");
				$sumofalltime = $db->FetchCellValue("job_estimates_id","SUM(Time)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."'");
				$faux_mural = $db->FetchCellValue("job_estimates_id","Time"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."' && job_id = '32' ");
				$sumofgals = $db->FetchCellValue("job_estimates_id","SUM(Gals)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."'");
				$paint_rate = $db->FetchCellValue("rate_list","interior_rate"," id = '1'");
				$cost_per_gallon = $db->FetchCellValue("rate_list","interior_rate"," id = '3'");
				$cost_per_percent = $db->FetchCellValue("rate_list","interior_rate"," id = '4'");
				$sumoftime = isset($sumoftime) ? $sumoftime : 0 ; 
				$faux_mural = isset($faux_mural) ? $faux_mural : 0 ; 
				$sumofgals = isset($sumofgals) ? $sumofgals : 0 ; 
				$sumofalltime = isset($sumofalltime) ? $sumofalltime : 0 ; 
				if(isset($_REQUEST['cost_type']) && $_REQUEST['cost_type'] == "percent"){
					$cost_percent = ($sumoftime*$paint_rate + $faux_mural*$paint_rate)*($cost_per_percent/100);
					$cost = $sumoftime*$paint_rate + $faux_mural*$paint_rate + $cost_percent;
				}
				else{
					$cost = $sumoftime*$paint_rate + $faux_mural*$paint_rate + $sumofgals*$cost_per_gallon;
				}
				$adddata['Gallons'] = $sumofgals;
				$adddata['Hours'] = $sumofalltime;
				$adddata['Cost'] = $cost;
				$result3 = $db->Update('int_estimates',$adddata,"id",$_REQUEST['estimate_id']);
			if($result55 > 0)
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'New Estimate is created.','id'=>$result55)));
				exit;
			}
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				exit;
			}
			
		}
		else
		{
			echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
			exit;
		}
		
	}
	
	public function insertextestimate(){
		
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		
		$table = "ext_job_estimates_id";
		$table_id = 'id';
		$result = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		
		if(isset($_REQUEST['job_id']) && $_REQUEST['job_id']!="")
		{	
			$coat = $_REQUEST['Coats'];
			switch ($coat) {
				case "1":
					$rate = $db->FetchCellValue("default_rate",'coat_1','job_id ="'.$_REQUEST['job_id'].'" && type= "ext_type"');
					$_REQUEST['Rates'] = $rate;
					break;
				case "2":
					$rate = $db->FetchCellValue("default_rate",'coat_2','job_id ="'.$_REQUEST['job_id'].'" && type= "ext_type"');
					$_REQUEST['Rates'] = $rate;
					break;
				case "3":
					$rate = $db->FetchCellValue("default_rate",'coat_3','job_id ="'.$_REQUEST['job_id'].'" && type= "ext_type"');
					$_REQUEST['Rates'] = $rate;
					break;
				case "4":
					$rate = $db->FetchCellValue("default_rate",'coat_4','job_id ="'.$_REQUEST['job_id'].'" && type= "ext_type"');
					$_REQUEST['Rates'] = $rate;
					break;
			}
			$unit = $db->FetchCellValue("ext_estimates_jobs",'unit','id ="'.$_REQUEST['job_id'].'"');
			$unit = trim($unit);
			$_REQUEST['Unit'] = $unit;
			if($unit == "Hours"){
				$_REQUEST['Time'] = $_REQUEST['Quantity'];
			}
			else if($unit == "Each"){
				$job = $_REQUEST['job_id'];
					switch ($job) {
						case "9":
						case "10":
						case "11":
						case "12":
						case "13":
						case "14":
							$rate = $db->FetchCellValue("default_rate",'coat_1','job_id ="'.$_REQUEST['job_id'].'" && type= "ext_type"');
							$_REQUEST['Rates'] = $rate;
							break;
					}
				$_REQUEST['Time'] = $_REQUEST['Quantity'] * $rate;
			}
			else if(isset($unit) && ($unit = "Ln. Ft." || $unit = "Sq. Ft.")){
				$job = $_REQUEST['job_id'];
					switch ($job) {
						case "9":
						case "10":
						case "11":
						case "12":
						case "13":
						case "14":
							$rate = $db->FetchCellValue("default_rate",'coat_1','job_id ="'.$_REQUEST['job_id'].'" && type= "ext_type"');
							$_REQUEST['Rates'] = $rate;
							break;
					}
					$_REQUEST['Time'] = $_REQUEST['Quantity'] / $rate;
			}
			$arr = $db->CreateOptions("array", "default_rate", array("id","job_id"),"","","type='ext_type'");
			if(isset($_REQUEST['Gals']) && $_REQUEST['Gals'] != "")
			{
				$gals = $_REQUEST['Gals'] ;
			}
			else{
				if(in_array($_REQUEST['job_id'], $arr)){
					$spread = $db->FetchCellValue("default_rate",'spread','job_id ="'.$_REQUEST['job_id'].'" && type= "ext_type"');
					$_REQUEST['Gals'] = ($_REQUEST['Quantity'] * $_REQUEST['Coats']) / $spread;
				}
			}
			$intid = $_REQUEST['id'];
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$result2 = $db->Update($table,$_REQUEST,"id",$intid);
				$sumoftime = $db->FetchCellValue("ext_job_estimates_id","SUM(Time)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."'");
				$sumofgals = $db->FetchCellValue("ext_job_estimates_id","SUM(Gals)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."'");
				$paint_rate = $db->FetchCellValue("rate_list","exterior_rate"," id = '1'");
				$cost_per_gallon = $db->FetchCellValue("rate_list","exterior_rate"," id = '3'");
				$cost_per_percent = $db->FetchCellValue("rate_list","exterior_rate"," id = '4'");
				$sumoftime = isset($sumoftime) ? $sumoftime : 0 ; 
				$sumofgals = isset($sumofgals) ? $sumofgals : 0 ; 
				if(isset($_REQUEST['cost_type']) && $_REQUEST['cost_type'] == "percent"){
					$cost_percent = ($sumoftime*$paint_rate)*($cost_per_percent/100);
					$cost = $sumoftime*$paint_rate + $cost_percent;
				}
				else{
					$cost = $sumoftime*$paint_rate + $sumofgals*$cost_per_gallon;
				}
				
				$adddata['Gallons'] = $sumofgals;
				$adddata['Hours'] = $sumoftime;
				$adddata['Cost'] = $cost;
				$result3 = $db->Update('ext_estimates',$adddata,"id",$_REQUEST['estimate_id']);
				echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
				exit;
			}
			$_REQUEST['status'] = 1;
			$result55 = $db->Insert($table, $_REQUEST, 1);
				$sumoftime = $db->FetchCellValue("ext_job_estimates_id","SUM(Time)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."'");
				$sumofgals = $db->FetchCellValue("ext_job_estimates_id","SUM(Gals)"," estimate_id = '".$_REQUEST['estimate_id']."' && project_id = '".$_REQUEST['project_id']."'");
				$paint_rate = $db->FetchCellValue("rate_list","exterior_rate"," id = '1'");
				$cost_per_gallon = $db->FetchCellValue("rate_list","exterior_rate"," id = '3'");
				$cost_per_percent = $db->FetchCellValue("rate_list","exterior_rate"," id = '4'");
				$sumoftime = isset($sumoftime) ? $sumoftime : 0 ; 
				$sumofgals = isset($sumofgals) ? $sumofgals : 0 ; 
				if(isset($_REQUEST['cost_type']) && $_REQUEST['cost_type'] == "percent"){
					$cost_percent = ($sumoftime*$paint_rate)*($cost_per_percent/100);
					$cost = $sumoftime*$paint_rate + $cost_percent;
				}
				else{
					$cost = $sumoftime*$paint_rate + $sumofgals*$cost_per_gallon;
				}
				
				$adddata['Gallons'] = $sumofgals;
				$adddata['Hours'] = $sumoftime;
				$adddata['Cost'] = $cost;
				$result3 = $db->Update('ext_estimates',$adddata,"id",$_REQUEST['estimate_id']);
			if($result55 > 0)
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'New External Estimate is created.','id'=>$result55)));
				exit;
			}
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				exit;
			}
			
		}
		else
		{
			echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
			exit;
		}
		
	}
	
	public function generateintestimate(){
		
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$area_info = array();
		$length = isset($_REQUEST['Length']) ? $_REQUEST['Length'] : 0 ; 
		$width = isset($_REQUEST['Width']) ? $_REQUEST['Width'] : 0 ; 
		$height = isset($_REQUEST['Height']) ? $_REQUEST['Height'] : 0 ; 
		$lnft = 2*$length + 2*$width;
		$wft = 2*$length*$height + 2*$width*$height;
		$cft = $length * $width;
		/*print_r($area_info);
		exit;*/
		$table = "int_estimates";
		$table_id = 'id';
		$result = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$intid = $_REQUEST['id'];
			$_REQUEST['LN_FT']= $lnft;
			$_REQUEST['W_FT']= $wft;
			$_REQUEST['C_FT']= $cft;
			$result2 = $db->Update($table,$_REQUEST,"id",$intid);
			echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
			exit;
		}
		else{
			if(isset($_REQUEST['project_id']) && $_REQUEST['project_id']!="")
			{	
				$_REQUEST['status'] = 1;
				$_REQUEST['LN_FT']= $lnft;
				$_REQUEST['W_FT']= $wft;
				$_REQUEST['C_FT']= $cft;
				$result55 = $db->Insert('int_estimates', $_REQUEST, 1);
				if($result55 > 0)
				{
					
					echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'New Estimate is created.','id'=>$result55,'data'=>$_REQUEST)));
					exit;
				}
				else
				{
					echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
					exit;
				}
				
			}
			echo json_encode(array("success"=>"0",'msg'=>'Please select the project.'));
			exit;
		}
	}
	
	public function generateextintestimate(){
		
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$length = isset($_REQUEST['Length']) ? $_REQUEST['Length'] : 0 ; 
		$height = isset($_REQUEST['Height']) ? $_REQUEST['Height'] : 0 ; 
		$sqft = $length * $height;
		
		$table = "ext_estimates";
		$table_id = 'id';
		$result = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$extid = $_REQUEST['id'];
			$_REQUEST['Sq_Ft']= $sqft;
			$result2 = $db->Update($table,$_REQUEST,"id",$extid);
			echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
			exit;
		}
		else{
			if(isset($_REQUEST['project_id']) && $_REQUEST['project_id']!="")
			{	
				$_REQUEST['status'] = 1;
				$_REQUEST['Sq_Ft']= $sqft;
				$result55 = $db->Insert($table, $_REQUEST, 1);
				if($result55 > 0)
				{
					
					echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'New External Estimate is created.','id'=>$result55,'data'=>$_REQUEST)));
					exit;
				}
				else
				{
					echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
					exit;
				}
				
			}
			echo json_encode(array("success"=>"0",'msg'=>'Please select the project.'));
			exit;
		}
	}
	
	
	public function insertintnotes(){
		
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		
		$table = "int_notes";
		$table_id = 'id';
		$result = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$result55 = '';
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id']!="")
		{	
			$_REQUEST['status'] = 1;
					
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $_REQUEST['id'] > 0 ){
					$result = $db->Update($table, $_REQUEST,'id',$_REQUEST['id']);	
					if($result)
						$result55 = $_REQUEST['id'];
			}
			else
			{
				$result55 = $db->Insert('int_notes', $_REQUEST, 1);
			}
			
			if($result55 > 0)
			{
				if(isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $_REQUEST['id'] > 0 ){
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'Notes is Updated.','id'=>$result55)));
				}
				else{
					echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'New Notes is created.','id'=>$result55)));
				}
				exit;
			}
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				exit;
			}
			
		}
		else
		{
			echo json_encode(array("success"=>"0",'msg'=>'Please select the project.'));
			exit;
		}
		
	}
	
	public function insertextnotes(){
		
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		
		$table = "ext_notes";
		$table_id = 'id';
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != ""){	
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $_REQUEST['id'] > 0 ){
				/*echo "in if";*/
				$result = $db->Update($table, $_REQUEST,'id',$_REQUEST['id']);	
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'Notes is Updated.')));
				exit;
			}
			else
			{
				$result55 = $db->Insert($table, $_REQUEST, 1);
				if($result55 > 0)
				{
					echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'New Notes is created.')));
					exit;
				}
				else
				{
					echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
					exit;
				}
			}
		}
		else{
			echo json_encode(array("success"=>"0",'msg'=>'Please select the project.'));
			exit;
		}
		
		/*if($result55 > 0)
		{
			echo "test1";
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $_REQUEST['id'] > 0 ){
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'Notes is Updated.','id'=>$result55)));
			}
			else{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'msg'=>'success','message'=>'New Notes is created.','id'=>$result55)));
			}
			exit;
		}
		else
		{
			echo "test2";
			echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
			exit;
		}*/
		
	}
	
	public function gennote(){
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		
		$table = "notes";
		$table_id = 'id';
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user = $this->validateobjuser2();
		if($user == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['created_by'] = $user[0]['id'];
		
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$result5 = $db->Update($table, $_REQUEST,'id',$_REQUEST['id']);
				if($result5)
				{
					echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
					exit;
				}
				else
				{  
					echo json_encode(array("success"=>"0",'msg'=>'Problem in Update.'));
					exit;
				}  
			}
			else
			{
				$result = $db->Insert($table, $_REQUEST, 1);
				if($result > 0)
				{
					echo json_encode(array('success'=>'1','message'=>'New Note Created'));
					exit;
				}
				else
				{  
					echo json_encode(array('success'=>'0','message'=>'Problem in data insert.'));
					exit;
				}  
			}
		}
		else{
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Please select the project.')));
			exit;
		}
		
		
	}
	
	public function fetchgennotes(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['project_id']))
				$res = $db->Fetch("notes", "*","project_id='".$_REQUEST['project_id']."' && created_by= '".$user[0]['id']."' ",array('id'=>'desc'));
			else
			{
				$res = $db->Fetch("notes", "*"," created_by= '".$user[0]['id']."' ",array('id'=>'desc'),array(0,5));
			}
			
			while($row = mysql_fetch_assoc($res))
			{
				$row['type_name'] = $db->FetchCellValue("lov","value"," id = '".$row['type']."'");
				$row['Client_id'] = $db->FetchCellValue("projects","Client_id"," id = '".$_REQUEST['project_id']."'");
				$row['project_name'] = $db->FetchCellValue("client","name"," id = '".$row['Client_id']."'");
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function fetchintnotes(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['project_id']))
				$res = $db->Fetch("int_notes", "*","project_id='".$_REQUEST['project_id']."' && status=1",array('id' => 'desc'));
			else
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Please select the project.')));
				exit;
			}
			
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	
	public function fetchintjob(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['id']))
				$res = $db->Fetch("job_estimates_id", "*","id='".$_REQUEST['id']."' && status=1");
			else
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Please select the project.')));
				exit;
			}
			
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function fetchextjob(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['id']))
				$res = $db->Fetch("ext_job_estimates_id", "*","id='".$_REQUEST['id']."' && status=1");
			else
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Please select the project.')));
				exit;
			}
			
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function fetchspecificintnote(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['id']))
				$res = $db->Fetch("int_notes", "*","id='".$_REQUEST['id']."' && status=1");
			else
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Please select the Internal Note.')));
				exit;
			}
			
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	} 
	
	public function fetchspecificgennote(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['id']))
				$res = $db->Fetch("notes", "*","id='".$_REQUEST['id']."'");
			else
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Please select the Internal Note.')));
				exit;
			}
			
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	} 
	
	public function fetchspecificextnote(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['id']))
				$res = $db->Fetch("ext_notes", "*","id='".$_REQUEST['id']."' && status=1");
			else
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Please select the Internal Note.')));
				exit;
			}
			
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	} 
	
	public function deleteintnotes()
	{
		require 'include_classes.php';
		$db = new Db();
		
		$table = "int_notes";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		//$db->delete('tbl_user_clinic_relation','patient_id',$id);
		
		if($db->delete($table,$table_id,$id))
		{
			/*$_SESSION["samajadmin"]['msg']= "Record Deleted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";*/
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","msg"=>"Record Deleted successfully.")));
			exit;
		}
		else
		{
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
			exit;
		}
	}
	
	public function deletegennotes()
	{
		require 'include_classes.php';
		$db = new Db();
		
		$table = "notes";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		//$db->delete('tbl_user_clinic_relation','patient_id',$id);
		
		if($db->delete($table,$table_id,$id))
		{
			/*$_SESSION["samajadmin"]['msg']= "Record Deleted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";*/
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","msg"=>"Record Deleted successfully.")));
			exit;
		}
		else
		{
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
			exit;
		}
	}
	
	public function deleteextnotes()
	{
		require 'include_classes.php';
		$db = new Db();
		
		$table = "ext_notes";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		//$db->delete('tbl_user_clinic_relation','patient_id',$id);
		
		if($db->delete($table,$table_id,$id))
		{
			/*$_SESSION["samajadmin"]['msg']= "Record Deleted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";*/
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","msg"=>"Record Deleted successfully.")));
			exit;
		}
		else
		{
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
			exit;
		}
	}
	
	public function deleteintestimate()
	{
		require 'include_classes.php';
		$db = new Db();
		
		$table = "job_estimates_id";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		//$db->delete('tbl_user_clinic_relation','patient_id',$id);
		
		if($db->delete($table,$table_id,$id))
		{
			/*$_SESSION["samajadmin"]['msg']= "Record Deleted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";*/
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","msg"=>"Record Deleted successfully.")));
			exit;
		}
		else
		{
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
			exit;
		}
	}
	
	public function deleteextestimate()
	{
		require 'include_classes.php';
		$db = new Db();
		
		$table = "ext_job_estimates_id";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		//$db->delete('tbl_user_clinic_relation','patient_id',$id);
		
		if($db->delete($table,$table_id,$id))
		{
			/*$_SESSION["samajadmin"]['msg']= "Record Deleted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";*/
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","msg"=>"Record Deleted successfully.")));
			exit;
		}
		else
		{
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
			exit;
		}
	}
	
	public function deleteproject()
	{
		require 'include_classes.php';
		$db = new Db();
		
		$table = "projects";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		$user = $this->validateobjuser2();
		if($user == 0)
		{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		//$db->delete('tbl_user_clinic_relation','patient_id',$id);
		
		if($db->delete($table,$table_id,$id))
		{
			/*$_SESSION["samajadmin"]['msg']= "Record Deleted successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";*/
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","msg"=>"Record Deleted successfully.")));
			exit;
		}
		else
		{
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
			exit;
		}
	}
	
	public function fetchintestimates(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$maindata = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$userid = $user[0]['id'];
			$res = "";
			if(isset($_REQUEST['project_id'])){
				$table = "job_estimates_id";
				$main_table = array("$table i",array("i.*"));
				$join_tables = array(
					array('left','Finish_desc f1','f1.id = i.Finish', array('f1.id as finish_id','f1.description as Finish_type')),
					array('left','estimates_jobs e1','e1.id = i.job_id', array('e1.jobs_name as job_name')),
					array('left','int_estimates in1','in1.id = i.estimate_id', array('in1.id as estimate_id','in1.Gallons as int_Gallons','in1.Hours as int_Hours','in1.Cost as int_Cost')),
					array('left','room_types r1','r1.id = in1.SpaceType', array('r1.name as room_name')),
					array('left','projects p1','p1.id = i.project_id', array('p1.created_by as created_user')),
				);
				$condition = "i.project_id = '".$_REQUEST['project_id']."' && i.estimate_id = '".$_REQUEST['estimate_id']."'  && p1.created_by = '".$userid."' && i.status=1";
				/*echo "Condition:::: ".$condition;*/
				$res = $db->JoinFetch($main_table, $join_tables, $condition);
				/*$res = $db->Fetch("", "*","project_id='".$_REQUEST['project_id']."' && estimate_id='".$_REQUEST['estimate_id']."' && status=1");*/
			}
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Please select the project.'));
				exit;
			}
			$maindata1= array();
			while($row = mysql_fetch_assoc($res))
			{
				$maindata['int_Gallons'] = $row['int_Gallons'];
				$maindata['int_Hours'] = $row['int_Hours'];
				$maindata['int_Cost'] = $row['int_Cost'];
				$maindata['room_name'] = $row['room_name'];
				$maindata['estimate_id'] = $row['estimate_id'];
				
				$maindata1 = $maindata;
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","Main data"=>$maindata1,"data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function fetchextestimates(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			$userid = $user[0]['id'];
			if(isset($_REQUEST['project_id']))
			{
				$table = "ext_job_estimates_id";
				$main_table = array("$table i",array("i.*"));
				$join_tables = array(
					array('left','Finish_desc f1','f1.id = i.Finish', array('f1.id as finish_id','f1.description as Finish_type')),
					array('left','ext_estimates_jobs e1','e1.id = i.job_id', array('e1.jobs_name as job_name')),
					array('left','ext_estimates ex1','ex1.id = i.estimate_id', array('ex1.id as estimate_id','ex1.Gallons as ext_Gallons','ex1.Hours as ext_Hours','ex1.Cost as ext_Cost')),
					array('left','ext_room_type r1','r1.id = ex1.id', array('r1.name as room_name')),
					array('left','projects p1','p1.id = i.project_id', array('p1.created_by as created_user')),
				);
				$condition = "i.project_id = '".$_REQUEST['project_id']."' && i.estimate_id = '".$_REQUEST['estimate_id']."'  && p1.created_by = '".$userid."' && i.status=1";
				/*echo "Condition:::: ".$condition;*/
				$res = $db->JoinFetch($main_table, $join_tables, $condition);
			}
				/*$res = $db->Fetch("ext_job_estimates_id", "*","project_id='".$_REQUEST['project_id']."' && estimate_id='".$_REQUEST['estimate_id']."' && status=1");*/
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Please select the project.'));
				exit;
			}
			$maindata1= array();
			while($row = mysql_fetch_assoc($res))
			{
				/*$row['job'] = $db->FetchCellValue("ext_estimates_jobs",'jobs_name','id ="'.$row['job_id'].'"');*/
				$maindata['ext_Gallons'] = $row['ext_Gallons'];
				$maindata['ext_Hours'] = $row['ext_Hours'];
				$maindata['ext_Cost'] = $row['ext_Cost'];
				$maindata['room_name'] = $row['room_name'];
				$maindata['estimate_id'] = $row['estimate_id'];
				
				$maindata1 = $maindata;
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","Main data"=>$maindata1,"data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function fetchestjobtype(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['job_id']))
				$res = $db->Fetch("estimates_jobs", "*","id='".$_REQUEST['job_id']."'");
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Please select the project.'));
				exit;
			}
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function fetchextestjobtype(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['job_id']))
				$res = $db->Fetch("ext_estimates_jobs", "*","id='".$_REQUEST['job_id']."'");
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Please select the project.'));
				exit;
			}
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function fetchdetailintnotes(){
		
			require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['id']))
				$res = $db->Fetch("int_notes", "*","id='".$_REQUEST['id']."'");
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Please select the project.'));
				exit;
			}
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
	
	public function fetchprojectdetails(){
	
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$table = "projects";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$userid = $user_id[0]['id'];
		$main_table = array("$table i",array("i.*"));
		$join_tables = array(
			array('left','client c1','c1.id = i.Client_id', array('c1.name as client_name')),
			array('left','int_estimates in1','in1.project_id = i.id', array('in1.id as estimate_id'))
		);
		$condition = " 1=1 && i.created_by in (".$userid.") ";
		/*echo "condition::".$condition;*/
		$rs = $db->JoinFetch($main_table, $join_tables, $condition,array('i.id' => 'desc'));
			
		$result = array();
		while($row = mysql_fetch_assoc($rs))
		{
			$row['city_name'] = $row['city'];
			$row['state_name'] = $row['state'];
			$row['country_name'] = $row['country'];
			$result[] = $row;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'Projects'=>$result)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	
	}
	public function fetchextnotes(){
	
		require 'include_classes.php';
  			require 'classes/sMail.php';
			$db = new Db();
			$result = array();
			$_REQUEST = $db->FilterParameters($_REQUEST);
			$user = $this->validateobjuser2();
			if($user == 0)
			{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
				exit;
			}
			$res = "";
			if(isset($_REQUEST['project_id']))
				$res = $db->Fetch("ext_notes", "*","project_id='".$_REQUEST['project_id']."' && status=1",array('id' => 'desc'));
			else
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Please select the project.')));
				exit;
			}
			
			while($row = mysql_fetch_assoc($res))
			{
				$result[] = $row;
			}
			$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	
	}
	
	public function pricingint(){
	
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$table = "int_estimates";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$clientid = $user_id[0]['id'];
		$main_table = array("$table i",array("i.*"));
		$join_tables = array(
			array('left','room_types t1','t1.id = i.SpaceType', array('t1.name as room_name')),
			array('left','projects p1','p1.id = i.project_id', array('p1.id as projectid','p1.Address as address','p1.created_date as create_date')),
			array('left','client c1','c1.id = p1.Client_id', array('c1.id as clientid','c1.name as client_name','c1.phonenumber as client_phonenumber','c1.email as client_email'))
		);
		$condition = " 1=1 && i.project_id IN (".$_REQUEST['project_id'].") ";
		/*echo "condition::".$condition;*/
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);
			
		$client = array();
		$data1 = array();
		while($row = mysql_fetch_assoc($rs))
		{
			$row['city_name'] = $row['city'];
			$row['state_name'] = $row['state'];
			$row['country_name'] = $row['country'];
			
			$client['id'] = $row['clientid'];
			$client['client_name'] = $row['client_name'];
			$client['client_phonenumber'] = $row['client_phonenumber'];
			$client['client_email'] = $row['client_email'];
			$client['client_address'] = $row['address'];
			$client['client_city'] = $row['city_name'];
			$client['client_state'] = $row['state_name'];
			$client['client_country'] = $row['country_name'];
			$data = array();
			$data['create_date'] = $row['create_date'];
			$data['room'] = $row['room_name'];
			$data['gallon'] = $row['Gallons'];
			$data['hours'] = $row['Hours'];
			$data['cost'] = $row['Cost'];
			$data1[] = $data;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'client'=>$client,'data'=>$data1)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	
	}
	
	public function pricingext(){
	
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$table = "ext_estimates";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$clientid = $user_id[0]['id'];
		$main_table = array("$table i",array("i.*"));
		$join_tables = array(
			array('left','room_types t1','t1.id = i.SpaceType', array('t1.name as room_name')),
			array('left','projects p1','p1.id = i.project_id', array('p1.id as projectid','p1.Address as address','p1.created_date as create_date')),
			array('left','client c1','c1.id = p1.Client_id', array('c1.id as clientid','c1.name as client_name','c1.phonenumber as client_phonenumber','c1.email as client_email'))
		);
		$condition = " 1=1 && i.project_id IN (".$_REQUEST['project_id'].") ";
		/*echo "condition::".$condition;*/
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);
			
		$client = array();
		$data1 = array();
		while($row = mysql_fetch_assoc($rs))
		{
			$row['city_name'] = $row['city'];
				$row['state_name'] = $row['state'];
				$row['country_name'] = $row['country'];
				
			$client['id'] = $row['clientid'];
			$client['client_name'] = $row['client_name'];
			$client['client_phonenumber'] = $row['client_phonenumber'];
			$client['client_email'] = $row['client_email'];
			$client['client_address'] = $row['address'];
			$client['client_city'] = $row['city_name'];
			$client['client_state'] = $row['state_name'];
			$client['client_country'] = $row['country_name'];
			$data = array();
			$data['create_date'] = $row['create_date'];
			$data['room'] = $row['room_name'];
			$data['gallon'] = $row['Gallons'];
			$data['hours'] = $row['Hours'];
			$data['cost'] = $row['Cost'];
			$data1[] = $data;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'client'=>$client,'data'=>$data1)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	
	}
	
	public function listextpricing()
  	{
		require 'include_classes.php';
  		$db = new Db();
  		$table = "ext_estimates";
  		//$table = "";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' exterior_descript r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' external_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$condition = " 1=1 && r1.created_by = '".$id."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
		// echo $condition;
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);
		
		while($row = mysql_fetch_assoc($rs))
		{
			$data = array();
			$data['id'] = $row['id'];
			$data['create_date'] = $row['created_date'];
			$data['room'] = $row['room_name'];
			$data['gallon'] = $row['Gallons'];
			$data['hours'] = $row['Hours'];
			$data['cost'] = $row['Cost'];
			$data1[] = $data;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$data1)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	}
	
	public function listintpricing()
  	{
		require 'include_classes.php';
  		$db = new Db();
  		$table = "int_estimates";
  		//$table = "";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' room_types r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' internal_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$condition = " 1=1 && r1.created_by = '".$id."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
		// echo $condition;
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);
		
		while($row = mysql_fetch_assoc($rs))
		{
			$data = array();
			$data['id'] = $row['id'];
			$data['create_date'] = $row['created_date'];
			$data['room'] = $row['room_name'];
			$data['gallon'] = $row['Gallons'];
			$data['hours'] = $row['Hours'];
			$data['cost'] = $row['Cost'];
			$data1[] = $data;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$data1)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	}
	
	public function listextest()
  	{
		require 'include_classes.php';
  		$db = new Db();
  		$table = "ext_estimates";
  		//$table = "";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' exterior_descript r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' external_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$condition = " 1=1 && r1.created_by = '".$id."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
		// echo $condition;
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);
		
		while($row = mysql_fetch_assoc($rs))
		{
			$data = array();
			$data['id'] = $row['id'];
			$dateeve = date_create($row['created_date']); 
			$data['create_date'] = date_format($dateeve,"jS F Y");
			$data['room'] = $row['room_name'];
			$data['cost'] = $row['Cost'];
			$data1[] = $data;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$data1)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	}
	
	public function listintest()
  	{
		require 'include_classes.php';
  		$db = new Db();
  		$table = "int_estimates";
  		//$table = "";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' room_types r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' internal_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$condition = " 1=1 && r1.created_by = '".$id."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
		// echo $condition;
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);
		
		while($row = mysql_fetch_assoc($rs))
		{
			$data = array();
			$data['id'] = $row['id'];
			$dateeve = date_create($row['created_date']); 
			$data['create_date'] = date_format($dateeve,"jS F Y");
			$data['room'] = $row['room_name'];
			$data['cost'] = $row['Cost'];
			$data1[] = $data;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$data1)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	}
	
	public function listintproject()
  	{
		require 'include_classes.php';
  		$db = new Db();
  		$table = "int_estimates";
  		//$table = "";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' room_types r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' internal_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$condition = " 1=1 && r1.created_by = '".$id."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
		// echo $condition;
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);
		
		while($row = mysql_fetch_assoc($rs))
		{
			$data = array();
			$data['id'] = $row['id'];
			$data['create_date'] = $row['created_date'];
			$data['room'] = $row['room_name'];
			$data['Length'] = $row['Length'];
			$data['Width'] = $row['Width'];
			$data['Height'] = $row['Height'];
			$data['LN_FT'] = $row['LN_FT'];
			$data['W_FT'] = $row['W_FT'];
			$data['C_FT'] = $row['C_FT'];
			$data['gallon'] = $row['Gallons'];
			$data['hours'] = $row['Hours'];
			$data['cost'] = $row['Cost'];
			$data1[] = $data;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$data1)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
  	}
	
	public function listextproject()
  	{
		require 'include_classes.php';
  		$db = new Db();
  		$table = "ext_estimates";
  		//$table = "";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' exterior_descript r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' external_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$condition = " 1=1 && r1.created_by = '".$id."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
		// echo $condition;
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);
		
		while($row = mysql_fetch_assoc($rs))
		{
			$data = array();
			$data['id'] = $row['id'];
			$data['create_date'] = $row['created_date'];
			$data['room'] = $row['room_name'];
			$data['Length'] = $row['Length'];
			$data['Width'] = $row['Width'];
			$data['Height'] = $row['Height'];
			$data['Sq_Ft'] = $row['Sq_Ft'];
			$data['gallon'] = $row['Gallons'];
			$data['hours'] = $row['Hours'];
			$data['cost'] = $row['Cost'];
			$data1[] = $data;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$data1)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
  	}
	
	
	public function inthrstracking()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$trackingid = $db->FetchCellValue("internal_hrs_tracking","id","project_id = '".$_REQUEST['project_id']."' && created_by = ".$id);
		$row = array();
		$table88 = "internal_hrs_tracking";

		if(isset($trackingid) && $trackingid != ""){
			$condition88 = "i.project_id = '".$_REQUEST['project_id']."' ";
			$main_table88 = array("$table88 i",array("i.*"));
			$join_tables88 = array(
			array('left','internal_estimate c','c.project_id = i.project_id', array('sum(c.furniture_time) as furniture_time','sum(c.furniture_gals) as furniture_gals','sum(c.maskcover_time) as maskcover_time','sum(c.maskcover_gals) as maskcover_gals','sum(c.wallpaper_removal_time) as wallpaper_removal_time','sum(c.wallpaper_removal_gals) as wallpaper_removal_gals','sum(c.rrhardware_time) as rrhardware_time','sum(c.rrhardware_gals) as rrhardware_gals','sum(c.prepwoodwork_time) as prepwoodwork_time','sum(c.prepwoodwork_gals) as prepwoodwork_gals','sum(c.patchtexture_gals) as patchtexture_gals','sum(c.patchtexture_time) as patchtexture_time','sum(c.skimcoat_time) as skimcoat_time','sum(c.skimcoat_gals) as skimcoat_gals','sum(c.polesand_time) as polesand_time','sum(c.polesand_gals) as polesand_gals','sum(c.wprime_time) as wprime_time','sum(c.wprime_gals) as wprime_gals','sum(c.wpaint09_time) as wpaint09_time','sum(c.wpaint9_time) as wpaint9_time','sum(c.wpaint09_gals) as wpaint09_gals','sum(c.wpaint9_gals) as wpaint9_gals','sum(c.cprime_time) as cprime_time','sum(c.cprime_gals) as cprime_gals','sum(c.cpaint_time) as cpaint_time','sum(c.cw_time_time) as cw_time_time','sum(c.cpaint_gals) as cpaint_gals','sum(c.cw_time_gals) as cw_time_gals','sum(c.dflat_time) as dflat_time','sum(c.dpaneled_time) as dpaneled_time','sum(c.dfrench_time) as dfrench_time','sum(c.dframes_time) as dframes_time','sum(c.dtime_time) as dtime_time','sum(c.dflat_gals) as dflat_gals','sum(c.dpaneled_gals) as dpaneled_gals','sum(c.dfrench_gals) as dfrench_gals','sum(c.dframes_gals) as dframes_gals','sum(c.dtime_gals) as dtime_gals','sum(c.wcasement_time) as wcasement_time','sum(c.w1_1_time) as w1_1_time','sum(c.w3_7_panel_time) as w3_7_panel_time','sum(c.w8_16_panel_time) as w8_16_panel_time','sum(c.w16_panel_time) as w16_panel_time','sum(c.wtime_time) as wtime_time','sum(c.wcasement_gals) as wcasement_gals','sum(c.w1_1_gals) as w1_1_gals','sum(c.w3_7_panel_gals) as w3_7_panel_gals','sum(c.w8_16_panel_gals) as w8_16_panel_gals','sum(c.w16_panel_gals) as w16_panel_gals','sum(c.wtime_gals) as wtime_gals','sum(c.baseboards_time) as baseboards_time','sum(c.baseboardstime_time) as baseboardstime_time','sum(c.baseboards_gals) as baseboards_gals','sum(c.baseboardstime_gals) as baseboardstime_gals','sum(c.chairrail_time) as chairrail_time','sum(c.chairrail_time_time) as chairrail_time_time','sum(c.chairrail_gals) as chairrail_gals','sum(c.chairrail_time_gals) as chairrail_time_gals','sum(c.crownmolding_time) as crownmolding_time','sum(c.crownmolding_time_time) as crownmolding_time_time','sum(c.crownmolding_gals) as crownmolding_gals','sum(c.crownmolding_time_gals) as crownmolding_time_gals','sum(c.closets_time) as closets_time','sum(c.closets_gals) as closets_gals','sum(c.cabinetry_time) as cabinetry_time','sum(c.cabinetry_gals) as cabinetry_gals','sum(c.cleantouchup_time) as cleantouchup_time','sum(c.cleantouchup_gals) as cleantouchup_gals','sum(c.faux_time) as faux_time','sum(c.faux_gals) as faux_gals','sum(c.miscellaneous1_time) as miscellaneous1_time','sum(c.miscellaneous2_time) as miscellaneous2_time','sum(c.miscellaneous3_time) as miscellaneous3_time','sum(c.miscellaneous1_gals) as miscellaneous1_gals','sum(c.miscellaneous2_gals) as miscellaneous2_gals','sum(c.miscellaneous3_gals) as miscellaneous3_gals'))
			);
			$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
			$row = mysql_fetch_assoc($rs1);
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$row)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	}
	
	public function exthrstracking()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$trackingid = $db->FetchCellValue("external_hrs_tracking","id","project_id = '".$_REQUEST['project_id']."' && created_by = ".$id);
		$row = array();
		$table88 = "external_hrs_tracking";

		if(isset($trackingid) && $trackingid != ""){
			$condition88 = "i.project_id = '".$_REQUEST['project_id']."' ";
			$main_table88 = array("$table88 i",array("i.*"));
			$join_tables88 = array(
			array('left','external_estimate c','c.project_id = i.project_id', array('sum(c.scraping_time) as scraping_time','sum(c.scraping_gals) as scraping_gals','sum(c.patch_time) as patch_time','sum(c.patch_gals) as patch_gals','sum(c.feather_time) as feather_time','sum(c.feather_gals) as feather_gals','sum(c.flexible_time) as flexible_time','sum(c.flexible_gals) as flexible_gals','sum(c.caulking_time) as caulking_time','sum(c.caulking_gals) as caulking_gals','sum(c.pressure_time) as pressure_time','sum(c.pressure_gals) as pressure_gals','sum(c.roof_time) as roof_time','sum(c.roof_gals) as roof_gals','sum(c.spot_time) as spot_time','sum(c.spot_gals) as spot_gals','sum(c.remove_lights_time) as remove_lights_time','sum(c.remove_screens_time) as remove_screens_time','sum(c.remove_other_time) as remove_other_time','sum(c.remove_lights_gals) as remove_lights_gals','sum(c.remove_screens_gals) as remove_screens_gals','sum(c.remove_other_gals) as remove_other_gals','sum(c.wash_time) as wash_time','sum(c.wash_gals) as wash_gals','sum(c.pressurewashdeck_time) as pressurewashdeck_time','sum(c.pressurewashdeck_gals) as pressurewashdeck_gals','sum(c.maskwindowsdoors_time) as maskwindowsdoors_time','sum(c.maskwindowsdoors_gals) as maskwindowsdoors_gals','sum(c.maskother_time) as maskother_time','sum(c.maskother_gals) as maskother_gals','sum(c.eavessingle_time) as eavessingle_time','sum(c.eavestwo_time) as eavestwo_time','sum(c.eaveseasy_time) as eaveseasy_time','sum(c.eaveshard_time) as eaveshard_time','sum(c.eavessingle_gals) as eavessingle_gals','sum(c.eavestwo_gals) as eavestwo_gals','sum(c.eaveseasy_gals) as eaveseasy_gals','sum(c.eaveshard_gals) as eaveshard_gals','sum(c.fasciasingle_time) as fasciasingle_time','sum(c.fasciatwo_time) as fasciatwo_time','sum(c.fasciasingle_gals) as fasciasingle_gals','sum(c.fasciatwo_gals) as fasciatwo_gals','sum(c.metalflashing_time) as metalflashing_time','sum(c.metalflashing_gals) as metalflashing_gals','sum(c.raingutters_time) as raingutters_time','sum(c.raingutters_gals) as raingutters_gals','sum(c.shutters_time) as shutters_time','sum(c.shutters_gals) as shutters_gals','sum(c.windowstrim_time) as windowstrim_time','sum(c.windows2pane_time) as windows2pane_time','sum(c.windows37pane_time) as windows37pane_time','sum(c.windows815pane_time) as windows815pane_time','sum(c.windows16pane_time) as windows16pane_time','sum(c.windowstrim_gals) as windowstrim_gals','sum(c.windows2pane_gals) as windows2pane_gals','sum(c.windows37pane_gals) as windows37pane_gals','sum(c.windows815pane_gals) as windows815pane_gals','sum(c.windows16pane_gals) as windows16pane_gals','sum(c.doorsflat_time) as doorsflat_time','sum(c.doorslight_time) as doorslight_time','sum(c.doorspaneled_time) as doorspaneled_time','sum(c.doorsfrench_time) as doorsfrench_time','sum(c.doorsflat_gals) as doorsflat_gals','sum(c.doorslight_gals) as doorslight_gals','sum(c.doorspaneled_gals) as doorspaneled_gals','sum(c.doorsfrench_gals) as doorsfrench_gals','sum(c.garagedoor_time) as garagedoor_time','sum(c.garagedoor_gals) as garagedoor_gals','sum(c.garagedoorframe_time) as garagedoorframe_time','sum(c.garagedoorframe_gals) as garagedoorframe_gals','sum(c.entrydoor_time) as entrydoor_time','sum(c.entrydoor_gals) as entrydoor_gals','sum(c.postspillars_time) as postspillars_time','sum(c.postspillars_gals) as postspillars_gals','sum(c.wroughtiron_time) as wroughtiron_time','sum(c.wroughtiron_gals) as wroughtiron_gals','sum(c.stuccosingle_time) as stuccosingle_time','sum(c.stuccotwo_time) as stuccotwo_time','sum(c.stuccosingle_gals) as stuccosingle_gals','sum(c.stuccotwo_gals) as stuccotwo_gals','sum(c.sidingsingle_time) as sidingsingle_time','sum(c.sidingtwo_time) as sidingtwo_time','sum(c.sidingsingle_gals) as sidingsingle_gals','sum(c.sidingtwo_gals) as sidingtwo_gals','sum(c.bodypaint_time) as bodypaint_time','sum(c.bodypaint_gals) as bodypaint_gals','sum(c.miscellaneous_time) as miscellaneous_time','sum(c.miscellaneous1_time) as miscellaneous1_time','sum(c.miscellaneous2_time) as miscellaneous2_time','sum(c.miscellaneous_gals) as miscellaneous_gals','sum(c.miscellaneous1_gals) as miscellaneous1_gals','sum(c.miscellaneous2_gals) as miscellaneous2_gals')));
			$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
			$row = mysql_fetch_assoc($rs1);
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$row)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	}
	
	public function calculateestimate(){
		
	require 'include_classes.php';
	$db = new Db();
	$result = "";
	$rate = "";
	$arr= array();
	$response= array();
	$_REQUEST = $db->FilterParameters($_REQUEST);
	$user = $this->validateobjuser2();
	if($user == 0)
	{	echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
		exit;
	}
	
		if(isset( $_REQUEST['coats']) &&  $_REQUEST['coats'] !="")
		{	$coat = $_REQUEST['coats'];
			$response['coats'] = $_REQUEST['coats'];
		}else{
			$response['coats'] = "0";
		}
		switch ($coat) {
			case "1":
				$rate = $db->FetchCellValue("default_production_rate",'coat_1','production_item ="'.$_REQUEST['job_items'].'" ');
				$response['rates'] = $rate;
				break;
			case "2":
				$rate = $db->FetchCellValue("default_production_rate",'coat_2','production_item ="'.$_REQUEST['job_items'].'" ');
				$response['rates'] = $rate;
				break;
			case "3":
				$rate = $db->FetchCellValue("default_production_rate",'coat_3','production_item ="'.$_REQUEST['job_items'].'" ');
				$response['rates'] = $rate;
				break;
			case "4":
				$rate = $db->FetchCellValue("default_production_rate",'coat_4','production_item ="'.$_REQUEST['job_items'].'" ');
				$response['rates'] = $rate;
				break;
			default:
				$response['rates'] = "0";
				break;
		}
		
		$unit = $_REQUEST['unit'];
		if($unit == "Hours"){
			$response['time'] = $_REQUEST['quantity'];
		}
		else if($unit == "Each"){
			$response['time'] = $_REQUEST['quantity'] * $rate;
		}
		else if(isset($unit) && ($unit = "Ln. Ft." || $unit = "Sq. Ft.")){
			/*$job = $_REQUEST['job_id'];
				switch ($job) {
					case "4":
					case "8":
					case "10":
					case "11":
					case "37":
						$_REQUEST['quantity'] = $wft;
						break;
					case "38":
					case "39":
						$_REQUEST['quantity'] = $cft;
						break;
					case "21":
					case "22":
					case "23":
						$_REQUEST['quantity'] = $lnft;
						break;
					case "9":
						$rate = $db->FetchCellValue("default_production_rate",'coat_1','job_id ="'.$_REQUEST['job_id'].'" && type= "int_type"');
						$_REQUEST['Rates'] = $rate;
						break;
				}*/
				$response['time'] = $_REQUEST['quantity'] / $rate;
		}
		
		if(isset($_REQUEST['gals']) && $_REQUEST['gals'] != "")
		{
			$response['gals'] = $_REQUEST['gals'] ;
		}
		else{
				if(isset($_REQUEST['job_items']) && $_REQUEST['job_items'] == 8){
					$spread = $db->FetchCellValue("default_production_rate",'coat_1','job_id ="10" && type= "int_type"');
				} 
				else {
					$spread = $db->FetchCellValue("default_production_rate",'spread','production_item ="'.$_REQUEST['job_items'].'" ');
				}
				if(isset( $_REQUEST['coats']) &&  $_REQUEST['coats'] !="")
					$response['gals'] = ($_REQUEST['quantity'] * $_REQUEST['coats']) / $spread;
				else
					$response['gals'] = "0";
		}
		
		echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'id'=>$response)));
		exit;			
	}
	
	
	public function deleteextest()
	{
		require 'include_classes.php';
		$db = new Db();
		$table = "ext_estimates";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		if($db->delete($table,$table_id,$id))
		{
			if($db->delete('external_estimate','estimate_id',$id))
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","msg"=>"Record Deleted successfully.")));
				exit;
			}
			else
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
				exit;
			}
		}
		else
		{
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
			exit;
		} 
	}
	
	public function deleteintest()
	{
		require 'include_classes.php';
		$db = new Db();
		$table = "int_estimates";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		if($db->delete($table,$table_id,$id))
		{
			if($db->delete('internal_estimate','estimate_id',$id))
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","msg"=>"Record Deleted successfully.")));
				exit;
			}
			else
			{
				echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
				exit;
			}
		}
		else
		{
			echo str_replace(':""',':"nullstring"',json_encode(array("success"=>"0",'msg'=>'Problem in delete.')));
			exit;
		}
	}
	
	
	public function addinthrstracking() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "internal_hrs_tracking";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$user = $this->validateobjuser2();
		if($user == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user_id = $user[0]['id'];
		$trackingid = $db->FetchCellValue("internal_hrs_tracking","id","project_id = '".$_REQUEST['project_id']."' && created_by = ".$user_id);
		$_REQUEST['created_by'] = $user_id;
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($trackingid) && $trackingid > 0)
			{
				$id = $_REQUEST['id'];
				$result2 = $db->Update($table,$_REQUEST,"id",$trackingid);
				if($result2)
				{
					echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
					exit;
				}
				else 
				{
					echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
					exit;
				}
			}
			else
			{ 
				
				$result = $db->Insert($table, $_REQUEST, 1);
				if($result > 0)
				{
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
				}
				else
				{
					 echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				}
				exit;
			}
		}
		else{	
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function addexthrstracking() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "external_hrs_tracking";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$user = $this->validateobjuser2();
		if($user == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$user_id = $user[0]['id'];
		$trackingid = $db->FetchCellValue("external_hrs_tracking","id","project_id = '".$_REQUEST['project_id']."' && created_by = ".$user_id);
		$_REQUEST['created_by'] = $user_id;
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($trackingid) && $trackingid > 0)
			{
				$id = $_REQUEST['id'];
				$result2 = $db->Update($table,$_REQUEST,"id",$trackingid);
				if($result2)
				{
					echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
					exit;
				}
				else 
				{
					echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
					exit;
				}
			}
			else
			{ 
				
				$result = $db->Insert($table, $_REQUEST, 1);
				if($result > 0)
				{
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
				}
				else
				{
					 echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				}
				exit;
			}
		}
		else{	
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function addcabtackoff() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "cabtakeoff";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$user = $this->validateobjuser2();
		if($user == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$trackingid = $db->FetchCellValue($table,"id","project_id = '".$_REQUEST['project_id']."' ");
		/*$user_id = $user[0]['id'];*/
		$_REQUEST['status'] = '1';
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($trackingid) && $trackingid > 0)
			{
				$result2 = $db->Update($table,$_REQUEST,"id",$trackingid);
				if($result2)
				{
					echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
					exit;
				}
				else
				{
					echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
					exit;
				}
			}
			else
			{
				
				$result55 = $db->Insert($table, $_REQUEST, 1);
				if($result55 > 0)
				{
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
				}
				else
				{
					 echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				}
				exit;
			}
		}
		else{	
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function listcabtackoff() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$row = array();
		$table88 = "cabtakeoff";
		$trackingid = $db->FetchCellValue("cabtakeoff","id","project_id = '".$_REQUEST['project_id']."' ");
		echo "T ID".$trackingid;
		if(isset($trackingid) && $trackingid != "")
		{
			$condition88 = "i.id = '".$trackingid ."'";
			$main_table88 = array("$table88 i",array("i.*"));
			$join_tables88 = array();
			$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
			$row = mysql_fetch_assoc($rs1);
			$row['LaborRate'] = $db->FetchCellValue("Interior_Rate","interior","rate_type = 'paint' ");
			$row['Material'] = $db->FetchCellValue("Interior_Rate","interior","rate_type = 'Material %' ");
		}
		else
		{
			$row['LaborRate'] = $db->FetchCellValue("Interior_Rate","interior","rate_type = 'paint' ");
			$row['Material'] = $db->FetchCellValue("Interior_Rate","interior","rate_type = 'Material %' ");
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$row)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
	}
	
	public function listallclients()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$table = "projects";
  		//$table = "";
		$table_id = 'id';
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$uid = $user_id[0]['id'];
		$condition = "" ;
  		$items = "";
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' client r','r.id = i.Client_id', array('r.name as client_name','r.phonenumber as phonenum','r.email as mailid'))
		);
		
		$result = array();
		
		$condition = " 1=1 && i.created_by = ".$uid;
		
		// echo $condition;
		$rs = $db->JoinFetch($main_table, $join_tables, $condition);
		
		while($row = mysql_fetch_object($rs))
		{				
			//echo "here";
			if(isset($row->city)){$city_name = ",".$row->city;} else {$city_name = "";}
			if(isset($row->state)){$state_name = ",".$row->state;} else {$state_name = "";}
			$temp = array();
			$temp['id'] = $row->id;
			$temp['name'] = $row->client_name;
			$temp['city_id'] = $row->City;
			$temp['city_name'] = $row->city;
			$temp['state_id'] = $row->State;
			$temp['state_name'] = $row->state;
			$temp['country_id'] = $row->country;
			$temp['country_name'] = $row->country;
			$temp['name'] = $row->client_name;
			$temp['Address'] = $row->Address."".$city."".$state;
			$temp['primary_phonenum'] = $row->phonenum;
			$temp['primary_mailid'] = $row->mailid;
			array_push($result, $temp);
			$count++;
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$result)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
  	}
	
	public function editclient()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "projects";
		$table_id = 'id';
		$result = "";
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$uid = $user_id[0]['id'];
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$id = $_REQUEST['id'];
			if(isset($_REQUEST['Address']) && $_REQUEST['Address'] != "")
			{
				$data1['Address'] = $_REQUEST['address'];
			}
			if(isset($_REQUEST['State']) && $_REQUEST['State'] != "")
			{
				$data1['State'] = $_REQUEST['State'];
			}
			if(isset($_REQUEST['City']) && $_REQUEST['City'] != "")
			{
				$data1['City'] = $_REQUEST['City'];
			}
			if(isset($_REQUEST['country']) && $_REQUEST['country'] != "")
			{
				$data1['country'] = $_REQUEST['country'];
			}
			if(isset($_REQUEST['name']) && $_REQUEST['name'] != "")
			{	$data2['name'] = $_REQUEST['name'];
			}
			if(isset($_REQUEST['phonenumber']) && $_REQUEST['phonenumber'] != "")
			{	$data2['phonenumber'] = $_REQUEST['phonenumber'];
			}
			if(isset($_REQUEST['email']) && $_REQUEST['email'] != "")
			{
				$data2['email'] = $_REQUEST['email'];
			}
			$result2 = $db->Update($table,$data1,"id",$id);
			$clientid = $db->FetchCellValue($table,"Client_id","id = '".$id."' ");
			$result3 = $db->Update('client',$data2,"id",$clientid);
			if($result2 || $result3)
			{
				echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
				exit;
			}
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
				exit;
			}
		}
		else
		{
			echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
			exit;
		}
	}
	
	public function editclient1()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "projects";
		$table_id = 'id';
		$result = "";
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$uid = $user_id[0]['id'];
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$id = $_REQUEST['id'];
			if(isset($_REQUEST['Address']) && $_REQUEST['Address'] != "")
			{
				$data1['Address'] = $_REQUEST['address'];
			}
			if(isset($_REQUEST['State']) && $_REQUEST['State'] != "")
			{
				$data1['State'] = $_REQUEST['State'];
			}
			if(isset($_REQUEST['City']) && $_REQUEST['City'] != "")
			{
				$data1['City'] = $_REQUEST['City'];
			}
			if(isset($_REQUEST['country']) && $_REQUEST['country'] != "")
			{
				$data1['country'] = $_REQUEST['country'];
			}
			if(isset($_REQUEST['name']) && $_REQUEST['name'] != "")
			{	$data2['name'] = $_REQUEST['name'];
			}
			if(isset($_REQUEST['phonenumber']) && $_REQUEST['phonenumber'] != "")
			{	$data2['phonenumber'] = $_REQUEST['phonenumber'];
			}
			if(isset($_REQUEST['email']) && $_REQUEST['email'] != "")
			{
				$data2['email'] = $_REQUEST['email'];
			}
			$result2 = $db->Update($table,$data1,"id",$id);
			$clientid = $db->FetchCellValue($table,"Client_id","id = '".$id."' ");
			$result3 = $db->Update('client',$data2,"id",$clientid);
			if($result2 || $result3)
			{
				echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .'));
				exit;
			}
			else
			{
				echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
				exit;
			}
		}
		else
		{
			echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
			exit;
		}
	}
	
	public function production_rates()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$id = $user_id[0]['id'];
		$result = array();
		$row = array();
		$table88 = "default_production_rate";

		$main_table88 = array("$table88 i",array("i.*"));
		$join_tables88 = array(
		);
		$condition88 = " i.project_id = '".$_REQUEST['project_id']."' ";
		$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
		
		while($row = mysql_fetch_assoc($rs1))
		{
			$result[] = $row;
		}
		
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1",'data'=>$result)));
		echo str_replace(':null',':"nullstring"',$tempstring);
		exit;
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
		$user_id = $this->validateobjuser2();
		if($user_id == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		$intid = $user_id[0]['id'];
		$_REQUEST = $db->FilterParameters($_REQUEST);
		
		$_REQUEST['password'] = md5($_REQUEST['password']);
		
		if(isset($intid) && $intid != "")
		{
			$result2 = $db->Update($table,$_REQUEST,"id",$intid);
			$main_table = array("$table i",array("i.*"));
			
			$join_tables = array();
			$condition = "(i.id = '{$intid}')";
			$rs = $db->JoinFetch($main_table, $join_tables, $condition);
			  
			while($row = mysql_fetch_assoc($rs))
			{
				$row['city_name'] = $row['city'];
				$row['state_name'] = $row['state'];
				$row['country_name'] = $row['country'];
			   $result[] = $row;
			}
			echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .','data'=>$result));
			exit;
		}
		else
		{
			echo json_encode(array("success"=>"0",'msg'=>'Problem in data Update.'));
			exit;
		}
	}
	
	public function addinternalroomtype() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "room_types";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		
		if(isset($_REQUEST['name']) && $_REQUEST['name'] != "" )
		{
			$result55 = $db->Insert($table, $_REQUEST, 1);
			echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
			exit;
		}
		else
		{	
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function addexternalroomtype() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "ext_room_type";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		
		if(isset($_REQUEST['name']) && $_REQUEST['name'] != "" )
		{
			$result55 = $db->Insert($table, $_REQUEST, 1);
			echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
			exit;
		}
		else
		{	
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function fetchrate()
	{
		 include_once('include_classes.php');
		 
		$db = new Db();
		$result = array();
		$table88 = "Interior_Rate";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		
		$user = $this->validateobjuser2();
		if($user == 0)
		{	
			echo json_encode(array("success"=>"0",'msg'=>'Username or password incorrect'));
			exit;
		}
		if(isset($_REQUEST['project_id'])){
			$condition88 = "i.project_id = '".$_REQUEST['project_id']."' ";
			$main_table88 = array("$table88 i",array("i.*"));
			$join_tables88 = array();
			$rs = $db->JoinFetch($main_table88, $join_tables88, $condition88);
			  
			while($row = mysql_fetch_assoc($rs))
			{
			   $result[] = $row;
			}
		}
		$tempstring = str_replace(':""',':"nullstring"',json_encode(array("success"=>"1","data"=>$result)));
			echo str_replace(':null',':"nullstring"',$tempstring);
			exit;
	}
}

?>