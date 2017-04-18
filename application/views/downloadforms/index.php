<?php
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$access2 = new PrivilegedUser();
if (!($access2->hasPrivilege("ManageForms") || $access2->hasPrivilege("EditForms") || $access2->hasPrivilege("DeleteForms") || $access2->hasPrivilege("AddForms")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
$heading = "Home";
?>
<div class="page-head">
	<div class="page-title">
		<h1>Forms Listing
		</h1>
	</div>
</div>                   
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark" style="margin-top: 1%;">
					<i class="fa fa-file-text"></i>
					<span class="caption-subject bold uppercase">Manage Forms</span>
				</div>
			<?php if ($access->hasPrivilege("AddForms") ) { ?>
			<div class="margin-top-10">
				<a href="<?php echo SITE_ROOT; ?>/downloadforms/addedit" class="btn green" name="submit" value="" style="float: right; margin: 0%;">ADD NEW FORM</a>
			</div>
			<?php } ?>
			
				<div class="tools"> </div>
			</div>
			<div class="portlet-body">
				<div id="sample_1_wrapper" class="dataTables_wrapper no-footer"><div class="table-scrollable">
				<table id="adminlisting" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>NO</th>
							<th>TITLE</th>
							<th>DESCRIPTION</th>
							<th>FILE</th>
							<th >SAMAJ CITY</th>
							<th class="no-sort">ACTIONS</th>
						</tr>
					</thead>
				</table>
				</div></div>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$('#menuforms').addClass('active');
});
function deletedata(id)
	{
    	var r=confirm("Are you sure you want to delete this record?");
    	if (r==true)
   		{
    		window.location.href="<?=SITE_ROOT;?>/downloadforms/delete?id="+id;
    	}
    }
	
	
$(document).ready(function() {
		var table = $('#adminlisting').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?=BASEPATH."/downloadforms/fetch_forms";?>",
			columnDefs: [
				{ targets: 'no-sort', orderable: false }
			],
			initComplete : function () {
			table.buttons().container()
				   .appendTo( $('#adminlisting_wrapper .col-sm-6:eq(1)'));
			},
			buttons: [ 
					{
						extend: 'copy',
						 exportOptions: {
							columns: [0,1,2,3,4]
						}
					},
					{
					   extend: 'excel',
					   title: 'DownloadForms export',
					   exportOptions: {
							columns: [0,1,2,3,4]
						}
					},
					{
					   extend: 'pdf',
					   title: 'DownloadForms export',
					   exportOptions: {
							columns: [0,1,2,3,4]
						}
					},
					{ 
						extend: 'colvis'
					} 
				]
	 });
	});
	
</script>