<?php
$db = new Db();
$result= array();
$access2 = new PrivilegedUser();
if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
{
	$table = "admin_member";
	$table_id = 'id';
	$condition = "" ;
	$main_table = array("$table i",array("i.*"));
	$join_tables = array(
		array('left','user_role r1','r1.id = i.user_role', array('r1.role_name as adminrole')),
		array('left','samaj_city r2','r2.id = i.admin_city', array('r2.name as admincity'))
	);
	if($condition=="")
		$condition = " 1=1 && i.id= '".$_REQUEST['id']."' ";
	$rs = $db->JoinFetch($main_table, $join_tables, $condition);									
	$result = mysql_fetch_object($rs);
}
?>
<div class="page-head">
	<div class="page-title">
		<h1>Add user</h1>
	</div>	
	<div class="page-title" style="float: left; clear: both;">		
		<h1>
			<span class="badge badge-success"> 1 </span>Basic Info<?php $result->admin_status;?>
		</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered" style="float:left;width:100%;padding:10px">	
			<form enctype="multipart/form-data" method="post" name="signup-form" id="signup-form" action='' novalidate  style="width:100%;">
			  <div class="fusion-image-wrapper" >
				<div id="displayMsg1" style="position:relative;" class="alert alert-danger display-hide">
					<button class="close" data-close="alert"></button>
					<span> Enter any username and password. </span>
				</div>
				 <div class="form-group col-md-6 col-xs-12">
					<label for="first_name" class="control-label">First Name<b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" id="first_name" name="first_name" value="<?php if(isset($result->first_name) && $result->first_name != ''){ echo $result->first_name; }?>" minlength=2 maxlength=30 />
					<input type="hidden" name="id" id="id" value="<?php if(isset($result->id) && $result->id != ''){ echo $result->id; } ?>">
				 </div>
				 <div class="form-group col-md-6 col-xs-12">
					<label for="last_name" class="control-label">Last Name<b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" id="last_name" name="last_name" maxlength="30" value="<?php if(isset($result->last_name) && $result->last_name != ''){ echo $result->last_name; }?>" />
				 </div>
				 <div style="clear:both;float:left;width:100%"></div>
				 <div class="form-group col-md-6 col-xs-12">
					<label for="username" class="control-label">User name<b style="color:red;margin-left:5px">*</b></label>
					<input class="form-control" type="text" id="username" name="username" value="<?php if(isset($result->username) && $result->username != ''){ echo $result->username; }?>" />
				 </div>
				 <div class="form-group col-md-6 col-xs-12">
					<label for="email" class="control-label">Email-Id<b style="color:red;margin-left:5px">*</b></label>
					<input class="form-control" type="email" id="email" name="email" value="<?php if(isset($result->email) && $result->email != ''){ echo $result->email; }?>" />
				 </div>
				 <div style="clear:both;float:left;width:100%"></div>
				 <div class="form-group col-md-6 col-xs-12">
					<label for="phonenumber" class="control-label">Phone Number<b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" name="mobile_no" maxlength="10" id="mobile_no" value="<?php if(isset($result->mobile_no) && $result->mobile_no != ''){ echo $result->mobile_no; }?>"/>
				 </div>
				 <div class="form-group col-md-6 col-xs-12">
					<label for="password" class="control-label">Password<b style="color:red;margin-left:5px">*</b></label>
					<input class="form-control" type="password" id="password" name="password" maxlength="25" />
				 </div>
				 <div style="clear:both;float:left;width:100%"></div>
				<div class="form-group col-md-6 col-xs-12">
					<label for="user_role" class="control-label">User Role<b style="color:red;margin-left:5px">*</b></label>
					<select class="form-control" name="user_role" id="user_role">
						<option value="">Select</option>
						<?php 
							$selectd= "";
							if(isset($result->user_role) && $result->user_role != '')
							{ $selectd = $result->user_role; }
							echo $db->CreateOptions("html", "user_role", array("id","role_name"),$selectd);
						?>
					</select>
				 </div>
				 <div class="form-group col-md-6 col-xs-12 cityid">
					<label for="admin_city" class="control-label">Samaj City<b style="color:red;margin-left:5px">*</b></label>
					<select class="form-control" name="admin_city" id="admin_city">
						<option value="">Select</option>
						<?php 
						if(isset($result->admin_city) && $result->admin_city != '')
							{ $selectd = $result->admin_city; }
							echo $db->CreateOptions("html", "samaj_city", array("id","name"),$selectd);
						?>
					</select>
				 </div>
				 <div style="clear:both;float:left;width:100%" class="cityid"></div>
				 <div class="form-group col-md-6 col-xs-12">
					  <label class="control-label">Status<b style="color:red;margin-left:5px">*</b></label>
					  <select class="form-control" id="status" name="status">
					  <option value="">Select</option>
						<?php 
							$selected = "";
							if(isset($result->status) && $result->status != "")
							{
								$selected = $result->status;
							}
							echo $db->CreateOptions("html", "lov", array("id","value"),$selected,"","type='status'");
						?>						
					  </select>
				 </div>
				 </div>
		 <div style="clear:both;float:left;width:100%"></div>
		 <div style="clear:both;float:left;width:100%;height:30px;"></div>
         <div class="button-container">
				
				<?php
			if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
			{
				if ($access2->hasPrivilege("EditAdmin"))
				{ 	
					?>
					<div class="col-md-12 col-xs-12">
						<input type="submit" class="btn green" name="submit" value="UPDATE" id="signup" style="margin-right: 2%;"/> 
					</div>
					<?php
				}
			}
			else
			{
				if ($access2->hasPrivilege("AddAdmin"))
				{
					?>
					<div class="col-md-12 col-xs-12">
						<input type="submit" class="btn green" name="submit" value="SUBMIT" id="signup" style="margin-right: 2%;"/> 
					</div>
					<?php
				}
			}
			?>
         </div>
		 </div>
      </form>
	</div>
	</div>
</div>

<script>

jQuery(document).ready(function($) {
	
		$("#home").addClass("active");
		
		$('#user_role').change(function(){
			if($(this).val() == 4 || $(this).val() == 5)
				$('.cityid').show();
			else
				$('.cityid').hide();
		});
		$('#user_role').change();
  });

</script>
<script>

$(document).ready(function(){
	$("#manageadmin").addClass("active");
	var vRulesL = {
				first_name:{required:true, number: false},
				last_name:{required:true, number: false},
				username:{required:true, number: false},
				email:{required:true,email: true},
				newpassword:{required:true, minlength: 5},
				mobile_no:{required:true, number: true,  minlength: 10,maxlength: 10},
				password:{required:true},
				user_role:{required:true},
				status:{required:true},
				admin_city:{required: function(element){
					if($("#user_role").val() == 4 || $("#user_role").val() == 5)
					return true;
					else
					return false;
				}}
			};

			var vMessagesL = {
				first_name:{required:"Please enter first name",number: "First name should be a string",minlength: "Your first name should be at least 2 characters long"},
				last_name:{required:"Please enter last name",number: "Last name should be a string",minlength: "Your last name should be at least 2 characters long"},
				user_name:{required:"Please enter usrname name",number: "Last name should be a string",minlength: "Your last name should be at least 2 characters long"},
				email:{required:"Please enter email-id"},
				mobile_no:{required:"Please enter phone number",number: "Phone number should be in digit",minlength: "Phone number should be at least 10 characters long",maxlength: "Phone number should be at least 10 characters long"},
				password:{required:"Please enter password"},
				user_role:{required:"Please select user role"},
				status:{required:"Please select user role"},
				admin_city:{required:"Please select samaj city"}
			};

			

	$("#signup-form").validate({
		rules: vRulesL,
		messages: vMessagesL,
		submitHandler: function(form1) {		
			$(form1).ajaxSubmit({
				url: '<?= SITE_ROOT; ?>/manageadmin/addnewadmin', 
				type: 'post',
				cache: false,
				enctype:"multipart/form-data",
				success: function (response) {					
					var res = eval('('+response+')');
					if(res['msg'] == "success")
					{	
						$('#displayMsg1').hide();	
						location.href = "<?= SITE_ROOT; ?>/manageadmin/";
					}
					else
					{		
						$('#displayMsg1').show();				
						$('#displayMsg1 span').html(res['msg']);
						window.setTimeout(function() { $('#displayMsg1').hide(); }, 5000);
						$("html,body").scrollTop(0);
						return false;
					}
					$("#loading").css('display','none');
				}
			});
		}
	});

}); 

</script>