<?php
/*
 * @auther	: 	Tejas Patel
 * @desc	:	Bootstrap file for action calling in control
 * @created	:	25 Oct 2013
 */

error_reporting(E_ALL ^ E_NOTICE);

class Bootstrap 
{
	function __construct()
	{
		$url="";
		$url=$_GET['url'];
		$url=rtrim($url,'/');
		$url=explode('/',$url);

		if(empty($url[0]))
		{
			require 'application/control/login.php';
			$controller=new Login();
			$controller->index();
			return false;
		}
		else
		{
			if($url[0] == "public" || $url[0] == "models")
			{
				$file= implode("/",$url);
				if(file_exists($file))
				{
					require $file;
					return false;
				}
			}
			$file='application/control/'.$url[0].'.php';
			if(file_exists($file))
			{
				require $file;				
			}
			else 
			{
				require 'application/control/error.php';
				$controller=new Error();
				return false;
			}
			$controller = new $url[0];
			if(isset($url[1]))
			{
				$controller->{$url[1]}();
			}
			else
			{
				$controller->{"index"}();
			}
		}
	}
}

?>