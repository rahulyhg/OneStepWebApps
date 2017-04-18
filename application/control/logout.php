<?php
class Logout extends Controller 
{
	public function index()
	{
		require 'include_classes.php';
		session_start();
		$user_id = $_SESSION["samajadmin"]["id"];		
		/*$relation['online_status'] = 0;
		$result2 = $db->Update('tbl_user_master',$relation,"id",$user_id);*/
		session_regenerate_id();
		session_destroy();
		session_regenerate_id();
		$core->RedirectTo(SITE_ROOT."/");
	}
	public function __call($method, $args) 
	{
		require 'application/control/error.php';
		$controller=new Error();
		return false;
  	}  	
}

?>