<?php
$db = new Db();
$row = array();
$table = "projects";
$table_id = 'id';

$condition = "" ;

$main_table = array("$table i",array("i.*"));
$join_tables = array(
	array('left',' client r','r.id = i.Client_id', array('r.name as client_name','r.phonenumber as phonenum','r.email as mailid'))
);

$condition = " 1=1 && i.id = ".$_REQUEST['id'] ;

$rs = $db->JoinFetch($main_table, $join_tables, $condition);
$row = mysql_fetch_object($rs);
?>
<style>
.btn:hover, .btn-large:hover{background:#4285F4!important;}
</style>
<div class="col s12 m12">
	<ul id="task-card" class="collection with-header" style="margin-bottom: 0px; border: 0px none;">
		<li class="collection-header" style="background:transparent;padding:0;">
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 500px);">
			</div>
		</li>
	</ul>
</div>
<div class="card-panel" style="margin-top: 0px;">
	<div id="row-grouping" class="section">
		<div class="row">
			<div class="col s12 m12">
				<form method="post" class="" enctype="multipart/form-data" name="signup_form" id="signup_form" action='<?=SITE_ROOT?>/login/loginvalidate'>
					<div class="row">
						<div class="input-field col s12">
							<input class="" placeholder="Name" type="text" id="name" name="name" value="<?php if(isset($row->client_name) && $row->client_name != ""){echo $row->client_name;} ?>" minlength=2 maxlength=30 />
							<label for="name">Client Name</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input class="" placeholder="Email Address" type="email" value="<?php if(isset($row->mailid) && $row->mailid != ""){echo $row->mailid;} ?>" id="email" name="email"/>
							<label for="email">Email</label>
						</div>
						<div class="input-field col s6">
							<input class="" placeholder="Mobile Number" type="text" name="phonenumber" value="<?php if(isset($row->phonenum) && $row->phonenum != ""){echo $row->phonenum;} ?>" maxlength="10" id="phonenumber"/>
							<label for="phonenumber">Mobile Number</label>
						</div>
					 </div>
					 <div class="row">
						<div class="input-field col s12">
							<textarea class="" placeholder="Address" id="address" name="address" rows="2" maxlength="500" style="border-left-width: 0px; border-top-width: 0px; border-right-width: 0px;"><?php if(isset($row->Address) && $row->Address != ""){echo $row->Address;} ?></textarea>
							<label for="address">Address</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input class="" placeholder="City" type="text" name="City" value="<?php if(isset($row->City) && $row->City != ""){echo $row->City;} ?>" id="City"/>
							
							<label for="City">City</label>
						</div>
						<div class="input-field col s6">
							<input class="" placeholder="State" type="text" name="State" value="<?php if(isset($row->State) && $row->State != ""){echo $row->State;} ?>" id="State"/>
							<label for="State">State</label>
						</div>  
					</div> 
					<div class="row">
						<div class="input-field col s6">
							<input class="" placeholder="Zip Code" type="text" name="Zip" value="<?php if(isset($row->Zip) && $row->Zip != ""){echo $row->Zip;} ?>" id="Zip"/>
							<label for="country">Zip Code</label>
						 </div>
						 <div class="input-field col s6">
							<input class="" placeholder="Country" type="text" name="country" value="<?php if(isset($row->country) && $row->country != ""){echo $row->country;} ?>" id="country"/>
							<label for="country">Country</label>
						 </div>
					</div>
					
					<div class="row">
						<div class="input-field col s3" style="float: right;">
							<button type="submit" class="btn waves-effect waves-light col s12">Update</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
var vRulesL = {
	name:{required:true, number: false, minlength: 2},
	email:{required:true,email: true},
	city:{required:true},
	state:{required:true},
	country:{required:true}
};
var vMessagesL = {
	name:{required:"Please enter name",number: "Name should be a string",minlength: "Name should be at least 2 characters long"},
	email:{required:"Please enter email-id"},
	city:{required:"Please select city"},
	state:{required:"Please select state"},
	country:{required:"Please select country"}
};
$("#signup_form").validate({
	rules: vRulesL,
	messages: vMessagesL,
	submitHandler: function(form1) {		
		$(form1).ajaxSubmit({
			url: '<?php echo SITE_ROOT; ?>/project/editclient1?id=<?php echo $_REQUEST['id']; ?>', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			success: function (response) {					
				var res = eval('('+response+')');
				if(res['success'] == 1)
				{	
					swal({   title: "Do you want to continue?",   
						 text: "You have successfully edited an Client. Do you want to proceed to the Listing?",   
						 type: "warning",   
						 showCancelButton: true,   
						 confirmButtonColor: "#DD6B55",   
						 confirmButtonText: "Yes",   
						 cancelButtonText: "No",   
						 closeOnConfirm: false,   
						 closeOnCancel: false }, 
						 function(isConfirm){   
							 if (!isConfirm) {     
								 location.href = "<?= SITE_ROOT; ?>/project/editclient?id="+res['id'];  } 
							 else {
								 location.href = "<?= SITE_ROOT; ?>/project/listclients";  } 
						});
				}
				else
				{		
					return false;
				}
				$("#loading").css('display','none');
			}
		});
	}
});
$(function(){
 $('#clientlist').addClass('active');
 $("#headingSearchtitle").html("Client");
});
</script>
