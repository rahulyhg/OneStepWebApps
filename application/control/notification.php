<?php
class Notification  extends Controller 
{
	public function index()
	{
		parent::__construct();
		$this->view->admin("notification/index");
	}
}

?>