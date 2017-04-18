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
$table88 = "int_notes";
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
				<a data-delay="50" data-tooltip="Next To Estimate" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/internalestimate?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#b71c1c;" class="mdi-hardware-keyboard-arrow-right"></i>
				</a>
				<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#b71c1c;" class="mdi-content-clear"></i>
				</a>
				<a data-delay="50" data-tooltip="Previous To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#b71c1c;" class="mdi-hardware-keyboard-arrow-left"></i>
				</a>
				<!--<a href="<?php echo SITE_ROOT."/home/internalnote?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="Create New Note">
					<i class="mdi-content-content-paste"></i>
				</a>
				<a href="<?php echo SITE_ROOT."/project/internalestimate?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="Create New Estimate">
					<i class="mdi-action-assignment-late"></i>
				</a>
				<a href="<?php echo SITE_ROOT."/project/internal_project?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="Create New Project">
					<i class="mdi-action-assignment"></i>
				</a>
				<a href="<?php echo SITE_ROOT."/project/internal_pricing?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="External Pricing">
					<i class="mdi-editor-attach-money"></i>
				</a>
				<a href="<?php echo SITE_ROOT."/home/notes?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="Create General Note">
					<i class="mdi-notification-folder-special"></i>
				</a>-->
				<a href="javascript:form_externalestimate()" style="float: right; margin-right: 20px;"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content strong" style="color:#b71c1c;background:#fff;"><?php echo $button; ?></span></h6></a>
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
					<form class="col s12" name="add_intnotes" id="add_intnotes">
						<div class="row">
							<div class="input-field col s12">
								<input type="text" tabindex="1" value="<?php if(isset($result['notes_name']))echo $result['notes_name'];?>" id="notes_name" name="notes_name" class="validate" placeholder="Notes Name">
								<!-- <label for="Date active">Date</label> -->
								<label for="notes_name">Notes Name</label>
								<input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">  
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<textarea type="text" tabindex="2" id="Room" name="Room" class="validate" ><?php if(isset($result['Room']))echo $result['Room'];?></textarea>
								<label for="Room">Room</label>
							</div>
							<div class="input-field col s6">
								<textarea type="text" tabindex="3" autocomplete="off" id="Size" name="Size" class="validate"><?php if(isset($result['Size']))echo $result['Size'];?></textarea>
								<label for="Size">Size</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s4">
								<textarea type="text" tabindex="4" value="" autocomplete="off" id="Furniture" name="Furniture" class="validate"><?php if(isset($result['Furniture']))echo $result['Furniture'];?></textarea>
								<label for="Furniture">Furniture</label>
							</div>
							<div class="input-field col s4">
								<textarea type="text" tabindex="5" value="" id="Window_Treatment" name="Window_Treatment" class="validate"><?php if(isset($result['Window_Treatment']))echo $result['Window_Treatment'];?></textarea>
								<label for="Window_Treatment">Window Treatment</label>
							</div>
							<div class="input-field col s4">
								<select class="" tabindex="6" name="furniture_hrs" tabindex="6" id="furniture_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="furniture_hrs">Furniture hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="7" value="" autocomplete="off" id="Mask" name="Mask" class="validate"><?php if(isset($result['Mask']))echo $result['Mask'];?></textarea>
								<label for="Mask">Mask</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="8" name="mask_hrs" id="mask_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="mask_hrs">Furniture hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="9" value="" autocomplete="off" id="Remove_WP" name="Remove_WP" class="validate" ><?php if(isset($result['Remove_WP']))echo $result['Remove_WP'];?></textarea>
								<label for="Remove_WP">Remove WP</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="10" name="remove_wp_hrs" id="remove_wp_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="remove_wp_hrs">Remove Wp hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="11" value="" autocomplete="off" id="Prep" name="Prep" class="validate"><?php if(isset($result['Prep']))echo $result['Prep'];?></textarea>
								<label for="Prep">Prep</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="12" name="prep_hrs" id="prep_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="prep_hrs">Prep hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="13" value="" id="Walls" name="Walls" class="validate" ><?php if(isset($result['Walls']))echo $result['Walls'];?></textarea>
								<label for="Walls">Walls</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="14" name="walls_hrs" id="walls_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="walls_hrs">Walls hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="15" value="" autocomplete="off" id="Ceiling" name="Ceiling" class="validate" ><?php if(isset($result['Ceiling']))echo $result['Ceiling'];?></textarea>
								<label for="Ceiling">Ceiling</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="16" name="ceiling_hrs" id="ceiling_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="ceiling_hrs">Ceiling hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="17" value="" id="Doors" name="Doors" class="validate"><?php if(isset($result['Doors']))echo $result['Doors'];?></textarea>
								<label for="Doors">Doors</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="18" name="doors_hrs" id="doors_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="doors_hrs">Doors hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="19" value="" autocomplete="off" id="Frames" name="Frames" class="validate"><?php if(isset($result['Frames']))echo $result['Frames'];?></textarea>
								<label for="Frames">Frames</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="20" name="frames_hrs" id="frames_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="frames_hrs">Frames hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="21" value="" id="French_Doors" name="French_Doors" class="validate"><?php if(isset($result['French_Doors']))echo $result['French_Doors'];?></textarea>
								<label for="French_Doors">French Doors</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="22" name="french_doors_hrs" id="french_doors_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="french_doors_hrs">French Doors hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="23" value="" id="Windows" name="Windows" class="validate"><?php if(isset($result['Windows']))echo $result['Windows'];?></textarea>
								<label for="Windows">Windows</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="24" name="windows_hrs" id="windows_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="windows_hrs">Windows hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="25" value="" autocomplete="off" id="French_Windows" name="French_Windows" class="validate" ><?php if(isset($result['French_Windows']))echo $result['French_Windows'];?></textarea>
								<label for="French_Windows">French Windows</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="26" name="french_windows_hrs" id="french_windows_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="french_windows_hrs">French Windows hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="27" value="" id="Cabinets" name="Cabinets" class="validate" ><?php if(isset($result['Cabinets']))echo $result['Cabinets'];?></textarea>
								<label for="Cabinets">Cabinets</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="28" name="cabinets_hrs" id="cabinets_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="cabinets_hrs">Cabinets hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="29" value="" autocomplete="off" id="Base" name="Base" class="validate"><?php if(isset($result['Base']))echo $result['Base'];?></textarea>
								<label for="Base">Base</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="30" name="base_hrs" id="base_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="base_hrs">Base hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="31" value="" id="Crown" name="Crown" class="validate"><?php if(isset($result['Crown']))echo $result['Crown'];?></textarea>
								<label for="Crown">Crown</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="32" name="crown_hrs" id="crown_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="crown_hrs">Crown hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s9">
								<textarea type="text" tabindex="33" value="" autocomplete="off" id="Closet" name="Closet" class="validate"><?php if(isset($result['Closet']))echo $result['Closet'];?></textarea>
								<label for="Closet">Closet</label>
							</div>
							<div class="input-field col s3">
								<select class="" tabindex="34" name="closet_hrs" id="closet_hrs">
									<option class="" value="">Select</option>
									<option class="" value="1">1</option>
									<option class="" value="2">2</option>
									<option class="" value="3">3</option>
									<option class="" value="4">4</option>
									<option class="" value="5">5</option>
									<option class="" value="6">6</option>
									<option class="" value="7">7</option>
									<option class="" value="8">8</option>
									<option class="" value="9">9</option>
									<option class="" value="10">10</option>
								</select>
								<label for="closet_hrs">Closet hrs</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea type="text" tabindex="35" id="Notes" name="Notes" class="validate"><?php if(isset($result['Notes']))echo $result['Notes'];?></textarea>
								<label for="Notes">Notes</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea type="text" tabindex="36" autocomplete="off" id="Description" name="Description" class="validate"><?php if(isset($result['Description']))echo $result['Description'];?></textarea>
								<label for="Description">Excl.</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12" style="text-align:center;">
								<input class="z-depth-1 waves-effect btn secondary-content strong" type="submit" id="submit" name="submit" value="<?php echo $button; ?>" style="background:#b71c1c; float:none; display:inline-block;">
							</div>
						</div>
					</form>
				</div>
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
 $('#intnotes').addClass('active');
});
$(function(){
	<?php if(isset($result['furniture_hrs'])){ ?>
	$("#furniture_hrs").val('<?php echo $result['furniture_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['mask_hrs'])){ ?>
	$("#mask_hrs").val('<?php echo $result['mask_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['remove_wp_hrs'])){ ?>
	$("#remove_wp_hrs").val('<?php echo $result['remove_wp_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['prep_hrs'])){ ?>
	$("#prep_hrs").val('<?php echo $result['prep_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['walls_hrs'])){ ?>
	$("#walls_hrs").val('<?php echo $result['walls_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['ceiling_hrs'])){ ?>
	$("#ceiling_hrs").val('<?php echo $result['ceiling_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['doors_hrs'])){ ?>
	$("#doors_hrs").val('<?php echo $result['doors_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['frames_hrs'])){ ?>
	$("#frames_hrs").val('<?php echo $result['frames_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['french_doors_hrs'])){ ?>
	$("#french_doors_hrs").val('<?php echo $result['french_doors_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['windows_hrs'])){ ?>
	$("#windows_hrs").val('<?php echo $result['windows_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['french_windows_hrs'])){ ?>
	$("#french_windows_hrs").val('<?php echo $result['french_windows_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['cabinets_hrs'])){ ?>
	$("#cabinets_hrs").val('<?php echo $result['cabinets_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['base_hrs'])){ ?>
	$("#base_hrs").val('<?php echo $result['base_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['crown_hrs'])){ ?>
	$("#crown_hrs").val('<?php echo $result['crown_hrs'];?>');
	<?php } ?>
	<?php if(isset($result['closet_hrs'])){ ?>
	$("#closet_hrs").val('<?php echo $result['closet_hrs'];?>');
	<?php } ?>
var vRules = {
	notes_name:{required:true}
};
var vMessages = {
	notes_name:{required:"Please enter notes name"}
};

$("#add_intnotes").validate({ 
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?= SITE_ROOT; ?>/home/addintnotes?project_id=<?php echo $_REQUEST['project_id']; ?>', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['success'])
				{		
					
					swal({   title: "Do you want to continue?",   
						 text: "Interior notes added. Do you want to create another notes?",   
						 type: "danger",   
						 showCancelButton: true,   
						 confirmButtonColor: "#DD6B55",   
						 confirmButtonText: "Yes",   
						 cancelButtonText: "No",   
						 closeOnConfirm: false,   
						 closeOnCancel: false }, 
						 function(isConfirm){   
							 if (isConfirm) {     
								 location.href = "<?= SITE_ROOT; ?>/home/internalnote?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
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
$("#headingSearchtitle").html("Interior Notes");
$("#interiorli").addClass("active");
   $("#interiorlidiv").show();
});
</script>