<?php
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$access2 = new PrivilegedUser();
if (!($access2->hasPrivilege("ManageLocation") || $access2->hasPrivilege("EditLocation") || $access2->hasPrivilege("DeleteLocation") || $access2->hasPrivilege("AddLocation")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
$heading = "Home";

?>
<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1>Location Listings
		</h1>
	</div>
	<!-- END PAGE TITLE -->
</div>                   
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark" style="margin-top: 1%;">
					<i class="icon-map"></i>
					<span class="caption-subject bold uppercase">Manage Location</span>
				</div>
				<?php
				if ($access2->hasPrivilege("AddLocation")) 
   { ?>
			<div class="margin-top-10">
				<a href="<?php echo SITE_ROOT; ?>/contact/addlisting" class="btn green" name="submit" value="" style="float: right; margin: 0%;">ADD LOCATION</a>
			</div>
   <?php }
   ?>
			
				<div class="tools"> </div>
			</div>
			<div class="portlet-body">
				<div id="sample_1_wrapper" class="dataTables_wrapper no-footer"><div class="table-scrollable">
				<table id="eventlisting" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>NO</th>
							<th>NAME</th>
							<th>LATITUDE</th>
							<th>LONGITUDE</th>
							<th>CONTACT</th>						
							<th>ADDRESS</th>	
							<th>STATUS</th>							
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
	$('#menucontact').addClass('active');
});
function deleteData(id)
	{
    	var r=confirm("Are you sure you want to delete this record?");
    	if (r==true)
   		{
    		window.location.href="<?=SITE_ROOT;?>/contact/delete?id="+id;
    	}
    }
	
	$(document).ready(function() {
		var table = $('#eventlisting').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?=BASEPATH."/contact/fetch";?>",
			columnDefs: [
			{ targets: 'no-sort', orderable: false }
			],
			initComplete : function () {
			table.buttons().container()
				   .appendTo( $('#eventlisting_wrapper .col-sm-6:eq(1)'));
			},
			buttons: [ 
				{
					extend: 'copy',
					 exportOptions: {
						columns: [0,1,2,3,4,5,6]
					}
				},
				{
				   extend: 'excel',
				   title: 'Contact export',
				   exportOptions: {
						columns: [0,1,2,3,4,5,6]
					}
				},
				{
				   extend: 'pdf',
				   title: 'Contact export',
				   exportOptions: {
						columns: [0,1,2,3,4,5,6]
					}
				},
				{ 
					extend: 'colvis'
				} 
			]
		});
	} );
	
	
</script>