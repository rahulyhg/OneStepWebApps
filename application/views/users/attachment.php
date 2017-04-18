<?php
$result= array();
$act = "add";
$heading = "Add User";
$url_prams = array();
$db = new Db();
if(!isset($_SESSION["webadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}

?>
<style>
p {
    margin: 0;
}
</style>
<div class="main" style="float: left; width: 100%; background:#F7F7F7;">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12" style="background-color:#fff;padding:10px; margin-top: 30px;">
					<div class="widget" style="background-color:#fff;padding:10px;">
						<div id="Inventry" class="tab-pane">
      	            <!-- Left side column. contains the logo and sidebar -->
                    <div class="container" style="width:100%;">
					
                        <div class="row">
							<?php if(isset($_REQUEST['patient_id'])){ ?>
								<span style="padding: 10px; float: left;"><a href="<?php echo SITE_ROOT; ?>/patient/listing">Manage Patient</a></span>
								<span style="padding: 10px 0; float: left;"> &nbsp; >> &nbsp; </span>
								<span style="padding: 10px; float: left;"><a href="#">Manage Attachment</a></span>
							<?php } ?>
							<?php if ($access->hasPrivilege("AddNewAttachment")) { ?>
							<a href="#addpayment" role="button" data-toggle="modal" class="btn btn-primary btn-lg" style="width: 300px;float:right;"><i class="fa fa-plus"></i> &nbsp; Add New Attachment</a>
							<?php } ?>
						</div>
						
						<div class="row">
							<div class="widget-content">
								<div style="clear:both;height:30px;"></div>
								<table id="mytable" cellpadding="0" callfunction="<?php if(isset($_REQUEST['patient_id'])) echo BASEPATH."/users/fetchattachment?patient_id=".$_REQUEST['patient_id']; else echo BASEPATH."/users/fetchattachment";?>" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
									<thead>
										<tr>
											<th width="15%">ALL</th>
											<th width="15%">ATTACHMENT</th>
											<th width="20%">PATIENT</th>
											<th width="30%">CREATED DATE & TIME</th>
											<th width="20%">ACTION</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
									<tfoot>
									</tfoot>
								</table>
								<div style="clear:both;height:20px;"></div>
							</div>
                        </div>
                    </div>
                </div>
					</div>
					<div style="clear:both;height:10px;"></div>
				</div>
				<!-- /span12 -->
			</div>
			<!-- /row --> 
		</div>
		<!-- /container --> 
	</div>
</div>
<div class="login-extra">
   <!-- Modal -->
	<div id="addpayment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:300px;width:50%;margin:auto;">
		<form method="post" name="addpayment1" id="addpayment1" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">Add New Attachment</h3>
			</div>
			<div class="modal-body">
				<div class="login-fields">
					<div class="field">
					  <label for="item_name">Patient Name</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="patient_id" name="patient_id">
							<option value="">Select Patient</option>
							<?php 
								if(isset($_REQUEST['patient_id']) && $_REQUEST['patient_id'] != "")
								{
									$selected = $_REQUEST['patient_id'];
								}
								$join_tables = array(
									array('left','tbl_user_clinic_relation r','r.user_id = i.id', array())
								);
								
								echo $db->CreateOptions2("html", "tbl_user_master", array("i.id","CONCAT(i.first_name,' ',i.last_name)"), $join_tables, $selected,"","r.role_id = ".PATIENT_ROLE." && r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
							?>								
						</select>
						
					<script>
				    $('#patient_id').searchableOptionList();
				    </script>	
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				   <div class="field">
					  <label for="item_name">Upload Attachment</label>
					  <input type="file" id="thumbnail" name="thumbnail" value="" placeholder="Please Select File" class="form-control login username-field required" />
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<?php if ($access->hasPrivilege("AddNewAttachment")) { ?>
				<input type="submit" class="btn btn-primary" value="Submit">
				<?php } ?>
			</div>
		</form>
	</div>
	
	
	<div id="editpayment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:500px;width:50%;margin:auto;">
		<form method="post" name="editpayment1" id="editpayment1" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">Update Attachment</h3>
			</div>
			<div class="modal-body">
				<div class="login-fields">
					<div class="field">
					  <label for="item_name">Patient Name</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="edit_patient_id" name="edit_patient_id">
							<option value="">Select Patient</option>
							<?php 
								if(isset($result['patient_id']) && $result['patient_id'] != "")
								{
									$selected = $result['patient_id'];
								}
								$join_tables = array(
									array('left','tbl_user_clinic_relation r','r.user_id = i.id', array())
								);
								
								echo $db->CreateOptions2("html", "tbl_user_master", array("i.id","CONCAT(i.first_name,' ',i.last_name)"), $join_tables, $selected,"","r.role_id = ".PATIENT_ROLE." && r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
							?>								
						</select>
					</div>
					<div style="clear:both;height:10px;"></div>		
					<div class="field">
						<label for="item_name">Upload Attachment</label>
						<input type="file" id="edit_thumbnail" name="edit_thumbnail" value="" placeholder="Please Select File" class="form-control login username-field required" />
						<a href="#" id="view_attachment" target="_blank">Attachment</a>
					</div>
					<div style="clear:both;height:10px;"></div>		
					<input type="hidden" id="edit_id" name="edit_id"/>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<?php if ($access->hasPrivilege("AddNewAttachment")) { ?>
				<input type="submit" class="btn btn-primary" value="Submit">
				<?php } ?>
			</div>
		</form>
	</div>
</div>
<script>
var vRules2 = {
	patient_id:{required:true},
	attached:{required:true}
};
var vMessages2 = {
	patient_id:{required:"Please Select the Patient"},
	attached:{required:"Please Upload the Attachment"}
};

var vRules3 = {
	edit_patient_id:{required:true}
};
var vMessages3 = {
	edit_patient_id:{required:"Please Select the Patient"}
};

jQuery("#addpayment1").validate({
	rules: vRules2,
	messages: vMessages2,
	submitHandler: function(form) {        
		jQuery("#loading").css('display','block');
		jQuery(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/users/addattachment', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {                    
				var res = eval('('+response+')');
				if(res['msg'] =="success")
				{                    
					location.reload();
				}
				else
				{                        
					displayMsg("error",res['msg']);
					return false;
				}
				jQuery("#loading").css('display','none');
			}
		});
	}
});

jQuery("#editpayment1").validate({
	rules: vRules3,
	messages: vMessages3,
	submitHandler: function(form) {        
		jQuery("#loading").css('display','block');
		jQuery(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/users/editattachemnt', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {                    
				var res = eval('('+response+')');
				if(res['msg'] =="success")
				{                    
					location.reload();
				}
				else
				{                        
					displayMsg("error",res['msg']);
					return false;
				}
				jQuery("#loading").css('display','none');
			}
		});
	}
});
$(function(){
	$("#first_name").focus();
	<?php if(isset($_REQUEST['patient_id'])){ ?>
	$('#patient_id').val(<?= $_REQUEST['patient_id']; ?>);
	<?php } ?>
	//$("#mytable").dataTable({});
	document.title="Attachment | Vettree";
});
   function editbutton(id)
   {
	   jQuery("#loading").css('display','block');
	   $.ajax({
		url: '<?php echo BASEPATH;?>/users/fetchAttachmentDetails', 
		type: 'post',
		cache: false,
		data: 'id='+id,
		success: function (response) {                    
			var res = eval('('+response+')');
			if(res['id'] !="")
			{                    
				$('#edit_id').val(res['id']);
				$('#edit_patient_id').val(res['patient_id']);
				$('#view_attachment').attr({'href': '<?= SITE_ROOT; ?>/attachment/'+res['attachment']});
			}
			jQuery("#loading").css('display','none');
		}
		});
   }
   function deleteData(id)
   {
      	var r=confirm("Are you sure you want to delete this record?");
      	if (r==true)
     		{
      		window.location.href="<?=SITE_ROOT;?>/users/deleteattachment?id="+id;
      	}
      }
</script>
