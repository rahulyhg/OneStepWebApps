<?php
$result= array();
$base_image_path = "";
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$access2 = new PrivilegedUser();
if (!$access2->hasPrivilege("ManageProfile"))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
$db = new Db();
if(isset($_SESSION["samajadmin"]["id"]))
{
	$user_id = $_SESSION["samajadmin"]["id"];

	$rs = $db->FetchRow("admin_member","id",$user_id);
	if($rs != null )
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
}
?>
<style>
tr.odd{background-color:#fff!important;}
tr.even{background-color:#e5eff5!important;}
.odd td{border-color:#e7e7e7!important;}
.even td{border-color:#e7e7e7!important;}
#mytable_wrapper{border: 1px solid #e7e7e7;border-top: 0px;}
.ver-inline-menu li.active i{background:#17c4bb none repeat scroll 0 0 !important;}
.ver-inline-menu li.active a, .ver-inline-menu li.active i{background:#17c4bb none repeat scroll 0 0 !important;border-left:2px solid #37a299 !important;}
.ver-inline-menu li.active::after{border-left:6px solid #17c4bb!important;}
label.error{margin-top:0;}
</style>
<script type="text/javascript" src="<?= JS; ?>/webcam.js"></script>
 <script>
        webcam.set_api_url( 'upload.php' );
        webcam.set_quality( 90 ); // JPEG quality (1 - 100)
        webcam.set_shutter_sound( true ); // play shutter click sound
        
        webcam.set_hook( 'onComplete', 'my_completion_handler' );
        
        function take_snapshot() {
            // take snapshot and upload to server
            document.getElementById('upload_results').innerHTML = 'Snapshot<br>'+
            '<img src="uploading.gif">';
            webcam.snap();
        }
        
        function my_completion_handler(msg) {
            // extract URL out of PHP output
            if (msg.match(/(http\:\/\/\S+)/)) {
                var image_url = RegExp.$1;
                // show JPEG image in page
                document.getElementById('upload_results').innerHTML = 
                    'Snapshot<br>' + 
                    '<a href="'+image_url+'" target"_blank"><img src="' + image_url + '"></a>';
                
                // reset camera for another shot
                webcam.reset();
            }
            else alert("PHP Error: " + msg);
        }
    </script>
	<!-- BEGIN PAGE HEAD-->
<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1 style="text-transform: uppercase;">My profile
		   <!-- <small>user profile sample</small>-->
		</h1>
	</div>
	<!-- END PAGE TITLE -->                       
</div>
<!-- END PAGE HEAD-->                   
<!-- BEGIN PAGE BASE CONTENT -->
<div class="profile">
	<div class="tabbable-line tabbable-full-width">
		<ul class="nav nav-tabs">                              
			<li class="active">
				<a data-toggle="tab" href="#tab_1_3" aria-expanded="true"> Account </a>
			</li>                               
		</ul>
		<div class="tab-content">                              
			<!--tab_1_2-->
			<div id="tab_1_3" class="tab-pane active">
				<div class="row profile-account">
					<div class="col-md-3">
						<ul class="ver-inline-menu tabbable margin-bottom-10">
							<li class="active">
								<a href="#tab_1-1" data-toggle="tab" aria-expanded="true">
									<i class="fa fa-cog"></i> Personal Info </a>
								<span class="after"> </span>
							</li>
							<li class="">
								<a href="#tab_2-2" data-toggle="tab" aria-expanded="false">
									<i class="fa fa-picture-o"></i> Change Profile Picture</a>
							</li>
							<li>
								<a href="#tab_3-3" data-toggle="tab" aria-expanded="true">
									<i class="fa fa-lock"></i> Change Password </a>
							</li>                                                
						</ul>
					</div>
					<div class="col-md-9">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1-1">
								<form id="form-validate" name="form-validate" enctype="multipart/form-data" method="post">
									<div class="form-group">
										<label class="control-label">First Name</label>
										<input type="text" class="form-control" maxlength="25" minlength="2" id="first_name" name="first_name" value="<?php if(isset($result['first_name']))echo $result['first_name'];?>" placeholder="First Name">
										<input class="span2" id="id" name="id" type="hidden" value="<?php if(isset($result['id']))echo $result['id'];?>"/>									
									</div>
									<div class="form-group">
										<label class="control-label">Last Name</label>
										<input type="text" class="form-control" id="last_name" name="last_name" maxlength="25" minlength="2" value="<?php if(isset($result['last_name']))echo $result['last_name'];?>" placeholder="Last Name"> </div>
									<div class="form-group">
										<label class="control-label">User Name</label>
										<input type="text" class="form-control" id="username" name="username" value="<?php if(isset($result['username']))echo $result['username'];?>" placeholder="User Name" disabled>
									</div>
									<div class="form-group">
										<label class="control-label">Email</label>
										<input type="text" class="form-control" id="email" name="email" value="<?php if(isset($result['email']))echo $result['email'];?>"  placeholder="Email">
									</div> 
									<div class="form-group">
										<label class="control-label">Mobile Number</label>
										<input type="text" class="form-control" maxlength="10" minlength="10" id="mobile_no" name="mobile_no"value="<?php if(isset($result['mobile_no']))echo $result['mobile_no'];?>" placeholder="+1 646 580 DEMO (6284)">
									</div>                                                        
									<div class="margiv-top-10">
										<input type="submit" name="submit" value="Save Changes" class="btn green"/>
									</div>
								</form>
							</div>
							<div class="tab-pane" id="tab_2-2">
								<form class="horizontal-form" id="form-thumbnail" name="form-thumbnail" enctype="multipart/form-data" method="post">
									<div class="form-group">
										<div data-provides="fileinput" class="fileinput fileinput-new">
											<div style="height: auto;width: 200px;" class="fileinput-new thumbnail">
												<img alt="" src="<?php echo SITE_ROOT."/".$base_image_path; ?>"> </div>
											<div>
											<input class="span2" id="id" name="id" type="hidden" value="<?php if(isset($result['id']))echo $result['id'];?>"/>					
												<span class="btn default btn-file">
													<span class="fileinput-new"> Select image </span>
													<span class="fileinput-exists"> Change </span>
													<input type="file" id="admin_thumbnail" name="admin_thumbnail">
													<?php 
													if(isset($result['name']) && $result['name'] != "")
													{
														$selected = $baserole_image;
														echo "<img src='".BASEPATH."/uploads/".$result['name']."' style='float:left;width:50px;height:50px;'/>";
													}
													?>	
												</span>
											</div>
										</div>
										<div class="clearfix margin-top-10">
											<span class="label label-danger"> NOTE! </span>&nbsp;&nbsp;
											<span> Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
										</div>
									</div>
									<div class="margin-top-10">
										<input type="submit" class="btn green" name="submit" value="Submit"/>
									</div>
								</form>
							</div>
							<div class="tab-pane" id="tab_3-3">
							   <form class="horizontal-form" id="password-change" name="password-change" enctype="multipart/form-data" method="post">
									<div class="form-group">
										<label class="control-label">Old Password</label>
										<input type="password" id="old_password" name="old_password" class="form-control" > </div>
									<div class="form-group">
										<label class="control-label">New Password</label>
										<input type="password" id="new_password" name="new_password" class="form-control" maxlength="25" minlength="6"> </div>
									<div class="form-group">
										<label class="control-label">Re-type New Password</label>
										<input type="password" id="password" equalto="#new_password" name="password" class="form-control" maxlength="25"> </div>
									<div class="margin-top-10">
										<input type="submit" name="submit" value="Change Password" class="btn green"/>
									</div>
								</form>
							</div>                                               
						</div>
					</div>
					<!--end col-md-9-->
				</div>
			</div>
			<!--end tab-pane-->                                                              
		</div>
	</div>
</div>
<!-- END PAGE BASE CONTENT -->
               
            
										
<script>
$(function(){
	$('#menuprofile').addClass('active');
});


var vRulesP = {
	old_password:{required:true},
	password:{required:true},
	new_password:{required:true}
};
var vMessagesP = {
	old_password:{required:"Please enter old password"},
	password:{required:"Please enter confirm password", minlength: "Confirm password should be at least 6 characters long",maxlength: "Confirm password should be at least 25 characters long"},
	new_password:{required:"Please enter new password",}
};

jQuery(document).ready(function(){
jQuery("#password-change").validate({
	rules: vRulesP,
	messages: vMessagesP,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/home/changepassword', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{					
					window.location.href="<?php echo SITE_ROOT;?>/home/changpwd";
				}
				else
				{						
					displayMsg("error",res['msg']);
					return false;
				}
				$("#loading").css('display','none');
			}
		});
	}
});



var vRules = {
	first_name:{required:true},
	last_name:{required:true},
	username:{required:true},
	email:{required:true, email: true},
	mobile_no:{required:true, number: true,  minlength: 10, maxlength: 10}	
};
var vMessages = {
	first_name:{required:"Please enter first name",minlength: "First name should be at least 2 characters long"},
	last_name:{required:"Please enter last name",minlength: "Last name should be at least 2 characters long"},
	username:{required:"Please enter user name"},
	email:{required:"Please enter email id"},
	mobile_no:{required:"Please enter mobile number", minlength: "Phone number should be at least 10 characters long",maxlength: "Phone number should be at least 10 characters long"}	
};

$("#form-validate").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/home/proupdate', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{	
					window.location.href="<?php echo SITE_ROOT;?>/home/changpwd";
				}
				else
				{	displayMsg("error",res['msg']);
					return false;
				}
				$("#loading").css('display','none');
			}
		});
	}
});

var vRulesphoto = {
	admin_thumbnail:{required:true}
};
var vMessagesphoto = {
	admin_thumbnail:{required:"Please upload thumbnail image"}
};

$("#form-thumbnail").validate({
	rules: vRulesphoto,
	messages: vMessagesphoto,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/home/addEdit', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{	window.location.href="<?php echo SITE_ROOT;?>/home/changpwd";
				}
				else
				{	displayMsg("error",res['msg']);
					return false;
				}
				$("#loading").css('display','none');
			}
		});
	}
});
});
</script>										