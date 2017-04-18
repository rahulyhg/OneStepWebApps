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
	$main_table888 = array("$table888 i",array("i.*","sum(i.furniture_time) as sum_furniture_time","sum(i.maskcover_time) as sum_maskcover_time","sum(i.wallpaper_removal_time) as sum_wallpaper_removal_time","sum(i.rrhardware_time) as sum_rrhardware_time","sum(i.prepwoodwork_time) as sum_prepwoodwork_time","sum(i.patchtexture_time) as sum_patchtexture_time","sum(i.skimcoat_time) as sum_skimcoat_time","sum(i.polesand_time) as sum_polesand_time","sum(i.wprime_time) as sum_wprime_time","sum(i.polesand_time) as sum_polesand_time","sum(i.wpaint09_time) as sum_wpaint09_time","sum(i.wpaint9_time) as sum_wpaint9_time","sum(i.cprime_time) as sum_cprime_time","sum(i.cpaint_time) as sum_cpaint_time","sum(i.cw_time_time) as sum_cw_time_time","sum(i.dflat_time) as sum_dflat_time","sum(i.dpaneled_time) as sum_dpaneled_time","sum(i.dfrench_time) as sum_dfrench_time","sum(i.dframes_time) as sum_dframes_time","sum(i.dtime_time) as sum_dtime_time","sum(i.wcasement_time) as sum_wcasement_time","sum(i.w1_1_time) as sum_w1_1_time","sum(i.w3_7_panel_time) as sum_w3_7_panel_time","sum(i.w8_16_panel_time) as sum_w8_16_panel_time","sum(i.w16_panel_time) as sum_w16_panel_time","sum(i.wtime_time) as sum_wtime_time","sum(i.baseboards_time) as sum_baseboards_time","sum(i.baseboardstime_time) as sum_baseboardstime_time","sum(i.chairrail_time) as sum_chairrail_time","sum(i.chairrail_time_time) as sum_chairrail_time_time","sum(i.crownmolding_time) as sum_crownmolding_time","sum(i.crownmolding_time_time) as sum_crownmolding_time_time","sum(i.closets_time) as sum_closets_time","sum(i.cabinetry_time) as sum_cabinetry_time","sum(i.dailybreakdown_time) as sum_dailybreakdown_time","sum(i.cleantouchup_time) as sum_cleantouchup_time","sum(i.bullnosewall_time) as sum_bullnosewall_time","sum(i.bullnosewall_time) as sum_bullnosewall_time","sum(i.miscellaneous1_time) as sum_miscellaneous1_time","sum(i.miscellaneous2_time) as sum_miscellaneous2_time","sum(i.miscellaneous3_time) as sum_miscellaneous3_time","sum(i.faux_time) as sum_faux_time"));
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
	
	if(isset($row11['furniture_time'])){ 
		$all .=  $production_rate['Furniture Treatment']['description'].'<br/><strong>';
		$all .=  "Total Bid Hours".$row11['sum_furniture_time'] .'<br/>';
	}/*
	if(isset($row11['window_quantity'])){ 
		$all .=  $production_rate['Window Treatment']['description'].'<br/>';
	}*/
	if(isset($row11['maskcover_time'])){ 
		$all .=  $production_rate['Mask & Cover']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_maskcover_time'] .'<br/>';	
	}
	if(isset($row11['wallpaper_removal_time'])){ 
		$all .=  $production_rate['Wallpaper Removal']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_wallpaper_removal_time'] .'<br/>';
	}
	if(isset($row11['rrhardware_time'])){ 
		$all .=  $production_rate['R&R Hardware & Lighting']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_rrhardware_time'] .'<br/>';
	}
	if(isset($row11['prepwoodwork_time'])){ 
		$all .=  $production_rate['Prep Woodwork']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_prepwoodwork_time'] .'<br/>';
	}
	if(isset($row11['patchtexture_time'])){ 
		$all .=  $production_rate['Patch & Texture']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_patchtexture_time'] .'<br/>';
	}
	if(isset($row11['skimcoat_time'])){ 
		$all .=  $production_rate['Skim Coat']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_skimcoat_time'] .'<br/>';
	}
	if(isset($row11['polesand_time'])){ 
		$all .=  $production_rate['Pole Sand Walls']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_polesand_time'] .'<br/>';
	}
	if(isset($row11['wprime_time']) || $row11['wpaint09_time'] != "" || $row11['wpaint9_time'] != ""){ 
		$sum = $row11['sum_wprime_time'] + $row11['sum_wpaint09_time'] + $row11['sum_wpaint9_time'];
		$all .=  $production_rate['Walls: Prime']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['cprime_time']) || $row11['cpaint_time'] != "" || $row11['cw_time_time'] != ""){ 
		$sum = $row11['sum_cprime_time'] + $row11['sum_cpaint_time'] + $row11['sum_cw_time_time'];
		$all .=  $production_rate['Ceilings: Prime']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	
	if(isset($row11['dflat_time']) || $row11['dpaneled_time'] != "" || $row11['dfrench_time'] != "" || $row11['dframes_time'] != "" || $row11['dtime_time'] != "" ){ 
		$sum = $row11['sum_dflat_time'] + $row11['sum_dpaneled_time'] + $row11['sum_dfrench_time'] + $row11['sum_dframes_time'] + $row11['sum_dtime_time'];
		$all .=  $production_rate['Doors: Flat']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['wcasement_time']) || $row11['w1_1_time'] != "" || $row11['w3_7_panel_time'] != "" || $row11['w8_16_panel_time'] != "" || $row11['w16_panel_time'] != "" || $row11['wtime_time'] != "" ){ 
		$sum = $row11['sum_wcasement_time'] + $row11['sum_w1_1_time'] + $row11['sum_w3_7_panel_time'] + $row11['sum_w8_16_panel_time'] + $row11['sum_w16_panel_time'] + $row11['sum_wtime_time'];
		$all .=  $production_rate['Windows: Casement']['description'].' <br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['baseboards_time']) || $row11['baseboardstime_time'] != ""){ 
		$sum = $row11['sum_baseboards_time'] + $row11['sum_baseboardstime_time'];
		$all .=  $production_rate['Baseboards']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['chairrail_time'])  || $row11['chairrail_time_time'] != "" ){ 
		$sum = $row11['sum_chairrail_time'] + $row11['sum_chairrail_time_time'];
		$all .=  $production_rate['Chair Rail']['description'].'<br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['crownmolding_time']) || $row11['crownmolding_time_time'] != ""){ 
		$sum = $row11['sum_crownmolding_time'] + $row11['sum_crownmolding_time_time'];
		$all .=  $production_rate['Crown Molding']['description'].' <br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}	
	if(isset($row11['closets_time'])){ 
		$all .=  $production_rate['Closets']['description'].' - Apply | Coats<br/>';
		$all .=  "Total Bid Hours".$row11['sum_closets_time'].'<br/>';
	}
	if(isset($row11['cabinetry_time'])){ 
		$all .=  $production_rate['Cabinetry']['description'].' - Apply | Coats<br/>';
		$all .=  "Total Bid Hours".$row11['sum_cabinetry_time'].'<br/>';
	}/*
	if(isset($row11['dailybreakdown_quantity'])){ 
		$all .=  $production_rate['Daily Setup/Breakdown']['description'].'<br/>';
	}*/
	if(isset($row11['cleantouchup_time'])){ 
		$all .=  $production_rate['Clean and Touchup']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_cleantouchup_time'].'<br/>';
		
	}/*
	if(isset($row11['bullnosewall_quantity'])){ 
		$all .=  $production_rate['Bullnose/Accent Wall']['description'].'<br/>';
	}*/
	if(isset($row11['miscellaneous1_time']) || $row11['miscellaneous2_time'] != "" || $row11['miscellaneous3_time'] != ""){ 
		$sum = $row11['sum_miscellaneous1_time'] + $row11['sum_miscellaneous2_time'] + $row11['sum_miscellaneous3_time'];
		$all .=  'Miscellaneous <br/>';
		$all .=  "Total Bid Hours".$sum.'<br/>';
	}
	if(isset($row11['faux_time'])){ 
		$all .=  $production_rate['Faux/Mural']['description'].'<br/>';
		$all .=  "Total Bid Hours".$row11['sum_faux_time'].'<br/>';
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