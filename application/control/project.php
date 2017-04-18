<?php

class Project extends Controller 

{	
	public function __call($method, $args) {
		require 'application/control/error.php';
		$controller=new Error();
		return false;
  	}  	
	
	public function dashboard()
	{
		parent::__construct();
		$this->view->admin("project/dashboard");
	}
	
	public function lists()
	{
		parent::__construct();
		$this->view->admin("project/lists");
	}
	
	public function internalestimate()
	{
		parent::__construct();
		$this->view->admin("project/internalestimate");
	}
	public function externalestimate()
	{
		parent::__construct();
		$this->view->admin("project/externalestimate");
	}
	public function internal_project()
	{
		parent::__construct();
		$this->view->admin("project/internal_project");
	}
	public function external_project()
	{
		parent::__construct();
		$this->view->admin("project/external_project");
	}
	public function internal_pricing()
	{
		parent::__construct();
		$this->view->admin("project/internal_pricing");
	}
	public function external_pricing()
	{
		parent::__construct();
		$this->view->admin("project/external_pricing");
	}
	public function internal_hrs_tracking()
	{
		parent::__construct();
		$this->view->admin("project/internal_hrs_tracking");
	}
	public function external_hrs_tracking()
	{
		parent::__construct();
		$this->view->admin("project/external_hrs_tracking");
	}
	public function internal_summary()
	{
		parent::__construct();
		$this->view->admin("project/internal_summary");
	}
	public function internalsummary_frame()
	{
		parent::__construct();
		$this->view->singlerender("project/internalsummary_frame");
	}
	public function external_summary()
	{
		parent::__construct();
		$this->view->admin("project/external_summary"); 
	}
	public function externalsummary_frame()
	{
		parent::__construct();
		$this->view->singlerender("project/externalsummary_frame");
	}
	public function production_rates()
	{
		parent::__construct();
		$this->view->admin("project/production_rates");
	}
	public function production_rates_frame()
	{
		parent::__construct();
		$this->view->singlerender("project/production_rates_frame");
	}
	
	public function lists_frame()
	{
		parent::__construct();
		$this->view->singlerender("project/lists_frame");
	}
	
	public function cabtackoff()
	{
		parent::__construct();
		$this->view->admin("project/cabtackoff");
	} 
	public function cabtackoff_frame()
	{
		parent::__construct();
		$this->view->singlerender("project/cabtackoff_frame");
	}
	public function listclients()
	{
		parent::__construct();
		$this->view->admin("project/listclients");
	}
	public function editclient()
	{
		parent::__construct();
		$this->view->admin("project/editclient");
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
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
		
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$id = $_REQUEST['id'];
				$result2 = $db->Update("int_estimates", $_REQUEST,"id",$id);
				$result21 = $db->Update($table,$_REQUEST,"estimate_id",$id);
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
				
				$_REQUEST['estimate_id'] = $db->Insert("int_estimates", $_REQUEST, 1);
				//echo $_REQUEST['estimate_id'];
				if($_REQUEST['estimate_id'] > 0)
				{
					/*print_r($_REQUEST);*/
					$result55 = $db->Insert($table, $_REQUEST, 1);
					$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
					$_SESSION["samajadmin"]['msg_type']="1";
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .','id'=>$_REQUEST['estimate_id']));
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
	
	public function addextest() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "external_estimate";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$id = $_REQUEST['id'];
				$result2 = $db->Update("ext_estimates", $_REQUEST,"id",$id);
				$result21 = $db->Update($table,$_REQUEST,"id",$id);
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
				$_REQUEST['estimate_id'] = $db->Insert("ext_estimates", $_REQUEST, 1);
				if($_REQUEST['estimate_id'] > 0)
				{
					$result55 = $db->Insert($table, $_REQUEST, 1);
					$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
					$_SESSION["samajadmin"]['msg_type']="1";
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .','id'=>$_REQUEST['estimate_id']));
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
	
	public function listintproject()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "int_estimates";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'i.id';
		$default_sort_order = 'desc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' room_types r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' internal_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$colArray = array('i.id','i.room_name');
	
		$page = $_GET['start'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['length'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition = " ( ";
		}
		
		for($i=1;$i<2;$i++)
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
			$condition = " 1=1 && r1.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		else
			$condition .= " && r1.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
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
			array_push($temp, $row->room_name);
			array_push($temp, $row->Length);
			array_push($temp, $row->Width);
			array_push($temp, $row->Height);
			array_push($temp, $row->LN_FT);
			array_push($temp, $row->W_FT);
			array_push($temp, $row->C_FT);
			array_push($temp, $row->Gallons);
			array_push($temp, $row->Hours);
			array_push($temp, $row->Cost);
			$actionCol = "";
			$actionCol .='<a href="'.SITE_ROOT.'/project/internalestimate?id='.$row->id.'&project_id='.$row->project_id.'"  title="Edit"><i class="icon-pencil"></i></a>';
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
	
	public function listextproject()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "ext_estimates";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'i.id';
		$default_sort_order = 'desc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' exterior_descript r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' external_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$colArray = array('i.id','i.room_name');
	
		$page = $_GET['start'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['length'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition = " ( ";
		}
		
		for($i=1;$i<2;$i++)
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
			$condition = " 1=1 && r1.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		else
			$condition .= " && r1.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
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
			array_push($temp, $row->room_name);
			array_push($temp, $row->Length);
			array_push($temp, $row->Height);
			array_push($temp, $row->Sq_Ft);
			array_push($temp, $row->Gallons);
			array_push($temp, $row->Hours);
			array_push($temp, $row->Cost);
			$actionCol = "";
			$actionCol .='<a href="'.SITE_ROOT.'/project/externalestimate?id='.$row->id.'&project_id='.$row->project_id.'"  title="Edit"><i class="icon-pencil"></i></a>';
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
	
	public function listintpricing()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "int_estimates";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'i.id';
		$default_sort_order = 'desc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' room_types r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' internal_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$colArray = array('i.id','i.room_name');
	
		$page = $_GET['start'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['length'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition = " ( ";
		}
		
		for($i=1;$i<2;$i++)
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
			$condition = " 1=1 && r1.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		else
			$condition .= " && r1.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
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
			array_push($temp, $row->room_name);
			array_push($temp, $row->Gallons);
			array_push($temp, $row->Hours);
			array_push($temp, $row->Cost);
			$actionCol = "";
			$actionCol .='<a href="'.SITE_ROOT.'/project/internalestimate?id='.$row->id.'&project_id='.$row->project_id.'"  title="Edit"><i class="icon-pencil"></i></a>';
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
	
	public function listextpricing()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "ext_estimates";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'i.id';
		$default_sort_order = 'desc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' exterior_descript r','r.id = i.SpaceType', array('r.name as room_name')),
			array('left',' external_estimate r1','r1.estimate_id = i.id', array('r1.created_by as created_by'))
		);
		
		$colArray = array('i.id','i.room_name');
	
		$page = $_GET['start'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['length'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
		{	$condition = " ( ";
		}
		
		for($i=1;$i<2;$i++)
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
			$condition = " 1=1 && r1.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		else
			$condition .= " && r1.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id = '".$_REQUEST['project_id']."' " ;
		
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
			array_push($temp, $row->room_name);
			array_push($temp, $row->Gallons);
			array_push($temp, $row->Hours);
			array_push($temp, $row->Cost);
			$actionCol = "";
			$actionCol .='<a href="'.SITE_ROOT.'/project/externalestimate?id='.$row->id.'&project_id='.$row->project_id.'"  title="Edit"><i class="icon-pencil"></i></a>';
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
	
	
	public function addinthrstracking() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "internal_hrs_tracking";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
		
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$id = $_REQUEST['id'];
				$result2 = $db->Update($table,$_REQUEST,"id",$id);
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
					$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
					$_SESSION["samajadmin"]['msg_type']="1";
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
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
	
	public function addexthrstracking() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "external_hrs_tracking";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
		
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$id = $_REQUEST['id'];
				$result2 = $db->Update($table,$_REQUEST,"id",$id);
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
					$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
					$_SESSION["samajadmin"]['msg_type']="1";
					 echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
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
	
	public function addcabtackoff()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "cabtakeoff";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		/*$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];*/
		$trackingid = $db->FetchCellValue($table,"id","project_id = '".$_REQUEST['project_id']."' ");
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($trackingid) && $trackingid > 0)
			{
				$result21 = $db->Update($table,$_REQUEST,"id",$trackingid);
				if($result21)
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
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function deleteintproject()
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
				$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
				$_SESSION["samajadmin"]['msg_type']="1";
			}
			else
			{
				$_SESSION["samajadmin"]['msg']= "Record deletion fails.";
				$_SESSION["samajadmin"]['msg_type']="0";
			}
		}
		else
		{
		   $_SESSION["samajadmin"]['msg']= "Record deletion fails.";
		   $_SESSION["samajadmin"]['msg_type']="0";
		}
		$core->RedirectTo(SITE_ROOT."/project/internal_project?project_id=".$_REQUEST['project_id']);
	}
	
	public function deleteintpricing()
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
				$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
				$_SESSION["samajadmin"]['msg_type']="1";
			}
			else
			{
				$_SESSION["samajadmin"]['msg']= "Record deletion fails.";
				$_SESSION["samajadmin"]['msg_type']="0";
			}
		}
		else
		{
		   $_SESSION["samajadmin"]['msg']= "Record deletion fails.";
		   $_SESSION["samajadmin"]['msg_type']="0";
		}
		$core->RedirectTo(SITE_ROOT."/project/internal_project?project_id=".$_REQUEST['project_id']);
	}
	
	public function deleteextproject()
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
				$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
				$_SESSION["samajadmin"]['msg_type']="1";
			}
			else
			{
				$_SESSION["samajadmin"]['msg']= "Record deletion fails.";
				$_SESSION["samajadmin"]['msg_type']="0";
			}
		}
		else
		{
		   $_SESSION["samajadmin"]['msg']= "Record deletion fails.";
		   $_SESSION["samajadmin"]['msg_type']="0";
		}
		$core->RedirectTo(SITE_ROOT."/project/external_project?project_id=".$_REQUEST['project_id']);
	}
	
	public function deleteextpricing()
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
				$_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
				$_SESSION["samajadmin"]['msg_type']="1";
			}
			else
			{
				$_SESSION["samajadmin"]['msg']= "Record deletion fails.";
				$_SESSION["samajadmin"]['msg_type']="0";
			}
		}
		else
		{
		   $_SESSION["samajadmin"]['msg']= "Record deletion fails.";
		   $_SESSION["samajadmin"]['msg_type']="0";
		}
		$core->RedirectTo(SITE_ROOT."/project/external_project?project_id=".$_REQUEST['project_id']);
	}
	
	public function updaterates()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "default_production_rate";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$id = $_REQUEST['id'];
			$result21 = $db->Update($table,$_REQUEST,"id",$id);
			if($result21)
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
	public function listallclients()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access1 = new PrivilegedUser();
  		$table = "projects";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left',' client r','r.id = i.Client_id', array('r.name as client_name','r.phonenumber as phonenum','r.email as mailid'))
		);
		
		$colArray = array('i.id','r.name','i.Address','r.phonenumber','r.email');
	
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
			if(isset($row->City)){$city = ",".$row->City;} else {$city = "";}
			if(isset($row->State)){$state = ",".$row->State;} else {$state = "";}
			$temp = array();
			array_push($temp, $count);
			array_push($temp, $row->client_name);
			array_push($temp, $row->Address." ".$city." ".$state);
			array_push($temp, $row->phonenum);
			array_push($temp, $row->mailid);
			$actionCol = "";
			$actionCol .='<a href="'.SITE_ROOT.'/project/editclient?id='.$row->id.'"  title="Edit"><i class="mdi-editor-mode-edit"></i></a>';
			array_push($temp, $actionCol);
			array_push($items, $temp);
			$count++;
		}
		$result["data"] = $items;
		echo json_encode($result);
		exit;
  	}
	
	public function editclient1()
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "projects";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$id = $_REQUEST['id'];
			$data1['Address'] = $_REQUEST['address'];
			$data1['State'] = $_REQUEST['State'];
			$data1['City'] = $_REQUEST['City'];
			$data1['country'] = $_REQUEST['country'];
			$data1['Zip'] = $_REQUEST['Zip'];
			$data2['name'] = $_REQUEST['name'];
			$data2['phonenumber'] = $_REQUEST['phonenumber'];
			$data2['email'] = $_REQUEST['email'];
			$result2 = $db->Update($table,$data1,"id",$id);
			$clientid = $db->FetchCellValue($table,"Client_id","id = '".$_REQUEST['id']."' ");
			$result3 = $db->Update('client',$data2,"id",$clientid);
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
			echo json_encode(array("success"=>"0",'msg'=>'Problem in update.'));
			exit;
		}
	}
	
	public function addintsummary() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "internal_summary";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
		
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$id = $_REQUEST['id'];
				/*$result2 = $db->Update("int_estimates", $_REQUEST,"id",$id);*/
				$result2 = $db->Update($table,$_REQUEST,"id",$id);
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
				
				/*$_REQUEST['estimate_id'] = $db->Insert("int_estimates", $_REQUEST, 1);*/
				//echo $_REQUEST['estimate_id'];
				
					/*print_r($_REQUEST);*/
				$result55 = $db->Insert($table, $_REQUEST, 1);
				$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
				$_SESSION["samajadmin"]['msg_type']="1";
				echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
				exit;
			}
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	
	public function addextsummary() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "external_summary";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		$_REQUEST['created_by'] = $_SESSION['samajadmin']['id'];
		
		if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "" )
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
			{
				$id = $_REQUEST['id'];
				/*$result2 = $db->Update("int_estimates", $_REQUEST,"id",$id);*/
				$result2 = $db->Update($table,$_REQUEST,"id",$id);
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
				
				/*$_REQUEST['estimate_id'] = $db->Insert("int_estimates", $_REQUEST, 1);*/
				//echo $_REQUEST['estimate_id'];
				
					/*print_r($_REQUEST);*/
				$result55 = $db->Insert($table, $_REQUEST, 1);
				$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
				$_SESSION["samajadmin"]['msg_type']="1";
				echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
				exit;
			}
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	
	public function addroomtype() 
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
			$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
			exit;
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function editroomtype() 
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
			$id = $_REQUEST['id'];
			/*$result2 = $db->Update("int_estimates", $_REQUEST,"id",$id);*/
			$result2 = $db->Update($table,$_REQUEST,"id",$id);
			$_SESSION["samajadmin"]['msg']= "Record Updated successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array("success"=>"1",'msg'=>'Record Updated Successfully .'));
			exit;
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function editspacetype() 
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
			$id = $_REQUEST['id'];
			/*$result2 = $db->Update("int_estimates", $_REQUEST,"id",$id);*/
			$result2 = $db->Update($table,$_REQUEST,"id",$id);
			$_SESSION["samajadmin"]['msg']= "Record Updated successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array("success"=>"1",'msg'=>'Record Updated Successfully .'));
			exit;
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function editfinishdesc() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "Finish_desc";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		
		if(isset($_REQUEST['description']) && $_REQUEST['description'] != "" )
		{
			$id = $_REQUEST['id'];
			/*$result2 = $db->Update("int_estimates", $_REQUEST,"id",$id);*/
			$result2 = $db->Update($table,$_REQUEST,"id",$id);
			$_SESSION["samajadmin"]['msg']= "Record Updated successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array("success"=>"1",'msg'=>'Record Updated Successfully .'));
			exit;
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function editlevel() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "level_of_preparation";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		
		if(isset($_REQUEST['percentage']) && $_REQUEST['percentage'] != "" )
		{
			$id = $_REQUEST['id'];
			/*$result2 = $db->Update("int_estimates", $_REQUEST,"id",$id);*/
			$result2 = $db->Update($table,$_REQUEST,"id",$id);
			$_SESSION["samajadmin"]['msg']= "Record Updated successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array("success"=>"1",'msg'=>'Record Updated Successfully .'));
			exit;
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	
	public function editinteriorrate() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "Interior_Rate";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		
		if(isset($_REQUEST['rate']) && $_REQUEST['rate'] != "" )
		{
			if($_REQUEST['type'] == "interior")
				$_REQUEST["interior"] = $_REQUEST["rate"];
			else if($_REQUEST['type'] == "exterior")
				$_REQUEST["exterior"] = $_REQUEST["rate"];
			
			$id = $_REQUEST['id'];
			
			$result2 = $db->Update($table,$_REQUEST,"id",$id);
			$_SESSION["samajadmin"]['msg']= "Record Updated successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array("success"=>"1",'msg'=>'Record Updated Successfully .'));
			exit;
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function editprojectparam() 
	{
		require 'include_classes.php';
		require 'classes/sMail.php';
		$db = new Db();
  
		$table = "projects";
		$table_id = 'id';
		$result = "";
		$client_id = "";
		$_REQUEST = $db->FilterParameters($_REQUEST);
		$_REQUEST['status'] = '1';
		
		if(isset($_REQUEST['param']) && $_REQUEST['param'] != "" )
		{
			if($_REQUEST['param'] == "deposit_percent")
				$_REQUEST["deposit_percent"] = $_REQUEST["value"];
			else if($_REQUEST['param'] == "maximum_deposit")
				$_REQUEST["maximum_deposit"] = $_REQUEST["value"];
			else if($_REQUEST['param'] == "prepared_by")
				$_REQUEST["prepared_by"] = $_REQUEST["value"];
			
			$id = $_REQUEST['id'];
			
			$result2 = $db->Update($table,$_REQUEST,"id",$id);
			$_SESSION["samajadmin"]['msg']= "Record Updated successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array("success"=>"1",'msg'=>'Record Updated Successfully .'));
			exit;
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
	
	public function addspacetype() 
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
			$_SESSION["samajadmin"]['msg']= "Record inserted successfully.";
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array("success"=>"1",'msg'=>'Record Inserted Successfully .'));
			exit;
		}
		else{	
			$_SESSION["samajadmin"]['msg_type']="0";
			echo json_encode(array('msg'=>'success','message'=>'Please select the project.'));
			exit;
		}
	}
}

?>