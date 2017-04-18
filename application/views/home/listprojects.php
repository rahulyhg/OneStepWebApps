<div class="col s12 m12">
	<ul id="task-card" class="collection with-header" style="margin-bottom: 0px; border: 0px none;">
		<li class="collection-header" style="background:transparent;padding:0;">
		<div style="z-index: 2147483647; position: fixed; top: 15px; left: calc(100% - 600px);">
			<a href="<?php echo SITE_ROOT;?>/home/projects"><h6 class="task-card-title" style="text-align:right;"><span class="z-depth-2 waves-effect btn secondary-content white strong" style="color:#4285F4;">Add New Project</span></h6></a>
			</div>
		</li>
	</ul>
</div>
<div class="card-panel" style="margin-top: 0px;">
	<div id="row-grouping" style="padding: 0 10px;" class="section">
		<div class="row">
			<div class="col s12 m12">
				<table id="data-table-row-grouping" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Project Id</th>
							<th>Project Name</th>
							<th>Date</th>
							<th>Client</th>
							<th>Phone</th>
							<th>Email</th>
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
		"ajax": "<?=BASEPATH."/home/listallprojects";?>",
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
		window.location.href="<?=SITE_ROOT;?>/home/deleteprojects?id="+id;
	}
}
$(function(){
 $('#projectmenu').addClass('active');
  $("#headingSearchtitle").html("Projects");
});
</script>