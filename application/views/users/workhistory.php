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
<link rel="stylesheet" media="all" type="text/css" href="<?=CSS; ?>/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="<?=JS; ?>/jquery-ui-timepicker-addon.js"></script>
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
								<span style="padding: 10px; float: left;"><a href="#">Manage Payment</a></span>
							<?php } ?>
							<?php if($_SESSION['webadmin1']['role_id']=="3" || $_SESSION['webadmin1']['role_id']=="4"){ ?>
							<?php if ($access->hasPrivilege("AddNewWorkHistory")) { ?>
							<a href="#addhours" role="button" data-toggle="modal" class="btn btn-primary btn-lg" style="width: 300px;float:right;"><i class="fa fa-plus"></i> &nbsp; Add Hours</a>
							<?php }} ?>
						</div>
						
						<div class="row">
							<div class="widget-content">
								<div style="clear:both;height:30px;"></div>
								<table id="mytable" cellpadding="0" callfunction="<?php if(isset($_REQUEST['user_id'])) echo BASEPATH."/users/fetchhistory?user_id=".$_REQUEST['user_id']; else echo BASEPATH."/users/fetchhistory";?>" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
									<thead>
										<tr>
										<?php if($_SESSION['webadmin1']['role_id']!="3" && $_SESSION['webadmin1']['role_id']!="4"){ ?>
											<th width="15%">STAFF NAME</th>
										<?php } ?>
											<th width="10%">Date</th>
											<th width="10%">IN TIME</th>
											<!-- <th width="15%">BREAK IN TIME</th>
											<th width="15%">BREAK OUT TIME</th> -->
											<th width="10%">OUT TIME</th>
											<th width="15%" data-bSortable="false">HOURS WORKED</th>
											<th width="10%" data-bSortable="false">ACTION</th>
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
	<div id="addhours" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:500px;width:50%;margin:auto;">
		<form method="post" name="addhours1" id="addhours1">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">Add Hours</h3>
			</div>
			<div class="modal-body">
				<div class="login-fields">
					<div class="field">
					  <label for="item_name">Date</label>
					  <input type="text" id="date" name="date" value="" placeholder="Select Date" class="form-control login username-field required" />
					</div>
					<div style="clear:both;height:10px;"></div>		
					<div class="field">
					  <label for="item_name">In Time</label>
					  <input type="text" id="in_time" name="in_time" value="" placeholder="Select In Time" class="form-control login username-field required" />
					</div>
					<div style="clear:both;height:10px;display:none;"></div>		
					<div class="field" style="display:none;">
					  <label for="item_name">Break In Time</label>
					  <input type="text" id="break_in_time" name="break_in_time" value="12:00" placeholder="Select Break In Time" class="form-control login username-field required" />
					</div>
					<div style="clear:both;height:10px;display:none;" ></div>		
					<div class="field" style="display:none;">
					  <label for="item_name">Break Out Time</label>
					  <input type="text" id="break_out_time" name="break_out_time" value="12:00" placeholder="Select Break Out Time" class="form-control login username-field required" />
					</div>
				   <div style="clear:both;height:10px;"></div>		
				    <div class="field">
					  <label for="item_name">Out Time</label>
					  <input type="text" id="out_time" name="out_time" value="" placeholder="Select Out Time" class="form-control login username-field required" />
				   </div>
				   <div style="clear:both;height:10px;"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<?php if ($access->hasPrivilege("AddNewWorkHistory")) { ?>
				<input type="submit" class="btn btn-primary" value="Submit">
				<?php } ?>
			</div>
		</form>
	</div>
	
	
	<div id="editpayment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:500px;width:50%;margin:auto;">
		<form method="post" name="editpayment1" id="editpayment1">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">Update Payment</h3>
			</div>
			<div class="modal-body">
				<div class="login-fields">
					<div class="field">
					  <label for="item_name">Date</label>
					  <input type="text" id="edit_date" name="edit_date" value="" placeholder="Select Date" class="form-control login username-field required" />
					</div>
					<div style="clear:both;height:10px;"></div>		
					<div class="field">
					  <label for="item_name">In Time</label>
					  <input type="text" id="edit_in_time" name="edit_in_time" value="" placeholder="Select In Time" class="form-control login username-field required" />
					</div>
					<div style="clear:both;height:10px;display:none;"></div>		
					<div class="field" style="display:none;">
					  <label for="item_name">Break In Time</label>
					  <input type="text" id="edit_break_in_time" name="edit_break_in_time" value="" placeholder="Select Break Time" class="form-control login username-field required" />
					</div>
				   <div style="clear:both;height:10px;display:none;"></div>		
				   <div class="field" style="display:none;">
					  <label for="item_name" >Break Out Time</label>
					  <input type="text" id="edit_break_out_time" name="edit_break_out_time" value="" placeholder="Select Break Time" class="form-control login username-field required" />
					</div>
				   <div style="clear:both;height:10px;"></div>		
				    <div class="field">
					  <label for="item_name">Out Time</label>
					  <input type="text" id="edit_out_time" name="edit_out_time" value="" placeholder="Select Out Time" class="form-control login username-field required" />
					  <input type="hidden" id="edit_id" name="edit_id"/>
				   </div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<?php if ($access->hasPrivilege("AddNewWorkHistory")) { ?>
				<input type="submit" class="btn btn-primary" value="Submit">
				<?php } ?>
			</div>
		</form>
	</div>
</div>
<script>
var vRules2 = {
	date:{required:true},
	in_time:{required:true},
	out_time:{required:true},
	break_in_time:{required:true},
	break_out_time:{required:true}
};
var vMessages2 = {
	date:{required:"Please Select the Date"},
	in_time:{required:"Please Select the In Time"},
	out_time:{required:"Please Select the Out Time"},
	break_in_time:{required:"Please Select the Break Time"},
	break_out_time:{required:"Please Select the Break Time"}
};

var vRules3 = {
	edit_date:{required:true},
	edit_in_time:{required:true},
	edit_break_in_time:{required:true},
	edit_break_out_time:{required:true},
	edit_out_time:{required:true}
};
var vMessages3 = {
	edit_date:{required:"Please Select the Date"},
	edit_in_time:{required:"Please Select the In Time"},
	edit_out_time:{required:"Please Select the Out Time"},
	edit_break_in_time:{required:"Please Select the Break Time"},
	edit_break_out_time:{required:"Please Select the Break Time"}
};

jQuery("#addhours1").validate({
	rules: vRules2,
	messages: vMessages2,
	submitHandler: function(form) {        
		jQuery("#loading").css('display','block');
		jQuery(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/users/addhours', 
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
			url: '<?php echo BASEPATH;?>/users/edithours', 
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
	$("#date,#edit_date").datepicker({      
		changeMonth: true,
		changeYear: true
	});
	$("#in_time,#out_time,#break_in_time,#break_out_time").timepicker({timeFormat: 'HH:mm'});
	$("#edit_in_time,#edit_out_time,#edit_break_in_time,#edit_break_out_time").timepicker({timeFormat: 'HH:mm'});
	document.title="Work History | Vettree";
	<?php if(isset($_REQUEST['patient_id'])){ ?>
	$('#patient_id').val(<?= $_REQUEST['patient_id']; ?>);
	<?php } ?>
});
   function editbutton(id)
   {
	   jQuery("#loading").css('display','block');
	   $.ajax({
		url: '<?php echo BASEPATH;?>/users/fetchlogs', 
		type: 'post',
		cache: false,
		data: 'id='+id,
		success: function (response) {                    
			var res = eval('('+response+')');
			if(res['id'] !="")
			{                    
				$('#edit_id').val(res['id']);
				$('#edit_in_time').val(res['in_time']);
				$('#edit_date').val(res['date']);
				$('#edit_out_time').val(res['out_time']);
				$('#edit_break_in_time').val(res['break_in_time']);
				$('#edit_break_out_time').val(res['break_out_time']);
			}
			jQuery("#loading").css('display','none');
		}
		});
   }
   function deleteDataP(id)
   {
      	var r=confirm("Are you sure you want to delete this record?");
      	if (r==true)
     		{
      		window.location.href="<?=SITE_ROOT;?>/users/deletehours?id="+id;
      	}
      }
</script>
