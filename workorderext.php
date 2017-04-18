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
$table888 = "external_estimate";
if(isset($_REQUEST['project_id'])){
	$condition888 = "i.project_id = '".$_REQUEST['project_id']."' ";
	$main_table888 = array("$table888 i",array("i.*","sum(i.scraping_time) as sum_scraping_time","sum(i.patch_time) as sum_patch_time","sum(i.feather_time) as sum_feather_time","sum(i.flexible_time) as sum_flexible_time","sum(i.caulking_time) as sum_caulking_time","sum(i.pressure_time) as sum_pressure_time","sum(i.roof_time) as sum_roof_time","sum(i.spot_time) as sum_spot_time","sum(i.remove_lights_time) as sum_remove_lights_time","sum(i.remove_screens_time) as sum_remove_screens_time","sum(i.remove_other_time) as sum_remove_other_time","sum(i.wash_time) as sum_wash_time","sum(i.pressurewashdeck_time) as sum_pressurewashdeck_time","sum(i.maskwindowsdoors_time) as sum_maskwindowsdoors_time","sum(i.maskother_time) as sum_maskother_time","sum(i.eavessingle_time) as sum_eavessingle_time","sum(i.eavestwo_time) as sum_eavestwo_time","sum(i.eaveseasy_time) as sum_eaveseasy_time","sum(i.eaveshard_time) as sum_eaveshard_time","sum(i.fasciasingle_time) as sum_fasciasingle_time","sum(i.fasciatwo_time) as sum_fasciatwo_time","sum(i.metalflashing_time) as sum_metalflashing_time","sum(i.raingutters_time) as sum_raingutters_time","sum(i.shutters_time) as sum_shutters_time","sum(i.windowstrim_time) as sum_windowstrim_time","sum(i.windows2pane_time) as sum_windows2pane_time","sum(i.windows37pane_time) as sum_windows37pane_time","sum(i.windows815pane_time) as sum_windows815pane_time","sum(i.windows16pane_time) as sum_windows16pane_time","sum(i.doorsflat_time) as sum_doorsflat_time","sum(i.doorslight_time) as sum_doorslight_time","sum(i.doorspaneled_time) as sum_doorspaneled_time","sum(i.doorsfrench_time) as sum_doorsfrench_time","sum(i.garagedoor_time) as sum_garagedoor_time","sum(i.garagedoorframe_time) as sum_garagedoorframe_time","sum(i.entrydoor_time) as sum_entrydoor_time","sum(i.postspillars_time) as sum_postspillars_time","sum(i.wroughtiron_time) as sum_wroughtiron_time","sum(i.miscellaneous1_time) as sum_miscellaneous1_time","sum(i.miscellaneous2_time) as sum_miscellaneous2_time","sum(i.stuccosingle_time) as sum_stuccosingle_time","sum(i.stuccotwo_time) as sum_stuccotwo_time","sum(i.sidingsingle_time) as sum_sidingsingle_time","sum(i.sidingtwo_time) as sum_sidingtwo_time","sum(i.bodypaint_time) as sum_bodypaint_time"));
	$join_tables888 = array(
		array('left',' projects p','p.id = i.project_id', array('p.alt_phone as alterphone','p.Address as address','p.Zip as zipcode','p.created_by as user_id')),
		array('left',' client r','r.id = p.Client_id', array('r.name as client_name','r.phonenumber as phonenum','r.email as mailid')),
		array('left',' location r1','r1.location_id = p.City', array('r1.name as city_name')),
		array('left',' location r2','r2.location_id = p.State', array('r2.name as state_name')),
		array('left',' location r3','r3.location_id = p.country', array('r3.name as country_name')),
		array('left',' int_estimates r4','r4.id = i.estimate_id', array('r4.SpaceType as room_id','r4.Cost as costadd')),
		array('left',' room_types r5','r5.id = r4.SpaceType', array('r5.name as room_name'))
		/*array('left',' users r6','r6.id = p.created_by', array('r6.frist_name as f_name','r6.last_name as l_name'))*/
	);
	$rs11 = $db->JoinFetch($main_table888, $join_tables888, $condition888);
	
	$all= "";
	$clientdetails = "<strong>";
	$cost= 0;
	$val = $db->FetchToArray("default_production_rate","*","project_id='193'"); 
	$production_rate = array();
	for($i = 0; $i < sizeof($val) ; $i++)
	{
		$production_rate[$val[$i]['production_item']]['description'] = $val[$i]['description'];
	}
while($row11 = mysql_fetch_array($rs11)){
	/*$cost += $row11['costadd'];
	$all .= "<strong>".$row11['room_name']."</strong><br/>";
	$clientname = $row11['client_name'];
	$clientphone = $row11['phonenum'];
	$clientaltphone = $row11['alterphone'];	
	$clientaddress = $row11['address'];	
	$clientemail = $row11['mailid'];	
	$clientcity = $row11['city_name'];	
	$clientstate = $row11['state_name'];	
	$clientcountry = $row11['country_name'];	
	$clientzip = $row11['zipcode'];	*/
	
	$clientdetails .= $row11['client_name'].'<br/>';
	$clientdetails .= $row11['address'].",".$row11['city_name'].'<br/>';
	$clientdetails .= $row11['state_name'].",".$row11['country_name'].'<br/>';
	$clientdetails .= "Primary Phone:".$row11['phonenum'].'<br/>';
	$clientdetails .= "Alternate Phone:".$row11['alterphone'].'<br/>';
	$clientdetails .= "Email:".$row11['mailid'].'<br/>';
	$clientdetails .= "Estimator:".$row11['f_name']." ".$row11['l_name'].'<br/></strong>';
	
	if(isset($row11['scraping_time'])){ 
		$all .=  $production_rate['Scraping & Sanding']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_scraping_time'] .'<br/>';
	}
	if(isset($row11['patch_time'])){ 
		$all .=  $production_rate['Patch Stucco']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_patch_time'] .'<br/>';
	}
	if(isset($row11['feather_time'])){ 
		$all .=  $production_rate['Feather Sanding']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_feather_time'] .'<br/>';
	}
	if(isset($row11['flexible_time'])){ 
		$all .=  $production_rate['Flexible Epoxy']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_flexible_time'] .'<br/>';
	}
	if(isset($row11['caulking_time'])){ 
		$all .=  $production_rate['Caulking']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_caulking_time'] .'<br/>';
	}
	if(isset($row11['pressure_time'])){ 
		$all .=  $production_rate['Pressure Wash']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_pressure_time'] .'<br/>';
	}
	if(isset($row11['roof_time'])){ 
		$all .=  $production_rate['Roof Ladder Time']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_roof_time'] .'<br/>';
	}
	if(isset($row11['spot_time'])){ 
		$all .=  $production_rate['Spot Prime']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_spot_time'] .'<br/>';
	}
	if(isset($row11['remove_lights_time']) || $row11['remove_screens_time'] != "" || $row11['remove_other_time'] != ""){ 
		$sum = $row11['sum_remove_lights_time'] + $row11['sum_remove_screens_time'] + $row11['sum_remove_other_time'];
		$all .=  $production_rate['Remove Replace Lights']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['wash_time'])){ 
		$all .=  $production_rate['Wash Windows']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_wash_time'] .'<br/>';
	}
	if(isset($row11['pressurewashdeck_time'])){ 
		$all .=  $production_rate['Pressure Wash Deck']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_pressurewashdeck_time'] .'<br/>';
	}
	if(isset($row11['maskwindowsdoors_time'])){ 
		$all .=  $production_rate['Mask Windows Doors']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_maskwindowsdoors_time'] .'<br/>';
	}
	if(isset($row11['maskother_time'])){ 
		$all .=  $production_rate['Mask Other']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_maskother_time'] .'<br/>';
	}
	if(isset($row11['eavessingle_time']) || $row11['eavestwo_time'] != "" || $row11['eaveseasy_time'] != "" || $row11['eaveshard_time'] != "" ){ 
		$sum = $row11['sum_eavessingle_time'] + $row11['sum_eavestwo_time'] + $row11['sum_eaveseasy_time'] + $row11['sum_eaveshard_time'];
		$all .=  $production_rate['Eaves Single Story']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['fasciasingle_time']) || $row11['fasciatwo_time'] != ""){ 
		$sum = $row11['sum_fasciasingle_time'] + $row11['sum_fasciatwo_time'];
		$all .=  $production_rate['Fascia Single Story']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['metalflashing_time'])){ 
		$all .=  $production_rate['Metal Flashing']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_metalflashing_time'] .'<br/>';
	}
	if(isset($row11['raingutters_time'])){ 
		$all .=  $production_rate['Rain Gutters Downspouts']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_raingutters_time'] .'<br/>';
	}
	if(isset($row11['shutters_time'])){ 
		$all .=  $production_rate['Shutters']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_shutters_time'] .'<br/>';
	}
	if(isset($row11['windowstrim_time']) || $row11['windows2pane_time'] != "" || $row11['windows37pane_time'] != "" || $row11['windows815pane_time'] != "" || $row11['windows16pane_quantity'] != ""){ 
		$sum = $row11['sum_windowstrim_time'] + $row11['sum_windows2pane_time'] + $row11['sum_windows37pane_time'] + $row11['sum_windows815pane_time'] + $row11['sum_windows16pane_quantity'];
		$all .=  $production_rate['Windows Trim']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['doorsflat_time']) || $row11['doorslight_time'] != "" || $row11['doorspaneled_time'] != "" || $row11['doorsfrench_time'] != "" ){ 
		$sum = $row11['sum_doorsflat_time'] + $row11['sum_doorslight_time'] + $row11['sum_doorspaneled_time'] + $row11['sum_doorsfrench_time'];
		$all .=  $production_rate['Doors Flat']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['garagedoor_time'])){ 
		$all .=  $production_rate['Garage Door']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_garagedoor_time'] .'<br/>';
	}
	if(isset($row11['garagedoorframe_time'])){ 
		$all .=  $production_rate['Garage Door Frame']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_garagedoorframe_time'] .'<br/>';
	}
	if(isset($row11['entrydoor_time'])){ 
		$all .=  $production_rate['Entry Door or Frame Only']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_entrydoor_time'] .'<br/>';
	}
	if(isset($row11['postspillars_time']) && $row11['postspillars_coats'] != "" ){ 
		$all .=  $production_rate['Posts or Pillars']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_postspillars_time'] .'<br/>';
	}
	if(isset($row11['wroughtiron_time'])){ 
		$all .=  $production_rate['Wrought Iron']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_wroughtiron_time'] .'<br/>';
	}
	if(isset($row11['stuccosingle_time']) || $row11['stuccotwo_time'] != ""){ 
		$sum = $row11['sum_stuccosingle_time'] + $row11['sum_stuccotwo_time'];
		$all .=  $production_rate['Stucco Single Story']['description'].' - Apply | Coats<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['sidingsingle_time']) || $row11['sidingtwo_time'] != "" ){ 
		$sum = $row11['sum_sidingsingle_time'] + $row11['sum_sidingtwo_time'];
		$all .=  $production_rate['Siding Single Story']['description'].' - Apply | Coats<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['bodypaint_time'])){ 
		$all .=  $production_rate['Body Paint: +/- Time']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_bodypaint_time'].'<br/>';
	}
	if(isset($row11['miscellaneous1_time']) || $row11['miscellaneous2_time'] != "" || $row11['miscellaneous3_time'] != ""){ 
		$sum = $row11['sum_miscellaneous1_time'] + $row11['sum_miscellaneous2_time'] + $row11['sum_miscellaneous3_time'];
		$all .=  'Miscellaneous <br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	$all .="<br/>";
}
}

$html = '<p class="">JOB DETAILES  </p>
<table>
 <tr>
	<td width=500>
		<table>
			<tr>
				<td>'.$clientdetails.'</td>
			</tr>
		</table>
	</td>
 </tr>
</table>
<h2 style="text-decoration: underline;">WORK To Be Perform:</h2>
<table>
 <tr>
	<td width=1000>
		<table>
			<tr>
				<td>'.$all.'</td>
			</tr>
		</table>
	</td>
 </tr>
</table>
';
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