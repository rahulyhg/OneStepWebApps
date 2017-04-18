<?php
class Accessdenided  extends Controller 
{
	public function index()
	{
		parent::__construct();
		$this->view->render("accessdenided/index");
	}
	public function __call($method, $args) 
	{
		require 'application/control/error.php';
		$controller=new Error();
		return false;
  	}  	
}

?>