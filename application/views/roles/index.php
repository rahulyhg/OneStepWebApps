<?php 
$result= array();
$act = "add";
$heading = "Manage Roles";

if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$access2= new  PrivilegedUser();
if (!($access2->hasPrivilege("ManageRole") || $access2->hasPrivilege("EditRole") || $access2->hasPrivilege("DeleteRole") || $access2->hasPrivilege("AddRole")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
?>
<!--Body content-->
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark" style="margin-top: 1%;">
					<i class="fa fa-key"></i>
					<span class="caption-subject bold uppercase">Manage Roles</span>
				</div>
				<?php
				if ($access2->hasPrivilege("AddRole")) 
   { ?>
			<div class="margin-top-10">
				<a href="<?php echo SITE_ROOT; ?>/roles/addEdit" class="btn green" name="submit" value="" style="float: right; margin: 0%;">ADD ROLE</a>
			</div>
   <?php }
   ?>
			
				<div class="tools"> </div>
			</div>
			<div class="portlet-body">
				<div id="sample_1_wrapper" class="dataTables_wrapper no-footer"><div class="table-scrollable">
				<table id="rolelisting" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>NO</th>
							<th>Role Name</th>			
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
    jQuery(document).ready(function($){
		
	});
	
	$(function(){
	$('#menurole').addClass('active');
	});
	
	function deleteData(id)
	{
		var r=confirm("Are you sure you want to delete this record?");
		if (r==true)
		{
			window.location.href="<?=SITE_ROOT; ?>/roles/delete?id="+id;
		}
	}
	
	$(document).ready(function() {
		$('#rolelisting').DataTable({
	  "processing": true,
			"serverSide": true,
	  "ajax": "<?=BASEPATH."/roles/fetch";?>",
	  columnDefs: [
	   { targets: 'no-sort', orderable: false }
	  ]
	 });
	} );
	
</script>