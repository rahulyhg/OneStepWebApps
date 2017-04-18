<style>
label.error{
	display:none!important;
}
</style>
<?php
$db = new Db();
$table88 = "users";
$condition88 = "i.id = ".$_SESSION['samajadmin']['id'];
$main_table88 = array("$table88 i",array("i.*"));
$join_tables88 = array(
/*array('left',' client r','r.id = i.Client_id', array('r.name as client_name'))*/
);
$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
$result = mysql_fetch_array($rs1);
$label = "Edit";
$button = "Update";
?>
<style>
.picker__weekday-display{
	background:#4285F4!important;
}
.collection-header{
	padding:10px !important; 
}
</style>
<!-- 
<div class="col s12 m12">
	<div class="col s6 m6">
		<ul id="task-card" class="collection with-header" style="margin-bottom: 0px; border: 0px none;">
			<li class="collection-header" style="background:#4285F4;">
				<!--<a href="<?php echo SITE_ROOT."/home/projects?project_id=".$_REQUEST['project_id'];?>"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content white strong" style="color:#4285F4;">Add New Note</span></h6></a>
				<h4 class="task-card-title" style="font-size:1.5rem;"><?php echo $label; ?> My Profile</h4>
				<a data-delay="50" data-tooltip="Back To Home" class="btn-floating tooltipped white" style="float: right; position: absolute; top: 4px; right: 5px;" href="<?php echo SITE_ROOT."/home"; ?>">
					<i style="color:#4285f4;" class="mdi-content-clear"></i>
				</a>
			</li>
		</ul>
	</div>
</div> -->
<div class="card-panel" style="margin-top: 0px;">
	<div id="input-fields">
		<div class="row">
			<div class="col s12 m12 l12">
				<div class="row">
					<form class="col s12" name="myprofile" id="myprofile">
						<div class="row">
							<div class="input-field col s6">
								<!-- <input type="date" value="<?php if(isset($result['Date']))echo $result['Date'];?>" id="Date" name="Date" placeholder="Date * " class="datepicker"> -->
								<input class="" type="text" id="first_name" name="first_name" value="<?php if(isset($result['first_name']))echo $result['first_name'];?>" minlength=2 maxlength=30 />
								<input type="hidden" id="id" name="id" value="<?php echo $_SESSION['samajadmin']['id']; ?>">  
								<label for="Date active">First Name</label>
							</div>
							<div class="input-field col s6">
								<input class=""  type="text" id="last_name" name="last_name" value="<?php if(isset($result['last_name']))echo $result['last_name'];?>" minlength=2 maxlength="30" />
								<label for="client_name">Last Name</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<input class=""  type="email" id="email" name="email" value="<?php if(isset($result['email']))echo $result['email'];?>" readonly />
								<label for="phonenumber">Email</label>
							</div>
							<div class="input-field col s6">
								<input class=""  type="text" name="phonenumber" maxlength="10" value="<?php if(isset($result['phonenumber']))echo $result['phonenumber'];?>" id="phonenumber"/>
								<label for="alt_phone">Phone Number</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<select class="" name="gender" id="gender">
									<option value="1" <?php if ($rows['gender'] == '1') echo 'selected="selected"'?> >Male</option>
									<option value="2" <?php if ($rows['gender'] == '2') echo 'selected="selected"'?> >Female</option>
								</select>
								<label for="gender">Gender</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input id="address" name="address" value="<?php if(isset($result['address']))echo $result['address'];?>" type="text" class="validate" style="border-width: 0px 0px 1px; border-bottom: 1px solid rgb(158, 158, 158);">
								<label for="Address">Address</label>
							</div>
						</div>
							
						<div class="row">
							<div class="input-field col s6">
								<input class="" placeholder="city" type="text" id="city" name="city" value="<?php if(isset($result['city']))echo $result['city'];?>"/>
								<label for="city">City</label>
							</div>
							<div class="input-field col s6">
								<input class="" placeholder="State" type="text" id="state" name="state" value="<?php if(isset($result['state']))echo $result['state'];?>"/>
								<label for="state">State</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
									<input type="text" tabindex="6" value="<?php if(isset($result['postalcode']))echo $result['postalcode'];?>" autocomplete="off" id="postalcode" name="postalcode" class="validate">
									<label for="postalcode">Postal Code</label>
							</div>
							<div class="input-field col s6">
								<input class="" placeholder="country" type="text" id="country" name="country" value="<?php if(isset($result['country']))echo $result['country'];?>"/>
								<label for="country">Country</label>
							</div>
							
						</div>
						<div class="row">
							
						</div>
						<div class="row">
							<div class="input-field col s12" style="text-align:center;">
								<input class="z-depth-1 waves-effect btn secondary-content strong" type="submit" id="submit" name="submit" value="<?php echo $button; ?>" style="background:#4285F4;display:inline-block;float:none;">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
/*
var ignore = false;
$(function () {
    $(window).bind('beforeunload', function () {
        if (!ignore) {
            return 'WARNING: Data you have entered may not be saved.';
        }
    });

    $('.ignorepostback').live('click',function () {
        ignore = true;
    });
});
*/
$(function(){
var vRules = {
	client_name:{required:true, number: false, minlength: 2},
	email:{required:true,email: true},
	phonenumber:{required:true, number: true,  minlength: 10,maxlength: 10},
	Date:{required:true},
	address:{required:true},
	city:{required:true},
	state:{required:true},
	country:{required:true},
	postalcode:{required:true,maxlength: 10}
};
var vMessages = {
	email:{required:"Please enter email-id"},
	phonenumber:{required:"Please enter mobile number",number: "Mobile number should be in digit",minlength: "Mobile number should be at least 10 characters long",maxlength: "Phone number should be at least 10 characters long"},
	Date:{required:"Please enter date"},
	city:{required:"Please select city"},
	State:{required:"Please select state"},
	country:{required:"Please select country"},
	postalcode:{required:"Please enter postal code",maxlength: "Postal code should be at least 10 characters long"},
	address:{required:"Please enter address"}
};

$("#myprofile").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {	
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?= SITE_ROOT; ?>/users/updatemyprofile', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['success'])
				{	
					swal({   title: "Do you want to continue?",   
						 text: "You have updated your Profile. Do you want to proceed to the Home?",   
						 type: "warning",   
						 showCancelButton: true,   
						 confirmButtonColor: "#DD6B55",   
						 confirmButtonText: "Yes",   
						 cancelButtonText: "No",   
						 closeOnConfirm: false,   
						 closeOnCancel: false }, 
						 function(isConfirm){   
							 if (!isConfirm) {     
								 location.href = "<?= SITE_ROOT; ?>/users/myprofile/";  } 
							 else {
								 location.href = "<?= SITE_ROOT; ?>/home";  } 
						});
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
$('#birth_date').pickadate({
	formatSubmit: 'yyyy/mm/dd',
	closeOnSelect:true,
	onSet:function(context){console.log("Click");}
});
});
$(function(){
		$("#headingSearchtitle").html("Edit My Profile");
 $('.picker__day').click(function(){$('.picker__close').click();});
});
</script>