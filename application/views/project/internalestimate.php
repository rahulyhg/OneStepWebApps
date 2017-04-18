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
$button = "Create";
if(isset($_REQUEST['id'])){
	$label = "Edit";
	$button = "Update";
} 

$db = new Db();
$row = array();
$table88 = "int_estimates";

if(isset($_REQUEST['id'])){
	$condition88 = "i.id = '".$_REQUEST['id']."' ";
	$main_table88 = array("$table88 i",array("i.*"));
	$join_tables88 = array(
		array('left','internal_estimate c','c.estimate_id = i.id', array('c.*'))
	);
	$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
	$row = mysql_fetch_array($rs1);
	//print_r($row);
}
?>
<?php
$val = array();
$val = $db->FetchToArray("default_production_rate","*","project_id =".$_REQUEST['project_id']); 
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
								 location.href = "<?= SITE_ROOT; ?>/project/internalestimate?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
							 else {
								 location.href = "<?= SITE_ROOT; ?>/project/dashboard?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
						});
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
	
	$('table#mainTable td').on('change', function(evt, newValue) {
		var classdiv = $(this).hasClass('furniture_coats');
		var rate_js = {};
		rate_js = <?php echo str_replace(")",'',str_replace("(",'',str_replace("-",'',str_replace("+",'',str_replace("'",'',str_replace(' ','',json_encode($production_rate)))))));?>;
		var rates = 0; 
		var tc = 0;
		var paint_rate = 0;
		var cost_per_gallon = 0;
		paint_rate = <?php $paint_rate = $db->FetchCellValue("Interior_Rate","interior","rate_type='paint' && project_id = '".$_REQUEST['project_id']."' "); echo $paint_rate; ?>;
		cost_per_gallon = <?php $cost_per_gallon = $db->FetchCellValue("Interior_Rate","interior","rate_type='Cost Per Gallon' && project_id = '".$_REQUEST['project_id']."' "); echo $cost_per_gallon; ?>;
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
			var sumtimewithout = 0;
			var maincost = 0;
			var faux_mural = 0;
			$('#mainTable tr td:nth-child(7)').each(function(){
				try{
					if(parseFloat($(this).html()) > 0)
					{
						sumgallon += parseFloat($(this).html());
					}
				}catch(err){
					/*sumgallon = sumgallon;*/
				}
			});
			$("#gallons").val((sumgallon).toFixed(1));
			
			$('#mainTable tr td:nth-child(8)').each(function(){
				try{
					if($(this).html() != "")
					{
						sumtime += parseFloat($(this).html());
					}
				}catch(err){
					sumtime = sumtime;
				}
			});
			
			$("#hours").val((sumtime).toFixed(1));
			if(classdiv)
				$('td.wallgals').change();
			
			$('#mainTable tr td:nth-child(8):not(.timecount1)').each(function(){
				try{
					if($(this).html() != "")
					{
						sumtimewithout += parseFloat($(this).html());
					}
				}catch(err){
					sumtimewithout = sumtimewithout;
				}
			});
			
			faux_mural = sumtime - sumtimewithout;
			maincost = sumtimewithout * paint_rate + faux_mural * paint_rate + sumgallon * cost_per_gallon;
			$("#cost").val((maincost).toFixed(1));
			/*alert(sumtimewithout+" --- "+sumtime+" --- "+faux_mural+" --- "+sumgallon+" --- "+paint_rate+" --- "+cost_per_gallon);*/
		
	});
});

function updateval(val)
{
	var t = val;
}
</script>
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
.select-wrapper span.caret{
	top:10px;
}
input, select {
    height: 3rem !important;
    margin-bottom: 10px !important;
}
</style>
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/mindmup-editabletable.js"></script>   
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/numeric-input-example.js"></script>
<div class="row">
<div class="col s12 m12">
	<ul id="task-card" class="collection with-header" style="margin: 0px; border: 0px none;">
		<li class="collection-header" style="background:transparent;padding:0;">
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 600px);">
				<a data-delay="50" data-tooltip="Next To Project" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/internal_project?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#b71c1c;" class="mdi-hardware-keyboard-arrow-right"></i>
				</a>
				<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#b71c1c;" class="mdi-content-clear"></i>
				</a>
				<a data-delay="50" data-tooltip="Previous To Notes" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/home/listinternalnotes?project_id=".$_REQUEST['project_id']; ?>">
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
				<a href="javascript:form_internalestimate()" style="float: right; margin-right: 20px;"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content strong" style="color:#B71C1C;background:white;"><?php echo $button; ?></span></h6></a>
			</div>
		</li>
	</ul>
</div>
<div class="col s12 m12 l12">
<div class="card-panel" style="margin-top: 0px;">
	<div id="row-grouping" class="section" style="padding-top:0;">
		<div class="row">
			<div class="col s12 m12">
				<div class="col s4 m4 input-field">
					<select class="" name="space_type" id="space_type" onchange = "updateval(this.val)">
						<option value="">Space Type</option>
						<?php 
							$cpl_status="";
							$selected = "";
							if(isset($row['SpaceType']) && $row['SpaceType'] != "")
							{
								$selected = $row['SpaceType'];
							}
							echo $db->CreateOptions("html", "room_types", array("id","name"),$selected,array("name"=>'asc'),"");
						?>
					</select>
					<input type="hidden" name="SpaceType" id="SpaceType">
				</div>
				<div class="col s2 m2 input-field">
					<a class="modal-trigger" style="color: rgb(51, 51, 51); margin-top: 15px;float:left;" href="#modal1"><span class="btn-floating btn" style="background: rgb(66, 133, 244) none repeat scroll 0% 0%; height: 20px; width: 20px; margin-right: 10px;"><i class="mdi-content-add" style="float: left; font-size: 16px; line-height: 20px ! important;"></i></span>Add
					</a>
				</div>
				<div class="col s2 m2 input-field">
					<input id="length" class="validate calculation placecolor" type="text" value="<?php if(isset($row['Length']))echo $row['Length'];?>" autocomplete="off" name="length" placeholder="Length"> 
					<label class="active" for="length">Length</label>
				</div>
				<div class="col s2 m2 input-field">
					<input id="width" class="validate calculation placecolor" type="text" value="<?php if(isset($row['Width']))echo $row['Width'];?>" autocomplete="off" name="width" placeholder="Width">
					<label class="active" for="width">Width</label>
				</div>
				<div class="col s2 m2 input-field">
					<input id="height" class="validate calculation placecolor" type="text" value="<?php if(isset($row['Height']))echo $row['Height'];?>" autocomplete="off" name="height" placeholder="Height">
					<label class="active" for="height">Height</label>
				</div>
			</div>
			<div class="col s12 m12">
				
			</div>
			<div class="col s3 m6">
				<div class="col s12 m12" style="text-align:center;">
					<h6>Dimensions</h6>
				</div> 
				<div class="col s4 m4 input-field">
					<input id="lnft" class="validate greyclr placecolor" type="text" value="<?php if(isset($row['LN_FT']))echo $row['LN_FT'];?>" autocomplete="off" readonly name="lnft" placeholder="LN.FT">
					 <label class="active" for="lnft">LN.FT</label> 
				</div>
				<div class="col s4 m4 input-field">
					<input id="wft" class="validate greyclr placecolor" type="text" value="<?php if(isset($row['W_FT']))echo $row['W_FT'];?>" autocomplete="off" readonly name="wft" placeholder="W.FT">
					 <label class="active" for="wft">W.FT</label> 
				</div>
				<div class="col s4 m4 input-field">
					<input id="cft" class="validate greyclr placecolor" type="text" value="<?php if(isset($row['C_FT']))echo $row['C_FT'];?>" autocomplete="off" readonly name="cft" placeholder="C.FT">
					 <label class="active" for="cft">C.FT</label> 
				</div>
			</div>
			<div class="col s3 m6">
				<div class="col s12 m12" style="text-align:center;">
					<h6>Job Total</h6>
				</div>
				<div class="col s4 m4 input-field">
					<input id="gallons" class="validate greyclr placecolor" type="text" value="<?php if(isset($row['Gallons']))echo $row['Gallons'];?>" autocomplete="off" readonly name="gallons"  placeholder="Gallons">
					<label class="active" for="gallons">Gallons</label>
				</div>
				<div class="col s4 m4 input-field">
					<input id="hours" class="validate greyclr placecolor" type="text" value="<?php if(isset($row['Hours']))echo $row['Hours'];?>" autocomplete="off" readonly name="hours"  placeholder="Hours">
					<label class="active" for="hours">Hours</label>
				</div>
				<div class="col s4 m4 input-field">
					<input id="cost" class="validate greyclr placecolor" type="text" value="<?php if(isset($row['Cost']))echo $row['Cost'];?>" autocomplete="off" readonly name="cost"  placeholder="Cost">
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
								<td field="" class="light_blueclr">Furniture Treatment</td>
								<td field="furniture_quantity" class="yellowclr"><?php if(isset($row['furniture_quantity']))echo $row['furniture_quantity'];?></td>
								<td field="furniture_unit" class="light_blueclr">Hours</td>
								<td field="furniture_coats" class="greyclr edit-disabled furniture_coats"><?php if(isset($row['furniture_coats']))echo $row['furniture_coats'];?></td>
								<td field="furniture_finish" class="greyclr edit-disabled"><?php if(isset($row['furniture_finish']))echo $row['furniture_finish'];?></td>
								<td field="furniture_rates" class="greyclr edit-disabled"><?php if(isset($row['furniture_rates']))echo $row['furniture_rates'];?></td>
								<td field="furniture_gals" class="greyclr edit-disabled"><?php if(isset($row['furniture_gals']))echo $row['furniture_gals'];?></td>
								<td field="furniture_time" class="light_blueclr timecount"><?php if(isset($row['furniture_time']))echo $row['furniture_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Window Treatment</td>
								<td field="window_quantity" class="yellowclr"><?php if(isset($row['window_quantity']))echo $row['window_quantity'];?></td>
								<td field="window_unit" class="light_blueclr">Hours</td>
								<td field="window_coats" class="greyclr edit-disabled"><?php if(isset($row['window_coats']))echo $row['window_coats'];?></td>
								<td field="window_finish" class="greyclr edit-disabled"><?php if(isset($row['window_finish']))echo $row['window_finish'];?></td>
								<td field="window_rates" class="greyclr edit-disabled"><?php if(isset($row['window_rates']))echo $row['window_rates'];?></td>
								<td field="window_gals" class="greyclr edit-disabled"><?php if(isset($row['window_gals']))echo $row['window_gals'];?></td>
								<td field="window_time" class="light_blueclr timecount"><?php if(isset($row['window_time']))echo $row['window_time'];?></td> 
							</tr>
							<tr>
								<td field="" class="light_blueclr">Mask & Cover</td>
								<td field="maskcover_quantity" class="yellowclr"><?php if(isset($row['maskcover_quantity']))echo $row['maskcover_quantity'];?></td>
								<td field="maskcover_unit" class="light_blueclr">Hours</td>
								<td field="maskcover_coats" class="greyclr edit-disabled"><?php if(isset($row['maskcover_coats']))echo $row['maskcover_coats'];?></td>
								<td field="maskcover_finish" class="greyclr edit-disabled"><?php if(isset($row['maskcover_finish']))echo $row['maskcover_finish'];?></td>
								<td field="maskcover_rates" class="greyclr edit-disabled"><?php if(isset($row['maskcover_rates']))echo $row['maskcover_rates'];?></td>
								<td field="maskcover_gals" class="greyclr edit-disabled"><?php if(isset($row['maskcover_gals']))echo $row['maskcover_gals'];?></td>
								<td field="maskcover_time" class="light_blueclr timecount"><?php if(isset($row['maskcover_time']))echo $row['maskcover_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Wallpaper Removal</td>
								<td field="wallpaper_removal_quantity" class="greyclr edit-disabled wftq"><?php if(isset($row['wallpaper_removal_quantity']))echo $row['wallpaper_removal_quantity'];?></td>
								<td field="wallpaper_removal_unit" class="light_blueclr">Sq. Ft.</td>
								<td field="wallpaper_removal_coats" class="yellowclr"><?php if(isset($row['wallpaper_removal_coats']))echo $row['wallpaper_removal_coats'];?></td>
								<td field="wallpaper_removal_finish" class="greyclr edit-disabled"><?php if(isset($row['wallpaper_removal_finish']))echo $row['wallpaper_removal_finish'];?></td>
								<td field="wallpaper_removal_rates" class="greyclr edit-disabled"><?php if(isset($row['wallpaper_removal_rates']))echo $row['wallpaper_removal_rates'];?></td>
								<td field="wallpaper_removal_gals" class="white wallgals"><?php if(isset($row['wallpaper_removal_gals']))echo $row['wallpaper_removal_gals'];?></td>
								<td field="wallpaper_removal_time" class="light_blueclr timecount"><?php if(isset($row['wallpaper_removal_time']))echo $row['wallpaper_removal_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">R&R Hardware & Lighting</td>
								<td field="rrhardware_quantity" class="yellowclr"><?php if(isset($row['rrhardware_quantity']))echo $row['rrhardware_quantity'];?></td>
								<td field="rrhardware_unit" class="light_blueclr">Hours</td>
								<td field="rrhardware_coats" class="greyclr edit-disabled"><?php if(isset($row['rrhardware_coats']))echo $row['rrhardware_coats'];?></td>
								<td field="rrhardware_finish" class="greyclr edit-disabled"><?php if(isset($row['rrhardware_finish']))echo $row['rrhardware_finish'];?></td>
								<td field="rrhardware_rates" class="greyclr edit-disabled"><?php if(isset($row['rrhardware_rates']))echo $row['rrhardware_rates'];?></td>
								<td field="rrhardware_gals" class="greyclr edit-disabled"><?php if(isset($row['rrhardware_gals']))echo $row['rrhardware_gals'];?></td>
								<td field="rrhardware_time" class="light_blueclr timecount"><?php if(isset($row['rrhardware_time']))echo $row['rrhardware_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Prep Woodwork</td>
								<td field="prepwoodwork_quantity" class="yellowclr"><?php if(isset($row['prepwoodwork_quantity']))echo $row['prepwoodwork_quantity'];?></td>
								<td field="prepwoodwork_unit" class="light_blueclr">Hours</td>
								<td field="prepwoodwork_coats" class="greyclr edit-disabled"><?php if(isset($row['prepwoodwork_coats']))echo $row['prepwoodwork_coats'];?></td>
								<td field="prepwoodwork_finish" class="greyclr edit-disabled"><?php if(isset($row['prepwoodwork_finish']))echo $row['prepwoodwork_finish'];?></td>
								<td field="prepwoodwork_rates" class="greyclr edit-disabled"><?php if(isset($row['prepwoodwork_rates']))echo $row['prepwoodwork_rates'];?></td>
								<td field="prepwoodwork_gals" class="greyclr edit-disabled"><?php if(isset($row['prepwoodwork_gals']))echo $row['prepwoodwork_gals'];?></td>
								<td field="prepwoodwork_time" class="light_blueclr timecount"><?php if(isset($row['prepwoodwork_time']))echo $row['prepwoodwork_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Patch & Texture</td>
								<td field="patchtexture_quantity" class="yellowclr"><?php if(isset($row['patchtexture_quantity']))echo $row['patchtexture_quantity'];?></td>
								<td field="patchtexture_unit" class="light_blueclr">Hours</td>
								<td field="patchtexture_coats" class="greyclr edit-disabled"><?php if(isset($row['patchtexture_coats']))echo $row['patchtexture_coats'];?></td>
								<td field="patchtexture_finish" class="greyclr edit-disabled"><?php if(isset($row['patchtexture_finish']))echo $row['patchtexture_finish'];?></td>
								<td field="patchtexture_rates" class="greyclr edit-disabled"><?php if(isset($row['patchtexture_rates']))echo $row['patchtexture_rates'];?></td>
								<td field="patchtexture_gals" class="greyclr edit-disabled"><?php if(isset($row['patchtexture_gals']))echo $row['patchtexture_gals'];?></td>
								<td field="patchtexture_time" class="light_blueclr timecount"><?php if(isset($row['patchtexture_time']))echo $row['patchtexture_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Skim Coat</td>
								<td field="skimcoat_quantity" class="greyclr edit-disabled wftq"><?php if(isset($row['skimcoat_quantity']))echo $row['skimcoat_quantity'];?></td>
								<td field="skimcoat_unit" class="light_blueclr">Sq. Ft.</td>
								<td field="skimcoat_coats" class="yellowclr"><?php if(isset($row['skimcoat_coats']))echo $row['skimcoat_coats'];?></td>
								<td field="skimcoat_finish" class="greyclr edit-disabled"><?php if(isset($row['skimcoat_finish']))echo $row['skimcoat_finish'];?></td>
								<td field="skimcoat_rates" class="greyclr edit-disabled"><?php if(isset($row['skimcoat_rates']))echo $row['skimcoat_rates'];?></td>
								<td field="skimcoat_gals" class="white"><?php if(isset($row['skimcoat_gals']))echo $row['skimcoat_gals'];?></td>
								<td field="skimcoat_time" class="light_blueclr timecount"><?php if(isset($row['skimcoat_time']))echo $row['skimcoat_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Pole Sand Walls</td>
								<td field="polesand_quantity" class="yellowclr"><?php if(isset($row['polesand_quantity']))echo $row['polesand_quantity'];?></td>
								<td field="polesand_unit" class="light_blueclr">Sq. Ft.</td>
								<td field="polesand_coats" class="greyclr edit-disabled"><?php if(isset($row['polesand_coats']))echo $row['polesand_coats'];?></td>
								<td field="polesand_finish" class="greyclr edit-disabled"><?php if(isset($row['polesand_finish']))echo $row['polesand_finish'];?></td>
								<td field="polesand_rates" class="greyclr edit-disabled"><?php if(isset($row['polesand_rates']))echo $row['polesand_rates'];?></td>
								<td field="polesand_gals" class="greyclr edit-disabled"><?php if(isset($row['polesand_gals']))echo $row['polesand_gals'];?></td>
								<td field="polesand_time" class="light_blueclr timecount"><?php if(isset($row['polesand_time']))echo $row['polesand_time'];?></td>
							</tr>
							
							<tr>
								<td field="" class="dark_yellowclr">Walls: Prime</td>
								<td field="wprime_quantity" class="greyclr edit-disabled wftq"><?php if(isset($row['wprime_quantity']))echo $row['wprime_quantity'];?></td>
								<td field="wprime_unit" class="light_blueclr">Sq. Ft.</td>
								<td field="wprime_coats" class="yellowclr"><?php if(isset($row['wprime_coats']))echo $row['wprime_coats'];?></td>
								<td field="wprime_finish" class="greyclr edit-disabled"><?php if(isset($row['wprime_finish']))echo $row['wprime_finish'];?></td> 
								<td field="wprime_rates" class="greyclr edit-disabled"><?php if(isset($row['wprime_rates']))echo $row['wprime_rates'];?></td>
								<td field="wprime_gals" class="white"><?php if(isset($row['wprime_gals']))echo $row['wprime_gals'];?></td>
								<td field="wprime_time" class="light_blueclr timecount"><?php if(isset($row['wprime_time']))echo $row['wprime_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_yellowclr">Walls: Paint 0 to 9</td>
								<td field="wpaint09_quantity" class="greyclr edit-disabled wftq"><?php if(isset($row['wpaint09_quantity']))echo $row['wpaint09_quantity'];?></td>
								<td field="wpaint09_unit" class="light_blueclr">Sq. Ft.</td>
								<td field="wpaint09_coats" class="yellowclr"><?php if(isset($row['wpaint09_coats']))echo $row['wpaint09_coats'];?></td>
								<td field="wpaint09_finish" class="yellowclr"><?php if(isset($row['wpaint09_finish']))echo $row['wpaint09_finish'];?></td>
								<td field="wpaint09_rates" class="greyclr edit-disabled"><?php if(isset($row['wpaint09_rates']))echo $row['wpaint09_rates'];?></td>
								<td field="wpaint09_gals" class="white"><?php if(isset($row['wpaint09_gals']))echo $row['wpaint09_gals'];?></td>
								<td field="wpaint09_time" class="light_blueclr timecount"><?php if(isset($row['wpaint09_time']))echo $row['wpaint09_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_yellowclr">Walls: Paint 9 or more</td>
								<td field="wpaint9_quantity" class="greyclr edit-disabled wftq"><?php if(isset($row['wpaint9_quantity']))echo $row['wpaint9_quantity'];?></td>
								<td field="wpaint9_unit" class="light_blueclr">Sq. Ft.</td>
								<td field="wpaint9_coats" class="yellowclr"><?php if(isset($row['wpaint9_coats']))echo $row['wpaint9_coats'];?></td>
								<td field="wpaint9_finish" class="yellowclr"><?php if(isset($row['wpaint9_finish']))echo $row['wpaint9_finish'];?></td>
								<td field="wpaint9_rates" class="greyclr edit-disabled"><?php if(isset($row['wpaint9_rates']))echo $row['wpaint9_rates'];?></td>
								<td field="wpaint9_gals" class="white"><?php if(isset($row['wpaint9_gals']))echo $row['wpaint9_gals'];?></td>
								<td field="wpaint9_time" class="light_blueclr timecount"><?php if(isset($row['wpaint9_time']))echo $row['wpaint9_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_yellowclr">Ceilings: Prime</td>
								<td field="cprime_quantity" class="greyclr edit-disabled cftq"><?php if(isset($row['cprime_quantity']))echo $row['cprime_quantity'];?></td>
								<td field="cprime_unit" class="light_blueclr">Sq. Ft.</td>
								<td field="cprime_coats" class="yellowclr"><?php if(isset($row['cprime_coats']))echo $row['cprime_coats'];?></td>
								<td field="cprime_finish" class="greyclr edit-disabled"><?php if(isset($row['cprime_finish']))echo $row['cprime_finish'];?></td>
								<td field="cprime_rates" class="greyclr edit-disabled"><?php if(isset($row['cprime_rates']))echo $row['cprime_rates'];?></td>
								<td field="cprime_gals" class="white"><?php if(isset($row['cprime_gals']))echo $row['cprime_gals'];?></td>
								<td field="cprime_time" class="light_blueclr timecount"><?php if(isset($row['cprime_time']))echo $row['cprime_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_yellowclr">Ceilings: Paint</td>
								<td field="cpaint_quantity" class="greyclr edit-disabled cftq"><?php if(isset($row['cpaint_quantity']))echo $row['cpaint_quantity'];?></td>
								<td field="cpaint_unit" class="light_blueclr">Sq. Ft.</td>
								<td field="cpaint_coats" class="yellowclr"><?php if(isset($row['cpaint_coats']))echo $row['cpaint_coats'];?></td>
								<td field="cpaint_finish" class="yellowclr"><?php if(isset($row['cpaint_finish']))echo $row['cpaint_finish'];?></td>
								<td field="cpaint_rates" class="greyclr edit-disabled"><?php if(isset($row['cpaint_rates']))echo $row['cpaint_rates'];?></td>
								<td field="cpaint_gals" class="white"><?php if(isset($row['cpaint_gals']))echo $row['cpaint_gals'];?></td>
								<td field="cpaint_time" class="light_blueclr timecount"><?php if(isset($row['cpaint_time']))echo $row['cpaint_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_yellowclr">Ceiling & Walls: +/- Time</td>
								<td field="cw_time_quantity" class="yellowclr"><?php if(isset($row['cw_time_quantity']))echo $row['cw_time_quantity'];?></td>
								<td field="cw_time_unit" class="light_blueclr">Hours</td>
								<td field="cw_time_coats" class="greyclr edit-disabled"><?php if(isset($row['cw_time_coats']))echo $row['cw_time_coats'];?></td>
								<td field="cw_time_finish" class="greyclr edit-disabled"><?php if(isset($row['cw_time_finish']))echo $row['cw_time_finish'];?></td>
								<td field="cw_time_rates" class="greyclr edit-disabled"><?php if(isset($row['cw_time_rates']))echo $row['cw_time_rates'];?></td>
								<td field="cw_time_gals" class="greyclr edit-disabled"><?php if(isset($row['cw_time_gals']))echo $row['cw_time_gals'];?></td>
								<td field="cw_time_time" class="light_blueclr timecount"><?php if(isset($row['cw_time_time']))echo $row['cw_time_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_orangeclr">Doors: Flat</td>
								<td field="dflat_quantity" class="yellowclr"><?php if(isset($row['dflat_quantity']))echo $row['dflat_quantity'];?></td>
								<td field="dflat_unit" class="light_blueclr">Each</td>
								<td field="dflat_coats" class="yellowclr"><?php if(isset($row['dflat_coats']))echo $row['dflat_coats'];?></td>
								<td field="dflat_finish" class="yellowclr"><?php if(isset($row['dflat_finish']))echo $row['dflat_finish'];?></td>
								<td field="dflat_rates" class="greyclr edit-disabled"><?php if(isset($row['dflat_rates']))echo $row['dflat_rates'];?></td>
								<td field="dflat_gals" class="white"><?php if(isset($row['dflat_gals']))echo $row['dflat_gals'];?></td>
								<td field="dflat_time" class="light_blueclr timecount"><?php if(isset($row['dflat_time']))echo $row['dflat_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_orangeclr">Doors: Paneled</td>
								<td field="dpaneled_quantity" class="yellowclr"><?php if(isset($row['dpaneled_quantity']))echo $row['dpaneled_quantity'];?></td>
								<td field="dpaneled_unit" class="light_blueclr">Each</td>
								<td field="dpaneled_coats" class="yellowclr"><?php if(isset($row['dpaneled_coats']))echo $row['dpaneled_coats'];?></td>
								<td field="dpaneled_finish" class="yellowclr"><?php if(isset($row['dpaneled_finish']))echo $row['dpaneled_finish'];?></td>
								<td field="dpaneled_rates" class="greyclr edit-disabled"><?php if(isset($row['dpaneled_rates']))echo $row['dpaneled_rates'];?></td>
								<td field="dpaneled_gals" class="white"><?php if(isset($row['dpaneled_gals']))echo $row['dpaneled_gals'];?></td>
								<td field="dpaneled_time" class="light_blueclr timecount"><?php if(isset($row['dpaneled_time']))echo $row['dpaneled_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_orangeclr">Doors: French</td>
								<td field="dfrench_quantity" class="yellowclr"><?php if(isset($row['dfrench_quantity']))echo $row['dfrench_quantity'];?></td>
								<td field="dfrench_unit" class="light_blueclr">Each</td>
								<td field="dfrench_coats" class="yellowclr"><?php if(isset($row['dfrench_coats']))echo $row['dfrench_coats'];?></td>
								<td field="dfrench_finish" class="yellowclr"><?php if(isset($row['dfrench_finish']))echo $row['dfrench_finish'];?></td>
								<td field="dfrench_rates" class="greyclr edit-disabled"><?php if(isset($row['dfrench_rates']))echo $row['dfrench_rates'];?></td>
								<td field="dfrench_gals" class="white"><?php if(isset($row['dfrench_gals']))echo $row['dfrench_gals'];?></td>
								<td field="dfrench_time" class="light_blueclr timecount"><?php if(isset($row['dfrench_time']))echo $row['dfrench_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_orangeclr">Doors: Frames</td>
								<td field="dframes_quantity" class="yellowclr"><?php if(isset($row['dframes_quantity']))echo $row['dframes_quantity'];?></td>
								<td field="dframes_unit" class="light_blueclr">Each</td>
								<td field="dframes_coats" class="yellowclr"><?php if(isset($row['dframes_coats']))echo $row['dframes_coats'];?></td>
								<td field="dframes_finish" class="yellowclr"><?php if(isset($row['dframes_finish']))echo $row['dframes_finish'];?></td>
								<td field="dframes_rates" class="greyclr edit-disabled"><?php if(isset($row['dframes_rates']))echo $row['dframes_rates'];?></td>
								<td field="dframes_gals" class="white"><?php if(isset($row['dframes_gals']))echo $row['dframes_gals'];?></td>
								<td field="dframes_time" class="light_blueclr timecount"><?php if(isset($row['dframes_time']))echo $row['dframes_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_orangeclr">Doors: +/- Time</td>
								<td field="dtime_quantity" class="yellowclr"><?php if(isset($row['dtime_quantity']))echo $row['dtime_quantity'];?></td>
								<td field="dtime_unit" class="light_blueclr">Hours</td>
								<td field="dtime_coats" class="greyclr edit-disabled"><?php if(isset($row['dtime_coats']))echo $row['dtime_coats'];?></td>
								<td field="dtime_finish" class="greyclr edit-disabled"><?php if(isset($row['dtime_finish']))echo $row['dtime_finish'];?></td>
								<td field="dtime_rates" class="greyclr edit-disabled"><?php if(isset($row['dtime_rates']))echo $row['dtime_rates'];?></td>
								<td field="dtime_gals" class="greyclr edit-disabled"><?php if(isset($row['dtime_gals']))echo $row['dtime_gals'];?></td>
								<td field="dtime_time" class="light_blueclr timecount"><?php if(isset($row['']))echo $row['dtime_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_redclr">Windows: Casement</td>
								<td field="wcasement_quantity" class="yellowclr"><?php if(isset($row['wcasement_quantity']))echo $row['wcasement_quantity'];?></td>
								<td field="wcasement_unit" class="light_blueclr">Each</td>
								<td field="wcasement_coats" class="yellowclr"><?php if(isset($row['wcasement_coats']))echo $row['wcasement_coats'];?></td>
								<td field="wcasement_finish" class="yellowclr"><?php if(isset($row['wcasement_finish']))echo $row['wcasement_finish'];?></td>
								<td field="wcasement_rates" class="greyclr edit-disabled"><?php if(isset($row['wcasement_rates']))echo $row['wcasement_rates'];?></td>
								<td field="wcasement_gals" class="white"><?php if(isset($row['wcasement_gals']))echo $row['wcasement_gals'];?></td>
								<td field="wcasement_time" class="light_blueclr timecount"><?php if(isset($row['wcasement_time']))echo $row['wcasement_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_redclr">Windows: 1/1</td>
								<td field="w1_1_quantity" class="yellowclr"><?php if(isset($row['w1_1_quantity']))echo $row['w1_1_quantity'];?></td>
								<td field="w1_1_unit" class="light_blueclr">Each</td>
								<td field="w1_1_coats" class="yellowclr"><?php if(isset($row['w1_1_coats']))echo $row['w1_1_coats'];?></td>
								<td field="w1_1_finish" class="yellowclr"><?php if(isset($row['w1_1_finish']))echo $row['w1_1_finish'];?></td>
								<td field="w1_1_rates" class="greyclr edit-disabled"><?php if(isset($row['w1_1_rates']))echo $row['w1_1_rates'];?></td>
								<td field="w1_1_gals" class="white"><?php if(isset($row['w1_1_gals']))echo $row['w1_1_gals'];?></td>
								<td field="w1_1_time" class="light_blueclr timecount"><?php if(isset($row['w1_1_time']))echo $row['w1_1_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_redclr">Windows: 3 to 7 Panel</td>
								<td field="w3_7_panel_quantity" class="yellowclr"><?php if(isset($row['w3_7_panel_quantity']))echo $row['w3_7_panel_quantity'];?></td>
								<td field="w3_7_panel_unit" class="light_blueclr">Each</td>
								<td field="w3_7_panel_coats" class="yellowclr"><?php if(isset($row['w3_7_panel_coats']))echo $row['w3_7_panel_coats'];?></td>
								<td field="w3_7_panel_finish" class="yellowclr"><?php if(isset($row['w3_7_panel_finish']))echo $row['w3_7_panel_finish'];?></td>
								<td field="w3_7_panel_rates" class="greyclr edit-disabled"><?php if(isset($row['w3_7_panel_rates']))echo $row['w3_7_panel_rates'];?></td>
								<td field="w3_7_panel_gals" class="white"><?php if(isset($row['w3_7_panel_gals']))echo $row['w3_7_panel_gals'];?></td>
								<td field="w3_7_panel_time" class="light_blueclr timecount"><?php if(isset($row['w3_7_panel_time']))echo $row['w3_7_panel_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_redclr">Windows: 8 to 16 Panel</td>
								<td field="w8_16_panel_quantity" class="yellowclr"><?php if(isset($row['w8_16_panel_quantity']))echo $row['w8_16_panel_quantity'];?></td>
								<td field="w8_16_panel_unit" class="light_blueclr">Each</td>
								<td field="w8_16_panel_coats" class="yellowclr"><?php if(isset($row['w8_16_panel_coats']))echo $row['w8_16_panel_coats'];?></td>
								<td field="w8_16_panel_finish" class="yellowclr"><?php if(isset($row['w8_16_panel_finish']))echo $row['w8_16_panel_finish'];?></td>
								<td field="w8_16_panel_rates" class="greyclr edit-disabled"><?php if(isset($row['w8_16_panel_rates']))echo $row['w8_16_panel_rates'];?></td>
								<td field="w8_16_panel_gals" class="white"><?php if(isset($row['w8_16_panel_gals']))echo $row['w8_16_panel_gals'];?></td>
								<td field="w8_16_panel_time" class="light_blueclr timecount"><?php if(isset($row['w8_16_panel_time']))echo $row['w8_16_panel_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_redclr">Windows: 16 or more Panel</td>
								<td field="w16_panel_quantity" class="yellowclr"><?php if(isset($row['w16_panel_quantity']))echo $row['w16_panel_quantity'];?></td>
								<td field="w16_panel_unit" class="light_blueclr">Each</td>
								<td field="w16_panel_coats" class="yellowclr"><?php if(isset($row['w16_panel_coats']))echo $row['w16_panel_coats'];?></td>
								<td field="w16_panel_finish" class="yellowclr"><?php if(isset($row['w16_panel_finish']))echo $row['w16_panel_finish'];?></td>
								<td field="w16_panel_rates" class="greyclr edit-disabled"><?php if(isset($row['w16_panel_rates']))echo $row['w16_panel_rates'];?></td>
								<td field="w16_panel_gals" class="white"><?php if(isset($row['w16_panel_gals']))echo $row['w16_panel_gals'];?></td>
								<td field="w16_panel_time" class="light_blueclr timecount"><?php if(isset($row['w16_panel_time']))echo $row['w16_panel_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_redclr">Windows: +/- Time</td>
								<td field="wtime_quantity" class="yellowclr"><?php if(isset($row['wtime_quantity']))echo $row['wtime_quantity'];?></td>
								<td field="wtime_unit" class="light_blueclr">Hours</td>
								<td field="wtime_coats" class="greyclr edit-disabled"><?php if(isset($row['wtime_coats']))echo $row['wtime_coats'];?></td>
								<td field="wtime_finish" class="greyclr edit-disabled"><?php if(isset($row['wtime_finish']))echo $row['wtime_finish'];?></td>
								<td field="wtime_rates" class="greyclr edit-disabled"><?php if(isset($row['wtime_rates']))echo $row['wtime_rates'];?></td>
								<td field="wtime_gals" class="greyclr edit-disabled"><?php if(isset($row['wtime_gals']))echo $row['wtime_gals'];?></td>
								<td field="wtime_time" class="light_blueclr timecount"><?php if(isset($row['wtime_time']))echo $row['wtime_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Baseboards</td>
								<td field="baseboards_quantity" class="greyclr edit-disabled lnftq"><?php if(isset($row['baseboards_quantity']))echo $row['baseboards_quantity'];?></td>
								<td field="baseboards_unit" class="light_blueclr">Ln. Ft.</td>
								<td field="baseboards_coats" class="yellowclr"><?php if(isset($row['baseboards_coats']))echo $row['baseboards_coats'];?></td>
								<td field="baseboards_finish" class="yellowclr"><?php if(isset($row['baseboards_finish']))echo $row['baseboards_finish'];?></td>
								<td field="baseboards_rates" class="greyclr edit-disabled"><?php if(isset($row['baseboards_rates']))echo $row['baseboards_rates'];?></td>
								<td field="baseboards_gals" class="white"><?php if(isset($row['baseboards_gals']))echo $row['baseboards_gals'];?></td>
								<td field="baseboards_time" class="light_blueclr timecount"><?php if(isset($row['baseboards_time']))echo $row['baseboards_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Baseboards: +/- Time</td>
								<td field="baseboardstime_quantity" class="yellowclr"><?php if(isset($row['baseboardstime_quantity']))echo $row['baseboardstime_quantity'];?></td>
								<td field="baseboardstime_unit" class="light_blueclr">Hours</td>
								<td field="baseboardstime_coats" class="greyclr edit-disabled"><?php if(isset($row['baseboardstime_coats']))echo $row['baseboardstime_coats'];?></td>
								<td field="baseboardstime_finish" class="greyclr edit-disabled"><?php if(isset($row['baseboardstime_finish']))echo $row['baseboardstime_finish'];?></td>
								<td field="baseboardstime_rates" class="greyclr edit-disabled"><?php if(isset($row['baseboardstime_rates']))echo $row['baseboardstime_rates'];?></td>
								<td field="baseboardstime_gals" class="greyclr edit-disabled"><?php if(isset($row['baseboardstime_gals']))echo $row['baseboardstime_gals'];?></td>
								<td field="baseboardstime_time" class="light_blueclr timecount"><?php if(isset($row['baseboardstime_time']))echo $row['baseboardstime_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Chair Rail</td>
								<td field="chairrail_quantity" class="greyclr edit-disabled lnftq"><?php if(isset($row['chairrail_quantity']))echo $row['chairrail_quantity'];?></td>
								<td field="chairrail_unit" class="light_blueclr">Ln. Ft.</td>
								<td field="chairrail_coats" class="yellowclr"><?php if(isset($row['chairrail_coats']))echo $row['chairrail_coats'];?></td>
								<td field="chairrail_finish" class="yellowclr"><?php if(isset($row['chairrail_finish']))echo $row['chairrail_finish'];?></td>
								<td field="chairrail_rates" class="greyclr edit-disabled"><?php if(isset($row['chairrail_rates']))echo $row['chairrail_rates'];?></td>
								<td field="chairrail_gals" class="white"><?php if(isset($row['chairrail_gals']))echo $row['chairrail_gals'];?></td>
								<td field="chairrail_time" class="light_blueclr timecount"><?php if(isset($row['chairrail_time']))echo $row['chairrail_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Chair Rail: +/- Time</td>
								<td field="chairrail_time_quantity" class="yellowclr"><?php if(isset($row['chairrail_time_quantity']))echo $row['chairrail_time_quantity'];?></td>
								<td field="chairrail_time_unit" class="light_blueclr">Hours</td>
								<td field="chairrail_time_coats" class="greyclr edit-disabled"><?php if(isset($row['chairrail_time_coats']))echo $row['chairrail_time_coats'];?></td>
								<td field="chairrail_time_finish" class="greyclr edit-disabled"><?php if(isset($row['chairrail_time_finish']))echo $row['chairrail_time_finish'];?></td>
								<td field="chairrail_time_rates" class="greyclr edit-disabled"><?php if(isset($row['chairrail_time_rates']))echo $row['chairrail_time_rates'];?></td>
								<td field="chairrail_time_gals" class="greyclr edit-disabled"><?php if(isset($row['chairrail_time_gals']))echo $row['chairrail_time_gals'];?></td>
								<td field="chairrail_time_time" class="light_blueclr timecount"><?php if(isset($row['chairrail_time_time']))echo $row['chairrail_time_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Crown Molding</td>
								<td field="crownmolding_quantity" class="greyclr edit-disabled lnftq"><?php if(isset($row['crownmolding_quantity']))echo $row['crownmolding_quantity'];?></td>
								<td field="crownmolding_unit" class="light_blueclr">Ln. Ft.</td>
								<td field="crownmolding_coats" class="yellowclr"><?php if(isset($row['crownmolding_coats']))echo $row['crownmolding_coats'];?></td>
								<td field="crownmolding_finish" class="yellowclr"><?php if(isset($row['crownmolding_finish']))echo $row['crownmolding_finish'];?></td>
								<td field="crownmolding_rates" class="greyclr edit-disabled"><?php if(isset($row['crownmolding_rates']))echo $row['crownmolding_rates'];?></td>
								<td field="crownmolding_gals" class="white"><?php if(isset($row['crownmolding_gals']))echo $row['crownmolding_gals'];?></td>
								<td field="crownmolding_time" class="light_blueclr timecount"><?php if(isset($row['crownmolding_time']))echo $row['crownmolding_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Crown Molding: +/- Time</td>
								<td field="crownmolding_time_quantity" class="yellowclr"><?php if(isset($row['crownmolding_time_quantity']))echo $row['crownmolding_time_quantity'];?></td>
								<td field="crownmolding_time_unit" class="light_blueclr">Hours</td>
								<td field="crownmolding_time_coats" class="greyclr edit-disabled"><?php if(isset($row['crownmolding_time_coats']))echo $row['crownmolding_time_coats'];?></td>
								<td field="crownmolding_time_finish" class="greyclr edit-disabled"><?php if(isset($row['crownmolding_time_finish']))echo $row['crownmolding_time_finish'];?></td>
								<td field="crownmolding_time_rates" class="greyclr edit-disabled"><?php if(isset($row['crownmolding_time_rates']))echo $row['crownmolding_time_rates'];?></td>
								<td field="crownmolding_time_gals" class="greyclr edit-disabled"><?php if(isset($row['crownmolding_time_gals']))echo $row['crownmolding_time_gals'];?></td>
								<td field="crownmolding_time_time" class="light_blueclr timecount"><?php if(isset($row['crownmolding_time_time']))echo $row['crownmolding_time_time'];?></td>
							</tr>
							<tr>
								<td field="" class="dark_yellowclr">Closets</td>
								<td field="closets_quantity" class="yellowclr"><?php if(isset($row['closets_quantity']))echo $row['closets_quantity'];?></td>
								<td field="closets_unit" class="light_blueclr">Hours</td>
								<td field="closets_coats" class="yellowclr"><?php if(isset($row['closets_coats']))echo $row['closets_coats'];?></td>
								<td field="closets_finish" class="yellowclr"><?php if(isset($row['closets_finish']))echo $row['closets_finish'];?></td>
								<td field="closets_rates" class="greyclr edit-disabled"><?php if(isset($row['closets_rates']))echo $row['closets_rates'];?></td>
								<td field="closets_gals" class="greyclr edit-disabled"><?php if(isset($row['closets_gals']))echo $row['closets_gals'];?></td>
								<td field="closets_time" class="light_blueclr timecount"><?php if(isset($row['closets_time']))echo $row['closets_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_purpleclr">Cabinetry</td>
								<td field="cabinetry_quantity" class="yellowclr"><?php if(isset($row['cabinetry_quantity']))echo $row['cabinetry_quantity'];?></td>
								<td field="cabinetry_unit" class="light_blueclr">Hours</td>
								<td field="cabinetry_coats" class="yellowclr"><?php if(isset($row['cabinetry_coats']))echo $row['cabinetry_coats'];?></td>
								<td field="cabinetry_finish" class="yellowclr"><?php if(isset($row['cabinetry_finish']))echo $row['cabinetry_finish'];?></td>
								<td field="cabinetry_rates" class="greyclr edit-disabled"><?php if(isset($row['cabinetry_rates']))echo $row['cabinetry_rates'];?></td>
								<td field="cabinetry_gals" class="greyclr edit-disabled"><?php if(isset($row['cabinetry_gals']))echo $row['cabinetry_gals'];?></td>
								<td field="cabinetry_time" class="light_blueclr timecount"><?php if(isset($row['cabinetry_time']))echo $row['cabinetry_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Daily Setup/Breakdown</td>
								<td field="dailybreakdown_quantity" class="yellowclr"><?php if(isset($row['dailybreakdown_quantity']))echo $row['dailybreakdown_quantity'];?></td>
								<td field="dailybreakdown_unit" class="light_blueclr">Hours</td>
								<td field="dailybreakdown_coats" class="greyclr edit-disabled"><?php if(isset($row['dailybreakdown_coats']))echo $row['dailybreakdown_coats'];?></td>
								<td field="dailybreakdown_finish" class="greyclr edit-disabled"><?php if(isset($row['dailybreakdown_finish']))echo $row['dailybreakdown_finish'];?></td>
								<td field="dailybreakdown_rates" class="greyclr edit-disabled"><?php if(isset($row['dailybreakdown_rates']))echo $row['dailybreakdown_rates'];?></td>
								<td field="dailybreakdown_gals" class="greyclr edit-disabled"><?php if(isset($row['dailybreakdown_gals']))echo $row['dailybreakdown_gals'];?></td>
								<td field="dailybreakdown_time" class="light_blueclr timecount"><?php if(isset($row['dailybreakdown_time']))echo $row['dailybreakdown_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_blueclr">Clean and Touchup</td>
								<td field="cleantouchup_quantity" class="yellowclr"><?php if(isset($row['cleantouchup_quantity']))echo $row['cleantouchup_quantity'];?></td>
								<td field="cleantouchup_unit" class="light_blueclr">Hours</td>
								<td field="cleantouchup_coats" class="greyclr edit-disabled"><?php if(isset($row['cleantouchup_coats']))echo $row['cleantouchup_coats'];?></td>
								<td field="cleantouchup_finish" class="greyclr edit-disabled"><?php if(isset($row['cleantouchup_finish']))echo $row['cleantouchup_finish'];?></td>
								<td field="cleantouchup_rates" class="greyclr edit-disabled"><?php if(isset($row['cleantouchup_rates']))echo $row['cleantouchup_rates'];?></td>
								<td field="cleantouchup_gals" class="greyclr edit-disabled"><?php if(isset($row['cleantouchup_gals']))echo $row['cleantouchup_gals'];?></td>
								<td field="cleantouchup_time" class="light_blueclr timecount"><?php if(isset($row['cleantouchup_time']))echo $row['cleantouchup_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_purpleclr">Bullnose/Accent Wall</td>
								<td field="bullnosewall_quantity" class="yellowclr"><?php if(isset($row['bullnosewall_quantity']))echo $row['bullnosewall_quantity'];?></td>
								<td field="bullnosewall_unit" class="light_blueclr">Hours</td>
								<td field="bullnosewall_coats" class="greyclr edit-disabled"><?php if(isset($row['bullnosewall_coats']))echo $row['bullnosewall_coats'];?></td>
								<td field="bullnosewall_finish" class="greyclr edit-disabled"><?php if(isset($row['bullnosewall_finish']))echo $row['bullnosewall_finish'];?></td>
								<td field="bullnosewall_rates" class="greyclr edit-disabled"><?php if(isset($row['bullnosewall_rates']))echo $row['bullnosewall_rates'];?></td>
								<td field="bullnosewall_gals" class="greyclr edit-disabled"><?php if(isset($row['bullnosewall_gals']))echo $row['bullnosewall_gals'];?></td>
								<td field="bullnosewall_time" class="light_blueclr timecount"><?php if(isset($row['bullnosewall_time']))echo $row['bullnosewall_time'];?></td>
							</tr>
							<tr>
								<td field="" class="yellowclr">Miscellaneous</td>
								<td field="miscellaneous1_quantity" class="yellowclr"><?php if(isset($row['miscellaneous1_quantity']))echo $row['miscellaneous1_quantity'];?></td>
								<td field="miscellaneous1_unit" class="light_blueclr">Hours</td>
								<td field="miscellaneous1_coats" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous1_coats']))echo $row['miscellaneous1_coats'];?></td>
								<td field="miscellaneous1_finish" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous1_finish']))echo $row['miscellaneous1_finish'];?></td>
								<td field="miscellaneous1_rates" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous1_rates']))echo $row['miscellaneous1_rates'];?></td>
								<td field="miscellaneous1_gals" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous1_gals']))echo $row['miscellaneous1_gals'];?></td>
								<td field="miscellaneous1_time" class="light_blueclr timecount"><?php if(isset($row['miscellaneous1_time']))echo $row['miscellaneous1_time'];?></td>
							</tr>
							<tr>
								<td field="" class="yellowclr">Miscellaneous</td>
								<td field="miscellaneous2_quantity" class="yellowclr"><?php if(isset($row['miscellaneous2_quantity']))echo $row['miscellaneous2_quantity'];?></td>
								<td field="miscellaneous2_unit" class="light_blueclr">Hours</td>
								<td field="miscellaneous2_coats" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous2_coats']))echo $row['miscellaneous2_coats'];?></td>
								<td field="miscellaneous2_finish" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous2_finish']))echo $row['miscellaneous2_finish'];?></td>
								<td field="miscellaneous2_rates" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous2_rates']))echo $row['miscellaneous2_rates'];?></td>
								<td field="miscellaneous2_gals" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous2_gals']))echo $row['miscellaneous2_gals'];?></td>
								<td field="miscellaneous2_time" class="light_blueclr timecount"><?php if(isset($row['miscellaneous2_time']))echo $row['miscellaneous2_time'];?></td>
							</tr>
							<tr>
								<td field="" class="yellowclr">Miscellaneous</td>
								<td field="miscellaneous3_quantity" class="yellowclr"><?php if(isset($row['miscellaneous3_quantity']))echo $row['miscellaneous3_quantity'];?></td>
								<td field="miscellaneous3_unit" class="light_blueclr">Hours</td>
								<td field="miscellaneous3_coats" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous3_coats']))echo $row['miscellaneous3_coats'];?></td>
								<td field="miscellaneous3_finish" class="greyclr edit-disabled timecount"><?php if(isset($row['miscellaneous3_finish']))echo $row['miscellaneous3_finish'];?></td>
								<td field="miscellaneous3_rates" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous3_rates']))echo $row['miscellaneous3_rates'];?></td>
								<td field="miscellaneous3_gals" class="greyclr edit-disabled"><?php if(isset($row['miscellaneous3_gals']))echo $row['miscellaneous3_gals'];?></td>
								<td field="miscellaneous3_time" class="light_blueclr timecount"><?php if(isset($row['miscellaneous3_time']))echo $row['miscellaneous3_time'];?></td>
							</tr>
							<tr>
								<td field="" class="light_purpleclr">Faux/Mural</td>
								<td field="faux_quantity" class="yellowclr"><?php if(isset($row['faux_quantity']))echo $row['faux_quantity'];?></td>
								<td field="faux_unit" class="light_blueclr">Hours</td>
								<td field="faux_coats" class="greyclr edit-disabled"><?php if(isset($row['faux_coats']))echo $row['faux_coats'];?></td>
								<td field="faux_finish" class="greyclr edit-disabled"><?php if(isset($row['faux_finish']))echo $row['faux_finish'];?></td>
								<td field="faux_rates" class="greyclr edit-disabled"><?php if(isset($row['faux_rates']))echo $row['faux_rates'];?></td>
								<td field="faux_gals" class="greyclr edit-disabled"><?php if(isset($row['faux_gals']))echo $row['faux_gals'];?></td>
								<td field="faux_time" class="light_blueclr timecount1"><?php if(isset($row['faux_time']))echo $row['faux_time'];?></td>
							</tr>
						</tbody>
						<!-- <tfoot>
							<tr>
								<th>
									<strong>TOTAL</strong>
								</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</tfoot> -->
					</table>
				<div class="input-field col s12" style="padding: 0px; text-align:center;" >
				   <i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#B71C1C; display:inline-block; float:none;">
					<input id="submit" class="waves-button-input" type="button" onclick="form_internalestimate()" value="<?php echo $button; ?>" name="submit" style="height: 2rem !important;">
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
 $('#intest').addClass('active');
});
var ignore = false;

$(function () {
    $(window).bind('beforeunload', function () {
        if (!ignore) {
            return 'WARNING: Data you have entered may not be saved.';
        }
    });
/*
    $('.ignorepostback').live('click',function () {
        ignore = true;
    });
	*/
	
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
			url: '<?= SITE_ROOT; ?>/project/addroomtype', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['success'])
				{		
					window.location.href="<?php echo SITE_ROOT;?>/project/internalestimate?project_id=<?php echo $_REQUEST['project_id']; ?>";
					193
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
	$("#headingSearchtitle").html("Interior Estimate");
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
   $("#interiorli").addClass("active");
   $("#interiorlidiv").show();
});
</script>