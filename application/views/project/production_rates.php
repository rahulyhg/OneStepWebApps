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

//$trackingid = $db->FetchCellValue("external_hrs_tracking","id","project_id = '".$_REQUEST['project_id']."' && created_by = ".$_SESSION["samajadmin"]["id"]);
$label = "Add";
$button = "Create";
if(isset($trackingid) && $trackingid != ""){
	$label = "Edit";
	$button = "Update";
} 

$db = new Db();  
$row = array();
$table88 = "default_production_rate";

	$main_table88 = array("$table88 i",array("i.*"));
	$join_tables88 = array(
	);
	
?> 
<style>
table th,table td{
	background:white;
}
.mainTable td, .mainTable2 th
{
	padding: 5px 5px!important;
}
.ui-accordion .ui-accordion-header{
	float:left;width:100%;
}
.ui-accordion .ui-accordion-content{
	height:auto!Important;
}
.mainTable td:first-child,.mainTable2 th:first-child {
    width: 100px;
}
.mainTable2 th:nth-child(2) {
    width: 200px;
}
.mainTable2 th:nth-child(3) {
    width: 50px;
}
.mainTable2 th:nth-child(4) {
    width: 80px;
}
.mainTable2 th:nth-child(5),.mainTable2 th:nth-child(6),.mainTable2 th:nth-child(7),.mainTable2 th:nth-child(8),.mainTable2 th:nth-child(9),.mainTable2 th:nth-child(10) {
    width: 50px;
}
.mainTable td:nth-child(2) {
    width: 200px;
}
.mainTable td:nth-child(3) {
    width: 50px;
}
.mainTable td:nth-child(4) {
    width: 80px;
}
.mainTable td:nth-child(5),.mainTable td:nth-child(6),.mainTable td:nth-child(7),.mainTable td:nth-child(8),.mainTable td:nth-child(9),.mainTable td:nth-child(10) {
    width: 50px;
}
.ui-accordion .ui-accordion-content{
	width:100%;
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
$(document).ready(function(){
	
	$('#ratepercoat').change(function(){
		var rateper = $(this).val();
		var poststring55={};
		$('.mainTable td').each(function(){
			
			poststring55['id'] =  $(this).attr('objid');
			poststring55[$(this).attr('field')] =  $(this).html();
			var parentobj = $(this).parent();
			var c1_16 = $(parentobj.find('td.coat1')).html();
			
			coat2 = (c1_16/2) + (c1_16/4 * rateper/100);
				$(this).parent().find('td.coat2').html((coat2).toFixed(2));
				
			coat3 = (c1_16/3) + (c1_16/9 * rateper/100)*2;
				$(this).parent().find('td.coat3').html((coat3).toFixed(2));
			
			coat4 = (c1_16/4) + (c1_16/16 * rateper/100)*3;
				$(this).parent().find('td.coat4').html((coat4).toFixed(2));
				
			/*poststring55['coat_1'] = c1_16;*/
			poststring55['coat_2'] = coat2;
			poststring55['coat_3'] = coat3;
			poststring55['coat_4'] = coat4;
		});
		/*$.ajax({
			url: '<?php echo BASEPATH;?>/project/updaterates',  
			type: 'post',
			cache: false,
			data: poststring55,
			success: function (response) {                    
				var res = eval('('+response+')');
				if(res['success'] == "1"){
					//window.location.reload();
				}
				console.log(res->success);
			}
		});*/
	});
	
	$('#level').change(function(){
		var K16 = $(this).val()/100;
		var factorval = $(this).val();
		var ratepercoat = $('#ratepercoat').val();
		var poststring55={};
		$('.mainTable tr:not(.nolevel) td').each(function(){
			poststring55['id'] =  $(this).attr('objid');
			poststring55[$(this).attr('field')] =  $(this).html();
			
			var parentobj = $(this).parent();
			/*var c1_16 = $(parentobj.find('td.coat1')).html();*/
			var D16 = $(parentobj.find('td:nth-child(3)')).html();
			$(parentobj.find('td:last-child')).html(factorval);
			var c1_16 = 0;
			var coat2 = 0;
			var coat3 = 0;
			var coat4 = 0;
			if(K16=="")
				c1_16 = D16;
			else
				c1_16 = D16*(1-K16);
			
				$(this).parent().find('td.coat1').html((c1_16).toFixed(2));
			
			coat2 = (c1_16/2) + (c1_16/4 * ratepercoat/100);
				$(this).parent().find('td.coat2').html((coat2).toFixed(2));
				
			coat3 = (c1_16/3) + (c1_16/9 * ratepercoat/100)*2;
				$(this).parent().find('td.coat3').html((coat3).toFixed(2));
			
			coat4 = (c1_16/4) + (c1_16/16 * ratepercoat/100)*3;
				$(this).parent().find('td.coat4').html((coat4).toFixed(2));
				
			/*poststring55['coat_1'] = c1_16;*/
			poststring55['coat_2'] = coat2;
			poststring55['coat_3'] = coat3;
			poststring55['coat_4'] = coat4;
		});
	});
	
	$('.mainTable td').on('change', function(evt, newValue) {
		var poststring55={};
		poststring55['id'] =  $(this).attr('objid');
		poststring55[$(this).attr('field')] =  $(this).html();
		var K16 = parseFloat($(this).parent().find('td.Factor').html())/100;
		var ratepercoat = $('#ratepercoat').val();
		if($(this).hasClass('rateobj')){
			var D16 = parseFloat(newValue);
			var c1_16 = 0;
			var coat2 = 0;
			var coat3 = 0;
			var coat4 = 0;
			if(K16=="")
				c1_16 = D16;
			else
				c1_16 = D16*(1-K16);
			
				$(this).parent().find('td.coat1').html((c1_16).toFixed(2));
			
			coat2 = (c1_16/2) + (c1_16/4 * ratepercoat/100);
				$(this).parent().find('td.coat2').html((coat2).toFixed(2));
				
			coat3 = (c1_16/3) + (c1_16/9 * ratepercoat/100)*2;
				$(this).parent().find('td.coat3').html((coat3).toFixed(2));
			
			coat4 = (c1_16/4) + (c1_16/16 * ratepercoat/100)*3;
				$(this).parent().find('td.coat4').html((coat4).toFixed(2));
			
			poststring55['coat_1'] = c1_16;
			poststring55['coat_2'] = coat2;
			poststring55['coat_3'] = coat3;
			poststring55['coat_4'] = coat4;
		}
		
		$.ajax({
			url: '<?php echo BASEPATH;?>/project/updaterates',  
			type: 'post',
			cache: false,
			data: poststring55,
			success: function (response) {                    
				var res = eval('('+response+')');
				if(res['success'] == "1"){
					//window.location.reload();
				}
				//console.log(res->success);
			}
		}); 
	});
	
	$('.rateobj').on('change', function(evt, newValue) {
	});
});
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
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 500px);">
					<a data-delay="50" data-tooltip="Next To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#4285F4;" class="mdi-hardware-keyboard-arrow-right"></i>
					</a>
					<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#4285F4;" class="mdi-content-clear"></i>
					</a>
					<a data-delay="50" data-tooltip="Previous To Summary" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/external_summary?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#4285F4;" class="mdi-hardware-keyboard-arrow-left"></i>
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
					</a>
					<a href="javascript:form_internalestimate()" style="float: right; margin-right: 13px;"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content strong" style="color:#4285F4;background:#fff;"><?php echo $button; ?></span></h6></a>-->
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
				<div class="col s12 m6 input-field">
					<input id="ratepercoat" class="validate calculation placecolor" type="text" value="50" autocomplete="off" name="ratepercoat" placeholder="ratepercoat">
					<label class="active" for="length">Rate Increase per Coat</label>
				</div>
				<div class="col s12 m6 input-field">
					<label class="active" for="length">Level of Preparation</label>
					<select class="" name="level" id="level">
					    <?php 
							//echo $db->CreateOptions("html", "occuptions", array("id","name"),"","","status='1'");
							$selected = "0";
							echo $db->CreateOptions("html", "level_of_preparation", array("percentage","level"),$selected,"","project_id = '".$_REQUEST['project_id']."'");
						?>
					</select>
				</div>
						<table class="mainTable2 table table-striped specialclass" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
							<thead>
								<tr>
									<th class="greyclr">Production Item</th>
									<th class="greyclr">Description</th>
									<th class="greyclr">Rate</th>
									<th class="greyclr">Unit</th>
									<th class="greyclr">Coat 1</th>
									<th class="greyclr">Coat 2</th>
									<th class="greyclr">Coat 3</th>
									<th class="greyclr">Coat 4</th>
									<th class="greyclr">Spread</th>
									<th class="greyclr">% Factor</th>
								</tr>
							</thead>
						<tbody>
						<tr>
						<td colspan="10">
					<div id="accordion">
					  <h3>INTERIOR Preparation</h3>
					  <div style="float:left;">
							<table class="mainTable table table-striped" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
								<tbody>
								<?php 
								$condition88 = " i.project_id = '".$_REQUEST['project_id']."' && section='Preparation'";
								$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
								while($row = mysql_fetch_assoc($rs1))
								{ ?>
									<tr class="<?php echo $row['class']; ?>">
										<td class="edit-disabled" field="production_item" objid="<?php echo $row['id']; ?>"><?php echo $row['production_item']; ?></td>
										<td class="yellowclr" field="description" objid="<?php echo $row['id']; ?>"><?php echo $row['description']; ?></td>
										<td class="yellowclr rateobj" field="rate" objid="<?php echo $row['id']; ?>"><?php echo $row['rate']; ?></td>
										<td class="edit-disabled" field="unit" objid="<?php echo $row['id']; ?>"><?php echo $row['unit']; ?></td>
										<td class="white coat1" field="coat_1" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_1']; ?></td>
										<td class="white coat2" field="coat_2" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_2']; ?></td>
										<td class="white coat3" field="coat_3" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_3']; ?></td>
										<td class="white coat4" field="coat_4" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_4']; ?></td>
										<td class="yellowclr" field="spread" objid="<?php echo $row['id']; ?>"><?php echo $row['spread']; ?></td>
										<td class="yellowclr Factor" field="factor" objid="<?php echo $row['id']; ?>"><?php echo $row['factor']; ?></td>
									</tr>
								<?php }?>
							</tbody>
						</table>
					  </div>
					  <h3>INTERIOR Paint Application</h3>
					  <div style="float:left;">
							<table class="mainTable table table-striped" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
							<tbody>
							<?php
								$condition88 = " i.project_id = '".$_REQUEST['project_id']."' && section='PaintApplication'";
								$rs2 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
								while($row = mysql_fetch_assoc($rs2))
								{ ?>
								<tr class="<?php echo $row['class']; ?>">
									<td class="edit-disabled" field="production_item" objid="<?php echo $row['id']; ?>"><?php echo $row['production_item']; ?></td>
									<td class="yellowclr" field="description" objid="<?php echo $row['id']; ?>"><?php echo $row['description']; ?></td>
									<td class="yellowclr rateobj" field="rate" objid="<?php echo $row['id']; ?>"><?php echo $row['rate']; ?></td>
									<td class="edit-disabled" field="unit" objid="<?php echo $row['id']; ?>"><?php echo $row['unit']; ?></td>
									<td class="white coat1" field="coat_1" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_1']; ?></td>
									<td class="white coat2" field="coat_2" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_2']; ?></td>
									<td class="white coat3" field="coat_3" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_3']; ?></td>
									<td class="white coat4" field="coat_4" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_4']; ?></td>
									<td class="yellowclr" field="spread" objid="<?php echo $row['id']; ?>"><?php echo $row['spread']; ?></td>
									<td class="yellowclr Factor" field="factor" objid="<?php echo $row['id']; ?>"><?php echo $row['factor']; ?></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					  </div>
					  <h3>INTERIOR Specialty</h3>
					  <div style="float:left;">
							<table class="mainTable table table-striped" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
							<tbody>
							<?php 
								$condition88 = " i.project_id = '".$_REQUEST['project_id']."' && section='Specialty'";
								$rs3 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
								while($row = mysql_fetch_assoc($rs3))
								{ ?>
								<tr class="<?php echo $row['class']; ?>">
									<td class="edit-disabled" field="production_item" objid="<?php echo $row['id']; ?>"><?php echo $row['production_item']; ?></td>
									<td class="yellowclr" field="description" objid="<?php echo $row['id']; ?>"><?php echo $row['description']; ?></td>
									<td class="yellowclr rateobj" field="rate" objid="<?php echo $row['id']; ?>"><?php echo $row['rate']; ?></td>
									<td class="edit-disabled" field="unit" objid="<?php echo $row['id']; ?>"><?php echo $row['unit']; ?></td>
									<td class="white coat1" field="coat_1" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_1']; ?></td>
									<td class="white coat2" field="coat_2" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_2']; ?></td>
									<td class="white coat3" field="coat_3" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_3']; ?></td>
									<td class="white coat4" field="coat_4" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_4']; ?></td>
									<td class="yellowclr" field="spread" objid="<?php echo $row['id']; ?>"><?php echo $row['spread']; ?></td>
									<td class="yellowclr Factor" field="factor" objid="<?php echo $row['id']; ?>"><?php echo $row['factor']; ?></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
					<h3>EXTERIOR Preparation</h3>
					  <div style="float:left;">
							<table class="mainTable table table-striped" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
							<tbody>
							<?php 
								$condition88 = " i.project_id = '".$_REQUEST['project_id']."' && section='Preparation2'";
								$rs4 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
								while($row = mysql_fetch_assoc($rs4))
								{ ?>
								<tr class="<?php echo $row['class']; ?>">
									<td class="edit-disabled" field="production_item" objid="<?php echo $row['id']; ?>"><?php echo $row['production_item']; ?></td>
									<td class="yellowclr" field="description" objid="<?php echo $row['id']; ?>"><?php echo $row['description']; ?></td>
									<td class="yellowclr rateobj" field="rate" objid="<?php echo $row['id']; ?>"><?php echo $row['rate']; ?></td>
									<td class="edit-disabled" field="unit" objid="<?php echo $row['id']; ?>"><?php echo $row['unit']; ?></td>
									<td class="white coat1" field="coat_1" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_1']; ?></td>
									<td class="white coat2" field="coat_2" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_2']; ?></td>
									<td class="white coat3" field="coat_3" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_3']; ?></td>
									<td class="white coat4" field="coat_4" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_4']; ?></td>
									<td class="yellowclr" field="spread" objid="<?php echo $row['id']; ?>"><?php echo $row['spread']; ?></td>
									<td class="yellowclr Factor" field="factor" objid="<?php echo $row['id']; ?>"><?php echo $row['factor']; ?></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
					<h3>EXTERIOR Paint Application</h3>
					  <div style="float:left;">
							<table class="mainTable table table-striped" style="border-collapse: separate; border-spacing: 1px ! important; background: #009688;">
							<tbody>
							<?php 
								$condition88 = " i.project_id = '".$_REQUEST['project_id']."' && section='PaintApplication2'";
								$rs5 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
								while($row = mysql_fetch_assoc($rs5))
								{ ?>
								<tr class="<?php echo $row['class']; ?>">
									<td class="edit-disabled" field="production_item" objid="<?php echo $row['id']; ?>"><?php echo $row['production_item']; ?></td>
									<td class="yellowclr" field="description" objid="<?php echo $row['id']; ?>"><?php echo $row['description']; ?></td>
									<td class="yellowclr rateobj" field="rate" objid="<?php echo $row['id']; ?>"><?php echo $row['rate']; ?></td>
									<td class="edit-disabled" field="unit" objid="<?php echo $row['id']; ?>"><?php echo $row['unit']; ?></td>
									<td class="white coat1" field="coat_1" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_1']; ?></td>
									<td class="white coat2" field="coat_2" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_2']; ?></td>
									<td class="white coat3" field="coat_3" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_3']; ?></td>
									<td class="white coat4" field="coat_4" objid="<?php echo $row['id']; ?>"><?php echo $row['coat_4']; ?></td>
									<td class="yellowclr" field="spread" objid="<?php echo $row['id']; ?>"><?php echo $row['spread']; ?></td>
									<td class="yellowclr Factor" field="factor" objid="<?php echo $row['id']; ?>"><?php echo $row['factor']; ?></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
					
					</div>
					</td>
					</tr>
					</tbody>
					</table>
			</div>
		</div>
	</div>
</div>
</div>
</div>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$('.mainTable').editableTableWidget({disableClass: "edit-disabled"});
$(function(){
 $('#productionrates').addClass('active'); 
});
</script>
  <script>
  $( function() {
    $( "#accordion" ).accordion();
	$("#headingSearchtitle").html("Production Rates");
  } );
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
});
  </script>