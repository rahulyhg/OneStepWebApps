<?php
class Permission  extends Controller 
{
	public function index()
	{
		parent::__construct();
		$this->view->admin("permission/index");
	}
	public function addEdit()
	{
		parent::__construct();
		$this->view->admin("permission/addEdit");
	}
	public function __call($method, $args)
	{
		require 'application/control/error.php';
		$controller=new Error();
		return false;
	}
	public function addeditpermission()
	{
			require 'include_classes.php';
			$db = new Db();
			$table = "permissions";
			$table_id = 'perm_id';

			$_REQUEST = $db->FilterParameters($_REQUEST);

			$condition = "perm_desc= '".$_REQUEST['perm_desc']."'";
			if(!empty($_POST[$table_id]))
			{
				$condition .= " && $table_id != '".$_POST[$table_id]."'";
			}

			$check_name = $db->FunctionFetch($table, 'count', '*', $condition);

			if($check_name > 0)
			{
				echo json_encode(array('msg'=>'Permission Already Present.'));
				exit;
			}
			else
			{
				if(!empty($_POST[$table_id]))
				{
					$result= $db->Update($table, $_POST, $table_id, $_POST[$table_id]);
					$_SESSION['msg']= "Record updated successfully.";
				}
				else
				{
					$_POST[$table_id] = $db->getLastId($table, $table_id,IDPREFIX);
					$result = $db->Insert($table, $_POST, 1);
					$_SESSION['msg']= "Record inserted successfully.";
				}
				if($result)
				{
					$_SESSION['msg_type']="1";
					echo json_encode(array('msg'=>'success'));
					exit;
				}
				else
				{
					echo json_encode(array('msg'=>'Problem in data insert.'));
					exit;
				}
			}					
	}

	
	public function fetch()
	{
		require 'include_classes.php';

		$table = "permissions";
		$table_id = 'perm_id';
		$access9 = new PrivilegedUser();
		$default_sort_column = 'perm_id';
		$default_sort_order = 'asc';
		$condition = "";

		$main_table = array("$table i",array("i.*"));
		$main_table_count = array("$table i",array(" count( * ) AS ret_val"));

		$join_tables = array(
		);
		$join_tables_count = array(
		);

		$colArray = array('i.id','i.perm_desc');

		$page = $_GET['start'];												
		$rows = $_GET['length'];											

		$sort = isset($_GET['iSortCol_0']) ? strval($colArray[$_GET['iSortCol_0']]) : $default_sort_column;
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : $default_sort_order;

		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  

		$result = array();

		for($i=0;$i<=1;$i++)
		{
			if(isset($_GET['search']['value']) && $_GET['search']['value']!='')
			{
				if($condition=="")
					$condition .= " $colArray[$i] like '%".$_GET['search']['value']."%'";
				else
					$condition .= " or $colArray[$i] like '%".$_GET['search']['value']."%'";
			}
		}
		
		if($condition=="")
			$condition = " 1=1 " ;
		
		$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));
		$result["sEcho"]= $_GET['sEcho']; 											

		$totalRs = $db->JoinFetch($main_table_count, $join_tables_count, $condition, array($sort => $order));		
		$totalRecords = mysql_fetch_array($totalRs);
		$result["iTotalRecords"] = $totalRecords['ret_val'] ;							
		$result["iTotalDisplayRecords"]= $totalRecords['ret_val'];						
			
		$items = array();
		$count = ($page);
		$count++;
		while($row = mysql_fetch_object($rs))
		{
			$temp = array();
			array_push($temp, $count);
			array_push($temp, $row->perm_desc);

			$actionCol = "";
			if ($access9->hasPrivilege("EditPermission")) {
				$actionCol .='<a href="'.SITE_ROOT.'/permission/addEdit?id='.$row->perm_id.'" title="Edit Member"><i class="icon-pencil"></i></a>';
			}
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

		$table = "permissions";
		$table_id = 'perm_id';
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
		$core->RedirectTo(SITE_ROOT."/permission");
	}
	
}
?>