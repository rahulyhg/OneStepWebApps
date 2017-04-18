<?php
class View {
	
	function __construct() {}
	
	// Show the login page.
	public function login($page_name)
	{
		require 'application/control/include_classes.php';
		require 'application/layout/login.php';
	}
	
	public function adminlogin($page_name)
	{
		require 'application/control/include_classes.php';
		require 'application/layout/adminlogin.php';
	}
	
	// Show the admin page.
	public function admin($page_name)
	{
		require 'application/control/include_classes.php';
		require 'application/layout/admin.php';
	}
	
	public function render($page_name)
	{
		require 'application/control/include_classes.php';
		require 'application/layout/layout.php';
	}
	public function singlerender($page_name)
	{
		require 'application/control/include_classes.php';
		require 'application/layout/singleinclude.php';
	}
}

?>