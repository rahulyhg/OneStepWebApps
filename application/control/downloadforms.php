<?php
class Downloadforms  extends Controller 
{
	public function index()
	{
		parent::__construct();
		$this->view->admin("downloadforms/index");
	}
	public function addEdit()
	{
		parent::__construct();
		require 'include_classes.php';
  		$db = new Db();
		$this->view->admin("downloadforms/addedit");
	}
	public function addeditform()
	{
		require 'include_classes.php';
  		$db = new Db();
		$table = "downloadform";
		$table_id = 'id';
		//echo "TEST";
		if(isset($_POST['id']) && $_POST['id']!="")
		{
			$data_adv['title']= $_POST['title'];
			$data_adv['description']= $_POST['description'];
			$data_adv['samaj_city']= $_POST['samaj_city'];	
			$data_advup = $db->update($table,$data_adv,$table_id,$_POST['id']);
			if($data_advup)
			{	
				if(isset($_FILES["filename"]["name"]) && $_FILES["filename"]["name"] != "")
				{
				$target_dir = "forms/";
				$file_name = time()."_".str_replace(" ","_",basename($_FILES["filename"]["name"]));
				$target_file = $target_dir . $file_name;
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$imageFileType = strtolower($imageFileType);
				if(isset($_POST["submit"])) {
					$check = filesize($_FILES["filename"]["tmp_name"]);
					if($check !== false) {
						$uploadOk = 1;
					} else {
						$uploadOk = 0;					
						exit;
					}
				}
				
				if (file_exists($target_file)) {
					$uploadOk = 0;			
					$_SESSION["samajadmin"]['msg']= "Sorry, file already exists.";		
					$_SESSION["samajadmin"]['msg_type']="0";
					exit;
				}
				
				if ($_FILES["filename"]["size"] > 3010000) {
					$uploadOk = 0;			
					$_SESSION["samajadmin"]['msg']= "Sorry, your file is too large. The maximum file size limit is 3 MB.";		
					$_SESSION["samajadmin"]['msg_type']="0";
					exit;
				}
				if ($uploadOk == 0) {
					echo json_encode(array('msg'=>'Sorry, your file was not uploaded.'));
					$_SESSION["samajadmin"]['msg']= "Sorry, your file was not uploaded.";		
					$_SESSION["samajadmin"]['msg_type']="0";
					exit;
				} else {
					if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
								$advpost_update['filepath'] = $target_file;
								$result1adv = $db->Update($table,$advpost_update,"id",$_POST['id']);
						
						$_SESSION["samajadmin"]['msg']= "Form updated successfully.";							
						$_SESSION["samajadmin"]['msg_type']="1";
						echo json_encode(array('msg'=>'success'));
						exit;
					}
				}	
				}
				$_SESSION["samajadmin"]['msg']= "Form updated successfully.";		
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
			$data_adv1['title']= $_POST['title'];
			$data_adv1['description']= $_POST['description'];
			$data_adv1['samaj_city']= $_POST['samaj_city'];
			$data_adv = $db->insert($table,$data_adv1,"1");
			if($data_adv)
			{				
				$target_dir = "forms/";
				$file_name = time()."_".str_replace(" ","_",basename($_FILES["filename"]["name"]));
				$target_file = $target_dir . $file_name;
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$imageFileType = strtolower($imageFileType);
				if(isset($_POST["submit"])) {
					$check = filesize($_FILES["filename"]["tmp_name"]);
					if($check !== false) {
						$uploadOk = 1;
					} else {
						$uploadOk = 0;					
						exit;
					}
				}
				
				if (file_exists($target_file)) {
					$uploadOk = 0;			
					$_SESSION["samajadmin"]['msg']= "Sorry, file already exists.";		
					$_SESSION["samajadmin"]['msg_type']="0";
					exit;
				}
				
				if ($_FILES["filename"]["size"] > 3010000) {
					$uploadOk = 0;			
					$_SESSION["samajadmin"]['msg']= "Sorry, your file is too large. The maximum file size limit is 3 MB.";		
					$_SESSION["samajadmin"]['msg_type']="0";
					exit;
				}
				if ($uploadOk == 0) {
					echo json_encode(array('msg'=>'Sorry, your file was not uploaded.'));
					$_SESSION["samajadmin"]['msg']= "Sorry, your file was not uploaded.";		
					$_SESSION["samajadmin"]['msg_type']="0";
					exit;
				} else {
					if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
							
						$adv_post1['filepath'] = $target_file;
						
						$result1adv = $db->Update($table,$adv_post1,"id",$data_adv);
						
						$_SESSION["samajadmin"]['msg']= "Form added successfully.";							
						$_SESSION["samajadmin"]['msg_type']="1";
						echo json_encode(array('msg'=>'success'));
						exit;
					}
				}		
			$_SESSION["samajadmin"]['msg']= "Form added successfully.";		
			$_SESSION["samajadmin"]['msg_type']="1";
			echo json_encode(array('msg'=>'success'));	
			}
			else
			{
				echo json_encode(array('msg'=>'Problem in insert.'));				
			}
		}
	}
	public function fetch_forms()
	{
		require 'include_classes.php';
  		$db = new Db();
  		$access5 = new PrivilegedUser();
  		$table = "downloadform";
  		//$table = "";
		$table_id = 'id';
		
		$default_sort_column = 'id';
		$default_sort_order = 'asc';
		$condition = "";
  		
  		$main_table = array("$table i",array("i.*"));
		//$join_tables = array();
		$join_tables = array(
			array('left','samaj_city r','r.id = i.samaj_city', array('r.name as city'))
		);
		$colArray = array('i.id','i.title','i.description','i.filepath','r.name');
		//print_r($colArray);
	
		$page = $_GET['start'];												// iDisplayStart starting offset of limit funciton
		$rows = $_GET['length'];											// iDisplayLength no of records from the offset
		
		// sort order by column
		$sort = isset($_GET['order']['0']['column']) ? strval($colArray[$_GET['order']['0']['column']]) : $default_sort_column;  
		$order = isset($_GET['order']['0']['dir']) ? strval($_GET['order']['0']['dir']) : $default_sort_order;  
	
		$result = array();
		
		for($i=1;$i<=5;$i++)
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
			$condition = " 1=1 ";
		
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
			array_push($temp, $row->filepath);
			array_push($temp, $row->city);	
			$actionCol = "";
			if ($access5->hasPrivilege("EditForms")) 
			{
				$actionCol .='<a href="'.SITE_ROOT.'/downloadforms/addedit?id='.$row->id.'"  title="Edit"><i class="icon-pencil"></i></a>';
			} 
			if ($access5->hasPrivilege("DeleteForms")) 
			{
				$actionCol .='&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deletedata(\''.$row->id.'\');" title="Delete"><i class="icon-trash"></i></a>';
			}
			array_push($temp, $actionCol);
			array_push($items, $temp);
			$count++;
		}
		//print_r($items);die;
		$result["aaData"] = $items;
			//http_build_query(array("id"=>$row->user_id))
			
		echo json_encode($result);
		exit;
	}
	
	public function delete()
	{
		require 'include_classes.php';
		$db = new Db();
		
		$table = "downloadform";
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
	  
	  $core->RedirectTo(SITE_ROOT."/downloadforms/");
  
	}
}
?>