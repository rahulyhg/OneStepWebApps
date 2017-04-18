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
$table88 = "cabtakeoff";
$trackingid = $db->FetchCellValue("cabtakeoff","id","project_id = '".$_REQUEST['project_id']."' ");
if(isset($trackingid) && $trackingid != "")
{
	$condition88 = "i.id = '".$trackingid ."'";
	$main_table88 = array("$table88 i",array("i.*"));
	$join_tables88 = array();
	$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
	$row123 = mysql_fetch_assoc($rs1);
	/*print_r($row123);*/
}
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
	 poststring['LaborDollars'] =  $('#LaborDollars').val();
	 poststring['MaterialDollars'] =  $("#MaterialDollars").val();
	 poststring['TOTALBID'] =  $("#TOTALBID").val();
	 poststring['project_id'] =  <?php echo $_REQUEST['project_id']; ?>;
	 <?php if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" ){?>
		  poststring['id'] =  <?php echo $_REQUEST['id']; ?>;
	<?php } ?> 
	 console.log(poststring);
	
	 ignore = true;
	$.ajax({
		url: '<?php echo BASEPATH;?>/project/addcabtackoff', 
		type: 'post',
		cache: false,
		data: poststring,
		success: function (response) {                    
			var res = eval('('+response+')');
			if(res['success'] == "1"){
				//window.location.reload();
			}
			//console.log(res->success);
		}
	}); 
}
$(function(){
	$('table td').on('change', function(evt, newValue) {
		/*$('table tr td:nth-child(7)').each(function(){
			try{
				if($(this).html() != "")
				{
					sumgallon += parseFloat($(this).html());
				}
			}catch(err){
				sumgallon = sumgallon;
			}
			$("#gallons").val(sumgallon);
		});*/
		var sumtime = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(3)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours1").html(sumtime);
		$("#costs1").html(sumtime * parseFloat($("#LaborRate").val())+sumtime * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100);
		$(".doors_drawers1").html( parseFloat($("#costs1").html())/ (parseFloat($(".doors1").html()) + parseFloat($(".drawers1").html())));
		
		var sumtime2 = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(6)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime2 += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours2").html(sumtime2);
		$("#costs2").html(sumtime2 * parseFloat($("#LaborRate").val())+sumtime2 * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100);
		$(".doors_drawers2").html( parseFloat($("#costs2").html())/ (parseFloat($(".doors2").html()) + parseFloat($(".drawers2").html())));
		
		var sumtime3 = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(9)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime3 += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours3").html(sumtime3);
		$("#costs3").html(sumtime3 * parseFloat($("#LaborRate").val())+sumtime3 * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100);
		$(".doors_drawers3").html( parseFloat($("#costs3").html())/ (parseFloat($(".doors3").html()) + parseFloat($(".drawers3").html())));
		
		var sumtime4 = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(12)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime4 += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours4").html(sumtime4);
		$("#costs4").html(sumtime4 * parseFloat($("#LaborRate").val())+sumtime4 * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100);
		$(".doors_drawers4").html( parseFloat($("#costs4").html())/ (parseFloat($(".doors4").html()) + parseFloat($(".drawers4").html())));
		
		var sumtime5 = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(15)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime5 += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours5").html(sumtime5);
		$("#costs5").html(sumtime5 * parseFloat($("#LaborRate").val())+sumtime5 * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100);
		$(".doors_drawers5").html( parseFloat($("#costs5").html())/ (parseFloat($(".doors5").html()) + parseFloat($(".drawers5").html())));
		
	/*	var sumtime6 = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(18)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime6 += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours6").html(sumtime6);
		$("#costs6").html(sumtime6 * parseFloat($("#LaborRate").val())+sumtime6 * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100);
		$(".doors_drawers6").html( parseFloat($("#costs6").html())/ (parseFloat($(".doors6").html()) + parseFloat($(".drawers6").html())));
		
		var sumtime7 = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(21)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime7 += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours7").html(sumtime7);
		$("#costs7").html(sumtime7 * parseFloat($("#LaborRate").val())+sumtime7 * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100);
		$(".doors_drawers7").html( parseFloat($("#costs7").html())/ (parseFloat($(".doors7").html()) + parseFloat($(".drawers7").html())));
		
		var sumtime8 = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(24)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime8 += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours8").html(sumtime8);
		$("#costs8").html(sumtime8 * parseFloat($("#LaborRate").val())+sumtime8 * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100);
		$(".doors_drawers8").html( parseFloat($("#costs8").html())/ (parseFloat($(".doors8").html()) + parseFloat($(".drawers8").html())));
		
		var sumtime9 = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(27)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime9 += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours9").html(sumtime9);
		$("#costs9").html(sumtime9 * parseFloat($("#LaborRate").val())+sumtime9 * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100);
		$(".doors_drawers9").html( parseFloat($("#costs9").html())/ (parseFloat($(".doors9").html()) + parseFloat($(".drawers9").html())));
		
		var sumtime0 = 0;
		$('#mainTable tr:not(:first-child) td:nth-child(30)').each(function(){
			try{
				if(parseFloat($(this).html()) > 0)
				{
					//$(this).css({"background":"#333"});
					sumtime0 += parseFloat($(this).html());
				}
			}catch(err){}
		});	
		$("#hours0").html(sumtime0);
		$("#costs0").html(sumtime0 * parseFloat($("#LaborRate").val())+sumtime0 * parseFloat($("#LaborRate").val())*parseFloat($("#Material").val())/100); */
		$(".doors_drawers0").html( parseFloat($("#costs0").html())/ (parseFloat($(".doors0").html()) + parseFloat($(".drawers0").html())));
		$("#LaborDollars").val(sumtime * parseFloat($("#LaborRate").val()));
		$("#MaterialDollars").val((parseFloat($("#Material").val()) * parseFloat($("#LaborDollars").val())) / 100);
	});
});
</script>
<style>
.card-title.grey-text.text-darken-4 p{
	margin:10px 0px;
}
.mywidth{
	width:25%;
}
.tableheight{
	
}
.tableheight th, .tableheight td{
	 height: 60px;
	padding-bottom: 0 !important;
	padding-left: 10px !important;
	padding-right: 10px !important;
	padding-top: 0 !important;
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
			<li class="collection-header" style="background:#4285F4;">
				<h4 class="task-card-title">Cab Take Off</h4>
				<div style="position: absolute; top: 20px; right: 20px;">
					<a data-delay="50" data-tooltip="Next To Project" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/external_hrs_tracking?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#4285F4;" class="mdi-hardware-keyboard-arrow-right"></i>
					</a>
					<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#4285F4;" class="mdi-content-clear"></i>
					</a>
					<a data-delay="50" data-tooltip="Previous To Project" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/external_pricing?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#4285F4;" class="mdi-hardware-keyboard-arrow-left"></i>
					</a>
					<a href="<?php echo SITE_ROOT."/home/externalnote?project_id=".$_REQUEST['project_id']; ?>" style="color: white; font-size: 25px;" data-tooltip="Create New Note">
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
					</a>
				</div>
			</li>
		</ul>
	</div>
</div>
<div class="col s12 m12 l12">
<div class="card-panel" style="margin-top: 0px;">
	<div id="row-grouping" class="section" style="padding-top:0px;">
		<div class="col s12 m12 l12">
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
			<!--<div class="col s12 m12" style="text-align:center;">
				<h6>Labor Rate</h6>
			</div>-->
			<div class="col s4 m6 input-field">
				<input id="LaborRate" class="validate greyclr" type="text" value="<?php echo $db->FetchCellValue("Interior_Rate","interior","rate_type = 'paint' ");?>" autocomplete="off" readonly name="LaborRate"  placeholder=" ">
				<label for="LaborRate">Labor Rate</label>
			</div>
			<div class="col s4 m6 input-field">
				<input id="LaborDollars" class="validate greyclr" type="text" value="<?php if(isset($row['Cost']))echo $row['Cost'];?>" autocomplete="off" readonly name="LaborDollars"  placeholder=" ">
				<label for="LaborDollars">Labor Dollars</label>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="col s12 m12">
			<div class="col s4 m6 input-field">
				<input id="Material" class="validate greyclr" type="text" value="<?php echo $db->FetchCellValue("Interior_Rate","interior","rate_type = 'Material %' ");?>" autocomplete="off" readonly name="Material"  placeholder=" ">
				<label for="Material">Material %</label>
			</div>
			<div class="col s4 m6 input-field">
				<input id="MaterialDollars" class="validate greyclr" type="text" value="<?php if(isset($row['Cost']))echo $row['Cost'];?>" autocomplete="off" readonly name="MaterialDollars"  placeholder=" ">
				<label for="MaterialDollars">Material Dollars by %</label>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="col s12 m12">
			<div class="col s4 m6 input-field">
				<input id="TOTALBID" class="validate greyclr" type="text" value="<?php if(isset($row['Hours']))echo $row['Hours'];?>" autocomplete="off" readonly name="TOTALBID"  placeholder=" ">
				<label for="TOTALBID">TOTAL BID</label>
			</div>
		</div>
		</div>
		<div class="row">
			<div class="col s12 m12 tableheight">
				<div class="width30" style="float:left;width:30%;">
				<table class="table table-striped" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
					<tbody>
							<tr>
								<th>Hours</th>
								<th>Task</th>
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Mask & Cover</td>
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Set up booth</td>
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Remove & Label Hardware</td>
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Strip</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Sand All Surfaces</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Sanding Sealer</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Apply Stain</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">1st coat primer</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Caulk & putty</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Sand After Primer</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">2nd coat primer</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Sand After Primer</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">3rd coat primer</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Sand After Primer</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Apply Antiquing Glaze</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">First Coat Clear</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Sand</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Second Coat Clear</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Sand</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Third Coat Clear</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Sand</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Final Coat Clear</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Hang Doors & Hardware</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Install new hardware</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Painting Touch-Up</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Daily Set Up & Breakdown</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr">Clean Up</td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr"></td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr"></td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr"></td>
								
							</tr>
							<tr>
								<td field="" class="white"></td>
								<td field="" class="yellowclr"></td>
								
							</tr>
						</tbody>
					</table>
				</div>
				<div class="width70" style="float:left;width:70%;overflow-x:scroll;">
				<table id="mainTable" class="table table-striped" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
					<tbody>
							<tr>
								
								<td id="hours1" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs1">Cost</td>
								<td id="hours2" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs2">Cost</td>
								
								<td id="hours3" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs3">Cost</td>
								
								<td id="hours4" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs4">Cost</td>
								<td id="hours5" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs5">Cost</td>
								<td id="hours6" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs6">Cost</td>
								
								<td id="hours7" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs7">Cost</td>
								
								<td id="hours8" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs8">Cost</td>
								<td id="hours9" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs9">Cost</td>
								<td id="hours10" data-tooltip="Hours">Hours</td>
								<td></td>
								<td id="costs10">Cost</td>
							</tr>
							<tr>
								<td field="Mask_Cover_1" class="yellowclr"><?php echo $row123['Mask_Cover_1']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_1" class="yellowclr doors1"><?php echo $row123['Doors_1']; ?></td>
								<td field="Mask_Cover_2" class="yellowclr"><?php echo $row123['Mask_Cover_2']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_2" class="yellowclr doors2" ><?php echo $row123['Doors_2']; ?></td>
								<td field="Mask_Cover_3" class="yellowclr"><?php echo $row123['Mask_Cover_3']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_3" class="yellowclr doors3" ><?php echo $row123['Doors_3']; ?></td>
								<td field="Mask_Cover_4" class="yellowclr"><?php echo $row123['Mask_Cover_4']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_4" class="yellowclr doors4" ><?php echo $row123['Doors_4']; ?></td>
								<td field="Mask_Cover_5" class="yellowclr"><?php echo $row123['Mask_Cover_5']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_5" class="yellowclr doors5" ><?php echo $row123['Doors_5']; ?></td>
								<td field="Mask_Cover_6" class="yellowclr"><?php echo $row123['Mask_Cover_6']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_6" class="yellowclr doors6" ><?php echo $row123['Doors_6']; ?></td>
								<td field="Mask_Cover_7" class="yellowclr"><?php echo $row123['Mask_Cover_7']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_7" class="yellowclr doors7" ><?php echo $row123['Doors_7']; ?></td>
								<td field="Mask_Cover_8" class="yellowclr"><?php echo $row123['Mask_Cover_8']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_8" class="yellowclr doors8" ><?php echo $row123['Doors_8']; ?></td>
								<td field="Mask_Cover_9" class="yellowclr"><?php echo $row123['Mask_Cover_9']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_9" class="yellowclr doors9" ><?php echo $row123['Doors_9']; ?></td>
								<td field="Mask_Cover_10" class="yellowclr"><?php echo $row123['Mask_Cover_10']; ?></td>
								<td field="" class="yellowclr">Doors</td>
								<td field="Doors_10" class="yellowclr doors0" ><?php echo $row123['Doors_10']; ?></td> 
							</tr>
							<tr>
								<td field="Set_up_booth_1" class="yellowclr"><?php echo $row123['Set_up_booth_1']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_1" class="yellowclr drawers1"><?php echo $row123['Drawers_1']; ?></td>
								<td field="Set_up_booth_2" class="yellowclr"><?php echo $row123['Set_up_booth_2']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_2" class="yellowclr drawers2"><?php echo $row123['Drawers_2']; ?></td>
								<td field="Set_up_booth_3" class="yellowclr"><?php echo $row123['Set_up_booth_3']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_3" class="yellowclr drawers3"><?php echo $row123['Drawers_3']; ?></td>
								<td field="Set_up_booth_4" class="yellowclr"><?php echo $row123['Set_up_booth_4']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_4" class="yellowclr drawers4"><?php echo $row123['Drawers_4']; ?></td>
								<td field="Set_up_booth_5" class="yellowclr"><?php echo $row123['Set_up_booth_5']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_5" class="yellowclr drawers5"><?php echo $row123['Drawers_5']; ?></td>
								<td field="Set_up_booth_6" class="yellowclr"><?php echo $row123['Set_up_booth_6']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_6" class="yellowclr drawers6"><?php echo $row123['Drawers_6']; ?></td>
								<td field="Set_up_booth_7" class="yellowclr"><?php echo $row123['Set_up_booth_7']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_7" class="yellowclr drawers7"><?php echo $row123['Drawers_7']; ?></td>
								<td field="Set_up_booth_8" class="yellowclr"><?php echo $row123['Set_up_booth_8']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_8" class="yellowclr drawers8"><?php echo $row123['Drawers_8']; ?></td>
								<td field="Set_up_booth_9" class="yellowclr"><?php echo $row123['Set_up_booth_9']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_9" class="yellowclr drawers9"><?php echo $row123['Drawers_9']; ?></td>
								<td field="Set_up_booth_10" class="yellowclr"><?php echo $row123['Set_up_booth_10']; ?></td>
								<td field="" class="yellowclr">Drawers</td>
								<td field="Drawers_10" class="yellowclr drawers0"><?php echo $row123['Drawers_10']; ?></td>
						
							</tr>
							<tr>
								<td field="Remove_Label_Hardware_1" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_1']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers1"></td>
								<td field="Remove_Label_Hardware_2" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_2']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers2"></td>
								<td field="Remove_Label_Hardware_3" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_3']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers3"></td>
								<td field="Remove_Label_Hardware_4" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_4']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers4"></td>
								<td field="Remove_Label_Hardware_5" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_5']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers5"></td>
								<td field="Remove_Label_Hardware_6" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_6']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers5"></td>
								<td field="Remove_Label_Hardware_7" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_7']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers5"></td>
								<td field="Remove_Label_Hardware_8" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_8']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers5"></td>
								<td field="Remove_Label_Hardware_9" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_9']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers5"></td>
								<td field="Remove_Label_Hardware_10" class="yellowclr"><?php echo $row123['Remove_Label_Hardware_10']; ?></td>
								<td field="" class="greyclr edit-disabled">$ / D+D</td>
								<td field="" class="greyclr edit-disabled doors_drawers5"></td>
							</tr>
							<tr>
								<td field="Strip_1" class="yellowclr"><?php echo $row123['Strip_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Strip_2" class="yellowclr"><?php echo $row123['Strip_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Strip_3" class="yellowclr"><?php echo $row123['Strip_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Strip_4" class="yellowclr"><?php echo $row123['Strip_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Strip_5" class="yellowclr"><?php echo $row123['Strip_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Strip_6" class="yellowclr"><?php echo $row123['Strip_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Strip_7" class="yellowclr"><?php echo $row123['Strip_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Strip_8" class="yellowclr"><?php echo $row123['Strip_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Strip_9" class="yellowclr"><?php echo $row123['Strip_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Strip_10" class="yellowclr"><?php echo $row123['Strip_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Sand_All_Surfaces_1" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_All_Surfaces_2" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_All_Surfaces_3" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_All_Surfaces_4" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_All_Surfaces_5" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_All_Surfaces_6" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_All_Surfaces_7" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_All_Surfaces_8" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_All_Surfaces_9" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_All_Surfaces_10" class="yellowclr"><?php echo $row123['Sand_All_Surfaces_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Sanding_Sealer_1" class="yellowclr"><?php echo $row123['Sanding_Sealer_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sanding_Sealer_2" class="yellowclr"><?php echo $row123['Sanding_Sealer_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sanding_Sealer_3" class="yellowclr"><?php echo $row123['Sanding_Sealer_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sanding_Sealer_4" class="yellowclr"><?php echo $row123['Sanding_Sealer_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sanding_Sealer_5" class="yellowclr"><?php echo $row123['Sanding_Sealer_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sanding_Sealer_6" class="yellowclr"><?php echo $row123['Sanding_Sealer_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sanding_Sealer_7" class="yellowclr"><?php echo $row123['Sanding_Sealer_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sanding_Sealer_8" class="yellowclr"><?php echo $row123['Sanding_Sealer_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sanding_Sealer_9" class="yellowclr"><?php echo $row123['Sanding_Sealer_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sanding_Sealer_10" class="yellowclr"><?php echo $row123['Sanding_Sealer_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Apply_Stain_1" class="yellowclr"><?php echo $row123['Apply_Stain_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Stain_2" class="yellowclr"><?php echo $row123['Apply_Stain_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Stain_3" class="yellowclr"><?php echo $row123['Apply_Stain_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Stain_4" class="yellowclr"><?php echo $row123['Apply_Stain_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Stain_5" class="yellowclr"><?php echo $row123['Apply_Stain_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Stain_6" class="yellowclr"><?php echo $row123['Apply_Stain_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Stain_7" class="yellowclr"><?php echo $row123['Apply_Stain_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Stain_8" class="yellowclr"><?php echo $row123['Apply_Stain_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Stain_9" class="yellowclr"><?php echo $row123['Apply_Stain_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Stain_10" class="yellowclr"><?php echo $row123['Apply_Stain_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="1st_coat_primer_1" class="yellowclr"><?php echo $row123['1st_coat_primer_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="1st_coat_primer_2" class="yellowclr"><?php echo $row123['1st_coat_primer_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="1st_coat_primer_3" class="yellowclr"><?php echo $row123['1st_coat_primer_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="1st_coat_primer_4" class="yellowclr"><?php echo $row123['1st_coat_primer_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="1st_coat_primer_5" class="yellowclr"><?php echo $row123['1st_coat_primer_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="1st_coat_primer_6" class="yellowclr"><?php echo $row123['1st_coat_primer_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="1st_coat_primer_7" class="yellowclr"><?php echo $row123['1st_coat_primer_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="1st_coat_primer_8" class="yellowclr"><?php echo $row123['1st_coat_primer_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="1st_coat_primer_9" class="yellowclr"><?php echo $row123['1st_coat_primer_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="1st_coat_primer_10" class="yellowclr"><?php echo $row123['1st_coat_primer_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Caulk_putty_1" class="yellowclr"><?php echo $row123['Caulk_putty_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Caulk_putty_2" class="yellowclr"><?php echo $row123['Caulk_putty_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Caulk_putty_3" class="yellowclr"><?php echo $row123['Caulk_putty_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Caulk_putty_4" class="yellowclr"><?php echo $row123['Caulk_putty_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Caulk_putty_5" class="yellowclr"><?php echo $row123['Caulk_putty_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Caulk_putty_6" class="yellowclr"><?php echo $row123['Caulk_putty_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Caulk_putty_7" class="yellowclr"><?php echo $row123['Caulk_putty_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Caulk_putty_8" class="yellowclr"><?php echo $row123['Caulk_putty_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Caulk_putty_9" class="yellowclr"><?php echo $row123['Caulk_putty_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Caulk_putty_10" class="yellowclr"><?php echo $row123['Caulk_putty_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Sand_After_Primer_11" class="yellowclr"><?php echo $row123['Sand_After_Primer_11']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_21" class="yellowclr"><?php echo $row123['Sand_After_Primer_21']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_31" class="yellowclr"><?php echo $row123['Sand_After_Primer_31']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_41" class="yellowclr"><?php echo $row123['Sand_After_Primer_41']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_51" class="yellowclr"><?php echo $row123['Sand_After_Primer_51']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_61" class="yellowclr"><?php echo $row123['Sand_After_Primer_61']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_71" class="yellowclr"><?php echo $row123['Sand_After_Primer_71']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_81" class="yellowclr"><?php echo $row123['Sand_After_Primer_81']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_91" class="yellowclr"><?php echo $row123['Sand_After_Primer_91']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_101" class="yellowclr"><?php echo $row123['Sand_After_Primer_101']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="2nd_coat_primer_1" class="yellowclr"><?php echo $row123['2nd_coat_primer_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="2nd_coat_primer_2" class="yellowclr"><?php echo $row123['2nd_coat_primer_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="2nd_coat_primer_3" class="yellowclr"><?php echo $row123['2nd_coat_primer_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="2nd_coat_primer_4" class="yellowclr"><?php echo $row123['2nd_coat_primer_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="2nd_coat_primer_5" class="yellowclr"><?php echo $row123['2nd_coat_primer_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="2nd_coat_primer_6" class="yellowclr"><?php echo $row123['2nd_coat_primer_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="2nd_coat_primer_7" class="yellowclr"><?php echo $row123['2nd_coat_primer_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="2nd_coat_primer_8" class="yellowclr"><?php echo $row123['2nd_coat_primer_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="2nd_coat_primer_9" class="yellowclr"><?php echo $row123['2nd_coat_primer_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="2nd_coat_primer_10" class="yellowclr"><?php echo $row123['2nd_coat_primer_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Sand_After_Primer_12" class="yellowclr"><?php echo $row123['Sand_After_Primer_12']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_22" class="yellowclr"><?php echo $row123['Sand_After_Primer_22']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_32" class="yellowclr"><?php echo $row123['Sand_After_Primer_32']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_42" class="yellowclr"><?php echo $row123['Sand_After_Primer_42']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_52" class="yellowclr"><?php echo $row123['Sand_After_Primer_52']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_62" class="yellowclr"><?php echo $row123['Sand_After_Primer_62']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_72" class="yellowclr"><?php echo $row123['Sand_After_Primer_72']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_82" class="yellowclr"><?php echo $row123['Sand_After_Primer_82']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_92" class="yellowclr"><?php echo $row123['Sand_After_Primer_92']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_102" class="yellowclr"><?php echo $row123['Sand_After_Primer_102']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="3rd_coat_primer_1" class="yellowclr"><?php echo $row123['3rd_coat_primer_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="3rd_coat_primer_2" class="yellowclr"><?php echo $row123['3rd_coat_primer_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="3rd_coat_primer_3" class="yellowclr"><?php echo $row123['3rd_coat_primer_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="3rd_coat_primer_4" class="yellowclr"><?php echo $row123['3rd_coat_primer_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="3rd_coat_primer_5" class="yellowclr"><?php echo $row123['3rd_coat_primer_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="3rd_coat_primer_6" class="yellowclr"><?php echo $row123['3rd_coat_primer_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="3rd_coat_primer_7" class="yellowclr"><?php echo $row123['3rd_coat_primer_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="3rd_coat_primer_8" class="yellowclr"><?php echo $row123['3rd_coat_primer_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="3rd_coat_primer_9" class="yellowclr"><?php echo $row123['3rd_coat_primer_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="3rd_coat_primer_10" class="yellowclr"><?php echo $row123['3rd_coat_primer_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Sand_After_Primer_13" class="yellowclr"><?php echo $row123['Sand_After_Primer_13']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_23" class="yellowclr"><?php echo $row123['Sand_After_Primer_23']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_33" class="yellowclr"><?php echo $row123['Sand_After_Primer_33']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_43" class="yellowclr"><?php echo $row123['Sand_After_Primer_43']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_53" class="yellowclr"><?php echo $row123['Sand_After_Primer_53']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_63" class="yellowclr"><?php echo $row123['Sand_After_Primer_63']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_73" class="yellowclr"><?php echo $row123['Sand_After_Primer_73']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_83" class="yellowclr"><?php echo $row123['Sand_After_Primer_83']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_93" class="yellowclr"><?php echo $row123['Sand_After_Primer_93']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_After_Primer_103" class="yellowclr"><?php echo $row123['Sand_After_Primer_103']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Apply_Antiquing_Glaze_1" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Antiquing_Glaze_2" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Antiquing_Glaze_3" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Antiquing_Glaze_4" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Antiquing_Glaze_5" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Antiquing_Glaze_6" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Antiquing_Glaze_7" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Antiquing_Glaze_8" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Antiquing_Glaze_9" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Apply_Antiquing_Glaze_10" class="yellowclr"><?php echo $row123['Apply_Antiquing_Glaze_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="First_Coat_Clear_1" class="yellowclr"><?php echo $row123['First_Coat_Clear_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="First_Coat_Clear_2" class="yellowclr"><?php echo $row123['First_Coat_Clear_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="First_Coat_Clear_3" class="yellowclr"><?php echo $row123['First_Coat_Clear_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="First_Coat_Clear_4" class="yellowclr"><?php echo $row123['First_Coat_Clear_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="First_Coat_Clear_5" class="yellowclr"><?php echo $row123['First_Coat_Clear_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="First_Coat_Clear_6" class="yellowclr"><?php echo $row123['First_Coat_Clear_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="First_Coat_Clear_7" class="yellowclr"><?php echo $row123['First_Coat_Clear_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="First_Coat_Clear_8" class="yellowclr"><?php echo $row123['First_Coat_Clear_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="First_Coat_Clear_9" class="yellowclr"><?php echo $row123['First_Coat_Clear_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="First_Coat_Clear_10" class="yellowclr"><?php echo $row123['First_Coat_Clear_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Sand_11" class="yellowclr"><?php echo $row123['Sand_11']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_21" class="yellowclr"><?php echo $row123['Sand_21']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_31" class="yellowclr"><?php echo $row123['Sand_31']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_41" class="yellowclr"><?php echo $row123['Sand_41']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_51" class="yellowclr"><?php echo $row123['Sand_51']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_61" class="yellowclr"><?php echo $row123['Sand_61']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_71" class="yellowclr"><?php echo $row123['Sand_71']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_81" class="yellowclr"><?php echo $row123['Sand_81']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_91" class="yellowclr"><?php echo $row123['Sand_91']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_101" class="yellowclr"><?php echo $row123['Sand_101']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Second_Coat_Clear_1" class="yellowclr"><?php echo $row123['Second_Coat_Clear_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Second_Coat_Clear_2" class="yellowclr"><?php echo $row123['Second_Coat_Clear_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Second_Coat_Clear_3" class="yellowclr"><?php echo $row123['Second_Coat_Clear_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Second_Coat_Clear_4" class="yellowclr"><?php echo $row123['Second_Coat_Clear_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Second_Coat_Clear_5" class="yellowclr"><?php echo $row123['Second_Coat_Clear_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Second_Coat_Clear_6" class="yellowclr"><?php echo $row123['Second_Coat_Clear_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Second_Coat_Clear_7" class="yellowclr"><?php echo $row123['Second_Coat_Clear_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Second_Coat_Clear_8" class="yellowclr"><?php echo $row123['Second_Coat_Clear_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Second_Coat_Clear_9" class="yellowclr"><?php echo $row123['Second_Coat_Clear_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Second_Coat_Clear_10" class="yellowclr"><?php echo $row123['Second_Coat_Clear_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Sand_12" class="yellowclr"><?php echo $row123['Sand_12']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_22" class="yellowclr"><?php echo $row123['Sand_22']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_32" class="yellowclr"><?php echo $row123['Sand_32']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_42" class="yellowclr"><?php echo $row123['Sand_42']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_52" class="yellowclr"><?php echo $row123['Sand_52']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_62" class="yellowclr"><?php echo $row123['Sand_62']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_72" class="yellowclr"><?php echo $row123['Sand_72']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_82" class="yellowclr"><?php echo $row123['Sand_82']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_92" class="yellowclr"><?php echo $row123['Sand_92']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_102" class="yellowclr"><?php echo $row123['Sand_102']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Third_Coat_Clear_1" class="yellowclr"><?php echo $row123['Third_Coat_Clear_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Third_Coat_Clear_2" class="yellowclr"><?php echo $row123['Third_Coat_Clear_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Third_Coat_Clear_3" class="yellowclr"><?php echo $row123['Third_Coat_Clear_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Third_Coat_Clear_4" class="yellowclr"><?php echo $row123['Third_Coat_Clear_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Third_Coat_Clear_5" class="yellowclr"><?php echo $row123['Third_Coat_Clear_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Third_Coat_Clear_6" class="yellowclr"><?php echo $row123['Third_Coat_Clear_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Third_Coat_Clear_7" class="yellowclr"><?php echo $row123['Third_Coat_Clear_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Third_Coat_Clear_8" class="yellowclr"><?php echo $row123['Third_Coat_Clear_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Third_Coat_Clear_9" class="yellowclr"><?php echo $row123['Third_Coat_Clear_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Third_Coat_Clear_10" class="yellowclr"><?php echo $row123['Third_Coat_Clear_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Sand_13" class="yellowclr"><?php echo $row123['Sand_13']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_23" class="yellowclr"><?php echo $row123['Sand_23']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_33" class="yellowclr"><?php echo $row123['Sand_33']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_43" class="yellowclr"><?php echo $row123['Sand_43']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_53" class="yellowclr"><?php echo $row123['Sand_53']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_63" class="yellowclr"><?php echo $row123['Sand_63']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_73" class="yellowclr"><?php echo $row123['Sand_73']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_83" class="yellowclr"><?php echo $row123['Sand_83']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_93" class="yellowclr"><?php echo $row123['Sand_93']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Sand_103" class="yellowclr"><?php echo $row123['Sand_103']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Final_Coat_Clear_1" class="yellowclr"><?php echo $row123['Final_Coat_Clear_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Final_Coat_Clear_2" class="yellowclr"><?php echo $row123['Final_Coat_Clear_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Final_Coat_Clear_3" class="yellowclr"><?php echo $row123['Final_Coat_Clear_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Final_Coat_Clear_4" class="yellowclr"><?php echo $row123['Final_Coat_Clear_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Final_Coat_Clear_5" class="yellowclr"><?php echo $row123['Final_Coat_Clear_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Final_Coat_Clear_6" class="yellowclr"><?php echo $row123['Final_Coat_Clear_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Final_Coat_Clear_7" class="yellowclr"><?php echo $row123['Final_Coat_Clear_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Final_Coat_Clear_8" class="yellowclr"><?php echo $row123['Final_Coat_Clear_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Final_Coat_Clear_9" class="yellowclr"><?php echo $row123['Final_Coat_Clear_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Final_Coat_Clear_10" class="yellowclr"><?php echo $row123['Final_Coat_Clear_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							</tr>
							<tr>
								<td field="Hang_Doors_Hardware_1" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Hang_Doors_Hardware_2" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Hang_Doors_Hardware_3" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Hang_Doors_Hardware_4" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Hang_Doors_Hardware_5" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Hang_Doors_Hardware_6" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Hang_Doors_Hardware_7" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Hang_Doors_Hardware_8" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Hang_Doors_Hardware_9" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Hang_Doors_Hardware_10" class="yellowclr"><?php echo $row123['Hang_Doors_Hardware_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Install_new_hardware_1" class="yellowclr"><?php echo $row123['Install_new_hardware_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Install_new_hardware_2" class="yellowclr"><?php echo $row123['Install_new_hardware_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Install_new_hardware_3" class="yellowclr"><?php echo $row123['Install_new_hardware_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Install_new_hardware_4" class="yellowclr"><?php echo $row123['Install_new_hardware_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Install_new_hardware_5" class="yellowclr"><?php echo $row123['Install_new_hardware_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Install_new_hardware_6" class="yellowclr"><?php echo $row123['Install_new_hardware_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Install_new_hardware_7" class="yellowclr"><?php echo $row123['Install_new_hardware_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Install_new_hardware_8" class="yellowclr"><?php echo $row123['Install_new_hardware_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Install_new_hardware_9" class="yellowclr"><?php echo $row123['Install_new_hardware_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Install_new_hardware_10" class="yellowclr"><?php echo $row123['Install_new_hardware_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Painting_Touch_Up_1" class="yellowclr"><?php echo $row123['Painting_Touch_Up_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Painting_Touch_Up_2" class="yellowclr"><?php echo $row123['Painting_Touch_Up_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Painting_Touch_Up_3" class="yellowclr"><?php echo $row123['Painting_Touch_Up_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Painting_Touch_Up_4" class="yellowclr"><?php echo $row123['Painting_Touch_Up_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Painting_Touch_Up_5" class="yellowclr"><?php echo $row123['Painting_Touch_Up_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Painting_Touch_Up_6" class="yellowclr"><?php echo $row123['Painting_Touch_Up_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Painting_Touch_Up_7" class="yellowclr"><?php echo $row123['Painting_Touch_Up_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Painting_Touch_Up_8" class="yellowclr"><?php echo $row123['Painting_Touch_Up_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Painting_Touch_Up_9" class="yellowclr"><?php echo $row123['Painting_Touch_Up_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Painting_Touch_Up_10" class="yellowclr"><?php echo $row123['Painting_Touch_Up_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Daily_Set_Up_Breakdown_1" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Daily_Set_Up_Breakdown_2" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Daily_Set_Up_Breakdown_3" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Daily_Set_Up_Breakdown_4" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Daily_Set_Up_Breakdown_5" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Daily_Set_Up_Breakdown_6" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Daily_Set_Up_Breakdown_7" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Daily_Set_Up_Breakdown_8" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Daily_Set_Up_Breakdown_9" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Daily_Set_Up_Breakdown_10" class="yellowclr"><?php echo $row123['Daily_Set_Up_Breakdown_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
							<tr>
								<td field="Clean_Up_1" class="yellowclr"><?php echo $row123['Clean_Up_1']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Clean_Up_2" class="yellowclr"><?php echo $row123['Clean_Up_2']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Clean_Up_3" class="yellowclr"><?php echo $row123['Clean_Up_3']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Clean_Up_4" class="yellowclr"><?php echo $row123['Clean_Up_4']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Clean_Up_5" class="yellowclr"><?php echo $row123['Clean_Up_5']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Clean_Up_6" class="yellowclr"><?php echo $row123['Clean_Up_6']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Clean_Up_7" class="yellowclr"><?php echo $row123['Clean_Up_7']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Clean_Up_8" class="yellowclr"><?php echo $row123['Clean_Up_8']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Clean_Up_9" class="yellowclr"><?php echo $row123['Clean_Up_9']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="Clean_Up_10" class="yellowclr"><?php echo $row123['Clean_Up_10']; ?></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								
							</tr>
							<tr>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								
								
							</tr>
							<tr>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								
							</tr>
							<tr>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								
							</tr>
							<tr>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="yellowclr"></td>
								<td field="" class="greyclr edit-disabled"></td>
								<td field="" class="greyclr edit-disabled"></td>
							
							</tr>
						</tbody>
					</table>
					</div>
					<div class="input-field col s12" style="padding: 0px">
						
					</div>
					<div class="input-field col s12" style="padding: 0px">
						<i class="z-depth-1 waves-effect btn secondary-content strong waves-input-wrapper" style="background:#4285F4;">
							<input id="submit" class="waves-button-input" type="button" name="submit" value="Create" onclick="form_internalestimate()">
						</i>
					</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
$('#mainTable').editableTableWidget();
$('#mainTable').editableTableWidget({disableClass: "edit-disabled"});
$(function(){
 $('#cabstackoff').addClass('active');
});
</script>