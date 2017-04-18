<div class="main" style="float: left; width: 100%; background:#F7F7F7;">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12" style="background-color:#fff;padding:10px; margin-top: 30px;">
					<div class="widget" style="background-color:#fff;padding:10px;">
						<div class="widget-header" style="border-bottom:1px solid #D9D8D8;padding:5px;">
							<p style="font-size:16px;font-weight:600;">Reset Password</p>
						</div>
						<!-- End .heading-->
						<!-- Build page from here: -->
							<div class="col-md-6">
                        	<div class="row">
                        	<div class="portlet-body form" style="margin-left: 20px;padding-top: 20px;">
											<!-- BEGIN FORM-->
											<form method="post" name="form-validate" id="form-validate">
												<div class="form-body">						
													<div class="row">
														<div class="col-md-8">
															<div class="form-group">
																<label class="control-label">New Password</label>
                                                                <div class="controls">
																	 <input type="password" minlength="6" id="new_password" name="new_password" value="" placeholder="New Password" class="password-field required form-control " />
                                                                </div> <!-- /controls -->
															</div>
														</div>
														
														<div class="col-md-8">
															<div class="form-group">
																<label class="control-label">Confirm Password</label>
                                                                <div class="controls">
																	<input type="password" minlength="6" equalTo="#new_password" id="cnf_password" name="cnf_password" value="" placeholder="Confirm Password" class="login password-field required form-control"/>
																	<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>"/>
																	<input type="hidden" name="token" id="token" value="<?php echo $_REQUEST['token']; ?>"/>
                                                                </div> <!-- /controls -->
															</div>
														</div>
													</div>
                                                <br>
												<div class="col-md-6 col-md-offset-3" style="margin-bottom:40px;">
													<button type="submit" class="btn btn-success btn-lg">Submit</button>
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
			<!-- /row --> 
		</div>
		<!-- /container --> 
	</div>
</div>

<script>
    jQuery(document).ready(function($){
		document.title = "Reset Password | Vettree Files";
	});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#form-validate').validate({
		submitHandler: function(form) {
			jQuery(form).ajaxSubmit({
				url: 'changepass',
				beforeSubmit: function (formData, jqForm, options) {						
					jQuery(form).find('input[type="submit"]').show();
					jQuery('#msg_wait').show();
				},
				dataType: 'json',
				clearForm: false,
				success: function (resObj, statusText) {
					jQuery('#msg_wait').hide();
					jQuery(form).find('input[type="submit"]').show();
					
					if (resObj.msg == "success") 
					{
						jQuery(form).clearForm();
						window.location = '<?php echo BASEPATH; ?>';
					}	
					else
					{
						jQuery('#displayMsg').show();				
						jQuery('#displayMsg').html(resObj.msg);
						jQuery("#displayMsg").addClass("bg-danger");
						window.setTimeout(function() { jQuery('#displayMsg').hide(); }, 5000);
						jQuery("html,body").scrollTop(0);
						return false;
					}					
				},
				error: function(){
				}
			});
		}
	});
});
</script>