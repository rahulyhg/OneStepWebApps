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
?>
<div class="row">
<div class="col s12 m12">
	<ul id="task-card" class="collection with-header" style="margin-bottom: 0px; border: 0px none;">
		<li class="collection-header" style="background:transparent;padding:0;">
			<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 600px);">
				<a data-delay="50" data-tooltip="Next To Estimate" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/externalestimate?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#00699C;" class="mdi-hardware-keyboard-arrow-right"></i>
				</a>
				<a data-delay="50" data-tooltip="Back To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#00699C;" class="mdi-content-clear"></i>
				</a>
				<a data-delay="50" data-tooltip="Previous To Dashboard" class="btn-floating tooltipped white" style="float: right;margin-left:10px;" href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$_REQUEST['project_id']; ?>">
					<i style="color:#00699C;" class="mdi-hardware-keyboard-arrow-left"></i>
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
				<a href="<?php echo SITE_ROOT."/home/externalnote?project_id=".$_REQUEST['project_id'];?>" style="float: right; margin-right: 20px;"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content strong" style="color:#00699C;background:#fff;">Add Notes</span></h6></a>
			</div>
		</li>
	</ul>
</div>
	
</div>
<div class="col s12 m12">
<div class="card-panel" style="margin-top: 0px;">
	<div id="row-grouping" class="section" style="padding-top:0px;">
		<div class="row">
			<div class="col s12 m12">
				<table id="data-table-row-grouping" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Date Created</th>
							<th>Name</th>
							<th>Description</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
$(document).ready(function() {
    var table = $('#data-table-row-grouping').DataTable({
		"processing": true,
        "serverSide": true,
		"ajax": "<?=BASEPATH."/home/listextnotes?project_id=".$_REQUEST['project_id']?>",
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
		window.location.href="<?=SITE_ROOT;?>/home/deleteextnotes?id="+id;
	}
}
$(function(){
 $('#extnotes').addClass('active');
 $("#headingSearchtitle").html("Exterior Notes");
 $("#exteriorli").addClass("active");
   $("#exteriorlidiv").show();
});
</script>