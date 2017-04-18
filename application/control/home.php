<?php
class Home  extends Controller 
{
	public function index()
	{
		parent::__construct();
		$this->view->admin("home/index");
	}
	public function notes()
	{
		parent::__construct();
		$this->view->admin("home/notes");
	}
	public function listnotes()
	{
		parent::__construct();
		$this->view->admin("home/listnotes");
	}
	public function projects()
	{
		parent::__construct();
		$this->view->admin("home/projects");
	}
	public function listprojects()
	{
		parent::__construct();
		$this->view->admin("home/listprojects");
	}
	public function externalnote()
	{
		parent::__construct();
		$this->view->admin("home/externalnote");
	}
	public function internalnote()
	{
		parent::__construct();
		$this->view->admin("home/internalnote");
	}
	public function listexternalnote()
	{
		parent::__construct();
		$this->view->admin("home/listexternalnote");
	}
	public function listinternalnotes()
	{
		parent::__construct();
		$this->view->admin("home/listinternalnotes");
	}
	public function changpwd()
	{
		parent::__construct();
		$this->view->admin("home/changpwd");
	}
	public function changepassword()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "admin_member";
		$table_id = 'id';
		
		$new_password = $_POST['new_password'];
		$cnf_password = $_POST['password'];
		$old_password = $_POST['old_password'];
		$id = $_SESSION['samajadmin']['id'];
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
	
	public function add_note(){
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
		
		$table = "notes";
		$table_id = 'id';
		
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
		
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$result5 = $db->Update($table, $_REQUEST,'id',$_REQUEST['id']);
				if($result5)
				{
					$_SESSION["samajadmin"]['msg']= "Note Updated.";		
					$_SESSION["samajadmin"]['msg_type']="1";
					echo json_encode(array('msg'=>'success','message'=>'Note Updated.','id'=>$_REQUEST['id']));
					exit;
				}
				else
				{  
					echo json_encode(array('msg'=>'Problem in data insert.'));
					exit;
				}  
			}
			else
			{
				$result = $db->Insert($table, $_REQUEST, 1);
				if($result > 0)
				{
					$_SESSION["samajadmin"]['msg']= "Note Inserted.";		
					$_SESSION["samajadmin"]['msg_type']="1";
					echo json_encode(array('msg'=>'success','message'=>'Note Inserted.','id'=>$result));
					exit;
				}
				else
				{  
					echo json_encode(array('msg'=>'Problem in data insert.'));
					exit;
				}  
			}
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
		
	}
	
	
	public function delete()
	{
		require 'include_classes.php';
		$db = new Db();
		
		$table = "user";
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
	  
	  /*$core->RedirectTo(SITE_ROOT."/home/datatable");*/
  
   }
   
	
	public function __call($method, $args) 
	{
		require 'application/control/error.php';
		$controller=new Error();
		return false;
  	} 
	
	
	public function listallnotes()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "notes";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' lov r','r.id = i.type', array('r.value as note_type'))
		);
		
		$colArray = array('i.id','i.title','i.description','r.value');
	
		$page = $_GET['start'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['length'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition = " ( ";
		}
		
		for($i=1;$i<4;$i++)
		{
			if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
			{
				if($condition==" ( ")
					$condition .= " $colArray[$i] like '%".$_GET['search']['value']."%'";
				else
					$condition .= " or $colArray[$i] like '%".$_GET['search']['value']."%'";
			}
		}
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition .= " ) ";
		}
		
		if($condition=="")
			$condition = " 1=1 && i.created_by = ".$_SESSION['samajadmin']['id'] ;
		else
			$condition .= " && i.created_by = ".$_SESSION['samajadmin']['id'];
		
		// echo $condition;
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
			array_push($temp, $count);
			array_push($temp, $row->title);
			array_push($temp, $row->description);
			array_push($temp, $row->note_type);
			$actionCol = "";
			$actionCol .='<a href="'.SITE_ROOT.'/home/notes?id='.$row->id.'&project_id='.$row->project_id.'"  title="Edit"><i class="icon-pencil"></i></a>';
			$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteData(\''.$row->id.'\');" title="Delete"><i class="icon-trash"></i></a>';
			array_push($temp, $actionCol);
			array_push($items, $temp);
			$count++;
		}
		//print_r($items);die;
		$result["data"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function addnewproject() 
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
			$result2 = $db->Update('projects',$_REQUEST,"id",$intid);
			$client_id = $db->FetchCellValue("projects",'Client_id','id ="'.$_REQUEST['id'].'"');
			$client['name'] = $_REQUEST['client_name']; 
			$client['phonenumber'] = $_REQUEST['phonenumber']; 
			$client['email'] = $_REQUEST['email']; 
			$result2 = $db->Update('client',$client,"id",$client_id);
			echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .','project_id'=>$_REQUEST['id']));
			exit;
		}
		else
		{
			if(isset($_REQUEST['client_name']) && $_REQUEST['client_name']!="")
			{ 
		
				$data['name'] = $_REQUEST['client_name'];
				$data['phonenumber'] = $_REQUEST['phonenumber'];
				$data['email'] = $_REQUEST['email'];
				$result = $db->Insert('client', $data, 1);
				
				$_REQUEST['deposit_percent'] = '10';
				$_REQUEST['maximum_deposit'] = '1000000';
				$_REQUEST['levels_of_prep'] = '0';
				$_REQUEST['Client_id'] = $result;
				$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
				$_REQUEST['status'] = 1;
				$result55 = $db->Insert('projects', $_REQUEST, 1);
				
				$result66 = $db->Query("INSERT INTO default_production_rate(production_item,description,rate,unit,coat_1,coat_2,coat_3,coat_4,spread,factor,class,section,project_id,client_id)SELECT production_item,description,rate,unit,coat_1,coat_2,coat_3,coat_4,spread,factor,class,section,'".$result55."','".$_SESSION['samajadmin']['id']."' FROM default_production_rate WHERE project_id = '0'");
				
				$result67 = $db->Query("INSERT INTO Interior_Rate (rate_type,interior,exterior,project_id)SELECT rate_type,interior,exterior,'".$result55."' FROM Interior_Rate WHERE project_id = '0'");
				
				$result68 = $db->Query("INSERT INTO level_of_preparation (level,percentage,project_id)SELECT level,percentage,'".$result55."' FROM level_of_preparation WHERE project_id = '0'");
				
				if($result55 > 0)
				{
					
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .','project_id'=>$result55));
				}
				else
				{
				
					 echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				}
			}
			else
			{
				 echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
			}
			exit;
		}
	}
	
	public function listallprojects()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "projects";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'desc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' client r','r.id = i.Client_id', array('r.name as client_name'))
		);
		
		$colArray = array('i.id','i.date','r.name','i.Address','i.phonenumber','i.email');
	
		$page = $_GET['start'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['length'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition = " ( ";
		}
		
		for($i=1;$i<6;$i++)
		{
			if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
			{
				if($condition==" ( ")
					$condition .= " $colArray[$i] like '%".$_GET['search']['value']."%'";
				else
					$condition .= " or $colArray[$i] like '%".$_GET['search']['value']."%'";
			}
		}
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition .= " ) ";
		}
		
		if($condition=="")
			$condition = " 1=1 && i.created_by = ".$_SESSION['samajadmin']['id'] ;
		else
			$condition .= " && i.created_by = ".$_SESSION['samajadmin']['id'];
		
		// echo $condition;
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
			array_push($temp, 'OSE'.str_pad($row->id,7,"0",STR_PAD_LEFT));
			array_push($temp, $row->project_name);
			array_push($temp, $row->Date);
			array_push($temp, $row->client_name);
			//array_push($temp, $row->Address);
			array_push($temp, $row->phonenumber);
			array_push($temp, $row->email);
			$actionCol = "";
			$actionCol .='<a style="margin-right:10px;" href="'.SITE_ROOT.'/project/dashboard?project_id='.$row->id.'"  title="View Project"><i class="mdi-action-view-quilt"></i></a>';
			$actionCol .='<a href="'.SITE_ROOT.'/home/projects?id='.$row->id.'"  title="Edit"><i class="mdi-editor-mode-edit"></i></a>';
			$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteData(\''.$row->id.'\');" title="Delete"><i class="mdi-action-delete"></i></a>';
			array_push($temp, $actionCol);
			array_push($items, $temp);
			$count++;
		}
		//print_r($items);die;
		$result["data"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function deletenotes()
	{
	   require 'include_classes.php';
		$db = new Db();
		$table = "notes";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		
		if($db->delete($table,$table_id,$id))
		{
			$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
		}
		else
		{
		   $_SESSION["samajadmin"]['msg']= "Record deletion fails123456.";
		   $_SESSION["samajadmin"]['msg_type']="0";
		}
		$core->RedirectTo(SITE_ROOT."/home/listnotes");
	}
	
	public function deleteprojects()
	{
	   require 'include_classes.php';
		$db = new Db();
		$table = "projects";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		
		if($db->delete($table,$table_id,$id))
		{
			$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
		}
		else
		{
		   $_SESSION["samajadmin"]['msg']= "Record deletion fails123456.";
		   $_SESSION["samajadmin"]['msg_type']="0";
		}
		$core->RedirectTo(SITE_ROOT."/home/listprojects");
	}
	
	public function listextnotes()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "ext_notes";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			/*array('left',' client r','r.id = i.Client_id', array('r.name as client_name'))*/
		);
		
		$colArray = array('i.id','i.created_date','i.notes_name','i.notes_desc');
	
		$page = $_GET['start'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['length'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition = " ( ";
		}
		
		for($i=1;$i<3;$i++)
		{
			if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
			{
				if($condition==" ( ")
					$condition .= " $colArray[$i] like '%".$_GET['search']['value']."%'";
				else
					$condition .= " or $colArray[$i] like '%".$_GET['search']['value']."%'";
			}
		}
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition .= " ) ";
		}
		
		if($condition=="")
			$condition = " 1=1 && i.created_by = ".$_SESSION['samajadmin']['id']." && project_id = ".$_REQUEST['project_id'] ;
		else
			$condition .= " && i.created_by = ".$_SESSION['samajadmin']['id']." && project_id = ".$_REQUEST['project_id'];
		
		// echo $condition;
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
			$dateeve = date_create($row->created_date);
			$formatdate = date_format($dateeve,"jS F Y"); 
			
			$temp = array();
			//array_push($temp, $count);
			array_push($temp, $formatdate);
			array_push($temp, $row->notes_name);
			array_push($temp, $row->notes_desc);
			$actionCol = "";
			$actionCol .='<a href="'.SITE_ROOT.'/home/externalnote?id='.$row->id.'&project_id='.$_REQUEST['project_id'].'"  title="Edit"><i class="icon-pencil"></i></a>';
			$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteData(\''.$row->id.'\');" title="Delete"><i class="icon-trash"></i></a>';
			array_push($temp, $actionCol);
			array_push($items, $temp);
			$count++;
		}
		//print_r($items);die;
		$result["data"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function listintnotes()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "int_notes";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			/*array('left',' client r','r.id = i.Client_id', array('r.name as client_name'))*/
		);
		
		$colArray = array('i.id','i.created_date','i.notes_name','i.Description');
	
		$page = $_GET['start'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['length'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition = " ( ";
		}
		
		for($i=1;$i<3;$i++)
		{
			if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
			{
				if($condition==" ( ")
					$condition .= " $colArray[$i] like '%".$_GET['search']['value']."%'";
				else
					$condition .= " or $colArray[$i] like '%".$_GET['search']['value']."%'";
			}
		}
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition .= " ) ";
		}
		
		if($condition=="")
			$condition = " 1=1 && i.created_by = ".$_SESSION['samajadmin']['id']." && project_id = ".$_REQUEST['project_id'] ;
		else
			$condition .= " && i.created_by = ".$_SESSION['samajadmin']['id']." && project_id = ".$_REQUEST['project_id'];
		
		// echo $condition;
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
			
			$dateeve = date_create($row->created_date);
			$formatdate = date_format($dateeve,"jS F Y"); 
	
			$temp = array();
			//array_push($temp, $count);
			array_push($temp, $formatdate);
			array_push($temp, $row->notes_name);
			array_push($temp, $row->Description);
			$actionCol = "";
			$actionCol .='<a href="'.SITE_ROOT.'/home/internalnote?project_id='.$row->project_id.'&id='.$row->id.'"  title="Edit"><i class="icon-pencil"></i></a>';
			$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteData(\''.$row->id.'\');" title="Delete"><i class="icon-trash"></i></a>';
			array_push($temp, $actionCol);
			array_push($items, $temp);
			$count++;
		}
		//print_r($items);die;
		$result["data"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
  	}
	
	public function deleteextnotes()
	{
	   require 'include_classes.php';
		$db = new Db();
		$table = "ext_notes";
		$table_id = 'id';
		$id = $_REQUEST['id'];
		
		if($db->delete($table,$table_id,$id))
		{
			$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
		}
		else
		{
		   $_SESSION["samajadmin"]['msg']= "Record deletion fails123456.";
		   $_SESSION["samajadmin"]['msg_type']="0";
		}
		$core->RedirectTo(SITE_ROOT."/home/listexternalnote");
	}
	
	
	public function addextnotes() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "ext_notes";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
		$id = $_REQUEST['id'];
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				
				$result2 = $db->Update($table,$_REQUEST,"id",$id);
				if($result2)
				{
					$_SESSION["samajadmin"]['msg']= "Record Update successfully.";
					echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .','id'=>$_REQUEST['id']));
					exit;
				}
				else
				{
					$_SESSION["samajadmin"]['msg']= "Problem in update.";
					echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
					exit;
				}
			}
			else
			{
				$result55 = $db->Insert($table, $_REQUEST, 1);
				if($result55 > 0)
				{
					$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
					$_SESSION["samajadmin"]['msg_type']="1";
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .','id'=>$result55));
				}
				else
				{
					$_SESSION["samajadmin"]['msg']= "Problem in data insert.";
					$_SESSION["samajadmin"]['msg_type']="0";
					 echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				}
				exit;
			}
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function addintnotes() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "int_notes";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
		$id = $_REQUEST['id'];
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				
				$result2 = $db->Update($table,$_REQUEST,"id",$id);
				if($result2)
				{
					echo json_encode(array("success"=>"1",'msg'=>'Record Update Successfully .','id'=>$_REQUEST['id']));
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
					$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
					$_SESSION["samajadmin"]['msg_type']="1";
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .','id'=>$result55));
				}
				else
				{
					$_SESSION["samajadmin"]['msg']= "Problem in data insert.";
					$_SESSION["samajadmin"]['msg_type']="0";
					 echo json_encode(array("success"=>"0",'msg'=>'Problem in data insert.'));
				}
				exit;
			}
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
}

?>