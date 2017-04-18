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
$table88 = "int_estimates";

if(isset($_REQUEST['project_id'])){
	$condition88 = "i.project_id = '".$_REQUEST['project_id']."' ";
	$main_table88 = array("$table88 i",array());
	$join_tables88 = array(
		array('left','internal_estimate c','c.estimate_id = i.id', array('sum(c.wpaint09_gals) as sum_wpaint09_gals','sum(c.wpaint09_time) as sum_wpaint09_time','sum(c.wpaint09_quantity) as sum_wpaint09_quantity','sum(c.wpaint9_gals) as sum_wpaint9_gals','sum(c.wpaint9_time) as sum_wpaint9_time','sum(c.wpaint9_quantity) as sum_wpaint9_quantity','sum(c.cpaint_gals) as sum_cpaint_gals','sum(c.cpaint_time) as sum_cpaint_time','sum(c.cpaint_quantity) as sum_cpaint_quantity','sum(c.cw_time_time) as sum_cw_time_time','sum(c.cw_time_quantity) as sum_cw_time_quantity','sum(c.dflat_gals) as sum_dflat_gals','sum(c.dflat_time) as sum_dflat_time','sum(c.dflat_quantity) as sum_dflat_quantity','sum(c.dpaneled_gals) as sum_dpaneled_gals','sum(c.dpaneled_time) as sum_dpaneled_time','sum(c.dpaneled_quantity) as sum_dpaneled_quantity','sum(c.dfrench_gals) as sum_dfrench_gals','sum(c.dfrench_time) as sum_dfrench_time','sum(c.dfrench_quantity) as sum_dfrench_quantity','sum(c.dframes_gals) as sum_dframes_gals','sum(c.dframes_time) as sum_dframes_time','sum(c.dframes_quantity) as sum_dframes_quantity','sum(c.dtime_time) as sum_dtime_time','sum(c.dtime_quantity) as sum_dtime_quantity','sum(c.wcasement_gals) as sum_wcasement_gals','sum(c.wcasement_time) as sum_wcasement_time','sum(c.wcasement_quantity) as sum_wcasement_quantity','sum(c.w1_1_gals) as sum_w1_1_gals','sum(c.w1_1_time) as sum_w1_1_time','sum(c.w1_1_quantity) as sum_w1_1_quantity','sum(c.w3_7_panel_gals) as sum_w3_7_panel_gals','sum(c.w3_7_panel_time) as sum_w3_7_panel_time','sum(c.w3_7_panel_quantity) as sum_w3_7_panel_quantity','sum(c.w8_16_panel_gals) as sum_w8_16_panel_gals','sum(c.w8_16_panel_time) as sum_w8_16_panel_time','sum(c.w8_16_panel_quantity) as sum_w8_16_panel_quantity','sum(c.w16_panel_gals) as sum_w16_panel_gals','sum(c.w16_panel_time) as sum_w16_panel_time','sum(c.w16_panel_quantity) as sum_w16_panel_quantity','sum(c.wtime_time) as sum_wtime_time','sum(c.wtime_quantity) as sum_wtime_quantity','sum(c.baseboards_gals) as sum_baseboards_gals','sum(c.baseboards_time) as sum_baseboards_time','sum(c.baseboards_quantity) as sum_baseboards_quantity','sum(c.baseboardstime_time) as sum_baseboardstime_time','sum(c.baseboardstime_quantity) as sum_baseboardstime_quantity','sum(c.chairrail_gals) as sum_chairrail_gals','sum(c.chairrail_time) as sum_chairrail_time','sum(c.chairrail_quantity) as sum_chairrail_quantity','sum(c.chairrail_time_time) as sum_chairrail_time_time','sum(c.chairrail_time_quantity) as sum_chairrail_time_quantity','sum(c.crownmolding_gals) as sum_crownmolding_gals','sum(c.crownmolding_time) as sum_crownmolding_time','sum(c.crownmolding_quantity) as sum_crownmolding_quantity','sum(c.crownmolding_time_time) as sum_crownmolding_time_time','sum(c.crownmolding_time_quantity) as sum_crownmolding_time_quantity','sum(c.closets_time) as sum_closets_time_time','sum(c.closets_quantity) as sum_closets_time_quantity','sum(c.cabinetry_gals) as sum_cabinetry_gals','sum(c.cabinetry_time) as sum_cabinetry_time','sum(c.cabinetry_quantity) as sum_cabinetry_quantity','sum(c.polesand_time) as sum_polesand_time','sum(c.polesand_quantity) as sum_polesand_quantity','sum(c.furniture_quantity) as sum_furniture_quantity','sum(c.furniture_time) as sum_furniture_time','sum(c.furniture_gals) as sum_furniture_gals','sum(c.cleantouchup_quantity) as sum_cleantouchup_quantity','sum(c.cleantouchup_time) as sum_cleantouchup_time','sum(c.cleantouchup_gals) as sum_cleantouchup_gals','sum(c.maskcover_time) as sum_maskcover_time','sum(c.maskcover_quantity) as sum_maskcover_quantity','sum(c.rrhardware_time) as sum_rrhardware_time','sum(c.rrhardware_quantity) as sum_rrhardware_quantity','sum(c.prepwoodwork_time) as sum_prepwoodwork_time','sum(c.prepwoodwork_quantity) as sum_prepwoodwork_quantity','sum(c.wallpaper_removal_gals) as sum_wallpaper_removal_gals','sum(c.wallpaper_removal_time) as sum_wallpaper_removal_time','sum(c.wallpaper_removal_quantity) as sum_wallpaper_removal_quantity','sum(c.patchtexture_gals) as sum_patchtexture_gals','sum(c.patchtexture_time) as sum_patchtexture_time','sum(c.patchtexture_quantity) as sum_patchtexture_quantity','sum(c.wprime_gals) as sum_wprime_gals','sum(c.wprime_time) as sum_wprime_time','sum(c.wprime_quantity) as sum_wprime_quantity','sum(c.cprime_gals) as sum_cprime_gals','sum(c.cprime_time) as sum_cprime_time','sum(c.cprime_quantity) as sum_cprime_quantity','sum(c.skimcoat_gals) as sum_skimcoat_gals','sum(c.skimcoat_time) as sum_skimcoat_time','sum(c.skimcoat_quantity) as sum_skimcoat_quantity','sum(c.bullnosewall_time) as sum_bullnosewall_time','sum(c.bullnosewall_quantity) as sum_bullnosewall_quantity','sum(c.faux_time) as sum_faux_time','sum(c.faux_quantity) as sum_faux_quantity','sum(c.miscellaneous1_time) as sum_miscellaneous1_time','sum(c.miscellaneous1_quantity) as sum_miscellaneous1_quantity','sum(c.miscellaneous2_time) as sum_miscellaneous2_time','sum(c.miscellaneous2_quantity) as sum_miscellaneous2_quantity','sum(c.miscellaneous3_time) as sum_miscellaneous3_time','sum(c.miscellaneous3_quantity) as sum_miscellaneous3_quantity'))
	);
	$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
	$row = mysql_fetch_array($rs1);
	//print_r($row);
	
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
$table888 = "internal_summary";

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
<script>
function form_internalsummary(){
	
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
		url: '<?php echo BASEPATH;?>/project/addintsummary', 
		type: 'post',
		cache: false,
		data: poststring,
		success: function (response) {                    
			var res = eval('('+response+')');
			if(res['success'] == "1"){
				swal({   title: "Do you want to continue?",   
						 text: "You have successfully update Interior Summary. Do you want to proceed to the Dashboard?",   
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
								 location.href = "<?= SITE_ROOT; ?>/project/internal_summary?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
						});
			}
			
			//console.log(res->success);
		}
	}); 
}
</script>
<style>
.card-title.grey-text.text-darken-4 p{
	margin:10px 0px;
}
.mywidth{
	width:25%;
}
.mya a{
font-style:normal !important;
color:white !important;
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
					<a data-delay="50" data-tooltip="Next To Project" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/internal_hrs_tracking?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#b71c1c;" class="mdi-hardware-keyboard-arrow-right"></i>
					</a>
					<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#b71c1c;" class="mdi-content-clear"></i>
					</a>
					<a data-delay="50" data-tooltip="Previous To Project" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/internal_pricing?project_id=".$_REQUEST['project_id']; ?>">
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
				</div>
			</li>
		</ul>
	</div>
</div>
<div class="col s12 m12 l12">
	<div class="row" style="position: fixed; top: 64px; width: 100%; max-width: calc(100% - 550px); text-align: center;padding-bottom:5px;background:#f2f2f2; z-index: 9;">
		<div class="input-field col m2 s12">
		   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;padding: 0px; width: 96%; display: inline-block; float: none;">
			<input id="submit" class="waves-button-input" type="button" onclick="javascript:form_internalsummary()" value="<?php echo $button; ?> Summary" name="submit" style="">
		   </i>
		</div>
		<div class="input-field col m3 s12 mya">
		   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;padding: 0px; width: 96%; display: inline-block; float: none;">
			<a id="createproposal" class="waves-button-input" style="width: 175px;" href="<?php echo SITE_ROOT."/proposal.php?project_id=".$_REQUEST['project_id'];?>"><?php echo $button; ?> Proposal</a>
		   </i>
		</div>
		<div class="input-field col m4 s12">
		<iframe src="<?= SITE_ROOT; ?>/classes/phpword2/samples/contractint.php<?php echo "?project_id=".$_REQUEST['project_id']; ?>"  width="300" height="57" style="float: right;" frameBorder="0" scrolling="no"></iframe>
		</div>
		<div class="input-field col m3 s12">
		   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;padding: 0px; width: 96%; display: inline-block; float: none;">
			<input class="waves-button-input" type="button" value="<?php echo $button; ?> Work Order" disabled style="width: 175px;">
		   </i>
		</div>
	</div>
	
<div class="card-panel" style="margin-top: 45px; margin-bottom: 0px; padding-bottom: 0px;">
	<div id="row-grouping" class="section" style="padding-top: 0px;">
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
								<td field="" class="dark_blueclr edit-disabled">Walls: Paint 0 to 9</td>
								<td field="" id="sum_wpaint09_gals" class="white edit-disabled wpgallons"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
								<td field="" id="sum_wpaint09_time" class="white edit-disabled papp"><?php if(isset($row['sum_wpaint09_time']))echo $row['sum_wpaint09_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_quantity']))echo $row['sum_wpaint09_quantity'];?></td>
								<td field="wpaint09_price" id="wp09_price" class="white edit-disabled pricefield"><?php if(isset($row11['wpaint09_price']))echo $row11['wpaint09_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr edit-disabled">Walls: Paint 9 or more</td>
								<td field="" class="white edit-disabled wpgallons"><?php if(isset($row['sum_wpaint9_gals']))echo $row['sum_wpaint9_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_wpaint9_time']))echo $row['sum_wpaint9_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint9_quantity']))echo $row['sum_wpaint9_quantity'];?></td>
								<td field="wpaint9_price" class="white edit-disabled pricefield"><?php if(isset($row11['wpaint9_price']))echo $row11['wpaint9_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Ceilings: Paint</td>
								<td field="" class="white edit-disabled cpgallons"><?php if(isset($row['sum_cpaint_gals']))echo $row['sum_cpaint_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_cpaint_time']))echo $row['sum_cpaint_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_cpaint_quantity']))echo $row['sum_cpaint_quantity'];?></td>
								<td field="cpaint_price" class="white edit-disabled pricefield"><?php if(isset($row11['cpaint_price']))echo $row11['cpaint_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Ceiling & Walls: +/- Time</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_cw_time_time']))echo $row['sum_cw_time_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_cw_time_quantity']))echo $row['sum_cw_time_quantity'];?></td>
								<td field="cwpaint_price" class="white edit-disabled pricefield"><?php if(isset($row11['cwpaint_price']))echo $row11['cwpaint_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors: Flat</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_dflat_gals']))echo $row['sum_dflat_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_dflat_time']))echo $row['sum_dflat_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_dflat_quantity']))echo $row['sum_dflat_quantity'];?></td>
								<td field="dflat_price" class="white edit-disabled pricefield"><?php if(isset($row11['dflat_price']))echo $row11['dflat_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors: Paneled</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_dpaneled_gals']))echo $row['sum_dpaneled_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_dpaneled_time']))echo $row['sum_dpaneled_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_dpaneled_quantity']))echo $row['sum_dpaneled_quantity'];?></td>
								<td field="dpaneled_price" class="white edit-disabled pricefield"><?php if(isset($row11['dpaneled_price']))echo $row11['dpaneled_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors: French</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_dfrench_gals']))echo $row['sum_dfrench_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_dfrench_time']))echo $row['sum_dfrench_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_dfrench_quantity']))echo $row['sum_dfrench_quantity'];?></td>
								<td field="dfrench_price" class="white edit-disabled pricefield"><?php if(isset($row11['dfrench_price']))echo $row11['dfrench_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors: Frames</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_dframes_gals']))echo $row['sum_dframes_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_dframes_time']))echo $row['sum_dframes_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_dframes_quantity']))echo $row['sum_dframes_quantity'];?></td>
								<td field="dframes_price" class="white edit-disabled pricefield"><?php if(isset($row11['dframes_price']))echo $row11['dframes_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors: +/- Time</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_dtime_time']))echo $row['sum_dtime_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_dtime_quantity']))echo $row['sum_dtime_quantity'];?></td>
								<td field="dtime_price" class="white edit-disabled pricefield"><?php if(isset($row11['dtime_price']))echo $row11['dtime_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows: Casement</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_wcasement_gals']))echo $row['sum_wcasement_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_wcasement_time']))echo $row['sum_wcasement_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wcasement_quantity']))echo $row['sum_wcasement_quantity'];?></td>
								<td field="wcasement_price" class="white edit-disabled pricefield"><?php if(isset($row11['wcasement_price']))echo $row11['wcasement_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows: 1/1</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_w1_1_gals']))echo $row['sum_w1_1_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_w1_1_time']))echo $row['sum_w1_1_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_w1_1_quantity']))echo $row['sum_w1_1_quantity'];?></td>
								<td field="w1_1_price" class="white edit-disabled pricefield"><?php if(isset($row11['w1_1_price']))echo $row11['w1_1_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows: 3-7 Panel</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_w3_7_panel_gals']))echo $row['sum_w3_7_panel_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_w3_7_panel_time']))echo $row['sum_w3_7_panel_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_w3_7_panel_quantity']))echo $row['sum_w3_7_panel_quantity'];?></td>
								<td field="w3_7_panel_price" class="white edit-disabled pricefield"><?php if(isset($row11['w3_7_panel_price']))echo $row11['w3_7_panel_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows: 8-16 Panel</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_w8_16_panel_gals']))echo $row['sum_w8_16_panel_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_w8_16_panel_time']))echo $row['sum_w8_16_panel_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_w8_16_panel_quantity']))echo $row['sum_w8_16_panel_quantity'];?></td>
								<td field="w8_16_panel_price" class="white edit-disabled pricefield"><?php if(isset($row11['w8_16_panel_price']))echo $row11['w8_16_panel_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows: 16 + Panel</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_w16_panel_gals']))echo $row['sum_w16_panel_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_w16_panel_time']))echo $row['sum_w16_panel_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_w16_panel_quantity']))echo $row['sum_w16_panel_quantity'];?></td>
								<td field="w16_panel_price" class="white edit-disabled pricefield"><?php if(isset($row11['w16_panel_price']))echo $row11['w16_panel_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows: +/- Time</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_wtime_time']))echo $row['sum_wtime_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wtime_quantity']))echo $row['sum_wtime_quantity'];?></td>
								<td field="wtime_price" class="white edit-disabled pricefield"><?php if(isset($row11['wtime_price']))echo $row11['wtime_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Baseboards</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_baseboards_gals']))echo $row['sum_baseboards_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_baseboards_time']))echo $row['sum_baseboards_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_baseboards_quantity']))echo $row['sum_baseboards_quantity'];?></td>
								<td field="baseboards_price" class="white edit-disabled pricefield"><?php if(isset($row11['baseboards_price']))echo $row11['baseboards_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Baseboards: +/- Time</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_baseboardstime_time']))echo $row['sum_baseboardstime_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_baseboardstime_quantity']))echo $row['sum_baseboardstime_quantity'];?></td>
								<td field="baseboards_time_price" class="white edit-disabled pricefield"><?php if(isset($row11['baseboards_time_price']))echo $row11['baseboards_time_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Chair Rail</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_chairrail_gals']))echo $row['sum_chairrail_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_chairrail_time']))echo $row['sum_chairrail_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_chairrail_quantity']))echo $row['sum_chairrail_quantity'];?></td>
								<td field="chairrail_price" class="white edit-disabled pricefield"><?php if(isset($row11['chairrail_price']))echo $row11['chairrail_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Chair Rail: +/- Time</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_chairrail_time_time']))echo $row['sum_chairrail_time_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_chairrail_time_quantity']))echo $row['sum_chairrail_time_quantity'];?></td>
								<td field="chairrail_time_price" class="white edit-disabled pricefield"><?php if(isset($row11['chairrail_time_price']))echo $row11['chairrail_time_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Crown Molding</td>
								<td field="" class="white edit-disabled tpgallons"><?php if(isset($row['sum_crownmolding_gals']))echo $row['sum_crownmolding_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_crownmolding_time']))echo $row['sum_crownmolding_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_crownmolding_quantity']))echo $row['sum_crownmolding_quantity'];?></td>
								<td field="crownmolding_price" class="white edit-disabled pricefield"><?php if(isset($row11['crownmolding_price']))echo $row11['crownmolding_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Crown Molding: +/- Time</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_crownmolding_time_time']))echo $row['sum_crownmolding_time_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_crownmolding_time_quantity']))echo $row['sum_crownmolding_time_quantity'];?></td>
								<td field="crownmolding_time_price" class="white edit-disabled pricefield"><?php if(isset($row11['crownmolding_time_price']))echo $row11['crownmolding_time_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Closets</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_closets_time_time']))echo $row['sum_closets_time_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_closets_time_quantity']))echo $row['sum_closets_time_quantity'];?></td>
								<td field="closets_price" class="white edit-disabled pricefield"><?php if(isset($row11['closets_price']))echo $row11['closets_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Cabinetry</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_cabinetry_gals']))echo $row['sum_cabinetry_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_cabinetry_time']))echo $row['sum_cabinetry_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_cabinetry_quantity']))echo $row['sum_cabinetry_quantity'];?></td>
								<td field="cabinetry_price" class="white edit-disabled pricefield"><?php if(isset($row11['cabinetry_price']))echo $row11['cabinetry_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Pole Sand Walls</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_polesand_time']))echo $row['sum_polesand_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_polesand_quantity']))echo $row['sum_polesand_quantity'];?></td>
								<td field="polesand_price" class="white edit-disabled pricefield"><?php if(isset($row11['polesand_price']))echo $row11['polesand_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Furniture Treatment</td>
								<td field="" class="greyclr edit-disabled"><?php if(isset($row['sum_furniture_gals']))echo $row['sum_furniture_gals'];?></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_furniture_time']))echo $row['sum_furniture_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_furniture_quantity']))echo $row['sum_furniture_quantity'];?></td>
								<td field="furniture_price" class="white edit-disabled pricefield"><?php if(isset($row11['furniture_price']))echo $row11['furniture_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Mask & Cover</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation" ><?php if(isset($row['sum_maskcover_time']))echo $row['sum_maskcover_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_maskcover_quantity']))echo $row['sum_maskcover_quantity'];?></td>
								<td field="maskcover_price" class="white edit-disabled pricefield"><?php if(isset($row11['maskcover_price']))echo $row11['maskcover_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">R&R Hardware & Lighting</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_rrhardware_time']))echo $row['sum_rrhardware_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_rrhardware_quantity']))echo $row['sum_rrhardware_quantity'];?></td>
								<td field="rrhardware_price" class="white edit-disabled pricefield"><?php if(isset($row11['rrhardware_price']))echo $row11['rrhardware_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Prep Woodwork</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_prepwoodwork_time']))echo $row['sum_prepwoodwork_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_prepwoodwork_quantity']))echo $row['sum_prepwoodwork_quantity'];?></td>
								<td field="prepwoodwork_price" class="white edit-disabled pricefield"><?php if(isset($row11['prepwoodwork_price']))echo $row11['prepwoodwork_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Wallpaper Removal</td>
								<td field="" class="white edit-disabled "><?php if(isset($row['sum_wallpaper_removal_gals']))echo $row['sum_wallpaper_removal_gals'];?></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_wallpaper_removal_time']))echo $row['sum_wallpaper_removal_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wallpaper_removal_quantity']))echo $row['sum_wallpaper_removal_quantity'];?></td>
								<td field="wallpaper_removal_price" class="white edit-disabled pricefield"><?php if(isset($row11['wallpaper_removal_price']))echo $row11['wallpaper_removal_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Patch & Texture</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_patchtexture_gals']))echo $row['sum_patchtexture_gals'];?></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_patchtexture_time']))echo $row['sum_patchtexture_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_patchtexture_quantity']))echo $row['sum_patchtexture_quantity'];?></td>
								<td field="patchtexture_price" class="white edit-disabled pricefield"><?php if(isset($row11['patchtexture_price']))echo $row11['patchtexture_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Walls: Prime</td>
								<td field="" class="white edit-disabled pgallons"><?php if(isset($row['sum_wprime_gals']))echo $row['sum_wprime_gals'];?></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_wprime_time']))echo $row['sum_wprime_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wprime_quantity']))echo $row['sum_wprime_quantity'];?></td>
								<td field="wprime_price" class="white edit-disabled pricefield"><?php if(isset($row11['wprime_price']))echo $row11['wprime_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Ceilings: Prime</td>
								<td field="" class="white edit-disabled pgallons"><?php if(isset($row['sum_cprime_gals']))echo $row['sum_cprime_gals'];?></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_cprime_time']))echo $row['sum_cprime_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_cprime_quantity']))echo $row['sum_cprime_quantity'];?></td>
								<td field="cprime_price" class="white edit-disabled pricefield"><?php if(isset($row11['cprime_price']))echo $row11['cprime_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Skim Coat</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_skimcoat_gals']))echo $row['sum_skimcoat_gals'];?></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_skimcoat_time']))echo $row['sum_skimcoat_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_skimcoat_quantity']))echo $row['sum_skimcoat_quantity'];?></td>
								<td field="skimcoat_price" class="white edit-disabled pricefield"><?php if(isset($row11['skimcoat_price']))echo $row11['skimcoat_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Bullnose/Accent Wall</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_bullnosewall_time']))echo $row['sum_bullnosewall_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_bullnosewall_quantity']))echo $row['sum_bullnosewall_quantity'];?></td>
								<td field="bullnosewall_price" class="white edit-disabled pricefield"><?php if(isset($row11['bullnosewall_price']))echo $row11['bullnosewall_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Faux/Mural</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled special"><?php if(isset($row['sum_faux_time']))echo $row['sum_faux_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_faux_quantity']))echo $row['sum_faux_quantity'];?></td>
								<td field="faux_price" class="white edit-disabled pricefield"><?php if(isset($row11['faux_price']))echo $row11['faux_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Clean and Touchup</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_cleantouchup_gals']))echo  $row['sum_cleantouchup_gals'];?></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_cleantouchup_time']))echo $row['sum_cleantouchup_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_cleantouchup_quantity']))echo $row['sum_cleantouchup_quantity'];?></td>
								<td field="cleantouchup_price" class="white edit-disabled pricefield"><?php if(isset($row11['cleantouchup_price']))echo $row11['cleantouchup_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Miscellaneous</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled miscell"><?php if(isset($row['sum_miscellaneous1_time']))echo $row['sum_miscellaneous1_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_miscellaneous1_quantity']))echo $row['sum_miscellaneous1_quantity'];?></td>
								<td field="miscell1_price" class="white edit-disabled pricefield"><?php if(isset($row11['miscell1_price']))echo $row11['miscell1_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Miscellaneous</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled miscell"><?php if(isset($row['sum_miscellaneous2_time']))echo $row['sum_miscellaneous2_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_miscellaneous2_quantity']))echo $row['sum_miscellaneous2_quantity'];?></td>
								<td field="miscell2_price" class="white edit-disabled pricefield"><?php if(isset($row11['miscell2_price']))echo $row11['miscell2_price'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Miscellaneous</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled miscell"><?php if(isset($row['sum_miscellaneous3_time']))echo $row['sum_miscellaneous3_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_miscellaneous3_quantity']))echo $row['sum_miscellaneous3_quantity'];?></td>
								<td field="miscell3_price" class="white edit-disabled pricefield"><?php if(isset($row11['miscell3_price']))echo $row11['miscell3_price'];?></td>
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
									<td field="preparationtime" id="Preparationtime" class="light_greenclr edit-disabled"><?php if(isset($row11['preparationtime']))echo $row11['preparationtime'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr">Paint Application</td>
									<td field="paintapplication" id="paintapplication" class="light_greenclr edit-disabled"><?php if(isset($row11['paintapplication']))echo $row11['paintapplication'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr">Specialty</td>
									<td field="speciality" id="speciality" class="light_greenclr edit-disabled"><?php if(isset($row11['speciality']))echo $row11['speciality'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr">Miscellaneous</td>
									<td field="miscellaneous" id="Miscellaneous" class="light_greenclr edit-disabled"><?php if(isset($row11['miscellaneous']))echo $row11['miscellaneous'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr">0% Financing % Increase</td>
									<td field="financing" id="financing" class="yellowclr"><?php if(isset($row11['financing']))echo $row11['financing'];?></td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<td field="miscellaneous1" id="miscellaneous1" class="yellowclr"><?php if(isset($row11['miscellaneous1']))echo $row11['miscellaneous1']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<td field="miscellaneous2" id="miscellaneous2" class="yellowclr"><?php if(isset($row11['miscellaneous2']))echo $row11['miscellaneous2']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<td field="miscellaneous3" id="miscellaneous3" class="yellowclr"><?php if(isset($row11['miscellaneous3']))echo $row11['miscellaneous3']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<td field="miscellaneous4" id="miscellaneous4" class="yellowclr"><?php if(isset($row11['miscellaneous4']))echo $row11['miscellaneous4']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="light_orangeclr">Labor Cost(s)</td>
									<td field="laborcost" id="Laborcost" class="light_greenclr"><?php if(isset($row11['laborcost']))echo $row11['laborcost'];?></td>
								</tr>
								<tr>
									<td class="yellowclr edit-disabled">
										<select name="costtype" id="costtype">
											<option value="bygallon" <?php if($row11['costtype'] == "bygallon") echo "selected";?>>Paint Cost (by gal.)</option>
											<option value="perpercent" <?php if($row11['costtype'] == "perpercent") echo "selected";?> >Paint Cost (by %)</option>
										</select>
									</td>
									<td field="costvalue" id="costvalue" class="light_greenclr edit-disabled"><?php if(isset($row11['costvalue']))echo $row11['costvalue'];?></td>
								</tr>
								<tr>
									<td class="yellowclr edit-disabled">Soft Supplies</td>
									<td field="softsupplies" id="softsupplies" class="light_greenclr edit-disabled"><?php if(isset($row11['softsupplies']))echo $row11['softsupplies'];?></td>
								</tr>
								<tr>
									<td class="yellowclr edit-disabled">Additional Materials</td>
									<td field="additionalmaterials" id="additionalmaterials" class="yellowclr"><?php if(isset($row11['additionalmaterials']))echo $row11['additionalmaterials']; else echo "0";?></td>
								</tr>
								
								<tr>
								<td colspan="2" class="white edit-disabled" style="">
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
													<td class="light_orangeclr edit-disabled" style="padding: 0px 10px;">Wall Paint (Gallons)</td>
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
													<td field="wallpaintval" id="wallpaintval" class="white edit-disabled"><?php if(isset($row11['wallpaintval']))echo $row11['wallpaintval']; else echo "0";?></td>
													<td field="wallpaintcost" id="wallpaintcost" class="white edit-disabled"><?php if(isset($row11['wallpaintcost']))echo $row11['wallpaintcost']; else echo "0";?></td>
												</tr>
												<tr>
													<td class="light_orangeclr edit-disabled" style="padding: 0px 10px;">Ceiling Paint (Gallons)</td>
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
													<td field="ceilingpaintval" id="ceilingpaintval" class="white edit-disabled"><?php if(isset($row11['ceilingpaintval']))echo $row11['ceilingpaintval']; else echo "0";?></td>
													<td field="ceilingpaintcost" id="ceilingpaintcost" class="white edit-disabled"><?php if(isset($row11['ceilingpaintcost']))echo $row11['ceilingpaintcost']; else echo "0";?></td>
												</tr>
												<tr>
													<td class="light_orangeclr edit-disabled" style="padding: 0px 10px;">Trim Paint (Gallons)</td>
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
													<td field="trimpaintval" id="trimpaintval" class="white edit-disabled"><?php if(isset($row11['trimpaintval']))echo $row11['trimpaintval']; else echo "0";?></td>
													<td field="trimpaintcost" id="trimpaintcost" class="white edit-disabled"><?php if(isset($row11['trimpaintcost']))echo $row11['trimpaintcost']; else echo "0";?></td>
												</tr>
												<tr>
													<td class="light_orangeclr  edit-disabled" style="padding: 0px 10px;">Primer (Gallons)</td>
													<td field="primer" id="primer" class="light_greenclr  edit-disabled" style="padding: 0px 10px;"><?php if(isset($row11['primer']))echo $row11['primer'];?></td>
													<td class="white edit-disabled" style="padding: 0px 10px;">
														<select class="" name="primergrade" id="primergrade" onchange="paintgrade('primergrade',this.value)">
														<option value="">Select Grade</option>
															<?php
																$selected = "";
																if(isset($row11['primergrade']) && $row11['primergrade'] != "")
																{
																	$selected = $row11['primergrade'];
																}
																echo $db->CreateOptions("html", "paint_grade", array("id","paint_grade"),$selected,"","");
															?>
														</select>
													</td>
													<td field="primerpaintval" id="primerpaintval" class="white edit-disabled"><?php if(isset($row11['primerpaintval']))echo $row11['primerpaintval']; else echo "0";?></td>
													<td field="primerpaintcost" id="primerpaintcost" class="white edit-disabled"><?php if(isset($row11['primerpaintcost']))echo $row11['primerpaintcost']; else echo "0";?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>								
								<tr>
									<td class="light_orangeclr edit-disabled">Man Days</td>
									<td field="mandays" id="mandays" class="light_greenclr edit-disabled"><?php if(isset($row11['mandays']))echo $row11['mandays'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled">3 Men Per Day</td>
									<td field="manperday" id="manperday" class="light_greenclr edit-disabled"><?php if(isset($row11['manperday']))echo $row11['manperday'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr  edit-disabled">Adjusted hours</td>
									<td field="addhours" id="addhours" class="yellowclr"><?php if(isset($row11['addhours']))echo $row11['addhours']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled"><b>Budgeted Hours</b></td>
									<td field="budgethours" id="budgethours" class="light_greenclr edit-disabled"><?php if(isset($row11['budgethours']))echo $row11['budgethours'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled"><b>Total of Gallons</b></td>
									<td field="totalgallons" id="totalgallons" class="light_greenclr edit-disabled"><?php if(isset($row11['totalgallons']))echo $row11['totalgallons'];?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled">Tax</td>
									<td field="tax" id="tax" class="light_greenclr edit-disabled"><?php if(isset($row11['tax']))echo $row11['tax']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled">Adjusted price:</td>
									<td field="addprice" id="addprice" class="yellowclr"><?php if(isset($row11['addprice']))echo $row11['addprice']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="light_orangeclr  edit-disabled"><b>Price in Dollars</b></td>
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
									<td id="salerate" class="white edit-disabled"><?php echo $db->FetchCellValue("rate_list","interior_rate"," id = '1'"); ?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Projected GP</td>
									<td field="projectgp" id="projectgp" class="white ProjectedGP edit-disabled"><?php if(isset($row11['projectgp']))echo $row11['projectgp'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Sales Rate w/ Material</td>
									<td field="salesratewmaterial"  class="white edit-disabled" id="SalesRatewMaterial"><?php if(isset($row11['salesratewmaterial']))echo $row11['salesratewmaterial'];?></td>
								</tr>
								<tr>
									<td class="white">Average Wage w/ Burden</td>
									<td field="average" id="average" class="yellowclr avgburden"><?php if(isset($row11['average']))echo $row11['average']; else echo "0";?></td>
								</tr>
								<tr>
									<td colspan=2 class="white" style="padding:0px;">
										<table  style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;" cellspacing="0" cellpadding="0">
											<tr>
												<td class="white edit-disabled" style="padding: 0px 0px 0px 10px;">Gap %</td>
												<td field="gappercent" id="gappercent" class="yellowclr avgburden" style="padding: 0px 0px 0px 10px;"><?php if(isset($row11['gappercent']))echo $row11['gappercent']; else echo "0";?></td>
												<td field="gaprate" id="gaprate" class="white edit-disabled" ><?php if(isset($row11['gaprate']))echo $row11['gaprate']; else echo "0";?></td>
											</tr>
										</table>
									</td>
									
								</tr>
								<tr>
									<td class="white edit-disabled">Hr Labor Rate w/ Burden & Gap</td>
									<td field="sumof" id="sumof" class="white edit-disabled"><?php if(isset($row11['sumof']))echo $row11['sumof'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor Rate Charged</td>
									<td field="laborratecharged" id="laborratecharged" class="white edit-disabled"><?php if(isset($row11['laborratecharged']))echo $row11['laborratecharged'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor GP %</td>
									<td field="laborgp" id="laborgp" class="white edit-disabled"><?php if(isset($row11['laborgp']))echo $row11['laborgp'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor Total</td>
									<td field="labortotal" id="labortotal" class="white edit-disabled"><?php if(isset($row11['labortotal']))echo $row11['labortotal'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Actual Labor Costs</td>
									<td field="actualcost" id="actualcost" class="white edit-disabled"><?php if(isset($row11['actualcost']))echo $row11['actualcost']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor Profit/Contr. to Overhead</td>
									<td field="laboroverhead" id="laboroverhead" class="white edit-disabled"><?php if(isset($row11['laboroverhead']))echo $row11['laboroverhead'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Material Total</td>
									<td field="materialtotal" id="materialtotal" class="white edit-disabled"><?php if(isset($row11['materialtotal']))echo $row11['materialtotal'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Mat % of Job</td>
									<td field="matpercent" id="matpercent" class="white edit-disabled"><?php if(isset($row11['matpercent']))echo $row11['matpercent'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Additional Fixed Costs</td>
									<td field="fixedcost" id="fixedcost" class="white"><?php if(isset($row11['fixedcost']))echo $row11['fixedcost']; else echo "0";?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Total Job Costs</td>
									<td field="totaljobcost" id="totaljobcost" class="white edit-disabled"><?php if(isset($row11['totaljobcost']))echo $row11['totaljobcost'];?></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Total Job Amount</td>
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
						<?php /* ?><div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="javascript:form_internalsummary()" value="<?php echo $button; ?> Summary" name="submit">
						   </i>
						</div>
						<div class="input-field col s12 mya" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<a id="createproposal" class="waves-button-input" href="<?php echo SITE_ROOT."/proposal.php?project_id=".$_REQUEST['project_id'];?>"><?php echo $button; ?> Proposal</a>
						   </i>
						</div>
						<!-- <div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?> Customer Contact" name="submit">
						   </i>
						</div>-->
						<iframe src="<?= SITE_ROOT; ?>/classes/phpword2/samples/contractint.php<?php echo "?project_id=".$_REQUEST['project_id']; ?>"  width="300" height="57" style="float: right;" frameBorder="0" scrolling="no"></iframe>
						<div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?> Work Order" name="submit">
						   </i>
						</div><?php */ ?>
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
 $('#intsummary').addClass('active');
});

$(document).ready(function(){
	var preparation = 0;
	var paintapp = 0;
	var special = 0;
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
		
	$('td.pgallons').each(function(){
		try{
			if(parseFloat($(this).html()))
			{
				pg += parseFloat($(this).html());
			}
		}catch(err){}
	});
	
	$("#primer").html((pg).toFixed(2));	
	special = $(".special").html();
	$("#speciality").html(special);
	cpaint = $(".cpgallons").html();
	$("#ceilingpaint").html(cpaint);
	
	laborratecharged = $('#salerate').html();
	$('#laborratecharged').html(laborratecharged);
	
	var paint_rate = parseFloat(<?php $paint_rate = $db->FetchCellValue("rate_list","interior_rate"," id = '1'"); echo $paint_rate;?>);
	var faux_mural = parseFloat(<?php $faux_mural = $db->FetchCellValue("rate_list","interior_rate"," id = '2'"); echo $faux_mural;?>);
	var laborcost = parseFloat((mis+paintapp+preparation)*paint_rate+special*faux_mural);
	$("#Laborcost").html((laborcost).toFixed(2));
	$("#labortotal").html((laborcost).toFixed(2));
	
	$("#laborratecharged").html(paint_rate);
	var additionalhours = parseFloat($("#addhours").html());
	budhour = parseFloat(mis) + parseFloat(paintapp) + parseFloat(preparation) + parseFloat(special) + parseFloat(additionalhours);
	$("#budgethours").html(budhour);
	
	totalgallon = parseFloat(wpaint) + parseFloat(cpaint) + parseFloat(tpaint) + parseFloat(pg);
	$("#totalgallons").html(totalgallon);
	
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
		cpergallon =  parseFloat(<?php $cpergallon = $db->FetchCellValue("rate_list","interior_rate"," id = '3'"); echo $cpergallon;?>);
		paint =  parseFloat(<?php $paint = $db->FetchCellValue("rate_list","interior_rate"," id = '1'"); echo $paint;?>);
		material =  parseFloat(<?php $paint = $db->FetchCellValue("rate_list","interior_rate"," id = '4'"); echo $paint;?>);
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
			m =  parseFloat(<?php $cpergallon = $db->FetchCellValue("rate_list","interior_rate"," id = '4'"); echo $cpergallon;?>);
			s = parseFloat(laborcost) * (m/100);
			$('#costvalue').html(s);
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
			console.log(" fixedcost -- "+fixedcost+" materialtotal -- "+materialtotal+" actualcost -- "+actualcost);
			 $("#totaljobcost").html(totaljobcost);
			
			p = parseFloat((priceindollars-totaljobcost));
			projectgp = parseFloat((p*100))/parseFloat(priceindollars);
			console.log("if -- "+projectgp+" priceindollars --"+priceindollars);
			$('#projectgp').html(Math.abs(projectgp));
		}
		
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
				console.log(" fixedcost -- "+fixedcost+" materialtotal -- "+materialtotal+" actualcost -- "+actualcost);
				$('#totaljobcost').html(totaljobcost);
				
				p = parseFloat((priceindollars-totaljobcost));
				projectgp = parseFloat((p*100))/parseFloat(priceindollars);
				console.log("if -- "+projectgp+" priceindollars --"+priceindollars);
				$('#projectgp').html(Math.abs(projectgp));
			}
			else{
				m =  parseFloat(<?php $cpergallon = $db->FetchCellValue("rate_list","interior_rate"," id = '3'"); echo $cpergallon;?>);
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
				console.log(" fixedcost -- "+fixedcost+" materialtotal -- "+materialtotal+" actualcost -- "+actualcost);
				$('#totaljobcost').html(totaljobcost);
				
				p = parseFloat((priceindollars-totaljobcost));
				projectgp = parseFloat((p*100))/parseFloat(priceindollars);
				console.log("if -- "+projectgp+" priceindollars --"+priceindollars);
				$('#projectgp').html(Math.abs(projectgp));
			}
		}
	}); 
	$('#costtype, #gradestatus').change();
	$('table td.avgburden').on('change', function(evt, newValue) {});
	$("#headingSearchtitle").html("Interior Summary");
});

	/* paint grade */
function paintgrade(name,id){
	$('#gradestatus').change();
	/*alert(id); */
	/*alert(name);*/
	var grade = {};
	grade = <?php echo json_encode($val);?>;
	if(name == 'wallpaintgrade'){
		$('#wallpaintval').html(grade[$("#wallpaintgrade").val()]['interior_rate']);
		var w = 0;
		var v = 0;
		v = grade[$("#wallpaintgrade").val()]['interior_rate'];
		w = $('#wallpaint').html();
		$('#wallpaintcost').html((v*w).toFixed(2));
	}
	if(name == 'ceilinggrade'){
		$('#ceilingpaintval').html(grade[$("#ceilinggrade").val()]['interior_rate']);
		var w = 0;
		var v = 0;
		v = grade[$("#ceilinggrade").val()]['interior_rate'];
		w = $('#ceilingpaint').html();
		$('#ceilingpaintcost').html((v*w).toFixed(2));
	}
	
	if(name == 'trimpaintgrade'){
		$('#trimpaintval').html(grade[id]['interior_rate']);
		var w = 0;
		var v = 0;
		v = grade[id]['interior_rate'];
		w = $('#trimpaint').html();
		$('#trimpaintcost').html((v*w).toFixed(2));
	}
	
	if(name == 'primergrade'){
		$('#primerpaintval').html(grade[id]['interior_rate']);
		var w = 0;
		var v = 0;
		v = grade[id]['interior_rate'];
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
   $("#interiorli").addClass("active");
   $("#interiorlidiv").show();
});
</script>
