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
$label = "Add";
$button = "Update";
if(isset($_REQUEST['id'])){
	$label = "Edit";
	$button = "Update";
} 

$db = new Db();
$row = array();
$table88 = "ext_estimates";

if(isset($_REQUEST['project_id'])){
	$condition88 = "i.project_id = '".$_REQUEST['project_id']."' ";
	$main_table88 = array("$table88 i",array());
	$join_tables88 = array(
		array('left','external_estimate c','c.estimate_id = i.id', array('sum(c.scraping_time) as sum_scraping_time','sum(c.scraping_quantity) as sum_scraping_quantity','sum(c.patch_time) as sum_patch_time','sum(c.patch_quantity) as sum_patch_quantity','sum(c.feather_time) as sum_feather_time','sum(c.feather_quantity) as sum_feather_quantity','sum(c.flexible_time) as sum_flexible_time','sum(c.flexible_quantity) as sum_flexible_quantity','sum(c.caulking_time) as sum_caulking_time','sum(c.caulking_quantity) as sum_caulking_quantity','sum(c.pressure_time) as sum_pressure_time','sum(c.pressure_quantity) as sum_pressure_quantity','sum(c.roof_time) as sum_roof_time','sum(c.roof_quantity) as sum_roof_quantity','sum(c.spot_time) as sum_spot_time','sum(c.spot_quantity) as sum_spot_quantity','sum(c.remove_lights_time) as sum_remove_lights_time','sum(c.remove_lights_quantity) as sum_remove_lights_quantity','sum(c.remove_screens_time) as sum_remove_screens_time','sum(c.remove_screens_quantity) as sum_remove_screens_quantity','sum(c.remove_other_time) as sum_remove_other_time','sum(c.remove_other_quantity) as sum_remove_other_quantity','sum(c.wash_time) as sum_wash_time','sum(c.wash_quantity) as sum_wash_quantity','sum(c.pressurewashdeck_time) as sum_pressurewashdeck_time','sum(c.pressurewashdeck_quantity) as sum_pressurewashdeck_quantity','sum(c.maskwindowsdoors_time) as sum_maskwindowsdoors_time','sum(c.maskwindowsdoors_quantity) as sum_maskwindowsdoors_quantity','sum(c.maskother_time) as sum_maskother_time','sum(c.maskother_quantity) as sum_maskother_quantity','sum(c.eavessingle_gals) as sum_eavessingle_gals','sum(c.eavessingle_time) as sum_eavessingle_time','sum(c.eavessingle_quantity) as sum_eavessingle_quantity','sum(c.eavestwo_gals) as sum_eavestwo_gals','sum(c.eavestwo_time) as sum_eavestwo_time','sum(c.eavestwo_quantity) as sum_eavestwo_quantity','sum(c.eaveseasy_gals) as sum_eaveseasy_gals','sum(c.eaveseasy_time) as sum_eaveseasy_time','sum(c.eaveseasy_quantity) as sum_eaveseasy_quantity','sum(c.eaveshard_gals) as sum_eaveshard_gals','sum(c.eaveshard_time) as sum_eaveshard_time','sum(c.eaveshard_quantity) as sum_eaveshard_quantity','sum(c.fasciasingle_gals) as sum_fasciasingle_gals','sum(c.fasciasingle_time) as sum_fasciasingle_time','sum(c.fasciasingle_quantity) as sum_fasciasingle_quantity','sum(c.fasciatwo_gals) as sum_fasciatwo_gals','sum(c.fasciatwo_time) as sum_fasciatwo_time','sum(c.fasciatwo_quantity) as sum_fasciatwo_quantity','sum(c.metalflashing_gals) as sum_metalflashing_gals','sum(c.metalflashing_time) as sum_metalflashing_time','sum(c.metalflashing_quantity) as sum_metalflashing_quantity','sum(c.raingutters_gals) as sum_raingutters_gals','sum(c.raingutters_time) as sum_raingutters_time','sum(c.raingutters_quantity) as sum_raingutters_quantity','sum(c.shutters_gals) as sum_shutters_gals','sum(c.shutters_time) as sum_shutters_time','sum(c.shutters_quantity) as sum_shutters_quantity','sum(c.windowstrim_gals) as sum_windowstrim_gals','sum(c.windowstrim_time) as sum_windowstrim_time','sum(c.windowstrim_quantity) as sum_windowstrim_quantity','sum(c.windows2pane_gals) as sum_windows2pane_gals','sum(c.windows2pane_time) as sum_windows2pane_time','sum(c.windows2pane_quantity) as sum_windows2pane_quantity','sum(c.windows37pane_gals) as sum_windows37pane_gals','sum(c.windows37pane_time) as sum_windows37pane_time','sum(c.windows37pane_quantity) as sum_windows37pane_quantity','sum(c.windows815pane_gals) as sum_windows815pane_gals','sum(c.windows815pane_time) as sum_windows815pane_time','sum(c.windows815pane_quantity) as sum_windows815pane_quantity','sum(c.windows16pane_gals) as sum_windows16pane_gals','sum(c.windows16pane_time) as sum_windows16pane_time','sum(c.windows16pane_quantity) as sum_windows16pane_quantity','sum(c.doorsflat_gals) as sum_doorsflat_gals','sum(c.doorsflat_time) as sum_doorsflat_time','sum(c.doorsflat_quantity) as sum_doorsflat_quantity','sum(c.doorslight_gals) as sum_doorslight_gals','sum(c.doorslight_time) as sum_doorslight_time','sum(c.doorslight_quantity) as sum_doorslight_quantity','sum(c.doorspaneled_gals) as sum_doorspaneled_gals','sum(c.doorspaneled_time) as sum_doorspaneled_time','sum(c.doorspaneled_quantity) as sum_doorspaneled_quantity','sum(c.doorsfrench_gals) as sum_doorsfrench_gals','sum(c.doorsfrench_time) as sum_doorsfrench_time','sum(c.doorsfrench_quantity) as sum_doorsfrench_quantity','sum(c.garagedoor_gals) as sum_garagedoor_gals','sum(c.garagedoor_time) as sum_garagedoor_time','sum(c.garagedoor_quantity) as sum_garagedoor_quantity','sum(c.garagedoorframe_gals) as sum_garagedoorframe_gals','sum(c.garagedoorframe_time) as sum_garagedoorframe_time','sum(c.garagedoorframe_quantity) as sum_garagedoorframe_quantity','sum(c.entrydoor_gals) as sum_entrydoor_gals','sum(c.entrydoor_time) as sum_entrydoor_time','sum(c.entrydoor_quantity) as sum_entrydoor_quantity','sum(c.postspillars_gals) as sum_postspillars_gals','sum(c.postspillars_time) as sum_postspillars_time','sum(c.postspillars_quantity) as sum_postspillars_quantity','sum(c.wroughtiron_gals) as sum_wroughtiron_gals','sum(c.wroughtiron_time) as sum_wroughtiron_time','sum(c.wroughtiron_quantity) as sum_wroughtiron_quantity','sum(c.stuccosingle_gals) as sum_stuccosingle_gals','sum(c.stuccosingle_time) as sum_stuccosingle_time','sum(c.stuccosingle_quantity) as sum_stuccosingle_quantity','sum(c.stuccotwo_gals) as sum_stuccotwo_gals','sum(c.stuccotwo_time) as sum_stuccotwo_time','sum(c.stuccotwo_quantity) as sum_stuccotwo_quantity','sum(c.sidingsingle_gals) as sum_sidingsingle_gals','sum(c.sidingsingle_time) as sum_sidingsingle_time','sum(c.sidingsingle_quantity) as sum_sidingsingle_quantity','sum(c.sidingtwo_gals) as sum_sidingtwo_gals','sum(c.sidingtwo_time) as sum_sidingtwo_time','sum(c.sidingtwo_quantity) as sum_sidingtwo_quantity','sum(c.bodypaint_gals) as sum_bodypaint_gals','sum(c.bodypaint_time) as sum_bodypaint_time','sum(c.bodypaint_quantity) as sum_bodypaint_quantity','sum(c.miscellaneous_time) as sum_miscellaneous_time','sum(c.miscellaneous_quantity) as sum_miscellaneous_quantity','sum(c.miscellaneous1_time) as sum_miscellaneous1_time','sum(c.miscellaneous1_quantity) as sum_miscellaneous1_quantity','sum(c.miscellaneous2_time) as sum_miscellaneous2_time','sum(c.miscellaneous2_quantity) as sum_miscellaneous2_quantity',))
	);
	$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
	$row = mysql_fetch_array($rs1);
	$paint_grade = array();
	$paint_grade = $db->FetchToArray("paint_grade","*"); 
	
	$val = array();
	for($i = 0; $i < sizeof($paint_grade) ; $i++)
	{
		$val[$paint_grade[$i]['id']]['paint_grade'] = $paint_grade[$i]['paint_grade'];
		$val[$paint_grade[$i]['id']]['interior_rate'] = $paint_grade[$i]['interior_rate'];
		$val[$paint_grade[$i]['id']]['exterior_rate'] = $paint_grade[$i]['exterior_rate'];
	}
}

$row11 = array();
$table888 = "external_summary";

if(isset($_REQUEST['id'])){
	$condition888 = "i.id = '".$_REQUEST['id']."' ";
	$main_table888 = array("$table888 i",array("i.*"));
	$join_tables888 = array(
	);
	$rs11 = $db->JoinFetch($main_table888, $join_tables888, $condition888);
	$row11 = mysql_fetch_array($rs11);
	//print_r($row);
}
?>
<?php
/*$val = array();
$val = $db->FetchToArray("default_production_rate","*"); 
$production_rate = array();
for($i = 0; $i < sizeof($val) ; $i++)
{
	$production_rate[$val[$i]['production_item']]['rate'] = $val[$i]['rate'];
	$production_rate[$val[$i]['production_item']]['coat_1'] = $val[$i]['coat_1'];
	$production_rate[$val[$i]['production_item']]['coat_2'] = $val[$i]['coat_2'];
	$production_rate[$val[$i]['production_item']]['coat_3'] = $val[$i]['coat_3'];
	$production_rate[$val[$i]['production_item']]['coat_4'] = $val[$i]['coat_4'];
	$production_rate[$val[$i]['production_item']]['spread'] = $val[$i]['spread'];
}*/
//print_r($production_rate['Patch & Texture']['rate']);
?>

<script>
function form_externalsummary(){
	
	var poststring={};
 
	 $('table td').each(function(){
	  try{
	   if($(this).attr('field')!="")
	   {
		poststring[$(this).attr('field')] = $(this).html();
	   }
	  }catch(err){}
	 });
	 poststring['costtype'] =  $('#costtype').val();
	 poststring['gradestatus'] =  $("#gradestatus").val();
	 poststring['wallpaintgrade'] =  $("#wallpaintgrade").val();
	 poststring['ceilinggrade'] =  $("#ceilinggrade").val();
	 poststring['trimpaintgrade'] =  $("#trimpaintgrade").val();
	 poststring['primergrade'] =  $("#primergrade").val();
	 /*poststring['C_FT'] =  $("#cft").val();
	 poststring['Gallons'] =  $("#gallons").val();
	 poststring['Hours'] =  $("#hours").val();
	 poststring['Cost'] =  $("#cost").val();*/
	 poststring['project_id'] =  <?php echo $_REQUEST['project_id']; ?>;
	 <?php if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" ){?>
		  poststring['id'] =  <?php echo $_REQUEST['id']; ?>;
	<?php } ?>
	 console.log(poststring);
	
	 ignore = true;
	$.ajax({
		url: '<?php echo BASEPATH;?>/project/addextsummary', 
		type: 'post',
		cache: false,
		data: poststring,
		success: function (response) {                    
			var res = eval('('+response+')');
			if(res['success'] == "1"){
				swal({   title: "Do you want to continue?",   
						 text: "You have successfully update Exterior Summary. Do you want to proceed to the Dashboard?",   
						 type: "warning",   
						 showCancelButton: true,   
						 confirmButtonColor: "#DD6B55",   
						 confirmButtonText: "Yes",   
						 cancelButtonText: "No",   
						 closeOnConfirm: false,   
						 closeOnCancel: false }, 
						 function(isConfirm){   
							 if (isConfirm) {     
								 window.location.href="<?php echo SITE_ROOT;?>/project/dashboard?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
							 else {
								 location.href = "<?= SITE_ROOT; ?>/project/external_summary?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
						});
			}
			
			//console.log(res->success);
		}
	}); 
}
</script>
<script>
/*function form_internalestimate(){
	
	var poststring={};
 
 
	 $('table td').each(function(){
	  try{
	   if($(this).attr('field')!="")
	   {
		poststring[$(this).attr('field')] = $(this).html();
	   }
	  }catch(err){}
	 });
	 poststring['SpaceType'] =  $('#space_type').val();
	 poststring['Length'] =  $("#length").val();
	 poststring['Width'] =  $("#width").val();
	 poststring['Height'] =  $("#height").val();
	 poststring['LN_FT'] =  $("#lnft").val();
	 poststring['W_FT'] =  $("#wft").val();
	 poststring['C_FT'] =  $("#cft").val();
	 poststring['Gallons'] =  $("#gallons").val();
	 poststring['Hours'] =  $("#hours").val();
	 poststring['Cost'] =  $("#cost").val();
	 poststring['project_id'] =  <?php echo $_REQUEST['project_id']; ?>;
	 <?php if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" ){?>
		  poststring['id'] =  <?php echo $_REQUEST['id']; ?>;
	<?php } ?> 
	 console.log(poststring);
	
	 ignore = true;
	$.ajax({
		url: '<?php echo BASEPATH;?>/project/addintest', 
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
*/
</script>
<style>
.card-title.grey-text.text-darken-4 p{
	margin:10px 0px;
}
.mywidth{
	width:25%;
}
.mya a {
    color: rgb(255, 255, 255) !important;
    font-style: normal !important;
}
.specialclass.fixed,.specialclass2.fixed{
  top:136px;
  position:fixed;
  width:auto;
  display:none;
  border:none;
}
</style>
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/mindmup-editabletable.js"></script>   
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/numeric-input-example.js"></script>
<?php
$db = new Db();
$table88 = "projects";
$condition88 = "i.created_by = '".$_SESSION['samajadmin']['id']."' && i.id= '".$_REQUEST['project_id']."' ";
$main_table88 = array("$table88 i",array("i.*"));
$join_tables88 = array(
	array('left','client c','c.id = i.Client_id', array('c.name as client_name','c.phonenumber as client_phone','c.email as client_email')),
	array('left','location r1','r1.location_id = i.City', array('r1.name as city_name')),
	array('left','location r2','r2.location_id = i.State', array('r2.name as state_name')),
	array('left','location r3','r3.location_id = i.country', array('r3.name as country_name')),
);
$rs88 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
$rs11 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
$totalcount88 =  @mysql_num_rows($rs88);
?>
<div class="row">
	<div class="col s12 m12">
		<ul id="task-card" class="collection with-header" style="margin-bottom: 0px; border: 0px none;">
		<li class="collection-header" style="background:transparent;padding:0;">
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 500px);">
					<a data-delay="50" data-tooltip="Next To Hours Tracking" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/external_hrs_tracking?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#00695C;" class="mdi-hardware-keyboard-arrow-right"></i>
					</a>
					<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#00695C;" class="mdi-content-clear"></i>
					</a>
					<a data-delay="50" data-tooltip="Previous To Pricing" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/external_pricing?project_id=".$_REQUEST['project_id']; ?>">
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
				</div>
			</li>
		</ul>
	</div>
</div>
<div class="col s12 m12 l12">
						
<div class="row" style="position: fixed; top: 64px; width: 100%; max-width:  calc(100% - 550px); text-align: center;padding-bottom:5px;background:#f2f2f2; z-index: 9;">
		<div class="input-field col m2 s12">
		   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;padding: 0px; width: 96%; display: inline-block; float: none;">
			<input id="submit" class="waves-button-input" type="button" onclick="form_externalsummary()" value="<?php echo $button; ?> Summary" name="submit">
		   </i>
		</div>
		<div class="input-field col m3 s12 mya">
		   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;padding: 0px; width: 96%; display: inline-block; float: none;">
			<a id="createproposal" class="waves-button-input" href="<?php echo SITE_ROOT."/proposalext.php?project_id=".$_REQUEST['project_id'];?>"><?php echo $button; ?> Proposal</a>
		   </i>
		</div>
		<div class="input-field col m4 s12">
		 <iframe src="<?= SITE_ROOT; ?>/classes/phpword2/samples/contractext.php<?php echo "?project_id=".$_REQUEST['project_id']; ?>"  width="300" height="57" style="float: right;" frameBorder="0" scrolling="no"></iframe>
		</div>
		<div class="input-field col m3 s12">
		   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;padding: 0px; width: 96%; display: inline-block; float: none;">
			<input id="submit" class="waves-button-input" type="button" disabled value="<?php echo $button; ?> Work Order" name="submit">
		   </i>
		</div>
	</div>
<div class="card-panel" style="margin-top: 45px;">
	<div id="row-grouping" class="section" style="padding-top:0px;">
		<div class="col s12 m12 l12" style="display:none;">
				<div id="profile-card" class="card">
				<div class="card-image waves-effect waves-block waves-light">
					<img class="activator" src="<?php echo CSS; ?>/images/user-bg.jpg" alt="user bg">
				</div>
				<?php
				if(isset($totalcount88) && $totalcount88 != 0)
					{
						while($row12 = mysql_fetch_object($rs88))
						{
				?>
							<div class="card-content" style="">
								  <!-- <img align="left" src="<?php echo CSS; ?>/images/avatar.jpg" alt="" class="circle responsive-img activator card-profile-image"> -->
								  <div class="circle card-profile-image clientname z-depth-2" style="background:<?php echo $_SESSION['samajadmin']['client_color']; ?>">
									<?php 
									$client = $row12->client_name; 
									$arr1 = str_split($client);
									echo strtoupper($arr1[0]);
									?>
								  </div>
								  <a style="display:none;" class="btn-floating activator btn-move-up waves-effect waves-light darken-2 right">
									<i class="mdi-editor-mode-edit"></i>
								  </a>

								  <span class="card-title activator grey-text text-darken-4"><?php echo $row12->client_name; ?></span>
								  <div class="row">
										<p class="col mywidth"><i class="mdi-action-perm-identity"></i><?php echo $row12->prepared_by; ?></p>
										<p class="col mywidth"><i class="mdi-action-perm-phone-msg"></i><?php echo $row12->client_phone; ?></p>
										<p class="col mywidth"><i class="mdi-action-perm-phone-msg"></i><?php echo $row12->alt_phone; ?></p>
										<p class="col mywidth"><i class="mdi-communication-email"></i><?php echo $row12->client_email; ?></p>
								  </div>
							</div>
							<div class="card-reveal">
							  <span class="card-title grey-text text-darken-4"><?php echo $row12->client_name; ?></p>
							  <p><i class="mdi-action-perm-identity"></i><?php echo $row12->Address.", ".$row12->city_name.", ".$row12->state_name.", ".$row12->country_name ?></p>
							  <p><i class="mdi-action-perm-phone-msg"></i> <?php echo $row12->client_phone; ?></p>
							  <p><i class="mdi-communication-email"></i><?php echo $row12->client_email; ?></p>
							  <p><i class="mdi-social-cake"></i> <?php echo $row12->Date; ?></p>
							</div>
				<?php
						}
					}
					else
					{
				?>
					<div class="row"><div class="col s12"><h5 class="col s12">No Record Found</h5></div></div>
				<?php
					}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col s12 m12">
				<table id="mainTable" class="table table-striped specialclass" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
					<thead>
						<tr>
							<th>Surface</th>
							<th>Gallons</th>
							<th>Hours</th>
							<th>Unit</th>
							<th>Price</th>
						</tr>
					</thead>
						<tbody>
							<tr>
								<td field="" class="dark_blueclr">Scraping & Sanding</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_scraping_time']))echo $row['sum_scraping_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_scraping_quantity']))echo $row['sum_scraping_quantity'];?></td>
								<td field="scraping_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Patch Stucco</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_patch_time']))echo $row['sum_patch_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_patch_quantity']))echo $row['sum_patch_quantity'];?></td>
								<td field="patch_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Feather Sanding</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_feather_time']))echo $row['sum_feather_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_feather_quantity']))echo $row['sum_feather_quantity'];?></td>
								<td field="feather_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Flexible Epoxy</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_flexible_time']))echo $row['sum_flexible_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_flexible_quantity']))echo $row['sum_flexible_quantity'];?></td>
								<td field="flexible_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Caulking</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_caulking_time']))echo $row['sum_caulking_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_caulking_quantity']))echo $row['sum_caulking_quantity'];?></td>
								<td field="caulking_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Pressure Wash</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_pressure_time']))echo $row['sum_pressure_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_pressure_quantity']))echo $row['sum_pressure_quantity'];?></td>
								<td field="pressure_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Roof/Ladder Time</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_roof_time']))echo $row['sum_roof_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_roof_quantity']))echo $row['sum_roof_quantity'];?></td>
								<td field="roof_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Spot Prime</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_spot_time']))echo $row['sum_spot_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_spot_quantity']))echo $row['sum_spot_quantity'];?></td>
								<td field="spot_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Remove/Replace (Lights)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_remove_lights_time']))echo $row['sum_remove_lights_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_remove_lights_quantity']))echo $row['sum_remove_lights_quantity'];?></td>
								<td field="remove_lights_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Remove/Replace (Screens)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_remove_screens_time']))echo $row['sum_remove_screens_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_remove_screens_quantity']))echo $row['sum_remove_screens_quantity'];?></td>
								<td field="remove_screens_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Remove/Replace (Other)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_remove_other_time']))echo $row['sum_remove_other_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_remove_other_quantity']))echo $row['sum_remove_other_quantity'];?></td>
								<td field="remove_other_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Wash Windows</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_wash_time']))echo $row['sum_wash_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wash_quantity']))echo $row['sum_wash_quantity'];?></td>
								<td field="wash_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Pressure Wash Deck</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_pressurewashdeck_time']))echo $row['sum_pressurewashdeck_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_pressurewashdeck_quantity']))echo $row['sum_pressurewashdeck_quantity'];?></td>
								<td field="pressure_wash_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Mask (Windows & Doors)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_maskwindowsdoors_time']))echo $row['sum_maskwindowsdoors_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_maskwindowsdoors_quantity']))echo $row['sum_maskwindowsdoors_quantity'];?></td>
								<td field="maskwindowsdoors_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Mask (Other)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_maskother_time']))echo $row['sum_maskother_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_maskother_quantity']))echo $row['sum_maskother_quantity'];?></td>
								<td field="maskother_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Eaves (Single Story)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_eavessingle_gals']))echo $row['sum_eavessingle_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_eavessingle_time']))echo $row['sum_eavessingle_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eavessingle_quantity']))echo $row['sum_eavessingle_quantity'];?></td>
								<td field="eavessingle_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Eaves (Two Story)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_eavestwo_gals']))echo $row['sum_eavestwo_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_eavestwo_time']))echo $row['sum_eavestwo_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eavestwo_quantity']))echo $row['sum_eavestwo_quantity'];?></td>
								<td field="eavestwo_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Eaves (Easy)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_eaveseasy_gals']))echo $row['sum_eaveseasy_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_eaveseasy_time']))echo $row['sum_eaveseasy_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eaveseasy_quantity']))echo $row['sum_eaveseasy_quantity'];?></td>
								<td field="eaveseasy_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Eaves (Hard)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_eaveshard_gals']))echo $row['sum_eaveshard_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_eaveshard_time']))echo $row['sum_eaveshard_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eaveshard_quantity']))echo $row['sum_eaveshard_quantity'];?></td>
								<td field="eaveshard_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Fascia (Single Story)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_fasciasingle_gals']))echo $row['sum_fasciasingle_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_fasciasingle_time']))echo $row['sum_fasciasingle_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_fasciasingle_quantity']))echo $row['sum_fasciasingle_quantity'];?></td>
								<td field="fasciasingle_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Fascia (Two Story)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_fasciatwo_gals']))echo $row['sum_fasciatwo_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_fasciatwo_time']))echo $row['sum_fasciatwo_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_fasciatwo_quantity']))echo $row['sum_fasciatwo_quantity'];?></td>
								<td field="fasciatwo_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Metal Flashing</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_metalflashing_gals']))echo $row['sum_metalflashing_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_metalflashing_time']))echo $row['sum_metalflashing_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_metalflashing_quantity']))echo $row['sum_metalflashing_quantity'];?></td>
								<td field="metalflashing_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Rain Gutters & Downspouts</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_raingutters_gals']))echo $row['sum_raingutters_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_raingutters_time']))echo $row['sum_raingutters_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_raingutters_quantity']))echo $row['sum_raingutters_quantity'];?></td>
								<td field="raingutters_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Shutters</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_shutters_gals']))echo $row['sum_shutters_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_shutters_time']))echo $row['sum_shutters_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_shutters_quantity']))echo $row['sum_shutters_quantity'];?></td>
								<td field="shutters_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows Trim</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_windowstrim_gals']))echo $row['sum_windowstrim_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windowstrim_time']))echo $row['sum_windowstrim_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windowstrim_quantity']))echo $row['sum_windowstrim_quantity'];?></td>
								<td field="windowstrim_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows (2 Pane)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_windows2pane_gals']))echo $row['sum_windows2pane_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windows2pane_time']))echo $row['sum_windows2pane_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows2pane_quantity']))echo $row['sum_windows2pane_quantity'];?></td>
								<td field="windows2pane_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows (3-7 Pane)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_windows37pane_gals']))echo $row['sum_windows37pane_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windows37pane_time']))echo $row['sum_windows37pane_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows37pane_quantity']))echo $row['sum_windows37pane_quantity'];?></td>
								<td field="windows37pane_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows (8-15 Pane)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_windows815pane_gals']))echo $row['sum_windows815pane_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windows815pane_time']))echo $row['sum_windows815pane_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows815pane_quantity']))echo $row['sum_windows815pane_quantity'];?></td>
								<td field="windows815pane_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows (16 + Pane)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_windows16pane_gals']))echo $row['sum_windows16pane_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windows16pane_time']))echo $row['sum_windows16pane_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows16pane_quantity']))echo $row['sum_windows16pane_quantity'];?></td>
								<td field="windows16pane_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors (Flat)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_doorsflat_gals']))echo $row['sum_doorsflat_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_doorsflat_time']))echo $row['sum_doorsflat_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorsflat_quantity']))echo $row['sum_doorsflat_quantity'];?></td>
								<td field="doorsflat_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors (Light)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_doorslight_gals']))echo $row['sum_doorslight_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_doorslight_time']))echo $row['sum_doorslight_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorslight_quantity']))echo $row['sum_doorslight_quantity'];?></td>
								<td field="doorslight_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors (Paneled)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_doorspaneled_gals']))echo $row['sum_doorspaneled_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_doorspaneled_time']))echo $row['sum_doorspaneled_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorspaneled_quantity']))echo $row['sum_doorspaneled_quantity'];?></td>
								<td field="doorspaneled_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors (French)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_doorsfrench_gals']))echo $row['sum_doorsfrench_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_doorsfrench_time']))echo $row['sum_doorsfrench_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorsfrench_quantity']))echo $row['sum_doorsfrench_quantity'];?></td>
								<td field="doorsfrench_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Garage Door</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_garagedoor_gals']))echo $row['sum_garagedoor_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_garagedoor_time']))echo $row['sum_garagedoor_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_garagedoor_quantity']))echo $row['sum_garagedoor_quantity'];?></td>
								<td field="garagedoor_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Garage Door Frame</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_garagedoorframe_gals']))echo $row['sum_garagedoorframe_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_garagedoorframe_time']))echo $row['sum_garagedoorframe_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_garagedoorframe_quantity']))echo $row['sum_garagedoorframe_quantity'];?></td>
								<td field="garagedoorframe_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Entry Door (or Frame Only)</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_entrydoor_gals']))echo $row['sum_entrydoor_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_entrydoor_time']))echo $row['sum_entrydoor_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_entrydoor_quantity']))echo $row['sum_entrydoor_quantity'];?></td>
								<td field="entrydoor_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Posts/Pillars</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_postspillars_gals']))echo $row['sum_postspillars_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_postspillars_time']))echo $row['sum_postspillars_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_postspillars_quantity']))echo $row['sum_postspillars_quantity'];?></td>
								<td field="postspillars_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Wrought Iron</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_wroughtiron_gals']))echo $row['sum_wroughtiron_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_wroughtiron_time']))echo $row['sum_wroughtiron_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wroughtiron_quantity']))echo $row['sum_wroughtiron_quantity'];?></td>
								<td field="wroughtiron_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Stucco - Single Story</td>
								<td field="" class="white edit-disabled wpgallons"><?php if(isset($row['sum_stuccosingle_gals']))echo $row['sum_stuccosingle_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_stuccosingle_time']))echo $row['sum_stuccosingle_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_stuccosingle_quantity']))echo $row['sum_stuccosingle_quantity'];?></td>
								<td field="stuccosingle_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Stucco - Two Story</td>
								<td field="" class="white edit-disabled wpgallons"><?php if(isset($row['sum_stuccotwo_gals']))echo $row['sum_stuccotwo_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_stuccotwo_time']))echo $row['sum_stuccotwo_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_stuccotwo_quantity']))echo $row['sum_stuccotwo_quantity'];?></td>
								<td field="stuccotwo_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Siding - Single Story</td>
								<td field="" class="white edit-disabled wpgallons"><?php if(isset($row['sum_sidingsingle_gals']))echo $row['sum_sidingsingle_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_sidingsingle_time']))echo $row['sum_sidingsingle_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_sidingsingle_quantity']))echo $row['sum_sidingsingle_quantity'];?></td>
								<td field="sidingsingle_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Siding - Two Story</td>
								<td field="" class="white edit-disabled wpgallons"><?php if(isset($row['sum_sidingtwo_gals']))echo $row['sum_sidingtwo_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_sidingtwo_time']))echo $row['sum_sidingtwo_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_sidingtwo_quantity']))echo $row['sum_sidingtwo_quantity'];?></td>
								<td field="sidingtwo_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Body Paint: +/- Time</td>
								<td field="" class="white edit-disabled wpgallons"><?php if(isset($row['sum_bodypaint_gals']))echo $row['sum_bodypaint_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_bodypaint_time']))echo $row['sum_bodypaint_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_bodypaint_quantity']))echo $row['sum_bodypaint_quantity'];?></td>
								<td field="bodypaint_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Miscellaneous</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled miscell"><?php if(isset($row['sum_miscellaneous_time']))echo $row['sum_miscellaneous_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_miscellaneous_quantity']))echo $row['sum_miscellaneous_quantity'];?></td>
								<td field="miscell1_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Miscellaneous</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled miscell"><?php if(isset($row['sum_miscellaneous1_time']))echo $row['sum_miscellaneous1_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_miscellaneous1_quantity']))echo $row['sum_miscellaneous1_quantity'];?></td>
								<td field="miscell2_price" class="white edit-disabled pricefield"></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Miscellaneous</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled miscell"><?php if(isset($row['sum_miscellaneous2_time']))echo $row['sum_miscellaneous2_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_miscellaneous2_quantity']))echo $row['sum_miscellaneous2_quantity'];?></td>
								<td field="miscell3_price" class="white edit-disabled pricefield"></td>
							</tr>
						</tbody>
					</table>
					<div class="input-field col s12" style="padding: 0px">
				  &nbsp;
				</div>
				<div class="input-field col s12" style="padding: 0px">
					<div class="input-field col m6" style="padding-left: 0px">
						<table id="mainTable1" class="table table-striped specialclass2" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
							<thead>
								<tr> 
									<th>Summary Details</th>
									<th>Totals</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="light_orangeclr">Preparation</td>
									<td field="preparationtime" id="Preparationtime" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="light_orangeclr">Paint Application</td>
									<!-- <td id="paintapplication" class="light_greenclr edit-disabled"></td> -->
									<td field="paintapplication" id="paintapplication" class="light_greenclr edit-disabled"><?php if(isset($row11['paintapplication']))echo $row11['paintapplication'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr">Miscellaneous</td>
									<!-- <td id="Miscellaneous" class="light_greenclr edit-disabled"></td> -->
									<td field="miscellaneous" id="Miscellaneous" class="light_greenclr edit-disabled"><?php if(isset($row11['miscellaneous']))echo $row11['miscellaneous'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr">0% Financing % Increase</td>
									<!-- <td id="financing" class="yellowclr"></td> -->
									<td field="financing" id="financing" class="yellowclr"><?php if(isset($row11['financing']))echo $row11['financing'];?></td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<!-- <td id="miscellaneous1" class="yellowclr">0</td> -->
									<td field="miscellaneous1" id="miscellaneous1" class="yellowclr"><?php if(isset($row11['miscellaneous1']))echo $row11['miscellaneous1']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<!-- <td id="miscellaneous2" class="yellowclr">0</td> -->
									<td field="miscellaneous2" id="miscellaneous2" class="yellowclr"><?php if(isset($row11['miscellaneous2']))echo $row11['miscellaneous2']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<!-- <td id="miscellaneous3" class="yellowclr">0</td> -->
									<td field="miscellaneous3" id="miscellaneous3" class="yellowclr"><?php if(isset($row11['miscellaneous3']))echo $row11['miscellaneous3']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<!-- <td id="miscellaneous4" class="yellowclr">0</td> -->
									<td field="miscellaneous4" id="miscellaneous4" class="yellowclr"><?php if(isset($row11['miscellaneous4']))echo $row11['miscellaneous4']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="light_orangeclr">Labor Cost(s)</td>
									<!-- <td id="Laborcost" class="light_greenclr"></td> -->
									<td field="laborcost" id="Laborcost" class="light_greenclr"><?php if(isset($row11['laborcost']))echo $row11['laborcost'];?></td>
								</tr>
								<tr>
									<td class="yellowclr edit-disabled">
										<!-- <select name="costtype" id="costtype">
											<option value="bygallon">Paint Cost (by gal.)</option>
											<option value="perpercent">Paint Cost (by %)</option>
										</select> -->
										<select name="costtype" id="costtype">
											<option value="bygallon" <?php if($row11['costtype'] == "bygallon") echo "selected";?>>Paint Cost (by gal.)</option>
											<option value="perpercent" <?php if($row11['costtype'] == "perpercent") echo "selected";?> >Paint Cost (by %)</option>
										</select>
									</td>
									<!-- <td id="costvalue" class="light_greenclr edit-disabled"></td> -->
									<td field="costvalue" id="costvalue" class="light_greenclr edit-disabled"><?php if(isset($row11['costvalue']))echo $row11['costvalue'];?></td>
								</tr>
								<tr>
									<td class="yellowclr edit-disabled">Soft Supplies</td>
									<!-- <td id="softsupplies" class="light_greenclr edit-disabled"></td> -->
									<td field="softsupplies" id="softsupplies" class="light_greenclr edit-disabled"><?php if(isset($row11['softsupplies']))echo $row11['softsupplies'];?></td>
								</tr>
								<tr>
									<td class="yellowclr edit-disabled">Additional Materials</td>
									<!-- <td id="additionalmaterials" class="yellowclr">0</td> -->
									<td field="additionalmaterials" id="additionalmaterials" class="yellowclr"><?php if(isset($row11['additionalmaterials']))echo $row11['additionalmaterials']; else echo "0";?></td>
								</tr>
								
								<tr>
								<td colspan="2" class="white edit-disabled" style="">
									<!-- <select name="gradestatus" id="gradestatus">
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select> -->
									<select name="gradestatus" id="gradestatus">
										<option value="yes" <?php if($row11['costtype'] == "yes") echo "selected";?> >Yes</option>
										<option value="no" <?php if($row11['costtype'] == "no") echo "selected";?> >No</option>
									</select>
								</td>
								</tr>
								<tr>
									
									<td colspan="2" class="white" style="padding: 0">
										<table style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;" cellspacing="0" cellpadding="0">
											<tbody>
												<tr>
													<td class="light_orangeclr edit-disabled" style="padding: 0px 10px;">Body Paint (Gallons)</td>
													<!-- <td id="wallpaint" class="light_greenclr edit-disabled" style="padding: 0px 10px;"></td> -->
													<td field="wallpaint" id="wallpaint" class="light_greenclr edit-disabled" style="padding: 0px 10px;"><?php if(isset($row11['wallpaint']))echo $row11['wallpaint'];?></td>
													<td class="white edit-disabled" style="padding: 0px 10px;">
														<select class="" name="wallpaintgrade" id="wallpaintgrade" 	onchange="paintgrade('wallpaintgrade',this.value)">
														<option value="">Select Grade</option>
															<?php
																$selected = "";
																if(isset($row11['wallpaintgrade']) && $row11['wallpaintgrade'] != "")
																{
																	$selected = $row11['wallpaintgrade'];
																}
																echo $db->CreateOptions("html", "paint_grade", array("id","paint_grade"),$selected,"","");
															?>
														</select>
													</td>
													<!-- <td id="wallpaintval" class="white edit-disabled">0</td>
													<td id="wallpaintcost" class="white edit-disabled allpaintcost">0</td> -->
													<td field="wallpaintval" id="wallpaintval" class="white edit-disabled"><?php if(isset($row11['wallpaintval']))echo $row11['wallpaintval']; else echo "0";?></td>
													<td field="wallpaintcost" id="wallpaintcost" class="white edit-disabled"><?php if(isset($row11['wallpaintcost']))echo $row11['wallpaintcost']; else echo "0";?></td>
												</tr>
												<tr>
													<td class="light_orangeclr edit-disabled" style="padding: 0px 10px;">Trim Paint (Gallons)</td>
													<!-- <td id="trimpaint" class="light_greenclr edit-disabled"  style="padding: 0px 10px;"></td> -->
													<td field="trimpaint" id="trimpaint" class="light_greenclr edit-disabled"  style="padding: 0px 10px;"><?php if(isset($row11['trimpaint']))echo $row11['trimpaint'];?></td>
													<td class="white edit-disabled" style="padding: 0px 10px;">
														<select class="" name="trimpaintgrade" id="trimpaintgrade" onchange="paintgrade('trimpaintgrade',this.value)">
														<option value="">Select Grade</option>
															<?php
																$selected = "";
																if(isset($row11['trimpaintgrade']) && $row11['trimpaintgrade'] != "")
																{
																	$selected = $row11['trimpaintgrade']; 
																}
																echo $db->CreateOptions("html", "paint_grade", array("id","paint_grade"),$selected,"","");
															?>
														</select>
													</td>
													<!-- <td id="trimpaintval" class="white edit-disabled">0</td>
													<td id="trimpaintcost" class="white edit-disabled allpaintcost">0</td> -->
													<td field="trimpaintval" id="trimpaintval" class="white edit-disabled"><?php if(isset($row11['trimpaintval']))echo $row11['trimpaintval']; else echo "0";?></td>
													<td field="trimpaintcost" id="trimpaintcost" class="white edit-disabled"><?php if(isset($row11['trimpaintcost']))echo $row11['trimpaintcost']; else echo "0";?></td>
												</tr>
												<tr>
													<td class="light_orangeclr  edit-disabled" style="padding: 0px 10px;">Primer (Gallons)</td>
													<!-- <td id="primer" class="light_greenclr" style="padding: 0px 10px;"></td> -->
													<td field="primer" id="primer" class="light_greenclr  edit-disabled" style="padding: 0px 10px;"><?php if(isset($row11['primer']))echo $row11['primer'];?></td>
													<td class="white edit-disabled" style="padding: 0px 10px;">
														<select class="" name="primergrade" id="primergrade" onchange="paintgrade('primergrade',this.value)">
														<option value="">Select Grade</option>
															<?php
																$selected = "";
																if(isset($row11['primer']) && $row11['primer'] != "")
																{
																	$selected = $row11['primer'];
																}
																echo $db->CreateOptions("html", "paint_grade", array("id","paint_grade"),$selected,"","");
															?>
														</select>
													</td>
													<!-- <td id="primerpaintval" class="white edit-disabled">0</td>
													<td id="primerpaintcost" class="white edit-disabled allpaintcost">0</td> -->
													<td field="primerpaintval" id="primerpaintval" class="white edit-disabled"><?php if(isset($row11['primerpaintval']))echo $row11['primerpaintval']; else echo "0";?></td>
													<td field="primerpaintcost" id="primerpaintcost" class="white edit-disabled"><?php if(isset($row11['primerpaintcost']))echo $row11['primerpaintcost']; else echo "0";?></td>
												</tr>
												<tr>
													<td class="light_orangeclr edit-disabled" style="padding: 0px 10px;">Specialty Paint (Gallons)</td>
													<!-- <td id="ceilingpaint" class="light_greenclr" style="padding: 0px 10px;"></td> -->
													<td field="ceilingpaint" id="ceilingpaint" class="light_greenclr edit-disabled" style="padding: 0px 10px;"><?php if(isset($row11['ceilingpaint']))echo $row11['ceilingpaint'];?></td>
													<td class="white edit-disabled" style="padding: 0px 10px;">
														<select class="" name="ceilinggrade" id="ceilinggrade" onchange="paintgrade('ceilinggrade',this.value)">
														<option value="">Select Grade</option>
															<?php
																$selected = "";
																if(isset($row11['ceilinggrade']) && $row11['ceilinggrade'] != "")
																{
																	$selected = $row11['ceilinggrade'];
																}
																echo $db->CreateOptions("html", "paint_grade", array("id","paint_grade"),$selected,"","");
															?>
														</select>
													</td>
													<!-- <td id="ceilingpaintval" class="white edit-disabled">0</td>
													<td id="ceilingpaintcost" class="white edit-disabled allpaintcost">0</td> -->
													<td field="ceilingpaintval" id="ceilingpaintval" class="white edit-disabled"><?php if(isset($row11['ceilingpaintval']))echo $row11['ceilingpaintval']; else echo "0";?></td>
													<td field="ceilingpaintcost" id="ceilingpaintcost" class="white edit-disabled"><?php if(isset($row11['ceilingpaintcost']))echo $row11['ceilingpaintcost']; else echo "0";?></td>
												</tr>
												
											</tbody>
										</table>
									</td>
								</tr>								
								<tr>
									<td class="light_orangeclr edit-disabled">Man Days</td>
									<!-- <td id="mandays" class="light_greenclr edit-disabled"></td> -->
									<td field="mandays" id="mandays" class="light_greenclr edit-disabled"><?php if(isset($row11['mandays']))echo $row11['mandays'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled">3 Men Per Day</td>
									<!-- <td id="manperday" class="light_greenclr edit-disabled"></td> -->
									<td field="manperday" id="manperday" class="light_greenclr edit-disabled"><?php if(isset($row11['manperday']))echo $row11['manperday'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr  edit-disabled">Adjusted hours</td>
									<!-- <td id="addhours" class="yellowclr">0</td> -->
									<td field="addhours" id="addhours" class="yellowclr"><?php if(isset($row11['addhours']))echo $row11['addhours']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled"><b>Budgeted Hours</b></td>
									<!-- <td id="budgethours" class="light_greenclr edit-disabled"></td> -->
									<td field="budgethours" id="budgethours" class="light_greenclr edit-disabled"><?php if(isset($row11['budgethours']))echo $row11['budgethours'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled"><b>Total of Gallons</b></td>
									<!-- <td id="totalgallons" class="light_greenclr edit-disabled"></td> -->
									<td field="totalgallons" id="totalgallons" class="light_greenclr edit-disabled"><?php if(isset($row11['totalgallons']))echo $row11['totalgallons'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled">Tax</td>
									<!-- <td id="tax" class="light_greenclr edit-disabled">0</td> -->
									<td field="tax" id="tax" class="light_greenclr edit-disabled"><?php if(isset($row11['tax']))echo $row11['tax']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled">Adjusted price:</td>
									<!-- <td id="addprice" class="yellowclr">0</td> -->
									<td field="addprice" id="addprice" class="yellowclr"><?php if(isset($row11['addprice']))echo $row11['addprice']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="light_orangeclr  edit-disabled"><b>Price in Dollars</b></td>
									<!-- <td id="priceindollars" class="light_greenclr  edit-disabled"></td> -->
									<td field="priceindollars" id="priceindollars" class="light_greenclr  edit-disabled"><?php if(isset($row11['priceindollars']))echo $row11['priceindollars'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr  edit-disabled"><b>Date to begin project:</b></td>
									<td class="yellowclr"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="input-field col m6" style="padding-left: 0px">
						<table id="costtable" class="table table-striped" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
								<tr>
									<td class="white edit-disabled">Sales Rate</td>
									<td id="salerate" class="white edit-disabled"><?php echo $db->FetchCellValue("rate_list","exterior_rate"," id = '1' " ); ?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Projected GP</td>
									<!-- <td id="projectgp" class="white ProjectedGP edit-disabled"></td> -->
									<td field="projectgp" id="projectgp" class="white ProjectedGP edit-disabled"><?php if(isset($row11['projectgp']))echo $row11['projectgp'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Sales Rate w/ Material</td>
									<!-- <td class="white edit-disabled" id="SalesRatewMaterial"></td> -->
									<td field="salesratewmaterial"  class="white edit-disabled" id="SalesRatewMaterial"><?php if(isset($row11['salesratewmaterial']))echo $row11['salesratewmaterial'];?></td>
								</tr>
								<tr>
									<td class="white">Average Wage w/ Burden</td>
									<!-- <td id="average" class="yellowclr avgburden">0</td> -->
									<td field="average" id="average" class="yellowclr avgburden"><?php if(isset($row11['average']))echo $row11['average']; else echo "0";?></td>
								</tr>
								<tr>
									<td colspan=2 class="white" style="padding:0px;">
										<table  style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;" cellspacing="0" cellpadding="0">
											<tr>
												<td class="white edit-disabled" style="padding: 0px 0px 0px 10px;">Gap %</td>
												<!-- <td id="gappercent" class="yellowclr avgburden" style="padding: 0px 0px 0px 10px;">0</td>
												<td id="gaprate" class="white edit-disabled" >0</td> -->
												<td field="gappercent" id="gappercent" class="yellowclr avgburden" style="padding: 0px 0px 0px 10px;"><?php if(isset($row11['gappercent']))echo $row11['gappercent']; else echo "0";?></td>
												<td field="gaprate" id="gaprate" class="white edit-disabled" ><?php if(isset($row11['gaprate']))echo $row11['gaprate']; else echo "0";?></td>
											</tr>
										</table>
									</td>
									
								</tr>
								<tr>
									<td class="white edit-disabled">Hr Labor Rate w/ Burden & Gap</td>
									<!-- <td id="sumof" class="white edit-disabled"></td> -->
									<td field="sumof" id="sumof" class="white edit-disabled"><?php if(isset($row11['sumof']))echo $row11['sumof'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor Rate Charged</td>
									<!-- <td id="laborratecharged" class="white edit-disabled"></td> -->
									<td field="laborratecharged" id="laborratecharged" class="white edit-disabled"><?php if(isset($row11['laborratecharged']))echo $row11['laborratecharged'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor GP %</td>
									<!-- <td id="laborgp" class="white edit-disabled"></td> -->
									<td field="laborgp" id="laborgp" class="white edit-disabled"><?php if(isset($row11['laborgp']))echo $row11['laborgp'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor Total</td>
									<!-- <td id="labortotal" class="white edit-disabled"></td> -->
									<td field="labortotal" id="labortotal" class="white edit-disabled"><?php if(isset($row11['labortotal']))echo $row11['labortotal'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Actual Labor Costs</td>
									<!-- <td id="actualcost" class="white">0</td> -->
									<td field="actualcost" id="actualcost" class="white edit-disabled"><?php if(isset($row11['actualcost']))echo $row11['actualcost']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor Profit/Contr. to Overhead</td>
									<!-- <td id="laboroverhead" class="white edit-disabled"></td> -->
									<td field="laboroverhead" id="laboroverhead" class="white edit-disabled"><?php if(isset($row11['laboroverhead']))echo $row11['laboroverhead'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Material Total</td>
									<!-- <td id="materialtotal" class="white edit-disabled"></td> -->
									<td field="materialtotal" id="materialtotal" class="white edit-disabled"><?php if(isset($row11['materialtotal']))echo $row11['materialtotal'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Mat % of Job</td>
									<!-- <td id="matpercent" class="white edit-disabled"></td> -->
									<td field="matpercent" id="matpercent" class="white edit-disabled"><?php if(isset($row11['matpercent']))echo $row11['matpercent'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Additional Fixed Costs</td>
									<!-- <td id="fixedcost" class="white">0</td> -->
									<td field="fixedcost" id="fixedcost" class="white"><?php if(isset($row11['fixedcost']))echo $row11['fixedcost']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Total Job Costs</td>
									<!-- <td id="totaljobcost" class="white edit-disabled"></td> -->
									<td field="totaljobcost" id="totaljobcost" class="white edit-disabled"><?php if(isset($row11['totaljobcost']))echo $row11['totaljobcost'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Total Job Amount</td>
									<!-- <td id="totaljobamount" class="white edit-disabled"></td> -->
									<td field="totaljobamount" id="totaljobamount" class="white edit-disabled"><?php if(isset($row11['totaljobamount']))echo $row11['totaljobamount'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">% of GP for Comm.</td>
									<td class="yellowclr">0</td>
								</tr>
								<tr>
									<td class="white edit-disabled">Expected Commission</td>
									<td class="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								</tr>
						</table>
						<!-- <div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="form_externalsummary()" value="<?php echo $button; ?> Summary" name="submit">
						   </i>
						</div>
						<div class="input-field col s12 mya" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<a id="createproposal" class="waves-button-input" href="<?php echo SITE_ROOT."/proposalext.php?project_id=".$_REQUEST['project_id'];?>"><?php echo $button; ?> Proposal</a>
						   </i>
						</div> -->
						<!-- <div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?> Customer Contact" name="submit">
						   </i>
						</div> -->
						<!--  <iframe src="<?= SITE_ROOT; ?>/classes/phpword2/samples/contractext.php<?php echo "?project_id=".$_REQUEST['project_id']; ?>"  width="300" height="57" style="float: right;" frameBorder="0" scrolling="no"></iframe>
						<div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?> Work Order" name="submit">
						   </i>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
$('#mainTable').editableTableWidget();
$('#mainTable1').editableTableWidget({disableClass: "edit-disabled"});
$('#costtable').editableTableWidget({disableClass: "edit-disabled"});
$(function(){
 $('#extsummary').addClass('active');
});

$(document).ready(function(){
	var preparation = 0;
	var paintapp = 0;
	var mis = 0;
	var laborcost = 0;
	var wpaint = 0;
	var cpaint = 0;
	var tpaint = 0;
	var pg = 0;
	var budhour = 0;
	var totalgallon = 0;
	var mandays = 0;
	var manperday = 0;
	var tax = 0;
	var addprice = 0;
	var priceindollars = 0;
	var laborratecharged = 0;
	$('td.Preparation').each(function(){
		try{
			if(parseFloat($(this).html()) > 0)
			{
				preparation += parseFloat($(this).html());
			}
		}catch(err){}
	});
	$("#Preparationtime").html((preparation).toFixed(2));
	
	$('td.papp').each(function(){
		try{
			if(parseFloat($(this).html()))
			{
				paintapp += parseFloat($(this).html());
			}
		}catch(err){}
	});
	$("#paintapplication").html((paintapp).toFixed(2));
	
	$('td.miscell').each(function(){
		try{
			if(parseFloat($(this).html()))
			{
				mis += parseFloat($(this).html());
			}
		}catch(err){}
		
	});
	$("#Miscellaneous").html(mis);
	
	
	var l = preparation + paintapp + mis;
	var lbcost = '<?php echo $db->FetchCellValue("rate_list","exterior_rate"," id = '1'" ); ?>';
	laborcost = l*lbcost;
	$("#Laborcost").html((laborcost).toFixed(2));
	
	
	$('td.tpgallons').each(function(){
		try{
			if(parseFloat($(this).html()))
			{
				tpaint += parseFloat($(this).html());
			}
		}catch(err){}
		
	});
	$("#trimpaint").html((tpaint).toFixed(2));
		
	$('td.wpgallons').each(function(){
		try{
			if(parseFloat($(this).html()))
			{
				wpaint += parseFloat($(this).html());
			}
		}catch(err){}
		
	});
	$("#wallpaint").html((wpaint).toFixed(2));
	pg = $('#primerpaintcost').html();
	cpaint = $('#ceilingpaintcost').html();
	totalgallon = parseFloat(wpaint) + parseFloat(cpaint) + parseFloat(tpaint) + parseFloat(pg);
	$("#totalgallons").html(totalgallon);
	
	laborratecharged = $('#salerate').html();
	$('#laborratecharged').html(laborratecharged);
	
	var paint_rate = parseFloat(<?php $paint_rate = $db->FetchCellValue("rate_list","exterior_rate"," id = '1'"); echo $paint_rate;?>);
	/*var faux_mural = parseFloat(<?php $faux_mural = $db->FetchCellValue("rate_list","exterior_rate"," id = '2'"); echo $faux_mural;?>);*/
	var laborcost = parseFloat((mis+paintapp+preparation)*paint_rate);
	$("#Laborcost").html((laborcost).toFixed(2));
	$("#labortotal").html((laborcost).toFixed(2));
	
	$("#laborratecharged").html(paint_rate);
	var additionalhours = parseFloat($("#addhours").html());
	budhour = parseFloat(mis) + parseFloat(paintapp) + parseFloat(preparation) + parseFloat(additionalhours);
	$("#budgethours").html(budhour);
	mandays = parseFloat(totalgallon/8);
	$("#mandays").html(mandays);
	
	manperday = parseFloat(mandays/3);
	$("#manperday").html((manperday).toFixed(2));
	$("#SalesRatewMaterial").html(parseFloat(priceindollars/budhour));
	
	$('table td.avgburden').on('change', function(evt, newValue) {
		var avg = 0;
		var percent = 0;
		var val = 0;
		var sumof = 0;
		var laborgp = 0;
		var actualcost = 0;
		
		avg = $('#average').html();
		percent = $('#gappercent').html();
		val = avg*(percent/100);
			$('#gaprate').html(parseFloat(val));
		sumof = parseFloat(avg) + parseFloat(val);
			$('#sumof').html(parseFloat(sumof));
		laborgp =  (parseFloat(laborratecharged) - parseFloat(sumof))/parseFloat(laborratecharged);
			$('#laborgp').html(parseFloat(laborgp*100));
		a = laborcost * (laborgp);
			$('#laboroverhead').html(Math.abs(a));
		actualcost = parseFloat(laborcost) + parseFloat(Math.abs(a)); 
			$('#actualcost').html(parseFloat(actualcost));
	});
	
	
	$('#costtype').change(function(){
		typeval = $(this).val();
		miscell1 = $('#miscellaneous1').html();
		miscell2 = $('#miscellaneous2').html();
		miscell3 = $('#miscellaneous3').html();
		miscell4 = $('#miscellaneous4').html();
		additionalmaterials = $('#additionalmaterials').html();
		addhours = $('#addhours').html();
		addprice = $('#addprice').html();
		tax = $('#tax').html();
		cpergallon =  parseFloat(<?php $cpergallon = $db->FetchCellValue("rate_list","exterior_rate"," id = '3'"); echo $cpergallon;?>);
		paint =  parseFloat(<?php $paint = $db->FetchCellValue("rate_list","exterior_rate"," id = '1'"); echo $paint;?>);
		material =  parseFloat(<?php $paint = $db->FetchCellValue("rate_list","exterior_rate"," id = '4'"); echo $paint;?>);
		if(typeval == 'bygallon'){
			
			
			/*Walls: Paint 0 to 9 by gollon */
				/*wp09t = parseFloat($('#sum_wpaint09_time').html());
				wp09g = parseFloat($('#sum_wpaint09_gals').html());
				wp09_price = (wp09g * cpergallon) + (wp09t * paint);
				$('#wp09_price').html(wp09_price);*/
				
			$('td.pricefield').each(function(){
				var parentobj = $(this).parent();
				var g = parentobj.find('td:nth-child(2)').html();
				var t = parentobj.find('td:nth-child(3)').html();
				var p = (g * cpergallon) + (t * paint);
				$(parentobj.find('td:last-child')).html(parseFloat((p).toFixed(2)));
			});
			
			
			
		}
		else{
			m =  parseFloat(<?php $cpergallon = $db->FetchCellValue("rate_list","exterior_rate"," id = '4'"); echo $cpergallon;?>);
			/*console.log("if -- "+m);*/
			s = parseFloat(laborcost) * (m/100);
			/*console.log("if -- "+s); */
			$('#costvalue').html(s);
			/*alert("costvalue -- "+s);*/
			$('#softsupplies').html(s * 0.15);
			
			
			
			priceindollars =  parseFloat(miscell1) +  parseFloat(miscell2) +  parseFloat(miscell3) +  parseFloat(miscell4) + s +  parseFloat(laborcost) +  parseFloat(additionalmaterials) +  parseFloat(addprice) +  parseFloat((addhours*paint)) +  parseFloat(tax) + parseFloat((s*0.15));
			/*alert(priceindollars);*/ 
			$('#priceindollars').html(priceindollars);
			
			materialtotal =  parseFloat(additionalmaterials) + s + parseFloat((s*0.15)); 
			$("#materialtotal").html(materialtotal);
			matpercent = parseFloat((materialtotal/priceindollars)*100);
			$("#matpercent").html(matpercent);
			
			/*Walls: Paint 0 to 9 per percent */
				/*wp09t = parseFloat($('#sum_wpaint09_time').html());
				wp09_price = (wp09t * paint * (material/100)) + (wp09t * paint);
				$('#wp09_price').html(wp09_price);*/
				
			$('td.pricefield').each(function(){
				var parentobj1 = $(this).parent();
				var t1 = parentobj1.find('td:nth-child(3)').html();
				var p1 = (t1 * paint * (material/100)) + (t1 * paint);
				$(parentobj1.find('td:last-child')).html(parseFloat((p1).toFixed(2)));
			});
			
			fixedcost = $('#fixedcost').html();
			actualcost = $('#actualcost').html();
			totaljobcost =  parseFloat(fixedcost) +  parseFloat(materialtotal) +  parseFloat(actualcost);
			/*console.log(" fixedcost -- "+fixedcost+" materialtotal -- "+materialtotal+" actualcost -- "+actualcost);*/
			 $('#totaljobcost').html(totaljobcost);
			
			p = parseFloat((priceindollars-totaljobcost));
			projectgp = parseFloat((p*100))/parseFloat(priceindollars);
			/*console.log("else -- "+projectgp);*/
			$('#projectgp').html(projectgp);
		}
		$('#gradestatus').change();
	});
	
	$('#gradestatus').change(function(){
		statval = $(this).val();
		statval123 = $("#costtype").val();
		
			if(statval123 == 'bygallon'){
				if(statval == 'yes'){
				w = $('#wallpaintcost').html();
				c = $('#ceilingpaintcost').html();
				t = $('#trimpaintcost').html();
				p = $('#primerpaintcost').html();
				s = parseFloat(w)+parseFloat(c)+parseFloat(t)+parseFloat(p);
				$('#costvalue').html(s);
				$('#softsupplies').html(s * 0.15);
				
				priceindollars =  parseFloat(miscell1) +  parseFloat(miscell2) +  parseFloat(miscell3) +  parseFloat(miscell4) + s +  parseFloat(laborcost) +  parseFloat(additionalmaterials) +  parseFloat(addprice) +  parseFloat((addhours*paint)) +  parseFloat(tax) + parseFloat((s*0.15));
				$('#priceindollars').html((priceindollars).toFixed(2));
				$('#totaljobamount').html((priceindollars).toFixed(2));
				
				
				
				materialtotal =  parseFloat(additionalmaterials) + s + parseFloat((s*0.15)); 
				$("#materialtotal").html(materialtotal);
				
				matpercent = parseFloat((materialtotal/priceindollars)*100);
				$("#matpercent").html(matpercent);
				
				fixedcost = $('#fixedcost').html();
				actualcost = $('#actualcost').html();
				totaljobcost =  parseFloat(fixedcost) +  parseFloat(materialtotal) +  parseFloat(actualcost);
				/*console.log(" fixedcost -- "+fixedcost+" materialtotal -- "+materialtotal+" actualcost -- "+actualcost);*/
				$('#totaljobcost').html(totaljobcost);
				
				p = parseFloat((priceindollars-totaljobcost));
				projectgp = parseFloat((p*100))/parseFloat(priceindollars);
				/*console.log("if -- "+projectgp);*/
				$('#projectgp').html(projectgp);
			}
			else{
				pg = $('#primerpaintcost').html();
				cpaint = $('#ceilingpaintcost').html();
				totalgallon = parseFloat(wpaint) + parseFloat(cpaint) + parseFloat(tpaint) + parseFloat(pg);
				$("#totalgallons").html(totalgallon);
				m =  parseFloat(<?php $cpergallon = $db->FetchCellValue("rate_list","exterior_rate"," id = '3'"); echo $cpergallon;?>);
				s = totalgallon * m;
				$('#costvalue').html(s);
				$('#softsupplies').html(s * 0.15);
				
				priceindollars =  parseFloat(miscell1) +  parseFloat(miscell2) +  parseFloat(miscell3) +  parseFloat(miscell4) + s +  parseFloat(laborcost) +  parseFloat(additionalmaterials) +  parseFloat(addprice) +  parseFloat((addhours*paint)) +  parseFloat(tax) + parseFloat((s*0.15));
				$('#priceindollars').html((priceindollars).toFixed(2));
				$('#totaljobamount').html((priceindollars).toFixed(2));
				
				materialtotal =  parseFloat(additionalmaterials) + s + parseFloat((s*0.15)); 
				$("#materialtotal").html(materialtotal);
				
				matpercent = parseFloat((materialtotal/priceindollars)*100);
				$("#matpercent").html(matpercent);
				
				fixedcost = $('#fixedcost').html();
				actualcost = $('#actualcost').html();
				totaljobcost =  parseFloat(fixedcost) +  parseFloat(materialtotal) +  parseFloat(actualcost);
				/*console.log(" fixedcost -- "+fixedcost+" materialtotal -- "+materialtotal+" actualcost -- "+actualcost);*/
				$('#totaljobcost').html(totaljobcost);
				
				p = parseFloat((priceindollars-totaljobcost));
				projectgp = parseFloat((p*100))/parseFloat(priceindollars);
				/*console.log("if -- "+projectgp);*/
				$('#projectgp').html(projectgp);
			}
		}
		
	}); 
	$('#costtype, #gradestatus').change();
	$('table td.avgburden').on('change', function(evt, newValue) {});
	$("#headingSearchtitle").html("Exterior Summary");
});


function paintgrade(name,id){
	$('#gradestatus').change();
	/*alert(id); */
	/*alert(name);*/
	var grade = {};
	grade = <?php echo json_encode($val);?>;
	if(name == 'wallpaintgrade'){
		$('#wallpaintval').html(grade[$("#wallpaintgrade").val()]['exterior_rate']);
		var w = 0;
		var v = 0;
		v = grade[$("#wallpaintgrade").val()]['exterior_rate'];
		w = $('#wallpaint').html();
		$('#wallpaintcost').html((v*w).toFixed(2));
	}
	if(name == 'ceilinggrade'){
		$('#ceilingpaintval').html(grade[$("#ceilinggrade").val()]['exterior_rate']);
		var w = 0;
		var v = 0;
		v = grade[$("#ceilinggrade").val()]['exterior_rate'];
		w = $('#ceilingpaint').html();
		$('#ceilingpaintcost').html((v*w).toFixed(2));
	}
	
	if(name == 'trimpaintgrade'){
		$('#trimpaintval').html(grade[id]['exterior_rate']);
		var w = 0;
		var v = 0;
		v = grade[id]['exterior_rate'];
		w = $('#trimpaint').html();
		$('#trimpaintcost').html((v*w).toFixed(2));
	}
	
	if(name == 'primergrade'){
		$('#primerpaintval').html(grade[id]['exterior_rate']);
		var w = 0;
		var v = 0;
		v = grade[id]['exterior_rate'];
		w = $('#primer').html();
		$('#primerpaintcost').html((v*w).toFixed(2));
	}
	
	
	
	/*alert($("#wallpaintgrade").val());
	<td id="wallpaintval" class="white">0</td>
	<td id="wallpaintcost" class="white">0</td>
	*/
	
}
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
   $(".specialclass").fixMe();
   $(".specialclass2").fixMe();
   $("#exteriorli").addClass("active");
   $("#exteriorlidiv").show();
});
</script>