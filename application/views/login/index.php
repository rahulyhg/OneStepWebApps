<style>
.display-hide, .display-none {
    display: none;
}
.alert {
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-right-width: 1px;
    border-top-width: 1px;
}
.alert-danger {
    background-color: rgb(251, 225, 227);
    border-bottom-color: rgb(251, 225, 227);
    border-left-color: rgb(251, 225, 227);
    border-right-color: rgb(251, 225, 227);
    border-top-color: rgb(251, 225, 227);
    color: rgb(231, 61, 74);
}
.alert {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-bottom-style: solid;
    border-image-outset: 0 0 0 0;
    border-image-repeat: stretch stretch;
    border-image-slice: 100% 100% 100% 100%;
    border-image-source: none;
    border-image-width: 1 1 1 1;
    border-left-style: solid;
    border-right-style: solid;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    border-top-style: solid;
    padding-bottom: 15px;
    padding-left: 15px;
    padding-right: 15px;
    padding-top: 15px;
}
.alert, .thumbnail {
    margin-bottom: 20px;
}

button.close {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-attachment: scroll;
    background-clip: border-box;
    background-color: rgba(0, 0, 0, 0);
    background-image: none;
    background-origin: padding-box;
    background-position-x: 0;
    background-position-y: 0;
    background-repeat: repeat;
    background-size: auto auto;
    border-bottom-color: -moz-use-text-color;
    border-bottom-style: none;
    border-bottom-width: 0;
    border-image-outset: 0 0 0 0;
    border-image-repeat: stretch stretch;
    border-image-slice: 100% 100% 100% 100%;
    border-image-source: none;
    border-image-width: 1 1 1 1;
    border-left-color: -moz-use-text-color;
    border-left-style: none;
    border-left-width: 0;
    border-right-color: -moz-use-text-color;
    border-right-style: none;
    border-right-width: 0;
    border-top-color: -moz-use-text-color;
    border-top-style: none;
    border-top-width: 0;
    cursor: pointer;
    padding-bottom: 0;
    padding-left: 0;
    padding-right: 0;
    padding-top: 0;
}
.close {
    background-image: url("<?= SITE_ROOT; ?>/css/images/remove-icon-small.png") !important;
    background-repeat: no-repeat !important;
    display: inline-block;
    height: 9px;
    margin-right: 0;
    margin-top: 0;
    outline-color: -moz-use-text-color;
    outline-style: none;
    outline-width: 0;
    text-indent: -10000px;
    width: 9px;
}
.close {
    color: rgb(0, 0, 0);
    float: right;
    font-size: 21px;
    line-height: 1;
    opacity: 0.2;
    text-shadow: 0 1px 0 rgb(255, 255, 255);
}
.alert .alert-link, .close {
    font-weight: 700;
}
.btn, .btn-large{
	background:#009688;
}
.input-field .prefix.active{
	color:#009688;
}
.btn:hover, .btn-large:hover{
	background:#00897b!important;
}
input[type="text"]:focus:not([readonly]), input[type="password"]:focus:not([readonly]), input[type="email"]:focus:not([readonly]), input[type="url"]:focus:not([readonly]), input[type="time"]:focus:not([readonly]), input[type="date"]:focus:not([readonly]), input[type="datetime-local"]:focus:not([readonly]), input[type="tel"]:focus:not([readonly]), input[type="number"]:focus:not([readonly]), input[type="search"]:focus:not([readonly]), textarea.materialize-textarea:focus:not([readonly]){
	border-bottom-color:#009688!important;
	box-shadow:0 1px 0 0 #009688!important;
}
</style>
<div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel" style="padding: 0px;">
		<form method="post" class="login-form" enctype="multipart/form-data" name="login-form" id="login-form" action='<?=SITE_ROOT?>/login/loginvalidate'>
			<div class="row">
				<div class="logo" style="margin-top:20px;text-align:center;">
					<a href="">
						<img src="<?php echo IMAGES;?>/logo-white.png" alt="" / style="max-width:200px;width:100%;"> 
					</a>
				</div>
			</div>
			 <div id="displayMsg" class="alert alert-danger display-hide">
				<button class="close" data-close="alert"></button>
				<span> Enter any username and password. </span>
			</div>
			<div class="row margin">
			  <div class="input-field col s12">
				<i class="mdi-social-person-outline prefix"></i>
				<input id="username" name="username" type="text" autocomplete="off" placeholder="User Name"/>
				<!--<label for="username" class="center-align">Username</label>-->
			  </div>
			</div>
			<div class="row margin">
			  <div class="input-field col s12">
				<i class="mdi-action-lock-outline prefix"></i>
				<input id="password" type="password" name="password" placeholder="Password" autocomplete="off"/>
				<!--<label for="password">Password</label>-->
			  </div>
			</div>
			<div class="row">          
			  <div class="input-field col s12 m12 l12  login-text">
				  <input type="checkbox" id="remember-me" />
				  <label for="remember-me">Remember me</label>
			  </div>
			</div>
			<div class="row">
			  <div class="input-field col s12">
				<button type="submit" class="btn waves-effect waves-light col s12">Login</button>
			  </div>
			</div>
			<div class="row">
			  <div class="input-field col s6 m6 l6">
				<p class="margin medium-small"><a href="<?php echo SITE_ROOT."/login/signup"; ?>">Register Now!</a></p>
			  </div>
			  <div class="input-field col s6 m6 l6">
				  <p class="margin right-align medium-small"><a href="<?php echo SITE_ROOT."/login/forgetpass"; ?>">Forgot password ?</a></p>
			  </div>          
			</div>
		</form>
    </div>
  </div>
			<script>
			function displayMsg(type,msg)
			{
				var icon,title,icon = "";
				if(type=="1"){
					type="success";
					title = "Success Message";
					icon = 'picon icon16 iconic-icon-check-alt white';
				}else{
					type="error";
					title = "Error Message";
					icon = 'picon icon16 typ-icon-cancel white';
				}
				jQuery.pnotify_remove_all();
				jQuery.pnotify({
					type: type,
					title: title,
					text: msg,
					icon: icon,
					opacity: 0.95,
					hide:true,
					history: true,
					sticker: false
				});
			}
			
			jQuery(document).ready(function(){
				
				<?php if(!empty($_SESSION["samajadmin"]['msg'])){ ?>
					 Materialize.toast("<?php echo $_SESSION["samajadmin"]['msg']; ?>", 5000);
				<?php }
					unset($_SESSION["samajadmin"]['msg']);
				?>
				jQuery(document).ajaxSend(function(event, jqXHR, settings) {
					if(settings.url!="<?php echo BASEPATH;?>/users/fetchnotDetails" && settings.url!= "<?php echo BASEPATH;?>/users/lastseencall" && settings.url!= "../chat/chat_msg" && settings.url!= "../chat/onload")
						jQuery("#loading").css('display','block');
				});
				jQuery(document).ajaxComplete(function(event, jqXHR, settings) {
					jQuery("#loading").css('display','none');
				});
				jQuery( document ).ajaxError(function() {
					jQuery("#loading").css('display','none');
				});
				jQuery( document ).ajaxStop(function() {
					jQuery("#loading").css('display','none');
				});
				jQuery( document ).ajaxSuccess(function() {
					jQuery("#loading").css('display','none');
				});
				
				jQuery("#loading").css('display','none');
				
			var vRulesL = {
				username:{required:true},
				password:{required:true}
			};
			var vMessagesL = {
				username:{required:"Please enter email id"},
				password:{required:"Please enter password"}
			};
			var vRulesF = {
				reset_email:{required:true}
			};
			var vMessagesF = {
				reset_email:{required:"Please enter email id"}
			};
			
			jQuery("#login-form").validate({
				rules: vRulesL,
				messages: vMessagesL,
				submitHandler: function(form1) {		
					jQuery(form1).ajaxSubmit({
						url: '<?php echo SITE_ROOT; ?>/login/loginvalidate', 
						type: 'post',
						cache: false,
						enctype:"multipart/form-data",
						success: function (response) {					
							var res = eval('('+response+')');
							if(res['success'] == 1)
							{	
								jQuery('#displayMsg').hide();	
								location.href = "<?= SITE_ROOT; ?>/home";
							}
							else
							{		
								jQuery('#displayMsg').show();				
								jQuery('#displayMsg span').html(res['msg']);
								window.setTimeout(function() { jQuery('#displayMsg').hide(); }, 5000);
								jQuery("html,body").scrollTop(0);
								return false;
							}
							jQuery("#loading").css('display','none');
						}
					});
				}
			});
			jQuery("#forget-password").click(function(){
				jQuery(".login-form").hide(),jQuery(".forget-form").show()});
			jQuery("#back-btn").click(function(){
					jQuery(".login-form").show(),jQuery(".forget-form").hide()});
			
			jQuery("#forget-form").validate({
				rules: vRulesF,
				messages: vMessagesF,
				submitHandler: function(form) {        
					jQuery("#loading").css('display','block');
					jQuery(form).ajaxSubmit({
						url: 'login/forgotpass', 
						type: 'post',
						cache: false,
						enctype:"multipart/form-data",
						clearForm: false,
						success: function (response) {                    
							var res = eval('('+response+')');
							alert(res['success']);
							if(res['success']=="1")
							{                    
								window.location.href="<?php echo SITE_ROOT;?>";
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
			});
			</script>