<?php
$result= array();
$act = "add";
$heading = "Add User";
$url_prams = array();
if(!isset($_SESSION["webadmin"]["id"]) || !isset($_REQUEST["user_id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$db = new Db();
if(isset($_REQUEST["user_id"]))
{
	$user_id = $_REQUEST["user_id"];

	$rs = $db->FetchRow("tbl_user_master","id",$user_id);
	if($rs != null )
	{
		$heading = "Update";
		$result = mysql_fetch_array($rs);
		$act = "Edit";	
	}
}
?>
<style>
.editable{display:none;}
tr.odd{background-color:#fff!important;}
tr.even{background-color:#e5eff5!important;}
.odd td{border-color:#e7e7e7!important;}
.even td{border-color:#e7e7e7!important;}
#mytable_wrapper{border: 1px solid #e7e7e7;border-top: 0px;}
.selectedtab div{background: #e5eff5 none repeat scroll 0 0;color: black;float: left;margin: 10px 0 25px;padding: 10px;text-align: center;width: 50%;cursor:pointer;}
.selectedtab .select{background-color:#2185c5!important;color:white!important;}
</style>
<!--Body content-->
<div class="main" style="float: left; width: 100%; background:#F7F7F7;">
	<div class="main-inner">
		<div class="container">
			<div class="row">
			<div class="col-md-12">
				<div class="widget" style="background-color:#fff;padding:10px;float:left;width:100%;">
					<div class="col-md-12">
						<div class="row" style="margin-right: 5px;">
							<div class="portlet-body form" style="margin-left: 20px;padding-top: 20px;">
								<div class="widget-header" style="border-bottom:1px solid #D9D8D8;float: left; width: 100%; padding: 10px;">
									<p style="font-size: 16px; font-weight: 600; float: left; line-height: 35px;"><?= $result['first_name']." ".$result['last_name']; ?></p>   
									<?php if ($access->hasPrivilege("AddNewStaff")) { ?>
									<input type="button" style="float:left;margin-left:20px;" class="btn btn-primary btn-lg pull-right" value="Edit" onclick="funcedit()" />
									<?php } ?>
								</div>
								<div style="clear:both;float:left;width:100%;height:20px;"></div>
								<div class="col-md-3" style="padding-left: 0;padding-right:0;margin-bottom:20px;">
									<div class="form-group">
										<?php if(isset($result['profile_image']) && $result['profile_image']!=""){ ?>
										<img src="<?php echo UPLOADS;?>/<?php echo $result['profile_image'];?>" class="img-responsive" style="float: left;width:100px;height:100px;position: relative; top: -10px;border-radius:50% 50%;"/>
										<?php }else{ ?>
										<img src="<?php echo IMAGES;?>/user_pic.jpg" class="img-responsive" style="float: left;position: relative; top: -10px;width:100px;height:100px;"/>
										<?php } ?>
									</div>
									<div style="clear:both;height:10px;"></div>
								</div>
								<div class="col-md-9" style="padding-left: 0;padding-right:0;margin-bottom:20px;">
									<form class="horizontal-form" id="form-validate" enctype="multipart/form-data" method="post">
										<input id="id" name="id" type="hidden" value="<?php if(isset($user_id))echo $user_id;?>"/>
										<div class="form-group">
											<label class="control-label">E-mail</label>
											<span class="noneditable"><?php if(isset($result['email']))echo $result['email'];?></span>
											<input type="text" tabindex="5" disabled value="<?php if(isset($result['email']))echo $result['email'];?>" id="email" name="email" class="form-control email editable" placeholder="Email Id">
										</div>
										<div style="clear:both;height:10px;"></div>
										<div class="form-group">
											<label class="control-label">Phone No</label>
											<span class="noneditable"><?php if(isset($result['phone_no']))echo $result['phone_no'];?></span>
											<input type="text" tabindex="6" value="<?php if(isset($result['phone_no']))echo $result['phone_no'];?>" id="phone_no" name="phone_no" class="form-control number editable" placeholder="Mobile Number" maxlength=10 minlength=10>
										</div>
										<div style="clear:both;height:10px;"></div>
										<div class="form-group">
											<label class="control-label">Date Of Birth</label>
											<span class="noneditable"><?php if(isset($result['dob']))echo $result['dob'];?></span>
											<input type="text" value="<?php if(isset($result['dob']))echo $result['dob'];?>" id="dob" name="dob" class="form-control editable" placeholder="Date of Birth" tabindex="4" style="float:left;">
										</div>
										<div style="clear:both;height:10px;"></div>
										<div class="form-group">
											<label class="control-label">Gender</label>
											<span class="noneditable"><?php if(isset($result['gender']))echo $result['gender'];?></span>
											<select class="select2_category form-control editable" data-placeholder="Gender" tabindex="3" id="gender" name="gender">
												<option value="">Select one...</option>
												<option <?php if(isset($result['gender']) && $result['gender']=="Male")echo "selected";?> value="Male">Male</option>
												<option <?php if(isset($result['gender']) && $result['gender']=="Female")echo "selected";?> value="Female">Female</option>
												<option <?php if(isset($result['gender']) && $result['gender']=="Other")echo "selected";?> value="Other">Other</option>
											</select>
										</div>
										<div style="clear:both;height:10px;"></div>
										<div class="form-group editable">
											<label class="control-label editable">Upload Photo</label>
											<input type="file" tabindex="5" id="thumbnail" name="thumbnail" class="form-control editable" placeholder="Upload the Photo">
										</div>
										<div style="clear:both;height:10px;"></div>
										<div class="col-md-6 col-md-offset-3 editable" style="margin-bottom:40px;">
										<?php if ($access->hasPrivilege("AddNewStaff")) { ?>
											<button type="submit" tabindex="13" class="btn btn-success btn-lg"><?= $act; ?></button>
										<?php } ?>
										</div>
									</form>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="clear:both;height:30px;"></div>
				<div class="col-md-12">
					<div class="widget" style="background-color:#fff;padding:10px;float:left;width:100%;">
						<div class="col-md-12">
                        	<div class="row" style="margin-right: 5px;">
								<div class="portlet-body form" style="margin-left: 20px;padding-top: 20px;">
									<div class="widget-header" style="border-bottom:1px solid #D9D8D8;padding:5px;">
										<p style="font-size:16px;font-weight:600;">WORK HOURS HISTORY</p>   
									</div>
									<div style="clear:both;float:left;width:100%;height:20px;"></div>
									<div class="row" style="margin:0;">
										<div class="col-md-offset-3 col-md-6 selectedtab">
											<div class="col-md-6 selectedtabDiv select" sel="tableworkhistoryDiv">Daily</div>
											<div class="col-md-6 selectedtabDiv" sel="tableworkweeklyDiv">Weekly</div>
										</div>
										<div class="widget-content">
										<div id="tableworkhistoryDiv" class="col-md-12 hidetable">
											<table cellpadding="0" id="tableworkhistory" cellspacing="0" border="0" class="nofilter table table-bordered" width="100%">
												<thead>
													<tr style="background:#2185c5;">
														<th width="16%" style="color:white;border-color:#2185c5;">Date</th>
														<th width="16%" style="color:white;border-color:#2185c5;">IN TIME</th>
														<th width="16%" style="color:white;border-color:#2185c5;">BREAK IN TIME</th>
														<th width="16%" style="color:white;border-color:#2185c5;">BREAK OUT TIME</th>
														<th width="16%" style="color:white;border-color:#2185c5;">OUT TIME</th>
														<th width="16%" style="color:white;border-color:#2185c5;">HOURS WORKED</th>
														<th width="20%" style="color:white;border-color:#2185c5;">ACTION</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
												</tfoot>
											</table>
											<div style="clear:both;height:20px;"></div>
										</div>
										<div id="tableworkweeklyDiv" class="col-md-12 hidetable">
											<table cellpadding="0" id="tableworkweekly" cellspacing="0" border="0" class="nofilter table table-bordered" width="100%">
												<thead>
													<tr style="background:#2185c5;">
														<th width="50%" style="color:white;border-color:#2185c5;">Week</th>
														<th width="50%" style="color:white;border-color:#2185c5;">HOURS WORKED</th>
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
						</div>
					</div>
				</div>
				
				<div style="clear:both;height:10px;"></div>
				<!-- /span12 -->
			</div>
		</div>
		<!-- /container --> 
	</div>
</div>
<script>
$(function(){
	
var vRules = {
	first_name:{required:true},
	last_name:{required:true},
	email:{required:true},
	address:{required:true},
	dob:{required:true},
	phone_no:{required:true}
};
var vMessages = {
	first_name:{required:"Please enter first name"},
	last_name:{required:"Please enter last name"},
	email:{required:"Please enter email id"},
	address:{required:"Please enter Address"},
	dob:{required:"Please select Date of Birth"},
	phone_no:{required:"Please enter Mobile no"}
};

$("#form-validate").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/users/addEdit', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{					
					location.reload();
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

	$('.selectedtabDiv').click(function(){
		$('.selectedtabDiv').removeClass('select');
		$(this).addClass('select');
		$('.hidetable').hide();
		$('#'+$(this).attr('sel')).show();
	});
	$('.selectedtabDiv').click();
	$("#first_name").focus();
	var bFilter = true;
    if($('table').hasClass('nofilter')){
        bFilter = false;
    }
		var columnSort2 = new Array; 
		$(this).find('#tableworkhistory thead tr th').each(function(){
			if($(this).attr('data-bSortable') == 'false') {
				columnSort2.push({ "bSortable": false });
			} else {
				if($(this).html() == "Action" || $(this).html() == "Actions")
				{
					columnSort2.push({ "bSortable": false });
				}else{
					columnSort2.push({ "bSortable": true });
				}
			}
		});
		var noofrecords2 = $("#tableworkhistory").attr("noofrecords");		
		var oTable1 = $('#tableworkhistory').dataTable({
            "bSort": false,
			"bJQueryUI": false,
			"bAutoWidth": false,
			"bLengthChange": false,
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength":noofrecords2,
			"aaSorting":[],
			"sAjaxSource": "<?php if(isset($_REQUEST['user_id'])) echo BASEPATH."/users/fetchprofilehistory?user_id=".$_REQUEST['user_id']; else echo BASEPATH."/users/fetchprofilehistory";?>",
			"fnInitComplete": function(oSettings, json) {
				$('.dataTables_filter>label>input').parent().remove();
$(".hideclass").hide();				
		    },
		    "aoColumnDefs": [{ "bSortable": bFilter, "aTargets": [ -1 ] }],
		    "aoColumns": columnSort2,
		    "fnDrawCallback": function( oSettings ) {
		    	if (typeof datatablecomplete == 'function') { 
		    		datatablecomplete("tableworkhistory");
		    	} 
		    }
        });
		
		var columnSort3 = new Array; 
		$(this).find('#tableworkweekly thead tr th').each(function(){
			if($(this).attr('data-bSortable') == 'false') {
				columnSort3.push({ "bSortable": false });
			} else {
				if($(this).html() == "Action" || $(this).html() == "Actions")
				{
					columnSort3.push({ "bSortable": false });
				}else{
					columnSort3.push({ "bSortable": true });
				}
			}
		});
		var noofrecords3 = $("#tableworkweekly").attr("noofrecords");		
		var oTable1 = $('#tableworkweekly').dataTable({
            "bSort": false,
			"bJQueryUI": false,
			"bAutoWidth": false,
			"bLengthChange": false,
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength":noofrecords3,
			"aaSorting":[],
			"sAjaxSource": "<?php if(isset($_REQUEST['user_id'])) echo BASEPATH."/users/fetchhistoryweekly?user_id=".$_REQUEST['user_id']; else echo BASEPATH."/users/fetchhistoryweekly";?>",
			"fnInitComplete": function(oSettings, json) {
				$('.dataTables_filter>label>input').parent().remove();
$(".hideclass").hide();				
		    },
		    "aoColumnDefs": [{ "bSortable": bFilter, "aTargets": [ -1 ] }],
		    "aoColumns": columnSort3,
		    "fnDrawCallback": function( oSettings ) {
		    	if (typeof datatablecomplete == 'function') { 
		    		datatablecomplete("tableworkweekly");
		    	} 
		    }
        });
		
	$(".hideclass").hide();
	$("#dob").datepicker({changeMonth: true,changeYear: true});
	var dateToday = new Date();
	$("#date").datepicker({minDate: dateToday});
	document.title="Profile | Vettre"
});

	function deleteDataP(id)
	{
      	var r=confirm("Are you sure you want to delete this record?");
      	if (r==true)
     		{
      		window.location.href="<?=SITE_ROOT;?>/users/deletehours?id="+id+"&user_id="+<?= $_REQUEST['user_id']; ?>;
      	}
    }
	
	function funcedit()
	{
		$('.noneditable').hide();
		$('.editable').show();
		$("#dob").datepicker({});
	}
</script>