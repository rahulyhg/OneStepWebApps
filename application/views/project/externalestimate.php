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
<style>
input.placecolor::-webkit-input-placeholder {
color: #fff !important;
}
 
input.placecolor:-moz-placeholder { /* Firefox 18- */
color: #fff !important;  
}
 
input.placecolor::-moz-placeholder {  /* Firefox 19+ */
color: #fff !important;  
}
 
input.placecolor:-ms-input-placeholder {  
color: #fff !important;  
}

#mainTable.fixed{
  top:64px;
  position:fixed;
  width:auto;
  display:none;
  border:none;
}
</style>
<script>
$(function(){
	$( ".calculation" ).change(function() {
		var length = $('#length').val();
		var height = $('#height').val();
		var sqft = length * height;
		$('#sqft').val(sqft);
	});
	
	$('table#mainTable td').on('change', function(evt, newValue) {
		var classdiv = $(this).hasClass('furniture_coats');
		var rate_js = {};
		rate_js = <?php echo str_replace(")",'',str_replace("(",'',str_replace("-",'',str_replace("+",'',str_replace("'",'',str_replace(' ','',json_encode($production_rate)))))));?>;
		var rates = 0; 
		var paint_rate = 0;
		var cost_per_gallon = 0;
		/*paint_rate = <?php $paint_rate = $db->FetchCellValue("rate_list","exterior_rate"," id = '1'"); echo $paint_rate; ?>;
		cost_per_gallon = <?php $cost_per_gallon = $db->FetchCellValue("rate_list","exterior_rate"," id = '3'"); echo $cost_per_gallon; ?>;*/
		
		paint_rate = <?php $paint_rate = $db->FetchCellValue("Interior_Rate","exterior","rate_type='paint' && project_id = '".$_REQUEST['project_id']."' "); echo $paint_rate; ?>;
		cost_per_gallon = <?php $cost_per_gallon = $db->FetchCellValue("Interior_Rate","exterior","rate_type='Cost Per Gallon' && project_id = '".$_REQUEST['project_id']."' "); echo $cost_per_gallon; ?>;
		
		// do something with the new cell value 
		var parent = $(this).parent();
		var temparr = [];
		parent.find('td').each(function(){
			temparr.push($(this).html());
		});
		//console.log(temparr[0]);
		var temp444 = temparr[0].split(' ').join('');
		//console.log(temparr[0]);
		if(temparr[0] == "Remove Replace Lights" || temparr[0] == "Remove Replace Screens" || temparr[0] == "Wash Windows" || temparr[0] == "Mask Windows Doors"){
			temparr[3] = "1";
		}
		if(temparr[0] == "Remove Replace Other"){
			temparr[3] = "0";
		}
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
		
		if(temparr[0] == "Remove Replace Lights"){
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
					if(temparr[0] == "Remove Replace Lights" || temparr[0] == "Remove Replace Screens" || temparr[0] == "Remove Replace Other" || temparr[0] == "Wash Windows" || temparr[0] == "Mask Windows Doors"){
						//console.log(temparr[1]+"::::"+rates);
						var time = parseFloat(temparr[1]) * parseFloat(rates) ;
						var time1 = time.toFixed(2); 
						if(temparr[0] == "Remove Replace Other"){
							time1 = 0.0;
						}
						var gals = 0; 
						var gals1 = gals.toFixed(2); 
						$(parent.find('td:last-child')).attr({'round':time}).html(time1);
						$(parent.find('td:nth-child(6)')).attr({'round':rates}).html(rates);
						$(parent.find('td:nth-child(7)')).attr({'round':gals}).html(gals1);
					}else{
						var time = temparr[1] * rates ;
						var time1 = time.toFixed(2); 
						var gals1 = gals.toFixed(2); 
						$(parent.find('td:last-child')).attr({'round':time}).html(time1);
						$(parent.find('td:nth-child(6)')).attr({'round':rates}).html(rates);
						$(parent.find('td:nth-child(7)')).attr({'round':gals}).html(gals1);
					}
					break; 
				case "Sq. Ft.":
				case "Ln. Ft.":
					//console.log(temparr[0]);
					var temp444 = temparr[0].split(' ').join('');
					var coatindex = "coat_"+temparr[3];
					try{
					var rates  = rate_js[temp444][coatindex];
					console.log(rates);
					}catch(err){}
					if(temparr[0] == "Pressure Wash Deck"){
						rates = rate_js['PressureWashDeck']['coat_1']
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
			var maincost = 0;
			$('table#mainTable tr td:nth-child(7)').each(function(){
				try{
					if($(this).html() != "" && parseFloat($(this).html()) > 0)
					{
						sumgallon += parseFloat($(this).html());
					}
				}catch(err){
				}
			});
			$("#gallons").val(sumgallon);
			
			$('table#mainTable tr td:nth-child(8)').each(function(){
				try{
					if($(this).html() != "" && parseFloat($(this).html()) > 0)
					{
						sumtime += parseFloat($(this).html());
					}
				}catch(err){}
				
			});
			$("#hours").val(sumtime);
			if(classdiv)
				$('td.wallgals').change();
			
			maincost = (sumtime * paint_rate) +  (sumgallon * cost_per_gallon);
			$("#cost").val((maincost).toFixed(1));
	});
});

function form_externalestimate(){
	
	var poststring={};
 
 
	 $('table td').each(function(){
	  try{
	   if($(this).attr('field')!="")
	   {
		poststring[$(this).attr('field')] = $(this).html();
	   }
	  }catch(err){}
	 });
	 poststring['SpaceType'] =  $("#space_type").val();
	 poststring['Length'] =  $("#length").val();
	 poststring['Height'] =  $("#height").val();
	 poststring['Sq_Ft'] =  $("#sqft").val();
	 poststring['Gallons'] =  $("#gallons").val();
	 poststring['Hours'] =  $("#hours").val();
	 poststring['Cost'] =  $("#cost").val();
	 poststring['project_id'] =  <?php echo $_REQUEST['project_id']; ?>;
	 <?php if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" ){?>
		  poststring['id'] =  <?php echo $_REQUEST['id']; ?>;
	<?php } ?>
	 //console.log(poststring);
	
	 ignore = true;
	$.ajax({
		url: '<?php echo BASEPATH;?>/project/addextest', 
		type: 'post',
		cache: false,
		data: poststring,
		success: function (response) {                    
			var res = eval('('+response+')');
			if(res['success'] == "1"){
				swal({   title: "Do you want to continue?",   
						 text: "You have added a new room. Do you want to add another room?",   
						 type: "warning",   
						 showCancelButton: true,   
						 confirmButtonColor: "#DD6B55",   
						 confirmButtonText: "Yes",   
						 cancelButtonText: "No",   
						 closeOnConfirm: false,   
						 closeOnCancel: false }, 
						 function(isConfirm){   
							 if (isConfirm) {     
								 location.href = "<?= SITE_ROOT; ?>/project/externalestimate?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
							 else {
								 location.href = "<?= SITE_ROOT; ?>/project/dashboard?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
						});
			}
			
			//console.log(res->success);
		}
	}); 
}
</script>
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

if(isset($_REQUEST['id'])){
	$condition88 = "i.id = '".$_REQUEST['id']."' ";
	$main_table88 = array("$table88 i",array("i.*"));
	$join_tables88 = array(
		array('left','external_estimate c','c.estimate_id = i.id', array('c.*'))
	);
	$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
	$row = mysql_fetch_array($rs1);
	//print_r($row);
}
?>
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/mindmup-editabletable.js"></script>   
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/numeric-input-example.js"></script>
<div class="row">
<div class="col s12 m12">
	<ul id="task-card" class="collection with-header" style="margin: 0px; border: 0px none;">
		<li class="collection-header" style="background:transparent;padding:0;">
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 600px);">
				<a data-delay="50" data-tooltip="Next To Project" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/external_project?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#00695C;" class="mdi-hardware-keyboard-arrow-right"></i>
				</a>
				<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#00695C;" class="mdi-content-clear"></i>
				</a>
				<a data-delay="50" data-tooltip="Previous To Notes" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/home/listexternalnote?project_id=".$_REQUEST['project_id']; ?>">
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
				<a href="javascript:form_externalestimate()" style="float: right; margin-right: 20px;"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content strong" style="color:#00695C;background:#fff;"><?php echo $button; ?></span></h6></a>
			</div>
		</li>
	</ul>
</div>
<div class="col s12 m12 l12">
<div class="card-panel" style="margin-top: 0px;">
	<div id="row-grouping" class="section" style="padding-top:0;">
		<div class="row">
			<div class="col s12 m7" style="margin-top: 30px;">
				<div class="col s3 m3 input-field">
					<select class="" name="space_type" id="space_type">
						<option value="">Space Type</option>
						<?php 
							$cpl_status="";
							$selected = "";
							if(isset($row['SpaceType']) && $row['SpaceType'] != "")
							{
								$selected = $row['SpaceType'];
							}
							echo $db->CreateOptions("html", "exterior_descript", array("id","name"),$selected,array("name"=>'asc'),"");
						?>
					</select>
				</div>
				<div class="col s3 m3 input-field">
					<a class="modal-trigger" style="color: rgb(51, 51, 51); margin-top: 15px;float:left;" href="#modal1"><span class="btn-floating btn" style="background: rgb(66, 133, 244) none repeat scroll 0% 0%; height: 20px; width: 20px; margin-right: 10px;"><i class="mdi-content-add" style="float: left; font-size: 16px; line-height: 20px ! important;"></i></span>Add
					</a>
				</div>
				<div class="col s2 m2 input-field">
					<input id="length" class="validate calculation placecolor" type="text" value="<?php if(isset($row['Length']))echo $row['Length'];?>" autocomplete="off" name="length" placeholder="Length">
					<label class="active" for="length">Length</label>
				</div>
				<div class="col s2 m2 input-field">
					<input id="height" class="validate calculation placecolor" type="text" value="<?php if(isset($row['Height']))echo $row['Height'];?>" autocomplete="off" name="height" placeholder="Height">
					<label class="active" for="height">Height</label>
				</div>
				<div class="col s2 m2 input-field">
					<input id="sqft" class="validate placecolor" type="text" value="<?php if(isset($row['Sq_Ft']))echo $row['Sq_Ft'];?>" autocomplete="off" name="sqft" readonly placeholder="Sq. Ft.">
					<label class="active" for="sqft">Sq. Ft.</label>
				</div>
			</div>
			<div class="col s12 m5">
				<div class="col s12 m12" style="text-align:center;">
					<h6>Job Total</h6>
				</div>
				<div class="col s4 m4 input-field">
					<input id="gallons" class="validate greyclr" type="text" value="<?php if(isset($row['Gallons']))echo $row['Gallons'];?>" autocomplete="off" readonly name="gallons" placeholder="Gallons"></textarea>
					<label class="active" for="gallons">Gallons</label>
				</div>
				<div class="col s4 m4 input-field">
					<input id="hours" class="validate greyclr" type="text" value="<?php if(isset($row['Hours']))echo $row['Hours'];?>" autocomplete="off" readonly name="hours" placeholder="Hours"></textarea>
					<label class="active" for="hours">Hours</label>
				</div>
				<div class="col s4 m4 input-field">
					<input id="cost" class="validate greyclr" type="text" value="<?php if(isset($row['Cost']))echo $row['Cost'];?>" autocomplete="off" readonly name="cost" placeholder="Cost"></textarea>
					<label class="active" for="cost">Cost</label>
				</div>
			</div>
			
			<div class="col s12 m12">
				<table id="mainTable" class="table table-striped" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
				<thead>
					<tr>
						<th>Job Item</th>
						<th>Quantity</th>
						<th>Unit</th>
						<th>Coats</th>
						<th>Finish</th>
						<th>Rates</th>
						<th>Gals</th>
						<th>Time</th>
					</tr>
				</thead>
					<tbody>
						<tr>
						   <td field="" class="white" colspan="8" style="text-align:center;font-weight: bold;">Preparation</td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Scraping & Sanding</td>
						   <td field="scraping_quantity" class="yellowclr"><?php if(isset($row['scraping_quantity']))echo $row['scraping_quantity'];?></td>
						   <td field="scraping_unit" class="light_blueclr">Hours</td>
						   <td field="scraping_coats" class="greyclr edit-disabled"><?php if(isset($row['scraping_coats']))echo $row['scraping_coats'];?></td>
						   <td field="scraping_finish" class="greyclr edit-disabled"><?php if(isset($row['scraping_finish']))echo $row['scraping_finish'];?></td>
						   <td field="scraping_rates" class="greyclr edit-disabled"><?php if(isset($row['scraping_rates']))echo $row['scraping_rates'];?></td>
						   <td field="scraping_gals" class="greyclr edit-disabled"><?php if(isset($row['scraping_gals']))echo $row['scraping_gals'];?></td>
						   <td field="scraping_time" class="light_blueclr"><?php if(isset($row['scraping_time']))echo $row['scraping_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Patch Stucco</td>
						   <td field="patch_quantity" class="yellowclr"><?php if(isset($row['patch_quantity']))echo $row['patch_quantity'];?></td>
						   <td field="patch_unit" class="light_blueclr">Hours</td>
						   <td field="patch_coats" class="greyclr edit-disabled"><?php if(isset($row['patch_coats']))echo $row['patch_coats'];?></td>
						   <td field="patch_finish" class="greyclr edit-disabled"><?php if(isset($row['patch_finish']))echo $row['patch_finish'];?></td>
						   <td field="patch_rates" class="greyclr edit-disabled"><?php if(isset($row['patch_rates']))echo $row['patch_rates'];?></td>
						   <td field="patch_gals" class="greyclr edit-disabled"><?php if(isset($row['patch_gals']))echo $row['patch_gals'];?></td>
						   <td field="patch_time" class="light_blueclr"><?php if(isset($row['patch_time']))echo $row['patch_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Feather Sanding</td>
						   <td field="feather_quantity" class="yellowclr"><?php if(isset($row['feather_quantity']))echo $row['feather_quantity'];?></td>
						   <td field="feather_unit" class="light_blueclr">Hours</td>
						   <td field="feather_coats" class="greyclr edit-disabled"><?php if(isset($row['feather_coats']))echo $row['feather_coats'];?></td>
						   <td field="feather_finish" class="greyclr edit-disabled"><?php if(isset($row['feather_finish']))echo $row['feather_finish'];?></td>
						   <td field="feather_rates" class="greyclr edit-disabled"><?php if(isset($row['feather_rates']))echo $row['feather_rates'];?></td>
						   <td field="feather_gals" class="greyclr edit-disabled"><?php if(isset($row['feather_gals']))echo $row['feather_gals'];?></td>
						   <td field="feather_time" class="light_blueclr"><?php if(isset($row['feather_time']))echo $row['feather_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Flexible Epoxy</td>
						   <td field="flexible_quantity" class="yellowclr"><?php if(isset($row['flexible_quantity']))echo $row['flexible_quantity'];?></td>
						   <td field="flexible_unit" class="light_blueclr">Hours</td>
						   <td field="flexible_coats" class="greyclr edit-disabled"><?php if(isset($row['flexible_coats']))echo $row['flexible_coats'];?></td>
						   <td field="flexible_finish" class="greyclr edit-disabled"><?php if(isset($row['flexible_finish']))echo $row['flexible_finish'];?></td>
						   <td field="flexible_rates" class="greyclr edit-disabled"><?php if(isset($row['flexible_rates']))echo $row['flexible_rates'];?></td>
						   <td field="flexible_gals" class="greyclr edit-disabled"><?php if(isset($row['flexible_gals']))echo $row['flexible_gals'];?></td>
						   <td field="flexible_time" class="light_blueclr"><?php if(isset($row['flexible_time']))echo $row['flexible_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Caulking</td>
						   <td field="caulking_quantity" class="yellowclr"><?php if(isset($row['caulking_quantity']))echo $row['caulking_quantity'];?></td>
						   <td field="caulking_unit" class="light_blueclr">Hours</td>
						   <td field="caulking_coats" class="greyclr edit-disabled"><?php if(isset($row['caulking_coats']))echo $row['caulking_coats'];?></td>
						   <td field="caulking_finish" class="greyclr edit-disabled"><?php if(isset($row['caulking_finish']))echo $row['caulking_finish'];?></td>
						   <td field="caulking_rates" class="greyclr edit-disabled"><?php if(isset($row['caulking_rates']))echo $row['caulking_rates'];?></td>
						   <td field="caulking_gals" class="greyclr edit-disabled"><?php if(isset($row['caulking_gals']))echo $row['caulking_gals'];?></td>
						   <td field="caulking_time" class="light_blueclr"><?php if(isset($row['caulking_time']))echo $row['caulking_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Pressure Wash</td>
						   <td field="pressure_quantity" class="yellowclr"><?php if(isset($row['pressure_quantity']))echo $row['pressure_quantity'];?></td>
						   <td field="pressure_unit" class="light_blueclr">Hours</td>
						   <td field="pressure_coats" class="greyclr edit-disabled"><?php if(isset($row['pressure_coats']))echo $row['pressure_coats'];?></td>
						   <td field="pressure_finish" class="greyclr edit-disabled"><?php if(isset($row['pressure_finish']))echo $row['pressure_finish'];?></td>
						   <td field="pressure_rates" class="greyclr edit-disabled"><?php if(isset($row['pressure_rates']))echo $row['pressure_rates'];?></td>
						   <td field="pressure_gals" class="greyclr edit-disabled"><?php if(isset($row['pressure_gals']))echo $row['pressure_gals'];?></td>
						   <td field="pressure_time" class="light_blueclr"><?php if(isset($row['pressure_time']))echo $row['pressure_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Roof Ladder Time</td>
						   <td field="roof_quantity" class="yellowclr"><?php if(isset($row['roof_quantity']))echo $row['roof_quantity'];?></td>
						   <td field="roof_unit" class="light_blueclr">Hours</td>
						   <td field="roof_coats" class="greyclr edit-disabled"><?php if(isset($row['roof_coats']))echo $row['roof_coats'];?></td>
						   <td field="roof_finish" class="greyclr edit-disabled"><?php if(isset($row['roof_finish']))echo $row['roof_finish'];?></td>
						   <td field="roof_rates" class="greyclr edit-disabled"><?php if(isset($row['roof_rates']))echo $row['roof_rates'];?></td>
						   <td field="roof_gals" class="greyclr edit-disabled"><?php if(isset($row['roof_gals']))echo $row['roof_gals'];?></td>
						   <td field="roof_time" class="light_blueclr"><?php if(isset($row['roof_time']))echo $row['roof_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Spot Prime</td>
						   <td field="spot_quantity" class="yellowclr"><?php if(isset($row['spot_quantity']))echo $row['spot_quantity'];?></td>
						   <td field="spot_unit" class="light_blueclr">Hours</td>
						   <td field="spot_coats" class="greyclr edit-disabled"><?php if(isset($row['spot_coats']))echo $row['spot_coats'];?></td>
						   <td field="spot_finish" class="greyclr edit-disabled"><?php if(isset($row['spot_finish']))echo $row['spot_finish'];?></td>
						   <td field="spot_rates" class="greyclr edit-disabled"><?php if(isset($row['spot_rates']))echo $row['spot_rates'];?></td>
						   <td field="spot_gals" class="greyclr edit-disabled"><?php if(isset($row['spot_gals']))echo $row['spot_gals'];?></td>
						   <td field="spot_time" class="light_blueclr"><?php if(isset($row['spot_time']))echo $row['spot_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Remove Replace Lights</td>
						   <td field="remove_lights_quantity" class="yellowclr"><?php if(isset($row['remove_lights_quantity']))echo $row['remove_lights_quantity'];?></td>
						   <td field="remove_lights_unit" class="light_blueclr">Each</td>
						   <td field="remove_lights_coats" class="greyclr edit-disabled"><?php if(isset($row['remove_lights_coats']))echo $row['remove_lights_coats'];?></td>
						   <td field="remove_lights_finish" class="greyclr edit-disabled"><?php if(isset($row['remove_lights_finish']))echo $row['remove_lights_finish'];?></td>
						   <td field="remove_lights_rates" class="greyclr edit-disabled remove_lights_rates">0.17</td>
						   <td field="remove_lights_gals" class="greyclr edit-disabled"><?php if(isset($row['remove_lights_gals']))echo $row['remove_lights_gals'];?></td>
						   <td field="remove_lights_time" class="light_blueclr"><?php if(isset($row['remove_lights_time']))echo $row['remove_lights_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Remove Replace Screens</td>
						   <td field="remove_screens_quantity" class="yellowclr"><?php if(isset($row['remove_screens_quantity']))echo $row['remove_screens_quantity'];?></td>
						   <td field="remove_screens_unit" class="light_blueclr">Each</td>
						   <td field="remove_screens_coats" class="greyclr edit-disabled"><?php if(isset($row['remove_screens_coats']))echo $row['remove_screens_coats'];?></td>
						   <td field="remove_screens_finish" class="greyclr edit-disabled"><?php if(isset($row['remove_screens_finish']))echo $row['remove_screens_finish'];?></td>
						   <td field="remove_screens_rates" class="greyclr edit-disabled">0.17</td>
						   <td field="remove_screens_gals" class="greyclr edit-disabled"><?php if(isset($row['remove_screens_gals']))echo $row['remove_screens_gals'];?></td>
						   <td field="remove_screens_time" class="light_blueclr"><?php if(isset($row['remove_screens_time']))echo $row['remove_screens_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Remove Replace Other</td>
						   <td field="remove_other_quantity" class="yellowclr"><?php if(isset($row['remove_other_quantity']))echo $row['remove_other_quantity'];?></td>
						   <td field="remove_other_unit" class="light_blueclr">Each</td>
						   <td field="remove_other_coats" class="greyclr edit-disabled"><?php if(isset($row['remove_other_coats']))echo $row['remove_other_coats'];?></td>
						   <td field="remove_other_finish" class="greyclr edit-disabled"><?php if(isset($row['remove_other_finish']))echo $row['remove_other_finish'];?></td>
						   <td field="remove_other_rates" class="greyclr edit-disabled"><?php if(isset($row['remove_other_rates']))echo $row['remove_other_rates'];?></td>
						   <td field="remove_other_gals" class="greyclr edit-disabled"><?php if(isset($row['remove_other_gals']))echo $row['remove_other_gals'];?></td>
						   <td field="remove_other_time" class="light_blueclr"><?php if(isset($row['remove_other_time']))echo $row['remove_other_time'];?></td>
						</tr
						<tr>
						   <td field="" class="light_blueclr">Wash Windows</td>
						   <td field="wash_quantity" class="yellowclr"><?php if(isset($row['wash_quantity']))echo $row['wash_quantity'];?></td>
						   <td field="wash_unit" class="light_blueclr">Each</td>
						   <td field="wash_coats" class="greyclr edit-disabled"><?php if(isset($row['wash_coats']))echo $row['wash_coats'];?></td>
						   <td field="wash_finish" class="greyclr edit-disabled"><?php if(isset($row['wash_finish']))echo $row['wash_finish'];?></td>
						   <td field="wash_rates" class="greyclr edit-disabled">1.00</td>
						   <td field="wash_gals" class="greyclr edit-disabled"><?php if(isset($row['wash_gals']))echo $row['wash_gals'];?></td>
						   <td field="wash_time" class="light_blueclr"><?php if(isset($row['wash_time']))echo $row['wash_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Pressure Wash Deck</td>
						   <td field="pressurewashdeck_quantity" class="yellowclr"><?php if(isset($row['pressurewashdeck_quantity']))echo $row['pressurewashdeck_quantity'];?></td>
						   <td field="pressurewashdeck_unit" class="light_blueclr">Sq. Ft.</td>
						   <td field="pressurewashdeck_coats" class="greyclr edit-disabled"><?php if(isset($row['pressurewashdeck_coats']))echo $row['pressurewashdeck_coats'];?></td>
						   <td field="pressurewashdeck_finish" class="greyclr edit-disabled"><?php if(isset($row['pressurewashdeck_finish']))echo $row['pressurewashdeck_finish'];?></td>
						   <td field="pressurewashdeck_rates" class="greyclr edit-disabled">100.00</td>
						   <td field="pressurewashdeck_gals" class="greyclr edit-disabled"><?php if(isset($row['pressurewashdeck_gals']))echo $row['pressurewashdeck_gals'];?></td>
						   <td field="pressurewashdeck_time" class="light_blueclr"><?php if(isset($row['pressurewashdeck_time']))echo $row['pressurewashdeck_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="white" colspan="8" style="text-align:center;font-weight: bold;">Painting</td>
						</tr>
						<tr>
						   <td field="" class="light_orangeclr">Mask Windows Doors</td>
						   <td field="maskwindowsdoors_quantity" class="yellowclr"><?php if(isset($row['maskwindowsdoors_quantity']))echo $row['maskwindowsdoors_quantity'];?></td>
						   <td field="maskwindowsdoors_unit" class="light_blueclr">Each</td>
						   <td field="maskwindowsdoors_coats" class="greyclr edit-disabled"><?php if(isset($row['maskwindowsdoors_coats']))echo $row['maskwindowsdoors_coats'];?></td>
						   <td field="maskwindowsdoors_finish" class="greyclr edit-disabled"><?php if(isset($row['maskwindowsdoors_finish']))echo $row['maskwindowsdoors_finish'];?></td>
						   <td field="maskwindowsdoors_rates" class="greyclr edit-disabled">0.25</td>
						   <td field="maskwindowsdoors_gals" class="greyclr edit-disabled"><?php if(isset($row['maskwindowsdoors_gals']))echo $row['maskwindowsdoors_gals'];?></td>
						   <td field="maskwindowsdoors_time" class="light_blueclr"><?php if(isset($row['maskwindowsdoors_time']))echo $row['maskwindowsdoors_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_orangeclr">Mask Other</td>
						   <td field="maskother_quantity" class="yellowclr"><?php if(isset($row['maskother_quantity']))echo $row['maskother_quantity'];?></td>
						   <td field="maskother_unit" class="light_blueclr">Hours</td>
						   <td field="maskother_coats" class="greyclr edit-disabled"><?php if(isset($row['maskother_coats']))echo $row['maskother_coats'];?></td>
						   <td field="maskother_finish" class="greyclr edit-disabled"><?php if(isset($row['maskother_finish']))echo $row['maskother_finish'];?></td>
						   <td field="maskother_rates" class="greyclr edit-disabled"><?php if(isset($row['maskother_rates']))echo $row['maskother_rates'];?></td>
						   <td field="maskother_gals" class="greyclr edit-disabled"><?php if(isset($row['maskother_gals']))echo $row['maskother_gals'];?></td>
						   <td field="maskother_time" class="light_blueclr"><?php if(isset($row['maskother_time']))echo $row['maskother_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="dark_blueclr">Eaves Single Story</td>
						   <td field="eavessingle_quantity" class="yellowclr"><?php if(isset($row['eavessingle_quantity']))echo $row['eavessingle_quantity'];?></td>
						   <td field="eavessingle_unit" class="light_blueclr">Ln. Ft.</td>
						   <td field="eavessingle_coats" class="yellowclr"><?php if(isset($row['eavessingle_coats']))echo $row['eavessingle_coats'];?></td>
						   <td field="eavessingle_finish" class="greyclr edit-disabled"><?php if(isset($row['eavessingle_finish']))echo $row['eavessingle_finish'];?></td>
						   <td field="eavessingle_rates" class="greyclr edit-disabled"><?php if(isset($row['eavessingle_rates']))echo $row['eavessingle_rates'];?></td>
						   <td field="eavessingle_gals" class="white"><?php if(isset($row['eavessingle_gals']))echo $row['eavessingle_gals'];?></td>
						   <td field="eavessingle_time" class="light_blueclr"><?php if(isset($row['eavessingle_time']))echo $row['eavessingle_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="dark_blueclr">Eaves Two Story</td>
						   <td field="eavestwo_quantity" class="yellowclr"><?php if(isset($row['eavestwo_quantity']))echo $row['eavestwo_quantity'];?></td>
						   <td field="eavestwo_unit" class="light_blueclr">Ln. Ft.</td>
						   <td field="eavestwo_coats" class="yellowclr"><?php if(isset($row['eavestwo_coats']))echo $row['eavestwo_coats'];?></td>
						   <td field="eavestwo_finish" class="greyclr edit-disabled"><?php if(isset($row['eavestwo_finish']))echo $row['eavestwo_finish'];?></td>
						   <td field="eavestwo_rates" class="greyclr edit-disabled"><?php if(isset($row['eavestwo_rates']))echo $row['eavestwo_rates'];?></td>
						   <td field="eavestwo_gals" class="white"><?php if(isset($row['eavestwo_gals']))echo $row['eavestwo_gals'];?></td>
						   <td field="eavestwo_time" class="light_blueclr"><?php if(isset($row['eavestwo_time']))echo $row['eavestwo_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="dark_blueclr">Eaves Easy</td>
						   <td field="eaveseasy_quantity" class="yellowclr"><?php if(isset($row['eaveseasy_quantity']))echo $row['eaveseasy_quantity'];?></td>
						   <td field="eaveseasy_unit" class="light_blueclr">Ln. Ft.</td>
						   <td field="eaveseasy_coats" class="yellowclr"><?php if(isset($row['eaveseasy_coats']))echo $row['eaveseasy_coats'];?></td>
						   <td field="eaveseasy_finish" class="greyclr edit-disabled"><?php if(isset($row['eaveseasy_finish']))echo $row['eaveseasy_finish'];?></td>
						   <td field="eaveseasy_rates" class="greyclr edit-disabled"><?php if(isset($row['eaveseasy_rates']))echo $row['eaveseasy_rates'];?></td>
						   <td field="eaveseasy_gals" class="white"><?php if(isset($row['eaveseasy_gals']))echo $row['eaveseasy_gals'];?></td>
						   <td field="eaveseasy_time" class="light_blueclr"><?php if(isset($row['eaveseasy_time']))echo $row['eaveseasy_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="dark_blueclr">Eaves Hard</td>
						   <td field="eaveshard_quantity" class="yellowclr"><?php if(isset($row['eaveshard_quantity']))echo $row['eaveshard_quantity'];?></td>
						   <td field="eaveshard_unit" class="light_blueclr">Ln. Ft.</td>
						   <td field="eaveshard_coats" class="yellowclr"><?php if(isset($row['eaveshard_coats']))echo $row['eaveshard_coats'];?></td>
						   <td field="eaveshard_finish" class="greyclr edit-disabled"><?php if(isset($row['eaveshard_finish']))echo $row['eaveshard_finish'];?></td>
						   <td field="eaveshard_rates" class="greyclr edit-disabled"><?php if(isset($row['eaveshard_rates']))echo $row['eaveshard_rates'];?></td>
						   <td field="eaveshard_gals" class="white"><?php if(isset($row['eaveshard_gals']))echo $row['eaveshard_gals'];?></td>
						   <td field="eaveshard_time" class="light_blueclr"><?php if(isset($row['eaveshard_time']))echo $row['eaveshard_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_greenclr">Fascia Single Story</td>
						   <td field="fasciasingle_quantity" class="yellowclr"><?php if(isset($row['fasciasingle_quantity']))echo $row['fasciasingle_quantity'];?></td>
						   <td field="fasciasingle_unit" class="light_blueclr">Ln. Ft.</td>
						   <td field="fasciasingle_coats" class="yellowclr"><?php if(isset($row['fasciasingle_coats']))echo $row['fasciasingle_coats'];?></td>
						   <td field="fasciasingle_finish" class="greyclr edit-disabled"><?php if(isset($row['fasciasingle_finish']))echo $row['fasciasingle_finish'];?></td>
						   <td field="fasciasingle_rates" class="greyclr edit-disabled"><?php if(isset($row['fasciasingle_rates']))echo $row['fasciasingle_rates'];?></td>
						   <td field="fasciasingle_gals" class="white"><?php if(isset($row['fasciasingle_gals']))echo $row['fasciasingle_gals'];?></td>
						   <td field="fasciasingle_time" class="light_blueclr"><?php if(isset($row['fasciasingle_time']))echo $row['fasciasingle_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_greenclr">Fascia Two Story</td>
						   <td field="fasciatwo_quantity" class="yellowclr"><?php if(isset($row['fasciatwo_quantity']))echo $row['fasciatwo_quantity'];?></td>
						   <td field="fasciatwo_unit" class="light_blueclr">Ln. Ft.</td>
						   <td field="fasciatwo_coats" class="yellowclr"><?php if(isset($row['fasciatwo_coats']))echo $row['fasciatwo_coats'];?></td>
						   <td field="fasciatwo_finish" class="greyclr edit-disabled"><?php if(isset($row['fasciatwo_finish']))echo $row['fasciatwo_finish'];?></td>
						   <td field="fasciatwo_rates" class="greyclr edit-disabled"><?php if(isset($row['fasciatwo_rates']))echo $row['fasciatwo_rates'];?></td>
						   <td field="fasciatwo_gals" class="white"><?php if(isset($row['fasciatwo_gals']))echo $row['fasciatwo_gals'];?></td>
						   <td field="fasciatwo_time" class="light_blueclr"><?php if(isset($row['fasciatwo_time']))echo $row['fasciatwo_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_purpleclr">Metal Flashing</td>
						   <td field="metalflashing_quantity" class="yellowclr"><?php if(isset($row['metalflashing_quantity']))echo $row['metalflashing_quantity'];?></td>
						   <td field="metalflashing_unit" class="light_blueclr">Ln. Ft.</td>
						   <td field="metalflashing_coats" class="yellowclr"><?php if(isset($row['metalflashing_coats']))echo $row['metalflashing_coats'];?></td>
						   <td field="metalflashing_finish" class="greyclr edit-disabled"><?php if(isset($row['metalflashing_finish']))echo $row['metalflashing_finish'];?></td>
						   <td field="metalflashing_rates" class="greyclr edit-disabled"><?php if(isset($row['metalflashing_rates']))echo $row['metalflashing_rates'];?></td>
						   <td field="metalflashing_gals" class="white"><?php if(isset($row['metalflashing_gals']))echo $row['metalflashing_gals'];?></td>
						   <td field="metalflashing_time" class="light_blueclr"><?php if(isset($row['metalflashing_time']))echo $row['metalflashing_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_redclr">Rain Gutters Downspouts</td>
						   <td field="raingutters_quantity" class="yellowclr"><?php if(isset($row['raingutters_quantity']))echo $row['raingutters_quantity'];?></td>
						   <td field="raingutters_unit" class="light_blueclr">Ln. Ft.</td>
						   <td field="raingutters_coats" class="yellowclr"><?php if(isset($row['raingutters_coats']))echo $row['raingutters_coats'];?></td>
						   <td field="raingutters_finish" class="greyclr edit-disabled"><?php if(isset($row['raingutters_finish']))echo $row['raingutters_finish'];?></td>
						   <td field="raingutters_rates" class="greyclr edit-disabled"><?php if(isset($row['raingutters_rates']))echo $row['raingutters_rates'];?></td>
						   <td field="raingutters_gals" class="white"><?php if(isset($row['raingutters_gals']))echo $row['raingutters_gals'];?></td>
						   <td field="raingutters_time" class="light_blueclr"><?php if(isset($row['raingutters_time']))echo $row['raingutters_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Shutters</td>
						   <td field="shutters_quantity" class="yellowclr"><?php if(isset($row['shutters_quantity']))echo $row['shutters_quantity'];?></td>
						   <td field="shutters_unit" class="light_blueclr">Each</td>
						   <td field="shutters_coats" class="yellowclr"><?php if(isset($row['shutters_coats']))echo $row['shutters_coats'];?></td>
						   <td field="shutters_finish" class="greyclr edit-disabled"><?php if(isset($row['shutters_finish']))echo $row['shutters_finish'];?></td>
						   <td field="shutters_rates" class="greyclr edit-disabled"><?php if(isset($row['shutters_rates']))echo $row['shutters_rates'];?></td>
						   <td field="shutters_gals" class="white"><?php if(isset($row['shutters_gals']))echo $row['shutters_gals'];?></td>
						   <td field="shutters_time" class="light_blueclr"><?php if(isset($row['shutters_time']))echo $row['shutters_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_orangeclr">Windows Trim</td>
						   <td field="windowstrim_quantity" class="yellowclr"><?php if(isset($row['windowstrim_quantity']))echo $row['windowstrim_quantity'];?></td>
						   <td field="windowstrim_unit" class="light_blueclr">Each</td>
						   <td field="windowstrim_coats" class="yellowclr"><?php if(isset($row['windowstrim_coats']))echo $row['windowstrim_coats'];?></td>
						   <td field="windowstrim_finish" class="greyclr edit-disabled"><?php if(isset($row['windowstrim_finish']))echo $row['windowstrim_finish'];?></td>
						   <td field="windowstrim_rates" class="greyclr edit-disabled"><?php if(isset($row['windowstrim_rates']))echo $row['windowstrim_rates'];?></td>
						   <td field="windowstrim_gals" class="white"><?php if(isset($row['windowstrim_gals']))echo $row['windowstrim_gals'];?></td>
						   <td field="windowstrim_time" class="light_blueclr"><?php if(isset($row['windowstrim_time']))echo $row['windowstrim_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_orangeclr">Windows 2 Pane</td>
						   <td field="windows2pane_quantity" class="yellowclr"><?php if(isset($row['windows2pane_quantity']))echo $row['windows2pane_quantity'];?></td>
						   <td field="windows2pane_unit" class="light_blueclr">Each</td>
						   <td field="windows2pane_coats" class="yellowclr"><?php if(isset($row['windows2pane_coats']))echo $row['windows2pane_coats'];?></td>
						   <td field="windows2pane_finish" class="greyclr edit-disabled"><?php if(isset($row['windows2pane_finish']))echo $row['windows2pane_finish'];?></td>
						   <td field="windows2pane_rates" class="greyclr edit-disabled"><?php if(isset($row['windows2pane_rates']))echo $row['windows2pane_rates'];?></td>
						   <td field="windows2pane_gals" class="white"><?php if(isset($row['windows2pane_gals']))echo $row['windows2pane_gals'];?></td>
						   <td field="windows2pane_time" class="light_blueclr"><?php if(isset($row['windows2pane_time']))echo $row['windows2pane_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_orangeclr">Windows 3 to 7 Pane</td>
						   <td field="windows37pane_quantity" class="yellowclr"><?php if(isset($row['windows37pane_quantity']))echo $row['windows37pane_quantity'];?></td>
						   <td field="windows37pane_unit" class="light_blueclr">Each</td>
						   <td field="windows37pane_coats" class="yellowclr"><?php if(isset($row['windows37pane_coats']))echo $row['windows37pane_coats'];?></td>
						   <td field="windows37pane_finish" class="greyclr edit-disabled"><?php if(isset($row['windows37pane_finish']))echo $row['windows37pane_finish'];?></td>
						   <td field="windows37pane_rates" class="greyclr edit-disabled"><?php if(isset($row['windows37pane_rates']))echo $row['windows37pane_rates'];?></td>
						   <td field="windows37pane_gals" class="white"><?php if(isset($row['windows37pane_gals']))echo $row['windows37pane_gals'];?></td>
						   <td field="windows37pane_time" class="light_blueclr"><?php if(isset($row['windows37pane_time']))echo $row['windows37pane_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_orangeclr">Windows 8 to 15 Pane</td>
						   <td field="windows815pane_quantity" class="yellowclr"><?php if(isset($row['windows815pane_quantity']))echo $row['windows815pane_quantity'];?></td>
						   <td field="windows815pane_unit" class="light_blueclr">Each</td>
						   <td field="windows815pane_coats" class="yellowclr"><?php if(isset($row['windows815pane_coats']))echo $row['windows815pane_coats'];?></td>
						   <td field="windows815pane_finish" class="greyclr edit-disabled"><?php if(isset($row['windows815pane_finish']))echo $row['windows815pane_finish'];?></td>
						   <td field="windows815pane_rates" class="greyclr edit-disabled"><?php if(isset($row['windows815pane_rates']))echo $row['windows815pane_rates'];?></td>
						   <td field="windows815pane_gals" class="white"><?php if(isset($row['windows815pane_gals']))echo $row['windows815pane_gals'];?></td>
						   <td field="windows815pane_time" class="light_blueclr"><?php if(isset($row['windows815pane_time']))echo $row['windows815pane_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_orangeclr">Windows 16 or more Pane</td>
						   <td field="windows16pane_quantity" class="yellowclr"><?php if(isset($row['windows16pane_quantity']))echo $row['windows16pane_quantity'];?></td>
						   <td field="windows16pane_unit" class="light_blueclr">Each</td>
						   <td field="windows16pane_coats" class="yellowclr"><?php if(isset($row['windows16pane_coats']))echo $row['windows16pane_coats'];?></td>
						   <td field="windows16pane_finish" class="greyclr edit-disabled"><?php if(isset($row['windows16pane_finish']))echo $row['windows16pane_finish'];?></td>
						   <td field="windows16pane_rates" class="greyclr edit-disabled"><?php if(isset($row['windows16pane_rates']))echo $row['windows16pane_rates'];?></td>
						   <td field="windows16pane_gals" class="white"><?php if(isset($row['windows16pane_gals']))echo $row['windows16pane_gals'];?></td>
						   <td field="windows16pane_time" class="light_blueclr"><?php if(isset($row['windows16pane_time']))echo $row['windows16pane_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Doors Flat</td>
						   <td field="doorsflat_quantity" class="yellowclr"><?php if(isset($row['doorsflat_quantity']))echo $row['doorsflat_quantity'];?></td>
						   <td field="doorsflat_unit" class="light_blueclr">Each</td>
						   <td field="doorsflat_coats" class="yellowclr"><?php if(isset($row['doorsflat_coats']))echo $row['doorsflat_coats'];?></td>
						   <td field="doorsflat_finish" class="greyclr edit-disabled"><?php if(isset($row['doorsflat_finish']))echo $row['doorsflat_finish'];?></td>
						   <td field="doorsflat_rates" class="greyclr edit-disabled"><?php if(isset($row['doorsflat_rates']))echo $row['doorsflat_rates'];?></td>
						   <td field="doorsflat_gals" class="white"><?php if(isset($row['doorsflat_gals']))echo $row['doorsflat_gals'];?></td>
						   <td field="doorsflat_time" class="light_blueclr"><?php if(isset($row['doorsflat_time']))echo $row['doorsflat_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Doors Light</td>
						   <td field="doorslight_quantity" class="yellowclr"><?php if(isset($row['doorslight_quantity']))echo $row['doorslight_quantity'];?></td>
						   <td field="doorslight_unit" class="light_blueclr">Each</td>
						   <td field="doorslight_coats" class="yellowclr"><?php if(isset($row['doorslight_coats']))echo $row['doorslight_coats'];?></td>
						   <td field="doorslight_finish" class="greyclr edit-disabled"><?php if(isset($row['doorslight_finish']))echo $row['doorslight_finish'];?></td>
						   <td field="doorslight_rates" class="greyclr edit-disabled"><?php if(isset($row['doorslight_rates']))echo $row['doorslight_rates'];?></td>
						   <td field="doorslight_gals" class="white"><?php if(isset($row['doorslight_gals']))echo $row['doorslight_gals'];?></td>
						   <td field="doorslight_time" class="light_blueclr"><?php if(isset($row['doorslight_time']))echo $row['doorslight_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Doors Paneled</td>
						   <td field="doorspaneled_quantity" class="yellowclr"><?php if(isset($row['doorspaneled_quantity']))echo $row['doorspaneled_quantity'];?></td>
						   <td field="doorspaneled_unit" class="light_blueclr">Each</td>
						   <td field="doorspaneled_coats" class="yellowclr"><?php if(isset($row['doorspaneled_coats']))echo $row['doorspaneled_coats'];?></td>
						   <td field="doorspaneled_finish" class="greyclr edit-disabled"><?php if(isset($row['doorspaneled_finish']))echo $row['doorspaneled_finish'];?></td>
						   <td field="doorspaneled_rates" class="greyclr edit-disabled"><?php if(isset($row['doorspaneled_rates']))echo $row['doorspaneled_rates'];?></td>
						   <td field="doorspaneled_gals" class="white"><?php if(isset($row['doorspaneled_gals']))echo $row['doorspaneled_gals'];?></td>
						   <td field="doorspaneled_time" class="light_blueclr"><?php if(isset($row['doorspaneled_time']))echo $row['doorspaneled_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Doors French</td>
						   <td field="doorsfrench_quantity" class="yellowclr"><?php if(isset($row['doorsfrench_quantity']))echo $row['doorsfrench_quantity'];?></td>
						   <td field="doorsfrench_unit" class="light_blueclr">Each</td>
						   <td field="doorsfrench_coats" class="yellowclr"><?php if(isset($row['doorsfrench_coats']))echo $row['doorsfrench_coats'];?></td>
						   <td field="doorsfrench_finish" class="greyclr edit-disabled"><?php if(isset($row['doorsfrench_finish']))echo $row['doorsfrench_finish'];?></td>
						   <td field="doorsfrench_rates" class="greyclr edit-disabled"><?php if(isset($row['doorsfrench_rates']))echo $row['doorsfrench_rates'];?></td>
						   <td field="doorsfrench_gals" class="white"><?php if(isset($row['doorsfrench_gals']))echo $row['doorsfrench_gals'];?></td>
						   <td field="doorsfrench_time" class="light_blueclr"><?php if(isset($row['doorsfrench_time']))echo $row['doorsfrench_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_redclr">Garage Door</td>
						   <td field="garagedoor_quantity" class="yellowclr"><?php if(isset($row['garagedoor_quantity']))echo $row['garagedoor_quantity'];?></td>
						   <td field="garagedoor_unit" class="light_blueclr">Each</td>
						   <td field="garagedoor_coats" class="yellowclr"><?php if(isset($row['garagedoor_coats']))echo $row['garagedoor_coats'];?></td>
						   <td field="garagedoor_finish" class="greyclr edit-disabled"><?php if(isset($row['garagedoor_finish']))echo $row['garagedoor_finish'];?></td>
						   <td field="garagedoor_rates" class="greyclr edit-disabled"><?php if(isset($row['garagedoor_rates']))echo $row['garagedoor_rates'];?></td>
						   <td field="garagedoor_gals" class="white"><?php if(isset($row['garagedoor_gals']))echo $row['garagedoor_gals'];?></td>
						   <td field="garagedoor_time" class="light_blueclr"><?php if(isset($row['garagedoor_time']))echo $row['garagedoor_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_redclr">Garage Door Frame</td>
						   <td field="garagedoorframe_quantity" class="yellowclr"><?php if(isset($row['garagedoorframe_quantity']))echo $row['garagedoorframe_quantity'];?></td>
						   <td field="garagedoorframe_unit" class="light_blueclr">Each</td>
						   <td field="garagedoorframe_coats" class="yellowclr"><?php if(isset($row['garagedoorframe_coats']))echo $row['garagedoorframe_coats'];?></td>
						   <td field="garagedoorframe_finish" class="greyclr edit-disabled"><?php if(isset($row['garagedoorframe_finish']))echo $row['garagedoorframe_finish'];?></td>
						   <td field="garagedoorframe_rates" class="greyclr edit-disabled"><?php if(isset($row['garagedoorframe_rates']))echo $row['garagedoorframe_rates'];?></td>
						   <td field="garagedoorframe_gals" class="white"><?php if(isset($row['garagedoorframe_gals']))echo $row['garagedoorframe_gals'];?></td>
						   <td field="garagedoorframe_time" class="light_blueclr"><?php if(isset($row['garagedoorframe_time']))echo $row['garagedoorframe_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_blueclr">Entry Door or Frame Only</td>
						   <td field="entrydoor_quantity" class="yellowclr"><?php if(isset($row['entrydoor_quantity']))echo $row['entrydoor_quantity'];?></td>
						   <td field="entrydoor_unit" class="light_blueclr">Each</td>
						   <td field="entrydoor_coats" class="yellowclr"><?php if(isset($row['entrydoor_coats']))echo $row['entrydoor_coats'];?></td>
						   <td field="entrydoor_finish" class="greyclr edit-disabled"><?php if(isset($row['entrydoor_finish']))echo $row['entrydoor_finish'];?></td>
						   <td field="entrydoor_rates" class="greyclr edit-disabled"><?php if(isset($row['entrydoor_rates']))echo $row['entrydoor_rates'];?></td>
						   <td field="entrydoor_gals" class="greyclr edit-disabled"><?php if(isset($row['entrydoor_gals']))echo $row['entrydoor_gals'];?></td>
						   <td field="entrydoor_time" class="light_blueclr"><?php if(isset($row['entrydoor_time']))echo $row['entrydoor_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_purpleclr">Posts or Pillars</td>
						   <td field="postspillars_quantity" class="yellowclr"><?php if(isset($row['postspillars_quantity']))echo $row['postspillars_quantity'];?></td>
						   <td field="postspillars_unit" class="light_blueclr">Each</td>
						   <td field="postspillars_coats" class="yellowclr"><?php if(isset($row['postspillars_coats']))echo $row['postspillars_coats'];?></td>
						   <td field="postspillars_finish" class="greyclr edit-disabled"><?php if(isset($row['postspillars_finish']))echo $row['postspillars_finish'];?></td>
						   <td field="postspillars_rates" class="greyclr edit-disabled"><?php if(isset($row['postspillars_rates']))echo $row['postspillars_rates'];?></td>
						   <td field="postspillars_gals" class="white"><?php if(isset($row['postspillars_gals']))echo $row['postspillars_gals'];?></td>
						   <td field="postspillars_time" class="light_blueclr"><?php if(isset($row['postspillars_time']))echo $row['postspillars_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="light_greenclr">Wrought Iron</td>
						   <td field="wroughtiron_quantity" class="yellowclr"><?php if(isset($row['wroughtiron_quantity']))echo $row['wroughtiron_quantity'];?></td>
						   <td field="wroughtiron_unit" class="light_blueclr">Ln. Ft.</td>
						   <td field="wroughtiron_coats" class="yellowclr"><?php if(isset($row['wroughtiron_coats']))echo $row['wroughtiron_coats'];?></td>
						   <td field="wroughtiron_finish" class="greyclr edit-disabled"><?php if(isset($row['wroughtiron_finish']))echo $row['wroughtiron_finish'];?></td>
						   <td field="wroughtiron_rates" class="greyclr edit-disabled"><?php if(isset($row['wroughtiron_rates']))echo $row['wroughtiron_rates'];?></td>
						   <td field="wroughtiron_gals" class="white"><?php if(isset($row['wroughtiron_gals']))echo $row['wroughtiron_gals'];?></td>
						   <td field="wroughtiron_time" class="light_blueclr"><?php if(isset($row['wroughtiron_time']))echo $row['wroughtiron_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="dark_blueclr">Stucco Single Story</td>
						   <td field="stuccosingle_quantity" class="yellowclr"><?php if(isset($row['stuccosingle_quantity']))echo $row['stuccosingle_quantity'];?></td>
						   <td field="stuccosingle_unit" class="light_blueclr">Sq. Ft.</td>
						   <td field="stuccosingle_coats" class="yellowclr"><?php if(isset($row['stuccosingle_coats']))echo $row['stuccosingle_coats'];?></td>
						   <td field="stuccosingle_finish" class="greyclr edit-disabled"><?php if(isset($row['stuccosingle_finish']))echo $row['stuccosingle_finish'];?></td>
						   <td field="stuccosingle_rates" class="greyclr edit-disabled"><?php if(isset($row['stuccosingle_rates']))echo $row['stuccosingle_rates'];?></td>
						   <td field="stuccosingle_gals" class="white"><?php if(isset($row['stuccosingle_gals']))echo $row['stuccosingle_gals'];?></td>
						   <td field="stuccosingle_time" class="light_blueclr"><?php if(isset($row['stuccosingle_time']))echo $row['stuccosingle_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="dark_blueclr">Stucco Two Story</td>
						   <td field="stuccotwo_quantity" class="yellowclr"><?php if(isset($row['stuccotwo_quantity']))echo $row['stuccotwo_quantity'];?></td>
						   <td field="stuccotwo_unit" class="light_blueclr">Sq. Ft.</td>
						   <td field="stuccotwo_coats" class="yellowclr"><?php if(isset($row['stuccotwo_coats']))echo $row['stuccotwo_coats'];?></td>
						   <td field="stuccotwo_finish" class="greyclr edit-disabled"><?php if(isset($row['stuccotwo_finish']))echo $row['stuccotwo_finish'];?></td>
						   <td field="stuccotwo_rates" class="greyclr edit-disabled"><?php if(isset($row['stuccotwo_rates']))echo $row['stuccotwo_rates'];?></td>
						   <td field="stuccotwo_gals" class="white"><?php if(isset($row['stuccotwo_gals']))echo $row['stuccotwo_gals'];?></td>
						   <td field="stuccotwo_time" class="light_blueclr"><?php if(isset($row['stuccotwo_time']))echo $row['stuccotwo_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="dark_blueclr">Siding Single Story</td>
						   <td field="sidingsingle_quantity" class="yellowclr"><?php if(isset($row['sidingsingle_quantity']))echo $row['sidingsingle_quantity'];?></td>
						   <td field="sidingsingle_unit" class="light_blueclr">Sq. Ft.</td>
						   <td field="sidingsingle_coats" class="yellowclr"><?php if(isset($row['sidingsingle_coats']))echo $row['sidingsingle_coats'];?></td>
						   <td field="sidingsingle_finish" class="greyclr edit-disabled"><?php if(isset($row['sidingsingle_finish']))echo $row['sidingsingle_finish'];?></td>
						   <td field="sidingsingle_rates" class="greyclr edit-disabled"><?php if(isset($row['sidingsingle_rates']))echo $row['sidingsingle_rates'];?></td>
						   <td field="sidingsingle_gals" class="white"><?php if(isset($row['sidingsingle_gals']))echo $row['sidingsingle_gals'];?></td>
						   <td field="sidingsingle_time" class="light_blueclr"><?php if(isset($row['sidingsingle_time']))echo $row['sidingsingle_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="dark_blueclr">Siding Two Story</td>
						   <td field="sidingtwo_quantity" class="yellowclr"><?php if(isset($row['sidingtwo_quantity']))echo $row['sidingtwo_quantity'];?></td>
						   <td field="sidingtwo_unit" class="light_blueclr">Sq. Ft.</td>
						   <td field="sidingtwo_coats" class="yellowclr"><?php if(isset($row['sidingtwo_coats']))echo $row['sidingtwo_coats'];?></td>
						   <td field="sidingtwo_finish" class="greyclr edit-disabled"><?php if(isset($row['sidingtwo_finish']))echo $row['sidingtwo_finish'];?></td>
						   <td field="sidingtwo_rates" class="greyclr edit-disabled"><?php if(isset($row['sidingtwo_rates']))echo $row['sidingtwo_rates'];?></td>
						   <td field="sidingtwo_gals" class="white"><?php if(isset($row['sidingtwo_gals']))echo $row['sidingtwo_gals'];?></td>
						   <td field="sidingtwo_time" class="light_blueclr"><?php if(isset($row['sidingtwo_time']))echo $row['sidingtwo_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="dark_blueclr">Body Paint: +/- Time</td>
						   <td field="bodypaint_quantity" class="yellowclr"><?php if(isset($row['bodypaint_quantity']))echo $row['bodypaint_quantity'];?></td>
						   <td field="bodypaint_unit" class="light_blueclr">Hours</td>
						   <td field="bodypaint_coats" class="greyclr edit-disabled"><?php if(isset($row['bodypaint_coats']))echo $row['bodypaint_coats'];?></td>
						   <td field="bodypaint_finish" class="greyclr edit-disabled"><?php if(isset($row['bodypaint_finish']))echo $row['bodypaint_finish'];?></td>
						   <td field="bodypaint_rates" class="greyclr edit-disabled"><?php if(isset($row['bodypaint_rates']))echo $row['bodypaint_rates'];?></td>
						   <td field="bodypaint_gals" class="greyclr edit-disabled"><?php if(isset($row['bodypaint_gals']))echo $row['bodypaint_gals'];?></td>
						   <td field="bodypaint_time" class="light_blueclr"><?php if(isset($row['bodypaint_time']))echo $row['bodypaint_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="white" colspan="8" style="text-align:center;font-weight: bold;">Miscellaneous</td>
						</tr>
						<tr>
						   <td field="" class="yellowclr">Miscellaneous</td>
						   <td field="miscellaneous_quantity" class="yellowclr"><?php if(isset($row['miscellaneous_quantity']))echo $row['miscellaneous_quantity'];?></td>
						   <td field="miscellaneous_unit" class="light_blueclr">Hours</td>
						   <td field="miscellaneous_coats" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous_coats']))echo $row['miscellaneous_coats'];?></td>
						   <td field="miscellaneous_finish" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous_finish']))echo $row['miscellaneous_finish'];?></td>
						   <td field="miscellaneous_rates" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous_rates']))echo $row['miscellaneous_rates'];?></td>
						   <td field="miscellaneous_gals" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous_gals']))echo $row['miscellaneous_gals'];?></td>
						   <td field="miscellaneous_time" class="light_blueclr"><?php if(isset($row['miscellaneous_time']))echo $row['miscellaneous_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="yellowclr">Miscellaneous</td>
						   <td field="miscellaneous1_quantity" class="yellowclr"><?php if(isset($row['miscellaneous1_quantity']))echo $row['miscellaneous1_quantity'];?></td>
						   <td field="miscellaneous1_unit" class="light_blueclr">Hours</td>
						   <td field="miscellaneous1_coats" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous1_coats']))echo $row['miscellaneous1_coats'];?></td>
						   <td field="miscellaneous1_finish" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous1_finish']))echo $row['miscellaneous1_finish'];?></td>
						   <td field="miscellaneous1_rates" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous1_rates']))echo $row['miscellaneous1_rates'];?></td>
						   <td field="miscellaneous1_gals" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous1_gals']))echo $row['miscellaneous1_gals'];?></td>
						   <td field="miscellaneous1_time" class="light_blueclr"><?php if(isset($row['miscellaneous1_time']))echo $row['miscellaneous1_time'];?></td>
						</tr>
						<tr>
						   <td field="" class="yellowclr">Miscellaneous</td>
						   <td field="miscellaneous2_quantity" class="yellowclr"><?php if(isset($row['miscellaneous2_quantity']))echo $row['miscellaneous2_quantity'];?></td>
						   <td field="miscellaneous2_unit" class="light_blueclr">Hours</td>
						   <td field="miscellaneous2_coats" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous2_coats']))echo $row['miscellaneous2_coats'];?></td>
						   <td field="miscellaneous2_finish" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous2_finish']))echo $row['miscellaneous2_finish'];?></td>
						   <td field="miscellaneous2_rates" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous2_rates']))echo $row['miscellaneous2_rates'];?></td>
						   <td field="miscellaneous2_gals" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous2_gals']))echo $row['miscellaneous2_gals'];?></td>
						   <td field="miscellaneous2_time" class="light_blueclr"><?php if(isset($row['miscellaneous2_time']))echo $row['miscellaneous2_time'];?></td>
						</tr>
					</tbody>
			</table>
			<div class="input-field col s12" style="padding: 0px; text-align:center;">
				<i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#00695C; display:inline-block; float:none;">
					<input id="submit" class="waves-button-input" type="button" onclick="form_externalestimate()" value="<?php echo $button; ?>" name="submit">
				</i>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<div id="modal1" class="modal" style="">
	<form id="roomtypeform" name="roomtypeform" method="post">
		<div class="modal-content">
			<div class="col s3 m3 input-field">
				<input id="name" class="placecolor" type="text" autocomplete="off" name="name" placeholder="Room Type"> 
				<label class="active" for="length">Room Type</label>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="waves-effect waves-red btn-flat modal-action modal-close">Cancel</a>
			<input id="submit" class="z-depth-1 waves-effect btn secondary-content strong" onclick="" name="submit" value="submit" type="submit">
		</div>
	</form>
</div>
<script>
$('#mainTable').editableTableWidget({disableClass: "edit-disabled"});
$(function(){
 $('#extest').addClass('active');
 
 
var vRules = {
	name:{required:true}
};
var vMessages = {
	name:{required:"Please enter space type"}
};

$("#roomtypeform").validate({ 
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?= SITE_ROOT; ?>/project/addspacetype', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['success'])
				{		
					window.location.href="<?php echo SITE_ROOT;?>/project/externalestimate?project_id=<?php echo $_REQUEST['project_id']; ?>";
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
 $("#headingSearchtitle").html("Exterior Estimate");
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
   $("#mainTable").fixMe();
   $("#exteriorli").addClass("active");
   $("#exteriorlidiv").show();
});
</script>