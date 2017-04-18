<?php
class Db extends Dbconfig {
	
	public function checkAccess($roleName)
	{
		if(isset($_SESSION["$roleName"]))
		{
			if($_SESSION["$roleName"] == "1")
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function Query($sql){
		
		$result = mysql_query($sql);
		return $result;
	}
	
	public function CountResultRows($resouce){
		return @mysql_num_rows($resouce);	
	}
	
	public function FetchRowInAssocArray($result){
		return @mysql_fetch_assoc($result);
	}
	
	public function FetchTableField($table, $neglect = null) { //Function That fetch the fields of table
		
		$field = array();
		$sql="SHOW COLUMNS FROM `$table`";
		//echo $sql;
		$res=mysql_query($sql);
		
		while($data=@mysql_fetch_assoc($res)) {
			$field[]=$data["Field"];
		}
		
		if(is_array($neglect) && count($neglect) >= 1){
			
			foreach($neglect as $val) {
				$index = array_search($val, $field); 
				if($index !== false){
					unset($field[$index]);
				}
			}
		}
		return $field;
	}
	
	public function getLastId($table,$colName,$prefix = 'AA',$appendPrefix = true)
	{
		$result = $this->Fetch($table, "*", "$colName like '".$prefix."%' && location=".LOCATION, array("id"=>"desc"), array(0,1));
		if(!empty($result) && mysql_num_rows($result) > 0)
		{
			$result = mysql_fetch_array($result);
			$id = substr($result[$colName], 2);
			$id++;
			if($appendPrefix)
			{
				return $prefix.$id;
			}
			else
			{
				return $id;
			}
		}
		else
		{
			if($appendPrefix)
			{
				return $prefix."1";
			}
			else
			{
				return "1";
			}
		}
	}
	
	public function FetchToArray($table, $columns, $condition = null, $sort_by = null, $limit = null){
		
		$res = $this->Fetch($table, $columns, $condition, $sort_by, $limit);
		$array_res = array();
		
		if(@mysql_num_rows($res)>=1){
			
			if($result_fields_count = mysql_num_fields($res) <= 1){
				for($i=0;$i<sizeof($res),$row = @mysql_fetch_assoc($res);$i++)
					$array_res[] = $row[key($row)];
			}else{
				for($i=0;$i<sizeof($res),$row = @mysql_fetch_assoc($res);$i++)
					$array_res[$i] = $row;
			}
		}
		return $array_res;
	}
	
	public function FetchToArrayFromResultset($res){
		
		$array_res = array();
		$res_rows = $this->CountResultRows($res); 
		if($res_rows >= 1){
			
			if($result_fields_count = mysql_num_fields($res) <= 1){
				for($i=0;$i<$res_rows,$row = @mysql_fetch_assoc($res);$i++)
					$array_res[] = $row[key($row)];
			}else{
				for($i=0;$i<$res_rows,$row = @mysql_fetch_assoc($res);$i++)
					$array_res[$i] = $row;
			}
		}
		return $array_res;
	}
	
	public function FetchRowForForm($table, $columns, $condition = null){
		
		$table_fields = $this->FetchTableField($table);
		$res = $this->FetchRowWhere($table, $columns, $condition);
		if($this->CountResultRows($res)>=1){
			$array_res = $this->MySqlFetchRow($res);
		}else{
			
			foreach ($table_fields as $key => $value){
				$array_res[$value] = '';
			}
		}
		return $array_res;
	}
	
	public function FetchRow($table,$filed,$filed_value,$columns = '*'){
		
		if(is_array($columns)){
			$columns = implode(", ", $columns);
		}
		
		$sql= "select $columns from $table where $filed='$filed_value' limit 0,1";
		//echo $sql;
//		exit;
		$res=mysql_query($sql);
		return $res;
	}
	
	public function FetchRowWhere($table,$columns = '*', $condition){
		
		if(is_array($columns)){
			$columns = implode(", ", $columns);
		}
		
		$sql= "select $columns from $table where $condition limit 0,1";
		//echo $sql;
		//exit;
		$res=mysql_query($sql);
		return $res;
	}
	
	public function FetchCellValue($table,$column,$where){

		$data = '';
		$query = "select $column from $table where $where";
//		echo $query ;
//		exit; 
		$res = mysql_query($query);
		if($this->CountResultRows($res)){
			$res_data = $this->MySqlFetchRow($res);
			$data = $res_data[$column];	
		}
		return $data;
	}
					
	public function Fetch($table, $columns, $condition = null, $sort_by = null, $limit = null, $group_by = null){
		
		if(is_array($columns)){
			$columns = implode(", ", $columns);
		}
		
		if(is_null($condition) || $condition==""){
			$condition = "1=1";
		}
		
		$sort_order = "";
		if(is_array($sort_by) && $sort_by != null){
			
			foreach ($sort_by as $key => $val){
				
				$sort_order .= ($sort_order == "") ? "order by $key $val" : ", $key $val";
			}
		}
		
		if($group_by != null){
			$group_by = "group by ".$group_by;			
		}
		
		if(is_array($limit) && $limit != null){
			$limit = "limit ".$limit[0].", ".$limit[1];			
		}
		
		$sql= trim("select $columns from $table where $condition $group_by $sort_order $limit");
		//echo $sql.'<br/>';
		//exit;
		$res=mysql_query($sql);
		
		return $res;
	}
	
	public function JoinFetch($main_table = array(), $join_tables = array(), $condition = null, $sort_by = null, $limit = null, $group_by = null){
		
		$columns = isset($main_table[1]) ? $main_table[1] : array();
		$main_table = $main_table[0];
		
		$join_str = "";
		foreach ($join_tables as $join_table){
			
			$join_str .= $join_table[0]." join ".$join_table[1]." on (".$join_table[2].") ";
			
			if(isset($join_table[3])){
				$columns = array_merge($columns,$join_table[3]);
			}
		}
		
		$columns = (sizeof($columns) > 0) ? implode(", ", $columns) : "*";
		
		if(is_null($condition) || $condition==""){
			$condition = "1=1";
		}
		
		$sort_order = "";
		if(is_array($sort_by) && $sort_by != null){
			
			foreach ($sort_by as $key => $val){
				$sort_order .= ($sort_order == "") ? "order by $key $val" : ", $key $val";
			}
		}
		
		if($group_by != null){
			$group_by = "group by ".$group_by;			
		}
		
		if(is_array($limit) && $limit != null){
			$limit = "limit ".$limit[0].", ".$limit[1];			
		}
		
		$sql= trim("select $columns from $main_table $join_str where $condition $group_by $sort_order $limit");
		//echo $sql.'<br/><br/><br/>';
		//exit;
		$res=mysql_query($sql);
		
		return $res;
	}

	public function UnionFetch($main_table1 = array(), $join_tables1 = array(), $condition1 = null,$main_table2 = array(), $join_tables2 = array(), $condition2 = null, $sort_by = null, $limit = null, $group_by = null){
		/*
		First Query
		*/
		$columns1 = isset($main_table1[1]) ? $main_table1[1] : array();
		$main_table1 = $main_table1[0];
		
		$join_str1 = "";
		foreach ($join_tables1 as $join_table){
			
			$join_str1 .= $join_table[0]." join ".$join_table[1]." on (".$join_table[2].") ";
			
			if(isset($join_table[3])){
				$columns1 = array_merge($columns1,$join_table[3]);
			}
		}		
		$columns1 = (sizeof($columns1) > 0) ? implode(", ", $columns1) : "*";
		
		if(is_null($condition1) || $condition1==""){
			$condition1 = "1=1";
		}
		/*
		End First Query
		*/
		/*
		Second Query
		*/
		$columns2 = isset($main_table2[1]) ? $main_table2[1] : array();
		$main_table2 = $main_table2[0];
		
		$join_str2 = "";
		foreach ($join_tables2 as $join_table){
			
			$join_str2 .= $join_table[0]." join ".$join_table[1]." on (".$join_table[2].") ";
			
			if(isset($join_table[3])){
				$columns2 = array_merge($columns2,$join_table[3]);
			}
		}		
		$columns2 = (sizeof($columns2) > 0) ? implode(", ", $columns2) : "*";
		
		if(is_null($condition2) || $condition2==""){
			$condition2 = "1=1";
		}
		/*
		End Second Query
		*/
		
		$sort_order = "";
		if(is_array($sort_by) && $sort_by != null){
			
			foreach ($sort_by as $key => $val){
				$sort_order .= ($sort_order == "") ? "order by $key $val" : ", $key $val";
			}
		}
		
		if($group_by != null){
			$group_by = "group by ".$group_by;			
		}
		
		if(is_array($limit) && $limit != null){
			$limit = "limit ".$limit[0].", ".$limit[1];			
		}
		
		$sql1= trim("select $columns1 from $main_table1 $join_str1 where $condition1 UNION select $columns2 from $main_table2 $join_str2 where $condition2 $group_by $sort_order $limit");
//		echo $sql1.'<br/>';
//		exit;
		$res=mysql_query($sql1);		
		return $res;
	}
	
	Public function UnionFetchCount($main_table1 = array(), $join_tables1 = array(), $condition1 = null,$main_table2 = array(), $join_tables2 = array(), $condition2 = null, $sort_by = null, $limit = null, $group_by = null){
		/*
		First Query
		*/
		$columns1 = isset($main_table1[1]) ? $main_table1[1] : array();
		$main_table1 = $main_table1[0];
		
		$join_str1 = "";
		foreach ($join_tables1 as $join_table){
			
			$join_str1 .= $join_table[0]." join ".$join_table[1]." on (".$join_table[2].") ";
			
			if(isset($join_table[3])){
				$columns1 = array_merge($columns1,$join_table[3]);
			}
		}		
		$columns1 = (sizeof($columns1) > 0) ? implode(", ", $columns1) : "*";
		
		if(is_null($condition1) || $condition1==""){
			$condition1 = "1=1";
		}
		/*
		End First Query
		*/
		/*
		Second Query
		*/
		$columns2 = isset($main_table2[1]) ? $main_table2[1] : array();
		$main_table2 = $main_table2[0];
		
		$join_str2 = "";
		foreach ($join_tables2 as $join_table){
			
			$join_str2 .= $join_table[0]." join ".$join_table[1]." on (".$join_table[2].") ";
			
			if(isset($join_table[3])){
				$columns2 = array_merge($columns2,$join_table[3]);
			}
		}		
		$columns2 = (sizeof($columns2) > 0) ? implode(", ", $columns2) : "*";
		
		if(is_null($condition2) || $condition2==""){
			$condition2 = "1=1";
		}
		/*
		End Second Query
		*/
		
		$sort_order = "";
		if(is_array($sort_by) && $sort_by != null){
			
			foreach ($sort_by as $key => $val){
				$sort_order .= ($sort_order == "") ? "order by $key $val" : ", $key $val";
			}
		}
		
		if($group_by != null){
			$group_by = "group by ".$group_by;			
		}
		
		if(is_array($limit) && $limit != null){
			$limit = "limit ".$limit[0].", ".$limit[1];			
		}
		
		$sql1= trim("SELECT COUNT(*) AS ret_val FROM (select $columns1 from $main_table1 $join_str1 where $condition1 UNION select $columns2 from $main_table2 $join_str2 where $condition2 $group_by $sort_order $limit) AS ret_val");
//		echo $sql1.'<br/>';
//		exit;
		$res=mysql_query($sql1);		
		return $res;
	}
	
	public function FunctionFetch($table, $function, $column, $condition = null, $limit = null, $group_by = null){
		
		if(is_array($column)){
			$column = implode(", ", $column);
		}
		
		if(is_null($condition) || $condition == ""){
			$condition = "1=1";
		}
		
		if($group_by != null){
			$group_by = "group by ".$group_by;			
		}
		
		if(is_array($limit) && $limit != null){
			$limit = "limit ".$limit[0].", ".$limit[1];			
		}
		
		$sql = "SELECT ".$function."(".$column.") as ret_val FROM $table where $condition $group_by $limit";
		//echo $sql."<br/><br/>";
//		exit;
		$res=mysql_query($sql);
		$ret_val = @mysql_fetch_assoc($res);
		$ret_data = $ret_val['ret_val'];
		return $ret_data;
	}
	
	public function Insert($table,$data,$status = 0) {
		
		//print_r($data);//exit;
		
		$data = $this->FilterParameters($data);
		$fields = array_keys($data);
		$table_fields = $this->FetchTableField($table);
		
		$parameters = array();
		$str = array();
		for($i=0;$i<count($fields);$i++) {
			
			if(in_array($fields[$i], $table_fields)){

				if(is_array($data[$fields[$i]]) && count($data[$fields[$i]]) >1) {
					$data_arr=implode(',',$data[$fields[$i]]);
				} else {
					$data_arr=$data[$fields[$i]];
				}
				$str[]="'".$data_arr."'";
				$parameters[]=$fields[$i];
			}
		}
		$sql="insert into `$table` (".implode(',',$parameters).") values (".implode(',',$str).")";
//		echo $sql.'<br/>';
//		exit;
		$res=mysql_query($sql);
		$id=mysql_insert_id();
		
		if($res) {
			if($status == '1') {
				return $id;
			} else {
				return true;
			}
		} else {
			return mysql_error();
		}
	}
	
	public function Update($table,$d,$id_field,$id_field_value) {
		
		$d = $this->FilterParameters($d);
		$f = array_keys($d);
		$table_fields = $this->FetchTableField($table);
		
		for($i=0;$i<count($f);$i++) {
			
			if(in_array($f[$i], $table_fields)){
				if(is_array($d[$f[$i]])) {
					if(sizeof($d[$f[$i]]) > 1){
						$data_arr=implode(',',$d[$f[$i]]);
					}else{
						$data_arr = $d[$f[$i]];
						$data_arr = $data_arr[0];
					}
				} else {
						
					if($d[$f[$i]]==""){
						$data_arr="";
					}
					else{
						$format_string = (string)$d[$f[$i]];
						$data_arr=$format_string;
					}
				}
				$parameters[]=$f[$i]."="."'".$data_arr."'";
			}
		}

		$sql="update $table set ".implode(',',$parameters)." where $id_field='".$id_field_value."'";
		//echo $sql.'<br/>';
//		exit;
		$res=mysql_query($sql);
		if($res) {
			return true;
		} else {
			return false;
		}
	}
	
	public function UpdateWhere($table,$d,$condition) {
		
		$d = $this->FilterParameters($d);
		$f = array_keys($d);
		$table_fields = $this->FetchTableField($table);
		
		for($i=0;$i<count($f);$i++) {
			
			if(in_array($f[$i], $table_fields)){
				if(is_array($d[$f[$i]])) {
					if(sizeof($d[$f[$i]]) > 1){
						$data_arr=implode(',',$d[$f[$i]]);
					}else{
						$data_arr = $d[$f[$i]];
						$data_arr = $data_arr[0];
					}
				} else {
						
					if($d[$f[$i]]==""){
						$data_arr="";
					}
					else{
						$format_string = (string)$d[$f[$i]];
						$data_arr=$format_string;
					}
				}
				$parameters[]=$f[$i]."="."'".$data_arr."'";
			}
		}

		$sql="update $table set ".implode(',',$parameters)." where $condition";
		//echo $sql.'<br/>';
		//exit;

		$res=mysql_query($sql);
		if($res) {
			return true;
		} else {
			return false;
		}
	}
	
	public function Delete($table, $id, $para){
		
		$para = $this->FilterParameters($para);
		if(is_array($para) && count($para)>0){
			$sql="delete from ".$table." where ".$id." in (".implode(',',$para).")";
		}else{
			$sql="delete from ".$table." where $id='$para'";
		}
//		echo $sql;
//		exit;
		$res=mysql_query($sql);
		
		if($res){
			return true;
		} else {
			return false;
		}
	}
	
	public function DeleteWhere($table,$condition){
		$sql="delete from ".$table." where $condition";
		//echo $sql;
		//exit;
		$res=mysql_query($sql);
		
		if($res){
			return true;
		} else {
			return false;
		}
	}
		
	public function FilterParameters($array) {
		
		if(is_array($array)) {
			
			foreach($array as $key => $value) {
				
				if(is_array($array[$key])){
					$array[$key] = $this->FilterParameters($array[$key]);
				}
				if(is_string($array[$key])){
					$array[$key] = mysql_real_escape_string(trim($array[$key]));
				}
			}
		}
		
		if(is_string($array)){
			$array = mysql_real_escape_string(trim($array));
		}
		return $array;
	}
	
	public function CreateOptionsFromResutlset($option_result, $format = 'html', $selected = null){
		
		$count = 0;
		if(is_resource($option_result)){
			$count = $this->CountResultRows($option_result);
		}
		
		$options = ('array' == $format) ? array() : '';
		if( 0 < $count){
			
			// if something wrorng happens then remove this $column logic
			$columns = array();
			for($i = 0; $i < mysql_num_fields($option_result); $i++) {
			    $field_info = mysql_fetch_field($option_result, $i);
			    $columns[$i] = $field_info->name;
			}
			// Up to here
			
			while ($option_data = $this->MySqlFetchRow($option_result)){
				
				switch ($format){
					case "array":
						$options[$option_data[$columns[0]]] = $option_data[$columns[1]];
						break;
					case "json":
						$options[] = array(
							"$columns[0]" => $option_data[$columns[0]],
							"$columns[1]" => $option_data[$columns[1]],
						);
						break;
					default:
					case "html":
//						$options[] = (!is_null($selected) && $option_data[$columns[0]] == $selected) ? "<option value='{$option_data[$columns[0]]}' selected='selected'>{$option_data[$columns[1]]}</option>" : "<option value='{$option_data[$columns[0]]}'>{$option_data[$columns[1]]}</option>";
						if(!is_null($selected)){
							
							if(is_array($selected)){
								$options[] = (in_array($option_data[$columns[0]], $selected)) ? "<option value='{$option_data[$columns[0]]}' selected='selected'>{$option_data[$columns[1]]}</option>" : "<option value='{$option_data[$columns[0]]}'>{$option_data[$columns[1]]}</option>";
							}else{
								$options[] = ($option_data[$columns[0]] == $selected) ? "<option value='{$option_data[$columns[0]]}' selected='selected'>{$option_data[$columns[1]]}</option>" : "<option value='{$option_data[$columns[0]]}'>{$option_data[$columns[1]]}</option>";
							}
						}else{
							$options[] = "<option value='{$option_data[$columns[0]]}'>{$option_data[$columns[1]]}</option>";
						}
						break;
				}
			}
				
			switch ($format){
				case "array":
					$options = $options;
					break;
				case "json":
					$options = json_encode($options);
					break;
				default:
				case "html":
					$options = implode("", $options);
					break;
			}
		}
		return $options;
	}

	public function CreateOptions($format,$table, $columns, $selected = null, $sort_by = null, $condition = null, $limit = null, $group_by = null){
		// If null then set sorting according to second parameter
		if(is_null($sort_by)){
			$sort_by = array("$columns[1]"=>'asc');
		}
		$option_result = $this->Fetch($table, $columns, $condition, $sort_by, $limit, $group_by);
		
		$options = $this->CreateOptionsFromResutlset($option_result, $format, $selected);
		return $options;
	}
	
	public function CreateOptions2($format,$table, $columns,$join_tables, $selected = null, $sort_by = null, $condition = null, $limit = null, $group_by = null){
		// If null then set sorting according to second parameter
		if(is_null($sort_by)){
			$sort_by = array("$columns[1]"=>'asc');
		}
		$main_table = array("$table i",$columns);
		$option_result = $this->JoinFetch($main_table, $join_tables, $condition, $sort_by, $limit, $group_by);
		
		$options = $this->CreateOptionsFromResutlset($option_result, $format, $selected);
		return $options;
	}
	
	public function LikeSearchCondition($search_term, $search_columns = array()){
		
		$condition = "";
		
		foreach ($search_columns as $key => $val){
			$condition .= ($key == count($search_columns) - 1 ) ? "$val like '%$search_term%' " : "$val like '%$search_term%' OR ";
		}
		return $condition;
	}
	
	public function MySqlFetchRow($result, $type = 'assoc'){
		
		$row = false;
		if($result != false){
				
			switch ($type){
				case 'array' :
					$row = @mysql_fetch_array($result,MYSQL_NUM);
					break;
				case 'object':
					$row = @mysql_fetch_object($result);
					break;
				default:
				case 'assoc':
					$row = @mysql_fetch_assoc($result);
					break;
			}	
		}
		return $row;
	}
	
	public function get_enumvalues ($table, $column) {			
			$query = "SHOW COLUMNS FROM `".$table."` LIKE '".$column."'";
			//$this->query($query);
			
			$res = mysql_query($query);
			$row = @mysql_fetch_array($res);			
			$enum = $row['Type'];			
			$off  = strpos($enum,"(");
			$enum = substr($enum, $off+1, strlen($enum)-$off-2);
			$values = explode(",",$enum);			
			// For each value in the array, remove the leading and trailing
			// single quotes, convert two single quotes to one. Put the result
			// back in the array in the same form as CodeCharge needs.
			for( $n = 0; $n < count($values); $n++) {
				$val = substr( $values[$n], 1,strlen($values[$n])-2);
				$val = str_replace("''","'",$val);
				$values[$n] = stripslashes($val);//array( $val, $val );
			}			
			return $values;
			//$values;
			//preg_match_all("/'([\w]*)'/", $this->last_result[0]->Type, $values);
			//return $values[1];
	}
	
	public function checkuserpermission($userid, $section_name, $page_name=false, $perm_lbl=false) {		
			if($page_name) {
				$pg_sql = " and page_name='".$page_name."' ";
			} 
			if($perm_lbl) {
				$pm_sql = " and permission_label='".$perm_lbl."' ";
			}
			
			$sql = "select * from user_panel_permission where usermaster_id='".$userid."' and perm_id in (select perm_id from user_perm_master where section_name='".$section_name."' ".$pg_sql.$pm_sql." ) ";
			//echo "<br/>".$sql."<br/>";
			$result = mysql_query($sql);
			if(@mysql_num_rows($result) > 0) {
				return true;
			} else {
				return false;
			}	
		}
		
	public function client_checkuserpermission($userid, $section_name, $page_name=false, $perm_lbl=false){
		if($page_name){
			$pg_sql = " and page_name='".$page_name."' ";
		}
		if($perm_lbl){
			$pm_sql = " and permission_label='".$perm_lbl."' ";
		}
		
		$sql = "select * from client_user_panel_permission where usermaster_id='".$userid."' and perm_id in (select perm_id from client_user_perm_master where section_name='".$section_name."' ".$pg_sql.$pm_sql." ) ";
		$result = mysql_query($sql);
		if(@mysql_num_rows($result) > 0){
			return true;
		}else{
			return false;
		}
	}
		
	public function checkuserpermission_page($userid, $realpage_name) {		
		if($realpage_name){
			$rp_sql = " realpage_name='".$realpage_name."' ";
		}
		$sql = "select * from user_panel_permission where usermaster_id='".$userid."' and perm_id in (select perm_id from user_perm_master where ".$rp_sql." ) ";
		//echo "<br/>".$sql."<br/>";
		$result = mysql_query($sql);
		if(@mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}	
	}
		
	public function client_checkuserpermissionpage($userid, $realpage_name){
		if($realpage_name){
			$rp_sql = " realpage_name='".$realpage_name."' ";
		}
		$sql = "select * from client_user_panel_permission where usermaster_id='".$userid."' and perm_id in(select perm_id from client_user_perm_master where ".$rp_sql." ) ";
		//echo $sql;
		$result = mysql_query($sql);
		if(@mysql_num_rows($result) > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function arrayRecursiveDiff($aArray1, $aArray2) {
		$aReturn = array();
		foreach ($aArray1 as $mKey => $mValue) {
			if (array_key_exists($mKey, $aArray2)) {
				if (is_array($mValue)) {
					$aRecursiveDiff = $this->arrayRecursiveDiff($mValue, $aArray2[$mKey]);
						 if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
						 }else {
							if ($mValue != $aArray2[$mKey]) {
								$aReturn[$mKey] = $mValue;
						   }
						 }
			}else{
				$aReturn[$mKey] = $mValue;
			}
		}
		return $aReturn;
	}
	
	public function captureLog($userid,$table,$id,$NewTableDataRow,$oldTableDataRow,$operation,$makerchecker = false)
	{
		//print_r(Utility::$table_maker_checker);
		//exit;
		$maker_checker_flag = false;
		$maker_checker_array = Utility::$table_maker_checker[$table];
		//print_r($maker_checker_array);exit;
		
		$NewTableDataRowFilter = array();
		$table_fields = $this->FetchTableField($table);
		$fields = array_keys($NewTableDataRow);
		for($i=0;$i<count($fields);$i++) {	
			if(in_array($fields[$i], $table_fields)){
				$NewTableDataRowFilter[$fields[$i]] = $NewTableDataRow[$fields[$i]];
			}
		}
		if($operation == "Update")
		{			
			$diff = array_diff($NewTableDataRowFilter,$oldTableDataRow);
			//$diff_makerchecker = $diff;						
			if(sizeof($diff)>0){
				foreach($diff as $tempdiff=>$val)
				{									
					$tempold[$tempdiff] =  $oldTableDataRow[$tempdiff];						
					if($diff[$tempdiff] == $tempold[$tempdiff])
					{
						unset($diff[$tempdiff]);
						unset($tempold[$tempdiff]);
					}
					if(sizeof($maker_checker_array) > 0)
					{
						if(in_array($tempdiff, $maker_checker_array))	
						{
							$maker_checker_flag = true;
							/*$tempold_makerchecker[$tempdiff] =  $oldTableDataRow[$tempdiff];
							if($diff_makerchecker[$tempdiff] == $tempold_makerchecker[$tempdiff])
							{
								unset($diff_makerchecker[$tempdiff]);
								unset($tempold_makerchecker[$tempdiff]);
							}*/
						}
					}					
				}

				$dbconfigobj = new Dbconfig();
				$dbhandle = mysql_connect($dbconfigobj->HostName(), $dbconfigobj->User(), $dbconfigobj->Password(),true) or die("Unable to connect to MySQL");
				$selected = mysql_select_db("INFORMATION_SCHEMA",$dbhandle) or die("Could not select examples");
				$str = 'USE INFORMATION_SCHEMA;';
				$str2='SELECT COLUMN_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME FROM KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = "'.$dbconfigobj->GetDb().'" AND TABLE_NAME = "'.$table.'" AND referenced_column_name IS NOT NULL';
				mysql_query($str,$dbhandle);
				$result = mysql_query($str2,$dbhandle);					
								
				$foreignkey = array();
				while($row = @mysql_fetch_assoc($result)){
					$foreignkey[] = $row;
				}
				mysql_close($dbhandle);
//				print_r($foreignkey);
//				exit;			
				$this->ConnectionOpen();
				
				if(sizeof($tempold) > 0)
				{
					for($i=0;$i<sizeOf($foreignkey);$i++)
					{
						//echo Utility::$table_id_name[$foreignkey[$i]['REFERENCED_TABLE_NAME']]."\n";
						//echo $foreignkey[$i]['REFERENCED_TABLE_NAME']." = ".$foreignkey[$i]['REFERENCED_COLUMN_NAME']."\n";
						
						if(array_key_exists($foreignkey[$i]['COLUMN_NAME'], $tempold)){
							$value = $this->FetchCellValue($foreignkey[$i]['REFERENCED_TABLE_NAME'],Utility::$table_id_name[$foreignkey[$i]['REFERENCED_TABLE_NAME']],$foreignkey[$i]['REFERENCED_COLUMN_NAME']." = '".$tempold[$foreignkey[$i]['COLUMN_NAME']]."'");
							$tempold[$foreignkey[$i]['COLUMN_NAME']."_value"] = $value;
						}
						if(array_key_exists($foreignkey[$i]['COLUMN_NAME'], $diff)){
							$value = $this->FetchCellValue($foreignkey[$i]['REFERENCED_TABLE_NAME'],Utility::$table_id_name[$foreignkey[$i]['REFERENCED_TABLE_NAME']],$foreignkey[$i]['REFERENCED_COLUMN_NAME']." = '".$diff[$foreignkey[$i]['COLUMN_NAME']]."'");
							$diff[$foreignkey[$i]['COLUMN_NAME']."_value"] = $value;
						}
						/*if(sizeof($tempold_makerchecker) > 0)
						{
							if(array_key_exists($foreignkey[$i]['COLUMN_NAME'], $tempold_makerchecker)){
								$value = $this->FetchCellValue($foreignkey[$i]['REFERENCED_TABLE_NAME'],Utility::$table_id_name[$foreignkey[$i]['REFERENCED_TABLE_NAME']],$foreignkey[$i]['REFERENCED_COLUMN_NAME']." = '".$tempold_makerchecker[$foreignkey[$i]['COLUMN_NAME']]."'");
								$tempold_makerchecker[$foreignkey[$i]['COLUMN_NAME']] = $value;
							}
							if(array_key_exists($foreignkey[$i]['COLUMN_NAME'], $diff_makerchecker)){
								$value = $this->FetchCellValue($foreignkey[$i]['REFERENCED_TABLE_NAME'],Utility::$table_id_name[$foreignkey[$i]['REFERENCED_TABLE_NAME']],$foreignkey[$i]['REFERENCED_COLUMN_NAME']." = '".$diff_makerchecker[$foreignkey[$i]['COLUMN_NAME']]."'");
								$diff_makerchecker[$foreignkey[$i]['COLUMN_NAME']] = $value;
							}
						}*/
					}
				
					$data = array();
					$data['ip'] = $_SERVER['REMOTE_ADDR'];
					$data['user_id'] = $userid;
					$data['identifier_field'] = $table;
					$data['identifier_id'] = $id;
					$data['value_from'] = json_encode($tempold);
					$data['value_to'] = json_encode($diff);
					$data['created'] = date("Y-m-d H:i:s");
					$data['operation'] = $operation;
					if($makerchecker)
					{
						$this->Insert("tbl_maker_checker", $data);
					}else{
						$this->Insert("tbl_logs", $data);
					}
				}						
			}
		}else{
			
			/*
			 * Get Value from foreign keys
			 */
			$dbconfigobj = new Dbconfig();
			$dbhandle = mysql_connect($dbconfigobj->HostName(), $dbconfigobj->User(), $dbconfigobj->Password(),true) or die("Unable to connect to MySQL");
			$selected = mysql_select_db("INFORMATION_SCHEMA",$dbhandle) or die("Could not select examples");
			$str = 'USE INFORMATION_SCHEMA;';
			$str2='SELECT COLUMN_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME FROM KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = "'.$dbconfigobj->GetDb().'" AND TABLE_NAME = "'.$table.'" AND referenced_column_name IS NOT NULL';
			mysql_query($str,$dbhandle);
			$result = mysql_query($str2,$dbhandle);					
							
			$foreignkey = array();
			$primarykey = array();
			while($row = @mysql_fetch_assoc($result)){
				$foreignkey[] = $row;
			}
			
			$str2='SELECT COLUMN_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME FROM KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = "'.$dbconfigobj->GetDb().'" AND TABLE_NAME = "'.$table.'" AND referenced_column_name IS NULL';
			mysql_query($str,$dbhandle);
			$result1 = mysql_query($str2,$dbhandle);	
			while($row1 = @mysql_fetch_assoc($result1)){
				$primarykey[] = $row1;
			}			
			mysql_close($dbhandle);
			//print_r($foreignkey);			
			$this->ConnectionOpen();
			for($i=0;$i<sizeOf($foreignkey);$i++)
			{
				//echo Utility::$table_id_name[$foreignkey[$i]['REFERENCED_TABLE_NAME']]."\n";
				if(array_key_exists($foreignkey[$i]['COLUMN_NAME'], $NewTableDataRowFilter)){
					$value = $this->FetchCellValue($foreignkey[$i]['REFERENCED_TABLE_NAME'],Utility::$table_id_name[$foreignkey[$i]['REFERENCED_TABLE_NAME']],$foreignkey[$i]['REFERENCED_COLUMN_NAME']." = '".$NewTableDataRowFilter[$foreignkey[$i]['COLUMN_NAME']]."'");
					$NewTableDataRowFilter[$foreignkey[$i]['COLUMN_NAME']."_value"] = $value;
				}				
			}
			for($i=0;$i<sizeOf($primarykey);$i++)
			{
				if(array_key_exists($primarykey[$i]['COLUMN_NAME'], $NewTableDataRowFilter)){
					$NewTableDataRowFilter[$primarykey[$i]['COLUMN_NAME']."_value"] = $id;
				}
			}
			//print_r($NewTableDataRowFilter);
			
			$data = array();
			$data['ip'] = $_SERVER['REMOTE_ADDR'];
			$data['user_id'] = $userid;
			$data['identifier_field'] = $table;
			$data['identifier_id'] = $id;
			$data['value_from'] = json_encode($NewTableDataRowFilter);
			$data['value_to'] = "";
			$data['created'] = date("Y-m-d H:i:s");
			$data['operation'] = $operation;			
			if($makerchecker){
				$this->Insert("tbl_maker_checker", $data);
			}else{
				$this->Insert("tbl_logs", $data);
			}
		}
	}

	// New Insert and Update Null Values
	public function Insertnew($table,$data,$status = 0) {
		
		//print_r($data);//exit;
		
		$data = $this->FilterParameters($data);
		$fields = array_keys($data);
		$table_fields = $this->FetchTableField($table);
		
		$parameters = array();
		$str = array();
		for($i=0;$i<count($fields);$i++) {
			
			if(in_array($fields[$i], $table_fields)){

				if(is_array($data[$fields[$i]]) && count($data[$fields[$i]]) >1) {
					$data_arr=implode(',',$data[$fields[$i]]);
				} else {
					//$data_arr=$data[$fields[$i]];
//					echo $data[$fields[$i]]; 
					if(!empty($data[$fields[$i]]))
					{
//						echo "if";
						$data_arr=$data[$fields[$i]];
						$str[]="'".$data_arr."'";
					}
					else {
//						echo "else";
						$data_arr='null';
						$str[]=$data_arr;
					}
				}				
				$parameters[]=$fields[$i];
			}
		}
		$sql="insert into `$table` (".implode(',',$parameters).") values (".implode(',',$str).")";
//		echo $sql.'<br/>';
//		exit;
		$res=mysql_query($sql);
		$id=mysql_insert_id();
		
		if($res) {
			if($status == '1') {
				return $id;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	public function Updatenew($table,$d,$id_field,$id_field_value) {
		
		$d = $this->FilterParameters($d);
		$f = array_keys($d);
		$table_fields = $this->FetchTableField($table);
		
		for($i=0;$i<count($f);$i++) {
			
			if(in_array($f[$i], $table_fields)){
				if(is_array($d[$f[$i]])) {
					if(sizeof($d[$f[$i]]) > 1){
						$data_arr=implode(',',$d[$f[$i]]);
					}else{
						$data_arr = $d[$f[$i]];
						$data_arr = $data_arr[0];
					}
					$parameters[]=$f[$i]."="."'".$data_arr."'";
				} else {
						
					if($d[$f[$i]]==""){
						$data_arr='null';
						$parameters[]=$f[$i]."=".$data_arr;
					}else{
						$format_string = (string)$d[$f[$i]];
						$data_arr=$format_string;
						$parameters[]=$f[$i]."="."'".$data_arr."'";
					}
				}
				
			}
		}

		$sql="update $table set ".implode(',',$parameters)." where $id_field='".$id_field_value."'";
//		echo $sql.'<br/>';
//		exit;
		$res=mysql_query($sql);
		if($res) {
			return true;
		} else {
			return false;
		}
	}
	
	public function summary($str, $limit=100, $strip = false) {
		$str = ($strip == true)?strip_tags($str):$str;
		if (strlen ($str) > $limit) {
			$str = substr ($str, 0, $limit - 3);
			return (substr ($str, 0, strrpos ($str, ' ')).'...');
		}
		return trim($str);
	}
}
?>