<?php

class Error extends Controller
{
	function __construct() 
	{
		parent::__construct();
		$this->view->msg='Page does not exist.';
		$this->view->render('error/index');
	}
	public function index() 
	{
		parent::__construct();
		$this->view->msg='Page does not exist.';
		$this->view->render('error/index');
	}
}

?>