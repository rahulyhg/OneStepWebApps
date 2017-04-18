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

table td{
	background : #eee;
}
.specialclass.fixed,.specialclass2.fixed,.specialclass3.fixed,.specialclass4.fixed,.specialclass5.fixed,.specialclass6.fixed,.specialclass7.fixed,.specialclass8.fixed,.specialclass9.fixed,.specialclass10.fixed,.specialclass11.fixed,.specialclass12.fixed,.specialclass13.fixed{
  top:0;
  position:fixed;
  width:auto;
  display:none;
  border:none;
  margin-top:0px !important;
}
</style>

<script type="text/javascript" src="<?php echo JS; ?>/editable-table/mindmup-editabletable.js"></script>   
<script type="text/javascript" src="<?php echo JS; ?>/editable-table/numeric-input-example.js"></script>
<div class="col s12 m12 l12">
		<div class="card-panel" style="margin-top: 0px;">
		<div id="row-grouping" class="section" style="padding-top:20px;">
			<div class="row">
				<div class="col s12 m4">
					<table id="mainTable" class="table table-striped specialclass" style="border-collapse: separate; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Id</th>
								<th class="greyclr">Description</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$rs1 = array();
							$db = new Db();  
							$row = array();
							$table88 = "room_types";

							$main_table88 = array("$table88 i",array("i.*"));
							$join_tables88 = array(
							);
							//$condition88 = " i.project_id = '".$_REQUEST['project_id']."' ";
							$condition88 = " 1=1 ";
							$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
							$count = 1;
							while($row = mysql_fetch_assoc($rs1))
							{ ?>
										<tr class="<?php echo $row['id']; ?>">
											<td class="edit-disabled"><?php echo $count; ?></td>
											<td class="yellowclr" objid="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></td>
										</tr>
							<?php  $count++; } ?>
						</tbody>
					</table>
					
					<table id="mainTable3" class="table table-striped specialclass2" style="border-collapse: separate;margin-top:30px; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Id</th>
								<th class="greyclr">Levels of Preparation</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$rs1 = array();
							$db = new Db();  
							$row = array();
							$table88 = "level_of_preparation";

							$main_table88 = array("$table88 i",array("i.*"));
							$join_tables88 = array(
							);
							$condition88 = " i.project_id = '".$_REQUEST['project_id']."' ";
							//$condition88 = " 1=1 ";
							$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
							$count = 1;
							while($row = mysql_fetch_assoc($rs1))
							{ ?>
										<tr class="<?php echo $row['id']; ?>">
											<td class="edit-disabled"><?php echo $row['level']; ?></td>
											<td class="yellowclr" objid="<?php echo $row['id']; ?>"><?php echo $row['percentage']; ?></td>
										</tr>
							<?php  $count++; } ?>
						</tbody>
					</table>
					
					<table class="table table-striped specialclass3" style="border-collapse: separate;margin-top:30px; margin-bottom:30px; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Material Calculation</th>
							</tr>
						</thead>
						<tbody>
							<tr class="">
								<td class="edit-disabled">Paint Cost (by gal.)</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">Paint Cost (by %)Sq. Ft.</td>
							</tr>
						</tbody>
					</table>
					
				</div>
				
				<div class="col s12 m4">
					<table id="mainTable1" class="table table-striped specialclass4" style="border-collapse: separate; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Id</th>
								<th class="greyclr">Exterior Descript</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$rs1 = array();
							$db = new Db();  
							$row = array();
							$table88 = "ext_room_type";

							$main_table88 = array("$table88 i",array("i.*"));
							$join_tables88 = array(
							);
							//$condition88 = " i.project_id = '".$_REQUEST['project_id']."' ";
							$condition88 = " 1=1 ";
							$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
							$count = 1;
							while($row = mysql_fetch_assoc($rs1))
							{ ?>
										<tr class="<?php echo $row['id']; ?>">
											<td class="edit-disabled"><?php echo $count; ?></td>
											<td class="yellowclr" objid="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></td>
										</tr>
							<?php  $count++; } ?>
						</tbody>
					</table>
					
					<table id="mainTable2" class="table table-striped specialclass5" style="border-collapse: separate;margin-top:30px; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Code</th>
								<th class="greyclr">Description</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$rs1 = array();
							$db = new Db();  
							$row = array();
							$table88 = "Finish_desc";

							$main_table88 = array("$table88 i",array("i.*"));
							$join_tables88 = array(
							);
							//$condition88 = " i.project_id = '".$_REQUEST['project_id']."' ";
							$condition88 = " 1=1 ";
							$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
							$count = 1;
							while($row = mysql_fetch_assoc($rs1))
							{ ?>
										<tr class="<?php echo $row['id']; ?>">
											<td class="edit-disabled"><?php echo $row['code']; ?></td>
											<td class="yellowclr" objid="<?php echo $row['id']; ?>"><?php echo $row['description']; ?></td>
										</tr>
							<?php  $count++; } ?>
						</tbody>
					</table>
					
					<table class="table table-striped specialclass6" style="border-collapse: separate;margin-top:30px; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Doors</th>
							</tr>
						</thead>
						<tbody>
							<tr class="">
								<td class="edit-disabled">Flat</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">Six Panels</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">French Doors</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">Frames</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">Extra Prep</td>
							</tr>
						</tbody>
					</table>
					
					<table class="table table-striped specialclass7" style="border-collapse: separate;margin-top:30px; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Windows</th>
							</tr>
						</thead>
						<tbody>
							<tr class="">
								<td class="edit-disabled">Casement</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">1 and 1</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">French 3-7 Panel</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">French 8-16 Panel</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">French 16 + Panel</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">Extra Prep</td>
							</tr>
						</tbody>
					</table>
					
					<table class="table table-striped specialclass8" style="border-collapse: separate;margin-top:30px; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Coats</th>
							</tr>
						</thead>
						<tbody>
							<tbody>
							<?php for($y=1;$y<=4;$y++){ ?>
							<tr class="">
								<td class="edit-disabled"><?= $y; ?></td>
							</tr>
							<?php } ?>
						</tbody>
						</tbody>
					</table>
					
					<table class="table table-striped specialclass9" style="border-collapse: separate;margin-top:30px; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Units</th>
							</tr>
						</thead>
						<tbody>
							<tr class="">
								<td class="edit-disabled">Hours</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">Each</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">Ln. Ft.</td>
							</tr>
							<tr class="">
								<td class="edit-disabled">Sq. Ft.</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col s12 m4">
					<table class="table table-striped specialclass10" style="border-collapse: separate; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Wall Dimensions</th>
							</tr>
						</thead>
						<tbody>
							<?php for($y=1;$y<=40;$y++){ ?>
							<tr class="">
								<td class="edit-disabled"><?= $y; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				</div>
				<div style="clear:both;float:left;height;10px;"></div>
				<div class="row">
					<div class="col s12 m6">
						<table  id="mainTable4" class="table table-striped specialclass11" style="border-collapse: separate;border-spacing: 1px ! important; background: #fff;">
							<thead>
								<tr>
									<th class="greyclr">Description</th>
									<th class="greyclr">Interior Rate</th>
									<th class="greyclr">Exterior Rate</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$rs1 = array();
								$db = new Db();  
								$row = array();
								$table88 = "Interior_Rate";

								$main_table88 = array("$table88 i",array("i.*"));
								$join_tables88 = array(
								);
								$condition88 = " i.project_id = '".$_REQUEST['project_id']."' ";
								//$condition88 = " 1=1 ";
								$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
								$count = 1;
								while($row = mysql_fetch_assoc($rs1))
								{ ?>
								<tr class="<?php echo $row['id']; ?>">
									<td class="edit-disabled"><?php echo $row['rate_type']; ?></td>
									<td class="yellowclr" objid="<?php echo $row['id']; ?>" objid1="interior"><?php echo $row['interior']; ?></td>
									<td class="yellowclr" objid="<?php echo $row['id']; ?>" objid1="exterior"><?php echo $row['exterior']; ?></td>
								</tr>
								<?php  $count++; } ?>
							</tbody>
						</table>
					</div>
					<div class="col s12 m6">
					<table id="mainTable5" class="table table-striped specialclass12" style="border-collapse: separate;border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Deposit Info</th>
								<th class="greyclr">Value</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="edit-disabled">Deposit Percent</td>
								<td class="yellowclr" objid="deposit_percent"><?php echo $db->FetchCellValue("projects","deposit_percent","id = ".$_REQUEST['project_id']); ?> %</td>
							</tr>
							<tr>
								<td class="edit-disabled">Maximum Deposit</td>
								<td class="yellowclr" objid="maximum_deposit"><?php echo $db->FetchCellValue("projects","maximum_deposit","id = ".$_REQUEST['project_id']); ?></td>
							</tr>
						</tbody>
					</table>
					
					<table  id="mainTable6" class="table table-striped specialclass13" style="border-collapse: separate;margin-top:30px; border-spacing: 1px ! important; background: #fff;">
						<thead>
							<tr>
								<th class="greyclr">Estimators</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="yellowclr" objid="prepared_by"><?php echo $db->FetchCellValue("projects","prepared_by","id = ".$_REQUEST['project_id']); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#mainTable td').on('change', function(evt, newValue) {
		var name = $(this).html();
		var id = $(this).attr("objid");
		if($(this).html()!=""){
		$.ajax({
			url: '<?= SITE_ROOT; ?>/project/editroomtype', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			data: {id: id, name: name},
			success: function (response) {
				var res = eval('('+response+')');
				if(res['success'])
				{
					Materialize.toast("Value Updated Successfully", 4000);
					return true;
				}
				else
				{	
					Materialize.toast("Value Not Updated Successfully", 4000);
					return false;
				}
			}
		});
		}else{
			return false;
		}
	});
	
	$('#mainTable1 td').on('change', function(evt, newValue) {
		var name = $(this).html();
		var id = $(this).attr("objid");
		if($(this).html()!=""){
		$.ajax({
			url: '<?= SITE_ROOT; ?>/project/editspacetype', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			data: {id: id, name: name},
			success: function (response) {
				var res = eval('('+response+')');
				if(res['success'])
				{
					Materialize.toast("Value Updated Successfully", 4000);
					return true;
				}
				else
				{	
					Materialize.toast("Value Not Updated Successfully", 4000);
					return false;
				}
			}
		});
		}else{
			return false;
		}
	});
	
	$('#mainTable4 td').on('change', function(evt, newValue) {
		var name = $(this).html();
		var id = $(this).attr("objid");
		var objid1 = $(this).attr("objid1");
		
		if($(this).html()!=""){
		$.ajax({
			url: '<?= SITE_ROOT; ?>/project/editinteriorrate', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			data: {id: id, rate: name, type:objid1},
			success: function (response) {
				var res = eval('('+response+')');
				if(res['success'])
				{
					Materialize.toast("Value Updated Successfully", 4000);
					return true;
				}
				else
				{	
					Materialize.toast("Value Not Updated Successfully", 4000);
					return false;
				}
			}
		});
		}else{
			return false;
		}
	});
	
	$('#mainTable2 td').on('change', function(evt, newValue) {
		var name = $(this).html();
		var id = $(this).attr("objid");
		if($(this).html()!=""){
		$.ajax({
			url: '<?= SITE_ROOT; ?>/project/editfinishdesc', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			data: {id: id, description: name},
			success: function (response) {
				var res = eval('('+response+')');
				if(res['success'])
				{
					Materialize.toast("Value Updated Successfully", 4000);
					return true;
				}
				else
				{	
					Materialize.toast("Value Not Updated Successfully", 4000);
					return false;
				}
			}
		});
		}else{
			return false;
		}
	});
	
	$('#mainTable3 td').on('change', function(evt, newValue) {
		var name = $(this).html();
		var id = $(this).attr("objid");
		var project_id = '<?php echo $_REQUEST['project_id']; ?>';
		if($(this).html()!=""){
		$.ajax({
			url: '<?= SITE_ROOT; ?>/project/editlevel', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			data: {id: id, percentage: name, project_id:project_id},
			success: function (response) {
				var res = eval('('+response+')');
				if(res['success'])
				{
					Materialize.toast("Value Updated Successfully", 4000);
					return true;
				}
				else
				{	
					Materialize.toast("Value Not Updated Successfully", 4000);
					return false;
				}
			}
		});
		}else{
			return false;
		}
	});
	
	$('#mainTable5 td,#mainTable6 td').on('change', function(evt, newValue) {
		var name = $(this).html().replace("%", "");
		var id = $(this).attr("objid");
		var project_id = '<?php echo $_REQUEST['project_id']; ?>';
		if($(this).html()!=""){
		$.ajax({
			url: '<?= SITE_ROOT; ?>/project/editprojectparam', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			data: {param: id, value: name, id:project_id},
			success: function (response) {
				var res = eval('('+response+')');
				if(res['success'])
				{
					Materialize.toast("Value Updated Successfully", 4000);
					return true;
				}
				else
				{	
					Materialize.toast("Value Not Updated Successfully", 4000);
					return false;
				}
			}
		});
		}else{
			return false;
		}
	});
});

$('#mainTable,#mainTable1,#mainTable2,#mainTable3,#mainTable4,#mainTable5,#mainTable6').editableTableWidget({disableClass: "edit-disabled"});

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
   $(".specialclass3").fixMe();
   $(".specialclass4").fixMe();
   $(".specialclass5").fixMe();
   $(".specialclass6").fixMe();
   $(".specialclass7").fixMe();
   $(".specialclass8").fixMe();
   $(".specialclass9").fixMe();
   $(".specialclass10").fixMe();
   $(".specialclass11").fixMe();
   $(".specialclass12").fixMe();
   $(".specialclass13").fixMe();
});
</script>