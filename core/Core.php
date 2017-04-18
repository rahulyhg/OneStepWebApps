<?php
class Core {
	
	/**
	 * @author: Rajan Rawal
	 * @desc: give self url
	 */
	
	public static function StrLeft($s1, $s2) {
		return substr($s1, 0, strpos($s1, $s2));
	}
					
	public static function SelfURL(){
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = Core::StrLeft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol."://".$_SERVER['SERVER_NAME'].$port;
	}
	
	public function GenRandomStr($length) {
		$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$string = '';    
		for ($p = 0; $p < $length; $p++) {
			$string.= $characters[mt_rand(0, strlen($characters)-1)];
		}
		return $string;
	}
	
	public static function ArrayToHTMLOptions($option_array, $selected = null){
		$options = "";
		foreach ($option_array as $key => $val){
				
			$options .= (!is_null($selected) && $key == $selected) ? "<option value='$key' selected='selected'>$val</option>" : "<option value='$key'>$val</option>";
		}
		return $options;
	}
	
	public static function PrintArray($data=array()){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	
	public static function PrependNullOption($option_list){
		return "<option value=''>----------Select-------</option>".$option_list;
	}
	
	public static function DisplayMessage($msg,$msg_type = 0, $autohide = 1) {
		$html= $class = $title = '';
		switch ($msg_type){
			case 1;
				$title="Success Message";
				$html = "<script type='text/javascript'>$(function(){ $.pnotify({type: 'success',title: '".$title."',text: '".$msg."',icon: 'picon icon16 iconic-icon-check-alt white',opacity: 0.95,hide:false,history: false,sticker: false});});</script>";
				break;
			case 2;
				$title="Notice Message";
				$html = "<script type='text/javascript'>$(function(){ $.pnotify({type: 'info',title: '".$title."',text: '".$msg."',icon: 'picon icon16 brocco-icon-info white',opacity: 0.95,hide:false,history: false,sticker: false});});</script>";
				break;			
			case 0;
			default:
				$title="Error Message";
				$html = "<script type='text/javascript'>$(function(){ $.pnotify({type: 'error',title: '".$title."',text: '".$msg."',icon: 'picon icon24 typ-icon-cancel white',opacity: 0.95,hide:false,history: false,sticker: false});});</script>";
				break;
		}
		return $html;
	}
	
	public static function FilterNullValues($array = array(), $filter_zero = false){
		
		return ($filter_zero===true) ? array_filter($array) : array_filter($array,'strlen');
	}
	
	public static function uploadFile($fieldname, $maxsize, $uploadpath, $extensions=false, $ref_name=false) {

		$upload_field_name = $_FILES[$fieldname]['name'];

		

		if(empty($upload_field_name) || $upload_field_name == 'NULL' ) {			

			return array('status'=>'error', 'msg'=>'Please upload the file ');

		}
		$value = explode(".",$upload_field_name);
		$file_extension = strtolower(end($value));

		

//		$file_extension = strtolower(pathinfo($upload_field_name, PATHINFO_EXTENSION));

		

		if($extensions !== false && is_array($extensions) ) {

			if(!in_array($file_extension,$extensions) ) {

				return array('status'=>'error', 'msg'=>'Please upload the valid file');

			}			

		}

		$file_size = @filesize($_FILES[$fieldname]["tmp_name"]);
		
		if ($file_size > $maxsize) {

			return array('status'=>'error', 'msg'=>'File Exceeds maximum limit');

		}

		if(isset($upload_field_name)) {

			if ($_FILES[$fieldname]["error"] > 0) {

				return array('status'=>'error', 'msg'=>'Error: '.$_FILES[$fieldname]['error']);

			}

		}

		if($ref_name == false ) {

			$file_name = time().str_replace(" ","_",$upload_field_name);

		} else {

			$file_name = str_replace(" ", "_",$ref_name).".".$file_extension;

		}
		if(!is_dir($uploadpath))
		{
			mkdir($uploadpath,0777);
		}
		if(move_uploaded_file($_FILES[$fieldname]["tmp_name"], $uploadpath.$file_name)) {			

			return array('status'=>'true', 'msg'=>$file_name);

		} else {

			return array('status'=>'error', 'msg'=>'Sorry unable to upload your file, Please try after some time.');			

		}

	}
	
	public function UploadSingleFile($fieldname, $maxsize, $uploadpath, $extensions=false, $ref_name=false) {
		$upload_field_name = $_FILES[$fieldname]['name'];
		if(empty($upload_field_name) || $upload_field_name == 'NULL' ) {			
			return array('file'=>$_FILES[$fieldname]["name"], 'status'=>false, 'msg'=>'Please upload a file');
		}
		//$file_extension = strtolower(end(explode(".",$upload_field_name)));
		$file_extension = strtolower(pathinfo($upload_field_name, PATHINFO_EXTENSION));
		
		if($extensions !== false && is_array($extensions) ) {
			if(!in_array($file_extension,$extensions) ) {
				return array('file'=>$_FILES[$fieldname]["name"], 'status'=>false, 'msg'=>'Please upload valid file');
			}			
		}
		$file_size = @filesize($_FILES[$fieldname]["tmp_name"]);
		if ($file_size > $maxsize) {
			return array('file'=>$_FILES[$fieldname]["name"], 'status'=>false, 'msg'=>'File Exceeds maximum limit');
		}
		if(isset($upload_field_name)) {
			if ($_FILES[$fieldname]["error"] > 0) {
				return array('file'=>$_FILES[$fieldname]["name"], 'status'=>false, 'msg'=>'Error: '.$_FILES[$fieldname]['error']);
			}
		}
		if($ref_name == false ) {
			//$file_name = time().'_'.str_replace(" ","_",$upload_field_name);
			
			$file_name_without_ext =  $this->FileNameWithoutExt($upload_field_name);
			$file_name = time().'_'.Core::RenameUploadFile($file_name_without_ext).".".$file_extension;
		} else {
			$file_name = str_replace(" ", "_",$ref_name).".".$file_extension;
		}
		if(!is_dir($uploadpath))
		{
			mkdir($uploadpath,0777);
		}
		if(move_uploaded_file($_FILES[$fieldname]["tmp_name"], $uploadpath.$file_name)) {			
			return array('file'=>$_FILES[$fieldname]["name"], 'status'=>true, 'msg'=>'File Uploaded Successfully!', 'filename'=>$file_name);
		} else {
			return array('file'=>$_FILES[$fieldname]["name"], 'status'=>false, 'msg'=>'Sorry unable to upload your file, Please try after some time.');			
		}
	}
	public function UploadMultipleFile($fieldname, $maxsize, $uploadpath, $index, $extensions=false, $ref_name=false) 
	{
		$upload_field_name = $_FILES[$fieldname]['name'][$index];
		if(empty($upload_field_name) || $upload_field_name == 'NULL' ) {			
			return array('file'=>$_FILES[$fieldname]["name"][$index], 'status'=>false, 'msg'=>'Please upload a file');
		}
		
		//$file_extension = strtolower(end(explode(".",$upload_field_name)));
		$file_extension = strtolower(pathinfo($upload_field_name, PATHINFO_EXTENSION));
		
		if($extensions !== false && is_array($extensions) ) {
			if(!in_array($file_extension,$extensions) ) {
				return array('file'=>$_FILES[$fieldname]["name"][$index], 'status'=>false, 'msg'=>'Please upload valid file');
			}			
		}
		$file_size = @filesize($_FILES[$fieldname]["tmp_name"][$index]);
		if ($file_size > $maxsize) {
			return array('file'=>$_FILES[$fieldname]["name"][$index],'status'=>false, 'msg'=>'File Exceeds maximum limit');
		}
		if(isset($upload_field_name)) {
			if ($_FILES[$fieldname]["error"][$index] > 0) {
				return array('file'=>$_FILES[$fieldname]["name"][$index],'status'=>false, 'msg'=>'Error: '.$_FILES[$fieldname]['error']);
			}
		}
		$file_name = "";
		if($ref_name == false ) {
			$file_name_without_ext =  $this->FileNameWithoutExt($upload_field_name);
			$file_name = time().'_'.Core::RenameUploadFile($file_name_without_ext).".".$file_extension;
		} else {
			$file_name = Core::RenameUploadFile($ref_name).".".$file_extension;
		}
		if(!is_dir($uploadpath))
		{
			mkdir($uploadpath,0777);
		}
		if(move_uploaded_file($_FILES[$fieldname]["tmp_name"][$index], $uploadpath.$file_name)) {
			return array('file'=>$_FILES[$fieldname]["name"][$index], 'status'=>true, 'msg'=>'File Uploaded Successfully!', 'filename'=>$file_name);
		} else {
			return array('file'=>$_FILES[$fieldname]["name"][$index], 'status'=>false, 'msg'=>'Sorry unable to upload your file, Please try after some time.');			
		}
	}
	
	/**
	 * @author : Rajan Rawal
	 * @desc: This function filters the uploaded file name and properly rename it 
	 * @param: $data : data string
	 * changes : Other 4 characters are added 
	 */
	public static function RenameUploadFile($data) {
		$search = array("'"," ","(",")",".","&","-","\"","\\","?",":","/");
		$replace = array("","_","","","","","","","","","","");
		$new_data=str_replace($search, $replace, $data);
		return strtolower($new_data);
	}
	
	public function FileNameWithoutExt($filename){
		return substr($filename, 0, (strlen ($filename)) - (strlen (strrchr($filename,'.'))));
	}
	
	public static function PadString($number,$total_length, $prefix_text = '', $postfix_text = '',$padding_char = "0", $pad_side = 'left'){
		
		$string = '';
		switch ($pad_side){
			case 'right':
				$string = str_pad($number, $total_length, $padding_char, STR_PAD_RIGHT);
				break;
			default:
			case 'left':
				$string = str_pad($number, $total_length, $padding_char, STR_PAD_LEFT);
				break;
		}
		return $prefix_text.$string.$postfix_text;
	}
	public static function PageRedirect($page) 
	{
		print "<script type='text/javascript'>";
		print "window.location = '$page'";
		print "</script>";
		@header ("Location : $page");
		exit;
	}
	public function RedirectTo($page)
	{
		if (!headers_sent())
	    {
	        header("Location: ".$page);
	        exit;
	    }
	    else
	    {
	        echo '<script type="text/javascript">';
	        echo 'window.location.href="'.$page.'";';
	        echo '</script>';
	        echo '<noscript>';
	        echo '<meta http-equiv="refresh" content="0;url='.$page.'" />';
	        echo '</noscript>'; 
	        exit;
	    }	
	}
	
	public function array_diff_multidimensional($session, $post) { 
		$result = array();
		foreach($session as $sKey => $sValue){
			foreach($post as $pKey => $pValue) {
				if((string) $sKey == (string) $pKey) {
					$result[$sKey] = array_diff($sValue, $pValue);
				}
			}
		}
		return $result;
	}
	public function array_search2d($needle, $haystack) 
	{
		for ($i = 0, $l = count($haystack); $i < $l; ++$i) {
			if (in_array($needle, $haystack[$i])) return $i;
		}
	    return false;
	}
	
	public static function YMDToDMY($ymd, $show_his = false){
		return ($show_his) ? date('d-m-Y h:i:s A',strtotime($ymd)) : date('d-m-Y',strtotime($ymd));
	}
	
	public static function DMYToYMD($dmy, $show_his = false){
		return date('Y-m-d',strtotime($dmy));
	}
	
	public static function aasort (&$array, $key) 
	{
	    $sorter=array();
	    $ret=array();
	    reset($array);
	    foreach ($array as $ii => $va) {
	    	if(!empty($va[$key]))
	    	{
	    		$sorter[$ii]=$va[$key];
	    	}else{
	    		$sorter[$ii]="";
	    	}
	    }
	    asort($sorter);
	    foreach ($sorter as $ii => $va) {
	    	if(!empty($array[$ii]))
	    	{
	    		$ret[$ii]=$array[$ii];
	    	}else{
	    		$ret[$ii]="";
	    	}
	    }
	    $array=$ret;
	}
	public static function getExcelColumns($obj,$collength)
	{
		$colNumber = PHPExcel_Cell::columnIndexFromString($obj->getActiveSheet()->getHighestDataColumn());
		if($collength != $colNumber)
		{
			return false;
		}else{
			return true;
		}
	}
	public static function getExcelRows($obj,$minrows)
	{
		$rows = $obj->getActiveSheet()->getHighestRow();
		if($rows < $minrows)
		{
			return false;
		}else{
			return true;
		}
		
	}
	
	public static function CreateWhereForSingleTable($search){
		
		$new_array_without_nulls = Core::FilterNullValues($search);
	//	echo "<pre>";
	//	print_r($new_array_without_nulls);
	//	echo "</pre>";
			
		$condition = "";
		foreach ($new_array_without_nulls as $key => $val){
			
			$match_cond = (is_numeric($val)) ? "$key=$val" : ((strtotime($val)) ? "$key='$val'" : "$key like '%$val%'");
			$condition .= ($condition=='') ? " $match_cond" : " && $match_cond";	
		}
		return $condition;
	}

	public static function DaysDiffFromToday($date){
		
		$now = time(); // or your date as well
		$your_date = strtotime($date);
		$datediff = $now - $your_date;
		return floor($datediff/(60*60*24));
	}

	public static function DaysDiffBetweenTwoDays($startdate,$enddate){
		
		$now = strtotime($startdate); // or your date as well
		$your_date = strtotime($enddate);
		$datediff = $now - $your_date;
		return floor($datediff/(60*60*24));
	}
	/* creates a compressed zip file */
	public static function CreateZip($files = array(),$destination = '',$overwrite = false) {
		//if the zip file already exists and overwrite is false, return false
		if(file_exists($destination) && !$overwrite) { return false; }
		//vars
		$valid_files = array();
		//if files were passed in...
		if(is_array($files)) {
			//cycle through each file
			foreach($files as $file) {
				//make sure the file exists
				if(file_exists($file)) {
					$valid_files[] = $file;
				}
			}
		}
		//if we have good files...
		if(count($valid_files)) {
			//create the archive
			$zip = new ZipArchive();
			if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			//add the files
			foreach($valid_files as $file) {
				$new_filename = substr($file,strrpos($file,'/') + 1);
				$zip->addFile($file,$new_filename);
			}
			//debug
			//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
			
			//close the zip -- done!
			$zip->close();
			
			//check to make sure the file exists
			return file_exists($destination);
		}
		else
		{
			return false;
		}
	}
}

