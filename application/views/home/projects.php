<style>
label.error{
	display:none!important;
}
</style>
<?php
$db = new Db();
$table88 = "projects";
$sort = 'i.id';
$order = 'desc';
$condition88 = "i.id = ".$_REQUEST['id']." && i.created_by = ".$_SESSION['samajadmin']['id'];
$main_table88 = array("$table88 i",array("i.*"));
$join_tables88 = array(
array('left',' client r','r.id = i.Client_id', array('r.name as client_name'))
);
$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
$result = mysql_fetch_array($rs1);
?>
<?php 
$label = "Add";
$button = "Create";
if(isset($_REQUEST['id'])){
	$label = "Edit";
	$button = "Update";
} ?>
<style>
.picker__weekday-display{
	background:#4285F4!important;
}
</style>
<div class="col s12 m12">
	<div class="col s6 m6">
		<ul id="task-card" class="collection with-header" style="margin-bottom: 0px; border: 0px none;">
			<li class="collection-header" style="background:transparent;padding:0;">
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 400px);">
				<!--<a href="<?php echo SITE_ROOT."/home/projects?project_id=".$_REQUEST['project_id'];?>"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content white strong" style="color:#4285F4;">Add New Note</span></h6></a>-->
				<a data-delay="50" data-tooltip="Back To Home" class="btn-floating tooltipped white" style="float: right;" href="<?php echo SITE_ROOT."/home"; ?>">
					<i style="color:#4285f4;" class="mdi-content-clear"></i>
				</a>
			</div>
			</li>
		</ul>
	</div>
</div>
<div class="card-panel" style="margin-top: 0px;">
	<div id="input-fields">
		<div class="row">
			<div class="col s12 m12 l12">
				<div class="row">
					<form class="col s12" name="add_project" id="add_project">
						<div class="row">
							<div class="input-field col s6">
								<input type="text" tabindex="2" value="<?php if(isset($result['project_name']))echo $result['project_name'];?>" autocomplete="off" id="project_name" name="project_name" class="validate">
								<label for="project_name">Project Name * </label>
							</div>
							<div class="input-field col s6">
								<input type="text" tabindex="5" value="<?php if(isset($result['email']))echo $result['email'];?>" autocomplete="off" id="email" name="email" class="validate" >
								<label for="email">Email * </label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<input type="date" value="<?php if(isset($result['Date']))echo $result['Date'];?>" id="Date" name="Date" placeholder="Date * ">
								<input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id']; ?>">  
								<!-- <label for="Date active">Date</label> -->
							</div>
							<div class="input-field col s6">
								<input type="text" tabindex="2" value="<?php if(isset($result['client_name']))echo $result['client_name'];?>" autocomplete="off" id="client_name" name="client_name" class="validate">
								<label for="client_name">Client Name * </label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<input type="text" tabindex="3" value="<?php if(isset($result['phonenumber']))echo $result['phonenumber'];?>" autocomplete="off" id="phonenumber" name="phonenumber" class="validate" maxlength=10 minlength=10 >
								<label for="phonenumber">Primary Phone Number * </label>
							</div>
							<div class="input-field col s6">
								<input type="text" tabindex="4" value="<?php if(isset($result['alt_phone']))echo $result['alt_phone'];?>" autocomplete="off" id="alt_phone" name="alt_phone" class="validate" maxlength=10 minlength=10>
								<label for="alt_phone">Alternate Phone Number</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input id="Address" name="Address" value="<?php if(isset($result['Address']))echo $result['Address'];?>" type="text" class="validate" style="border-width: 0px 0px 1px; border-bottom: 1px solid rgb(158, 158, 158);">
								<label for="Address">Address</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<input type="text" value="<?php if(isset($result['City'])){echo $result['City'];}?>" autocomplete="off" id="City" name="City" class="validate">
								<label for="City">City * </label>
							</div>
							<div class="input-field col s6">
								<input type="text" value="<?php if(isset($result['State'])){echo $result['State'];}?>" autocomplete="off" id="State" name="State" class="validate">
								<label for="State">State * </label>
							</div>
							
						</div>
						<div class="row">
							<div class="input-field col s6">
								<input type="text" tabindex="6" value="<?php if(isset($result['Zip']))echo $result['Zip'];?>" autocomplete="off" id="Zip" name="Zip" class="validate">
								<label for="Zip">ZipCode * </label>
							</div>
							<div class="input-field col s6">
								<input type="text" value="<?php if(isset($result['country'])){echo $result['country'];}else{echo 'United States';}?>" autocomplete="off" id="country" name="country" class="validate">
								<label for="country">Country * </label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<input type="text" tabindex="2" value="<?php if(isset($result['prepared_by'])){echo $result['prepared_by'];}else{echo $_SESSION['samajadmin']['first_name']." ".$_SESSION['samajadmin']['last_name'];}?>" autocomplete="off" id="prepared_by" name="prepared_by" class="validate">
								<label for="prepared_by">Prepared By * </label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12" style="text-align:center">
								<input class="z-depth-1 waves-effect btn secondary-content strong" type="submit" id="submit" name="submit" value="<?php echo $button; ?>" style="background:#4285F4; display:inline-block; float:none;">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	
var vRules = {
	client_name:{required:true, number: false, minlength: 2},
	project_name:{required:true, minlength: 2},
	email:{required:true,email: true},
	phonenumber:{required:true, number: true,  minlength: 10,maxlength: 10},
	alt_phone:{number: true},
	Date:{required:true},
	Address:{required:true},
	City:{required:true},
	State:{required:true},
	country:{required:true},
	Zip:{required:true,maxlength: 10}
};
var vMessages = {
	client_name:{required:"Please enter client name",number: "Client name should be a string",minlength: "Client name should be at least 2 characters long"},
	project_name:{required:"Please enter Project name",minlength: "Project name should be at least 2 characters long"},
	email:{required:"Please enter email-id"},
	phonenumber:{required:"Please enter mobile number",number: "Mobile number should be in digit",minlength: "Mobile number should be at least 10 characters long",maxlength: "Phone number should be at least 10 characters long"},
	alt_phone:{number: "Mobile number should be in digit"},
	Date:{required:"Please enter date"},
	City:{required:"Please select city"},
	State:{required:"Please select state"},
	country:{required:"Please select country"},
	Zip:{required:"Please enter postal code",maxlength: "Postal code should be at least 10 characters long"},
	Address:{required:"Please enter address"}
};

$("#add_project").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {	
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?= SITE_ROOT; ?>/home/addnewproject', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['success'])
				{	
					swal({   title: "",   
						 text: "You have successfully created a project. Do you want to proceed to the internal & external dashboard?",   
						 type: "warning",   
						 showCancelButton: true,   
						 confirmButtonColor: "#DD6B55",   
						 confirmButtonText: "Yes",   
						 cancelButtonText: "No",   
						 closeOnConfirm: false,   
						 closeOnCancel: false }, 
						 function(isConfirm){   
							 if (isConfirm) {     
								 window.location.href="<?php echo SITE_ROOT;?>/project/dashboard?project_id="+res['project_id'];  } 
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

var yesterday = new Date((new Date()).valueOf()-1000*60*60*24);

$('#Date').pickadate({
    closeOnSelect:true,
	selectMonths: true,
    selectYears: 15,
	disable: [
		{ from: [0,0,0], to: yesterday }
	],
	 onStart: function ()
	{
		var date = new Date();
		this.set('select', [date.getFullYear(), date.getMonth(), date.getDate()]);
	}
  });
  
  
  
/*$('#Date').pickadate({
	formatSubmit: 'yyyy/mm/dd',
	closeOnSelect:true,
	onSet:function(context){console.log("Click");}
});*/

});
$(function(){
 $('#projectmenu').addClass('active');
 $('.picker__day').click(function(){$('.picker__close').click();});
 $("#headingSearchtitle").html("Project");
 $("#exteriorli").addClass("active");
   $("#exteriorlidiv").show();
});
</script>