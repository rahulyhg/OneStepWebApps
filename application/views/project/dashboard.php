<?php
if(!isset($_SESSION["samajadmin"]["id"]))
{
	Core::PageRedirect(SITE_ROOT);
}
$heading = "Project";
?>
<style>
.secondary-content {
    color: #D23F31;
}
#task-card .task-cat{
	margin-left:0px;
}
#profile-card .card-profile-image{
	left:20px;
}
.mwidth{
	width:20%!important;
}
.mwidth h4{ 
	font-size:18px!important;
}
.card-title.grey-text.text-darken-4 p{
	margin:10px 0px;
}
.mywidth{
	width:25%;
}
</style>
<?php
$db = new Db();
$table88 = "projects";
$condition88 = "i.created_by = '".$_SESSION['samajadmin']['id']."' && i.id= '".$_REQUEST['project_id']."' ";
$main_table88 = array("$table88 i",array("i.*"));
$join_tables88 = array(
	array('left','client c','c.id = i.Client_id', array('c.name as client_name','c.phonenumber as client_phone','c.email as client_email')),
	array('left','location r1','r1.location_id = i.City', array('r1.name as city_name')),
	array('left','location r2','r2.location_id = i.State', array('r2.name as state_name')),
	array('left','location r3','r3.location_id = i.country', array('r3.name as country_name')),
);
$rs88 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
$rs11 = $db->JoinFetch($main_table88, $join_tables88, $condition88);
$totalcount88 =  @mysql_num_rows($rs88);
?>
<div class="section" style="padding-top:0px;">
	<div id="card-stats" class="row">
		<div class="col s12 m12 l12" style="position: relative;display:none;">
				<h4 class="header" style="position: absolute; color: white; z-index: 9; left: 25px;">Client Profile</h4>
				<div id="profile-card" class="card">
				<div class="card-image waves-effect waves-block waves-light">
					<img class="activator" src="<?php echo CSS; ?>/images/user-bg.jpg" alt="user bg">
				</div>
				<?php
				if(isset($totalcount88) && $totalcount88 != 0)
					{
						while($row12 = mysql_fetch_object($rs88))
						{
				?>
							<div class="card-content" style="">
								  <!-- <img align="left" src="<?php echo CSS; ?>/images/avatar.jpg" alt="" class="circle responsive-img activator card-profile-image"> -->
								  <div class="circle card-profile-image clientname z-depth-2" style="background:<?php echo $_SESSION['samajadmin']['client_color']; ?>">
									<?php 
									$client = $row12->client_name; 
									$arr1 = str_split($client);
									echo strtoupper($arr1[0]);
									?>
								  </div>
								  <a style="display:none;" class="btn-floating activator btn-move-up waves-effect waves-light darken-2 right">
									<i class="mdi-editor-mode-edit"></i>
								  </a>

								  <span class="card-title activator grey-text text-darken-4"><?php echo $row12->client_name; ?></span>
								  <div class="row">
									  <p class="col mywidth"><i class="mdi-action-perm-identity"></i><?php echo $row12->prepared_by; ?></p>
									  <p class="col mywidth"><i class="mdi-action-perm-phone-msg"></i><?php echo $row12->client_phone; ?></p>
									  <p class="col mywidth"><i class="mdi-action-perm-phone-msg"></i><?php echo $row12->alt_phone; ?></p>
									  <p class="col mywidth"><i class="mdi-communication-email"></i><?php echo $row12->client_email; ?></p>
								  </div>
							</div>
							<div class="card-reveal">
							  <span class="card-title grey-text text-darken-4"><?php echo $row12->client_name; ?></p>
							  <p><i class="mdi-action-perm-identity"></i><?php echo $row12->Address.", ".$row12->city_name.", ".$row12->state_name.", ".$row12->country_name ?></p>
							  <p><i class="mdi-action-perm-phone-msg"></i> <?php echo $row12->client_phone; ?></p>
							  <p><i class="mdi-communication-email"></i><?php echo $row12->client_email; ?></p>
							  <p><i class="mdi-social-cake"></i> <?php echo $row12->Date; ?></p>
							</div>
				<?php
						}
					}
					else
					{
				?>
					<div class="row"><div class="col s12"><h5 class="col s12">No Record Found</h5></div></div>
				<?php
					}
				?>
			</div>
		</div>
		<div class="col s12 m12 112">
			<div class="col s12 mwidth" style="margin: 0px 0px;">
				<a href="<?php echo SITE_ROOT."/home/notes?project_id=".$_REQUEST['project_id'];?>">
					<div class="card">
						<div class="card-content white-text" style="background:#4285F4;">
							<h4 class="card-stats-number">Add General <br/>Notes</h4>
						</div>
					</div>
				</a>
			</div>
			<div class="col s12 mwidth" style="margin: 0px 0px;">
				<a href="<?php echo SITE_ROOT."/home/internalnote?project_id=".$_REQUEST['project_id'];?>">
					<div class="card">
						<div class="card-content white-text" style="background:#B71C1C;">
							<h4 class="card-stats-number">Add Interior <br/>Notes</h4>
						</div>
					</div>
				</a>
			</div>			
			<div class="col s12 mwidth" style="margin: 0px 0px;">
				<a href="<?php echo SITE_ROOT."/project/internalestimate?project_id=".$_REQUEST['project_id'];?>">
					<div class="card">
						<div class="card-content white-text" style="background:#B71C1C;">
							<h4 class="card-stats-number">Add Interior <br/>Estimate</h4>
						</div>
					</div>
				</a>
			</div>
			<div class="col s12 mwidth" style="margin: 0px 0px;">
				<a href="<?php echo SITE_ROOT."/home/externalnote?project_id=".$_REQUEST['project_id'];?>">
					<div class="card">
						<div class="card-content white-text" style="background:#00695C;">
							<h4 class="card-stats-number">Add Exterior <br/>Notes</h4>
						</div>
					</div>
				</a>
			</div>
			<div class="col s12 mwidth" style="margin: 0px 0px;">
				<a href="<?php echo SITE_ROOT."/project/externalestimate?project_id=".$_REQUEST['project_id'];?>">
					<div class="card">
						<div class="card-content white-text" style="background:#00695C;">
							<h4 class="card-stats-number">Add Exterior <br/>Estimate</h4>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="col s12 m12 l6">
			<ul id="task-card" class="collection with-header">
				<li class="collection-header red darken-4" style="padding:9px;">
					<h6 class="task-card-title" style="text-align:right; display:none;"><a href="#"><span class="z-depth-2 waves-effect btn secondary-content white strong" style="color:#4285F4;">View More</span></a></h6>
					<h4 class="task-card-title" style=" font-size:1.5rem;">Interior</h4>
				</li>
				<a href="<?php echo SITE_ROOT."/project/internalestimate?project_id=".$_REQUEST['project_id']; ?>" class="task-add modal-trigger btn-floating waves-effect waves-light" style="display:none;"><i class="mdi-content-add" style="background: #fff; color: #4285F4;"></i></a>
				<?php 
				$db = new Db();
				$table99 = "int_estimates";
				$condition99 = "p.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id= '".$_REQUEST['project_id']."' ";
				$main_table99 = array("$table99 i",array("i.*"));
				$join_tables99 = array(
					array('left','projects p','p.id = i.project_id', array()),
					array('left','location r1','r1.location_id = p.City', array('r1.name as city_name')),
					array('left','location r2','r2.location_id = p.State', array('r2.name as state_name')),
					array('left','location r3','r3.location_id = p.country', array('r3.name as country_name')),
					array('left','room_types rm1','rm1.id = i.SpaceType', array('rm1.name as room_name'))
				);
				$rs99 = $db->JoinFetch($main_table99, $join_tables99, $condition99);
				$totalcount99 =  @mysql_num_rows($rs99);
				if(isset($totalcount99) && $totalcount99 != 0)
				{
					while($row99 = mysql_fetch_object($rs99))
					{
					?>
						<li class="collection-item dismissable">
							<h6>Room Type: <?php echo $row99->room_name; ?></h6>
							<label for="task5">Total Cost: <?php echo $row99->Cost; ?>$ <a href="<?php echo SITE_ROOT."/project/internalestimate?id=".$row99->id."&project_id=".$_REQUEST['project_id']; ?>" class="secondary-content"><span class="ultra-small">Details</span></a></label>
							<span class="task-cat blue"><?php $dateeve = date_create($row99->created_date); $date = date_format($dateeve,"jS F Y"); echo $date; ?></span>
						</li>
					<?php
					}
				}
				else
				{
				?>
					<div class="row white"><div class="col s12"><h5 class="col s12">No Record Found</h5></div></div>
				<?php
				}
				?>
			</ul>
		</div>
		<?php
		$db = new Db();
		$db = new Db();
		$table99 = "ext_estimates";
		$condition99 = "p.created_by = '".$_SESSION['samajadmin']['id']."' && i.project_id= '".$_REQUEST['project_id']."' ";
		$main_table99 = array("$table99 i",array("i.*"));
		$join_tables99 = array(
			array('left','projects p','p.id = i.project_id', array()),
			array('left','location r1','r1.location_id = p.City', array('r1.name as city_name')),
			array('left','location r2','r2.location_id = p.State', array('r2.name as state_name')),
			array('left','location r3','r3.location_id = p.country', array('r3.name as country_name')),
			array('left','ext_room_type rm1','rm1.id = i.SpaceType', array('rm1.name as room_name'))
		);
		$rs99 = $db->JoinFetch($main_table99, $join_tables99, $condition99);
		$totalcount =  @mysql_num_rows($rs99);
		?>
		<div class="col s12 m12 l6">
			<ul id="task-card" class="collection with-header" style="background: white;">
				<li class="collection-header teal darken-3" style="padding:9px;">
					<h6 class="task-card-title" style="text-align:right; display:none;"><a href="#"><span class="z-depth-2 waves-effect btn secondary-content white strong" style="color:#4285F4;">View More</span></a></h6>
					<h4 class="task-card-title" style=" font-size:1.5rem;">Exterior</h4>
				</li>
				<a href="<?php echo SITE_ROOT."/project/externalestimate?project_id=".$_REQUEST['project_id']; ?>" class="task-add modal-trigger btn-floating waves-effect waves-light" style="display:none;"><i class="mdi-content-add" style="background: #fff; color: #4285F4;"></i></a>
			<?php 
			if(isset($totalcount) && $totalcount != 0)
			{
				while($row88 = mysql_fetch_object($rs99))
				{
				?>
				<li class="collection-item dismissable">
					<h6>Room Type: <?php echo $row88->room_name; ?></h6>
					<label for="task5">Total Cost: <?php echo $row88->Cost; ?>$ <a href="<?php echo SITE_ROOT."/project/externalestimate?project_id=".$_REQUEST['project_id']."&id=".$row88->id; ?>" class="secondary-content"><span class="ultra-small">Details</span></a></label>
					<span class="task-cat blue">Date <?php $dateeve = date_create($row88->created_date); $date = date_format($dateeve,"jS F Y"); echo $date; ?></span>
				</li>
				<?php
				}
			}
			else
				{
				?>
					<div class="row"><div class="col s12"><h5 class="col s12">No Record Found</h5></div></div>
				<?php
				}
				?>
			</ul>
		</div>
	</div>
</div>
<script>
$(function(){
	$("#menuhome").addClass("active");
	$("#headingSearchtitle").html("Interior & Exterior Dashboard");
});
</script>
