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
<div class="row">
	<div class="col s12 m12">
		<ul id="task-card" class="collection with-header" style="margin-bottom: 0px; border: 0px none;">
		<li class="collection-header" style="background:transparent;padding:0;">
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 470px);">
					<a data-delay="50" data-tooltip="Next To Summary" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/internal_summary?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#b71c1c;" class="mdi-hardware-keyboard-arrow-right"></i>
					</a>
					<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
						<i style="color:#b71c1c;" class="mdi-content-clear"></i>
					</a>
					<a data-delay="50" data-tooltip="Previous To Project" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/internal_project?project_id=".$_REQUEST['project_id']; ?>">
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
<div class="card-panel" style="margin-top: 0px; padding: 10px 25px 0px 20px"">
	<div id="row-grouping" class="section">
		<div class="row">
			<div class="col s12 m12">
				<table id="data-table-row-grouping" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Id</th>
							<th>Room</th>
							<th>Gallons</th>
							<th>Hours</th>
							<th>Cost</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
    var table = $('#data-table-row-grouping').DataTable({
		"processing": true,
        "serverSide": true,
		"ajax": "<?=BASEPATH."/project/listintpricing?project_id=".$_REQUEST['project_id'];?>",
		columnDefs: [
			{ targets: 'no-sort', orderable: false }
		],
		initComplete : function () {
			table.buttons().container()
				   .appendTo( $('#userstable_wrapper .col-sm-6:eq(1)'));
		}
	});
	$('#role').change(function(){
		if($(this).val() == 'yes')
			$('.addselect').show();
		else
			$('.addselect').hide();
	});
});

function deleteData(id)
{
	var r=confirm("Are you sure you want to delete this record?");
	if (r==true)
	{
		window.location.href="<?=SITE_ROOT;?>/project/deleteintpricing?id="+id+"&project_id=<?php echo $_REQUEST['project_id']; ?>";
	}
}
$(function(){
 $('#intpricing').addClass('active');
 $("#headingSearchtitle").html("Interior Pricing");
 $("#interiorli").addClass("active");
   $("#interiorlidiv").show();
});
</script>