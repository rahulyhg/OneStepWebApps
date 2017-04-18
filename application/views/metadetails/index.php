<?php
$access2 = new PrivilegedUser();
if (!($access2->hasPrivilege("EditMeta") || $access2->hasPrivilege("AddMeta")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
$heading = "Home";
$idd="";
$displayadd = array();
if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
{
	$id = $_REQUEST['id'];
	$table = "meta_details";
	$condition = " i.id in (".$id.")";
  		
  		$main_table = array("$table i",array("i.*"));
		$join_tables = array(
			array('left','lov r1','r1.id = i.status', array('r1.value as status_val')),
			array('left','lov r2','r2.id = i.display_page_section', array('r2.value as page'))
		);
			
	$rs1 = $db->JoinFetch($main_table, $join_tables, $condition);
	$result = mysql_fetch_array($rs1);
	$idd=$result['id'];
}
$rs11 = $db->Fetch('meta_details','distinct(display_page_section)'," status = '3' ");
while($result1 = mysql_fetch_array($rs11))
{
	if($result1['display_page_section'] != "")
	{
		$displayadd[] = $result1['display_page_section'];
	}
}

?>
<form id="form-validate" name="form-validate" enctype="multipart/form-data" method="post">
<div class="page-head">
	<div class="page-title">
		<h1>Add Metadata
		</h1>
	</div>
</div>    
<div class="row"> 
	<div class="col-md-12">
		<div class="portlet light bordered" style="float: left; width:100%;">		
			<div class="form-group col-md-6 col-xs-12">
				<input type="hidden" name="id" value="<?php if(isset($idd) && $idd != ""){echo $idd;}else{ echo "";}?>">
				<label class="control-label">Select Page<b style="color:red;margin-left:5px">*</b></label>
				<select class="form-control abc" id="display_page_section" name="display_page_section">
				<?php 
					$selected = "";
					if(isset($result['display_page_section']) && $result['display_page_section'] != "")
					{
						$selected = $result['display_page_section'];
						
					}
					if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
					{
						echo $db->CreateOptions("html", "lov", array("id","value"),$selected,"","type='adv_display_page'");
					}
					else
					{
						echo $db->CreateOptions("html", "lov", array("id","value"),$selected,"","type='adv_display_page' AND id not in ('".join('\',\'', $displayadd)."')");
					}
				?>	
				</select>
			</div>
			<div class="form-group col-md-6 col-xs-12">
				<label class="control-label">Page Title<b style="color:red;margin-left:5px">*</b></label>
				<input type="text" class="form-control" id="meta_title" name="meta_title" value="<?php if(isset($result['meta_title']))echo $result['meta_title'];?>" placeholder="Title" minlength="2" maxlength="100">
						
			</div>
			 <div class="form-group col-md-6 col-xs-12">
					<label class="control-label">Description<b style="color:red;margin-left:5px">*</b></label>
					<textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Description" minlength="2" maxlength="100" ><?php if(isset($result['meta_description']))echo $result['meta_description'];?></textarea>                    
			</div>
			 <div class="form-group col-md-6 col-xs-12">
				<label class="control-label">Keywords<b style="color:red;margin-left:5px">*</b></label>
				<textarea class="form-control" id="meta_keyword" name="meta_keyword" rows="3" placeholder='Please saperate keywords by " , " (comma).' minlength="2"><?php if(isset($result['meta_keyword']))echo $result['meta_keyword'];?></textarea> 
			</div>
			<div class="form-group col-md-6 col-xs-12">
					  <label class="control-label">Status<b style="color:red;margin-left:5px">*</b></label>
					  <select class="form-control" id="status" name="status">
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
			<?php
			if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
			{
				if ($access2->hasPrivilege("EditMeta"))
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
				if ($access2->hasPrivilege("AddMeta"))
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

<script>
$(function(){
	$('#menumeta').addClass('active');
});

<?php if(isset($_REQUEST['id']) && $_REQUEST['id'] != ""){ 
?>
$(function(){
$('.abc :not(:selected)').attr('disabled','disabled');
});
<?php
} ?> 

var vRules = {
	meta_title:{required:true,maxlength:100},
	meta_description:{required:true,maxlength:100},
	meta_keyword :{required:true}
};
var vMessages = {
	title:{required:"Please enter name",maxlength:"Please enter title within 100 characters"},
	meta_description:{required:"Please enter description",maxlength:"Please description title within 100 characters"},
	keywords :{required:"Please enter keywords"}
};

$("#form-validate").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/metadetails/addmeta', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{	
					window.location.href="<?php echo SITE_ROOT;?>/metadetails/listmetadata";
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