<?php
@session_start();
if(isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT."/home");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="One Step">
	<meta name="keywords" content="One Step">
	<title>One Step</title>

  <!-- Favicons-->
  <link rel="icon" href="<?php echo SITE_ROOT; ?>/images/favicon/favicon-32x32.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="<?php echo SITE_ROOT; ?>/images/favicon/apple-touch-icon-152x152.png">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
  <!-- For Windows Phone -->


  <!-- CORE CSS-->
  
  <link href="<?php echo CSS_Admin2;?>/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo CSS_Admin2;?>/style.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo CSS_Admin2;?>/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo CSS;?>/jquery.pnotify.default.css" rel="stylesheet">
  
  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="<?php echo CSS_Admin2;?>/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo JS_Admin2;?>/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
   <script type="text/javascript" src="<?php echo JS_Admin2;?>/jquery-1.11.2.min.js"></script>
   <script src="<?php echo JS;?>/jquery.form.js"></script>
    <script src="<?php echo JS_Admin;?>/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo JS_Admin;?>/jquery.validate.js" type="text/javascript"></script>
	<script src="<?php echo JS;?>/jquery.pnotify.min.js"></script>
	
  <!--materialize js-->
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/materialize.js"></script>
  <!--prism-->
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/plugins.js"></script>
  <style>
  .toast {
		left: 38% !important;
		top: 45% !important;
		position: fixed;
		box-shadow: 0px 0px 70px white;
	}
	</style>
</head>
<body class="teal">
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->


<?php require 'application/views/'.$page_name.'.php';?>

  <!-- ================================================
    Scripts
    ================================================ -->

  <!-- jQuery Library -->
</body>

</html>