<?php
/**
*  Example of use of HTML to docx converter
*/

// Load the files we need:
require_once 'classes/htmltodocx/phpword/PHPWord.php';
require_once 'classes/htmltodocx/simplehtmldom/simple_html_dom.php';
require_once 'classes/htmltodocx/htmltodocx_converter/h2d_htmlconverter.php';
require_once 'html_files/styles.inc';

// Functions to support this example.
require_once 'classes/htmltodocx/documentation/support_functions.inc';

// HTML fragment we want to parse:

require $_SERVER['DOCUMENT_ROOT'].'/onestepnew/application/control/include_classes.php';

$db = new Db();
$row11 = array();
$table888 = "internal_estimate";
if(isset($_REQUEST['project_id'])){
	$condition888 = "i.project_id = '".$_REQUEST['project_id']."' ";
	$main_table888 = array("$table888 i",array("i.*"));
	$join_tables888 = array(
		array('left',' projects p','p.id = i.project_id', array('p.alt_phone as alterphone','p.Address as address','p.Zip as zipcode')),
		array('left',' client r','r.id = p.Client_id', array('r.name as client_name','r.phonenumber as phonenum','r.email as mailid')),
		array('left',' location r1','r1.location_id = p.City', array('r1.name as city_name')),
		array('left',' location r2','r2.location_id = p.State', array('r2.name as state_name')),
		array('left',' location r3','r3.location_id = p.country', array('r3.name as country_name')),
		array('left',' int_estimates r4','r4.id = i.estimate_id', array('r4.SpaceType as room_id','r4.Cost as costadd')),
		array('left',' room_types r5','r5.id = r4.SpaceType', array('r5.name as room_name'))
	);
	$rs11 = $db->JoinFetch($main_table888, $join_tables888, $condition888);
	
	$all= "";
	$cost= 0;
	$val = $db->FetchToArray("default_production_rate","*","project_id='193'"); 
	$production_rate = array();
	for($i = 0; $i < sizeof($val) ; $i++)
	{
		$production_rate[$val[$i]['production_item']]['description'] = $val[$i]['description'];
	}
while($row11 = mysql_fetch_array($rs11)){
	$cost += $row11['costadd'];
	$all .= "<strong>".$row11['room_name']."</strong><br/>";
	$clientname = $row11['client_name'];
	$clientphone = $row11['phonenum'];
	$clientaltphone = $row11['alterphone'];	
	$clientaddress = $row11['address'];	
	$clientemail = $row11['mailid'];	
	$clientcity = $row11['city_name'];	
	$clientstate = $row11['state_name'];	
	$clientcountry = $row11['country_name'];	
	$clientzip = $row11['zipcode'];	
	
	if(isset($row11['furniture_quantity'])){ 
		$all .=  $production_rate['Furniture Treatment']['description'].'<br/>';
	}
	if(isset($row11['window_quantity'])){ 
		$all .=  $production_rate['Window Treatment']['description'].'<br/>';
	}
	if(isset($row11['maskcover_quantity'])){ 
		$all .=  $production_rate['Mask & Cover']['description'].'<br/>';
	}
	if(isset($row11['wallpaper_removal_coats'])){ 
		$all .=  $production_rate['Wallpaper Removal']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['rrhardware_quantity'])){ 
		$all .=  $production_rate['R&R Hardware & Lighting']['description'].'<br/>';
	}
	if(isset($row11['prepwoodwork_quantity'])){ 
		$all .=  $production_rate['Prep Woodwork']['description'].'<br/>';
	}
	if(isset($row11['patchtexture_quantity'])){ 
		$all .=  $production_rate['Patch & Texture']['description'].'<br/>';
	}
	if(isset($row11['skimcoat_coats'])){ 
		$all .=  $production_rate['Skim Coat']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['polesand_quantity'])){ 
		$all .=  $production_rate['Pole Sand Walls']['description'].'<br/>';
	}
	if(isset($row11['wprime_coats'])){ 
		$all .=  $production_rate['Walls: Prime']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['wpaint09_coats'])){ 
		$all .=  $production_rate['Walls: Paint 0 to 9']['description'].' - Apply | Coats<br/>';
	}	
	if(isset($row11['wpaint9_coats'])){ 
		$all .=  $production_rate['Walls: Paint 9 or more']['description'].' - Apply | Coats<br/>';
	}	
	if(isset($row11['cprime_coats'])){ 
		$all .=  $production_rate['Ceilings: Prime']['description'].' - Apply | Coats<br/>';
	}	
	if(isset($row11['cpaint_coats'])){ 
		$all .=  $production_rate['Ceilings: Paint']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['cw_time_quantity'])){ 
		$all .=  $production_rate['Ceiling & Walls: +/- Time']['description'].'<br/>';
	}	
	if(isset($row11['dflat_quantity']) && $row11['dflat_coats'] != "" ){ 
		$all .=  $production_rate['Doors: Flat']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['dpaneled_quantity']) && $row11['dpaneled_coats'] != "" ){ 
		$all .=  $production_rate['Doors: Paneled']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['dfrench_quantity']) && $row11['dfrench_coats'] != "" ){ 
		$all .=  $production_rate['Doors: French']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['dframes_quantity']) && $row11['dframes_coats'] != "" ){ 
		$all .=  $production_rate['Doors: Frames']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['dtime_quantity'])){ 
		$all .=  $production_rate['Doors: +/- Time']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['wcasement_quantity']) && $row11['wcasement_coats'] != "" ){ 
		$all .=  $production_rate['Windows: Casement']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['w1_1_quantity']) && $row11['w1_1_coats'] != "" ){ 
		$all .=  $production_rate['Windows: 1/1']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['w3_7_panel_quantity']) && $row11['w3_7_panel_coats'] != "" ){ 
		$all .=  $production_rate['Windows: 3 to 7 Panel']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['w8_16_panel_quantity']) && $row11['w8_16_panel_coats'] != "" ){ 
		$all .=  $production_rate['Windows: 8 to 16 Panel']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['w16_panel_quantity']) && $row11['w16_panel_coats'] != "" ){ 
		$all .=  $production_rate['Windows: 16 or more Panel']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['wtime_quantity'])){ 
		$all .=  $production_rate['Windows: +/- Time']['description'].'<br/>';
	}
	if(isset($row11['baseboards_coats'])){ 
		$all .=  $production_rate['Baseboards']['description'].' - Apply | Coats<br/>';
	}	
	if(isset($row11['baseboardstime_quantity'])){ 
		$all .=  $production_rate['Baseboards: +/- Time']['description'].'<br/>';
	}
	if(isset($row11['chairrail_coats'])){ 
		$all .=  $production_rate['Chair Rail']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['chairrail_time_quantity'])){ 
		$all .=  $production_rate['Chair Rail: +/- Time']['description'].'<br/>';
	}
	if(isset($row11['crownmolding_coats'])){ 
		$all .=  $production_rate['Crown Molding']['description'].' - Apply | Coats<br/>';
	}	
	if(isset($row11['crownmolding_time_quantity'])){ 
		$all .=  $production_rate['Crown Molding: +/- Time']['description'].'<br/>';
	}
	if(isset($row11['closets_quantity']) && $row11['closets_coats'] != "" ){ 
		$all .=  $production_rate['Closets']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['cabinetry_quantity']) && $row11['cabinetry_coats'] != "" ){ 
		$all .=  $production_rate['Cabinetry']['description'].' - Apply | Coats<br/>';
	}
	if(isset($row11['dailybreakdown_quantity'])){ 
		$all .=  $production_rate['Daily Setup/Breakdown']['description'].'<br/>';
	}
	if(isset($row11['cleantouchup_quantity'])){ 
		$all .=  $production_rate['Clean and Touchup']['description'].'<br/>';
	}
	if(isset($row11['bullnosewall_quantity'])){ 
		$all .=  $production_rate['Bullnose/Accent Wall']['description'].'<br/>';
	}
	if(isset($row11['miscellaneous1_quantity'])){ 
		$all .=  'Miscellaneous <br/>';
	}
	if(isset($row11['miscellaneous2_quantity'])){ 
		$all .=  'Miscellaneous <br/>';
	}
	if(isset($row11['miscellaneous3_quantity'])){ 
		$all .=  'Miscellaneous <br/>';
	}
	if(isset($row11['faux_quantity'])){ 
		$all .=  $production_rate['Faux/Mural']['description'].'<br/>';
	}
	$all .="<br/>";
}
}

$html = '<p class="western" style=""><span lang="en-IN">Insert
your logo &amp; company info here as jpeg</span></p>
<table width="723" cellpadding="7" cellspacing="0">
	<tbody>
	<tr>
		<td colspan="7" width="707" height="6" bgcolor="#c0c0c0" style="">CONTRACT</td>
	</tr>
	<tr>
		<td colspan="2" width="334" bgcolor="#ffffff" style="">PROPOSAL SUBMITTED TO</td>
		<td width="83" bgcolor="#ffffff" style="">PRIMARY PHONE</td>
		<td width="68" bgcolor="#ffffff" style="">ALT.PHONE</td>
		<td colspan="2" width="112" bgcolor="#ffffff" style="">EMAIL</td>
		<td width="54" bgcolor="#ffffff" style="">DATE</td>
	</tr>
	<tr>
		<td colspan="2" width="334" bgcolor="#ffffff" style=""></td>
		<td width="83" bgcolor="#ffffff" style=""></td>
		<td width="68" bgcolor="#ffffff" style=""></td>
		<td colspan="2" width="112" bgcolor="#ffffff" style=""></td>
		<td width="54" bgcolor="#ffffff" style=""></td>
	</tr>
	<tr >
		<td colspan="2" width="334" bgcolor="#ffffff" style="">ADDRESS</td>
		<td colspan="5" width="359" bgcolor="#ffffff" style="">JOB NAME</td>
	</tr>
	<tr>
		<td colspan="2" width="334" bgcolor="#ffffff" style=""></td>
		<td colspan="5" width="359" bgcolor="#ffffff" style="">
			<p class="western">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" width="334" bgcolor="#ffffff" style="">CITY,STATE, AND ZIP CODE</td>
		<td colspan="5" width="359" bgcolor="#ffffff" style="">JOB LOCATION</td>
	</tr>
	<tr>
		<td colspan="2" width="334" bgcolor="#ffffff" style=""></td>
		<td colspan="5" width="359" bgcolor="#ffffff" style=""></td>
	</tr>
	<tr>
		<td colspan="2" width="334" height="7" bgcolor="#c0c0c0" style="">SPECIFICATIONS</td>
		<td colspan="5" width="359" bgcolor="#c0c0c0" style="">SCHEDULE</td>
	</tr>
	<tr>
		<td colspan="2" width="334" height="18"  bgcolor="#ffffff" style=""></td>
		<td colspan="3" width="240" bgcolor="#cce5ff" style="">Approximate date to begin project:</td>
		<td colspan="2" width="105" bgcolor="#cce5ff" style=""></td>
	</tr>
	<tr>
		<td colspan="2" width="334" height="4" bgcolor="#ffffff" style="">Please see Proposal Document and Scope of Work</td>
		<td colspan="3" width="240" bgcolor="#cce5ff" style="">Approximate project time:</td>
		<td colspan="2" width="105" bgcolor="#cce5ff" style="">Consecutive Days</td>
	</tr>
	<tr>
		<td colspan="2" width="334" height="16"  bgcolor="#ffffff" style=""></td>
		<td colspan="5" width="359"  bgcolor="#cce5ff" style="">Substantial commencement of work shall be deemed to be job site set-up and commencement of painting preparation work.</td>
	</tr>
	<tr>
		<td colspan="2" width="334" height="7" bgcolor="#c0c0c0" style="">TOTAL COST</td>
		<td colspan="5" width="359" bgcolor="#c0c0c0" style="">DEPOSIT</td>
	</tr>
	<tr>
		<td rowspan="2" width="225" height="3" bgcolor="#ffffff" style="">Customer agrees to pay contractor a total cash price of:</td>
		<td rowspan="2" width="95" bgcolor="#ffffff" style="">$</td>
		<td rowspan="2" colspan="3" width="240" bgcolor="#ffffff" style="">Due upon approval of proposal:</td>
		<td rowspan="2" colspan="2" width="105" bgcolor="#ffffff" style="">$</td>
	</tr>
	<tr>
		<td width="225" height="9" bgcolor="#ffffcc" style="">PAYMENTS:</td>
		<td width="95" bgcolor="#ffffcc" style="">AMOUNT:</td>
		<td rowspan="3" colspan="5" width="359" bgcolor="#99ccb2" style="">We will schedule your work once we receive a copy of this agreement and the requested deposit listed above. Please make checks payable to Company Name</td>
	</tr>
	<tr>
		<td width="225" height="9" bgcolor="#ffffcc" style="">Start Up Payment:</td>
		<td width="95"  bgcolor="#ffffcc" style="">$</td>
	</tr>
	<tr>
		<td width="225" height="1" bgcolor="#ffffcc" style="">&nbsp;</td>
		<td width="95"  bgcolor="#ffffcc" style="">&nbsp;</td>
	</tr>
	<tr>
		<td width="225" height="9" bgcolor="#ffffcc" style="">Final Payment Upon Completion:</td>
		<td width="95"  bgcolor="#ffffcc" style="">$</td>
		<td colspan="5" width="359" bgcolor="#99ccb2" style="">Additional Payment Plans are available.</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="25" bgcolor="#ffffff" style="">Upon	satisfactory payment being made for any portion of the work	performed, the contractor shall, prior to any further payment being made, furnish a full and unconditional release for any claim or mechanic’s lien pursuant to Section 3114 of the California Civil Code.</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="7" bgcolor="#c0c0c0" style="">TERMS	AND CONDITIONS AND ATTACHMENTS</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="22" bgcolor="#ffffff" style="">The Terms and Conditions following and all Attachments are expressly incorporated into this Agreement. This Agreement constitutes the entire understanding of the parties and no other understanding or representations, oral or otherwise shall be recognized as part of this agreement.</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="7" bgcolor="#c0c0c0" style="">ACCEPTANCE</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="19"  bgcolor="#ffffff" style="">Authorized Signature: ________________________________                Date:
			_______________________</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="3"  bgcolor="#ffffff" style="">(NOTE: This contract will expire if not accepted within 30 days of the date signed by Contractor.)</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="6"  bgcolor="#ffffff" style="">You’re hereby authorized to perform the work specified in this Proposal &amp; Agreement, for which I/we agree to pay the contract price &amp; according to the terms.</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="17" bgcolor="#ffffff" style="">Any alteration or deviation from the above specifications, including	but not limited to any such alteration or deviation involving additional material and/or labor costs, will be executed only upon written order for same, signed by Owner and Contract</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="19" bgcolor="#ffffff" style="">If any payment is not made when due, Contractor may suspend work on the job until such time as all payments have been made.  A failure to make payment for a period in excess of 3 days from the due date of the payment shall be deemed a material breach</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="24" bgcolor="#ffffcc" style="">I/we	have read and agree to the provisions of this Proposal and Agreement and acknowledge receipt of the following: (1) Notice to Owner and Warranty, (2) Exterior Proposal,  (3) Notice of Cancellation</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="10"  bgcolor="#ffffcc" style="">X_________________________________________ Date of Acceptance:___________________________</td>
	</tr>
	<tr>
		<td colspan="7" width="707"  bgcolor="#ffffcc" style="">Customer(Owner)</td>
	</tr>
	<tr>
		<td colspan="7" width="707" height="21" bgcolor="#ffffcc" style="">You the buyer (Owner), may cancel this transaction at any time prior to midnight of the third business day after the date of this transaction.  Or, if this is a contract for the repair of damages resulting from an earthquake, flood, fire, hurricane, riot.</td>
	</tr>
</tbody></table>
<p class="western" style=""><br>
</p>
<p class="western" style="">Fax signed copy to YOUR FAX NUMBER to reserve your painting project start date.</p>
<p class="western" style="">Please make deposit check payable to:YOUR COMPANY NAME YOUR COMPANY ADDRESS</p>
<p style=""><br>
</p>
<p style="; page-break-before: always">Work tandard</p>
<ol><li>Your Company Nameis a member of the Painting and Decorating Contractors of America and upholds the standard set forth by the PDCA.</li>
	<li>All work is to be completed in a workman like manner according to standard practices.
</li>
	<li>Work procedures as per standards of the PDCA (Painting and Decorating
	Contractors of America) P1-92, P2-92, P3-93, P4-94, P5-94, P7-98 and
	P6-99 and all other standards by reference (Standards can be
	obtained at www.pdca.org).
	</li><li>The painting contractor will produce a “properly painted surface”.  A
	“properly painted surface” is one that is uniform in color and sheen.  It is one that is free of foreign
	material, lumps, skins, sags, holidays, misses, strike-through, or
	insufficient coverage.  It is a surface that is free of drips,
	spatters, spills, or over-spray which the contractors’ workforce
	causes.  Compliance to meeting the criteria of a “properly
	painted surface” shall
	be determined when viewed without magnification at a distance of
	five feet or more under normal lighting conditions and from a normal
	viewing position
</li>
<p class="western" style=""><br>
</p>
<p style="">Customer
Responsibility:</p>
	<li>Please take specific note of job description.
</li>
	<li>Colors must be chosen one (1) week prior to start date.  An additional cost will
	be charged for color changes made after commencement of work.
</li>
	<li>All landscape items, trees, bushes… etc. are to be cut back so as not
	to touch the surface of the project prior to proceeding with
	painting work.>
</li>
	<li>Alarms and automatic sprinkler systems must be turned off while work is in
	progress.
</li>
	<li>Your Company Name is not responsible for damage to Spanish tile roofs (or any other
	roof systems).  Every precaution will be made to not break tiles,
	but it is not guaranteed that there will be no tile damage.
</li>
<p style=""><br>
</p>
<p style="">Notes about the job:</p>
	<li>Amount above assumes that the existing paint is lead free.  Amount subject
	to change if lead is found in any of the existing paint.
	</li><li>At the completion of the painting work, our trained foreman will
	carefully inspect all surfaces to insure our quality standards have
	been met.  This way, the customer will see only a high quality
	finished result.
</li>
	<li>This contract is based on a regular workweek of Monday through Friday,
	standard business hours.  If your project requires a different time
	schedule, this will need to be discussed for additional charges.
</li>
	<li>We understand that the scope of work calls for a certain amount of
	coats per surface to ensure proper coverage.  In certain situations
	of color/finish selection or type of surface being painted, the
	allowed amounts of coats may not cover per the estimated scope of
	work.  If this situation occurs, the customer will be notified and
	informed that additional coats will be required to ensure proper
	coverage and a professional looking paint job.
</li>
	<li>Complete
	clean up will be strictly observed at the end of each working day. 
	All paint materials and tools will be moved or stored in a location
	as directed by the customer at the end of each day so as to minimize
	interruption of our customer’s personal life style.
	<li>This contract is for completing the job as described above and is based on visually observed conditions.  Should any unforeseen conditions arise that could not be determined at the time of the estimate, but 	does occur at any time for the duration of the project, the customer will be notified and a firm price will be given at that time.
</li>
	<li>Pressure wash all surfaces scheduled for painting.  The owners should be aware that when pressure washing is done, water is applied at angles	not common to weather which will may cause temporary leaking. For this reason, we strongly advise the customer to remove any items from around doors and windows that may be damaged by water. CLEANING WINDOWS IS NOT INCLUDED IN CONTRACT AMOUNT.  Windows can be cleaned once job is completed at an additional cost.
</li>
<p style=""><br>
</p>
<p style="">Additional
Work Orders:</p>
	<li>If
	after you agree to this work, you desire any changes of additional
	work, please contact us as the cost of all revisions must be agreed
	upon in writing.  Workers are instructed not to undertake additional
	work without authorization.
</li>
	<li>It is essential that the work area be available to us, free from other trades. As a result of trade interference, Your Company Name may leave the job and additional charges may be incurred.
</li>
	<li>All
	work is to be performed according to standard painting sequencing and work flow. If interruptions occur, additional charges may be incurred.</p>
</li></ol>
<p align="CENTER" style="">Additional Provisions</p>
<table width="746" cellpadding="7" cellspacing="0">
	<tbody><tr>
		<td width="345" height="760" bgcolor="#ffffff" style="">Unless otherwise specified herein, the following additional provisions are expressly incorporated into this contract
			1.Outside Agency Circumstances:  Any changes required by an outside agency such as the government, EPA,inspection service or the like will be considered additional work
			which are to be paid by the owner.
			2.Installation: Owner understands the Contractor may or may not install the materials. Contractor has the right to subcontract any part of, or all of the work herein.
			3.Change Orders: Should owner, or other authorized individual under this contract require any modification to the work covered under this contract, any cost incurred by Contractor shall be added to the contract price as extra work and Owner agrees to pay Contractor his normal selling price for such extra work.  All extra work as well as any other modifications to the original contract shall be specified and approved by both parties in a written change order.  All change orders shall become a part of this contract and shall be incorporated herein.
			4.Owners Responsibility / Insurance etc.: Owner is responsible for the following (1) to see that all necessary water, electrical power, access to premises, refuse removal services, and toilet	facilities are provided on the premises. (2) to provide a storage area on the premises for equipment and materials (3) to, prior to	work, remove or relocate any item that prevents contractor from	having free access to the work areas such as pictures, artwork,	decorative items, furniture, appliances, draperies, clothing,plants, or any other personal effects and properties.  In the event the Owner fails to relocate items, contractor may relocate these items as required but in no way is contractor responsible for damage to these items during their relocation and during the performance of the work. (4) to obtain permission from the	owner(s) of adjacent properties that contractor must use to gain access to the work areas. Owner agrees to be responsible and to hold the contractor harmless and accept any risk resulting from the use of adjacent property by contractor. (5) to correct any existing defects which are recognized during the course of the work. Contractor shall have no liability for correcting any existing defects such as, but not limited to dry rot, structural	defects, or code violations. (6) to maintain property insurance	with Fire, course of construction, all physical loss with vandalism and malicious mischief clauses attached, in a sum at least equal to the contract price, prior to and during performance	of this contract. If the project is destroyed or damaged by an accident, disaster or calamity, or by theft or vandalism, any work or material supplied by contractor in repairing or repainting the	project shall be paid for by the owner as extra work.
			5. Delay: Contractor shall not be held responsible for any damage occasioned by delays resulting from work done by owners subcontractors, extra work, acts of owner or owners agent including failure of owner to make timely progress payments or payments for extra work, shortages of material and/or labor, bad weather, fire, strike, war, governmental regulations, or any other contingencies unforeseen by contractor or beyond contractors reasonable control.
			6.Surplus Materials: Any surplus material (except necessary touch up amounts) left over after this contract has been completed are the property of contractor and will be removed by the same. No credit is due owner on returns for any surplus materials because this contract is	based upon a complete job.  All salvage resulting from work under this contract is the property of the contractor.
			7.Cleanup and Displaying Signs: Upon completion, and after removing all debris and surplus materials, contractor will leave premises in a neat, broom clean condition. 	Owner hereby grants to contractor the right to display signs and advertise at the job site for the period of time starting at the date of signing of this contract and continuing uninterrupted	until fourteen (14) days past the date the job is completed and	payment in full has been made.
			8.Method of Application and Paint Colors: Owner authorizes contractor to use any method of paint application that contractor deems appropriate, weather it be brush, pad, roller, spray or a combination thereof.  Where colors and sheen factors are to be	matched, contractor shall make reasonable efforts to do so but does not guarantee a perfect match.  At the written request of owner, contractor shall provide a sample of any paint for approval by owner.  If the owner does not request a paint sample, contractor is authorized to apply manufacturer’s standard paint as identified in this contract and is not responsible for any	differences between the manufacturer’s color chart and the paint as it is applied.
			9.
			 Hazardous Substances: Owner understands that contractor is not qualified as a hazardous material handler or inspector or as a hazardous material abatement	contractor.  Should any hazardous substances as defined by the government be found to be present on the premises, it is the owners responsibility to arrange and pay for abatement of these	substances.
			10.
			 Right to Stop Work: If
			any payment is not made to contractor as per this contract,
			contractor shall have the right to stop work and keep the job idle
			until all past due progress payments are received.  Contractor is
			further excused by owner from paying any material, equipment
			and/or labor suppliers or any subcontractors (hereinafter
			collectively called suppliers).  If these same suppliers make
			demand upon owner for payment, owner may not make such payment on
			behalf of contractor without contractor approval at which time the
			contractor may access a late payment penalty by not reimbursing
			the customer the amount paid to the suppliers.  The owner is
			responsible to verify the true amounts owed to the contractor and
			to these same suppliers prior to making payment.  Owner shall not
			be entitled, under any circumstances, to collect as reimbursement
			from contractor any amount greater than that exact amount actually
			and truly owned by contractor to the same suppliers for work done
			on owners project.
			11.
			 Payment: Payments
			shall be made per Sec. 7159 (f) on the California Business and
			Professions Code, upon satisfactory payment being made for any
			portion of the work performed, the contractor shall prior to any
			further payment being made, furnish to the person contracting  for
			this home improvement, a full and unconditional release from any
			claim or mechanic’s lien pursuant to Section 3114 of the Civil
			Code for that portion of the work for which payment has been made.
			12.
			Collection: Owner
			agrees to pay all collection fees and charges including but not
			limited to all legal and attorney fees that result should owner
			default in payment of this contract.  Overdue accounts are subject
			to interest charged at the rate of 24% per annum.  Deposit is
			forfeited upon cancellation of job by owner.
			13.
			 Legal Fees: In
			the event litigation arises out of this contract, prevailing
			party(ies) are entitled to a legal, arbitration, and attorney
			fees.  The court shall not be bound to award fees based on any
			set, court fee schedule but shall if it so chooses, award the true
			amount of all cost, expenses and attorney fees paid or incurred.
		</td>
		<td width="4" bgcolor="#ffffff" style=""></td>
		<td width="352" bgcolor="#ffffff" style="">
			14.
			Notice: Any notice
			required or permitted under this contract may be given by ordinary
			mail at the address of both parties contained on page one of this
			contract. This address may be changed from time to time by written
			notice given by one party to the other.  After a notice is
			correctly posted and deposited in the mail, it shall be deemed
			received by the other party after one (1) day.
			15. Sever
			ability If
			any clause contained within this contract is rendered null and
			void, that clause shall not render the entire contract null and
			void.
			NOTICE
			TO OWNER – LIEN DISCLOSURE: 
			Under
			the California Mechanics’ Lien Law, any contractor,
			subcontractor, laborer, supplier, or other person or entity who
			helps to improve your property, but is not paid for his or her
			work or supplies, has a right to place a lien on your home, land,
			or property where the work was performed and to sue you in court
			to obtain payment. This means that after a court hearing, your
			home, land, and property could be sold by a court officer and the
			proceeds of the sale used to satisfy what you owe.  This can
			happen even if you have paid your contractor in full if the
			contractor’s subcontractors, Laborers, or suppliers remain
			unpaid.  To
			preserve their right to file a claim or lien against your
			property, certain claimants such as subcontractors or material
			suppliers are each required to provide you with a document called
			a “preliminary Notice”.  Contractors and laborers who contract
			with owners directly do not have to provide such notice since you
			are aware of their existence as an owner.  A preliminary notice is
			not a lien against your property.  Its purpose is to notify you of
			persons or entities that may have a right to file a lien against
			your property if they are not paid. In order to protect their lien
			rights, a contractor, subcontractor, supplier, or laborer must
			file a mechanic’s lien with the county recorder, which then
			becomes a recorder lien against your property. Generally, the
			maximum time allowed for filing a mechanic’s lien against your
			property is 90 days after substantial completion of your project.
			CUSTOMER PROTECTION: To
			insure extra protection for yourself and your property, you may
			whish to take one or more of the following precautionary steps:
			(1)
			 Require that your contractor supply you with a payment and
			performance bond (not a license bond), which provides that the
			bonding company will either complete the project or pay damages up
			to the amount of the bond.  This payment and performance bond as
			well as a copy of the construction contract should be filed with
			the county recorder for your future protection.  They payment and
			performance bond will usually cost from 1 to 5 percent of the
			contract amount depending on the contractor’s bonding ability. 
			If a contractor cannot obtain such bonding, it may indicate his or
			her financial incapacity.
			(2)
			 Require that payments be made directly to subcontractors and
			material suppliers through a joint control. Funding services may
			be available for a fee in your area which will establish voucher
			or other means of payment to your contractor.  These services may
			also provide you with lien waivers and other forms of protection. 
			Any joint control agreement should include the addendum approved
			by the registrar.
			(3)
			 Issue joint checks for payment, made out to both your contractor
			and subcontractors or material suppliers involved in the project. 
			The joint checks should be made payable to the persons or entities
			which send preliminary notices to you.  Those persons or entities
			have indicated that they may have lien rights on your property,
			therefore you need to protect yourself. This will help to insure
			that all persons due payment are actually paid.
			(4)
			 Upon making payment on any completed phase of the project, and
			before making any further payments, require your contractor to
			provide you with unconditional “Waiver and Release” forms
			signed by each material supplier, subcontractor, and laborer
			involved in that portion of the work for which payment was made.
			The statutory lien releases are set forth in exact language in
			Section 3262 of the Civil Code.  Most stationary stores will sell
			the “Waiver and Release” forms if your contractor does not
			have them.  The material suppliers, subcontractors, and laborers
			that you obtain releases from are those suppliers, contractors and
			laborers working on your project, you may obtain a list from your
			contractor.  On projects involving improvements to a single-family
			residence or a duplex owned by the individuals, the person signing
			these releases lose the right to file a mechanic’s lien claim
			against your property.  In other types of construction, this
			protection may still be important but may not be as complete.
			To
			protect yourself under this option you must be certain that all
			material suppliers, subcontractors, and laborers have signed the
			“waiver and Release” form.  IF a mechanic’s lien has been
			filed against your property, it can only be voluntarily released
			by a recorded “release of Mechanic’s Lien” signed by the
			person or entity that filed the mechanic’s lien against your
			property unless the law suit to enforce the lien was not timely
			filed. When making final payments, you should have the release
			form signed and make sure any and all such liens are removed.  You
			should consult an attorney if a lien is filed against your
			property.
		</td>
	</tr>
</tbody></table>
<p align="JUSTIFY" style="">Contractors are required by law to be licensed and regulated by the contractors
state license board, which has jurisdiction to investigate complaints
against contractors if a complaint regarding a patent act or omission
is filed within four years of the date of the alleged violation.  A
complaint regarding a latent act or omission pertaining to structural
defects must be filed within 10 years of the date of the alleged
violation.  Any questions concerning a contractor may be referred to
the registrar, contractors state license board, P.O. Box 26000,
Sacramento, CA 95826-0026.  State law requires anyone who contracts
to do construction work to be licensed by the contractors’ state
license board in the license category in which the contractor is
going to be working. If the total price of the job is $300 or more
(including labor and materials).  Licensed contractors are regulated
by laws designed to protect the public.  The board has offices
throughout California.  Please check the government pages of the
white pages for the office nearest you or call 1-800-321-CSLB for
more information.</p>
<p class="western" style=""><br>
</p>
<ol>
	<ol>
		<ol>
			<li><h3 class="western" style="background: #ffffff; line-height: 0.22in">
			</h3>
		</li></ol>
	</ol>
</ol>';
// $html = file_get_contents('test/table.html');
 
// New Word Document:
$phpword_object = new PHPWord();
$section = $phpword_object->createSection();

// HTML Dom object:
$html_dom = new simple_html_dom();
$html_dom->load('<html><body style="font-family:Times New Roman">' . $html . '</body></html>');
// Note, we needed to nest the html in a couple of dummy elements.

// Create the dom array of elements which we are going to work on:
$html_dom_array = $html_dom->find('html',0)->children();

// We need this for setting base_root and base_path in the initial_state array
// (below). We are using a function here (derived from Drupal) to create these
// paths automatically - you may want to do something different in your
// implementation. This function is in the included file 
// documentation/support_functions.inc.
$paths = htmltodocx_paths();

// Provide some initial settings:
$initial_state = array(
  // Required parameters:
  'phpword_object' => &$phpword_object, // Must be passed by reference.
  // 'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
  // 'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.
  'base_root' => $paths['base_root'],
  'base_path' => $paths['base_path'],
  // Optional parameters - showing the defaults if you don't set anything:
  'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
  'parents' => array(0 => 'body'), // Our parent is body.
  'list_depth' => 0, // This is the current depth of any current list.
  'context' => 'section', // Possible values - section, footer or header.
  'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
  'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
  'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
  'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
  'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
  'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.
      
  // Optional - no default:    
  'style_sheet' => htmltodocx_styles_proposal(), // This is an array (the "style sheet") - returned by htmltodocx_styles_proposal() here (in styles.inc) - see this function for an example of how to construct this array.
  );    

// Convert the HTML and put it into the PHPWord object
htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);

// Clear the HTML dom object:
$html_dom->clear(); 
unset($html_dom);

// Save File
$h2d_file_uri = tempnam('', 'htd');
$objWriter = PHPWord_IOFactory::createWriter($phpword_object, 'Word2007');
$objWriter->save($h2d_file_uri);

// Download the file:
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=example.docx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($h2d_file_uri));
ob_clean();
flush();
$status = readfile($h2d_file_uri);
unlink($h2d_file_uri);
exit;