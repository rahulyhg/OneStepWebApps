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
if(isset($_REQUEST["id"]))
{
	$user_id = $_REQUEST["id"];

	$rs = $db->FetchRow("tbl_user_master","id",$user_id);
	if($rs != null )
	{
		$heading = "Update";
		$result = mysql_fetch_array($rs);
		$act = "Edit";	
		$baserole_image = $db->FetchCellValue("tbl_user_clinic_relation","role_id","clinic_id = ".$_SESSION['webadmin1']['clinic_id']." AND user_id = '".$_REQUEST['id']."'");
	}
}
?>
<!--Body content-->
<script type="text/javascript" src="<?= JS; ?>/webcam.js"></script>
 <script>
        webcam.set_api_url( 'upload.php' );
        webcam.set_quality( 90 ); // JPEG quality (1 - 100)
        webcam.set_shutter_sound( true ); // play shutter click sound
        
        webcam.set_hook( 'onComplete', 'my_completion_handler' );
        
        function take_snapshot() {
            // take snapshot and upload to server
            document.getElementById('upload_results').innerHTML = 'Snapshot<br>'+
            '<img src="uploading.gif">';
            webcam.snap();
        }
        
        function my_completion_handler(msg) {
            // extract URL out of PHP output
            if (msg.match(/(http\:\/\/\S+)/)) {
                var image_url = RegExp.$1;
                // show JPEG image in page
                document.getElementById('upload_results').innerHTML = 
                    'Snapshot<br>' + 
                    '<a href="'+image_url+'" target"_blank"><img src="' + image_url + '"></a>';
                
                // reset camera for another shot
                webcam.reset();
            }
            else alert("PHP Error: " + msg);
        }
    </script>
<div class="main" style="float: left; width: 100%; background:#F7F7F7;">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12" style="background-color:#fff;padding:10px; margin-top: 30px;">
					<div class="widget" style="background-color:#fff;padding:10px;">
						<div class="widget-header" style="border-bottom:1px solid #D9D8D8;padding:5px;">
							<p style="font-size:16px;font-weight:600;"><?php echo $heading;?></p>
						</div>
						<!-- End .heading-->
						<!-- Build page from here: -->
							<div class="col-md-6">
                        	<div class="row">
                        	<div class="portlet-body form" style="margin-left: 20px;padding-top: 20px;">
											<!-- BEGIN FORM-->
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
							
												if (($access->hasPrivilege("AddNewStaff") && ($totalRecords < $_SESSION["webadmin1"]["subscription_obj"]["no_of_staff"] || $_SESSION["webadmin1"]["subscription_obj"]["no_of_staff"]==0 )) || isset($_REQUEST["id"])) {
											?>
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
														
														<div class="col-md-12">
															<div class="form-group">
																<label class="control-label">Photo</label>
																<div class="controls">
																	<input type="file" id="thumbnail" name="thumbnail" class="form-control" style="float:left;width:50%;margin-right:20px;">
																	<?php 
																		if(isset($result['profile_image']) && $result['profile_image'] != "")
																		{
																			$selected = $baserole_image;
																			echo "<img src='".BASEPATH."/uploads/".$result['profile_image']."' style='float:left;width:50px;height:50px;'/>";
																	
																		}
																	?>	
																</div> <!-- /controls
																<div style="width:100%;">OR</div>
																<div class="controls">
																	<a href="#addpayment" role="button" data-toggle="modal" class="btn btn-primary btn-lg" style="width: 300px;">&nbsp; Upload Via Webcam</a>
																	<div id="upload_results" class="border">
																		Snapshot<br>
																	</div>
																</div> --> 
															</div>
														</div>
							
														<div class="col-md-12">
															<label for="role_id" class="control-label">Type</label>
																<select class="select2_category form-control" data-placeholder="Gender" tabindex="1" id="role_id" name="role_id">
																	<option value="">Select one...</option>
																	<?php 
																		if(isset($baserole_image) && $baserole_image != "")
																		{
																			$selected = $baserole_image;
																		}
																		echo $db->CreateOptions("html", "tbl_role_master", array("id","role_name"), $selected,'','id not in ("1","2","5","6")');
																	?>
																</select>
														</div>
							
														<div class="col-md-12">
															<label for="gender" class="control-label">Gender</label>
																<select class="select2_category form-control" data-placeholder="Gender" tabindex="1" id="gender" name="gender">
																	<option value="">Select one...</option>
																	<option <?php if(isset($result['gender']) && $result['gender']=="Male")echo "selected";?> value="Male">Male</option>
																	<option <?php if(isset($result['gender']) && $result['gender']=="Female")echo "selected";?> value="Female">Female</option>
																</select>
														</div>
							
														<div class="col-md-12">
															<div class="form-group">
																<label class="control-label">Email Id</label>
																<div class="controls">
																	<input type="text" value="<?php if(isset($result['email']))echo $result['email'];?>" id="email" name="email" class="form-control email" placeholder="Email Id">
																</div> <!-- /controls --> 
															</div>
														</div>
														
														
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
																
																   <div class="col-md-6" style="padding-left: 0px;">
																		<label for="address" class="control-label">Address</label>
																		<div class="controls">
																			<input type="text" value="<?php if(isset($result['address']))echo $result['address'];?>" id="address" name="address" class="form-control" placeholder="Number">
																		 </div> <!-- /controls -->
																	</div>
																	<!--/span-->
																	<div class="col-md-6"  style="padding: 0px;">
																		<label for="address" class="control-label">&nbsp;</label>
																		<div class="controls">
																			<input type="text" value="<?php if(isset($result['street']))echo $result['street'];?>" id="street" name="street" class="form-control" placeholder="Street">
																		</div> <!-- /controls -->
																	</div>
																	<div style="clear:both;height:10px;"></div>
																	<div class="col-md-6"  style="padding-left: 0px;">
																		<div class="controls">
																			<input type="text" value="<?php if(isset($result['city']))echo $result['city'];?>" id="city" name="city" class="form-control" placeholder="City">
																		 </div> <!-- /controls -->
																	</div>
																	<div class="col-md-6"  style="padding: 0px;">
																		<div class="controls">
																			<input type="text" value="<?php if(isset($result['province']))echo $result['province'];?>" id="province" name="province" class="form-control" placeholder="Province">
																		 </div> <!-- /controls -->
																	</div>
																	<!--/span-->
																	<div style="clear:both;height:10px;"></div>
																	<div class="col-md-6" style="padding-left: 0px;">
																		<div class="controls">
																			<input type="text" value="<?php if(isset($result['country']))echo $result['country'];?>" id="country" name="country" class="form-control" placeholder="Country">
																		</div> <!-- /controls -->
																	</div>
																	
																	<div class="col-md-6" style="padding: 0px;">
																		<div class="controls">
																			<input type="text" value="<?php if(isset($result['pincode']))echo $result['pincode'];?>" id="pincode" name="pincode" class="form-control" placeholder="Postal Code">
																		 </div> <!-- /controls -->
																	</div>
															</div>
														</div>
													</div>
                                                <br>
												<div class="col-md-6 col-md-offset-3" style="margin-bottom:40px;">
												<?php if ($access->hasPrivilege("AddNewStaff")) { ?>
													<button type="submit" class="btn btn-success btn-lg">CREATE</button>
												<?php } ?>
												</div>
											</form>
											<?php }else{ ?>
												<div class='alert alert-danger' style='float:left;width:100%;text-align: center; margin: 20px;'><strong>You cannot add more new staffs. You have already reach your limits. </strong></div>
												<div style="clear:both;height:10px;"></div>
											<?php } ?>
											<!-- END FORM-->
										</div>
                        			</div>
                                  </div>
					
						<!-- End .row-fluid -->
						<!-- Page end here -->
                        
                        
					</div>
					<div style="clear:both;height:10px;"></div>
				</div>
				<div style="clear:both;height:10px;"></div>
				<!-- /span12 -->
			</div>
			<!-- /row --> 
		</div>
		<!-- /container --> 
	</div>
</div>

	<div id="addpayment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:white;float:left;height:400px;width:40%;margin:auto;">
		<form method="post" name="addpayment1" id="addpayment1" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close" aria-hidden="true"></i> </button>
				<h3 id="myModalLabel">Upload Photo</h3>
			</div>
			<div class="modal-body">
				<div class="login-fields">
					<div class="field">
						<script>
							document.write( webcam.get_html(320, 240) );
						</script>
				   </div>
				   <div style="clear:both;height:10px;"></div>		
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<input type="submit" class="btn btn-primary" onClick="return take_snapshot()" value="Submit">
			</div>
		</form>
	</div>
	
<script>

var vRules = {
	first_name:{required:true},
	last_name:{required:true},
	email:{required:true},
	user_name:{required:true},
	gender:{required:true},
	dob:{required:true},
	address:{required:true},
	street:{required:true},
	province:{required:true},
	city:{required:true},
	role_id:{required:true},
	country:{required:true},
	pincode:{required:true},
	phone_no:{required:true}
};
var vMessages = {
	first_name:{required:"Please enter first name"},
	last_name:{required:"Please enter last name"},
	email:{required:"Please enter email id"},
	thumbnail:{required:"Please Upload Thumbnail Image"},
	user_name:{required:"Please enter user name"},
	gender:{required:"Please select Gender"},
	dob:{required:"Please select Date Of Birth"},
	address:{required:"Please enter Address"},
	street:{required:"Please enter Street"},
	province:{required:"Please enter Province"},
	city:{required:"Please enter City"},
	country:{required:"Please enter country"},
	pincode:{required:"Please enter Postal Code"},
	role_id:{required:"Please Select Role"},
	phone_no:{required:"Please enter contact no"}
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
				{	window.location.href="<?php echo SITE_ROOT;?>/users/listing";
				}
				else
				{	displayMsg("error",res['msg']);
					return false;
				}
				$("#loading").css('display','none');
			}
		});
	}
});
$(function(){
	$("#first_name").focus();
	$("#dob").datepicker({changeMonth: true,
		changeYear: true,yearRange: "-100:+0"});
	document.title="<?php echo $heading;?> | Vettre"
});
</script>