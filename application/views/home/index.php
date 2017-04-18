<?php
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$heading = "Home";
?>
<style>
.secondary-content {
    color: #D23F31;
}
#task-card .task-cat{
	margin-left:0px;
}
.card span {
    color: white;
    display: inline-block;
    font-size: 13px;
    font-weight: normal;
    text-align: left !important;
    width: 115px;
	position:relative;
	z-index:9;
	vertical-align: top;
}
.card::after {
    background: #006666 none repeat scroll 0 0;
    bottom: 0;
    content: " ";
    left: 0;
    position: absolute;
    top: 0;
    width: 115px;
    z-index: 0;
}
</style>
<div class="section" style="padding-top:0px;">
	<div id="card-stats">
	<?php
		$db = new Db();
		$table88 = "projects";
		$sort = 'i.id';
		$order = 'desc';
		$condition88 = "i.created_by = ".$_SESSION['samajadmin']['id'];
		$main_table88 = array("$table88 i",array("i.*"));
		$join_tables88 = array(
			array('left',' client r','r.id = i.Client_id', array('r.name as client_name'))
		);
		$rs88 = $db->JoinFetch($main_table88, $join_tables88, $condition88, array($sort => $order),array(0, 6));
		$totalcount =  @mysql_num_rows($rs88);
		?>
		<div class="row">
			<div class="col s12">
				<ul id="task-card" class="collection with-header" style="background: white; padding-left: 10px; padding-bottom: 10px;">
					<li class="collection-header" style="background:#4285F4; padding:10px;display:none;">
						<h6 class="task-card-title" style="text-align:right;display: none;"><a href="<?php echo SITE_ROOT."/home/listprojects"; ?>"><span class="z-depth-2 waves-effect btn secondary-content white strong" style="color:#4285F4;">View More</span></a></h6>
						<h4 class="task-card-title" style="font-size:1.5rem;">Recent Projects</h4>
						<!--<p class="task-card-date">&nbsp;</p>-->
					</li>
					<a href="<?php echo SITE_ROOT."/home/projects"; ?>" class="task-add modal-trigger btn-floating waves-effect waves-light" style="display: none;"><i class="mdi-content-add" style="background: #fff; color: #4285F4;"></i></a>
				<?php 
				if(isset($totalcount) && $totalcount != 0)
				{
					while($row88 = mysql_fetch_object($rs88))
					{
					?>
						<div class="col s12 m6" style="margin-top: 20px;max-width:330px;">
							<a href="<?php echo SITE_ROOT."/project/dashboard?project_id=".$row88->id;?>">
							<div class="card" style="margin:0;">
								<div class="card-content white-text" style="background:#009688;padding-bottom:0; text-align:left;">
									<!--<p class="card-stats-title"><i class="mdi-social-group-add"></i> New Clients</p>-->
									<p style="padding: 0 0 5px; margin:0px;border-bottom:1px solid rgba(160, 160, 160, 0.4);position:relative;z-index:9;text-overflow: ellipsis;white-space: nowrap;overflow:hidden;font-weight:bold;"><span>Project Name</span><?php echo $row88->project_name; ?></p>
									<p class="card-stats-title" style="border-bottom:1px solid rgba(160, 160, 160, 0.4);position:relative;z-index:9;text-overflow: ellipsis;white-space: nowrap;overflow:hidden;padding-top: 5px;"><span style="padding-bottom:5px;">Client Name</span><span class="green-text text-lighten-5"><?php echo $row88->client_name; ?></span></p>
									<p class="card-stats-compare" style="border-bottom:1px solid rgba(160, 160, 160, 0.4);position:relative;z-index:9;padding-top: 5px;"><span style="padding-bottom:5px;">Date Created</span><span class="green-text text-lighten-5"><?php echo $row88->Date; ?></span>
									</p>
								</div>
								<div class="card-action" style="color:white;background:#009688;min-height:80px;">
									<div id="clients-bar" class="center-align" style="text-align:left;"><span style="vertical-align: top;">Address</span><span class="green-text text-lighten-5" style="width:calc(100% - 125px);"><?php echo $row88->Address." ".$row88->City."<br/>".$row88->State." ".$row88->Zip; ?></span></div>
								</div>
							</div>
							</a>
						</div>
					<?php
					}
				}
				else
				{
				?>
					<div class="row"><div class="col s12 m12 l12"><h5  class="col s12 m12 l12">No Record Found</h5></div></div>
				<?php
				}
				?>
				</ul>
			</div>
		</div>
		<div class="row">
		<?php
			$db = new Db();
			$table88 = "notes";
			$sort = 'i.id';
			$order = 'desc';
			$condition88 = "i.created_by = ".$_SESSION['samajadmin']['id'];
			$main_table88 = array("$table88 i",array("i.*"));
			$join_tables88 = array(
				array('left',' lov r','r.id = i.type', array('r.value as note_type'))
			);
			$rs88 = $db->JoinFetch($main_table88, $join_tables88, $condition88, array($sort => $order),array(0, 5));
			$totalcount88 =  @mysql_num_rows($rs88);
			?>
			<div class="col s12" style="display:none;">
				<ul id="task-card" class="collection with-header">
					<li class="collection-header" style="background:#4285F4;">
						<h6 class="task-card-title" style="text-align:right; display: none;"><a href="<?php echo SITE_ROOT."/home/listnotes" ?>"><span class="z-depth-2 waves-effect btn secondary-content white strong" style="color:#4285F4;">View More</span></a></h6>
						<h4 class="task-card-title">Recent Notes</h4>
						<p class="task-card-date"><?php echo date("F j, Y"); ?></p>
					</li>
					<?php 
					if(isset($totalcount88) && $totalcount88 != 0)
					{
						while($row88 = mysql_fetch_object($rs88))
						{
						?>
							<li class="collection-item dismissable">
								<h6><?php echo $row88->title; ?></h6>
								<label for="task5"><?php echo $row88->description; ?> <a href="<?php echo SITE_ROOT."/home/notes?project_id=".$row88->project_id."&id=".$row88->id; ?>" class="secondary-content"><span class="ultra-small">Details</span></a></label>
								<span class="task-cat <?php if($row88->note_type == "Things To Remember") {echo 'teal';} else if($row88->note_type == "Excluded") { echo "red";} else { echo "blue"; } ?>"><?php echo $row88->note_type; ?></span>
							</li>
						<?php
						}
					}
					else
					{
					?>
						<div class="row"><div class="col s12 m12 l12"><h5  class="col s12 m12 l12">No Record Found</h5></div></div>
					<?php
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$("#menuhome").addClass("active");
});
$(function(){
 $('#homemenu').addClass('active');
 $("#headingSearchtitle").html("Recent Projects");
});
</script>