<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1>Import Users
		</h1>
	</div>
	<!-- END PAGE TITLE -->
</div>                   
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark" style="margin-top: 1%;">
					<i class="fa fa-upload"></i>
					<span class="caption-subject bold uppercase">Import Users</span>
				</div>
			</div>
			<div class="portlet-body">
				<form name="import" id="import" method="post" action="<?php echo BASEPATH;?>/home/importcsv" enctype="multipart/form-data">
					<label>Please Upload only .xls OR .xlsx file</label>
					<input type="file" name="file1" /><br />
					<input type="submit" name="submit" class="btn green" value="Submit" />
				</form>
			</div>
		</div>
	</div>
</div>