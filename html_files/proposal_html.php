<?php
require $_SERVER['DOCUMENT_ROOT'].'/onestepnew/application/control/include_classes.php';

$db = new Db();
$row11 = array();
$table888 = "internal_estimate";
$_REQUEST['project_id'] = "193";
if(isset($_REQUEST['project_id'])){
	$condition888 = "i.project_id = '".$_REQUEST['project_id']."' ";
	$main_table888 = array("$table888 i",array("i.*"));
	$join_tables888 = array(
		array('left',' project p','p.id = i.project_id', array('p.alt_phone as alterphone','p.Address as address','p.Zip as zipcode')),
		array('left',' client r','r.id = p.Client_id', array('r.name as client_name','r.phonenumber as phonenum','r.email as mailid'))
	);
	$rs11 = $db->JoinFetch($main_table888, $join_tables888, $condition888);
	$row11 = mysql_fetch_array($rs11);
}
?>
<p class="red">Insert Logo & Co. Info Here as jpeg.  Try to keep it no more than 1.5” tall to preserve the formatting – delete this text before inserting logo</p>
<p>Proposal Date: </p>
<table>
 <tr>
		<td width=300>PROPOSAL SUBMITTED TO </td>
		<td width=300>
			<table>
				<tr>
					<td>PRIMARY PHONE </td>
					<td>ALTERNATE PHONE </td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width=300><?php echo $row11['client_name']; ?> </td>
		<td width=300>
      	<table>
			<tr>
				<td><?php echo $row11['phonenum']; ?></td>
				<td><?php echo $row11['alterphone']; ?></td>
			</tr>
		</table>
		</td>
	</tr>
    <tr>
		<td width=300>ADDRESS </td>
      	<td width=300>EMAIL </td>
	</tr> 
	<tr>
		<td width=300><?php echo $row11['address']; ?></td>
      	<td width=300 ><?php echo $row11['mailid']; ?></td>
	</tr>
	<tr>
		<td width=300>CITY,  STATE , AND ZIP CODE</td>
      	<td width=300>JOB NAME AND ADDRESS (if different)</td>
	</tr>
	<tr>
		<td width=300><?php echo $row11['city_name'].",".$row11['state_name'].",".$row11['country_name'].",".$row11['zipcode']; ?></td>
      	<td width=300>&nbsp;</td>
	</tr>
</table>
<h2 style="text-decoration: underline;">The areas we are proposing to paint (scope of work):</h2>
<p>*Unless otherwise clearly defined above, all work shall be preformed at the Level 3 Surface Preparation and Finish Appearance standard (see below)</p>
<p class="underline">Exclusions:</p>
<ul>
  <li>All closets and shelving</li>
  <li>All cabinets</li>
  <li>All other surfaces or areas not specifically mentioned above</li>
</ul>
<p class="underline">Included in our standard procedures:</p>
<ol>
  <li>Confirm colors and placement.</li>
  <li>Mask all furnishing; floors to be covered and protected before any work begins.</li>
  <li>Remove all plates, light covers, vents etc. and replaced after paint is dry. </li>
  <li>All areas, upon completion will be cleaned-up and vacuumed, and debris will be taken away.</li>
  <li>Left over paint will be labeled and left for future touch-ups.</li>
  <li>At the completion, our trained project manager will carefully inspect all surfaces to insure our quality standard has been met. </li>
</ol>
<p class="underline">Levels of Surface Preparation & Finish Appearance</p>
<ul>
  <li>Description: The following levels are used to establish a clearly-communicated standard as to what has been agreed upon and what is to be expected with regards to the different levels of surface preparation and the quality of appearance of the finished surface.  They are a summary of the actual standard based on PDCA (Painting & Decorating Contractors of America) Industry Standard P14-06.</li>
  <li> <strong>Level 1</strong> – Basic: <span class="underline"><i>Cleaned, No Patching </i></span> - Requires only basic cleanliness of surfaces to ensure the adhesion of new finishes, with less concern for the adhesion of existing paint and quality of appearance.  Obvious loose paint will be removed, but no smoothing of the existing surface profile will be done.  Includes washing or hand cleaning.  <span class="underline">No Warranty</span></li>
  <li><strong>Level 2</strong> – Standard:<span class="underline"> <i>Basic Patching</i></span> - Requires all of Level 1 as well as the examination of existing coatings to assess their adhesion. With this level of surface preparation, good adhesion and longevity of finish are of primary concern and appearance is of secondary concern. Includes basic patching, filling, dulling of glossy surfaces, spot priming, caulking, and light sanding/abrading to address surface profile differences exceeding 1/8 inch.  Excludes matching texture and taping cracks.</li>
  <li><strong>Level 3 – Superior:<span class="underline"> <i> Detailed Patching</i></span> – Requires all of Levels 1 and 2 with added emphasis on the quality of appearance of finish painted surfaces. Includes detailed patching, filling, properly taping cracks, approximate matching of textures, and thorough sanding to address surface profile differences exceeding 1/16 inch.  </strong></li>
  <li><strong>Level 4</strong> – Supreme: <span class="underline"> <i>Touch & Feel</i></span> – Requires all of Levels 1, 2 and 3 with even more emphasis on the quality of appearance of finish painted surfaces. The criteria for inspection and acceptance may include smoothness to “touch and feel” on interior handrails, doors and easily accessible trim.  Includes thorough filling & sanding to address surface profile differences exceeding 1/32 inch.</li>
  <li><strong>Level 5</strong> – Restoration/Resurfacing: <span class="underline"> <i>Back to Original</i></span> – This type of surface preparation is required when existing conditions indicate that the surfaces are severely deteriorated (where damage to the coating is widespread).  Includes complete or nearly complete removal of existing paint through various stripping methods.  Substrate (underlying surface being painted) may need to be completely replaced, repaired or resurfaced. </li>
</ul>
<p class="underline">Cost</p>
<ul>
	<li>We propose to furnish material and labor – complete and in accordance with the above specifications for the sum stated below.  Individual tasks, if selected, may require additional pricing.  Price is valid for 30 days, unless otherwise noted</li>
	<li style="vertical-align: right"><strong>Investment for the above:	$</strong></li>
</ul>
<p class="underline">Colors & Samples</p>
<ul>
  <li>We offer up to 3 - 8”X10” brush outs of your colors choices to help you in your decision making, FREE.  </li>
  <li>If your need more assistance with color, we offer Color Consultations and custom color mixing.  Additional costs do apply.</li>
  <li>This estimate includes up to 5 different colors through out the home.</li>
  <li>Due to the conceptual nature of our first meeting and not having a color scheme finalized, additional pricing may be required on multiple colors, color placement or deep based colors.</li>
</ul>
<p class="underline">Insurance & Licenses</p>
<ul>
  <li><strong>Insert your Contractor’s License number here if desired</strong></li>
  <li><strong>Insert your Liability Ins. info here if desired </strong></li>
  <li><strong>Insert your Workers Comp. Ins. info here if desired</strong></li>
</ul>
<p class="underline">Two-Year Limited Warranty </p>
<ul>
  <li><span class="red">YOUR COMPANY NAME</span> warrants labor and material for a period of two (2) years.  If paint failure appears, we will supply labor and materials to correct the condition without cost.  This warranty is in lieu of all other warranties, expressed or implied.  Our responsibility is limited to correcting the condition as indicated above.</li>
  <li>This warranty excludes, and in no event will <span class="red">YOUR COMPANY NAME</span> be responsible for consequential or incidental damages caused by accident or abuse, temperature changes, settlement or moisture; i.e., cracks caused by expansion and/or contraction.  Cracks will be properly prepared as indicated at time of job, but will not be covered under this warranty.   </li>
  <li><strong>Insert your Workers Comp. Ins. info here if desired</strong></li>
</ul>
<p class="underline">Payment</p>
<ul>
  <li>A <span class="red">10%</span> deposit is required to reserve your painting appointment.</li>
  <li>Progress payment will be addressed in our agreement / contract.</li>
</ul>
<p>Respectfully submitted:</p>
<p>Please read this proposal carefully and make sure that it contains all the aspects of the job that you want and no additional aspects.  Anything not included in this proposal is excluded.  We want to be as clear as possible to make this project easier for you.  Please let us know of any way we can help. </p>
<?php exit; ?>