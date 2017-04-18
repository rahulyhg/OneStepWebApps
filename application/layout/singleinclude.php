
		<link href="<?php echo CSS_Admin2; ?>/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
		<link href="<?php echo CSS_Admin2; ?>/style.css" type="text/css" rel="stylesheet" media="screen,projection">
		<link href="<?php echo CSS_Admin2; ?>/custom/custom.css" type="text/css" rel="stylesheet" media="screen,projection">
		<link href="<?php echo CSS;?>/datatables.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo CSS_Admin2; ?>/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
		<link href="<?php echo CSS_Admin2; ?>/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
		<link href="<?php echo CSS_Admin;?>/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo CSS_Admin;?>/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo JS_Admin2; ?>/plugins/fullcalendar/css/fullcalendar.min.css" type="text/css" rel="stylesheet" media="screen,projection">
		
	<script type="text/javascript" src="<?php echo JS_Admin2;?>/jquery-1.11.2.min.js"></script>
	<script src="<?php echo JS;?>/jquery.form.js"></script>
    <script src="<?php echo JS_Admin;?>/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo JS_Admin;?>/jquery.validate.js" type="text/javascript"></script>
	<script src="<?php echo JS;?>/jquery.pnotify.min.js"></script>
	
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/materialize.js"></script>
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/prism.js"></script>
  <script type="text/javascript" src="<?php echo JS_Admin2;?>/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <script type="text/javascript" src="<?php echo JS_Admin2;?>/plugins.js"></script>
  <script src="<?php echo JS;?>/jquery.dataTables.min.js"></script>
  <script src="<?php echo JS;?>/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo JS;?>/dataTables.responsive.min.js"></script>
  <script src="<?php echo JS;?>/dataTables.buttons.min.js"></script>
  
    <script type="text/javascript" src="<?php echo JS_Admin2; ?>/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_Admin2; ?>/plugins/fullcalendar/lib/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_Admin2; ?>/plugins/fullcalendar/js/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_Admin2; ?>/plugins/fullcalendar/fullcalendar-script.js"></script> 
  <style> 
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

</style>
    <script type="text/javascript" src="<?php echo JS_Admin2; ?>/plugins.js"></script>
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
		
</script>

<?php 

if(file_exists('application/views/'.$page_name.'.php'))
{
	include 'application/views/'.$page_name.'.php';
}

?>