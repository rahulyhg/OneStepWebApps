<?php
$result= array();
$act = "add";
$heading = "Add User";
$url_prams = array();
if(!isset($_SESSION["webadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$db = new Db();
if(isset($_SESSION["webadmin"]["id"]))
{
	$user_id = $_SESSION["webadmin"]["id"];

	$rs = $db->FetchRow("tbl_user_master","id",$user_id);
	if($rs != null )
	{
		$heading = "Update";
		$result = mysql_fetch_array($rs);
		$act = "Edit";	
		$baserole_image = $db->FetchCellValue("tbl_user_clinic_relation","role_id","clinic_id = 1 AND user_id = '".$_SESSION["webadmin"]["id"]."'");
	}
	
	$rs1 = $db->FetchRow("tbl_clinic_master","id",$_SESSION['webadmin1']['clinic_id']);
	if($rs1 != null )
	{
		$result2 = mysql_fetch_array($rs1);
	}
}
?>
<style>
tr.odd{background-color:#fff!important;}
tr.even{background-color:#e5eff5!important;}
.odd td{border-color:#e7e7e7!important;}
.even td{border-color:#e7e7e7!important;}
#mytable_wrapper{border: 1px solid #e7e7e7;border-top: 0px;}
</style>
<!--Body content-->
<div class="main" style="float: left; width: 100%; background:#F7F7F7;">
	<div class="main-inner">
		<div class="container">
			<div class="row">
			<div class="col-md-6">
				<div class="col-md-12" style="background-color:#fff;padding:10px;margin: 30px 2% 2%;width: 96%;">
					<div class="widget" style="background-color:#fff;padding:10px;">
						<div class="col-md-12">
                        	<div class="row"  style="margin-right: 5px;">
                        	<div class="portlet-body form" style="margin-left: 20px;padding-top: 20px;">
											<!-- BEGIN FORM-->
											<div class="widget-header" style="border-bottom:1px solid #D9D8D8;padding:5px;">
												<p style="font-size:16px;font-weight:600;">PERSONAL INFORMATION</p>   
											  </div>
											  <div style="clear:both;float:left;width:100%;height:5px;"></div>
											<form class="horizontal-form" id="form-validate" enctype="multipart/form-data" method="post">
												<div class="form-body">						
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label">First Name</label>
                                                                <div class="controls">
																	<input type="text" class="form-control" value="<?php if(isset($result['first_name']))echo $result['first_name'];?>" id="first_name" name="first_name" placeholder="First Name">
																	<input class="span2" id="id" name="id" type="hidden" value="<?php if(isset($result['id']))echo $result['id'];?>"/>
                                                                </div> <!-- /controls -->
															</div>
														</div>
														
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label">Last Name</label>
                                                                <div class="controls">
																	<input type="text" value="<?php if(isset($result['last_name']))echo $result['last_name'];?>" id="last_name" name="last_name" class="form-control" placeholder="Last Name">
                                                                </div> <!-- /controls -->
															</div>
														</div>
														
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label">Nick Name</label>
                                                                <div class="controls">
																	<input type="text" value="<?php if(isset($result['nick_name']))echo $result['nick_name'];?>" id="nick_name" name="nick_name" class="form-control" placeholder="Nick Name">
                                                                </div> <!-- /controls -->
															</div>
														</div>
														
														<div class="col-md-12">
															<div class="form-group">
																<label class="control-label">Photo</label>
																<div class="controls">
																	<input type="file" id="thumbnail" name="thumbnail" class="form-control" style="float:left;width:50%;margin-right:20px;">
																	<?php 
																		if(isset($result['profile_image']) && $result['profile_image'] != "")
																		{
																			$selected = $baserole_image;
																		}
																		echo "<img src='".BASEPATH."/uploads/".$result['profile_image']."' style='float:left;width:50px;height:50px;display:none;'/>";
																	?>
																</div> <!-- /controls --> 
															</div>
														</div>
							
													<!--	<div class="col-md-12">
															<label for="role_id" class="control-label">Type</label>
																<select class="select2_category form-control" data-placeholder="Gender" tabindex="1" id="role_id" name="role_id">
																	<option value="">Select one...</option>
																	<?php 
																		if(isset($baserole_image) && $baserole_image != "")
																		{
																			$selected = $baserole_image;
																		}
																		echo $db->CreateOptions("html", "tbl_role_master", array("id","role_name"), $selected);
																	?>
																</select>
														</div> -->
							
														<div class="col-md-12">
															<label for="gender" class="control-label">Gender</label>
																<select class="select2_category form-control" data-placeholder="Gender" tabindex="1" id="gender" name="gender">
																	<option value="">Select one...</option>
																	<option <?php if(isset($result['gender']) && $result['gender']=="Male")echo "selected";?> value="Male">Male</option>
																	<option <?php if(isset($result['gender']) && $result['gender']=="Female")echo "selected";?> value="Female">Female</option>
																</select>
														</div>
							
												<!--		<div class="col-md-12">
															<div class="form-group">
																<label class="control-label">Email Id</label>
																<div class="controls">
																	<input type="text" value="<?php if(isset($result['email']))echo $result['email'];?>" id="email" name="email" class="form-control email" placeholder="Email Id">
																</div> <!-- /controls --> 
												<!--			</div>
														</div> -->
														
														
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label">Date of Birth</label>
																<div class="controls">
																	<input type="text" value="<?php if(isset($result['dob']))echo $result['dob'];?>" id="dob" name="dob" class="form-control" placeholder="Date of Birth" style="float:left;">
																</div> <!-- /controls --> 
															</div>
														</div>
							
														<div class="col-md-12">
															<div class="form-group">
																<label class="control-label">Phone Number</label>
																 <div class="controls">
																	<input type="text" value="<?php if(isset($result['phone_no']))echo $result['phone_no'];?>" id="phone_no" name="phone_no" class="form-control number" placeholder="Phone Number" minlength="10" maxlength=10 />
																</div> <!-- /controls -->	
															</div>
														</div>
														<div class="row">
															<div class="col-md-12">
																<div class="col-md-6">
																	<label for="address" class="control-label">Address</label>
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result['address']))echo $result['address'];?>" id="address" name="address" class="form-control" placeholder="Number">
																	</div> <!-- /controls -->
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<label for="address" class="control-label">&nbsp;</label>
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result['street']))echo $result['street'];?>" id="street" name="street" class="form-control" placeholder="Street">
																	</div> <!-- /controls -->
																</div>
																<div style="clear:both;height:10px;"></div>
																<div class="col-md-6">
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result['province']))echo $result['province'];?>" id="province" name="province" class="form-control" placeholder="Province">
																	 </div> <!-- /controls -->
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result['country']))echo $result['country'];?>" id="country" name="country" class="form-control" placeholder="Country">
																	</div> <!-- /controls -->
																</div>
																<div style="clear:both;height:10px;"></div>
																<div class="col-md-6">
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result['pincode']))echo $result['pincode'];?>" id="pincode" name="pincode" class="form-control" placeholder="Postal Code">
																	 </div> <!-- /controls -->
																</div>
															</div>
														</div>
													</div>
                                                <br>
												<div class="col-md-6" style="padding-left: 0;margin-bottom:20px;">
												<?php if ($access->hasPrivilege("ManageSettingsProfile") && $_SESSION["webadmin1"]["clinic_status"]==1) { ?>
													<button type="submit" class="btn btn-success btn-lg">Save</button>
												<?php } ?>
												</div>
											</form>
											<!-- END FORM-->
										</div>
                        			</div>
                                  </div>
					
						<!-- End .row-fluid -->
						<!-- Page end here -->
                        
                        
					</div>
				</div>
				<div style="clear:both;height:10px;"></div>
				<!-- /span12 -->
			</div>
			<div class="col-md-12" style="background-color:#fff;padding:10px;margin: 45px 2% 2%;width: 96%;">
					<div class="widget" style="background-color:#fff;padding:10px;">
						<div class="col-md-12">
                        	<div class="row"  style="margin-right: 5px;">
                        	<div class="portlet-body form" style="margin-left: 20px;padding-top: 20px;">
											<!-- BEGIN FORM-->
											<div class="widget-header" style="border-bottom:1px solid #D9D8D8;padding:5px;">
												<p style="font-size:16px;font-weight:600;">CHANGE PASSWORD</p>   
											  </div>
											  <div style="clear:both;float:left;width:100%;height:5px;"></div>
											<form class="horizontal-form" id="password-validate" enctype="multipart/form-data" method="post">
												<div class="form-body">
													<div class="row">
														<div class="col-md-12">
                                                             <label for="old_password" class="control-label">Old Password</label>
                                                        <div class="controls">
															<input type="password" id="old_password" name="old_password" class="form-control" placeholder="Old Password">
                                                        </div> <!-- /controls -->	
														</div>
													</div>
													<!--/row-->
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label class="control-label">Password</label>
                                                                 <div class="controls">
																	<input type="password" minlength="6" id="new_password" name="new_password" value="" placeholder="New Password" class="password-field required form-control" />
                                                           		</div> <!-- /controls -->	
															</div>
														</div>
														<!--/span-->
													</div>
													
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label class="control-label">Confirm Password</label>
                                                                 <div class="controls">
																	<input type="password" minlength="6" equalTo="#new_password" id="password" name="password" value="" placeholder="Confirm Password" class="login password-field required form-control"/>
                                                           		</div> <!-- /controls -->	
															</div>
														</div>
														<!--/span-->
													</div>
												</div>
                                                <br>
												<div class="col-md-6" style="padding-left: 0;margin-bottom:20px;">
												<?php if ($access->hasPrivilege("ManageChangePassword") && $_SESSION["webadmin1"]["clinic_status"]==1) { ?>
													<button type="submit" class="btn btn-success btn-lg">Save</button>
												<?php } ?>
												</div>
											</form>
											<!-- END FORM-->
										</div>
                        			</div>
                                  </div>
					
						<!-- End .row-fluid -->
						<!-- Page end here -->
                        
                        
					</div>
				</div>
			</div>
			<div class="col-md-6">
			<!-- /row --> 
			<?php if ($_SESSION['webadmin1']['role_id']=="2") { ?>
			<div class="col-md-12" style="background-color:#fff;padding:10px;margin: 30px 2% 2%;width: 96%;">
					<div class="widget" style="background-color:#fff;padding:10px;">
						<div class="col-md-12">
                        	<div class="row" style="margin-right: 5px;">
                        	<div class="portlet-body form" style="margin-left: 20px;padding-top: 20px;">
											<!-- BEGIN FORM-->
											<div class="widget-header" style="border-bottom:1px solid #D9D8D8;padding:5px;">
												<p style="font-size:16px;font-weight:600;">CLINIC INFORMATION</p>   
											  </div>
											  <div style="clear:both;float:left;width:100%;height:5px;"></div>
											<form class="horizontal-form" id="clinic-validate" enctype="multipart/form-data" method="post">
												<div class="form-body">
													<div class="row">
														<div class="col-md-8">
                                                             <label for="clinic_name" class="control-label">Clinic Name</label>
                                                        <div class="controls">
															<input type="text" value="<?php if(isset($result2['clinic_name']))echo $result2['clinic_name'];?>" id="clinic_name" name="clinic_name" class="form-control" placeholder="Clinic Name">
                                                        </div> <!-- /controls -->	
														</div>
														<!--/span-->
														<div class="col-md-4">
															<?php if(isset($result2['thumbnail'])){
																	echo "<img src='".BASEPATH."/uploads/".$result2['thumbnail']."' style='float:left;width:50px;height:50px;'/>";
																} else { ?>
															<!-- <img src="<?php echo IMAGES;?>/logo.jpg" class="img-responsive" alt="" /> -->
															<?php } ?>
														</div>
														<!--/span-->
													</div>
													<!--/row-->
													<div class="row">
														<div class="col-md-12">
															
                                                               <div class="col-md-6" style="padding-left: 0px;">
																	<label for="address" class="control-label">Address</label>
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result2['address']))echo $result2['address'];?>" id="clinic_address" name="clinic_address" class="form-control" placeholder="Number">
																	 </div> <!-- /controls -->
																</div>
																<!--/span-->
																<div class="col-md-6"  style="padding: 0px;">
																	<label for="address" class="control-label">&nbsp;</label>
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result2['street']))echo $result2['street'];?>" id="clinic_street" name="clinic_street" class="form-control" placeholder="Street">
																	</div> <!-- /controls -->
																</div>
																<div style="clear:both;height:10px;"></div>
																<div class="col-md-6"  style="padding-left: 0px;">
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result2['province']))echo $result2['province'];?>" id="clinic_province" name="clinic_province" class="form-control" placeholder="Province">
																	 </div> <!-- /controls -->
																</div>
																<!--/span-->
																<div class="col-md-6" style="padding: 0px;">
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result2['country']))echo $result2['country'];?>" id="clinic_country" name="clinic_country" class="form-control" placeholder="Country">
																	</div> <!-- /controls -->
																</div>
																<div style="clear:both;height:10px;"></div>
																<div class="col-md-6" style="padding-left: 0px;">
																	<div class="controls">
																		<input type="text" value="<?php if(isset($result2['pincode']))echo $result2['pincode'];?>" id="clinic_pincode" name="clinic_pincode" class="form-control" placeholder="Postal Code">
																	 </div> <!-- /controls -->
																</div>
														</div>
													</div>
													<!--/row-->
                                                    <div style="clear:both;height:10px;"></div>
                                                    <div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label class="control-label">Phone Number</label>
                                                                 <div class="controls">
																	<input type="text" value="<?php if(isset($result2['phone_no']))echo $result2['phone_no'];?>" id="clinic_phone_no" name="clinic_phone_no" class="form-control number" maxlength=10 minlength=10 placeholder="Phone Number">
                                                           		</div> <!-- /controls -->	
															</div>
														</div>
													</div>
													<!--/row-->
													<div class="row" style="display:none;">
														<div class="col-md-6">
															<label for="contact_no" class="control-label">Map Location</label>
                                                            <div class="controls">
                                                                <input type="text" value="<?php if(isset($result2['map_lattitude']))echo $result2['map_lattitude'];?>" id="map_lattitude" name="map_lattitude" class="form-control" placeholder="Lattitude">
                                                             </div> <!-- /controls -->
														</div>
														<!--/span-->
														<div class="col-md-6">
                                                        <label for="contact_no" class="control-label">Longitude</label>
															<div class="controls">
                                                                <input type="text" value="<?php if(isset($result2['map_longitude']))echo $result2['map_longitude'];?>" id="map_longitude" name="map_longitude" class="form-control" placeholder="Longitude">
                                                            </div> <!-- /controls -->
														</div>
													</div>
													
												</div>
                                                <br>
												<div class="col-md-6" style="padding-left: 0;margin-bottom:20px;">
													<button type="submit" class="btn btn-success btn-lg">Save</button>
												</div>
											</form>
											<!-- END FORM-->
											<a href="<?php echo SITE_ROOT;?>/clinic/payment" class="btn btn-primary btn-lg pull-right" style="background:#3d5c87;border-color:#3d5c87;">Upgrade Subscription</a>
										</div>
                        			</div>
                                  </div>
					
						<!-- End .row-fluid -->
						<!-- Page end here -->
                        
                        
					</div>
				</div>
				<?php } ?>
				
				<?php if ($_SESSION['webadmin1']['role_id']=="2" || $_SESSION['webadmin1']['role_id']=="3" || $_SESSION['webadmin1']['role_id']=="4") { ?>
				<div class="col-md-12" style="background-color:#fff;padding:10px;margin: 45px 2% 2%;width: 96%;">
					<div class="widget" style="background-color:#fff;padding:10px;">
						<div class="col-md-12">
                        	<div class="row" style="margin-right: 5px;">
								<div class="portlet-body form" style="margin-left: 20px;padding-top: 20px;">
									<div class="widget-header" style="border-bottom:1px solid #D9D8D8;padding:5px;">
										<p style="font-size:16px;font-weight:600;">APPOINTMENT SETTINGS</p>   
									</div>
									<div style="clear:both;float:left;width:100%;height:20px;"></div>
									<div class="col-md-12" style="padding-left: 0;padding-right:0;margin-bottom:20px;">
										<span style="color:black;margin-top: 12px;float: left;">Reserved Timelots(Don't take appointments)</span>
										<?php if ($access->hasPrivilege("AddNewAppointment") && $_SESSION["webadmin1"]["clinic_status"]==1) { ?>
										<button href="#addappointment" role="button" data-toggle="modal" class="btn btn-primary btn-lg pull-right" style="background:#3d5c87;border-color:#3d5c87;">Add</button>
										<?php } ?>
									</div>
									<div class="row" style="margin:0;">
										<div class="widget-content">
											<table id="mytable" cellpadding="0" callfunction="<?=BASEPATH."/users/fetchAppointment2"?>" cellspacing="0" border="0" class="responsive dynamicTable display nofilter table table-bordered" width="100%">
												<thead>
													<tr style="background:#2185c5;">
														<th width="40%" data-bSortable="false" style="color:white;border-color:#2185c5;">Date</th>
														<th width="30%" data-bSortable="false" style="color:white;border-color:#2185c5;">From</th>
														<th width="30%" data-bSortable="false" style="color:white;border-color:#2185c5;">To</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
												</tfoot>
											</table>
											<div style="clear:both;height:20px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				</div>
				
				<div style="clear:both;height:10px;"></div>
				<!-- /span12 -->
			</div>
		</div>
		<!-- /container --> 
	</div>
</div>

<div class="login-extra">
	<div id="addappointment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:440px;width:20%;margin:auto;">
		<form method="post" name="addappointment1" id="addappointment1" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">ADD Time Slots</h3>
			</div>
			<div class="modal-body">
				<div class="login-fields">
					<div class="field">
					  <label for="item_name">Doctor Name</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" tabindex="1" id="user_id" name="user_id">
							<option value="">Select Doctor</option>
							<?php 
								if(isset($result['user_id']) && $result['user_id'] != "")
								{
									$selected = $result['user_id'];
								}
								$join_tables = array(
									array('left','tbl_user_master r','r.id = i.user_id', array('r.first_name as first_name','r.last_name as last_name'))
								);
								echo $db->CreateOptions2("html", "tbl_user_clinic_relation", array("i.user_id","CONCAT(first_name,' ',last_name)"), $join_tables, $selected,"","(i.role_id='3' OR i.role_id='2') && i.clinic_id = ".$_SESSION['webadmin1']['clinic_id']." && i.user_id = ".$_SESSION['webadmin']['id']);
							?>								
						</select>
						<script>
						$('#user_id').searchableOptionList();
						</script>
					</div>
					<div style="clear:both;height:10px;"></div>
					<div class="field">
					  <label for="item_name">Select Date</label>
						<input type="text" class="select2_category form-control required" placeholder="Select Date" id="date" name="date"/>
					</div>
					<div style="clear:both;height:10px;"></div>		
					<div class="field">
					  <label for="item_name">Appointment Start From</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" id="time_slot_start" name="time_slot_start">
							<option value="">Select Start Time</option>
							<?php 
								$selected = "";
								echo $db->CreateOptions("html", "tbl_timeslots", array("id","times"), $selected,array('id' => 'asc'));
							?>								
						</select>
					</div>
					<div style="clear:both;height:10px;"></div>
					<div class="field">
					  <label for="item_name">Appointment End To</label>
						<select class="select2_category form-control required" data-placeholder="Change subscription plans from here" id="time_slot_end" name="time_slot_end">
							<option value="">Select End Time</option>
							<?php 
								$selected1 = "";
								echo $db->CreateOptions("html", "tbl_timeslots", array("id","times"), $selected1,array('id' => 'asc'));
							?>								
						</select>
					</div>
					<div style="clear:both;height:10px;"></div>		
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<?php if ($access->hasPrivilege("AddNewAppointment") && $_SESSION["webadmin1"]["clinic_status"]==1) { ?>
				<input type="submit" class="btn btn-primary" value="Submit">
				<?php } ?>
			</div>
		</form>
	</div>
</div>

<script>

var vRules = {
	first_name:{required:true},
	last_name:{required:true},
	email:{required:true},
	user_name:{required:true},
	role_id:{required:true},
	contact_no:{required:true}
};
var vMessages = {
	first_name:{required:"Please enter first name"},
	last_name:{required:"Please enter last name"},
	email:{required:"Please enter email id"},
	user_name:{required:"Please enter user name"},
	role_id:{required:"Please select user type"},
	contact_no:{required:"Please enter contact no"}
};

$("#form-validate").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/users/addEdit', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{					
					window.location.href="<?php echo SITE_ROOT;?>/users/settings";
				}
				else
				{						
					displayMsg("error",res['msg']);
					return false;
				}
				$("#loading").css('display','none');
			}
		});
	}
});

var vRulesP = {
	old_password:{required:true},
	password:{required:true},
	new_password:{required:true}
};
var vMessagesP = {
	old_password:{required:"Please enter Old Password"},
	password:{required:"Please enter Confirm Password"},
	new_password:{required:"Please enter New Password"}
};

$("#password-validate").validate({
	rules: vRulesP,
	messages: vMessagesP,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/users/changepassword', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{					
					window.location.href="<?php echo SITE_ROOT;?>/users/settings";
				}
				else
				{						
					displayMsg("error",res['msg']);
					return false;
				}
				$("#loading").css('display','none');
			}
		});
	}
});


var vRulesC = {
	clinic_name:{required:true},
	clinic_address:{required:true},
	clinic_country:{required:true},
	clinic_phone_no:{required:true},
	clinic_pincode:{required:true},
	clinic_province:{required:true},
	clinic_street:{required:true}/*,
	map_lattitude:{required:true},
	map_longitude:{required:true}*/
};
var vMessagesC = {
	clinic_name:{required:"Please enter Clinic name"},
	clinic_address:{required:"Please enter Clinic address"},
	clinic_country:{required:"Please enter Country"},
	clinic_phone_no:{required:"Please enter Phone Number"},
	clinic_pincode:{required:"Please enter Pincode"},
	clinic_province:{required:"Please enter province"},
	clinic_street:{required:"Please enter Street"}/*,
	map_lattitude:{required:"Please enter Lattitude"},
	map_longitude:{required:"Please enter Longitude"}*/
};


$("#clinic-validate").validate({
	rules: vRulesC,
	messages: vMessagesC,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/clinic/update', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{					
					window.location.href="<?php echo SITE_ROOT;?>/users/settings";
				}
				else
				{						
					displayMsg("error",res['msg']);
					return false;
				}
				$("#loading").css('display','none');
			}
		});
	}
});

var vRulesApp2 = {
	date:{required:true},
	time_slot_start:{required:true},
	time_slot_end:{required:true},
	user_id:{required:true}
};
var vMessagesApp2 = {
	date:{required:"Please select the date"},
	time_slot_start:{required:"Please select start time"},
	time_slot_end:{required:"Please select End time"},
	user_id:{required:"Please Select Doctor"}
};

jQuery("#addappointment1").validate({
	rules: vRulesApp2,
	messages: vMessagesApp2,
	submitHandler: function(form) {        
		jQuery("#loading").css('display','block');
		jQuery(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/users/addtimeslots', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {                    
				var res = eval('('+response+')');
				if(res['msg'] =="success")
				{                    
					location.reload();
				}
				else
				{                        
					displayMsg("error",res['msg']);
					return false;
				}
				jQuery("#loading").css('display','none');
			}
		});
	}
});

$(function(){
	$("#first_name").focus();
	$("#dob").datepicker({});
	var dateToday = new Date();
	$("#date").datepicker({minDate: dateToday});
	document.title="Settings | Vettre"
});
</script>