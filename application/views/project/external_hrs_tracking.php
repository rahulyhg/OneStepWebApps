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

$trackingid = $db->FetchCellValue("external_hrs_tracking","id","project_id = '".$_REQUEST['project_id']."' && created_by = ".$_SESSION["samajadmin"]["id"]);
$label = "Add";
$button = "Update";
if(isset($trackingid) && $trackingid != ""){
	$label = "Edit";
	$button = "Update";
} 

$db = new Db();
$row = array();
$table88 = "external_hrs_tracking";

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
		url: '<?php echo BASEPATH;?>/project/addexthrstracking',  
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
						<i style="color:#00695C;" class="mdi-hardware-keyboard-arrow-right"></i>
					</a>
					<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#00695C;" class="mdi-content-clear"></i>
					</a>
					<a data-delay="50" data-tooltip="Previous To Summary" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/external_summary?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#00695C;" class="mdi-hardware-keyboard-arrow-left"></i>
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
					<a href="javascript:form_internalestimate()" style="float: right; margin-right: 13px;"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content strong" style="color:#00695C;background:#fff;"><?php echo $button; ?></span></h6></a>
				</div>
			</li>
		</ul>
	</div>
</div>
<div class="col s12 m12 l12">
<div class="card-panel" style="margin-top: 0px; padding-top: 0px; padding-bottom: 0px; margin-bottom: 0px;">
	<div id="row-grouping" class="section" style="padding-top:0px;">
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
								<td class="edit-disabled">Scraping & Sanding</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(scraping_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Scraping_Sanding_CL_Est_Hrs"><?php if(isset($row['Scraping_Sanding_CL_Est_Hrs']))echo $row['Scraping_Sanding_CL_Est_Hrs'];?></td>
								<td class="" field="Scraping_Sanding_Act_Hrs"><?php if(isset($row['Scraping_Sanding_Act_Hrs']))echo $row['Scraping_Sanding_Act_Hrs'];?></td>
								<td class="" field="Scraping_Sanding_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(scraping_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Scraping_Sanding_Act_Gal"><?php if(isset($row['Scraping_Sanding_Act_Gal']))echo $row['Scraping_Sanding_Act_Gal'];?></td>
								<td class="" field="Scraping_Sanding__Notes"><?php if(isset($row['Scraping_Sanding__Notes']))echo $row['Scraping_Sanding__Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Patch Stucco</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(patch_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Patch_Stucco_CL_Est_Hrs"><?php if(isset($row['Patch_Stucco_CL_Est_Hrs']))echo $row['Patch_Stucco_CL_Est_Hrs'];?></td>
								<td class="" field="Patch_Stucco_Act_Hrs"><?php if(isset($row['Patch_Stucco_Act_Hrs']))echo $row['Patch_Stucco_Act_Hrs'];?></td>
								<td class="" field="Patch_Stucco_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(patch_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Patch_Stucco_Act_Gal"><?php if(isset($row['Patch_Stucco_Act_Gal']))echo $row['Patch_Stucco_Act_Gal'];?></td>
								<td class="" field="Patch_Stucco_Notes"><?php if(isset($row['Patch_Stucco_Notes']))echo $row['Patch_Stucco_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Feather Sanding</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(feather_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Feather_Sanding_CL_Est_Hrs"><?php if(isset($row['Feather_Sanding_CL_Est_Hrs']))echo $row['Feather_Sanding_CL_Est_Hrs'];?></td>
								<td class="" field="Feather_Sanding_Act_Hrs"><?php if(isset($row['Feather_Sanding_Act_Hrs']))echo $row['Feather_Sanding_Act_Hrs'];?></td>
								<td class="" field="Feather_Sanding_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(feather_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Feather_Sanding_Act_Gal"><?php if(isset($row['Feather_Sanding_Act_Gal']))echo $row['Feather_Sanding_Act_Gal'];?></td>
								<td class="" field="Feather_Sanding_Notes"><?php if(isset($row['Feather_Sanding_Notes']))echo $row['Feather_Sanding_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Flexible Epoxy</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(flexible_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Flexible_Epoxy_CL_Est_Hrs"><?php if(isset($row['Flexible_Epoxy_CL_Est_Hrs']))echo $row['Flexible_Epoxy_CL_Est_Hrs'];?></td>
								<td class="" field="Flexible_Epoxy_Act_Hrs"><?php if(isset($row['Flexible_Epoxy_Act_Hrs']))echo $row['Flexible_Epoxy_Act_Hrs'];?></td>
								<td class="" field="Flexible_Epoxy_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(flexible_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Flexible_Epoxy_Act_Gal"><?php if(isset($row['Flexible_Epoxy_Act_Gal']))echo $row['Flexible_Epoxy_Act_Gal'];?></td>
								<td class="" field="Flexible_Epoxy_Notes"><?php if(isset($row['Flexible_Epoxy_Notes']))echo $row['Flexible_Epoxy_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Caulking</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(caulking_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Caulking_CL_Est_Hrs"><?php if(isset($row['Caulking_CL_Est_Hrs']))echo $row['Caulking_CL_Est_Hrs'];?></td>
								<td class="" field="Caulking_Act_Hrs"><?php if(isset($row['Caulking_Act_Hrs']))echo $row['Caulking_Act_Hrs'];?></td>
								<td class="" field="Caulking_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(caulking_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Caulking_Act_Gal"><?php if(isset($row['Caulking_Act_Gal']))echo $row['Caulking_Act_Gal'];?></td>
								<td class="" field="Caulking_Notes"><?php if(isset($row['Caulking_Notes']))echo $row['Caulking_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Pressure Wash</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(pressure_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Pressure_Wash_CL_Est_Hrs"><?php if(isset($row['Pressure_Wash_CL_Est_Hrs']))echo $row['Pressure_Wash_CL_Est_Hrs'];?></td>
								<td class="" field="Pressure_Wash_Act_Hrs"><?php if(isset($row['Pressure_Wash_Act_Hrs']))echo $row['Pressure_Wash_Act_Hrs'];?></td>
								<td class="" field="Pressure_Wash_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(pressure_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Pressure_Wash_Act_Gal"><?php if(isset($row['Pressure_Wash_Act_Gal']))echo $row['Pressure_Wash_Act_Gal'];?></td>
								<td class="" field="Pressure_Wash_Notes"><?php if(isset($row['Pressure_Wash_Notes']))echo $row['Pressure_Wash_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Roof/Ladder Time</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(roof_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Roof_Ladder_Time_CL_Est_Hrs"><?php if(isset($row['Roof_Ladder_Time_CL_Est_Hrs']))echo $row['Roof_Ladder_Time_CL_Est_Hrs'];?></td>
								<td class="" field="Roof_Ladder_Time_Act_Hrs"><?php if(isset($row['Roof_Ladder_Time_Act_Hrs']))echo $row['Roof_Ladder_Time_Act_Hrs'];?></td>
								<td class="" field="Roof_Ladder_Time_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(roof_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Roof_Ladder_Time_Act_Gal"><?php if(isset($row['Roof_Ladder_Time_Act_Gal']))echo $row['Roof_Ladder_Time_Act_Gal'];?></td>
								<td class="" field="Roof_Ladder_Time_Notes"><?php if(isset($row['Roof_Ladder_Time_Notes']))echo $row['Roof_Ladder_Time_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Spot Prime</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(spot_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Spot_Prime_CL_Est_Hrs"><?php if(isset($row['Spot_Prime_CL_Est_Hrs']))echo $row['Spot_Prime_CL_Est_Hrs'];?></td>
								<td class="" field="Spot_Prime_Act_Hrs"><?php if(isset($row['Spot_Prime_Act_Hrs']))echo $row['Spot_Prime_Act_Hrs'];?></td>
								<td class="" field="Spot_Prime_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(spot_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Spot_Prime_Act_Gal"><?php if(isset($row['Spot_Prime_Act_Gal']))echo $row['Spot_Prime_Act_Gal'];?></td>
								<td class="" field="Spot_Prime_Notes"><?php if(isset($row['Spot_Prime_Notes']))echo $row['Spot_Prime_Notes'];?></td>
							</tr>
							
							<tr>
								<td class="edit-disabled">Remove/Replace</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(remove_lights_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(remove_screens_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(remove_other_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Remove_Replace_CL_Est_Hrs"><?php if(isset($row['Remove_Replace_CL_Est_Hrs']))echo $row['Remove_Replace_CL_Est_Hrs'];?></td>
								<td class="" field="Remove_Replace_Act_Hrs"><?php if(isset($row['Remove_Replace_Act_Hrs']))echo $row['Remove_Replace_Act_Hrs'];?></td>
								<td class="" field="Remove_Replace_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(remove_lights_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(remove_screens_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(remove_other_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Remove_Replace_Act_Gal"><?php if(isset($row['Remove_Replace_Act_Gal']))echo $row['Remove_Replace_Act_Gal'];?></td>
								<td class="" field="Remove_Replace_Notes"><?php if(isset($row['Remove_Replace_Notes']))echo $row['Remove_Replace_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Wash Windows</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(wash_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Wash_Windows_CL_Est_Hrs"><?php if(isset($row['Wash_Windows_CL_Est_Hrs']))echo $row['Wash_Windows_CL_Est_Hrs'];?></td>
								<td class="" field="Wash_Windows_Act_Hrs"><?php if(isset($row['Wash_Windows_Act_Hrs']))echo $row['Wash_Windows_Act_Hrs'];?></td>
								<td class="" field="Wash_Windows_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(wash_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Wash_Windows_Act_Gal"><?php if(isset($row['Wash_Windows_Act_Gal']))echo $row['Wash_Windows_Act_Gal'];?></td>
								<td class="" field="Wash_Windows_Notes"><?php if(isset($row['Wash_Windows_Notes']))echo $row['Wash_Windows_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Pressure Wash Deck</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(pressurewashdeck_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Pressure_Wash_Deck_CL_Est_Hrs"><?php if(isset($row['Pressure_Wash_Deck_CL_Est_Hrs']))echo $row['Pressure_Wash_Deck_CL_Est_Hrs'];?></td>
								<td class="" field="Pressure_Wash_Deck_Act_Hrs"><?php if(isset($row['Pressure_Wash_Deck_Act_Hrs']))echo $row['Pressure_Wash_Deck_Act_Hrs'];?></td>
								<td class="" field="Pressure_Wash_Deck_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(pressurewashdeck_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Pressure_Wash_Deck_Act_Gal"><?php if(isset($row['Pressure_Wash_Deck_Act_Gal']))echo $row['Pressure_Wash_Deck_Act_Gal'];?></td>
								<td class="" field="Pressure_Wash_Deck_Notes"><?php if(isset($row['Pressure_Wash_Deck_Notes']))echo $row['Pressure_Wash_Deck_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Mask (Windows & Doors)</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(maskwindowsdoors_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Mask_Windows_Doors_CL_Est_Hrs"><?php if(isset($row['Mask_Windows_Doors_CL_Est_Hrs']))echo $row['Mask_Windows_Doors_CL_Est_Hrs'];?></td>
								<td class="" field="Mask_Windows_Doors_Act_Hrs"><?php if(isset($row['Mask_Windows_Doors_Act_Hrs']))echo $row['Mask_Windows_Doors_Act_Hrs'];?></td>
								<td class="" field="Mask_Windows_Doors_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(maskwindowsdoors_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Mask_Windows_Doors_Act_Gal"><?php if(isset($row['Mask_Windows_Doors_Act_Gal']))echo $row['Mask_Windows_Doors_Act_Gal'];?></td>
								<td class="" field="Mask_Windows_Doors_Notes"><?php if(isset($row['Mask_Windows_Doors_Notes']))echo $row['Mask_Windows_Doors_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Mask (Other)</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(maskother_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Mask_Other_CL_Est_Hrs"><?php if(isset($row['Mask_Other_CL_Est_Hrs']))echo $row['Mask_Other_CL_Est_Hrs'];?></td>
								<td class="" field="Mask_Other_Act_Hrs"><?php if(isset($row['Mask_Other_Act_Hrs']))echo $row['Mask_Other_Act_Hrs'];?></td>
								<td class="" field="Mask_Other_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(maskother_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Mask_Other_Act_Gal"><?php if(isset($row['Mask_Other_Act_Gal']))echo $row['Mask_Other_Act_Gal'];?></td>
								<td class="" field="Mask_Other_Notes"><?php if(isset($row['Mask_Other_Notes']))echo $row['Mask_Other_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Eaves </td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(eavessingle_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(eavestwo_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(eaveseasy_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(eaveshard_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Eaves_CL_Est_Hrs"><?php if(isset($row['Eaves_CL_Est_Hrs']))echo $row['Eaves_CL_Est_Hrs'];?></td>
								<td class="" field="Eaves_Act_Hrs"><?php if(isset($row['Eaves_Act_Hrs']))echo $row['Eaves_Act_Hrs'];?></td>
								<td class="" field="Eaves_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(eavessingle_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(eavestwo_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(eaveseasy_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(eaveshard_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Eaves_Act_Gal"><?php if(isset($row['Eaves_Act_Gal']))echo $row['Eaves_Act_Gal'];?></td>
								<td class="" field="Eaves_Notes"><?php if(isset($row['Eaves_Notes']))echo $row['Eaves_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Fascia</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(fasciasingle_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(fasciatwo_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Fascia_CL_Est_Hrs"><?php if(isset($row['Fascia_CL_Est_Hrs']))echo $row['Fascia_CL_Est_Hrs'];?></td>
								<td class="" field="Fascia_Act_Hrs"><?php if(isset($row['Fascia_Act_Hrs']))echo $row['Fascia_Act_Hrs'];?></td>
								<td class="" field="Fascia_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(fasciasingle_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(fasciatwo_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Fascia_Act_Gal"><?php if(isset($row['Fascia_Act_Gal']))echo $row['Fascia_Act_Gal'];?></td>
								<td class="" field="Fascia_Notes"><?php if(isset($row['Fascia_Notes']))echo $row['Fascia_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Metal Flashing</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(metalflashing_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Metal_Flashing_CL_Est_Hrs"><?php if(isset($row['Metal_Flashing_CL_Est_Hrs']))echo $row['Metal_Flashing_CL_Est_Hrs'];?></td>
								<td class="" field="Metal_Flashing_Act_Hrs"><?php if(isset($row['Metal_Flashing_Act_Hrs']))echo $row['Metal_Flashing_Act_Hrs'];?></td>
								<td class="" field="Metal_Flashing_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(metalflashing_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Metal_Flashing_Act_Gal"><?php if(isset($row['Metal_Flashing_Act_Gal']))echo $row['Metal_Flashing_Act_Gal'];?></td>
								<td class="" field="Metal_Flashing_Notes"><?php if(isset($row['Metal_Flashing_Notes']))echo $row['Metal_Flashing_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Rain Gutters & Downspouts</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(raingutters_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Rain_Gutters_Downspouts_CL_Est_Hrs"><?php if(isset($row['Rain_Gutters_Downspouts_CL_Est_Hrs']))echo $row['Rain_Gutters_Downspouts_CL_Est_Hrs'];?></td>
								<td class="" field="Rain_Gutters_Downspouts_Act_Hrs"><?php if(isset($row['Rain_Gutters_Downspouts_Act_Hrs']))echo $row['Rain_Gutters_Downspouts_Act_Hrs'];?></td>
								<td class="" field="Rain_Gutters_Downspouts_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(raingutters_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Rain_Gutters_Downspouts_Act_Gal"><?php if(isset($row['Rain_Gutters_Downspouts_Act_Gal']))echo $row['Rain_Gutters_Downspouts_Act_Gal'];?></td>
								<td class="" field="Rain_Gutters_Downspouts_Notes"><?php if(isset($row['Rain_Gutters_Downspouts_Notes']))echo $row['Rain_Gutters_Downspouts_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Shutters</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(shutters_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Shutters_CL_Est_Hrs"><?php if(isset($row['Shutters_CL_Est_Hrs']))echo $row['Shutters_CL_Est_Hrs'];?></td>
								<td class="" field="Shutters_Act_Hrs"><?php if(isset($row['Shutters_Act_Hrs']))echo $row['Shutters_Act_Hrs'];?></td>
								<td class="" field="Shutters_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(shutters_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Shutters_Act_Gal"><?php if(isset($row['Shutters_Act_Gal']))echo $row['Shutters_Act_Gal'];?></td>
								<td class="" field="Shutters_Notes"><?php if(isset($row['Shutters_Notes']))echo $row['Shutters_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Windows</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(windowstrim_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(windows2pane_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(windows37pane_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(windows815pane_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(windows16pane_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Windows_CL_Est_Hrs"><?php if(isset($row['Windows_CL_Est_Hrs']))echo $row['Windows_CL_Est_Hrs'];?></td>
								<td class="" field="Windows_Act_Hrs"><?php if(isset($row['Windows_Act_Hrs']))echo $row['Windows_Act_Hrs'];?></td>
								<td class="" field="Windows_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(windowstrim_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(windows2pane_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(windows37pane_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(windows815pane_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(windows16pane_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Windows_Act_Gal"><?php if(isset($row['Windows_Act_Gal']))echo $row['Windows_Act_Gal'];?></td>
								<td class="" field="Windows_Notes"><?php if(isset($row['Windows_Notes']))echo $row['Windows_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Doors</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(doorsflat_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(doorslight_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(doorspaneled_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(doorsfrench_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Doors_CL_Est_Hrs"><?php if(isset($row['Doors_CL_Est_Hrs']))echo $row['Doors_CL_Est_Hrs'];?></td>
								<td class="" field="Doors_Act_Hrs"><?php if(isset($row['Doors_Act_Hrs']))echo $row['Doors_Act_Hrs'];?></td>
								<td class="" field="Doors_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(doorsflat_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(doorslight_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(doorspaneled_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(doorsfrench_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Doors_Act_Gal"><?php if(isset($row['Doors_Act_Gal']))echo $row['Doors_Act_Gal'];?></td>
								<td class="" field="Doors_Notes"><?php if(isset($row['Doors_Notes']))echo $row['Doors_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Garage Door</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(garagedoor_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Garage_Door_CL_Est_Hrs"><?php if(isset($row['Garage_Door_CL_Est_Hrs']))echo $row['Garage_Door_CL_Est_Hrs'];?></td>
								<td class="" field="Garage_Door_Act_Hrs"><?php if(isset($row['Garage_Door_Act_Hrs']))echo $row['Garage_Door_Act_Hrs'];?></td>
								<td class="" field="Garage_Door_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(garagedoor_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Garage_Door_Act_Gal"><?php if(isset($row['Garage_Door_Act_Gal']))echo $row['Garage_Door_Act_Gal'];?></td>
								<td class="" field="Garage_Door_Notes"><?php if(isset($row['Garage_Door_Notes']))echo $row['Garage_Door_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Garage Door Frame</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(garagedoorframe_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Garage_Door_Frame_CL_Est_Hrs"><?php if(isset($row['Garage_Door_Frame_CL_Est_Hrs']))echo $row['Garage_Door_Frame_CL_Est_Hrs'];?></td>
								<td class="" field="Garage_Door_Frame_Act_Hrs"><?php if(isset($row['Garage_Door_Frame_Act_Hrs']))echo $row['Garage_Door_Frame_Act_Hrs'];?></td>
								<td class="" field="Garage_Door_Frame_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(garagedoorframe_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Garage_Door_Frame_Act_Gal"><?php if(isset($row['Garage_Door_Frame_Act_Gal']))echo $row['Garage_Door_Frame_Act_Gal'];?></td>
								<td class="" field="Garage_Door_Frame_Notes"><?php if(isset($row['Garage_Door_Frame_Notes']))echo $row['Garage_Door_Frame_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Entry Door (or Frame Only)</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(entrydoor_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Entry_Door_or_Frame_Only_CL_Est_Hrs"><?php if(isset($row['Entry_Door_or_Frame_Only_CL_Est_Hrs']))echo $row['Entry_Door_or_Frame_Only_CL_Est_Hrs'];?></td>
								<td class="" field="Entry_Door_or_Frame_Only_Act_Hrs"><?php if(isset($row['Entry_Door_or_Frame_Only_Act_Hrs']))echo $row['Entry_Door_or_Frame_Only_Act_Hrs'];?></td>
								<td class="" field="Entry_Door_or_Frame_Only_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(entrydoor_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Entry_Door_or_Frame_Only_Act_Gal"><?php if(isset($row['Entry_Door_or_Frame_Only_Act_Gal']))echo $row['Entry_Door_or_Frame_Only_Act_Gal'];?></td>
								<td class="" field="Entry_Door_or_Frame_Only_Notes"><?php if(isset($row['Entry_Door_or_Frame_Only_Notes']))echo $row['Entry_Door_or_Frame_Only_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Posts/Pillars</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(postspillars_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Posts_Pillars_CL_Est_Hrs"><?php if(isset($row['Posts_Pillars_CL_Est_Hrs']))echo $row['Posts_Pillars_CL_Est_Hrs'];?></td>
								<td class="" field="Posts_Pillars_Act_Hrs"><?php if(isset($row['Posts_Pillars_Act_Hrs']))echo $row['Posts_Pillars_Act_Hrs'];?></td>
								<td class="" field="Posts_Pillars_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(postspillars_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Posts_Pillars_Act_Gal"><?php if(isset($row['Posts_Pillars_Act_Gal']))echo $row['Posts_Pillars_Act_Gal'];?></td>
								<td class="" field="Posts_Pillars_Notes"><?php if(isset($row['Posts_Pillars_Notes']))echo $row['Posts_Pillars_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Wrought Iron</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(wroughtiron_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Wrought_Iron_CL_Est_Hrs"><?php if(isset($row['Wrought_Iron_CL_Est_Hrs']))echo $row['Wrought_Iron_CL_Est_Hrs'];?></td>
								<td class="" field="Wrought_Iron_Act_Hrs"><?php if(isset($row['Wrought_Iron_Act_Hrs']))echo $row['Wrought_Iron_Act_Hrs'];?></td>
								<td class="" field="Wrought_Iron_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(wroughtiron_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Wrought_Iron_Act_Gal"><?php if(isset($row['Wrought_Iron_Act_Gal']))echo $row['Wrought_Iron_Act_Gal'];?></td>
								<td class="" field="Wrought_Iron_Notes"><?php if(isset($row['Wrought_Iron_Notes']))echo $row['Wrought_Iron_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Stucco</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(stuccosingle_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(stuccotwo_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Stucco_CL_Est_Hrs"><?php if(isset($row['Stucco_CL_Est_Hrs']))echo $row['Stucco_CL_Est_Hrs'];?></td>
								<td class="" field="Stucco_Act_Hrs"><?php if(isset($row['Stucco_Act_Hrs']))echo $row['Stucco_Act_Hrs'];?></td>
								<td class="" field="Stucco_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(stuccosingle_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(stuccotwo_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Stucco_Act_Gal"><?php if(isset($row['Stucco_Act_Gal']))echo $row['Stucco_Act_Gal'];?></td>
								<td class="" field="Stucco_Notes"><?php if(isset($row['Stucco_Notes']))echo $row['Stucco_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Siding</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(sidingsingle_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(sidingtwo_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Siding_CL_Est_Hrs"><?php if(isset($row['Siding_CL_Est_Hrs']))echo $row['Siding_CL_Est_Hrs'];?></td>
								<td class="" field="Siding_Act_Hrs"><?php if(isset($row['Siding_Act_Hrs']))echo $row['Siding_Act_Hrs'];?></td>
								<td class="" field="Siding_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(sidingsingle_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(sidingtwo_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Siding_Act_Gal"><?php if(isset($row['Siding_Act_Gal']))echo $row['Siding_Act_Gal'];?></td>
								<td class="" field="Siding_Notes"><?php if(isset($row['Siding_Notes']))echo $row['Siding_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Body Paint: +/- Time</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(bodypaint_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Body_Paint_Time_CL_Est_Hrs"><?php if(isset($row['Body_Paint_Time_CL_Est_Hrs']))echo $row['Body_Paint_Time_CL_Est_Hrs'];?></td>
								<td class="" field="Body_Paint_Time_Act_Hrs"><?php if(isset($row['Body_Paint_Time_Act_Hrs']))echo $row['Body_Paint_Time_Act_Hrs'];?></td>
								<td class="" field="Body_Paint_Time_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(bodypaint_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Body_Paint_Time_Act_Gal"><?php if(isset($row['Body_Paint_Time_Act_Gal']))echo $row['Body_Paint_Time_Act_Gal'];?></td>
								<td class="" field="Body_Paint_Time_Notes"><?php if(isset($row['Body_Paint_Time_Notes']))echo $row['Body_Paint_Time_Notes'];?></td>
							</tr>
							<tr>
								<td class="edit-disabled">Miscellaneous</td>
								<td class="edit-disabled"><?php echo $db->FetchCellValue("external_estimate","sum(miscellaneous_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(miscellaneous1_time)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(miscellaneous2_time)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Miscellaneous_CL_Est_Hrs"><?php if(isset($row['Miscellaneous_CL_Est_Hrs']))echo $row['Miscellaneous_CL_Est_Hrs'];?></td>
								<td class="" field="Miscellaneous_Act_Hrs"><?php if(isset($row['Miscellaneous_Act_Hrs']))echo $row['Miscellaneous_Act_Hrs'];?></td>
								<td class="" field="Miscellaneous_Est_Gal"><?php echo $db->FetchCellValue("external_estimate","sum(miscellaneous_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(miscellaneous1_gals)","project_id = '".$_REQUEST['project_id']."' ") + $db->FetchCellValue("external_estimate","sum(miscellaneous2_gals)","project_id = '".$_REQUEST['project_id']."' "); ?></td>
								<td class="" field="Miscellaneous_Act_Gal"><?php if(isset($row['Miscellaneous_Act_Gal']))echo $row['Miscellaneous_Act_Gal'];?></td>
								<td class="" field="Miscellaneous_Notes"><?php if(isset($row['Miscellaneous_Notes']))echo $row['Miscellaneous_Notes'];?></td>
							</tr>
							<tr>
								<th class="greyclr">
									<strong>TOTAL DAILY MAN HRS</strong>
								</th>
								<th class="greyclr">0.0</th>
								<th class="greyclr"></th>
								<th class="greyclr"></th>
								<th class="greyclr">$0</th>
								<th class="greyclr"></th>
								<th class="greyclr"></th>
							</tr>
						</tbody>
					</table>
					<div class="col s12 m12 input-field" style="padding: 0px; margin: 30px 0px;">
						<textarea id="notes" class="validate" type="text" value="" autocomplete="off" name="notes"></textarea>
						<label for="notes">Notes</label>
					</div>
				<div class="input-field col s12" style="padding: 0px; text-align:center;">
				   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#00695C; float:none; display:inline-block;">
					<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?>" name="submit">
				   </i>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
$('#mainTable').editableTableWidget({disableClass: "edit-disabled"});
$(function(){
 $('#exthours').addClass('active');
 $("#headingSearchtitle").html("Exterior Hours Tracking");
});
var ignore = false;

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
   $("#exteriorli").addClass("active");
   $("#exteriorlidiv").show();
});
</script>