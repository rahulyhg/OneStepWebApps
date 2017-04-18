<?php
$result= array();
$base_image_path = "";
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$access2 = new PrivilegedUser();
if(!($access2->hasPrivilege("AddEmailAndNotification") || $access2->hasPrivilege("ManageEmailAndNotification")))
{
	Core::PageRedirect(SITE_ROOT_DASHBOARD);
}
?>
<style>
.multiselect-container label{
	color : #A8A89A;
}
.multiselect-container{
	max-height: 200px;
    overflow-y: scroll;
}
.multiselect-container{
	min-width:50%!important;
}
</style>
<link rel="stylesheet" href="<?php echo CSS; ?>/bootstrap-multiselect.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/froala_editor.min.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/froala_style.min.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/code_view.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/colors.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/emoticons.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/image_manager.min.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/image.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/line_breaker.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/table.min.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/char_counter.min.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/video.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/fullscreen.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/file.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/quick_insert.css">
<link rel="stylesheet" href="<?php echo CSS; ?>/codemirror.min.css">

<link href="<?php echo CSS; ?>/tokenize2.css" rel="stylesheet" />

<script type="text/javascript" src="<?php echo JS; ?>/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/codemirror.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/xml.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/froala_editor.min.js" ></script>
<script type="text/javascript" src="<?php echo JS; ?>/align.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/char_counter.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/code_beautifier.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/code_view.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/colors.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/draggable.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/emoticons.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/entities.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/file.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/font_size.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/font_family.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/fullscreen.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/image.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/image_manager.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/line_breaker.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/inline_style.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/link.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/lists.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/paragraph_format.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/paragraph_style.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/quick_insert.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/quote.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/table.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/save.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/url.min.js"></script>
<script type="text/javascript" src="<?php echo JS; ?>/video.min.js"></script>

<script src="<?php echo JS; ?>/tokenize2.js"></script>
<style>
.multiselect-container.dropdown-menu{height: 300px !important;
    overflow-y: scroll !important;}
</style>
<script>
jQuery(document).ready(function(){
	$(function(){
        $('#content')
          .on('froalaEditor.initialized', function (e, editor) {
			htmlDoNotWrapTags: ['script', 'style', 'img'],
			htmlAllowedTags: ['a', 'abbr', 'address', 'area', 'article', 'aside', 'audio', 'b', 'base', 'bdi', 'bdo', 'blockquote', 'br', 'button', 'canvas', 'caption', 'cite', 'code', 'col', 'colgroup', 'datalist', 'dd', 'del', 'details', 'dfn', 'dialog', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'figcaption', 'figure', 'footer', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'header', 'hgroup', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'kbd', 'keygen', 'label', 'legend', 'li', 'link', 'main', 'map', 'mark', 'menu', 'menuitem', 'meter', 'nav', 'noscript', 'object', 'ol', 'optgroup', 'option', 'output', 'p', 'param', 'pre', 'progress', 'queue', 'rp', 'rt', 'ruby', 's', 'samp', 'script', 'style', 'section', 'select', 'small', 'source', 'span', 'strike', 'strong', 'sub', 'summary', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'time', 'title', 'tr', 'track', 'u', 'ul', 'var', 'video', 'wbr'],
            $('#content').parents('form').on('submit', function () {
            })
          })
          .froalaEditor({enter: $.FroalaEditor.ENTER_P, placeholderText: null})
		 
		$('#content2')
          .on('froalaEditor.initialized', function (e, editor) {
			htmlDoNotWrapTags: ['script', 'style', 'img'],
			htmlAllowedTags: ['a', 'abbr', 'address', 'area', 'article', 'aside', 'audio', 'b', 'base', 'bdi', 'bdo', 'blockquote', 'br', 'button', 'canvas', 'caption', 'cite', 'code', 'col', 'colgroup', 'datalist', 'dd', 'del', 'details', 'dfn', 'dialog', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'figcaption', 'figure', 'footer', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'header', 'hgroup', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'kbd', 'keygen', 'label', 'legend', 'li', 'link', 'main', 'map', 'mark', 'menu', 'menuitem', 'meter', 'nav', 'noscript', 'object', 'ol', 'optgroup', 'option', 'output', 'p', 'param', 'pre', 'progress', 'queue', 'rp', 'rt', 'ruby', 's', 'samp', 'script', 'style', 'section', 'select', 'small', 'source', 'span', 'strike', 'strong', 'sub', 'summary', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'time', 'title', 'tr', 'track', 'u', 'ul', 'var', 'video', 'wbr'],
            $('#content').parents('form').on('submit', function () {
            })
          })
          .froalaEditor({enter: $.FroalaEditor.ENTER_P, placeholderText: null})
      });
});
</script>
<script>
  $(function() {
    $('#content').froalaEditor({
      imageUploadURL: '<?php echo BASEPATH;?>/home/upload_image',
	   imageManagerLoadURL: '<?php echo BASEPATH;?>/home/load_images',
	   imageManagerDeleteURL: '<?php echo BASEPATH;?>/home/delete_image',
	   fileUploadURL: '<?php echo BASEPATH;?>/home/upload_file',
      imageUploadParams: {
        id: 'content'
      }
    })
    $('#content2').froalaEditor({
      imageUploadURL: '<?php echo BASEPATH;?>/home/upload_image',
	   imageManagerLoadURL: '<?php echo BASEPATH;?>/home/load_images',
	   imageManagerDeleteURL: '<?php echo BASEPATH;?>/home/delete_image',
	   fileUploadURL: '<?php echo BASEPATH;?>/home/upload_file',
      imageUploadParams: {
        id: 'content'
      }
    })
  });
</script>
<style>
tr.odd{background-color:#fff!important;}
tr.even{background-color:#e5eff5!important;}
.odd td{border-color:#e7e7e7!important;}
.even td{border-color:#e7e7e7!important;}
#mytable_wrapper{border: 1px solid #e7e7e7;border-top: 0px;}
#floraid > .fr-box > div > a{display:none !important;}
.multiselect-container.dropdown-menu{height: 300px !important;
    overflow-y: scroll !important;}
.fr-box > div > a {
    display: none !important;
}
</style>
<form id="form-validate" name="form-validate" enctype="multipart/form-data" method="post">  
<div class="page-head">
	<div class="page-title">
		<h1>Send Email & Notification
		</h1>
	</div>	
	<div class="page-title" style="float: left; clear: both;">		
		<h1>
		<span class="badge badge-success"> 1 </span>Basic Info
		</h1>
	</div>
</div>                 
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered" style="padding: 3% 0px 0px;float:left;width:100%;">	
			<div class="form-group col-md-2 col-xs-12" style="text-align: right;">
				<label class="control-label" >Type<b style="color:red;margin-left:5px">*</b></label>
			</div>
			<div class="form-group col-md-6 col-xs-12">
				<select class="form-control" id="type" name="type" onchange="valuechange(this.value);">
					<option value="">Select</option>
					<option value="event" <?php if(isset($_GET['value']) && $_GET['value'] == 'event') { echo "selected"; } ?>>Event</option>
					<option value="function" <?php if(isset($_GET['value']) && $_GET['value'] == 'function') { echo "selected"; } ?>>Function</option>
				</select>
			</div>
			<div style="width:100%;clear:both;"></div>
			<div class="form-group col-md-2 col-xs-12" style="text-align: right;">
				<label class="control-label">Name<b style="color:red;margin-left:5px">*</b></label>
			</div>
			<div class="form-group col-md-6 col-xs-12">
				<select  class="form-control" id="name" name="name">
				  <option value="">Select</option>
					<?php 
					if(isset($_GET['value']) && $_GET['value'] == 'event')
					{
						echo $db->CreateOptions("html", "event_details", array("id","name"));
					}
					else if(isset($_GET['value']) && $_GET['value'] == 'function')
					{
						echo $db->CreateOptions("html", "samaj_funtions", array("id","name"));
					}
					?>							
				</select>							
			</div>
			<div style="width:100%;clear:both;"></div>
			<div class="form-group col-md-2 col-xs-12" style="text-align: right;">
				<label class="control-label">Formate<b style="color:red;margin-left:5px">*</b></label>
			</div>
			<div class="form-group col-md-6 col-xs-12">
				<select class="form-control" id="formate" name="formate">
					<option value="">Select</option>
					<option value="1">Layout 1 (Display only one image)</option>
					<option value="2">Layout 2 (Display multiple images)</option>		
									
				</select>		
			</div>
			<input type="hidden" id="lay" name="lay" value="">	
			<div style="width:100%;clear:both;"></div>
            <div class="form-group col-md-2 col-xs-12" style="text-align: right;">
				<label class="control-label">Samaj City Users<b style="color:red;margin-left:5px">*</b></label>
			</div>
			<div class="form-group col-md-6 col-xs-12">
				<select class="form-control" id="city_users" name="city_multiselect[]" multiple="multiple">
					<?php 
						echo $db->CreateOptions("html", "samaj_city", array("id","name"));
					?>							
				</select>
			</div>
			<div style="width:100%;clear:both;"></div>
            <div class="form-group col-md-2 col-xs-12" style="text-align: right;">
				<label class="control-label">Users<b style="color:red;margin-left:5px">*</b></label>
			</div>
			<div class="form-group col-md-6 col-xs-12">
				<select  class="profile-form valid tokenize-remote-demo1" id="multiselect" name="multiselect[]" multiple>	
					
				</select>	
			</div>
			<div style="width:100%;clear:both;"></div>
			 <div class="form-group col-md-2 col-xs-12" style="text-align: right;">
				<label class="control-label">Send Mail<b style="color:red;margin-left:5px">*</b></label>
			</div>
			<div class="form-group col-md-6 col-xs-12">
				<input type="checkbox" name="withmail" id="withmail">
			</div>
			
		</div>
	</div>
</div>
<div class="page-head">
	<div class="page-title" style="float: left; clear: both;">		
		<h1>
		<span class="badge badge-success"> 2 </span>Layouts
		</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered" style="padding: 3% 0px 0px;float:left;width:100%;">	
			<div class="form-group" id="layout1">
				<label class="control-label col-md-12" style="text-align: center; font-size: 30px;">Layout 1</label>
				<div id="floraid1" class="col-md-12">
					<textarea class="wysihtml5 form-control" id="content" rows="50" name="content" readonly="readonly">
							<!--[if (gte mso 9)|(IE)]>
							<table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							  <tr>
								<td>
							<![endif]-->
							<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
								<tr>
									<td style="padding: 15px 10px 15px 10px;">
										<table border="0" cellpadding="0" cellspacing="0" width="100%" style="display:none;">
											<tr>
												
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align="center" bgcolor="#1ec1b8" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
										<img src="<?php echo SITE_ROOT;?>/images/logo-white.png" alt="Logo" width="200" height="150" style="display:block;" /><br/>
										Newsletter
									</td>
								</tr>
								<tr>
									<td bgcolor="#ffffff" style="padding: 20px 20px 10px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;">
										<b style="text-transform: capitalize;">{Title}</b>
										<p style="margin:20px 0;font-size:13px;"><b style="font-size:15px;">Location:<b> {Location}</p>
										<p style="margin:20px 0;font-size:13px;"><b style="font-size:15px;">Date-Time:<b> {Date} &bull; {Time}</p>
									</td>
								</tr>
								<tr>
									<td>{image}</td>
								</tr>
								<tr>
									<td bgcolor="#ffffff" style="padding: 0 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; border-bottom: 1px solid #f6f6f6;">
										<b>Description</b></br>
										{Description}
									</td>
								</tr>
								<tr>
									<td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
										<b>Customer support</b><br/>Phone: 9022520952 &bull; Email id: contact@5lpparivar.com &bull; Time: 10am to 6pm (IST)
									</td>
								</tr>
								<tr>
									<td style="padding: 15px 10px 15px 10px;">
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td align="center" width="100%" style="color: #999999; font-family: Arial, sans-serif; font-size: 12px;">
													2016 &copy; <a href="<?php echo SITE_ROOT; ?>" style="color: #1ec1b8;">5LP Parivar</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<!--[if (gte mso 9)|(IE)]>
									</td>
								</tr>
							</table>
							<![endif]-->
					</textarea>
				</div>
			</div>
			<div class="form-group" id="layout2" style="">
				<label class="control-label col-md-12" style="text-align: center; font-size: 30px;">Layout 2</label>
				<div id="floraid2" class="col-md-12" style="padding-bottom: 15px;">
					<textarea class="wysihtml5 form-control" id="content2" rows="50" name="content2">
						<!--[if (gte mso 9)|(IE)]>
							<table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							  <tr>
								<td>
							<![endif]-->
							<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
								<tr>
									<td style="padding: 15px 10px 15px 10px;">
										<table border="0" cellpadding="0" cellspacing="0" width="100%" style="display:none;">
											<tr>
												
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align="center" bgcolor="#1ec1b8" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
										<img src="<?php echo SITE_ROOT;?>/images/logo-white.png" alt="Logo" width="200" height="150" style="display:block;" /><br/>
										Newsletter
									</td>
								</tr>
								<tr>
									<td bgcolor="#ffffff" style="padding: 20px 20px 10px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;">
										<b style="text-transform: capitalize;">{Title}</b>
										<p style="margin:20px 0;font-size:13px;"><b style="font-size:15px;">Location:<b> {Location}</p>
										<p style="margin:20px 0;font-size:13px;"><b style="font-size:15px;">Date-Time:<b> {Date} &bull; {Time}</p>
									</td>
								</tr>
								<tr>
									<td>{image}</td>
								</tr>
								<tr>
									<td bgcolor="#ffffff" style="padding: 0 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; border-bottom: 1px solid #f6f6f6;">
										<b>Description</b></br>
										{Description}
									</td>
								</tr>
								<tr>
									<td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
										<b>Customer support</b><br/>Phone: 9022520952 &bull; Email id: contact@5lpparivar.com &bull; Time: 10am to 6pm (IST)
									</td>
								</tr>
								<tr>
									<td style="padding: 15px 10px 15px 10px;">
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td align="center" width="100%" style="color: #999999; font-family: Arial, sans-serif; font-size: 12px;">
													2016 &copy; <a href="<?php echo SITE_ROOT; ?>" style="color: #1ec1b8;">5LP Parivar</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<!--[if (gte mso 9)|(IE)]>
									</td>
								</tr>
							</table>
							<![endif]-->
					</textarea>
				</div>
			</div>
			<div style="width:100%;clear:both;"></div>
			<div class="col-md-12 margin-top-10 margin-bottom-10" style="float:left;">
				<input type="submit" class="btn green" name="submit" value="SUBMIT" style="float: right; margin: 0px 3%;"/>    
			</div>
		</div>
	</div>
</div>
</form>
<script>
$(function(){
	$('#menuemailnotification').addClass('active');
});
function valuechange(value)
{
	window.location.href="<?=SITE_ROOT;?>/mail?value="+value;
}
$(document).ready(function() {
	$('#city_users').multiselect({
		includeSelectAllOption: true,
		enableFiltering: true
	});
	$('#layout1').show();
	$('#layout2').hide();
	$('#formate').change(function(){
		$('#lay').val(this.value);
		if(this.value == '2')
		{
			$('#layout2').show();
			$('#layout1').hide();
		}
		else
		{
			$('#layout2').hide();
			$('#layout1').show();
		}
	});
	
	$('.tokenize-remote-demo1').tokenize2({
		dataSource: '<?php echo SITE_ROOT?>/mail/remote'
	});
	
});
	
var vRules = {
	type:{required:true},
	name:{required:true},
	formate:{required:true},
	multiselect:{required:true}
	
};
var vMessages = {
	type:{required:"Please select type"},
	name:{required:"Please select function/event name"},
	formate:{required:"Please select formate"},
	multiselect:{required:"Please select users"}
};

$("#form-validate").validate({
	rules: vRules,
	messages: vMessages,
	submitHandler: function(form) {		
		$("#loading").css('display','block');
		$(form).ajaxSubmit({
			url: '<?php echo BASEPATH;?>/mail/sendmail', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			clearForm: false,
			success: function (response) {
				
				var res = eval('('+response+')');
				if(res['msg']=="success")
				{	
					window.location.href="<?php echo SITE_ROOT;?>/mail";
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
</script>