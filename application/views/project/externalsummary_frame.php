
<?php 
$label = "Add";
$button = "Create";
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
	//print_r($row);
}
?>
<?php
$val = array();
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
}
//print_r($production_rate['Patch & Texture']['rate']);
?>
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
$(function(){
	$( ".calculation" ).change(function() {
		var length = $('#length').val();
		var width = $('#width').val();
		var height = $('#height').val();
		var lnft = 2*length + 2*width;
		var wft = 2*length*height + 2*width*height;
		var cft = length * width;
		$('#lnft').val(lnft);
		$('#wft').val(wft);
		$('#cft').val(cft);
		$('.lnftq').html(lnft);
		$('.wftq').html(wft);
		$('.cftq').html(cft);
	});
	
	$('table td').on('change', function(evt, newValue) {
		var classdiv = $(this).hasClass('furniture_coats');
		var rate_js = {};
		rate_js = <?php echo str_replace(")",'',str_replace("(",'',str_replace("-",'',str_replace("+",'',str_replace("'",'',str_replace(' ','',json_encode($production_rate)))))));?>;
		var rates = 0; 
		// do something with the new cell value 
		var parent = $(this).parent();
		var temparr = [];
		parent.find('td').each(function(){
			temparr.push($(this).html());
		});
		//console.log(temparr[0]);
		var temp444 = temparr[0].split(' ').join('');
		//console.log(temparr[0]);
		var coatindex = "coat_"+temparr[3];
		//console.log(temp444);
		//console.log(temparr[0]);
		//console.log(rate_js[temp444]);
		try{
			var rates  = rate_js[temp444][coatindex];
			//console.log(rates);
			var spred  = rate_js[temp444]['spread'];
			//console.log(spred);
			//console.log(rate_js[temp444]);
			//console.log(temp444);
		}
		catch(err){
			
		}
			/*console.log(spred);*/
		var qty = temparr[1];
		var coats = temparr[3];
		var gals = (qty * coats) / spred;
		
		if(temparr[0] == "Wallpaper Removal"){
			var c = $('td.furniture_coats').html();
			gals = (qty * c) / spred;
		}
		if(temparr[0] == "Skim Coat"){
			var s = rate_js['Walls:Prime']['coat_1'];
			gals = (qty * coats) / s;
		}
		
		/*console.log(rate_js);*/
		switch (temparr[2]){
				case "Hours":
					var time = temparr[1];
					$(parent.find('td:last-child')).html(time);
					break;
				case "Each":
					var time = temparr[1] * rates ;
					var time1 = time.toFixed(2); 
					var gals1 = gals.toFixed(2); 
					$(parent.find('td:last-child')).attr({'round':time}).html(time1);
					$(parent.find('td:nth-child(6)')).attr({'round':rates}).html(rates);
					$(parent.find('td:nth-child(7)')).attr({'round':gals}).html(gals1);
					break;
				case "Sq. Ft.":
				case "Ln. Ft.":
					/*console.log(temparr[0]);*/
					var temp444 = temparr[0].replace(" ", "").replace("'", "").replace("+", "").replace("-", "").replace("(", "").replace(")", "");
					var coatindex = "coat_"+temparr[3];
					try{
					var rates  = rate_js[temp444][coatindex];
					}catch(err){}
					if(temparr[0] == "Pole Sand Walls"){
						rates = rate_js['PoleSandWalls']['coat_1']
						var time = temparr[1] / rates;
						gals = 0; 
					}
					var time = temparr[1] / rates;
					var time1 = time.toFixed(2); 
					var gals1 = gals.toFixed(2); 
					$(parent.find('td:last-child')).attr({'round':time}).html(time1);
					$(parent.find('td:nth-child(6)')).attr({'round':rates}).html(rates);
					$(parent.find('td:nth-child(7)')).attr({'round':gals}).html(gals1);
					break;
			}
			var sumgallon = 0;
			var sumtime = 0;
			$('table tr td:nth-child(7)').each(function(){
				try{
					if($(this).html() != "")
					{
						sumgallon += parseFloat($(this).html());
					}
				}catch(err){
					sumgallon = sumgallon;
				}
				$("#gallons").val(sumgallon);
			});
			$('table tr td:nth-child(8)').each(function(){
				try{
					if($(this).html() != "")
					{
						sumtime += parseFloat($(this).html());
					}
				}catch(err){
					sumtime = sumtime;
				}
				$("#hours").val(sumtime);
			});
			if(classdiv)
				$('td.wallgals').change();
		
	});
});

function updateval(val)
{
	var t = val;
}
</script>
<style>
.card-title.grey-text.text-darken-4 p{
	margin:10px 0px;
}
.mywidth{
	width:25%;
}
.specialclass.fixed,.specialclass2.fixed{
  top:0px;
  position:fixed;
  width:auto;
  display:none;
  border:none;
}
</style>
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/mindmup-editabletable.js"></script>   
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/numeric-input-example.js"></script>
<div class="col s12 m12 l12">
<div class="" style="margin-top: 0px;">
	<div id="row-grouping" class="section" style="padding-top:0px;">
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
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_scraping_time']))echo $row['sum_scraping_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Patch Stucco</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_patch_time']))echo $row['sum_patch_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_patch_quantity']))echo $row['sum_patch_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_patch_time']))echo $row['sum_patch_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Feather Sanding</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_feather_time']))echo $row['sum_feather_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_feather_quantity']))echo $row['sum_feather_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_feather_time']))echo $row['sum_feather_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Flexible Epoxy</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_flexible_time']))echo $row['sum_flexible_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_flexible_quantity']))echo $row['sum_flexible_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_flexible_time']))echo $row['sum_flexible_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Caulking</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_caulking_time']))echo $row['sum_caulking_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_caulking_quantity']))echo $row['sum_caulking_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_caulking_quantity']))echo $row['sum_caulking_quantity'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Pressure Wash</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['pressure_time']))echo $row['pressure_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['pressure_quantity']))echo $row['pressure_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['pressure_time']))echo $row['pressure_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Roof/Ladder Time</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_roof_time']))echo $row['sum_roof_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_roof_quantity']))echo $row['sum_roof_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_roof_time']))echo $row['sum_roof_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Spot Prime</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_spot_time']))echo $row['sum_spot_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_spot_quantity']))echo $row['sum_spot_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_spot_time']))echo $row['sum_spot_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Remove/Replace (Lights)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_remove_lights_time']))echo $row['sum_remove_lights_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_remove_lights_quantity']))echo $row['sum_remove_lights_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_remove_lights_time']))echo $row['sum_remove_lights_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Remove/Replace (Screens)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_remove_screens_time']))echo $row['sum_remove_screens_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_remove_screens_quantity']))echo $row['sum_remove_screens_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_remove_screens_time']))echo $row['sum_remove_screens_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Remove/Replace (Other)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_remove_other_time']))echo $row['sum_remove_other_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_remove_other_quantity']))echo $row['sum_remove_other_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_remove_other_time']))echo $row['sum_remove_other_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Wash Windows</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_wash_time']))echo $row['sum_wash_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wash_quantity']))echo $row['sum_wash_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wash_time']))echo $row['sum_wash_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Pressure Wash Deck</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_pressurewashdeck_time']))echo $row['sum_pressurewashdeck_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_pressurewashdeck_quantity']))echo $row['sum_pressurewashdeck_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_pressurewashdeck_time']))echo $row['sum_pressurewashdeck_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Mask (Windows & Doors)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_maskwindowsdoors_time']))echo $row['sum_maskwindowsdoors_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_maskwindowsdoors_quantity']))echo $row['sum_maskwindowsdoors_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_maskwindowsdoors_time']))echo $row['sum_maskwindowsdoors_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Mask (Other)</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled Preparation"><?php if(isset($row['sum_maskother_time']))echo $row['sum_maskother_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_maskother_quantity']))echo $row['sum_maskother_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_maskother_time']))echo $row['sum_maskother_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Eaves (Single Story)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eavessingle_gals']))echo $row['sum_eavessingle_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_eavessingle_time']))echo $row['sum_eavessingle_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eavessingle_quantity']))echo $row['sum_eavessingle_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eavessingle_gals']))echo $row['sum_eavessingle_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Eaves (Two Story)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eavestwo_gals']))echo $row['sum_eavestwo_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_eavestwo_time']))echo $row['sum_eavestwo_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eavestwo_quantity']))echo $row['sum_eavestwo_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eavestwo_gals']))echo $row['sum_eavestwo_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Eaves (Easy)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eaveseasy_gals']))echo $row['sum_eaveseasy_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_eaveseasy_time']))echo $row['sum_eaveseasy_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eaveseasy_quantity']))echo $row['sum_eaveseasy_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eaveseasy_gals']))echo $row['sum_eaveseasy_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Eaves (Hard)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eaveshard_gals']))echo $row['sum_eaveshard_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_eaveshard_time']))echo $row['sum_eaveshard_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eaveshard_quantity']))echo $row['sum_eaveshard_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_eaveshard_gals']))echo $row['sum_eaveshard_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Fascia (Single Story)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_fasciasingle_gals']))echo $row['sum_fasciasingle_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_fasciasingle_time']))echo $row['sum_fasciasingle_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_fasciasingle_quantity']))echo $row['sum_fasciasingle_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_fasciasingle_gals']))echo $row['sum_fasciasingle_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Fascia (Two Story)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_fasciatwo_gals']))echo $row['sum_fasciatwo_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_fasciatwo_time']))echo $row['sum_fasciatwo_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_fasciatwo_quantity']))echo $row['sum_fasciatwo_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_fasciatwo_gals']))echo $row['sum_fasciatwo_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Metal Flashing</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_metalflashing_gals']))echo $row['sum_metalflashing_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_metalflashing_time']))echo $row['sum_metalflashing_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_metalflashing_quantity']))echo $row['sum_metalflashing_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_metalflashing_gals']))echo $row['sum_metalflashing_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Rain Gutters & Downspouts</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_raingutters_gals']))echo $row['sum_raingutters_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_raingutters_time']))echo $row['sum_raingutters_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_raingutters_quantity']))echo $row['sum_raingutters_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_raingutters_gals']))echo $row['sum_raingutters_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Shutters</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_shutters_gals']))echo $row['sum_shutters_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_shutters_time']))echo $row['sum_shutters_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_shutters_quantity']))echo $row['sum_shutters_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_shutters_gals']))echo $row['sum_shutters_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows Trim</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windowstrim_gals']))echo $row['sum_windowstrim_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windowstrim_time']))echo $row['sum_windowstrim_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windowstrim_quantity']))echo $row['sum_windowstrim_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windowstrim_gals']))echo $row['sum_windowstrim_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows (2 Pane)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows2pane_gals']))echo $row['sum_windows2pane_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windows2pane_time']))echo $row['sum_windows2pane_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows2pane_quantity']))echo $row['sum_windows2pane_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows2pane_gals']))echo $row['sum_windows2pane_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows (3-7 Pane)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows37pane_gals']))echo $row['sum_windows37pane_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windows37pane_time']))echo $row['sum_windows37pane_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows37pane_quantity']))echo $row['sum_windows37pane_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows37pane_gals']))echo $row['sum_windows37pane_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows (8-15 Pane)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows815pane_gals']))echo $row['sum_windows815pane_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windows815pane_time']))echo $row['sum_windows815pane_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows815pane_quantity']))echo $row['sum_windows815pane_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows815pane_gals']))echo $row['sum_windows815pane_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Windows (16 + Pane)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows16pane_gals']))echo $row['sum_windows16pane_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_windows16pane_time']))echo $row['sum_windows16pane_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows16pane_quantity']))echo $row['sum_windows16pane_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_windows16pane_gals']))echo $row['sum_windows16pane_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors (Flat)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorsflat_gals']))echo $row['sum_doorsflat_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_doorsflat_time']))echo $row['sum_doorsflat_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorsflat_quantity']))echo $row['sum_doorsflat_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorsflat_gals']))echo $row['sum_doorsflat_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors (Light)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorslight_gals']))echo $row['sum_doorslight_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_doorslight_time']))echo $row['sum_doorslight_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorslight_quantity']))echo $row['sum_doorslight_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors (Paneled)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorspaneled_gals']))echo $row['sum_doorspaneled_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_doorspaneled_time']))echo $row['sum_doorspaneled_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorspaneled_quantity']))echo $row['sum_doorspaneled_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Doors (French)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorsfrench_gals']))echo $row['sum_doorsfrench_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_doorsfrench_time']))echo $row['sum_doorsfrench_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_doorsfrench_quantity']))echo $row['sum_doorsfrench_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Garage Door</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_garagedoor_gals']))echo $row['sum_garagedoor_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_garagedoor_time']))echo $row['sum_garagedoor_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_garagedoor_quantity']))echo $row['sum_garagedoor_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Garage Door Frame</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_garagedoorframe_gals']))echo $row['sum_garagedoorframe_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_garagedoorframe_time']))echo $row['sum_garagedoorframe_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_garagedoorframe_quantity']))echo $row['sum_garagedoorframe_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Entry Door (or Frame Only)</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_entrydoor_gals']))echo $row['sum_entrydoor_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_entrydoor_time']))echo $row['sum_entrydoor_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_entrydoor_quantity']))echo $row['sum_entrydoor_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Posts/Pillars</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_postspillars_gals']))echo $row['sum_postspillars_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_postspillars_time']))echo $row['sum_postspillars_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_postspillars_quantity']))echo $row['sum_postspillars_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Wrought Iron</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wroughtiron_gals']))echo $row['sum_wroughtiron_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_wroughtiron_time']))echo $row['sum_wroughtiron_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wroughtiron_quantity']))echo $row['sum_wroughtiron_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wroughtiron_gals']))echo $row['sum_wroughtiron_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Stucco - Single Story</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_stuccosingle_gals']))echo $row['sum_stuccosingle_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_stuccosingle_time']))echo $row['sum_stuccosingle_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_stuccosingle_quantity']))echo $row['sum_stuccosingle_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Stucco - Two Story</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_stuccotwo_gals']))echo $row['sum_stuccotwo_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_stuccotwo_time']))echo $row['sum_stuccotwo_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_stuccotwo_quantity']))echo $row['sum_stuccotwo_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_stuccotwo_gals']))echo $row['sum_stuccotwo_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Siding - Single Story</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_sidingsingle_gals']))echo $row['sum_sidingsingle_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_sidingsingle_time']))echo $row['sum_sidingsingle_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_sidingsingle_quantity']))echo $row['sum_sidingsingle_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Siding - Two Story</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_sidingtwo_gals']))echo $row['sum_sidingtwo_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_sidingtwo_time']))echo $row['sum_sidingtwo_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_sidingtwo_quantity']))echo $row['sum_sidingtwo_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Body Paint: +/- Time</td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_bodypaint_gals']))echo $row['sum_bodypaint_gals'];?></td>
								<td field="" class="white edit-disabled papp"><?php if(isset($row['sum_bodypaint_time']))echo $row['sum_bodypaint_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_bodypaint_quantity']))echo $row['sum_bodypaint_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Miscellaneous</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled miscell"><?php if(isset($row['sum_miscellaneous_time']))echo $row['sum_miscellaneous_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_miscellaneous_quantity']))echo $row['sum_miscellaneous_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Miscellaneous</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled miscell"><?php if(isset($row['sum_miscellaneous1_time']))echo $row['sum_miscellaneous1_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_miscellaneous1_quantity']))echo $row['sum_miscellaneous1_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_blueclr">Miscellaneous</td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="white edit-disabled miscell"><?php if(isset($row['sum_miscellaneous2_time']))echo $row['sum_miscellaneous2_time'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_miscellaneous2_quantity']))echo $row['sum_miscellaneous2_quantity'];?></td>
								<td field="" class="white edit-disabled"><?php if(isset($row['sum_wpaint09_gals']))echo $row['sum_wpaint09_gals'];?></td>
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
									<td id="Preparationtime" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="light_orangeclr">Paint Application</td>
									<td id="paintapplication" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="light_orangeclr">Miscellaneous</td>
									<td id="Miscellaneous" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="light_orangeclr">0% Financing % Increase</td>
									<td id="financing" class="yellowclr"></td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<td id="miscellaneous1" class="yellowclr">0</td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<td id="miscellaneous2" class="yellowclr">0</td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<td id="miscellaneous3" class="yellowclr">0</td>
								</tr>
								<tr>
									<td class="yellowclr"></td>
									<td id="miscellaneous4" class="yellowclr">0</td>
								</tr>
								<tr>
									<td class="light_orangeclr">Labor Cost(s)</td>
									<td id="Laborcost" class="light_greenclr"></td>
								</tr>
								<tr>
									<td class="yellowclr edit-disabled">
										<select name="costtype" id="costtype">
											<option value="bygallon">Paint Cost (by gal.)</option>
											<option value="perpercent">Paint Cost (by %)</option>
										</select>
									</td>
									<td id="costvalue" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="yellowclr edit-disabled">Soft Supplies</td>
									<td id="softsupplies" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="yellowclr edit-disabled">Additional Materials</td>
									<td id="additionalmaterials" class="yellowclr">0</td>
								</tr>
								
								<tr>
								<td colspan="2" class="white edit-disabled" style="">
									<select name="gradestatus" id="gradestatus">
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select>
								</td>
								</tr>
								<tr>
									
									<td colspan="2" class="white" style="padding: 0">
										<table style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;" cellspacing="0" cellpadding="0">
											<tbody>
												<tr>
													<td class="light_orangeclr edit-disabled" style="padding: 0px 10px;">Wall Paint (Gallons)</td>
													<td id="wallpaint" class="light_greenclr edit-disabled" style="padding: 0px 10px;"></td>
													<td class="white edit-disabled" style="padding: 0px 10px;">
														<select class="" name="wallpaintgrade" id="wallpaintgrade" 	onchange="paintgrade('wallpaintgrade',this.value)">
														<option value="">Select Grade</option>
															<?php
																$selected = "";
																if(isset($row['wallpaintgrade']) && $row['wallpaintgrade'] != "")
																{
																	$selected = $row['wallpaintgrade'];
																}
																echo $db->CreateOptions("html", "paint_grade", array("id","paint_grade"),$selected,"","");
															?>
														</select>
													</td>
													<td id="wallpaintval" class="white edit-disabled">0</td>
													<td id="wallpaintcost" class="white edit-disabled">0</td>
												</tr>
												<tr>
													<td class="light_orangeclr edit-disabled" style="padding: 0px 10px;">Ceiling Paint (Gallons)</td>
													<td id="ceilingpaint" class="light_greenclr edit-disabled" style="padding: 0px 10px;"></td>
													<td class="white edit-disabled" style="padding: 0px 10px;">
														<select class="" name="ceilinggrade" id="ceilinggrade" onchange="paintgrade('ceilinggrade',this.value)">
														<option value="">Select Grade</option>
															<?php
																$selected = "";
																if(isset($row['ceilinggrade']) && $row['ceilinggrade'] != "")
																{
																	$selected = $row['ceilinggrade'];
																}
																echo $db->CreateOptions("html", "paint_grade", array("id","paint_grade"),$selected,"","");
															?>
														</select>
													</td>
													<td id="ceilingpaintval" class="white edit-disabled">0</td>
													<td id="ceilingpaintcost" class="white edit-disabled">0</td>
												</tr>
												<tr>
													<td class="light_orangeclr edit-disabled" style="padding: 0px 10px;">Trim Paint (Gallons)</td>
													<td id="trimpaint" class="light_greenclr edit-disabled"  style="padding: 0px 10px;"></td>
													<td class="white edit-disabled" style="padding: 0px 10px;">
														<select class="" name="trimpaintgrade" id="trimpaint" onchange="paintgrade('trimpaintgrade',this.value)">
														<option value="">Select Grade</option>
															<?php
																$selected = "";
																if(isset($row['trimpaint']) && $row['trimpaint'] != "")
																{
																	$selected = $row['trimpaint'];
																}
																echo $db->CreateOptions("html", "paint_grade", array("id","paint_grade"),$selected,"","");
															?>
														</select>
													</td>
													<td id="trimpaintval" class="white edit-disabled">0</td>
													<td id="trimpaintcost" class="white edit-disabled">0</td>
												</tr>
												<tr>
													<td class="light_orangeclr  edit-disabled" style="padding: 0px 10px;">Primer (Gallons)</td>
													<td id="primer" class="light_greenclr  edit-disabled" style="padding: 0px 10px;"></td>
													<td class="white edit-disabled" style="padding: 0px 10px;">
														<select class="" name="primergrade" id="primer" onchange="paintgrade('primergrade',this.value)">
														<option value="">Select Grade</option>
															<?php
																$selected = "";
																if(isset($row['primer']) && $row['primer'] != "")
																{
																	$selected = $row['primer'];
																}
																echo $db->CreateOptions("html", "paint_grade", array("id","paint_grade"),$selected,"","");
															?>
														</select>
													</td>
													<td id="primerpaintval" class="white edit-disabled">0</td>
													<td id="primerpaintcost" class="white edit-disabled">0</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>								
								<tr>
									<td class="light_orangeclr edit-disabled">Man Days</td>
									<td id="mandays" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled">3 Men Per Day</td>
									<td id="manperday" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="light_orangeclr  edit-disabled">Adjusted hours</td>
									<td id="addhours" class="yellowclr">0</td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled"><b>Budgeted Hours</b></td>
									<td id="budgethours" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled"><b>Total of Gallons</b></td>
									<td id="totalgallons" class="light_greenclr edit-disabled"></td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled">Tax</td>
									<td id="tax" class="light_greenclr edit-disabled">0</td>
								</tr>
								<tr>
									<td class="light_orangeclr edit-disabled">Adjusted price:</td>
									<td id="addprice" class="yellowclr">0</td>
								</tr>
								<tr>
									<td class="light_orangeclr  edit-disabled"><b>Price in Dollars</b></td>
									<td id="priceindollars" class="light_greenclr  edit-disabled"></td>
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
									<td id="projectgp" class="white ProjectedGP edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Sales Rate w/ Material</td>
									<td class="white edit-disabled" id="SalesRatewMaterial"></td>
								</tr>
								<tr>
									<td class="white">Average Wage w/ Burden</td>
									<td id="average" class="yellowclr avgburden">0</td>
								</tr>
								<tr>
									<td colspan=2 class="white" style="padding:0px;">
										<table  style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;" cellspacing="0" cellpadding="0">
											<tr>
												<td class="white edit-disabled" style="padding: 0px 0px 0px 10px;">Gap %</td>
												<td id="gappercent" class="yellowclr avgburden" style="padding: 0px 0px 0px 10px;">0</td>
												<td id="gaprate" class="white edit-disabled" >0</td>
											</tr>
										</table>
									</td>
									
								</tr>
								<tr>
									<td class="white edit-disabled">Hr Labor Rate w/ Burden & Gap</td>
									<td id="sumof" class="white edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor Rate Charged</td>
									<td id="laborratecharged" class="white edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor GP %</td>
									<td id="laborgp" class="white edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor Total</td>
									<td id="labortotal" class="white edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Actual Labor Costs</td>
									<td id="actualcost" class="white edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Labor Profit/Contr. to Overhead</td>
									<td id="laboroverhead" class="white edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Material Total</td>
									<td id="materialtotal" class="white edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Mat % of Job</td>
									<td id="matpercent" class="white edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Additional Fixed Costs</td>
									<td id="fixedcost" class="white"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Total Job Costs</td>
									<td id="totaljobcost" class="white edit-disabled"></td>
								</tr>
								<tr>
									<td class="white edit-disabled">Total Job Amount</td>
									<td id="totaljobamount" class="white edit-disabled"></td>
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
						<div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?> Summary" name="submit">
						   </i>
						</div>
						<div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?> Proposal" name="submit">
						   </i>
						</div>
						<div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?> Customer Contact" name="submit">
						   </i>
						</div>
						<div class="input-field col s12" style="padding: 0px">
						   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C;">
							<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?> Work Order" name="submit">
						   </i>
						</div>
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
   $(".specialclass").fixMe();
   $(".specialclass2").fixMe();
});
</script>