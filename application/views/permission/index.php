<?php 
$result= array();
$act = "add";
$heading = "Manage Permissions";

if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$access12 = new PrivilegedUser();
if (!($access12->hasPrivilege("ManagePermission") || $access12->hasPrivilege("EditPermission") || $access12->hasPrivilege("DeletePermission") || $access12->hasPrivilege("AddPermission")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
/*
if (!$u->hasPrivilege("ManagePermissions")){
	Core::PageRedirect(SITE_ROOT);
}*/

?>
<!--Body content-->

<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark" style="margin-top: 1%;">
					<i class="fa fa-check"></i>
					<span class="caption-subject bold uppercase">Manage Permissions</span>
				</div>
				<?php
				if ($access12->hasPrivilege("AddPermission")) 
   { ?>
			<div class="margin-top-10">
				<a href="<?php echo SITE_ROOT; ?>/permission/addEdit" class="btn green" name="submit" value="" style="float: right; margin: 0%;">ADD PERMISSION</a>
			</div>
   <?php }
   ?>
			
				<div class="tools"> </div>
			</div>
			<div class="portlet-body">
				<div id="sample_1_wrapper" class="dataTables_wrapper no-footer"><div class="table-scrollable">
				<table id="permissionlisting" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>NO</th>
							<th>Permission Description</th>			
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
	$('#menupermission').addClass('active');
});

    jQuery(document).ready(function($){
		
	});
	
	function deleteData(id)
	{
		var r=confirm("Are you sure you want to delete this record?");
		if (r==true)
		{
			window.location.href="permission/delete?id="+id;
		}
	}
	$(document).ready(function() {
		var table =  $('#permissionlisting').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?=BASEPATH."/permission/fetch";?>",
			columnDefs: [
				{ targets: 'no-sort', orderable: false }
			],
			initComplete : function () {
			table.buttons().container()
				   .appendTo( $('#permissionlisting_wrapper .col-sm-6:eq(1)'));
		},
		buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
	 });
	} );
	
</script>