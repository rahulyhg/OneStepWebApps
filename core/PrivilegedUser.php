<?php
class PrivilegedUser
{
    // override User method
    public function getByUsername($role_id) 
    {
    	$db = new Db();	
    	$user_privilage = array();
		
		$condition = "i.role_id = '$role_id'";
		$main_table = array("role_perm i",array("i.*"));
		$join_tables = array(
					array('left','permissions r','r.perm_id = i.perm_id', array('r.perm_desc as perm_desc'))
		);
		
		$sql = "select i.*, r.perm_desc as perm_desc from role_perm i left join permissions r on (r.perm_id = i.perm_id ) where i.role_id = '".$role_id."'";
		try
		{
			$rs3=mysql_query($sql);
			while($row4 = mysql_fetch_object($rs3))
			{
				$user_privilage[$row4->perm_desc] = true;
			}   
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		return $user_privilage;    		
    }
 
    // check if user has a specific privilege
    public function hasPrivilege($perm) 
    {
		$user_privilage = $_SESSION["samajadmin"]["user_privilage"];
     	return isset($user_privilage[$perm]);       
    }
}
?>