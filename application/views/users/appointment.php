<?php
$result= array();
$act = "add";
$heading = "Appointment";
$url_prams = array();

$db = new Db();
if(!isset($_SESSION["webadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
?>
<link href='<?php echo CSS;?>/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo CSS;?>/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='<?php echo BASEPATH;?>/lib/moment.min.js'></script>
<script src='<?php echo JS;?>/fullcalendar.min.js'></script>

<style>
	#calendar {
		max-width: 900px;
		margin: 0 auto;
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
	.timeline {
		position: absolute;
		left: 59px;
		border: none;
		border-top: 2px solid red;
		width: 100%;
		margin: 0;
		padding: 0;
		z-index: 999;
	}
</style>
<?php
$timeslotsarray = array();
$timeslotsarray[0] = 0;

$db1 = new Db();
$temp  = $db1->FetchToArray("tbl_timeslots","*","1=1");


?>
<!--Body content-->
<div class="main" style="float: left; width: 100%; background:#F7F7F7;">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12" style="background-color:#fff;padding:10px; margin-top: 30px;">
					<div class="widget" style="background-color:#fff;padding:10px;">
						<div class="widget-header" style="border-bottom:1px solid #D9D8D8;padding:5px;">
							<p style="font-size:16px;font-weight:600;"><?php echo $heading;?></p>
						</div>
						<br/>
						<a href="<?=SITE_ROOT;?>/users/appointment_details" role="button" data-toggle="modal" class="btn btn-primary btn-lg" style="float:left;">Details View</a>
						<?php
							
							$table = "tbl_user_clinic_relation";
							$table_id = 'id';
							$condition = " i.clinic_id = ".$_SESSION['webadmin1']['clinic_id']." && i.role_id = ".PATIENT_ROLE ;
							$main_table = array("$table i",array("i.*"));
							
							$join_tables = array(
								array('left','tbl_user_master r','r.id = i.user_id', array('r.first_name as first_name','r.last_name as last_name','r.email as email,r.gender,r.dob,r.phone_no,r.emer_mobile_no as emergency_phone_no'))
							);
							
							$totalRs = $db->JoinFetch($main_table, $join_tables, $condition);
							$totalRecords = @mysql_num_rows($totalRs);
		
						if ($access->hasPrivilege("AddNewPatient") && ($totalRecords < $_SESSION["webadmin1"]["subscription_obj"]["no_of_patients"] || $_SESSION["webadmin1"]["subscription_obj"]["no_of_patients"]==0 )) { ?>
								<a href="<?php echo SITE_ROOT?>/patient" role="button" data-toggle="modal" class="btn btn-primary btn-lg" style="width: 20%;float:right;"><i class="fa fa-plus"></i> &nbsp; New Patient</a>
						<?php } ?>
						<?php if ($access->hasPrivilege("AddNewAppointment")) { ?>
							<a href="#addapp" role="button" id="AddNewAppointment" data-toggle="modal" class="btn btn-primary btn-lg" style="width: 300px;float:right;margin-right:20px;"><i class="fa fa-plus"></i> &nbsp; Add New Appointments</a>
						<?php } ?>
						
						<?php if ($_SESSION["webadmin1"]["role_id"]=="2" || $_SESSION["webadmin1"]["role_id"]=="3" ) { ?>
						<select class="select2_category form-control" onchange="changeDoc(this.value)" style="float: right; max-width: 200px; margin-right: 20px; padding: 9px; height: 46px;" id="my-select" name="my-select">
							<option value="">All</option>
							<?php 
								if(isset($_REQUEST['doctor']) && $_REQUEST['doctor'] != "")
								{
									$selected = $_REQUEST['doctor'];
								}
								$join_tables = array(
									array('left','tbl_user_master r','r.id = i.user_id', array('r.first_name as first_name','r.last_name as last_name'))
								);
								echo $db->CreateOptions2("html", "tbl_user_clinic_relation", array("i.user_id","CONCAT(first_name,' ',last_name)"), $join_tables, $selected,"","(i.role_id='3' OR i.role_id='2') && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
							?>								
						</select>
						
						<script>
						$('#my-select').searchableOptionList();
						</script>
						<?php } ?>
						<br/>
						<!-- End .heading-->
						<!-- Build page from here: -->
						<div style="clear:both;height:20px;"></div>	
						<div id='calendar'></div>
						<div style="clear:both;height:20px;"></div>
						<!-- End .row-fluid -->
						<!-- Page end here -->
                        
                        
					</div>
				</div>
				<div style="clear:both;height:10px;"></div>
				<!-- /span12 -->
			</div>
			<!-- /row --> 
		</div>
		<!-- /container --> 
	</div>
</div>

<div id="addapp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:530px;width:50%;margin:auto;">
		<form method="post" name="addapp1" id="addapp1">
			<?php if ($access->hasPrivilege("AddNewAppointment")) { ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">Add New Appointments</h3>
			</div>
			<?php } ?>
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
								
								if(isset($_SESSION['webadmin1']['role_id']) && $_SESSION['webadmin1']['role_id'] == PATIENT_ROLE)
								{
									$selected = $_SESSION['webadmin']['id'];
								}
								
								$join_tables = array(
									array('left','tbl_user_clinic_relation r','r.user_id = i.id', array())
								);
								
								if(isset($_SESSION['webadmin1']['role_id']) && $_SESSION['webadmin1']['role_id'] == PATIENT_ROLE)
								{
									echo $db->CreateOptions2("html", "tbl_user_master", array("i.id","CONCAT(i.first_name,' ',i.last_name)"), $join_tables, $selected,"","r.role_id = ".PATIENT_ROLE." && r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']." && i.id = ".$_SESSION['webadmin']['id']);
								}
								else
									echo $db->CreateOptions2("html", "tbl_user_master", array("i.id","CONCAT(i.first_name,' ',i.last_name)"), $join_tables, $selected,"","r.role_id = ".PATIENT_ROLE." && r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
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
								echo $db->CreateOptions2("html", "tbl_user_clinic_relation", array("i.user_id","CONCAT(first_name,' ',last_name)"), $join_tables, $selected,"","(i.role_id='3' OR i.role_id='2') && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
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
				   <div class="col-md-6">
					  <label for="amount">Appointment Start Time</label>
					  <select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="time_slot_start" name="time_slot_start">
							<option value="">Select Time</option>
							<?php 
								$selected = "";
								echo $db->CreateOptions("html", "tbl_timeslots", array("id","times"), $selected,array('id' => 'asc'));
							?>							
						</select>
				   </div>
				   <div class="col-md-6">
					  <label for="amount">Appointment End Time</label>
					  <select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="time_slot_end" name="time_slot_end">
							<option value="">Select Time</option>
							<?php 
								$selected = "";
								echo $db->CreateOptions("html", "tbl_timeslots", array("id","times"), $selected,array('id' => 'asc'));
							?>							
						</select>
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				    <!-- <div class="field">
					  <label for="item_name">Is New?</label>
					  <input type="checkbox" name="flag" id="flag" value="1" />
				   </div> -->
				   <div style="clear:both;height:10px;"></div>		
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<?php if ($access->hasPrivilege("AddNewAppointment")) { ?>
				<input type="submit" class="btn btn-primary" value="Submit">
				<?php } ?>
			</div>
		</form>
	</div>
	
	<div id="editAppointment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:530px;width:50%;margin:auto;">
		<form method="post" name="addapp2" id="addapp2">
			<div class="modal-header">
				<button type="button closebtn" class="close" onclick="checkout()" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">Edit Appointments</h3>
			</div>
			<div class="modal-body">
				<div class="login-fields">
					<div class="field">
					  <label for="item_name">Patient Name</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="edit_patient_id" name="edit_patient_id">
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
						$('#edit_patient_id').searchableOptionList();
						</script>
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
								echo $db->CreateOptions2("html", "tbl_user_clinic_relation", array("i.user_id","CONCAT(first_name,' ',last_name)"), $join_tables, $selected,"","(i.role_id='3' OR i.role_id='2') && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id']);
							?>								
						</select>
						<script>
						$('#edit_doctor_id').searchableOptionList();
						</script>
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				    <div class="field">
					  <label for="item_name">Date</label>
					  <input type="text" id="edit_date" name="edit_date" value="" placeholder="Select Date" class="form-control login username-field required" />
				   </div>
				   <div style="clear:both;height:10px;"></div>
				   <div class="col-md-6">
					  <label for="amount">Appointment Start Time</label>
					  <select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="edit_time_slot_start" name="edit_time_slot_start">
							<option value="">Select Time</option>
							<?php 
								$selected = "";
								echo $db->CreateOptions("html", "tbl_timeslots", array("id","times"), $selected,array('id' => 'asc'));
							?>							
						</select>
				   </div>
				   <div class="col-md-6">
					  <label for="amount">Appointment End Time</label>
					  <select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="edit_time_slot_end" name="edit_time_slot_end">
							<option value="">Select Time</option>
							<?php 
								$selected = "";
								echo $db->CreateOptions("html", "tbl_timeslots", array("id","times"), $selected,array('id' => 'asc'));
							?>							
						</select>
				   </div>
				   <input type="hidden" id="edit_id" name="edit_id"/>
				   <div style="clear:both;height:10px;"></div>		
				    <!--<div class="field">
					  <label for="item_name">Is New?</label>
					  <input type="checkbox" name="edit_flag" id="edit_flag" value="1" />
				   </div> -->
				   <div style="clear:both;height:10px;"></div>		
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" onclick="deleteDataP()">Cancel Appointment</button>
				<button class="btn closebtn" onclick="checkout()" data-dismiss="modal" aria-hidden="true">Close</button>
				<?php if ($access->hasPrivilege("AddNewAppointment")) { ?>
				<input type="submit" class="btn btn-primary" value="Submit">
				<?php } ?>
			</div>
		</form>
	</div>
	
<script>
function checkout()
{
	location.reload();
}
function editbuttonA(id)
   {
	   jQuery("#loading").css('display','block');
	   $.ajax({
		url: '<?php echo BASEPATH;?>/users/fetchAppDetails', 
		type: 'post',
		cache: false,
		data: 'id='+id,
		success: function (response) {                    
			var res = eval('('+response+')');
			if(res['id'] !="")
			{                    
				$('#edit_id').val(res['id']);
				if(res['flag']==1)
				$( "#edit_flag" ).prop( "checked", true );
				else
				$( "#edit_flag" ).prop( "checked", false );
				$('#edit_date').val(res['date']);
				$('#edit_doctor_id').val(res['doctor_id']);
				$('#edit_patient_id').val(res['patient_id']);
				$('#edit_time_slot_end').val(res['time_slot_end']);
				$('#edit_time_slot_start').val(res['time_slot_start']);
				$(".closebtn").removeAttr("onclick");
				$('#editAppointment').modal('show');
			}
			jQuery("#loading").css('display','none');
		}
		});
   }
   
function setTimeline() {
	var parentDiv = jQuery(".fc-slats:visible").parent();
	var timeline = parentDiv.children(".timeline");
	if (timeline.length == 0) { //if timeline isn't there, add it
		timeline = $("<hr>").addClass("timeline");
		parentDiv.prepend(timeline);
	}

	var curTime = new Date();

	var curCalView = calendar.fullCalendar("getView");
	/*if (curCalView.visStart < curTime && curCalView.visEnd > curTime) {*/
		timeline.show();
	/*} else {
		timeline.hide();
	}*/

	var curSeconds = (curTime.getHours() * 60 * 60) + (curTime.getMinutes() * 60) + curTime.getSeconds();
	var percentOfDay = curSeconds / 86400; //24 * 60 * 60 = 86400, # of seconds in a day
	var topLoc = Math.floor(parentDiv.height() * percentOfDay);
	//console.log(topLoc);
	timeline.css("top", topLoc + "px");

	if (curCalView.name == "agendaWeek") { //week view, don't want the timeline to go the whole way across
		var dayCol = $(".fc-today:visible");
		var left = dayCol.position().left + 1;
		var width = dayCol.width();
		timeline.css({
			left: left + "px",
			width: width + "px"
		});
		//$(".fc-time-grid").css({'top':"-"+topLoc+"px"});
	}
}
var calendar,timelineInterval;
var curTime1 = new Date();
var arr = new Array();
arr[0] = 0;
<?php for($t =0;$t<sizeof($temp);$t++){ ?>
arr[<?= $temp[$t]['id']; ?>] = "<?= $temp[$t]['alttime']; ?>";
<?php } ?>
//console.log(arr);
$(document).ready(function() {
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	calendar = $('#calendar').fullCalendar({
		//editable: true,
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		viewRender: function(view) {
			window.clearInterval(timelineInterval);
			timelineInterval = window.setInterval(setTimeline, 10000);
			try {
				setTimeline();
			} catch(err) { }
		},
		defaultView: 'agendaWeek',
		 scrollTime: curTime1.getHours()+':00:00',
		/*viewRender: function(view) {
			try {
				setTimeline();
			} catch(err) {}
		},*/
		events: "<?=SITE_ROOT ?>/users/fetchapp<?php if(isset($_REQUEST['doctor'])) echo "?doctor=".$_REQUEST['doctor']; ?>",
		// Convert the allDay from string to boolean
		eventRender: function(event, element, view) {
			
			if (event.allDay === 'true') {
			event.allDay = true;
			} else {
			event.allDay = false;
			}
		},
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			var check = new Date(start.format("M/D/YYYY"));
			var test = new Date();
			var d = test.getDate();
			var m = test.getMonth()+1;
			var y = test.getFullYear();
			var today = new Date(m + '/' + d + '/' + y);
			
			if(check < today)
			{
				alert("You cant add Appointment");
				$('#calendar').fullCalendar('unselect');
				return false;
			}
			else
			{
				jQuery("#date").val(start.format("M/D/YYYY"));
				jQuery("#time_slot_start").val(jQuery.inArray(start.format('HH:mm'),arr));
				jQuery("#time_slot_end").val(jQuery.inArray(end.format('HH:mm'),arr));
				jQuery("#AddNewAppointment").click();
				return true;
			}
		},
		editable: true,
		eventDrop: function(event, delta) {
			var start = event.start;
			var end = event.end;
			console.log(event);
			console.log(start.format("M/D/YYYY"));
			 $.ajax({
				url: '<?php echo BASEPATH;?>/users/fetchAppDetails', 
				type: 'post',
				cache: false,
				data: 'id='+event.id,
				success: function (response) {                    
					var res = eval('('+response+')');
					if(res['id'] !="")
					{                    
						$('#edit_id').val(res['id']);
						if(res['flag']==1)
						$( "#edit_flag" ).prop( "checked", true );
						else
						$( "#edit_flag" ).prop( "checked", false );
						$('#edit_date').val(start.format("M/D/YYYY"));
						$('#edit_doctor_id').val(res['doctor_id']);
						$('#edit_patient_id').val(res['patient_id']);
						$('#edit_time_slot_end').val(jQuery.inArray(end.format('HH:mm'),arr));
						$('#edit_time_slot_start').val(jQuery.inArray(start.format('HH:mm'),arr));
						$(".closebtn").attr({"onclick":"checkout()"});
						$('#editAppointment').modal('show');
					}
					jQuery("#loading").css('display','none');
				}
			});
		},
		eventResize: function(event) {
			
			var start = event.start;
			var end = event.end;
			
			 $.ajax({
				url: '<?php echo BASEPATH;?>/users/fetchAppDetails', 
				type: 'post',
				cache: false,
				data: 'id='+event.id,
				success: function (response) {                    
					var res = eval('('+response+')');
					if(res['id'] !="")
					{                    
						$('#edit_id').val(res['id']);
						if(res['flag']==1)
						$( "#edit_flag" ).prop( "checked", true );
						else
						$( "#edit_flag" ).prop( "checked", false );
						$('#edit_date').val(res['date']);
						$('#edit_doctor_id').val(res['doctor_id']);
						$('#edit_patient_id').val(res['patient_id']);
						$('#edit_time_slot_end').val(jQuery.inArray(end.format('HH:mm'),arr));
						$('#edit_time_slot_start').val(jQuery.inArray(start.format('HH:mm'),arr));
						$(".closebtn").attr({"onclick":"checkout()"});
						$('#editAppointment').modal('show');
					}
					jQuery("#loading").css('display','none');
				}
			});
		}
	});
});
	

</script>
<script>

var vRules2 = {
	patient_id:{required:true},
	doctor_id:{required:true},
	date:{required:true},
	time_slot_start:{required:true},
	time_slot_end:{required:true}
};
var vMessages2 = {
	date:{required:"Please Select the Date"},
	patient_id:{required:"Please Select the Patient"},
	doctor_id:{required:"Please Select the Doctor"},
	time_slot_start:{required:"Please Select the Start Time"},
	time_slot_end:{required:"Please Select the End Time"}
};

var vRules3 = {
	edit_patient_id:{required:true},
	edit_doctor_id:{required:true},
	edit_date:{required:true},
	edit_time_slot_start:{required:true},
	edit_time_slot_end:{required:true}
};
var vMessages3 = {
	edit_date:{required:"Please Select the Date"},
	edit_patient_id:{required:"Please Select the Patient"},
	edit_doctor_id:{required:"Please Select the Doctor"},
	edit_time_slot_start:{required:"Please Select the Start Time"},
	edit_time_slot_end:{required:"Please Select the End Time"}
};


jQuery("#addapp1").validate({
	rules: vRules2,
	messages: vMessages2,
	submitHandler: function(form) {        
		jQuery("#loading").css('display','block');
		
		$.ajax({
			url: '<?php echo BASEPATH;?>/users/verifyappointment', 
			type: 'post',
			cache: false,
			data: {
				patient_id : jQuery("#patient_id").val(),
				doctor_id : jQuery("#doctor_id").val(),
				time_slot_start : jQuery("#time_slot_start").val(),
				time_slot_end : jQuery("#time_slot_end").val(),
				date : jQuery("#date").val()
			},
			success: function (response) {                    
				var res = eval('('+response+')');
				//alert(res['flag']);
				if(!res['flag2'] && !res['flag1'])
				{	jQuery(form).ajaxSubmit({
						url: '<?php echo BASEPATH;?>/users/addappointment', 
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
				else
				{
					displayMsg("error","You cannot book apointment for this time intervals.");
					return false;
				}
				jQuery("#loading").css('display','none');
			}
		});
		
		
		
	}
});

jQuery("#addapp2").validate({
		rules: vRules3,
		messages: vMessages3,
		submitHandler: function(form) {        
			jQuery("#loading").css('display','block');
			jQuery(form).ajaxSubmit({
				url: '<?php echo BASEPATH;?>/users/editappointment', 
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
	document.title = "Appointments | Vettree";
		$("#date").datepicker({      
			changeMonth: true,
			changeYear: true,
			minDate: 0
		});
});

function deleteDataP()
{
	var r=confirm("Are you sure you want to delete this Appointment?");
	if (r==true)
		{
		window.location.href="<?=SITE_ROOT;?>/users/deleteappointment?id="+$("#edit_id").val();
	}
}

function changeDoc(val)
{
	if(val != "")
		window.location.href="<?=SITE_ROOT;?>/users/appointment?doctor="+val;
	else
		window.location.href="<?=SITE_ROOT;?>/users/appointment";
}
</script>