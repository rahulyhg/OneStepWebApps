<?php
@session_start();
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
if(!isset($_REQUEST['project_id'])){
	Core::PageRedirect(SITE_ROOT."/home");
}
?>
<style>
label.error{
	display:none!important;
}
</style>
<?php
$db = new Db();
$table88 = "ext_notes";
$sort = 'i.id';
$order = 'asc';
$condition88 = "i.id = ".$_REQUEST['id']." && i.created_by = ".$_SESSION['samajadmin']['id'];
$main_table88 = array("$table88 i",array("i.*"));
$join_tables88 = array(
);
$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
$result = mysql_fetch_array($rs1);
?>
<?php 
$label = "Add";
$button = "Create";
if(isset($_REQUEST['id'])){
	$label = "Edit";
	$button = "Update";
} ?>
<div class="row">
<div class="col s12 m12">
	<ul id="task-card" class="collection with-header" style="margin-bottom: 0px; border: 0px none;">
		<li class="collection-header" style="background:transparent;padding:0;">
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 600px);">
				<a data-delay="50" data-tooltip="Next To Estimate" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/externalestimate?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#00699C;" class="mdi-hardware-keyboard-arrow-right"></i>
				</a>
				<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#00699C;" class="mdi-content-clear"></i>
				</a>
				<a data-delay="50" data-tooltip="Previous To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/home/dashboard?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#00699C;" class="mdi-hardware-keyboard-arrow-left"></i>
				</a>
				<!--<a href="<?php echo SITE_ROOT."/home/externalnote?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="Create New Note">
					<i class="mdi-content-content-paste"></i>
				</a>
				<a href="<?php echo SITE_ROOT."/project/externalestimate?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="Create New Estimate">
					<i class="mdi-action-assignment-late"></i>
				</a>
				<a href="<?php echo SITE_ROOT."/project/external_project?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="Create New Project">
					<i class="mdi-action-assignment"></i>
				</a>
				<a href="<?php echo SITE_ROOT."/project/external_pricing?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="External Pricing">
					<i class="mdi-editor-attach-money"></i>
				</a>
				<a href="<?php echo SITE_ROOT."/home/notes?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="Create General Note">
					<i class="mdi-notification-folder-special"></i>
				</a>-->
				<a href="javascript:form_externalestimate()" style="float: right; margin-right: 20px;"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content strong" style="color:#00699C;background:#fff;"><?php echo $button; ?></span></h6></a>
			</div>
		</li>
	</ul>
</div>
</div>
<div class="col s12 m12 l12">
<div class="card-panel" style="margin-top:0px;">
	<div id="input-fields">
		<div class="row">
			<div class="col s12 m12 l12">
				<div class="row">
					<form class="col s12" name="add_project" id="add_project">
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="1" value="" id="notes_name" name="notes_name" class="validate"><?php if(isset($result['notes_name']))echo $result['notes_name'];?></textarea>
								<!-- <label for="Date active">Date</label> -->
								<label for="notes_name">Notes Name</label>
								<input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">  
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="2" value="" autocomplete="off" id="notes_desc" name="notes_desc" class="validate" ><?php if(isset($result['notes_desc']))echo $result['notes_desc'];?></textarea>
								<label for="notes_desc">Notes Description</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="3" value="" id="pressure_wash" name="pressure_wash" class="validate" ><?php if(isset($result['pressure_wash']))echo $result['pressure_wash'];?></textarea>
								<label for="pressure_wash">Pressure Wash</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="4" value="" autocomplete="off" id="patch_stucco" name="patch_stucco" class="validate"><?php if(isset($result['patch_stucco']))echo $result['patch_stucco'];?></textarea>
								<label for="patch_stucco">Patch Stucco</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="5" value="" id="prep_work" name="prep_work" class="validate"><?php if(isset($result['prep_work']))echo $result['prep_work'];?></textarea>
								<label for="prep_work">Prep Work</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="6" value="" autocomplete="off" id="prep" name="prep" class="validate" ><?php if(isset($result['prep']))echo $result['prep'];?></textarea>
								<label for="prep">Prep</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="7" value="" autocomplete="off" id="extra_prep" name="extra_prep" class="validate" ><?php if(isset($result['extra_prep']))echo $result['extra_prep'];?></textarea>
								<label for="extra_prep">Extra Prep</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="8" value="" autocomplete="off" id="mask_and_protect" name="mask_and_protect" class="validate" ><?php if(isset($result['mask_and_protect']))echo $result['mask_and_protect'];?></textarea>
								<label for="mask_and_protect">Mask and Protect</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="9" value="" id="glaze_windows" name="glaze_windows" class="validate" ><?php if(isset($result['glaze_windows']))echo $result['glaze_windows'];?></textarea>
								<label for="glaze_windows">Glaze Windows</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="10" value="" autocomplete="off" id="stucco" name="stucco" class="validate" ><?php if(isset($result['stucco']))echo $result['stucco'];?></textarea>
								<label for="stucco">Stucco</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="11" value="" id="siding" name="siding" class="validate"><?php if(isset($result['siding']))echo $result['siding'];?></textarea>
								<label for="siding">Siding</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="12" value="" autocomplete="off" id="eaves" name="eaves" class="validate"><?php if(isset($result['eaves']))echo $result['eaves'];?></textarea>
								<label for="eaves">Eaves</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="13" value="" id="fascia" name="fascia" class="validate"><?php if(isset($result['fascia']))echo $result['fascia'];?></textarea>
								<label for="fascia">Fascia</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="14" value="" id="flashing" name="flashing" class="validate"><?php if(isset($result['flashing']))echo $result['flashing'];?></textarea>
								<label for="flashing">Flashing</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="15" value="" autocomplete="off" id="gutters_downspouts" name="gutters_downspouts" class="validate" ><?php if(isset($result['gutters_downspouts']))echo $result['gutters_downspouts'];?></textarea>
								<label for="gutters_downspouts">Gutters Downspouts</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="16" value="" id="wood_windows" name="wood_windows" class="validate" ><?php if(isset($result['wood_windows']))echo $result['wood_windows'];?></textarea>
								<label for="wood_windows">Wood Windows</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="17" value="" autocomplete="off" id="siding_trim" name="siding_trim" class="validate"><?php if(isset($result['siding_trim']))echo $result['siding_trim'];?></textarea>
								<label for="siding_trim">Siding Trim</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="18" value="" id="doors_frames" name="doors_frames" class="validate"><?php if(isset($result['doors_frames']))echo $result['doors_frames'];?></textarea>
								<label for="doors_frames">Doors Frames</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="19" value="" autocomplete="off" id="shutters" name="shutters" class="validate" ><?php if(isset($result['shutters']))echo $result['shutters'];?></textarea>
								<label for="shutters">Shutters</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="20" value="" id="wrought_iron" name="wrought_iron" class="validate" ><?php if(isset($result['wrought_iron']))echo $result['wrought_iron'];?></textarea>
								<label for="wrought_iron">Wrought Iron</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="21" value="" autocomplete="off" id="perimeter_walls" name="perimeter_walls" class="validate" ><?php if(isset($result['perimeter_walls']))echo $result['perimeter_walls'];?></textarea>
								<label for="perimeter_walls">Perimeter Walls</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="22" value="" id="gates" name="gates" class="validate" ><?php if(isset($result['gates']))echo $result['gates'];?></textarea>
								<label for="gates">Gates</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="23" value="" autocomplete="off" id="garage_door" name="garage_door" class="validate" ><?php if(isset($result['garage_door']))echo $result['garage_door'];?></textarea>
								<label for="garage_door">Garage Door</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="24" value="" id="front_door" name="front_door" class="validate" ><?php if(isset($result['front_door']))echo $result['front_door'];?></textarea>
								<label for="front_door">Front Door</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="25" value="" autocomplete="off" id="decks" name="decks" class="validate"><?php if(isset($result['decks']))echo $result['decks'];?></textarea>
								<label for="decks">Decks</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="26" value="" id="wood_patio" name="wood_patio" class="validate" ><?php if(isset($result['wood_patio']))echo $result['wood_patio'];?></textarea>
								<label for="wood_patio">Wood Patio</label>
							</div>
						</div>
						<input type="hidden" name="status" id="status" value="1">
						<div class="row">
							<div class="input-field col s12" style="text-align:center;">
								<input class="z-depth-1 waves-effect btn secondary-content strong" type="submit" id="submit" name="submit" value="<?php echo $button; ?>" style="background:#00699C; display:inline-block; float:none;">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
function form_externalestimate(){
	$("#submit").click();
}

$(function(){
 $('#extnotes').addClass('active');
});
$(function(){
	
var vRules = {
	notes_name:{required:true}
	
};
var vMessages = {
	notes_name:{required:"Please enter notes name"}
};

function form_externalestimate(){
	$("#submit").click();
}

$("#add_project").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?= SITE_ROOT; ?>/home/addextnotes?project_id=<?php echo $_REQUEST['project_id']; ?>', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['success'])
				{	
					swal({   title: "Do you want to continue?",   
						 text: "Exterior notes added. Do you want to create another notes?",   
						 type: "warning",   
						 showCancelButton: true,   
						 confirmButtonColor: "#DD6B55",   
						 confirmButtonText: "Yes",   
						 cancelButtonText: "No",   
						 closeOnConfirm: false,   
						 closeOnCancel: false }, 
						 function(isConfirm){   
							 if (isConfirm) {     
								 location.href = "<?= SITE_ROOT; ?>/home/externalnote?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
							 else {
								 location.href = "<?= SITE_ROOT; ?>/project/dashboard?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
						});
						
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
$("#headingSearchtitle").html("Exterior Notes");
$("#exteriorli").addClass("active");
   $("#exteriorlidiv").show();
});
</script>