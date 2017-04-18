<?php
class Manageadmin  extends Controller 
{
	public function index()
	{
		parent::__construct();
		$this->view->admin("manageadmin/index");
	}
	public function addEdit()
	{
		parent::__construct();
		require 'include_classes.php';
  		$db = new Db();
		$this->view->admin("manageadmin/addEdit");
	}
	public function fetch_admin()
	{
		require 'include_classes.php';
  		$db = new Db();
  		$access10 = new PrivilegedUser();
  		$table = "admin_member";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		$join_tables = array(
			array('left','user_role r1','r1.id = i.user_role', array('r1.role_name as adminrole')),
			array('left','samaj_city r2','r2.id = i.admin_city', array('r2.name as admincity')),
			array('left','lov r3','r3.id = i.status', array('r3.value as admin_status'))
		);
		
		$colArray = array('i.id','CONCAT(i.first_name," ",i.last_name)','i.username','i.email','i.mobile_no','r1.role_name','r2.name','r3.value');
	
		$page = $_GET['start'];									
		$rows = $_GET['length'];								
		
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		for($i=1;$i<=7;$i++)
		{
			if($i==7){
				if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
				{
					if($condition=="")
						$condition .= " $colArray[$i] = '".$_GET['search']['value']."' ";
					else
						$condition .= " or $colArray[$i] = '".$_GET['search']['value']."' ";
				}
			}else{
				if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
				{
					if($condition=="")
						$condition .= " $colArray[$i] like '%".$_GET['search']['value']."%'";
					else
						$condition .= " or $colArray[$i] like '%".$_GET['search']['value']."%'";
				}
			}
		}

		if($condition=="")
			$condition = "1=1 " ;
		
		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 
		
		$totalRs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));	
		$totalRecords = @mysql_num_rows($totalRs);
		$result["iTotalRecords"] = $totalRecords;									
		$result["iTotalDisplayRecords"]= $totalRecords;									
		 
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{	
			$temp = array();
			array_push($temp, $count);
			array_push($temp, $row->first_name ." ".$row->last_name);
			array_push($temp, $row->username);
			array_push($temp, $row->email);	
			array_push($temp, $row->mobile_no);	
			array_push($temp, $row->adminrole);	
			array_push($temp, $row->admincity);	
			$status_val = $row->admin_status;
			if($status_val == "active")
			{
				$status_pass = "";
				$status_pass = "<a class='publishedclass'>".$status_val."</a>";
			}
			else if($status_val == "deactive")
			{
				$status_pass = "";
				$status_pass = "<a class='expiredclass'>".$status_val."</a>";
			}
			
			$actionCol = "";
			if ($access10->hasPrivilege("EditAdmin")) {
				$actionCol .='<a href="'.SITE_ROOT.'/manageadmin/addEdit?id='.$row->id.'" title="Edit"><i class="icon-pencil"></i></a>';
			} if ($access10->hasPrivilege("DeleteAdmin")) {
				$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deletedata(\''.$row->id.'\');" title="Delete"><i class="icon-trash"></i></a>';
			}
			array_push($temp, $status_pass);
			array_push($temp, $actionCol);
			array_push($items, $temp);
			$count++;
		}
		$result["aaData"] = $items;
			
		echo json_encode($result);
		exit;
	}
	
	public function delete()
	{
		require 'include_classes.php';

		$table = "admin_member";
		$table_id = 'id';
		$id = $_GET['id'];

		if($db->delete($table,$table_id,$id))
		{
			$_SESSION['msg']= "Record deleted successfully.";
			$_SESSION['msg_type']="1";
		}
		else
		{
			$_SESSION['msg']= "Record deletion fails.";
			$_SESSION['msg_type']="0";
		}
		$core->RedirectTo(SITE_ROOT."/manageadmin");
		
	}

	public function addnewadmin()	
	{		
		require 'include_classes.php';
  		$db = new Db();
		$table = "admin_member";
		$table_id = 'id';
		if(isset($_POST['id']) && $_POST['id']!="")		
		{			
			if(isset($_POST['user_role']) && $_POST['user_role'] != "" && ($_POST['user_role'] == 1 || $_POST['user_role'] == 6 || $_POST['user_role'] == 13))
			{
				$_POST['admin_city'] = 0;
			}
			
			if(isset($_POST['password']) && $_POST['password']!="")		
			{
				$_POST['password'] = md5($_POST['password']);
			}
			else
			{
				unset($_POST['password']);
			}
			$data_advup = $db->update($table,$_POST,$table_id,$_POST['id']);
			if($data_advup)
			{
					
					$_SESSION["samajadmin"]['msg']= "Update successfully.";						
					$_SESSION["samajadmin"]['msg_type']="1";
					echo json_encode(array('msg'=>'success'));
			}
			else
			{
					echo json_encode(array('msg'=>'Problem in update.'));
			}		
		}
		else
		{				
			if(isset($_POST['user_role']) && $_POST['user_role'] != "" && ($_POST['user_role'] == 1 || $_POST['user_role'] == 6 || $_POST['user_role'] == 13))
			{
				$_POST['admin_city'] = 0;
			}
			
			$_POST['password'] = md5($_POST['password']);
			$data_adv = $db->insert($table,$_POST,"1");
			if($data_adv)
			{
					$_SESSION["samajadmin"]['msg']= "Insert successfully.";
					$_SESSION["samajadmin"]['msg_type']="1";
					echo json_encode(array('msg'=>'success'));
					exit;
			}
			else
			{
					echo json_encode(array('msg'=>'Problem in update.'));							
			}
		}
	}

}