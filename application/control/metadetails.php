<?php
class Metadetails extends Controller 
{
	public function index()
	{
		parent::__construct();
		require 'include_classes.php';
  		$db = new Db();
		$this->view->admin("metadetails/index");
	}
	
	public function listmetadata()
	{
		parent::__construct();
		require 'include_classes.php';
  		$db = new Db();
		$this->view->admin("metadetails/listmetadata");
	}	

	public function __call($method, $args) 
	{
		require 'application/control/error.php';
		$controller=new Error();
		return false;
  	}  

		
	public function addmeta()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "meta_details";
		$table_id = 'id';
		if(isset($_POST['id']) && $_POST['id']!= "")
		{
			$data_meta['meta_description']= $_POST['meta_description'];
			$data_meta['meta_title']= $_POST['meta_title'];
			$data_meta['meta_keyword']= $_POST['meta_keyword'];
			$data_meta['display_page_section']= $_POST['display_page_section'];						
			$data_meta['status']= $_POST['status'];						
			$data_metaup = $db->update($table,$data_meta,$table_id,$_POST['id']);
			if($data_metaup)
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
			$data_meta1['meta_description']= $_POST['meta_description'];
			$data_meta1['meta_title']= $_POST['meta_title'];
			$data_meta1['meta_keyword']= $_POST['meta_keyword'];
			$data_meta1['display_page_section']= $_POST['display_page_section'];
			$data_meta1['status']= $_POST['status'];
			$data_meta2 = $db->insert($table,$data_meta1,"1");
			if($data_meta2)
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
	
	public function fetch_metadata()
	{
		require 'include_classes.php';
  		$db = new Db();
  		$access10 = new PrivilegedUser();
  		$table = "meta_details";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "" ;
  		
  		$main_table = array("$table i",array("i.*"));
		$join_tables = array(
			array('left','lov r1','r1.id = i.status', array('r1.value as status_val')),
			array('left','lov r2','r2.id = i.display_page_section', array('r2.value as page'))
			
		);
		
		$colArray = array('i.id','i.meta_title','i.meta_description','i.meta_keyword','r2.value','r1.value');
	
		$page = $_GET['start'];											
		$rows = $_GET['length'];
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		for($i=1;$i<=5;$i++)
		{
			if($i==4){
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
			array_push($temp, $row->meta_title);
			array_push($temp, $row->meta_description);
			array_push($temp, $row->meta_keyword);	
			array_push($temp, $row->page);	
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
			if ($access10->hasPrivilege("EditMeta")) {
				$actionCol .='<a href="'.SITE_ROOT.'/metadetails/index?id='.$row->id.'"  title="Edit"><i class="icon-pencil"></i></a>';
			} if ($access10->hasPrivilege("DeleteMeta")) {
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
	
	 public function delete4()
	{
		require 'include_classes.php';
		$db = new Db();
		
		$table = "meta_details";
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
	  
	  $core->RedirectTo(SITE_ROOT."/metadetails/listmetadata");
  
   }
	
}
?>