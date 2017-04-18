<?php
@session_start();
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$base_image_path = "";
$db = new Db();
$access = "";
if(isset($_SESSION["samajadmin"]["id"]))
{
	$user_id = $_SESSION["samajadmin"]["id"];

	$rs = $db->FetchRow("admin_member","id",$user_id);
	if($rs != "" )
	{
		$result = mysql_fetch_array($rs);
	}
	$base_image = $db->FetchCellValue("image_xref","image_id","ref_id = ".$_SESSION["samajadmin"]["id"]." && status = '3' && ref_type = '13' ");
	if($base_image != "")
	{
		$base_image_path = $db->FetchCellValue("image","path","id = ".$base_image." AND flag = '1' ");
	}
	else
	{
		$base_image_path = '/uploads/images.png';
	}
	 $access = new PrivilegedUser(); 
}

				/*	$table881 = "lov";
					$at = explode("/",$_SERVER['REQUEST_URI']);
					
					if($at[4]=="")
						$at[4] = "index";
					if($at[3] == "")
						$at[3] = "login";
					
					$at1 = explode("?",$at[4]);
					
					$condition881 = " i.type='adv_display_page' && i.value ='".$at[3]."-".$at1[0]."' && r.display_page_section = '72' && r.adv_status= '77' && r3.ref_type= '80' " ;
					$main_table881 = array("$table881 i",array("i.*"));
					//$join_tables = array();
					$join_tables881 = array(
						array('left',' samaj_advtisement r','r.display_page_id = i.id', array('r.adv_url as url')),
						
						array('left',' image_xref r3','r3.ref_id = r.id', array()),
						
						array('left',' image r4','r4.id = r3.image_id', array('r4.path as path'))
					);
					
					$rs88 = $db->JoinFetch($main_table881, $join_tables881, $condition881);
					$totalcount88 =  @mysql_num_rows($rs88);
			*/
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="msapplication-tap-highlight" content="no">
		<meta name="description" content="One Step">
		<meta name="keywords" content="One Step">
		<title>One Step</title>
		<!-- CORE CSS-->
		<link href="<?php echo CSS_Admin2; ?>/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
		<link href="<?php echo CSS_Admin2; ?>/style.css" type="text/css" rel="stylesheet" media="screen,projection">
		<!-- Custome CSS-->    
		<link href="<?php echo CSS_Admin2; ?>/custom/custom.css" type="text/css" rel="stylesheet" media="screen,projection">
		<link href="<?php echo CSS;?>/datatables.min.css" rel="stylesheet" type="text/css" />
		<!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
		<link href="<?php echo CSS_Admin2; ?>/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
		<link href="<?php echo CSS_Admin2; ?>/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
		<link href="<?php echo CSS_Admin;?>/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo CSS_Admin;?>/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo JS_Admin2; ?>/plugins/fullcalendar/css/fullcalendar.min.css" type="text/css" rel="stylesheet" media="screen,projection">
		
		<link href='<?php echo CSS;?>/jquery.pnotify.default.css' rel='stylesheet' />
		<link href='<?php echo CSS;?>/fullcalendar.css' rel='stylesheet' />
		<link href='<?php echo CSS;?>/fullcalendar.print.css' rel='stylesheet' media='print' />
		
		
		<script type="text/javascript" src="<?php echo JS_Admin2;?>/jquery-1.11.2.min.js"></script>
		<script src="<?php echo JS;?>/jquery.form.js"></script>
		<script src="<?php echo JS_Admin;?>/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo JS_Admin;?>/jquery.validate.js" type="text/javascript"></script>
		<script src="<?php echo JS;?>/jquery.pnotify.min.js"></script>
		
		<script src='<?php echo JS;?>/moment.min.js'></script>
		<script src='<?php echo JS;?>/fullcalendar.min.js'></script>
	
  <!--materialize js-->
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/materialize.js"></script>
  <!--prism-->
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/plugins.js"></script>
  <script src="<?php echo JS;?>/jquery.dataTables.min.js"></script>
  <script src="<?php echo JS;?>/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo JS;?>/dataTables.responsive.min.js"></script>
  <script src="<?php echo JS;?>/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="<?=JS;?>/plugins/sweetalert/dist/sweetalert.min.js"></script>   
<link href="<?=JS;?>/plugins/sweetalert/dist/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">

    <script type="text/javascript" src="<?php echo JS_Admin2; ?>/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
  <style> 
  *:focus {outline:none;}
  @media (min-width:981px){
	#chat-out{
	  left:auto!important;
	  right:0!important;
	  top:65px;
	  }
	  #main{
		  padding-right:300px;
	  }  
  }
  nav{
	  background:#4285F4
  }
	.mycls:hover{
	background:#4285f4 !important;
	}
	.mycls:hover i{
		color:#fff !important;
	}
	.toast {
		left: 45% !important;
		top: 45% !important;
		position: fixed;
		box-shadow: 0px 0px 70px white;
	}
	.fc-day-grid-container.fc-scroller
	{
		height:400px!important;
	}
	#headingSearchtitle{
		 font-size: 18px;
		font-weight: bold;
		padding-left: 0px;
		padding-right: 0px;
		position: relative;
		top: -6px;
	}
	#projecttitle{
		font-size: 22px; position: relative; 
		padding-left: 0px;
		padding-right: 10px;
		top: -6px;
	}
	.header-search-wrapper h4
	{
		text-transform: uppercase; 
		letter-spacing: 0.5px;
	}
	.user-details.cyan.darken-2{
		background:#f3f3f3 !important;
		padding:40px 0 10px 14px !important;
		margin-bottom:0px !important;
	}
	.clientprofi{
		 float: left !important;
		font-size: 14px !important;
		height: auto !important;
		line-height: 35px !important;
		padding: 15px 14px 0 !important;
		text-align: center !important;
		width: 100% !important;
	}
	#slide-out{
		position:fixed !important;
		width:240px!important;
	}
	ul.side-nav.leftside-navigation li a{
		float:left;
		width:100%;
	}
	.divider {
		background-color: #e0e0e0;
		float: left;
		height: 1px;
		width: 100%;
	}
	 #data-table-row-grouping_length label{color:transparent;}
	 #data-table-row-grouping_length div{color:#9e9e9e;}
</style>
	</head>
    <!-- END HEAD -->
    <body class="">
        <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START HEADER -->
  <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="navbar-color">
                <div class="nav-wrapper">
                    <ul class="left">                      
                      <li><h1 class="logo-wrapper"><a href="index.html" class="brand-logo darken-1" style="padding: 0px 55px; text-align: center;"><img src="<?php echo IMAGES; ?>/logo-white.png" alt="One Step logo" style="width: 130px; display:none;"></a> <span class="logo-text">One Step</span></h1></li>
					  <li>
					  <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="slide-out"><i class="fa fa-bars" aria-hidden="true" style="line-height:18px; padding:0px; color:#fff;"></i></a>
                        </li>
                    </ul>
                    <div class="header-search-wrapper hide-on-med-and-down" style="margin:10px 0">
                      <h4 style=" color: white; z-index: 9; margin-left: 0px; margin-top: 5px; padding-top:0px; height:36px; "> <span id="headingSearchtitle" style="font-size:18px;"></span> <?php if(isset($_REQUEST['project_id'])){ ?>| <a href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id'];?>"><span id="projecttitle" style="font-size:15px;cursor:pointer;"><?php $project_name  = $db->FetchCellValue("projects","project_name","id = '".$_REQUEST['project_id']."'"); echo $project_name; ?></span></a> <?php } ?></h4>
                    </div>
                    <ul class="right hide-on-med-and-down">
                        <li style="display:none;"><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
                        </li>
                                                
                        <li>
						<ul id="profile-dropdown" class="dropdown-content">
                        <li><a href="<?php echo SITE_ROOT."/project/listclients"; ?>" class="waves-effect waves-block waves-light notification-button clientprofi"><i class="mdi-social-people" style="font-size: 50px;"></i>
						client List
                        </a>
                        </li>
						<li><a class="clientprofi" href="<?php echo SITE_ROOT."/users/myprofile/";?>"><i class="mdi-action-face-unlock" style="font-size:40px;"></i> Profile</a>
                        </li>
						
                        <li class="divider"></li>
                        <li><a class="clientprofi" href="<?php echo SITE_ROOT;?>/logout"><i class="mdi-hardware-keyboard-tab" style="font-size:40px;"></i> Logout</a>
                        </li>
						</ul>

							<a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><img aria-hidden="true" src="<?php echo IMAGES; ?>/menuitam.png"></a>
                        </li>
						
                    </ul>
                    <!-- translation-button -->
                    <ul id="translation-dropdown" class="dropdown-content">
                      <li>
                        <a href="#!"><img src="<?php echo CSS; ?>/images/flag-icons/United-States.png" alt="English" />  <span class="language-select">English</span></a>
                      </li>
                    </ul>
                </div>
            </nav>
        </div>
  </header>
<div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">

      <!-- START LEFT SIDEBAR NAV-->
      <aside id="left-sidebar-nav">
        <ul id="slide-out" class="side-nav fixed leftside-navigation">
            <li class="cyan darken-2" style="text-align:center;background:#f3f3f3!important;">
            <div class="row">
                <div class="col">
					<a href="index.html" class="brand-logo darken-1" style="padding: 0px; position: relative; width: 100%;height:auto;"><img src="<?php echo IMAGES; ?>/logo-white.png" alt="One Step logo" style="width: 80%;display:inline-block;"></a>
                </div>
            </div>
            </li>
            <!-- <li class="bold"><a href="index.html" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Dashboard</a> -->
			<li class="bold" id="homemenu"><a href="<?php echo SITE_ROOT;?>/home" class="waves-effect waves-cyan"><i class="mdi-action-home"></i> Home</a> </li>
            <li class="bold" id="projectmenu"> <a href="<?php echo SITE_ROOT;?>/home/listprojects" class="waves-effect waves-cyan"><i class="mdi-image-movie-creation"></i> My Projects</a> </li>
            <li class="divider"></li>
			<li class="bold" id="gennotemenu"><a href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/home/listnotes?project_id=".$_REQUEST['project_id']; else echo "#"; ?>" <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> class="waves-effect waves-cyan"><i class="mdi-notification-folder-special" style="height:auto;"></i> General Notes</a></li>
			
			<li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li class="bold"><a id="interiorli" class="collapsible-header waves-effect waves-cyan" style="color:#444;"><i class="mdi-action-view-carousel" style="height:auto;"></i> Interior</a>
                        <div class="collapsible-body" id="interiorlidiv">
                            <ul>
                                <li id="intnotes"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/home/listinternalnotes?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-content-content-paste"></i>Notes</a></li>
                                <li id="intest"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/internalestimate?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-action-assignment-late"></i>Estimate</a></li>
                                <li id="intproject"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/internal_project?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-action-assignment"></i>Project</a></li>
                                <li id="intpricing"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/internal_pricing?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-editor-attach-money"></i>Pricing</a></li>
                                <li id="intsummary"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/internal_summary?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-action-subject"></i>Summary</a></li> 
                                <li id="inthours"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/internal_hrs_tracking?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-av-timer"></i>Hours Tracking</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li> 
			<li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li class="bold"><a id="exteriorli" class="collapsible-header waves-effect waves-cyan" style="color:#444;"><i class="mdi-action-view-day" style="height:auto;"></i> Exterior</a>
                        <div class="collapsible-body" id="exteriorlidiv">
                            <ul>
                                <li id="extnotes"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/home/listexternalnote?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-content-content-paste"></i>Notes</a></li>
                                <li id="extest"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/externalestimate?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-action-assignment-late"></i>Estimate</a></li> 
								<li id="extproject"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/external_project?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-action-assignment"></i>Project</a></li>
                                <li id="extpricing"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/external_pricing?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-editor-attach-money"></i>Pricing</a></li>
                                <li id="extsummary"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/external_summary?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-action-subject"></i>Summary</a></li> 
                                <li id="exthours"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/external_hrs_tracking?project_id=".$_REQUEST['project_id']; else echo "#"; ?>"><i class="mdi-av-timer"></i>Hours Tracking</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
			<li class="divider"></li>
			<li class="bold" id="productionrates"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/production_rates?project_id=".$_REQUEST['project_id']; else echo "#"; ?>" class="waves-effect waves-cyan"><i class="mdi-maps-local-atm"></i> Production Rates</a> </li>
			<!-- <li class="bold" id="clientlist"><a href="<?php echo SITE_ROOT."/project/listclients"; ?>" class="waves-effect waves-cyan"><i class="mdi-action-list"></i>Clients List</a> </li> -->
			<li class="bold" id="cabstackoff"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/cabtackoff?project_id=".$_REQUEST['project_id']; else echo "#"; ?>" class="waves-effect waves-cyan"><i class="mdi-maps-directions-car"></i> Cab Takes Off</a> </li>
			
			<li class="bold" id="listsoff"><a <?php if(!isset($_REQUEST['project_id']) && $_REQUEST['project_id'] == "") echo "onclick='Materialize.toast(".'"Please Select Project First"'.", 4000)'" ;?> href="<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") echo SITE_ROOT."/project/lists?project_id=".$_REQUEST['project_id']; else echo "#"; ?>" class="waves-effect waves-cyan"><i class="mdi-action-list"></i> Lists</a> </li>
            <li class="li-hover"><div class="divider"></div></li> 
        </ul>
        <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
        </aside>
      <!-- END LEFT SIDEBAR NAV-->
      <!-- //////////////////////////////////////////////////////////////////////////// -->

      <!-- START CONTENT -->
      <section id="content">
        
        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
            <!-- Search for small screen -->
            <div class="header-search-wrapper grey hide-on-large-only">
				
            </div>
        <!--start container-->
        <div class="container">
			<div class="section">
				<?php require 'application/views/'.$page_name.'.php';?>
			</div>
			<!-- Floating Action Button -->
            <div class="fixed-action-btn" style="bottom: 30px; right: 330px; z-index: 1000 ! important;">
                <a class="btn-floating btn-large" style="background:#4285f4;" href="<?php echo SITE_ROOT; ?>/home/projects">
                  <i class="mdi-content-add"></i>
                </a>
				<?php if(isset($_REQUEST['project_id']) && $_REQUEST['project_id'] != "") { ?>
             <!--   <ul>
				<li><a href="<?php echo SITE_ROOT."/project/externalestimate?project_id=".$_REQUEST['project_id']; ?>" class="btn-floating" data-tooltip="Add Exterior Estimate" title="Add Exterior Estimate"><i class="large mdi-content-add" style="background:#00695C;"></i></a></li>
                 <li><a href="<?php echo SITE_ROOT."/home/externalnote?project_id=".$_REQUEST['project_id']; ?>" class="btn-floating" data-tooltip="Add Exterior Notes" title="Add Exterior Notes"><i class="large mdi-content-add" style="background:#00695C;"></i></a></li>
                 <li><a href="<?php echo SITE_ROOT."/project/internalestimate?project_id=".$_REQUEST['project_id']; ?>" class="btn-floating" data-tooltip="Add Interior Estimate" title="Add Interior Estimate"><i class="large mdi-content-add" style="background:#B71C1C;"></i></a></li>
				 <li><a href="<?php echo SITE_ROOT."/home/internalnote?project_id=".$_REQUEST['project_id']; ?>" class="btn-floating" data-tooltip="Add Interior Notes" title="Add Interior Notes"><i class="large mdi-content-add" style="background:#B71C1C;"></i></a></li>
				  <li><a href="<?php echo SITE_ROOT."/home/notes?project_id=".$_REQUEST['project_id']; ?>" class="btn-floating"  data-tooltip="Add General Notes" title="Add General Notes"><i class="large mdi-content-add" style="background:#4285F4;"></i></a></li>
                </ul> -->
				<?php } ?>
            </div>
            <!-- Floating Action Button -->
        </div>
        <!--end container-->
      </section>
      <!-- END CONTENT -->

      <!-- //////////////////////////////////////////////////////////////////////////// -->
      <!-- START RIGHT SIDEBAR NAV-->
      <aside id="right-sidebar-nav">
        <ul id="chat-out" class="side-nav fixed rightside-navigation" style="left: auto; right: 0;width:298px !important; z-index:0 !important;">
            <li class="li-hover">
				<div class="row">
					<div class="col s12 m8 l12">
						<div id='calendar'></div>
					</div>
				</div>
            </li>
        </ul>
      </aside>
      <!-- LEFT RIGHT SIDEBAR NAV-->

    </div>
    <!-- END WRAPPER -->

  </div>



  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START FOOTER -->
  <footer class="page-footer ligh-blueclr" style="display:none;">
    <div class="footer-copyright">
      <div class="container">
        <span>Copyright © 2016 All rights reserved.</span>
        <span class="right"> Design and Developed by</span>
        </div>
    </div>
  </footer>
  <!-- END FOOTER -->



    <!-- ================================================
    Scripts
    ================================================ -->
   
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?php echo JS_Admin2; ?>/plugins.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="<?php echo JS_Admin2; ?>/custom-script.js"></script>
	
	<script type="text/javascript">
	function displayMsg(type,msg)
		{
			var icon,title,icon = "";
			if(type=="1"){
				type="success";
				title = "Success Message";
				icon = 'picon icon16 iconic-icon-check-alt white';
			}else{
				type="error";
				title = "Error Message";
				icon = 'picon icon16 typ-icon-cancel white';
			}
			jQuery.pnotify_remove_all();
			jQuery.pnotify({
				type: type,
				title: title,
				text: msg,
				icon: icon,
				opacity: 0.95,
				hide:true,
				history: true,
				sticker: false
			});
		}
	
	jQuery(document).ready(function($){
				jQuery(document).ajaxSend(function(event, jqXHR, settings) {
			
				jQuery("#loading").css('display','block');
		});
		jQuery(document).ajaxComplete(function(event, jqXHR, settings) {
			jQuery("#loading").css('display','none');
		});
		jQuery( document ).ajaxError(function() {
			jQuery("#loading").css('display','none');
		});
		jQuery( document ).ajaxStop(function() {
			jQuery("#loading").css('display','none');
		});
		jQuery( document ).ajaxSuccess(function() {
			jQuery("#loading").css('display','none');
		});
		
		jQuery("#loading").css('display','none');
	
		});
		
		<?php
			 if(isset($_SESSION["samajadmin"]['msg']))
			 {
			  ?>
			  Materialize.toast("<?php echo $_SESSION["samajadmin"]['msg']; ?>", 2000);
			  <?php 
			  unset($_SESSION["samajadmin"]['msg']);
			  unset($_SESSION["samajadmin"]['msg_type']);
			 }
		?>
</script>
<script>
$(document).ready(function() {
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	calendar = $('#calendar').fullCalendar({
		//editable: true,
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		viewRender: function(view) {
		},
		/*viewRender: function(view) {
			try {
				setTimeline();
			} catch(err) {}
		},*/
		//events: "<?=SITE_ROOT ?>/users/fetchapp<?php if(isset($_REQUEST['doctor'])) echo "?doctor=".$_REQUEST['doctor']; ?>",
		// Convert the allDay from string to boolean
		eventRender: function(event, element, view) {
			
			if (event.allDay === 'true') {
			event.allDay = true;
			} else {
			event.allDay = false;
			}
		},
		selectable: true,
		selectHelper: true,
		editable: true
	});
	$('.modal-close').click(function(){
		$('.lean-overlay').css('display','none');
	});
});
</script>
</body>
</html>