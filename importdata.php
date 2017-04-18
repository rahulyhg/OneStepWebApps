<?php
		require 'application/control/include_classes.php';
		require_once 'classes/phpexcel/PHPExcel.php';
		require_once 'classes/phpexcel/PHPExcel/IOFactory.php';
		$db = new Db();
		error_reporting(E_ALL);
		$file = realpath(dirname(__FILE__))."/uploads/Demo2.xlsx";
		if(!empty($file)) 
		{ 
	
			$gender = $db->CreateOptions("array", "lov", array("id","value"),"","","type='gender'");
			$status = $db->CreateOptions("array", "lov", array("id","value"),"","","type='married'");
			$city = $db->CreateOptions("array","samaj_city", array("id","name"),"","","");
			$villiage = $db->CreateOptions("array", "vilage", array("id","name"),"","","");
			/*echo "<pre>".print_r($gender)."</br>";
			print_r($status)."</br>";
			print_r($city)."</br>";
			print_r($villiage)."</br>";
				exit;*/
			$objPHPExcel = "";
			try 
			{
				$objPHPExcel = PHPExcel_IOFactory::load($file);
			} 
			catch(Exception $e) 
			{
				die('Error : Unable to load the file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			//print_r($allDataInSheet);
			$arrayCount = count($allDataInSheet);
			//echo $arrayCount;
			$result3 = "";
			for($i=3;$i<=$arrayCount;$i++)
			{
				$flag=true;
				$data1 = array();
				if(!ctype_alpha(trim($allDataInSheet[$i]["A"])) || !ctype_alpha(trim($allDataInSheet[$i]["B"])) || trim($allDataInSheet[$i]["A"]) == "" || trim($allDataInSheet[$i]["B"]) == "" || strlen(trim($allDataInSheet[$i]["A"])) > 30 || strlen(trim($allDataInSheet[$i]["A"])) < 2 || strlen(trim($allDataInSheet[$i]["B"])) > 30 || strlen(trim($allDataInSheet[$i]["B"])) < 2)
				{ 
					$flag = false;
					echo "Name :";
					exit;
				}
				else
				{
					$data1['first_name']= trim($allDataInSheet[$i]["A"]);
					$data1['last_name']= trim($allDataInSheet[$i]["B"]);
				}
				
				if(trim($allDataInSheet[$i]["C"]) == "" )
				{
					$flag = false;
				}
				else
				{
					$data1['about_me'] = trim($allDataInSheet[$i]["C"]);
				}
				
				if (trim($allDataInSheet[$i]["D"]) == "" || filter_var(trim($allDataInSheet[$i]["D"]), FILTER_VALIDATE_EMAIL) === true) 
				{
					$flag = false;
				} 
				else
				{
					$data1['email'] = trim($allDataInSheet[$i]["D"]);
				}

				if(strlen(trim($allDataInSheet[$i]["E"])) < 6 || strlen(trim($allDataInSheet[$i]["E"])) > 25 || trim($allDataInSheet[$i]["E"]) == "")
				{
					$flag = false;
				}
				else
				{
					$data1['password'] = trim($allDataInSheet[$i]["E"]);
				}
				
				
				if(!in_array(trim(strtolower($allDataInSheet[$i]["F"])),array_map('strtolower',$gender)) || trim($allDataInSheet[$i]["F"]) == "" )
				{ 
					$flag = false;
				} 
				else
				{
					$data1['gender'] = array_search(trim($allDataInSheet[$i]["F"]),$gender);
				}
				
				if(!in_array(trim(strtolower($allDataInSheet[$i]["G"])),array_map('strtolower',$status)) || trim($allDataInSheet[$i]["G"]) == "" )
				{ 
					$flag = false;
				} 
				else
				{
					$data1['status'] = array_search(trim($allDataInSheet[$i]["G"]),$status);
				}
				
				if(trim($allDataInSheet[$i]["I"]) == "" || !ctype_digit(trim($allDataInSheet[$i]["I"])) || strlen(trim($allDataInSheet[$i]["I"])) != 10 )
				{ 
					$flag = false;
				} 
				else
				{
					$data1['phonenumber'] = trim($allDataInSheet[$i]["I"]);
				}
				
				if(!in_array(trim(strtolower($allDataInSheet[$i]["J"])),array_map('strtolower',$city)) || trim($allDataInSheet[$i]["J"]) == "" )
				{ 
					$flag = false;
				} 
				else
				{
					$data1['samaj_city_id'] = array_search(trim($allDataInSheet[$i]["J"]),$city);
				}
				
				if(!in_array(trim(strtolower($allDataInSheet[$i]["K"])),array_map('strtolower',$villiage)) || trim($allDataInSheet[$i]["K"]) == "" )
				{ 
					$flag = false;
				} 
				else
				{
					$data1['samaj_village_id'] = array_search(trim($allDataInSheet[$i]["K"]),$villiage);
				}
				
				if(!in_array(trim(strtolower($allDataInSheet[$i]["L"])),array_map('strtolower',$villiage)) || trim($allDataInSheet[$i]["L"]) == "" )
				{ 
					$flag = false;
				} 
				else
				{
					$data1['masar_village_id'] = array_search(trim($allDataInSheet[$i]["L"]),$villiage);
				}
				
				
				//echo $arrayCount;
				if($flag == true)
				{
					print_r($data1);
					$result3 = $db->insert('user',$data1,1); 
					if($result3 > 0)
					{
						 $objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, 'Done'); 
					}
					
				}
				else
				{
					$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, 'Not Done');
				}	
							
			}
			
			$objPHPExcel->setActiveSheetIndex(0);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="exportdata.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}

?>