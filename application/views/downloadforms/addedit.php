<?php
$access2 = new PrivilegedUser();
if (!($access2->hasPrivilege("EditForms") || $access2->hasPrivilege("AddForms")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
$db = new Db();
$result= array();
$access2 = new PrivilegedUser();
if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
{
	$table = "downloadform";
	$table_id = 'id';
	$condition = "" ;
	$main_table = array("$table i",array("i.*"));
	$join_tables = array(
		array('left','samaj_city r2','r2.id = i.samaj_city', array('r2.name as city'))
	);
	if($condition=="")
		$condition = " 1=1 && i.id= '".$_REQUEST['id']."' ";
	$rs = $db->JoinFetch($main_table, $join_tables, $condition);									
	$result = mysql_fetch_object($rs);
}
?>
<div class="page-head">
	<div class="page-title">
		<h1>Add Form</h1>
	</div>	
	<div class="page-title" style="float: left; clear: both;">		
		<h1>
			<span class="badge badge-success"> 1 </span>Form Info
		</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered" style="float:left;width:100%;padding:10px">	
			<form enctype="multipart/form-data" method="post" name="signup-form" id="signup-form" action='' novalidate  style="width:100%;">
			  <div class="fusion-image-wrapper" >
				 <div class="form-group col-md-6 col-xs-12">
					<label for="title" class="control-label">Title<b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" id="title" name="title" value="<?php if(isset($result->title) && $result->title != '') { echo $result->title; } ?>" minlength=2 maxlength=30 />
					<input type="hidden" name="id" id="id" value="<?php if(isset($result->id) && $result->id != ''){ echo $result->id; } ?>">
				 </div>
				 <div class="form-group col-md-6 col-xs-12">
					<label for="description" class="control-label">Description<b style="color:red;margin-left:5px">*</b></label>
					<input type="text" class="form-control" id="description" name="description" maxlength="30" value="<?php if(isset($result->description) && $result->description != '') { echo $result->description; } ?>" />
				 </div>
				 <div style="clear:both;float:left;width:100%"></div>
				 <div class="form-group col-md-6 col-xs-12">
					<label for="filename" class="control-label">Select File<b style="color:red;margin-left:5px">*</b></label>
					<input class="form-control" type="file" id="filename" name="filename" value="" />
				 </div>
				 <div class="form-group col-md-6 col-xs-12 cityid">
					<label for="samaj_city" class="control-label">Samaj City<b style="color:red;margin-left:5px">*</b></label>
					<select class="form-control" name="samaj_city" id="samaj_city">
						<option value="">Select</option>
						<?php 
						if(isset($result->samaj_city) && $result->samaj_city != '')
							{ $selectd = $result->samaj_city; }
							echo $db->CreateOptions("html", "samaj_city", array("id","name"),$selectd);
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
				if ($access2->hasPrivilege("AddForms"))
				{ 	
					?>
					<div class="col-md-12 col-xs-12">
						<input type="submit" class="btn green" name="submit" value="UPDATE" id="signup" style="margin-right: 2%;"/> 
						<input type="reset" value="Cancel" class="btn default" id="cancle">
					</div>
					<?php
				}
			}
			else
			{
				if ($access2->hasPrivilege("EditForms"))
				{
					?>
					<div class="col-md-12 col-xs-12">
						<input type="submit" class="btn green" name="submit" value="SUBMIT" id="signup" style="margin-right: 2%;"/> 
						<input type="reset" value="Cancel" class="btn default" id="cancle">
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
	
		$("#menuforms").addClass("active");
		
  });

</script>
<script>

$(document).ready(function(){
	$("#manageadmin").addClass("active");
	var vRulesL = {
				title:{required:true, minlength:2,maxlength:30},
				description:{required:true, minlength:2,maxlength:300},
				<?php if(!isset($_REQUEST['id']) && $_REQUEST['id'] == ""){ ?>filename:{required:true}, <?php } ?>
				samaj_city:{required:true}
			};

			var vMessagesL = {
				title:{required:"Please enter title",minlength: "Title should be at least 2 characters",maxlength:"Title should be within 30 characters"},
				description:{required:"Please enter description",minlength: "Title should be at least 2 characters",maxlength:"Title should be within 300 characters"},
				<?php if(!isset($_REQUEST['id']) && $_REQUEST['id'] == ""){ ?>filename:{required:"Please select file"},<?php } ?>
				samaj_city:{required:"Please select samaj city"}
			};

			

	$("#signup-form").validate({
		rules: vRulesL,
		messages: vMessagesL,
		submitHandler: function(form1) {		
			$(form1).ajaxSubmit({
				url: '<?= SITE_ROOT; ?>/downloadforms/addeditform', 
				type: 'post',
				cache: false,
				enctype:"multipart/form-data",
				success: function (response) {					
					var res = eval('('+response+')');
					if(res['msg'] == "success")
					{	
						$('#displayMsg1').hide();	
						location.href = "<?= SITE_ROOT; ?>/downloadforms/";
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