<?php
$access2= new  PrivilegedUser();
if (!($access2->hasPrivilege("EditRole") || $access2->hasPrivilege("AddRole")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
$result= array();
$act = "add";
$heading = "Add Role";
$url_prams = array();

if(isset($_REQUEST['id']))
{
	$role_id = $_REQUEST['id'];

	$rs = $db->FetchRow("user_role","id",$role_id);
	if($rs != null )
	{
		$heading = "Update Role";
		$result = mysql_fetch_array($rs);
		$act = "edit";
	}
}
?>
<style>
.width25
{
	float:left;width:23%;padding:1%;
}

</style>
<form id="form-validate" name="form-validate" enctype="multipart/form-data" method="post">  
<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1>Add Role
		</h1>
	</div>	
	<div class="page-title" style="float: left; clear: both;">		
		<h1>
		<span class="badge badge-success"> 1 </span>Add Role
		</h1>
	</div>
	<!-- END PAGE TITLE -->
</div>                 
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered" style="float: left; width: 100%;">	
			<div class="form-group col-md-4 col-xs-12">
					<label class="control-label" for="role_name">Role Name<b style="color:red;margin-left:5px">*</b></label> 
					<input class="form-control" id="role_name" name="role_name" type="text" value="<?php if(isset($result['role_name']))echo $result['role_name'];?>" />
					<input class="span9" id="role_id" name="role_id" type="hidden" value="<?php if(isset($result['id']))echo $result['id'];?>" />
<!--<span class="FontSize-11">Product code must be unique for each product</span>-->								
			</div>
		</div>
	</div>
</div>
<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title" style="float: left; clear: both;">		
		<h1>
		<span class="badge badge-success"> 2 </span>Select Permissions
		</h1>
	</div>
	<!-- END PAGE TITLE -->
</div>  
<div class="row">
	<div class="col-md-12 col-xs-12">
		<div class="portlet light bordered" style="padding: 3% 0px 0px;float:left;width:100%;">
			<div class="form-group col-md-12 col-xs-12" style="margin-left: 1.5%;">
			<?php
			$selectedCheckArray = array();
			$rsSelect = $db->Fetch("permissions",array("perm_id","perm_desc"),"1=1",array("perm_id"=>"asc"));
			if(isset($role_id) && $role_id != "")
			{
				$selectedCheck = $db->Fetch("role_perm", array("perm_id"), "role_id = '".$role_id."'");
				while($selectedCheckRow = mysql_fetch_array($selectedCheck))
				{
					$selectedCheckArray[]=$selectedCheckRow['perm_id'];
				}
			}
			while($resultSelect = mysql_fetch_object($rsSelect))
			{?> 
				<span id="width25" class="chkall col-md-3 col-xs-6" style="margin: 5px 0px;"> 
					<input <?php if(in_array($resultSelect->perm_id,$selectedCheckArray)){ echo "checked=checked";} ?> class="chk" type="checkbox" id="<?php echo $resultSelect->perm_id;?>"	name="perm_id[]" value="<?php echo $resultSelect->perm_id;?>" />
					<?php echo $resultSelect->perm_desc;?>
<!--				<input type="hidden" name="role_id_hidden[]" value="<?php echo $resultSelect->perm_id;?>"/>-->
				</span> <?php
}
?>
			
			</div>
			
			<?php
			if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
			{
				if (!$access2->hasPrivilege("EditRole"))
				{ 	
					Core::PageRedirect(SITE_ROOT_DASHBOARD);
				}
				else
				{
					?>
					<div class="margin-top-10 margin-bottom-10" style="float:left;width:100%;">
						<input type="submit" class="btn green" name="submit" value="UPDATE ROLE" style="float: right; margin:0% 1%;"/> 
						<button id="chkAll" class="btn green"  style="float: right!important; margin:0% 1%;" type="button" onclick="checkUncheck(this)">Check All</button>
					</div>
					<?php
				}
			}
			else
			{
				if (!$access2->hasPrivilege("AddRole"))
				{ 	
					Core::PageRedirect(SITE_ROOT_DASHBOARD);
				}
				else
				{
					?>
				<div class="margin-top-10 margin-bottom-10" style="float:left;width:100%;">
					<input type="submit" class="btn green" name="submit" value="ADD ROLE" style="float: right; margin:0% 1%;"/> 
					<button id="chkAll" class="btn green"  style="float: right!important; margin:0% 1%;" type="button" onclick="checkUncheck(this)">Check All</button>
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

var vRules = {
	role_name:{required:true}
};
var vMessages = {
	role_name:{required:"Please enter role name"}
};

$("#form-validate").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) 
	{
		act = '<?=SITE_ROOT."/roles/addEdit"; ?>';
		$(form).ajaxSubmit({
			url: act, 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{
					window.location.href="<?php echo SITE_ROOT;?>/roles";
				}
				else
				{	
					$("#error_msg").css("display","block");
					$("#error_msg_div").html(res['msg']);
					return false;
				}
			}
		});
	}
});
function checkUncheck(obj)
{
    if($(obj).text() == "Check All")
    {
		$(".chkall").each(function(){
			$(this).find("span").addClass("checked");
			$(this).find("input").attr("checked","checked");
		});
		$(".both").each(function(){
			$(this).find("span").addClass("checked");
			$(this).find("input").attr("checked","checked");
		});
        $(obj).text("Uncheck All");
    }
    else
    {
    	$(".chkall").each(function(){
			$(this).find("span").removeClass("checked");
			$(this).find("input").removeAttr("checked");
		});
		$(".both").each(function(){
			$(this).find("span").removeClass("checked");
			$(this).find("input").removeAttr("checked");
		});
    	$(obj).text("Check All");
    }
}
</script>
