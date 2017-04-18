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
.form-control1 {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 46px;
    line-height: 1.42857;
    padding: 10px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
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
								<span style="padding: 10px; float: left;"><a href="#">Manage Payment</a></span>
							<?php } ?>
							<?php if ($access->hasPrivilege("AddNewPayment")) { ?>
							<a href="#addpayment" role="button" data-toggle="modal" class="btn btn-primary btn-lg" style="width: 300px;float:right;"><i class="fa fa-plus"></i> &nbsp; Add New Payment</a>
							<?php } ?>
							<div class="control-group dataTables_filter searchFilterClass" style="float:right;margin-right:30px;">
								<input id="search" type="text" class="searchInput form-control1"/>
							</div>
							<div class="btn-group dataTables_filter searchFilterClass" data-toggle="buttons">
								<div class="btn btn-default <?php if(isset($_REQUEST['datetype'])){if($_REQUEST['datetype']=="today")echo "active";} ?>">
									<input type="radio" name="searchtype" class="searchInput" <?php if(isset($_REQUEST['datetype'])){if($_REQUEST['datetype']=="today")echo " checked";} ?> value="today" /> Today
								</div> 
								<input id="search5" type="hidden" class="searchInput"/>
								<div class="btn btn-default <?php if(isset($_REQUEST['datetype'])){if($_REQUEST['datetype']=="week")echo "active";} ?>">
									<input type="radio" name="searchtype" class="searchInput" <?php if(isset($_REQUEST['datetype'])){if($_REQUEST['datetype']=="week")echo " checked";} ?> value="week" /> Last week
								</div> 
								<div class="btn btn-default <?php if(isset($_REQUEST['datetype'])){if($_REQUEST['datetype']=="month")echo "active";} ?>">
									<input type="radio" name="searchtype" class="searchInput" <?php if(isset($_REQUEST['datetype'])){if($_REQUEST['datetype']=="month")echo " checked";} ?> value="month" /> Last month
								</div>
							</div>
							<!-- <div class="control-group dataTables_filter searchFilterClass" style="float:right;margin-right:30px;">
								<input id="search1" type="text" class="searchInput form-control1 datechange"/>
							</div>
							<div class="control-group dataTables_filter searchFilterClass" style="float:right;margin-right:30px;">
								<input id="search2" type="text" class="searchInput form-control1 datechange1"/>
							</div> -->
						</div>
						
						<div class="row">
							<div class="widget-content">
								<div style="clear:both;height:30px;"></div>
								<?php 
									$temp = '';
									$temp1 = '';
									if(isset($_REQUEST['datetype']))
									{	$temp = "?datetype=".$_REQUEST['datetype'];
										$temp1 = "&datetype=".$_REQUEST['datetype'];
									}
								?>
								<table id="mytable" cellpadding="0" callfunction="<?php if(isset($_REQUEST['patient_id'])) echo BASEPATH."/users/fetchpayment?patient_id=".$_REQUEST['patient_id'].$temp1; else echo BASEPATH."/users/fetchpayment".$temp;?>" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
									<thead>
										<tr>
											<th width="15%">PATIENT NAME</th>
											<th width="10%">CONTACT</th>
											<th width="10%">AMT</th>
											<th width="15%">Descriptions</th>
											<th width="15%">DOCTOR NAME</th>
											<th width="15%">CREATED BY</th>
											<th width="10%">STATUS</th>
											<th width="10%">ACTION</th>
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
	<div id="addpayment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:530px;width:50%;margin:auto;">
		<form method="post" name="addpayment1" id="addpayment1">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">Add New Payment</h3>
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
								
								if($_SESSION['webadmin1']['role_id'] != PATIENT_ROLE)
									echo $db->CreateOptions2("html", "tbl_user_master", array("i.id","CONCAT(i.first_name,' ',i.last_name)"), $join_tables, $selected,"","r.role_id = ".PATIENT_ROLE." && r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
								else
									echo $db->CreateOptions2("html", "tbl_user_master", array("i.id","CONCAT(i.first_name,' ',i.last_name)"), $join_tables, $selected,"","r.role_id = ".PATIENT_ROLE." && r.user_id = ".$_SESSION['webadmin']['id']." && r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
								
							?>								
						</select>
						
				<script>
				$('#patient_id').searchableOptionList();
				</script>
				
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				   <div class="field">
					  <label for="item_name">Doctor Name</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="doctor_id" name="doctor_id">
							<option value="">Select Doctor</option>
							<?php 
								if(isset($result['doctor_id']) && $result['doctor_id'] != "")
								{
									$selected = $result['doctor_id'];
								}
								$join_tables = array(
									array('left','tbl_user_master r','r.id = i.user_id', array('r.first_name as first_name','r.last_name as last_name'))
								);
								
								if($_SESSION['webadmin1']['role_id'] == "2" || $_SESSION['webadmin1']['role_id'] == "4" )
									echo $db->CreateOptions2("html", "tbl_user_clinic_relation", array("i.user_id","CONCAT(first_name,' ',last_name)"), $join_tables, $selected,"","(i.role_id='3' OR i.role_id='2') && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
								else
									echo $db->CreateOptions2("html", "tbl_user_clinic_relation", array("i.user_id","CONCAT(first_name,' ',last_name)"), $join_tables, $selected,"","(i.role_id='3' OR i.role_id='2') && i.user_id = ".$_SESSION['webadmin']['id']." && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
							?>								
						</select>
						
					<script>
				    $('#doctor_id').searchableOptionList();
				    </script>	
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				    <div class="field">
					  <label for="item_name">Date</label>
					  <input type="text" id="date" name="date" value="" placeholder="Select Date" class="form-control login username-field required" />
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				    <div class="field">
					  <label for="item_name">Descriptions</label>
					  <input type="text" id="item_desc" name="item_desc" value="" placeholder="Item Descriptions" class="form-control required" />
				   </div>
				   <div style="clear:both;height:10px;"></div>
				   <div class="col-md-6">
					  <label for="amount">Amount</label>
					  <input type="number" id="amount" name="amount" value="" placeholder="Amount" class="form-control login username-field required" />
				   </div>
				   <div class="col-md-6">
					  <label for="status">Status</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="status" name="status">
							<option value="">Select Status</option>
							<option value="Paid">Paid</option>
							<option value="Pending">Pending</option>
						</select>
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				    <div class="field">
					  <label for="item_name">Payment Method</label>
					  <select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="payment_method" name="payment_method">
							<option value="">Select Status</option>
							<option value="Cash">Cash</option>
							<option value="DebitCard">DebitCard</option>
							<option value="Insurance">Insurance</option>
						</select>
				   </div>
				  <div style="clear:both;width:100%;float:left;margin-top:5px;">
						<label for="item_name">&nbsp;</label><a href="https://sso.telushealth.com/oam/server/obrareq.cgi?encquery%3DJbrsZmLi050pZBQMqTInQw5%2BxCH9HLmv%2FoZRHaRou89GT8bLNMbxYIw8TVlcplBjjv7SV3Oivy7gw6v%2BKhsIxaSNMVrbLXpZoiEQV0G0QAx%2BNWf86D4pC9pZpYS8PL%2BYwbfBFSW9VrvO2iwbB%2FbG0jX%2Bo5WMDy%2BJ8qnV01Z2LmCrBH%2FJPxvxPiUaXQXMP6er9rr6g%2FlfG10RSvz20yHE6bopUFFiiDCPTN6c8DFw4k%2BVIdBR4IFGk9eOCe2VY1%2FstZ%2BIwZFJAnPFWUqfhpAqj6eDiXKdNcvGDkfufW%2FcVC%2BKGgXL4AioM3LmrTFWkhmYp8WBpghIiJffRvmsrmqtfg%3D%3D%20agentid%3Dwebgate11g%20ver%3D1" class="btn btn-primary" target="_blank" style="background-color: #F0F0F0;color: black;border-color: #ccc;">Bill Insurance</a>
					</div>	
				   <div style="clear:both;height:10px;"></div>		
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<?php if ($access->hasPrivilege("AddNewPayment")) { ?>
				<input type="submit" class="btn btn-primary" value="Submit">
				<?php } ?>
			</div>
		</form>
	</div>
	
	
	<div id="editpayment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:530px;width:50%;margin:auto;">
		<form method="post" name="editpayment1" id="editpayment1">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">Update Payment</h3>
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
								
								if($_SESSION['webadmin1']['role_id'] != PATIENT_ROLE)
									echo $db->CreateOptions2("html", "tbl_user_master", array("i.id","CONCAT(i.first_name,' ',i.last_name)"), $join_tables, $selected,"","r.role_id = ".PATIENT_ROLE." && r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
								else
									echo $db->CreateOptions2("html", "tbl_user_master", array("i.id","CONCAT(i.first_name,' ',i.last_name)"), $join_tables, $selected,"","r.role_id = ".PATIENT_ROLE." && r.user_id = ".$_SESSION['webadmin']['id']." && r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
								
							?>								
						</select>
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				   <div class="field">
					  <label for="item_name">Doctor Name</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="edit_doctor_id" name="edit_doctor_id">
							<option value="">Select Doctor</option>
							<?php 
								if(isset($result['doctor_id']) && $result['doctor_id'] != "")
								{
									$selected = $result['doctor_id'];
								}
								$join_tables = array(
									array('left','tbl_user_master r','r.id = i.user_id', array('r.first_name as first_name','r.last_name as last_name'))
								);
								
								if($_SESSION['webadmin1']['role_id'] == "2" || $_SESSION['webadmin1']['role_id'] == "4" )
									echo $db->CreateOptions2("html", "tbl_user_clinic_relation", array("i.user_id","CONCAT(first_name,' ',last_name)"), $join_tables, $selected,"","(i.role_id='3' OR i.role_id='2') && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
								else
									echo $db->CreateOptions2("html", "tbl_user_clinic_relation", array("i.user_id","CONCAT(first_name,' ',last_name)"), $join_tables, $selected,"","(i.role_id='3' OR i.role_id='2') && i.user_id = ".$_SESSION['webadmin']['id']." && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
								
								
							?>								
						</select>
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				    <div class="field">
					  <label for="item_name">Date</label>
					  <input type="text" id="edit_date" name="edit_date" value="" placeholder="Select Date" class="form-control login username-field required" />
				   </div>
				   <div style="clear:both;height:10px;"></div>
				   <div class="field">
					  <label for="item_name">Descriptions</label>
					  <input type="text" id="edit_item_desc" name="edit_item_desc" value="" placeholder="Item Descriptions" class="form-control required" />
				   </div>
				   <div style="clear:both;height:10px;"></div>
				   <div class="col-md-6">
					  <label for="amount">Amount</label>
					  <input type="number" id="edit_amount" name="edit_amount" value="" placeholder="Amount" class="form-control login username-field required" />
				   </div>
				   <div class="col-md-6">
					  <label for="status">Status</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="edit_status" name="edit_status">
							<option value="">Select Status</option>
							<option value="Paid">Paid</option>
							<option value="Pending">Pending</option>
						</select>
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				    <div class="field">
					  <label for="item_name">Payment Method</label>
					  <select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="edit_payment_method" name="edit_payment_method">
							<option value="">Select Status</option>
							<option value="Cash">Cash</option>
							<option value="DebitCard">DebitCard</option>
							<option value="Insurance">Insurance</option>
						</select>
						<input type="hidden" id="edit_id" name="edit_id"/>
				   </div>
				  <div style="clear:both;width:100%;float:left;margin-top:5px;">
						<label for="item_name">&nbsp;</label><a href="https://sso.telushealth.com/oam/server/obrareq.cgi?encquery%3DJbrsZmLi050pZBQMqTInQw5%2BxCH9HLmv%2FoZRHaRou89GT8bLNMbxYIw8TVlcplBjjv7SV3Oivy7gw6v%2BKhsIxaSNMVrbLXpZoiEQV0G0QAx%2BNWf86D4pC9pZpYS8PL%2BYwbfBFSW9VrvO2iwbB%2FbG0jX%2Bo5WMDy%2BJ8qnV01Z2LmCrBH%2FJPxvxPiUaXQXMP6er9rr6g%2FlfG10RSvz20yHE6bopUFFiiDCPTN6c8DFw4k%2BVIdBR4IFGk9eOCe2VY1%2FstZ%2BIwZFJAnPFWUqfhpAqj6eDiXKdNcvGDkfufW%2FcVC%2BKGgXL4AioM3LmrTFWkhmYp8WBpghIiJffRvmsrmqtfg%3D%3D%20agentid%3Dwebgate11g%20ver%3D1" class="btn btn-primary" target="_blank" style="background-color: #F0F0F0;color: black;border-color: #ccc;">Bill Insurance</a>
					</div>	
				   <div style="clear:both;height:10px;"></div>	
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<?php if ($access->hasPrivilege("AddNewPayment")) { ?>
				<input type="submit" class="btn btn-primary" value="Submit">
				<?php } ?>
			</div>
		</form>
	</div>
</div>
<script>
var vRules2 = {
	patient_id:{required:true},
	doctor_id:{required:true},
	date:{required:true},
	amount:{required:true},
	status:{required:true},
	item_desc:{required:true},
	payment_method:{required:true}
};
var vMessages2 = {
	date:{required:"Please Select the Date"},
	patient_id:{required:"Please Select the Patient"},
	doctor_id:{required:"Please Select the Doctor"},
	status:{required:"Please Select the Status"},
	item_desc:{required:"Please Enter Item Descriptions"},
	payment_method:{required:"Please Select the Payment Method"},
	amount:{required:"Please enter the Amount"}
};

var vRules3 = {
	edit_patient_id:{required:true},
	edit_doctor_id:{required:true},
	edit_date:{required:true},
	edit_amount:{required:true},
	edit_status:{required:true},
	edit_item_desc:{required:true},
	edit_payment_method:{required:true}
};
var vMessages3 = {
	edit_date:{required:"Please Select the Date"},
	edit_patient_id:{required:"Please Select the Patient"},
	edit_doctor_id:{required:"Please Select the Doctor"},
	edit_status:{required:"Please Select the Status"},
	edit_item_desc:{required:"Please Enter Item Descriptions"},
	edit_payment_method:{required:"Please Select the Payment Method"},
	edit_amount:{required:"Please enter the Amount"}
};

jQuery("#addpayment1").validate({
	rules: vRules2,
	messages: vMessages2,
	submitHandler: function(form) {        
		jQuery("#loading").css('display','block');
		jQuery(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/users/addpayment', 
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
			url: '<?php echo BASEPATH;?>/users/editpayment', 
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
	$('input:radio').change(function(){
		<?php if(isset($_REQUEST['patient_id'])){ ?>
		window.location.href="<?= SITE_ROOT;?>/users/payment?datetype="+$(this).val()+"&patient_id=<?=$_REQUEST['patient_id']; ?>";
		<?php }else{ ?>
		window.location.href="<?= SITE_ROOT;?>/users/payment?datetype="+$(this).val();
		<?php } ?>
	});
	$("#first_name").focus();
	//$("#mytable").dataTable({});
	$(".datechange,.datechange1,#date,#edit_date").datepicker({      
		changeMonth: true,
		changeYear: true
	});
	document.title="Payment | Vettree";
	
	$("#search1,#search2").change(function(){		
		$(this).keyup();
		$(this).keypress();
		$(this).keydown();
	});
	<?php if(isset($_REQUEST['patient_id'])){ ?>
	$('#patient_id').val(<?= $_REQUEST['patient_id']; ?>);
	<?php } ?>
});
   function editbutton(id)
   {
	   jQuery("#loading").css('display','block');
	   $.ajax({
		url: '<?php echo BASEPATH;?>/users/fetchPaymentDetails', 
		type: 'post',
		cache: false,
		data: 'id='+id,
		success: function (response) {                    
			var res = eval('('+response+')');
			if(res['id'] !="")
			{                    
				$('#edit_id').val(res['id']);
				$('#edit_amount').val(res['amount']);
				$('#edit_date').val(res['date']);
				$('#edit_item_desc').val(res['item_desc']);
				$('#edit_doctor_id').val(res['doctor_id']);
				$('#edit_patient_id').val(res['patient_id']);
				$('#edit_payment_method').val(res['payment_method']);
				$('#edit_status').val(res['status']);
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
      		window.location.href="<?=SITE_ROOT;?>/users/deletepayment?id="+id;
      	}
      }
</script>
