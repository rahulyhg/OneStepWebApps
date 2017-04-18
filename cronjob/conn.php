<?php
ini_set('max_execution_time', '0');
date_default_timezone_set("Canada/Eastern");

@session_start();
define('BASEPATH','/');

define('SITE_URL',SelfURL());
define('SITE_ROOT',SelfURL().BASEPATH);

define('JS', SITE_ROOT.'/js');
define('CSS', SITE_ROOT.'/css');
define('IMAGES', SITE_ROOT.'/images');
define('PHP', SITE_ROOT.'/php');
define('PLUGINS', SITE_ROOT.'/plugins');
define('SITE_IMAGES', SITE_ROOT.'/site_images');
define('ABSOLUTE_DOC_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('DOC_ROOT', ABSOLUTE_DOC_ROOT . BASEPATH );
define('UPLOADS',SITE_ROOT.'/admin/images');

/*
$stripe = array(
  "secret_key"      => "sk_test_kOhMvFRlntPmO2FLOFbmOveC",
  "publishable_key" => "pk_test_dmTyGiPHjVtwa1OCSv8S1bJ4"
);
$client_id = array(
  "dev"      => "ca_6R5XqnThF77Nr27y19PpOUormZhYLkj6",
  "prod" => "ca_6R5XWIUOoHqJlU3L37BrvQaJtiwrp6Fn"
);*/
$stripe = array(
  "secret_key"      => "sk_test_oC1vyIVj8a1qzL3vthPro8ii",
  "publishable_key" => "pk_test_kwMcNUsWbRSO14jhVnOVsxZY"
);

// DB Connection
$mysqli = new mysqli("localhost", "vettreefiles", "@vettreefiles123#", "vettreefiles");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
function SelfURL(){
	//$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	//$protocol = StrLeft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	//$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	//http://vettreefiles.com
	//return $protocol."://".$_SERVER['SERVER_NAME'].$port;
	return "http://vettreefiles.com";
}
function StrLeft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}
?>