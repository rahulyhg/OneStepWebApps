<?php
error_reporting(0);
date_default_timezone_set("Canada/Eastern");

//define('BASEPATH','/');
define('BASEPATH','/onestepnew');

define('SITE_URL',Core:: SelfURL());
define('SITE_ROOT',Core:: SelfURL().BASEPATH);

define('JS', SITE_ROOT.'/js');
define('JS_Admin', SITE_ROOT.'/js/admin');
define('JS_Admin2', SITE_ROOT.'/js/admin2');
define('CSS', SITE_ROOT.'/css');
define('CSS_Admin', SITE_ROOT.'/css/admin');
define('CSS_Admin2', SITE_ROOT.'/css/admin2');
define('IMAGES', SITE_ROOT.'/images');
define('IMAGES_Admin', SITE_ROOT.'/images/admin');
define('UPLOADS', SITE_ROOT.'/uploads');
define('PHP', SITE_ROOT.'/php');
define('PLUGINS', SITE_ROOT.'/plugins');
define('CLASSES', SITE_ROOT.'/classes');
define('ABSOLUTE_DOC_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('DOC_ROOT', ABSOLUTE_DOC_ROOT . BASEPATH );
define('SERVICE_TAX',"12.36");

define('IDPREFIX','AA');
define('PATIENT_ROLE',5);

define('PUBLISHABLE_KEY',"pk_test_kwMcNUsWbRSO14jhVnOVsxZY");
//define('PUBLISHABLE_KEY',"pk_live_6IgAvNc1a4G7zk029i5MWurJ");
define('SECRET_KEY',"sk_test_oC1vyIVj8a1qzL3vthPro8ii");
//define('SECRET_KEY',"sk_live_4w2k4HgiirZdgfdUEniaVVzR");

$stripe = array(
  "secret_key"      => "sk_test_oC1vyIVj8a1qzL3vthPro8ii",
  "publishable_key" => "pk_test_kwMcNUsWbRSO14jhVnOVsxZY"
);
/*$stripe = array(
  "secret_key"      => "sk_live_hCy4hGgaJpPSd3AdA0EO4XnD",
  "publishable_key" => "pk_live_x23Gnw60zJJI3F55yGoKFvUV"
);*/

?>