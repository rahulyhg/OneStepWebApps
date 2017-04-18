<?php
@session_start();
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
if(!isset($_REQUEST['project_id'])){
	Core::PageRedirect(SITE_ROOT."/home");
}
?>

<style>
label.error{
	display:none!important;
}
</style>
<?php
$db = new Db();
$table88 = "notes";
$sort = 'i.id';
$order = 'desc';
$condition88 = "i.id = ".$_REQUEST['id']." && i.created_by = ".$_SESSION['samajadmin']['id'];
$main_table88 = array("$table88 i",array("i.*"));
$join_tables88 = array();
$rs1 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
$result = mysql_fetch_array($rs1);
?>
<?php 
$label = "Add";
$button = "Create";
if(isset($_REQUEST['id'])){
	$label = "Edit";
	$button = "Update";
} ?>
<div class="card-panel">
	<div id="input-fields">
		<h4 class="header" style="margin-top:0px; margin-bottom:0px;"><?= $label; ?> Note</h4>
		<div class="row">
			<div class="col s12 m12 l12">
				<div class="row">
					<form class="col s12" name="add_note" id="add_note">
						<div class="row">
							<div class="input-field col s6">
								<input id="title" name="title" type="text" maxlength="250" minlength="1" value="<?php if(isset($result['title'])) echo $result['title'];?>" class="validate">
								<label for="title">Title</label>
							</div>
							<input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
							<div class="input-field col s6">
								<select class="" name="type" id="type">
									<option class="" value="">Select</option>
									<?php 
										$cpl_status="";
										$selected = "";
										if(isset($result['type']) && $result['type'] != "")
										{
											$selected = $result['type'];
										}
										echo $db->CreateOptions("html", "lov", array("id","value"),$selected,"","type='notes_type'");
									?>
								</select>
								<label for="title">Type</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea id="description" name="description" type="text" class="validate" style="border-width: 0px 0px 1px; border-bottom: 1px solid rgb(158, 158, 158);"><?php if(isset($result['description'])) echo $result['description'];?></textarea>
								<label for="description">Description</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12" style="text-align:center;">
								<input class="z-depth-1 waves-effect btn secondary-content strong" type="submit" id="submit" name="submit" value="<?= $button; ?> Note" style="background:#4285F4; display:inline-block; float:none;">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

$(function(){
 $('#gennotemenu').addClass('active');
});

var vRulesLSign = {
	title:{required:true, number: false, minlength: 1},
	description:{required:true},
	type:{required:true}
};
var vMessagesLSign = {
	title:{required:"Please enter title",number: "First name should be a string",minlength: "Title should be at least 1 characters long"},
	description:{required:"Please enter description"},
	type:{required:"Please select note type"} 
};
$("#add_note").validate({
	rules: vRulesLSign,
	messages: vMessagesLSign,
	submitHandler: function(form1) {		
		$("#loading").css('display','block');
				
		$(form1).ajaxSubmit({
			url: '<?= SITE_ROOT; ?>/home/add_note?project_id=<?php echo $_REQUEST['project_id']; ?>', 
			type: 'post',
			cache: false,
			enctype:"multipart/form-data",
			success: function (response) {					
				var res = eval('('+response+')');
				if(res['msg'] == "success")
				{	
					$('#displayMsg1').hide();	
					  swal({   title: "Do you want to continue?",   
						 text: "Do you want to continue to edit or want to go to Dashboard?",   
						 type: "warning",   
						 showCancelButton: true,   
						 confirmButtonColor: "#DD6B55",   
						 confirmButtonText: "Yes",   
						 cancelButtonText: "No",   
						 closeOnConfirm: false,   
						 closeOnCancel: false }, 
						 function(isConfirm){   
							 if (isConfirm) {     
								 location.href = "<?= SITE_ROOT; ?>/home/notes?project_id=<?php echo $_REQUEST['project_id']; ?>&id="+res['id'];  } 
							 else {
								 location.href = "<?= SITE_ROOT; ?>/project/dashboard?project_id=<?php echo $_REQUEST['project_id']; ?>";  } 
						});
					//location.reload();
				}
				else
				{		
					$('#displayMsg1').show();				
					$('#displayMsg1 span').html(res['msg']);
					window.setTimeout(function() { $('#displayMsg1').hide(); }, 5000);
					$("html,body").scrollTop(0);
					return false;
				}
				$("#loading").css('display','none');
			}
		});
	}
});
$(function(){
 $('#gennotemenu').addClass('active');
 $("#headingSearchtitle").html("General Notes");
});
</script>