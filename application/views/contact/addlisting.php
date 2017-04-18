<?php
$result= array();
$base_image_path = "";
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$access2 = new PrivilegedUser();
if (!($access2->hasPrivilege("EditLocation") || $access2->hasPrivilege("AddLocation")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
$db = new Db();
if(isset($_REQUEST['id']))
{
	$user_id = $_REQUEST['id'];
	$ref_id=$_REQUEST['id'];
	
	$rs = $db->FetchRow("contact_location","id",$user_id);
	if($rs != null )
	{
		$result = mysql_fetch_array($rs);	
		
	}
}
?>
<style>
tr.odd{background-color:#fff!important;}
tr.even{background-color:#e5eff5!important;}
.odd td{border-color:#e7e7e7!important;}
.even td{border-color:#e7e7e7!important;}
#mytable_wrapper{border: 1px solid #e7e7e7;border-top: 0px;}
</style>
<form id="form-validate" name="form-validate" enctype="multipart/form-data" method="post">  
<div class="page-head">
	<div class="page-title">
		<h1>Add Location
		</h1>
	</div>	
	<div class="page-title" style="float: left; clear: both;">		
		<h1>
		<span class="badge badge-success"> 1 </span>Basic Info
		</h1>
	</div>
</div>                 
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered" style="padding: 3% 0px 0px;float:left;width:100%;">	
			<div class="form-group col-md-6 col-xs-12">
					  <label class="control-label">Location Name<?php echo $result['event_samaj_city'];?><b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" id="name" name="name" value="<?php if(isset($result['name']))echo $result['name'];?>" placeholder="Name" minlength="2" maxlength="30">
					<input class="span2" id="id" name="id" type="hidden" value="<?php if(isset($result['id']))echo $result['id'];?>"/>
			</div>
			<div class="form-group col-md-6 col-xs-12">
					<label class="control-label">Contact No<b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" id="contact" name="contact" value="<?php if(isset($result['contact']))echo $result['contact'];?>" placeholder="enter mobile no" minlength="10" maxlength="10">								
			</div>
			<div class="form-group col-md-6 col-xs-12">
					<label class="control-label">Latitude<b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" id="latitude" name="latitude" value="<?php if(isset($result['latitude']))echo $result['latitude'];?>" placeholder="enter latitude" minlength="9" maxlength="9">
					<input class="span2" id="id" name="id" type="hidden" value="<?php if(isset($result['id']))echo $result['id'];?>"/>								
			</div>
            <div class="form-group col-md-6 col-xs-12">
					<label class="control-label">Longitude<b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" id="longitude" name="longitude" value="<?php if(isset($result['longitude']))echo $result['longitude'];?>" placeholder="enter longitude" minlength="9" maxlength="9">
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group col-md-6 col-xs-12">
					  <label class="control-label">Status<b style="color:red;margin-left:5px">*</b></label>
					  <select class="form-control" id="status" name="status">
					  <option value="">Select</option>
						<?php 
							$selected = "";
							if(isset($result['status']) && $result['status'] != "")
							{
								$selected = $result['status'];
							}
							echo $db->CreateOptions("html", "lov", array("id","value"),$selected,"","type='status'");
						?>							
					  </select>
					</div>
					<div class="form-group col-md-6 col-xs-12">
					  <label class="control-label">Address<b style="color:red;margin-left:5px">*</b></label>
					  <textarea class="form-control" id="address" name="address" rows="3" placeholder="enter address" minlength="2" maxlength="60"><?php if(isset($result['address']))echo $result['address'];?></textarea>
					</div>
				</div>
			</div>
			
			<?php
			if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
			{
				if (!$access2->hasPrivilege("EditLocation"))
				{ 	
					Core::PageRedirect(SITE_ROOT_DASHBOARD);
				}
				else
				{
					?>
					<div class="margin-top-10 margin-bottom-10" style="float:left;width:100%;">
						<input type="submit" class="btn green" name="submit" value="UPDATE" style="float: right; margin: 0px 3%;"/>    
					</div>

					<?php
				}
			}
			else
			{
				if (!$access2->hasPrivilege("AddLocation"))
				{ 	
					Core::PageRedirect(SITE_ROOT_DASHBOARD);
				}
				else
				{
					?>
					<div class="margin-top-10 margin-bottom-10" style="float:left;width:100%;">
						<input type="submit" class="btn green" name="submit" value="SUBMIT" style="float: right; margin: 0px 3%;"/>    
					</div>

					<?php
				}
			}
			?>
		</div>
	</div>
</div>
</form>
<script>
$(function(){
	$('#menucontact').addClass('active');
});
var vRules = {
	name:{required:true},
	contact:{required:true, number: true,  minlength: 10,maxlength: 10},
	latitude:{required:true},
	longitude:{required:true},
	status:{required:true},
	address:{required:true}
};
var vMessages = {
	contact:{required:"Please enter phone number",number: "Phone number should be in digit",minlength: "Phone number should be at least 10 characters long",maxlength: "Phone number should be at least 10 characters long"},
	name:{required:"Please enter name"},
	latitude:{required:"Please enter latitude"},
	longitude:{required:"Please enter longitude"},
	status:{required:"Please select status"},	
	address:{required:"Please enter address"}
};

$("#form-validate").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/contact/addcontact', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{	
					window.location.href="<?php echo SITE_ROOT;?>/contact";
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
</script>