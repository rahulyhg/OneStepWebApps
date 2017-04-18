<?php
class Roles extends Controller
{
	public function index()
	{
		parent::__construct();
		$this->view->admin("roles/index");
	}

	public function __call($method, $args)
	{
		require 'application/control/error.php';
		$controller=new Error();
		return false;
	}

	public function fetch()
	{
		require 'include_classes.php';

		$table = "user_role";
		$table_id = 'id';
		$access10 = new PrivilegedUser();
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "";

		$main_table = array("$table i",array("i.*"));
		$main_table_count = array("$table i",array(" count( * ) AS ret_val"));

		$join_tables = array(
		);
		$join_tables_count = array(
		);

		$colArray = array('i.id','i.role_name');

		$page = $_GET['start'];											
		$rows = $_GET['length'];										

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
			array_push($temp, $row->role_name);

			$actionCol = "";
			
			if ($access10->hasPrivilege("EditRole")) {
				$actionCol .='<a href="'.SITE_ROOT.'/roles/addEdit?id='.$row->id.'" style="padding:0px 5px;" title="Edit Member"><i class="icon-pencil"></i></a>';
			} if ($access10->hasPrivilege("DeleteRole")) {
				$actionCol .='<a href="javascript:void(0);" style="padding:0px 5px;" onclick="deleteData(\''.$row->id.'\');" title="Delete"><i class="icon-trash"></i></a>';
			}
			
			array_push($temp, $actionCol);
			array_push($items, $temp);
			$count++;
		}
		$result["aaData"] = $items;
		/*http_build_query(array("id"=>$row->user_id))*/
			
		echo json_encode($result);
		exit;
	}

	public function delete()
	{
		require 'include_classes.php';

		$table = "user_role";
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
		$core->RedirectTo(SITE_ROOT."/roles");
	}

	public function addEdit()
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			require 'include_classes.php';
			$db = new Db();
			$table = "user_role";
			$table_id = 'id';
			
			$_REQUEST = $db->FilterParameters($_REQUEST);

			$condition = "role_name= '".$_REQUEST['role_name']."'";

				$condition .= " && $table_id != '".$_POST['role_id']."'";

			$check_name = $db->FunctionFetch($table, 'count', '*', $condition);

			if($check_name > 0)
			{
				echo json_encode(array('msg'=>'Role Name Already Present.'));
				exit;
			}
			else
			{
				if(!empty($_POST['role_id']))
				{
					$result= $db->Update($table, $_POST, $table_id, $_POST['role_id']);
					
					$deleteRow = $db->DeleteWhere("role_perm", "role_id='".$_POST['role_id']."'");
					if(isset($_POST['perm_id']))
					{
						for($i=0;$i<sizeof($_POST['perm_id']);$i++)
						{
							$data = array();
							$data['role_id']= $_POST['role_id'];
							$data['perm_id']= $_POST['perm_id'][$i];
							$data['location']= 1;

							$rs = $db->Insert("role_perm", $data, 1);
						}
					}
					$_SESSION['msg']= "Record updated successfully.";
				}
				else
				{
					/*
					 * Last Inserted Id
					 */
					$_POST[$table_id] = $db->getLastId($table, $table_id,IDPREFIX);;

					$result = $db->Insert($table, $_POST, 1);
					if(isset($_POST['perm_id']))
					{
						for($i=0;$i<sizeof($_POST['perm_id']);$i++)
						{
							$data = array();
							$data['role_id']= $_POST['role_id'];
							$data['perm_id']= $_POST['perm_id'][$i];
							$data['location']= 1;
							$rs = $db->Insert("role_perm", $data, 1);
						}
					}
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
		else
		{
			parent::__construct();
			$this->view->admin("roles/addEdit");
		}
	}

}

?>