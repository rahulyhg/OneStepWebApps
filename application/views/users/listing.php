<?php 
$result= array();
if(!isset($_SESSION["webadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}

?>
<!--Body content-->

<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget">
						<br>
						<?php
							
							$table = "tbl_user_master";
							$table_id = 'id';
							$condition = "r.clinic_id = ".$_SESSION['webadmin1']['clinic_id']." && r.role_id in('3','4') " ;
							
							$main_table = array("$table i",array("i.*"));
							$join_tables = array(
								array('left','tbl_user_clinic_relation r','r.user_id = i.id', array())
							);
							
							$totalRs = $db->JoinFetch($main_table, $join_tables, $condition);
							$totalRecords = @mysql_num_rows($totalRs);
		
							if ($access->hasPrivilege("AddNewStaff") && ($totalRecords < $_SESSION["webadmin1"]["subscription_obj"]["no_of_staff"] || $_SESSION["webadmin1"]["subscription_obj"]["no_of_staff"]==0 )) { ?>
						<a href="<?php echo SITE_ROOT?>/users" role="button" data-toggle="modal" class="btn btn-primary btn-lg" style="width: 20%;float:right;"><i class="fa fa-plus"></i> &nbsp; New Staff</a>
						<?php } ?>
						<br>
						<!-- End .heading-->
						<!-- Build page from here: -->
						<div class="widget-content">
							<div style="clear:both;height:30px;"></div>
							<table cellpadding="0" callfunction="<?=BASEPATH."/users/fetch"?>" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
								<thead>
									<tr>
										<th width="17%">STAFF NAME</th>
										<th width="15%">EMAIL</th>
										<th width="13%">PHONE</th>
										<th width="10%">GENDER</th>
										<th width="15%">DATE OF BIRTH</th>
										<th width="15%">Actions</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
								</tfoot>
							</table>
							<div style="clear:both;height:20px;"></div>
						</div>
						<!-- End .row-fluid -->
						<!-- Page end here -->
						<div style="clear:both;height:10px;"></div>
					</div>
				</div>
				<!-- /span12 -->
			</div>
			<!-- /row --> 
			<div style="clear:both;height:20px;"></div>
		</div>
		<!-- /container --> 
	</div>
</div>
<script>
    jQuery(document).ready(function($){
		document.title = "Staff | Vettree";
	});
	
	function deleteData(id)
	{
    	var r=confirm("Are you sure you want to delete this record?");
    	if (r==true)
   		{
    		window.location.href="<?=SITE_ROOT;?>/users/delete?id="+id;
    	}
    }
	
	
</script>