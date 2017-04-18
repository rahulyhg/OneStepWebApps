<?php
class Contact  extends Controller 
{
	public function index()
	{
		parent::__construct();
		$this->view->admin("contact/index");
	}
	public function addlisting()
	{
		parent::__construct();
		$this->view->admin("contact/addlisting");
	}

	public function fetch()
  	{
  		require 'include_classes.php';
  		$db = new Db();
  		$access8 = new PrivilegedUser();
  		$table = "contact_location";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		$join_tables = array(
			array('left','lov r1','r1.id = i.status', array('r1.value as status_val'))
		);
		
		$colArray = array('i.id','i.name','i.latitude','i.longitude','i.contact','i.address','r1.value');
	
		$page = $_GET['start'];												
		$rows = $_GET['length'];									
		
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		for($i=1;$i<=6;$i++)
		{
			if($i==6){
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
			$condition = " 1=1 " ;
		
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
			array_push($temp, $row->name);
			array_push($temp, $row->latitude);
			array_push($temp, $row->longitude);
			array_push($temp, $row->contact);
			array_push($temp, $row->address);
			$status_val = $row->status_val;
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
			if ($access8->hasPrivilege("EditLocation")) {
				$actionCol .='<a href="'.SITE_ROOT.'/contact/addlisting?id='.$row->id.'"  title="Edit"><i class="icon-pencil"></i></a>';
			} if ($access8->hasPrivilege("DeleteLocation")) {
				$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteData(\''.$row->id.'\');" title="Delete"><i class="icon-trash"></i></a>';
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
		$db = new Db();
		
		$table = "contact_location";
		$table_id = 'id';
		$id = $_GET['id'];
		
		$old_data = $db->FetchToArray($table, "*","$table_id = '".$id."'");
		
	  if($db->delete($table,$table_id,$id))
	  {
	   $_SESSION["samajadmin"]['msg']= "Record deleted successfully.";
	   $_SESSION["samajadmin"]['msg_type']="1";
	  }
	  else
	  {
	   $_SESSION["samajadmin"]['msg']= "Record deletion fails.";
	   $_SESSION["samajadmin"]['msg_type']="0";
	  }
	  
	  $core->RedirectTo(SITE_ROOT."/contact/");
  
   }
	
	public function addcontact()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "contact_location";
		$table_id = 'id';
		if(isset($_POST['id']) && $_POST['id']!="")
		{
			$data_adv['name']= $_POST['name'];
			$data_adv['latitude']= $_POST['latitude'];
			$data_adv['longitude']= $_POST['longitude'];		
			$data_adv['contact']= $_POST['contact'];					
			$data_adv['address']= $_POST['address'];					
			$data_adv['status']= $_POST['status'];							
			$data_advup = $db->update($table,$data_adv,$table_id,$_POST['id']);
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
			$data_adv1['name']= $_POST['name'];
			$data_adv1['latitude']= $_POST['latitude'];
			$data_adv1['longitude']= $_POST['longitude'];		
			$data_adv1['contact']= $_POST['contact'];					
			$data_adv1['address']= $_POST['address'];					
			$data_adv1['status']= $_POST['status'];	
			$data_adv = $db->insert($table,$data_adv1,"1");
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
	public function __call($method, $args) 
	{
		require 'application/control/error.php';
		$controller=new Error();
		return false;
  	} 
}

?>