<?php
@session_start();
error_reporting(0);
date_default_timezone_set('Asia/Calcutta');
ini_set('display_errors', 0);
include_once 'core/Utility.php';

require_once 'application/config/Dbconfig.php';

// Creating Db Object and Opening Connection
require_once  'core/Db.php';
$db = new Db();
$db->ConnectionOpen();

// Creating Core Object
require_once  'core/Core.php';
$core = new Core();

// Creating Utility Object
$utl = new Utility();

// Including Site Setting
require_once  'application/config/site_settings.php';

// Including User Authentication
require_once "core/PrivilegedUser.php";

$obj_privileged_user = new PrivilegedUser();

//require_once  'application/control/filters.php';
//require_once  'application/control/filters2.php';
?>
