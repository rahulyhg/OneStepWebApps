<div class="main" style="float: left; width: 100%; background:#F7F7F7;">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12" style="background-color:#fff;padding:10px; margin-top: 30px;">
					<div class="widget" style="background-color:#fff;padding:10px;">
						<div class="widget-header" style="border-bottom:1px solid #D9D8D8;padding:5px;">
							<p style="font-size:16px;font-weight:600;">Verification</p>
						</div>
						<!-- End .heading-->
						<!-- Build page from here: -->
							<div class="col-md-6">
                  <div class="page-title">
					<?PHP
					$table = "tbl_user_master";
					$table_id = 'id';
					if(isset($_REQUEST['user_id']) && isset($_REQUEST['token']))
					{
						$condition = "status = '0' && token = '".$_REQUEST['token']."' && id= '".$_REQUEST['user_id']."' ";
						//$condition = "1 = 1";
						$check_name = $db->FunctionFetch($table, 'count', '*', $condition);
						if($check_name > 0 && isset($_REQUEST['clinic_id']))
						{
							$data = array();
							$data['status'] = 1;
							$data['token'] = '';
							$result = $db->Update($table,$data,$table_id,$_REQUEST['user_id']);
								if($result)
								{?>
									<h1>Verified Successfully</h1>
									<p> You have verified successfully. Now you can login here from the below link.</p>
								<?php }
								else
								{ ?>
									<h1>Verification Failed</h1>
									<p> Data updation is failed. Now you can login here from the below link.</p>
								<?php }
						}
						else{ ?>
							<h1>Verification Failed</h1>
								<p> Token is Invalid or user is not valid. Now you can login here from the below link.</p>
						<?php }
					}
					else
					{
					?>
						<h1>Verification Failed</h1>
						<p> Token is not set. Now you can login here from the below link.</p>
					<?php } ?>
					 <a href="<?php echo SITE_ROOT; ?>">Click Here</a>
                  </div>
                </div>
					
						<!-- End .row-fluid -->
						<!-- Page end here -->
                        
                        
					</div>
					<div style="clear:both;height:100px;"></div>
				</div>
				<!-- /span12 -->
			</div>
			<!-- /row --> 
		</div>
		<!-- /container --> 
	</div>
</div>
<script>
    jQuery(document).ready(function($){
		document.title = "Verification | Zoheny";
	});
</script>