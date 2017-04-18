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

<?php 

$trackingid = $db->FetchCellValue("internal_hrs_tracking","id","project_id = '".$_REQUEST['project_id']."' && created_by = ".$_SESSION["samajadmin"]["id"]);
$label = "Add";
$button = "Update";
if(isset($trackingid) && $trackingid != ""){
	$label = "Edit";
	$button = "Update";
} 

$db = new Db();
$row = array();
$table88 = "internal_hrs_tracking";

if(isset($trackingid) && $trackingid != ""){
	$condition88 = "i.id = '".$trackingid."' ";
	$main_table88 = array("$table88 i",array("i.*"));
	$join_tables88 = array(
	);
	$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
	$row = mysql_fetch_array($rs1);
	//print_r($row);
}
?> 

<style>
table th,table td{
	background:white;
}
.specialclass.fixed,.specialclass2.fixed{
  top:64px;
  position:fixed;
  width:auto;
  display:none;
  border:none;
}
</style>
<script>
function form_internalestimate(){
	
	var poststring={};
	 $('table td').each(function(){
	  try{
	   if($(this).attr('field')!="")
	   {
		   
		poststring[$(this).attr('field')] = $(this).html();
	   }
	  }catch(err){}
	 });
	
	 poststring['project_id'] =  <?php echo $_REQUEST['project_id']; ?>;
	 poststring['Notes'] =  $("#Notes").val();
	 <?php if(isset($trackingid) && $trackingid != "" ){?>
		  poststring['id'] =  <?php echo $trackingid; ?>;
	<?php } ?>
	 console.log(poststring);
	
	 ignore = true;
	$.ajax({
		url: '<?php echo BASEPATH;?>/project/addinthrstracking',  
		type: 'post',
		cache: false,
		data: poststring,
		success: function (response) {                    
			var res = eval('('+response+')');
			if(res['success'] == "1"){
				window.location.reload();
			}
			
			//console.log(res->success);
		}
	}); 
}
</script>
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/mindmup-editabletable.js"></script>   
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/numeric-input-example.js"></script>
<div class="row">
	<div class="col s12 m12">
		<ul id="task-card" class="collection with-header" style="margin-bottom: 0px; border: 0px none;">
		<li class="collection-header" style="background:transparent;padding:0;">
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 600px);">
					<a data-delay="50" data-tooltip="Next To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#b71c1c;" class="mdi-hardware-keyboard-arrow-right"></i>
					</a>
					<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#b71c1c;" class="mdi-content-clear"></i>
					</a>
					<a data-delay="50" data-tooltip="Previous To Summary" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/external_summary?project_id=".$_REQUEST['project_id']; ?>">
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
					<a href="javascript:form_internalestimate()" style="float: right; margin-right: 13px;"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content strong" style="color:#B71C1C;background:white;"><?php echo $button; ?></span></h6></a>
				</div>
			</li>
		</ul>
	</div>
</div>
<div class="col s12 m12 l12">
<div class="card-panel" style="margin-top: 0px; padding-top: 0px; padding-bottom: 0px;">
	<div id="row-grouping" class="section" style="padding-top: 0px;">
		<div class="row">
			<div class="col s12 m12" style="margin-top: 20px;">
				<table id="mainTable" class="table table-striped specialclass2" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
					<thead>
						<tr>
							<th class="greyclr">Task or Surface</th>
							<th class="greyclr">Est. Hrs</th>
							<th class="greyclr">CL Est Hrs</th>
							<th class="greyclr">Act Hrs</th>
							<th class="greyclr">Est Gal</th>
							<th class="greyclr">Act Gal</th>
							<th class="greyclr">Notes</th>
						</tr>
					</thead>
						<tbody>
							<tr>
								<td class="edit-disabled">Furniture Treatment</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(furniture_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Furniture_Treatment_CL_Est_Hrs"><?php if(isset($row['Furniture_Treatment_CL_Est_Hrs']))echo $row['Furniture_Treatment_CL_Est_Hrs'];?></td>
								<td class="" field="Furniture_Treatment_Act_Hrs"><?php if(isset($row['Furniture_Treatment_Act_Hrs']))echo $row['Furniture_Treatment_Act_Hrs'];?></td>
								<td class="" field="Furniture_Treatment_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(furniture_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Furniture_Treatment_Act_Gal"><?php if(isset($row['Furniture_Treatment_Act_Gal']))echo $row['Furniture_Treatment_Act_Gal'];?></td>
								<td class="" field="Furniture_Treatment_Notes"><?php if(isset($row['Furniture_Treatment_Notes']))echo $row['Furniture_Treatment_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Mask & Cover</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(maskcover_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Mask_Cover_CL_Est_Hrs"><?php if(isset($row['Mask_Cover_CL_Est_Hrs']))echo $row['Mask_Cover_CL_Est_Hrs'];?></td>
								<td class="" field="Mask_Cover_Act_Hrs"><?php if(isset($row['Mask_Cover_Act_Hrs']))echo $row['Mask_Cover_Act_Hrs'];?></td>
								<td class="" field="Mask_Cover_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(maskcover_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Mask_Cover_Act_Gal"><?php if(isset($row['Mask_Cover_Act_Gal']))echo $row['Mask_Cover_Act_Gal'];?></td>
								<td class="" field="Mask_Cover_Notes"><?php if(isset($row['Mask_Cover_Notes']))echo $row['Mask_Cover_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Wallpaper Removal</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(wallpaper_removal_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Wallpaper_Removal_CL_Est_Hrs"><?php if(isset($row['Wallpaper_Removal_CL_Est_Hrs']))echo $row['Wallpaper_Removal_CL_Est_Hrs'];?></td>
								<td class="" field="Wallpaper_Removal_Act_Hrs"><?php if(isset($row['Wallpaper_Removal_Act_Hrs']))echo $row['Wallpaper_Removal_Act_Hrs'];?></td>
								<td class="" field="Wallpaper_Removal_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(wallpaper_removal_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Wallpaper_Removal_Act_Gal"><?php if(isset($row['Wallpaper_Removal_Act_Gal']))echo $row['Wallpaper_Removal_Act_Gal'];?></td>
								<td class="" field="Wallpaper_Removal_Notes"><?php if(isset($row['Wallpaper_Removal_Notes']))echo $row['Wallpaper_Removal_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">R&R Hardware & Lighting</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(rrhardware_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="RR_Hardware_Lighting_CL_Est_Hrs"><?php if(isset($row['RR_Hardware_Lighting_CL_Est_Hrs']))echo $row['RR_Hardware_Lighting_CL_Est_Hrs'];?></td>
								<td class="" field="RR_Hardware_Lighting_Act_Hrs"><?php if(isset($row['RR_Hardware_Lighting_Act_Hrs']))echo $row['RR_Hardware_Lighting_Act_Hrs'];?></td>
								<td class="" field="RR_Hardware_Lighting_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(rrhardware_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="RR_Hardware_Lighting_Act_Gal"><?php if(isset($row['RR_Hardware_Lighting_Act_Gal']))echo $row['RR_Hardware_Lighting_Act_Gal'];?></td>
								<td class="" field="RR_Hardware_Lighting_Notes"><?php if(isset($row['RR_Hardware_Lighting_Notes']))echo $row['RR_Hardware_Lighting_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Prep Woodwork</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(prepwoodwork_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Prep_Woodwork_CL_Est_Hrs"><?php if(isset($row['Prep_Woodwork_CL_Est_Hrs']))echo $row['Prep_Woodwork_CL_Est_Hrs'];?></td>
								<td class="" field="Prep_Woodwork_Act_Hrs"><?php if(isset($row['Prep_Woodwork_Act_Hrs']))echo $row['Prep_Woodwork_Act_Hrs'];?></td>
								<td class="" field="Prep_Woodwork_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(prepwoodwork_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Prep_Woodwork_Act_Gal"><?php if(isset($row['Prep_Woodwork_Act_Gal']))echo $row['Prep_Woodwork_Act_Gal'];?></td>
								<td class="" field="Prep_Woodwork_Notes"><?php if(isset($row['Prep_Woodwork_Notes']))echo $row['Prep_Woodwork_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Patch & Texture</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(patchtexture_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Patch_Texture_CL_Est_Hrs"><?php if(isset($row['Patch_Texture_CL_Est_Hrs']))echo $row['Patch_Texture_CL_Est_Hrs'];?></td>
								<td class="" field="Patch_Texture_Act_Hrs"><?php if(isset($row['Patch_Texture_Act_Hrs']))echo $row['Patch_Texture_Act_Hrs'];?></td>
								<td class="" field="Patch_Texture_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(patchtexture_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Patch_Texture_Act_Gal"><?php if(isset($row['Patch_Texture_Act_Gal']))echo $row['Patch_Texture_Act_Gal'];?></td>
								<td class="" field="Patch_Texture_Notes"><?php if(isset($row['Patch_Texture_Notes']))echo $row['Patch_Texture_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Skim Coat</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(skimcoat_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Skim_Coat_CL_Est_Hrs"><?php if(isset($row['Skim_Coat_CL_Est_Hrs']))echo $row['Skim_Coat_CL_Est_Hrs'];?></td>
								<td class="" field="Skim_Coat_Act_Hrs"><?php if(isset($row['Skim_Coat_Act_Hrs']))echo $row['Skim_Coat_Act_Hrs'];?></td>
								<td class="" field="Skim_Coat_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(skimcoat_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Skim_Coat_Act_Gal"><?php if(isset($row['Skim_Coat_Act_Gal']))echo $row['Skim_Coat_Act_Gal'];?></td>
								<td class="" field="Skim_Coat_Notes"><?php if(isset($row['Skim_Coat_Notes']))echo $row['Skim_Coat_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Pole Sand Walls</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(polesand_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Pole_Sand_Walls_CL_Est_Hrs"><?php if(isset($row['Pole_Sand_Walls_CL_Est_Hrs']))echo $row['Pole_Sand_Walls_CL_Est_Hrs'];?></td>
								<td class="" field="Pole_Sand_Walls_Act_Hrs"><?php if(isset($row['Pole_Sand_Walls_Act_Hrs']))echo $row['Pole_Sand_Walls_Act_Hrs'];?></td>
								<td class="" field="Pole_Sand_Walls_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(polesand_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Pole_Sand_Walls_Act_Gal"><?php if(isset($row['Pole_Sand_Walls_Act_Gal']))echo $row['Pole_Sand_Walls_Act_Gal'];?></td>
								<td class="" field="Pole_Sand_Walls_Notes"><?php if(isset($row['Pole_Sand_Walls_Notes']))echo $row['Pole_Sand_Walls_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Walls: Prime</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(wprime_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Walls_Prime_CL_Est_Hrs"><?php if(isset($row['Walls_Prime_CL_Est_Hrs']))echo $row['Walls_Prime_CL_Est_Hrs'];?></td>
								<td class="" field="Walls_Prime_Act_Hrs"><?php if(isset($row['Walls_Prime_Act_Hrs']))echo $row['Walls_Prime_Act_Hrs'];?></td>
								<td class="" field="Walls_Prime_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(wprime_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Walls_Prime_Act_Gal"><?php if(isset($row['Walls_Prime_Act_Gal']))echo $row['Walls_Prime_Act_Gal'];?></td>
								<td class="" field="Walls_Prime_Notes"><?php if(isset($row['Walls_Prime_Notes']))echo $row['Walls_Prime_Notes'];?></td>
							</tr>
							
							
							<tr>
								<td class="edit-disabled">Walls -</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(wpaint09_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(wpaint9_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Walls_CL_Est_Hrs"><?php if(isset($row['Walls_CL_Est_Hrs']))echo $row['Walls_CL_Est_Hrs'];?></td>
								<td class="" field="Walls_Act_Hrs"><?php if(isset($row['Walls_Act_Hrs']))echo $row['Walls_Act_Hrs'];?></td>
								<td class="" field="Walls_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(wpaint09_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(wpaint9_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Walls_Act_Gal"><?php if(isset($row['Walls_Act_Gal']))echo $row['Walls_Act_Gal'];?></td>
								<td class="" field="Walls_Notes"><?php if(isset($row['Walls_Notes']))echo $row['Walls_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Ceilings: Prime</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(cprime_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Ceilings_Prime_CL_Est_Hrs"><?php if(isset($row['Ceilings_Prime_CL_Est_Hrs']))echo $row['Ceilings_Prime_CL_Est_Hrs'];?></td>
								<td class="" field="Ceilings_Prime_Act_Hrs"><?php if(isset($row['Ceilings_Prime_Act_Hrs']))echo $row['Ceilings_Prime_Act_Hrs'];?></td>
								<td class="" field="Ceilings_Prime_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(cprime_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Ceilings_Prime_Act_Gal"><?php if(isset($row['Ceilings_Prime_Act_Gal']))echo $row['Ceilings_Prime_Act_Gal'];?></td>
								<td class="" field="Ceilings_Prime_Notes"><?php if(isset($row['Ceilings_Prime_Notes']))echo $row['Ceilings_Prime_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Ceilings -</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(cpaint_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(cw_time_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Ceilings_CL_Est_Hrs"><?php if(isset($row['Ceilings_CL_Est_Hrs']))echo $row['Ceilings_CL_Est_Hrs'];?></td>
								<td class="" field="Ceilings_Act_Hrs"><?php if(isset($row['Ceilings_Act_Hrs']))echo $row['Ceilings_Act_Hrs'];?></td>
								<td class="" field="Ceilings_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(cpaint_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(cw_time_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Ceilings_Act_Gal"><?php if(isset($row['Ceilings_Act_Gal']))echo $row['Ceilings_Act_Gal'];?></td>
								<td class="" field="Ceilings_Notes"><?php if(isset($row['Ceilings_Notes']))echo $row['Ceilings_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Doors & Frames</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(dflat_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(dpaneled_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(dfrench_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(dframes_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(dtime_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Doors_Frames_CL_Est_Hrs"><?php if(isset($row['Doors_Frames_CL_Est_Hrs']))echo $row['Doors_Frames_CL_Est_Hrs'];?></td>
								<td class="" field="Doors_Frames_Act_Hrs"><?php if(isset($row['Doors_Frames_Act_Hrs']))echo $row['Doors_Frames_Act_Hrs'];?></td>
								<td class="" field="Doors_Frames_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(dflat_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(dpaneled_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(dfrench_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(dframes_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(dtime_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Doors_Frames_Act_Gal"><?php if(isset($row['Doors_Frames_Act_Gal']))echo $row['Doors_Frames_Act_Gal'];?></td>
								<td class="" field="Doors_Frames_Notes"><?php if(isset($row['Doors_Frames_Notes']))echo $row['Doors_Frames_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Windows</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(wcasement_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(w1_1_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(w3_7_panel_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(w8_16_panel_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(w16_panel_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(wtime_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Windows_CL_Est_Hrs"><?php if(isset($row['Windows_CL_Est_Hrs']))echo $row['Windows_CL_Est_Hrs'];?></td>
								<td class="" field="Windows_Act_Hrs"><?php if(isset($row['Windows_Act_Hrs']))echo $row['Windows_Act_Hrs'];?></td>
								<td class="" field="Windows_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(wcasement_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(w1_1_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(w3_7_panel_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(w8_16_panel_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(w16_panel_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(wtime_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Windows_Act_Gal"><?php if(isset($row['Windows_Act_Gal']))echo $row['Windows_Act_Gal'];?></td>
								<td class="" field="Windows_Notes"><?php if(isset($row['Windows_Notes']))echo $row['Windows_Notes'];?></td>
							</tr>
							
							
							
							<tr>
								<td class="edit-disabled">Baseboards</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(baseboards_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(baseboardstime_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Baseboards_CL_Est_Hrs"><?php if(isset($row['Baseboards_CL_Est_Hrs']))echo $row['Baseboards_CL_Est_Hrs'];?></td>
								<td class="" field="Baseboards_Act_Hrs"><?php if(isset($row['Baseboards_Act_Hrs']))echo $row['Baseboards_Act_Hrs'];?></td>
								<td class="" field="Baseboards_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(baseboards_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(baseboardstime_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Baseboards_Act_Gal"><?php if(isset($row['Baseboards_Act_Gal']))echo $row['Baseboards_Act_Gal'];?></td>
								<td class="" field="Baseboards_Notes"><?php if(isset($row['Baseboards_Notes']))echo $row['Baseboards_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Chair Rail</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(chairrail_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(chairrail_time_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Chair_Rail_CL_Est_Hrs"><?php if(isset($row['Chair_Rail_CL_Est_Hrs']))echo $row['Chair_Rail_CL_Est_Hrs'];?></td>
								<td class="" field="Chair_Rail_Act_Hrs"><?php if(isset($row['Chair_Rail_Act_Hrs']))echo $row['Chair_Rail_Act_Hrs'];?></td>
								<td class="" field="Chair_Rail_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(chairrail_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(chairrail_time_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Chair_Rail_Act_Gal"><?php if(isset($row['Chair_Rail_Act_Gal']))echo $row['Chair_Rail_Act_Gal'];?></td>
								<td class="" field="Chair_Rail_Notes"><?php if(isset($row['Chair_Rail_Notes']))echo $row['Chair_Rail_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Crown Molding</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(crownmolding_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(crownmolding_time_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Crown_Molding_CL_Est_Hrs"><?php if(isset($row['Crown_Molding_CL_Est_Hrs']))echo $row['Crown_Molding_CL_Est_Hrs'];?></td>
								<td class="" field="Crown_Molding_Act_Hrs"><?php if(isset($row['Crown_Molding_Act_Hrs']))echo $row['Crown_Molding_Act_Hrs'];?></td>
								<td class="" field="Crown_Molding_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(crownmolding_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(crownmolding_time_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Crown_Molding_Act_Gal"><?php if(isset($row['Crown_Molding_Act_Gal']))echo $row['Crown_Molding_Act_Gal'];?></td>
								<td class="" field="Crown_Molding_Notes"><?php if(isset($row['Crown_Molding_Notes']))echo $row['Crown_Molding_Notes'];?></td>
							</tr>
							
							<tr>
								<td class="edit-disabled">Closets</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(closets_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Closets_CL_Est_Hrs"><?php if(isset($row['Closets_CL_Est_Hrs']))echo $row['Closets_CL_Est_Hrs'];?></td>
								<td class="" field="Closets_Act_Hrs"><?php if(isset($row['Closets_Act_Hrs']))echo $row['Closets_Act_Hrs'];?></td>
								<td class="" field="Closets_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(closets_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Closets_Act_Gal"><?php if(isset($row['Closets_Act_Gal']))echo $row['Closets_Act_Gal'];?></td>
								<td class="" field="Closets_Notes"><?php if(isset($row['Closets_Notes']))echo $row['Closets_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Cabinetry</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(cabinetry_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Cabinetry_CL_Est_Hrs"><?php if(isset($row['Cabinetry_CL_Est_Hrs']))echo $row['Cabinetry_CL_Est_Hrs'];?></td>
								<td class="" field="Cabinetry_Act_Hrs"><?php if(isset($row['Cabinetry_Act_Hrs']))echo $row['Cabinetry_Act_Hrs'];?></td>
								<td class="" field="Cabinetry_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(cabinetry_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Cabinetry_Act_Gal"><?php if(isset($row['Cabinetry_Act_Gal']))echo $row['Cabinetry_Act_Gal'];?></td>
								<td class="" field="Cabinetry_Notes"><?php if(isset($row['Cabinetry_Notes']))echo $row['Cabinetry_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Clean and Touchup</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(cleantouchup_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Clean_and_Touchup_CL_Est_Hrs"><?php if(isset($row['Clean_and_Touchup_CL_Est_Hrs']))echo $row['Clean_and_Touchup_CL_Est_Hrs'];?></td>
								<td class="" field="Clean_and_Touchup_Act_Hrs"><?php if(isset($row['Clean_and_Touchup_Act_Hrs']))echo $row['Clean_and_Touchup_Act_Hrs'];?></td>
								<td class="" field="Clean_and_Touchup_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(cleantouchup_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Clean_and_Touchup_Act_Gal"><?php if(isset($row['Clean_and_Touchup_Act_Gal']))echo $row['Clean_and_Touchup_Act_Gal'];?></td>
								<td class="" field="Clean_and_Touchup_Notes"><?php if(isset($row['Clean_and_Touchup_Notes']))echo $row['Clean_and_Touchup_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Faux/Mural</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(faux_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Faux_Mural_CL_Est_Hrs"><?php if(isset($row['Faux_Mural_CL_Est_Hrs']))echo $row['Faux_Mural_CL_Est_Hrs'];?></td>
								<td class="" field="Faux_Mural_Act_Hrs"><?php if(isset($row['Faux_Mural_Act_Hrs']))echo $row['Faux_Mural_Act_Hrs'];?></td>
								<td class="" field="Faux_Mural_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(faux_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Faux_Mural_Act_Gal"><?php if(isset($row['Faux_Mural_Act_Gal']))echo $row['Faux_Mural_Act_Gal'];?></td>
								<td class="" field="Faux_Mural_Notes"><?php if(isset($row['Faux_Mural_Notes']))echo $row['Faux_Mural_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Miscellaneous</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("internal_estimate","sum(miscellaneous1_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(miscellaneous2_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(miscellaneous3_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Miscellaneous_CL_Est_Hrs"><?php if(isset($row['Miscellaneous_CL_Est_Hrs']))echo $row['Miscellaneous_CL_Est_Hrs'];?></td>
								<td class="" field="Miscellaneous_Act_Hrs"><?php if(isset($row['Miscellaneous_Act_Hrs']))echo $row['Miscellaneous_Act_Hrs'];?></td>
								<td class="" field="Miscellaneous_Est_Gal"><?php echo $db->FetchCellValue("internal_estimate","sum(miscellaneous1_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(miscellaneous2_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("internal_estimate","sum(miscellaneous3_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Miscellaneous_Act_Gal"><?php if(isset($row['Miscellaneous_Act_Gal']))echo $row['Miscellaneous_Act_Gal'];?></td>
								<td class="" field="Miscellaneous_Notes"><?php if(isset($row['Miscellaneous_Notes']))echo $row['Miscellaneous_Notes'];?></td>
							</tr>
						
							<tr> 
								<th class="greyclr">
									<strong>TOTAL DAILY MAN HRS</strong>
								</th>
								<th class="greyclr"></th>
								<th class="greyclr"></th>
								<th class="greyclr"></th>
								<th class="greyclr"></th>
								<th class="greyclr"></th>
								<th class="greyclr"></th> 
							</tr>
						</tbody>
					</table>
					<div class="col s12 m12 input-field" style="padding: 0px; margin: 30px 0px;">
					<textarea id="Notes" class="validate" type="text" value="" autocomplete="off" name="Notes"><?php if(isset($row['Notes']))echo $row['Notes'];?></textarea>
					<label for="Notes">Notes</label>
					</div>
				<div class="input-field col s12" style="padding: 0px; text-align:center;" >
				   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C; display:inline-block; float:none;">
					<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?>" name="submit">
				   </i>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
$('#mainTable').editableTableWidget({disableClass: "edit-disabled"});
$(function(){
 $('#inthours').addClass('active');
	$("#headingSearchtitle").html("Interior Hours Tracking");
});
$(function () {
   $.fn.fixMe = function() {
      return this.each(function() {
         var $this = $(this),
            $t_fixed;
         function init() {
            $this.wrap('<div class="container" />');
            $t_fixed = $this.clone();
            $t_fixed.find("tbody").remove().end().addClass("fixed").insertBefore($this);
            resizeFixed();
         }
         function resizeFixed() {
            $t_fixed.find("th").each(function(index) {
               $(this).css("width",$this.find("th").eq(index).outerWidth()+"px");
            });
         }
         function scrollFixed() {
            var offset = $(this).scrollTop(),
            tableOffsetTop = $this.offset().top,
            tableOffsetBottom = tableOffsetTop + $this.height() - $this.find("thead").height();
            if(offset < tableOffsetTop || offset > tableOffsetBottom)
               $t_fixed.hide();
            else if(offset >= tableOffsetTop && offset <= tableOffsetBottom && $t_fixed.is(":hidden"))
               $t_fixed.show();
         }
         $(window).resize(resizeFixed);
         $(window).scroll(scrollFixed);
         init();
      });
   };
});

$(document).ready(function(){
   //$(".specialclass").fixMe();
   $(".specialclass2").fixMe();
   $("#interiorli").addClass("active");
   $("#interiorlidiv").show();
});
</script>