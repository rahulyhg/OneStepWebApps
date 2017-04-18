<?php
$result= array();
$base_image_path = "";
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$access2 = new PrivilegedUser();
if (!($access2->hasPrivilege("EditPermission") || $access2->hasPrivilege("AddPermission")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}

$db = new Db();
if(isset($_REQUEST['id']))
{
	$user_id = $_REQUEST['id'];
	$ref_id=$_REQUEST['id'];
	$rs = $db->FetchRow("permission","id",$user_id);
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
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1>Add Permission
		</h1>
	</div>	
	<div class="page-title" style="float: left; clear: both;">		
		<h1>
		<span class="badge badge-success"> 1 </span>Basic Info
		</h1>
	</div>
	<!-- END PAGE TITLE -->
</div>                 
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered" style="padding: 3% 0px 0px;float:left;width:100%;">	
			<div class="form-group col-md-6 col-xs-12">
					<label class="control-label">Permission Name<b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" id="perm_desc" name="perm_desc" value="<?php if(isset($result['perm_desc']))echo $result['perm_desc'];?>" placeholder="Enter permission" minlength="2" maxlength="50">								
			</div>
			
			<?php
			if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
			{
				if ($access2->hasPrivilege("EditPermission"))
				{
					?>
					<div class="form-group col-md-6 col-xs-12" style="margin-bottom: 0px; margin-top: 15px;">
						<div class="margin-top-10 margin-bottom-10" style="float:left;width:100%;">
							<input type="submit" class="btn green" name="submit" value="UPDATE" style="float: left; margin: 0px 3%;"/>    
						</div>
					</div>
					<?php
				}
			}
			else
			{
				if ($access2->hasPrivilege("AddPermission"))
				{
					?>
				<div class="form-group col-md-6 col-xs-12" style="margin-bottom: 0px; margin-top: 15px;">
					<div class="margin-top-10 margin-bottom-10" style="float:left;width:100%;">
						<input type="submit" class="btn green" name="submit" value="SUBMIT" style="float: left; margin: 0px 3%;"/>    
					</div>
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
	perm_desc:{required:true, minlength:2,maxlength:50},
	/*adv_thumbnail:{<?php if(isset($base_image_path) && $base_image_path != ""){ echo 'required:false';} else { echo 'required:true';}?>}	*/
};
var vMessages = {
	perm_desc:{required:"Please enter permission",minlength:"Minimum lenght 2 characters",maxlength:"Maximun lenght 50 characters"},
	/*adv_thumbnail:{required:"Please upload images"}	*/
};

$("#form-validate").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/permission/addeditpermission', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{	
					window.location.href="<?php echo SITE_ROOT;?>/permission";
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