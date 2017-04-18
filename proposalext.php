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
/*require_once 'documentation/support_functions.inc';*/
require_once 'classes/htmltodocx/documentation/support_functions.inc';

require $_SERVER['DOCUMENT_ROOT'].'/onestepnew/application/control/include_classes.php';


$db = new Db();
$row11 = array();
$table888 = "external_estimate";
if(isset($_REQUEST['project_id'])){
	$condition888 = "i.project_id = '".$_REQUEST['project_id']."' ";
	$main_table888 = array("$table888 i",array("i.*"));
	$join_tables888 = array(
		array('left',' projects p','p.id = i.project_id', array('p.alt_phone as alterphone','p.Address as address','p.Zip as zipcode')),
		array('left',' client r','r.id = p.Client_id', array('r.name as client_name','r.phonenumber as phonenum','r.email as mailid')),
		array('left',' location r1','r1.location_id = p.City', array('r1.name as city_name')),
		array('left',' location r2','r2.location_id = p.State', array('r2.name as state_name')),
		array('left',' location r3','r3.location_id = p.country', array('r3.name as country_name')),
		array('left',' ext_estimates r4','r4.id = i.estimate_id', array('r4.SpaceType as room_id','r4.Cost as costadd')),
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
		
		if(isset($row11['scraping_quantity'])){ 
			$all .=  $production_rate['Scraping & Sanding']['description'].'<br/>';
		}
		if(isset($row11['patch_quantity'])){ 
			$all .=  $production_rate['Patch Stucco']['description'].'<br/>';
		}
		if(isset($row11['feather_quantity'])){ 
			$all .=  $production_rate['Feather Sanding']['description'].'<br/>';
		}
		if(isset($row11['flexible_quantity'])){ 
			$all .=  $production_rate['Flexible Epoxy']['description'].'<br/>';
		}
		if(isset($row11['caulking_quantity'])){ 
			$all .=  $production_rate['Caulking']['description'].'<br/>';
		}
		if(isset($row11['pressure_quantity'])){ 
			$all .=  $production_rate['Pressure Wash']['description'].'<br/>';
		}
		if(isset($row11['roof_quantity'])){ 
			$all .=  $production_rate['Roof Ladder Time']['description'].'<br/>';
		}
		if(isset($row11['spot_quantity'])){ 
			$all .=  $production_rate['Spot Prime']['description'].'<br/>';
		}
		if(isset($row11['remove_lights_quantity'])){ 
			$all .=  $production_rate['Remove Replace Lights']['description'].'<br/>';
		}
		if(isset($row11['remove_screens_quantity'])){ 
			$all .=  $production_rate['Remove Replace Screens']['description'].'<br/>';
		}
		if(isset($row11['remove_other_quantity'])){ 
			$all .=  $production_rate['Remove Replace Other']['description'].'<br/>';
		}
		if(isset($row11['wash_quantity'])){ 
			$all .=  $production_rate['Wash Windows']['description'].'<br/>';
		}
		if(isset($row11['pressurewashdeck_quantity'])){ 
			$all .=  $production_rate['Pressure Wash Deck']['description'].'<br/>';
		}
		if(isset($row11['maskwindowsdoors_quantity'])){ 
			$all .=  $production_rate['Mask Windows Doors']['description'].'<br/>';
		}
		if(isset($row11['maskother_quantity'])){ 
			$all .=  $production_rate['Mask Other']['description'].'<br/>';
		}
		if(isset($row11['eavessingle_quantity']) && $row11['eavessingle_coats'] != "" ){ 
			$all .=  $production_rate['Eaves Single Story']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['eavestwo_quantity']) && $row11['eavestwo_coats'] != "" ){ 
			$all .=  $production_rate['Eaves Two Story']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['eaveseasy_quantity']) && $row11['eaveseasy_coats'] != "" ){ 
			$all .=  $production_rate['Eaves Easy']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['eaveshard_quantity']) && $row11['eaveshard_quantity'] != "" ){ 
			$all .=  $production_rate['Eaves Hard']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['fasciasingle_quantity']) && $row11['fasciasingle_coats'] != "" ){ 
			$all .=  $production_rate['Fascia Single Story']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['fasciatwo_quantity']) && $row11['fasciatwo_coats'] != "" ){ 
			$all .=  $production_rate['Fascia Two Story']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['metalflashing_quantity']) && $row11['metalflashing_coats'] != "" ){ 
			$all .=  $production_rate['Metal Flashing']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['raingutters_quantity']) && $row11['raingutters_coats'] != "" ){ 
			$all .=  $production_rate['Rain Gutters Downspouts']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['shutters_quantity']) && $row11['shutters_coats'] != "" ){ 
			$all .=  $production_rate['Shutters']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['windowstrim_quantity']) && $row11['windowstrim_coats'] != "" ){ 
			$all .=  $production_rate['Windows Trim']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['windows2pane_quantity']) && $row11['windows2pane_coats'] != "" ){ 
			$all .=  $production_rate['Windows 2 Pane']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['windows37pane_quantity']) && $row11['windows37pane_coats'] != "" ){ 
			$all .=  $production_rate['Windows 3 to 7 Pane']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['windows815pane_quantity']) && $row11['windows815pane_coats'] != "" ){ 
			$all .=  $production_rate['Windows 8 to 15 Pane']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['windows16pane_quantity']) && $row11['windows16pane_coats'] != "" ){ 
			$all .=  $production_rate['Windows 16 or more Pane']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['doorsflat_quantity']) && $row11['doorsflat_coats'] != "" ){ 
			$all .=  $production_rate['Doors Flat']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['doorslight_quantity']) && $row11['doorslight_coats'] != "" ){ 
			$all .=  $production_rate['Doors Light']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['doorspaneled_quantity']) && $row11['doorspaneled_coats'] != "" ){ 
			$all .=  $production_rate['Doors Paneled']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['doorsfrench_quantity']) && $row11['doorsfrench_coats'] != "" ){ 
			$all .=  $production_rate['Doors French']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['garagedoor_quantity']) && $row11['garagedoor_coats'] != "" ){ 
			$all .=  $production_rate['Garage Door']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['garagedoorframe_quantity']) && $row11['garagedoorframe_coats'] != "" ){ 
			$all .=  $production_rate['Garage Door Frame']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['entrydoor_quantity']) && $row11['entrydoor_coats'] != "" ){ 
			$all .=  $production_rate['Entry Door or Frame Only']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['postspillars_quantity']) && $row11['postspillars_coats'] != "" ){ 
			$all .=  $production_rate['Posts or Pillars']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['wroughtiron_quantity']) && $row11['wroughtiron_coats'] != "" ){ 
			$all .=  $production_rate['Wrought Iron']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['stuccosingle_quantity']) && $row11['stuccosingle_coats'] != "" ){ 
			$all .=  $production_rate['Stucco Single Story']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['stuccotwo_quantity']) && $row11['stuccotwo_coats'] != "" ){ 
			$all .=  $production_rate['Stucco Two Story']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['sidingsingle_quantity']) && $row11['sidingsingle_coats'] != "" ){ 
			$all .=  $production_rate['Siding Single Story']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['sidingtwo_quantity']) && $row11['sidingtwo_coats'] != "" ){ 
			$all .=  $production_rate['Siding Two Story']['description'].' - Apply | Coats<br/>';
		}
		if(isset($row11['bodypaint_quantity'])){ 
			$all .=  $production_rate['Body Paint: +/- Time']['description'].'<br/>';
		}
		if(isset($row11['miscellaneous_quantity'])){ 
			$all .=  $production_rate['Miscellaneous']['description'].'<br/>';
		}
		if(isset($row11['miscellaneous1_quantity'])){ 
			$all .=  $production_rate['Miscellaneous']['description'].'<br/>';
		}
		if(isset($row11['miscellaneous2_quantity'])){ 
			$all .=  $production_rate['Miscellaneous']['description'].'<br/>';
		}
		$all .="<br/>";
	}
}

$html = '<p class="">Insert  </p>
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
		<td width=300>'.$clientname.'</td>
		<td width=300>
      	<table>
			<tr>
				<td>'.$clientphone.'</td>
				<td>'.$clientaltphone.'</td>
			</tr>
		</table>
		</td>
	</tr>
    <tr>
		<td width=300>ADDRESS </td>
      	<td width=300>EMAIL </td>
	</tr> 
	<tr>
		<td width=300>'.$clientaddress.'</td>
      	<td width=300 >'.$clientemail.'</td>
	</tr>
	<tr>
		<td width=300>CITY,  STATE , AND ZIP CODE</td>
      	<td width=300>JOB NAME AND ADDRESS (if different)</td>
	</tr>
	<tr>
		<td width=300>'.$clientcity.','.$clientstate.','.$clientcountry.','.$clientzip.'</td>
      	<td width=300>&nbsp;</td>
	</tr>
</table>
<h2 style="text-decoration: underline;">The areas we are proposing to paint (scope of work):</h2>
<p>'.$all.'</p>
<p>*Unless otherwise clearly defined above, all work shall be preformed at the Level 3 Surface Preparation and Finish Appearance standard (see below)</p>
<p class="underline">Excluded:</p>
<ul>
  <li>All exterior concrete floor surfaces</li>
  <li>All chimney, roof and roof mounted items</li>
  <li>All other perimeter fencing and other landscape items</li>
  <li>All other surfaces not specifically mentioned above</li>
</ul>
<p class="underline">Included in our standard procedures:</p>
<ol>
  <li>Pressure wash all surfaces scheduled for painting work as needed</li>
  <li>Trench down 4” below grade wherever stucco meets ground</li>
  <li>Remove exterior lighting prior to painting and reinstall when completed</li>
  <li>All grounds and plants will be covered prior to any painting</li>
  <li>Left over paint will be labeled and left for future touch-ups.</li>
  <li>At the completion, our trained project manager will carefully inspect all surfaces to insure our quality standard has been met.</li>
</ol>
<p class="underline">Levels of Surface Preparation & Finish Appearance</p>
<ul>
  <li>The following levels are used to establish a clearly-communicated standard as to what has been agreed upon and what is to be expected with regards to the different levels of surface preparation and the quality of appearance of the finished surface.  They are a summary of the actual standard based on PDCA (Painting & Decorating Contractors of America) Industry Standard P14-06.</li>
  <li> <strong>Level 1</strong> – Basic: <span class="underline"><i>Cleaned, No Patching </i></span> - Requires only basic cleanliness of surfaces to ensure the adhesion of new finishes, with less concern for the adhesion of existing paint and quality of appearance.  Obvious loose paint will be removed, but no smoothing of the existing surface profile will be done.  Includes light power washing, or hand cleaning. <span class="underline">No Warranty</span></li>
  <li><strong>Level 2</strong> – Standard:<span class="underline"> <i>Basic Patching</i></span> - Requires all of Level 1 as well as the examination of existing coatings to assess their adhesion. With this level of surface preparation, good adhesion and longevity of finish are of primary concern and appearance is of secondary concern. Includes basic patching, filling, caulking, dulling of glossy surfaces, spot priming, and light sanding/abrading to address surface profile differences exceeding 1/8 inch.  Excludes matching stucco textures.</li>
  <li><strong>Level 3 – Superior:<span class="underline"> <i> Detailed Patching</i></span> – Requires all of Levels 1 and 2 with added emphasis on the quality of appearance of finish painted surfaces. Includes detailed patching, filling, approximate matching of stucco textures, and thorough sanding to address surface profile differences exceeding 1/16 inch.  </strong></li>
  <li><strong>Level 4</strong> – Supreme: <span class="underline"><i>Touch & Feel</i></span> – Requires all of Levels 1, 2 and 3 with even more emphasis on the quality of appearance of finish painted surfaces. The criteria for inspection and acceptance may include smoothness to “touch and feel” on doors, windows and easily accessible trim.  Includes thorough filling & sanding to address surface profile differences exceeding 1/32 inch.</li>
  <li><strong>Level 5</strong> – Restoration/Resurfacing: <span class="underline"> <i>Back to Original</i></span> – This type of surface preparation is required when existing conditions indicate that the surfaces are <span class="underline">severely deteriorated</span>(where damage to the coating is widespread).  Includes complete or nearly complete removal of existing paint through various stripping methods.  Substrate (underlying surface being painted) may need to be completely replaced, repaired or resurfaced.</li>
</ul>
<p class="underline">Cost</p>
<ul>
	<li>We propose to furnish material and labor – complete and in accordance with the above specifications for the sum stated below.  Individual tasks, if selected, may require additional pricing.  Price is valid for 30 days, unless otherwise noted</li>
	<li style="vertical-align: right"><strong>Investment for the above:	'.$cost.'$</strong></li>
</ul>
<p class="underline">Colors & Samples</p>
<ul>
  <li>We offer up to 3 - 8”X10” brush outs of your colors choices to help you in your decision making, FREE.   </li>
  <li>If your need more assistance with color, we offer Color Consultations and custom color mixing.  Additional costs do apply.</li>
  <li>This estimate includes up to 3 different colors to the home.</li>
  <li>Due to the conceptual nature of our first meeting and not having a color scheme finalized, additional pricing may be required on color changes, color placement, going from light to deep based colors or the reverse.</li>
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
<p>Please read this proposal carefully and make sure that it contains all the aspects of the job that you want and no additional aspects.  Anything not included in this proposal is excluded.  We want to be as clear as possible to make this project easier for you.  Please let us know of any way we can help. </p>';
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