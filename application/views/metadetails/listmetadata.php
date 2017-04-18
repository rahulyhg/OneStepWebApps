<?php
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$access2 = new PrivilegedUser();
if (!($access2->hasPrivilege("ManageMeta") || $access2->hasPrivilege("EditMeta") || $access2->hasPrivilege("DeleteMeta") || $access2->hasPrivilege("AddMeta")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
$heading = "Home";
?>
<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1>Metadata Listing
		</h1>
	</div>
	<!-- END PAGE TITLE -->
</div>                   
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark" style="margin-top: 1%;">
					<i class="fa fa-file-code-o"></i>
					<span class="caption-subject bold uppercase">Manage Matadata</span>
				</div>
				<?php
				if ($access2->hasPrivilege("AddMeta")) 
   { ?>
			<div class="margin-top-10">
				<a href="<?php echo SITE_ROOT; ?>/metadetails/" class="btn green" name="submit" value="" style="float: right; margin: 0%;">ADD METADATA</a>
			</div>
   <?php }
   ?>
			
				<div class="tools"> </div>
			</div>
			<div class="portlet-body">
				<div id="sample_1_wrapper" class="dataTables_wrapper no-footer"><div class="table-scrollable">
				<table id="adlisting" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>NO</th>
							<th>TITLE</th>
							<th >DESCRIPTION</th>
							<th >KEYWORDS</th>
							<th >PAGE</th>
							<th >STATUS</th>
							<th class="no-sort">ACTIONS</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
					</tfoot>
				</table>
				</div></div>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$('#menumeta').addClass('active');
});
function deleteData(id)
	{
    	var r=confirm("Are you sure you want to delete this record?");
    	if (r==true)
   		{
    		window.location.href="<?=SITE_ROOT;?>/metadetails/delete4?id="+id;
    	}
    }
	
	
		$(document).ready(function() {
		var table = $('#adlisting').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": "<?=BASEPATH."/metadetails/fetch_metadata";?>",
		columnDefs: [
		{ targets: 'no-sort', orderable: false }
		],
			initComplete : function () {
			table.buttons().container()
				   .appendTo( $('#adlisting_wrapper .col-sm-6:eq(1)'));
			},
			buttons: [ 
				{
					extend: 'copy',
					 exportOptions: {
						columns: [0,1,2,3,4,5]
					}
				},
				{
				   extend: 'excel',
				   title: 'Metadata export',
				   exportOptions: {
						columns: [0,1,2,3,4,5]
					}
				},
				{
				   extend: 'pdf',
				   title: 'Metadata export',
				   exportOptions: {
						columns: [0,1,2,3,4,5]
					}
				},
				{ 
					extend: 'colvis'
				} 
			]
	 });
	} );
	
</script>