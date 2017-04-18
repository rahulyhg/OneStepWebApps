<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */
/** Error reporting */
error_reporting(E_ALL);
//date_default_timezone_set('Europe/London');
/** PHPExcel */
require 'application/control/include_classes.php';
require_once 'classes/phpexcel/PHPExcel.php';
// Create new PHPExcel object

$db = new Db();
$table = "user";
$table_id = 'id';

//$ag = $db->calculateAge('"'.$row->birth_date.'"'));
//echo $ag;
				
$default_sort_column = 'i.id';
$default_sort_order = 'asc';

if(isset($_GET['sort']))
{
if($_GET['sort']=='village')
	$default_sort_column = "r.name";
else if($_GET['sort']=='name')
	$default_sort_column = "i.first_name";
else if($_GET['sort']=='age')
	$default_sort_column = "STR_TO_DATE(i.birth_date,'%m/%d/%Y')";
else if($_GET['sort']=='samaj_city')
	$default_sort_column = "r15.name";
}

$condition = " 1=1 " ;

if(isset($_GET['village']) && $_GET['village']!='')
	$condition .= " && r.id in (".$_GET['village'].") ";
if(isset($_GET['samaj_city']) && $_GET['samaj_city']!='')
	$condition .= " && r15.id in (".$_GET['samaj_city'].") ";
if(isset($_GET['country']) && $_GET['country']!='')
	$condition .= " && r7.name LIKE '%".$_GET['country']."%'";
if(isset($_GET['state']) && $_GET['state']!='')
	$condition .= " && r6.name LIKE '%".$_GET['state']."%'";
if(isset($_GET['city']) && $_GET['city']!='')
	$condition .= " && r5.name LIKE '%".$_GET['city']."%'";
if(isset($_GET['occuptions']) && $_GET['occuptions']!='')
	$condition .= " && r8.occuption_id in (".$_GET['occuptions'].") ";
if(isset($_GET['degree']) && $_GET['degree']!='')
	$condition .= " && r11.id in (".$_GET['degree'].") ";
if(isset($_GET['name']) && $_GET['name']!='')
	$condition .= " && (i.first_name LIKE '%".$_GET['name']."%' or i.last_name LIKE '%".$_GET['name']."%') ";
if(isset($_GET['email']) && $_GET['email']!='')
	$condition .= " && i.email LIKE '%".$_GET['email']."%' ";
if(isset($_GET['phonenumber']) && $_GET['phonenumber']!='')
	$condition .= " && i.phonenumber LIKE '%".$_GET['phonenumber']."%' ";
if(isset($_GET['sex']) && $_GET['sex']!='')
	$condition .= " && r14.id in (".$_GET['sex'].") ";
if(isset($_GET['zipcode']) && $_GET['zipcode']!='')
	$condition .= " && r4.postalcode LIKE '%".$_GET['zipcode']."%' ";
if(isset($_GET['commity_member']) && $_GET['commity_member']!='')
	$condition .= " && i.role LIKE '%".$_GET['commity_member']."%' ";
if(isset($_GET['slider-start']) && isset($_GET['slider-end']) && $_GET['slider-start'] != '' && $_GET['slider-end'] != '')
{
	$condition .=  " && (TIMESTAMPDIFF(YEAR,STR_TO_DATE(i.birth_date, '%m/%d/%Y'),NOW()) >= ".$_GET['slider-start']. "&& TIMESTAMPDIFF(YEAR,STR_TO_DATE(i.birth_date, '%m/%d/%Y'),NOW()) <= ".$_GET['slider-end']." ) ";
}

$condition .=  " && r12.ref_type in ('12') ";

$default_page = 1;
$default_rows = 10;

//photos,Business,education,mobileno(landline),village name

$page = isset($_GET['page']) ? strval($_GET['page']) : $default_page; 
$rows = isset($_GET['rows']) ? strval($_GET['rows']) : $default_rows;
$page = ($page-1) * $rows;
$sort = $default_sort_column;  
$order = isset($_GET['sortval']) ? strval($_GET['sortval']) : $default_sort_order;  

$main_table = array("$table i",array("i.*"));
//$join_tables = array();
$join_tables = array(
array('left',' vilage r','r.id = i.samaj_village_id', array('r.name as village_name','r.color as color_code')),
array('left',' user_address_xref r3','r3.user_id = i.id', array('r3.address_id as address_id')),
array('left',' address r4','r4.id = r3.address_id', array('r4.address1 as address1','r4.postalcode as postalcode')),
array('left',' location r5','r5.location_id = r4.city', array('r5.name as city_name')),
array('left',' location r6','r6.location_id = r4.state', array('r6.name as state_name')),
array('left',' location r7','r7.location_id = r4.country', array('r7.name as country_name')),
array('left',' user_occuptions r8','r8.user_id = i.id', array()),
array('left',' occuptions r9','r8.occuption_id = r9.id', array('r9.name as occuptions_name')),
array('left',' user_degree r10','r10.user_id = i.id', array()),
array('left',' degree r11','r10.degree_id = r11.id', array('r11.name as degree_name')),
array('left',' image_xref r12','r12.ref_id = i.id', array()),
array('left',' image r13','r12.image_id = r13.id', array('r13.path as image_path')),
array('left',' samaj_city r15','r15.id = i.samaj_city_id', array('r15.name as samaj_city_name')),
array('left',' lov r14','r14.id = i.gender', array('r14.value as gender_name','TIMESTAMPDIFF(YEAR,STR_TO_DATE(CONCAT(i.birth_date," ",i.birth_time), "%m/%d/%Y %h:%i %p"),NOW()) as age'))
);

$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order));
//$rs = $db->JoinFetch($main_table, $join_tables, $condition, array($sort => $order), array($page, $rows));

$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("5lpparivar.com")
							 ->setLastModifiedBy("5lpparivar.com")
							 ->setTitle("Export Report")
							 ->setSubject("Export Report")
							 ->setDescription("Export Report")
							 ->setKeywords("Export Report")
							 ->setCategory("Report");
	
$rowCount = 1; 
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'id'); 
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Name'); 
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'About Me'); 
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Address'); 
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Birth Date'); 
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Birth Time');
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Age');	
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Occupations');
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Education');	
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Phone no');	
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Samaj Village');	
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'Gender');	
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'Image');



$rowCount++;
$rowCount++;
$totalcount1 =  @mysql_num_rows($rs);
if($totalcount1 == 0){
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'NO Records Found'); 
}
else {
	while($row = mysql_fetch_object($rs))
	{
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->id); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $name); 
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->about_me); 
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->address1.", ".$row->city_name.", ".$row->state_name.", ".$row->country_name." - ".$row->postalcode); 
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->birth_date); 
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->birth_time); 
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->age);
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->occuptions_name);
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->degree_name);	
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->phonenumber);	
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->village_name);	
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->gender_name);	
		$default_image = $row->image_path; if(isset($default_image)){
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, SITE_ROOT."/".$row->image_path);
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "No Image");
		}
		$rowCount++;
	}
}
			
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="exportdirectory.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;