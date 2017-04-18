<?php
include_once 'Sample_Header.php';

// New Word Document
$phpWord = new \PhpOffice\PhpWord\PhpWord();
/*$section = $phpWord->addSection();*/
$header = array('size' => 16, 'bold' => true);

$section = $phpWord->addSection(array('marginLeft' => 600, 'marginRight' => 600, 'marginTop' => 600, 'marginBottom' => 600));
$section->addImage('resources/logo-white.png', array('width' => 200, 'height' => 90, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
/*$section->addText('Table with colspan and rowspan', $header);*/
$name = "One Step Estimating";
$fancyTableStyle = array('borderSize' => 6, 'borderColor' => '999999');
$cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '#339966');
$cellRowSpancolspan4 = array('gridSpan' => 4,'vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '#339966');
$cellRowContinue = array('vMerge' => 'continue');
$cellRowContinue4 = array('gridSpan' => 4,'vMerge' => 'continue');
$cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
$cellColSpan1 = array('gridSpan' => 5, 'valign' => 'center','bgColor' => '#C0C0C0');
$cellColSpan8grey = array('gridSpan' => 8, 'valign' => 'center','bgColor' => '#C0C0C0');
$cellColSpan8 = array('gridSpan' => 8, 'valign' => 'center');
$cellColSpan4 = array('gridSpan' => 4,'valign' => 'center');
$cellColSpan4green = array('gridSpan' => 4,'bgColor' => '#339966');
$cellColSpan4grey = array('gridSpan' => 4,'bgColor' => '#C0C0C0');
$cellColSpan4blue = array('gridSpan' => 4,'bgColor' => '#CEE6FF');
$cellColSpan3blue = array('gridSpan' => 3,'bgColor' => '#CEE6FF');
$cellColSpan3 = array('gridSpan' => 3);
$cellColSpan2blue = array('gridSpan' => 2,'bgColor' => '#CEE6FF');
$cellColSpan2= array('gridSpan' => 2,);
$cellblue = array('valign' => 'center','bgColor' => '#CEE6FF');
$cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,'spaceAfter' => 0);
$cellHLeft = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,'spaceAfter' => 0);
$cellHRIGHT = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT,'spaceAfter' => 0);
$headercellstyle = array('bold' => true,'size' => 16);
$subheadercellstyle = array('bold' => true,'size' => 14);
$subheadercellstyle11 = array('bold' => true,'size' => 11);
$subheadercellstyle11red = array('bold' => true,'size' => 11,'color' => '#C00000');
$cellstyle = array('size' => 8);
$cellcontentstyle = array('size' => 10,'bold' => true);
$content = array('size' => 8);
$contentwithtime = array('size' => 8,'name' => 'Times New Roman');
$contentwithtimebold = array('size' => 8,'name' => 'Times New Roman','bold' => true);
$content10 = array('size' => 10);
$cellVCentered = array('valign' => 'center');
$cellVCenteredgrey = array('valign' => 'center','bgColor' => '#C0C0C0');
$cost = array('bold' => true,'size' => 18,'color' => '#C00000');

$spanTableStyleName = 'Colspan Rowspan';
$phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);

$tableStyle = array(
    'borderColor' => '#ffffff',
    'borderSize'  => 6,
);
$firstRowStyle = array('bgColor' => '#FFFFCC');
$phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
$phpWord->addTableStyle('myTable1', $tableStyle, $firstRowStyle);

$table = $section->addTable($spanTableStyleName);
/*$table = $section->addTable(array('width' => 50 * 100, 'unit' => 'pct', 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER));*/

$table->addRow();
$cell11 = $table->addCell(4000, $cellColSpan8grey);
$textrun3 = $cell11->addTextRun($cellHCentered);
$textrun3->addText('CONTRACT',$headercellstyle);

$table->addRow();
	$cell1 = $table->addCell(6000, $cellColSpan4);
	$cell1->addText('PROPOSAL SUBMITTED TO', $cellstyle, $cellHLeft);
		$innerCell = $cell1->addTable()->addRow()->addCell();
		$innerCell->addText($name,$cellcontentstyle);
	$cell2 = $table->addCell(1500, $cellVCentered);
	$cell2->addText('PRIMARY PHONE', $cellstyle, $cellHLeft);
		$innerCell = $cell2->addTable()->addRow()->addCell();
		$innerCell->addText('0000000000',$cellcontentstyle);
	$cell3 = $table->addCell(1500, $cellVCentered);
	$cell3->addText('ALT. PHONE', $cellstyle, $cellHLeft);
		$innerCell = $cell3->addTable()->addRow()->addCell();
		$innerCell->addText('1111111111',$cellcontentstyle);
	$cell4 = $table->addCell(2000, $cellVCentered);
	$cell4->addText('EMAIL', $cellstyle, $cellHLeft);
		$innerCell = $cell4->addTable()->addRow()->addCell();
		$innerCell->addText('Robert',$cellcontentstyle);
	$cell5 = $table->addCell(1000, $cellVCentered);
	$cell5->addText('DATE', $cellstyle, $cellHLeft);
	$innerCell = $cell5->addTable()->addRow()->addCell();
		$innerCell->addText('Robert',$cellcontentstyle);
		
		
$table->addRow();
	$cell21 = $table->addCell(6000, $cellColSpan4);
	$cell21->addText('Address', $cellstyle, $cellHLeft);
		$innerCell = $cell21->addTable()->addRow()->addCell(6000, $cellVCentered);
		$innerCell->addText('sagram pura',$cellcontentstyle);
	$cell22 = $table->addCell(6000, $cellColSpan4);
	$cell22->addText('Job Name', $cellstyle, $cellHLeft);
		$innerCell = $cell22->addTable()->addRow()->addCell(6000, $cellVCentered);
		$innerCell->addText('sagram pura',$cellcontentstyle);
		
$table->addRow();
	$cell31 = $table->addCell(6000, $cellColSpan4);
	$cell31->addText('CITY, STATE, AND ZIP CODE', $cellstyle, $cellHLeft);
		$innerCell = $cell31->addTable()->addRow()->addCell(6000, $cellVCentered);
		$innerCell->addText('sagram pura',$cellcontentstyle);
	$cell32 = $table->addCell(6000, $cellColSpan4);
	$cell32->addText('JOB LOCATION', $cellstyle, $cellHLeft);
		$innerCell = $cell32->addTable()->addRow()->addCell(6000, $cellVCentered);
		$innerCell->addText('sagram pura',$cellcontentstyle);
		
$table->addRow();
	$cell41 = $table->addCell(6000, $cellColSpan4grey);
	$cell41->addText('SPECIFICATIONS', $subheadercellstyle, $cellHCentered);
	$cell42 = $table->addCell(6000, $cellColSpan4grey);
	$cell42->addText('SCHEDULE', $subheadercellstyle, $cellHCentered);

$table->addRow();
	$cell51 = $table->addCell(6000, $cellColSpan4);
	$cell51->addText('', $subheadercellstyle11, $cellHLeft);	
	$cell52 = $table->addCell('', $cellColSpan3blue);
	$cell52->addText('Approximate date to begin project:', $subheadercellstyle11, $cellHLeft);	
	$cell53 = $table->addCell('', $cellblue);
	$cell53->addText('', $subheadercellstyle11, $cellHLeft);
	
$table->addRow();
	$cell61 = $table->addCell(6000, $cellColSpan4);
	$cell61->addText('Please see Proposal Document and Scope of Work', $subheadercellstyle11red, $cellHLeft);	
	$cell62 = $table->addCell('', $cellColSpan3blue);
	$cell62->addText('Approximate project time:', $subheadercellstyle11, $cellHRIGHT);	
	$cell63 = $table->addCell('', $cellblue);
	$cell63->addText('', $subheadercellstyle11, $cellHLeft);	
	
$table->addRow();
	$cell71 = $table->addCell(6000, $cellColSpan4);
	$cell71->addText('', $subheadercellstyle, $cellHCentered);
	$cell72 = $table->addCell(6000, $cellColSpan4blue);
	$cell72->addText('Substantial commencement of work shall be deemed to be job site set-up and commencement of painting preparation work.', $content, $cellHLeft);
	
$table->addRow();
	$cell81 = $table->addCell(6000, $cellColSpan4grey);
	$cell81->addText('TOTAL COST', $subheadercellstyle, $cellHCentered);
	$cell82 = $table->addCell(6000, $cellColSpan4grey);
	$cell82->addText('DEPOSIT', $subheadercellstyle, $cellHCentered);
	
$table->addRow();
	$cell91 = $table->addCell(4000, $cellColSpan3);
	$cell91->addText('Customer agrees to pay contractor a total cash price of:', $subheadercellstyle11, $cellHLeft);
	$cell92 = $table->addCell(2000, $cellVCentered);
	$cell92->addText('$', $cost, $cellHCentered);
	$cell93 = $table->addCell('', $cellColSpan3);
	$cell93->addText('Due upon approval of proposal:', $subheadercellstyle11, $cellHLeft);
	$cell94 = $table->addCell('', $cellVCentered);
	$cell94->addText('$', $cost, $cellHCentered);
	
$table->addRow();
	$cell101 = $table->addCell('', $cellColSpan3);
	$cell101->addText('PAYMENTS:', $subheadercellstyle11, $cellHLeft);
	$cell102 = $table->addCell('', $cellVCentered);
	$cell102->addText('AMOUNT:',$subheadercellstyle11, $cellHCentered);
	$cell103 = $table->addCell(6000, $cellRowSpancolspan4);
	$cell103->addText('We will schedule your work once we receive a copy of this agreement and the requested deposit listed above. Please make checks* payable to ALL Bright Inc.',$content10, $cellHLeft);
	
$table->addRow();
	$cell111 = $table->addCell('', $cellColSpan3);
	$cell111->addText('Start Up Payment:', $subheadercellstyle11, $cellHLeft);
	$cell112 = $table->addCell('', $cellVCentered);
	$cell112->addText('$',$subheadercellstyle11, $cellHCentered);
	$cell113 = $table->addCell(null, $cellRowContinue4);
	
$table->addRow();
	$cell121 = $table->addCell('', $cellColSpan3);
	$cell121->addText('', $subheadercellstyle11, $cellHLeft);
	$cell122 = $table->addCell('', $cellVCentered);
	$cell122->addText('',$subheadercellstyle11, $cellHCentered);
	$cell123 = $table->addCell(null, $cellRowContinue4);
	
$table->addRow();
	$cell131 = $table->addCell('', $cellColSpan3);
	$cell131->addText('Final Payment Upon Completion:', $subheadercellstyle11, $cellHLeft);
	$cell132 = $table->addCell('', $cellVCentered);
	$cell132->addText('$',$subheadercellstyle11, $cellHCentered);
	$cell133 = $table->addCell('', $cellColSpan4green);
	$cell133->addText('* Additional Payment Plans are available.',$content10, $cellHLeft);		

$table->addRow();
	$cell142 = $table->addCell(6000, $cellColSpan8);
	$cell142->addText('Upon satisfactory payment being made for any portion of the work performed, the contractor shall, prior to any further payment being made, furnish a full and unconditional release for any claim or mechanic’s lien pursuant to Section 3114 of the California Civil Code.', $contentwithtime, $cellHCentered);	
	
$table->addRow();
	$cell151 = $table->addCell(4000, $cellColSpan8grey);
	$cell151->addText('TERMS AND CONDITIONS AND ATTACHMENTS',$subheadercellstyle, $cellHCentered);
	
$table->addRow();
	$cell162 = $table->addCell(6000, $cellColSpan8);
	$cell162->addText('The Terms and Conditions following and all Attachments are expressly incorporated into this Agreement.  This Agreement constitutes the entire understanding of the parties and no other understanding or representations, oral or otherwise shall be recognized as part of this agreement.', $contentwithtime, $cellHCentered);	
	
$table->addRow();
	$cell171 = $table->addCell(4000, $cellColSpan8grey);
	$cell171->addText('ACCEPTANCE',$subheadercellstyle, $cellHCentered);
	
$table->addRow();
	$cell81 = $table->addCell(6000, $cellColSpan4);
	$cell81->addText('Authorized Signature: ________________________________', $content, $cellHCentered);
		$innerCell = $cell81->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,'spaceAfter' => 0))->addRow()->addCell();
		$innerCell->addText('Contractor', $content);
	$cell82 = $table->addCell(6000, $cellColSpan4);
	$cell82->addText('Date: _______________________', $content, $cellHCentered);
	
$table->addRow();
	$cell162 = $table->addCell(6000, $cellColSpan8);
	$cell162->addText('', $contentwithtime, $cellHCentered);		
		$innerCell = $cell162->addTable()->addRow()->addCell(11000, $cellVCentered);
		$innerCell->addText('(NOTE: This contract will expire if not accepted within 30 days of the date signed by Contractor.)', $contentwithtime);
		$innerCell = $cell162->addTable()->addRow()->addCell(11000, $cellVCentered);
		$innerCell->addText(' You’re hereby authorized to perform the work specified in this Proposal & Agreement, for which I/we agree to pay the contract price & according to the terms.  Any alteration or deviation from the above specifications, including but not limited to any such alteration or deviation involving additional material and/or labor costs, will be executed only upon written order for same, signed by Owner and Contract', $contentwithtime);
		$innerCell = $cell162->addTable()->addRow()->addCell(11000, $cellVCentered);
		$innerCell->addText('If any payment is not made when due, Contractor may suspend work on the job until such time as all payments have been made.  A failure to make payment for a period in excess of 3 days from the due date of the payment shall be deemed a material breach', $contentwithtime);
		$innerCell = $cell162->addTable('myTable')->addRow()->addCell(11000, $cellVCentered);
		$innerCell->addText('I/we have read and agree to the provisions of this Proposal and Agreement and acknowledge receipt of the following: (1) Notice to Owner and Warranty, (2) Exterior Proposal,  (3) Notice of Cancellation', $contentwithtime);
		$innerCell = $cell162->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER),'myTable1')->addRow()->addCell(7500, $cellVCentered);
		$innerCell->addText('X___________________________                    Date of Acceptance: ___________________________', $content);

$table->addRow();
	$cell162 = $table->addCell(6000, $cellColSpan8);
	$cell162->addText('You the buyer (Owner), may cancel this transaction at any time prior to midnight of the third business day after the date of this transaction.  Or, if this is a contract for the repair of damages resulting from an earthquake, flood, fire, hurricane, riot.', $contentwithtimebold, $cellHLeft);			

$section->addText('Fax signed copy to YOUR FAX NUMBER to reserve your painting project start date.',$subheadercellstyle11,$cellHLeft);
$section->addText('Please make deposit check payable to:  YOUR COMPANY NAME',$subheadercellstyle11,$cellHLeft);
$section->addText('YOUR COMPANY ADDRESS',$subheadercellstyle11,$cellHLeft);

$section->addPageBreak();

$underline = array('underline'=> 'single','size'=> 10,'bold'=> true);
$fontstyle = array('size'=> 10);
$fontstylebold = array('size'=> 10,'bold'=> true);
$spaceAfter = array('spaceAfter' => 0);
$spaceboth = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,'spaceBefore' => 200,'spaceAfter' => 0);
$predefinedMultilevelStyle = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED);

$section->addText('Work Standard',$underline,$spaceAfter);
$section->addListItem('ALL Bright Inc. is a member of the Painting and Decorating Contractors of America and upholds the standard set forth by the PDCA', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('All work is to be completed in a workman like manner according to standard practices. ', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('Work procedures as per standards of the PDCA (Painting and Decorating Contractors of America) P1-92, P2-92, P3-93, P4-94, P5-94, P7-98 and P6-99 and all other standards by reference (Standards can be obtained at www.pdca.org).', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('The painting contractor will produce a "properly painted surface".  A "properly painted surface" is one that is uniform in color and sheen.  It is one that is free of foreign material, lumps, skins, sags, holidays, misses, strike-through, or insufficient coverage.  It is a surface that is free of drips, spatters, spills, or over-spray which the contractors’ workforce causes.  Compliance to meeting the criteria of a "properly painted surface" shall be determined when viewed without magnification at a distance of five feet or more under normal lighting conditions and from a normal viewing position', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);

$section->addText('Customer Responsibility:',$underline,$spaceboth);
$section->addListItem('Please take specific note of job description.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('Colors must be chosen one (1) week prior to start date.  An additional cost will be charged for color changes made after commencement of work.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('All landscape items, trees, bushes… etc. are to be cut back so as not to touch the surface of the project prior to proceeding with painting work.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('Alarms and automatic sprinkler systems must be turned off while work is in progress.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('ALL Bright Inc. is not responsible for damage to Spanish tile roofs (or any other roof systems).  Every precaution will be made to not break tiles, but it is not guaranteed that there will be no tile damage.', 0, $fontstylebold, $predefinedMultilevelStyle, $spaceAfter);

$section->addText('Notes about the job:',$underline,$spaceboth);
$section->addListItem('Amount above assumes that the existing paint is lead free.  Amount subject to change if lead is found in any of the existing paint.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('At the completion of the painting work, our trained foreman will carefully inspect all surfaces to insure our quality standards have been met.  This way, the customer will see only a high quality finished result.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('This contract is based on a regular workweek of Monday through Friday, standard business hours.  If your project requires a different time schedule, this will need to be discussed for additional charges.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('We understand that the scope of work calls for a certain amount of coats per surface to ensure proper coverage.  In certain situations of color/finish selection or type of surface being painted, the allowed amounts of coats may not cover per the estimated scope of work.  If this situation occurs, the customer will be notified and informed that additional coats will be required to ensure proper coverage and a professional looking paint job.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('Complete clean up will be strictly observed at the end of each working day.  All paint materials and tools will be moved or stored in a location as directed by the customer at the end of each day so as to minimize interruption of our customer’s personal life style.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('This contract is for completing the job as described above and is based on visually observed conditions.  Should any unforeseen conditions arise that could not be determined at the time of the estimate, but does occur at any time for the duration of the project, the customer will be notified and a firm price will be given at that time.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('Pressure wash all surfaces scheduled for painting.  The owners should be aware that when pressure washing is done, water is applied at angles not common to weather which will / may cause temporary leaking.  For this reason, we strongly advise the customer to remove any items from around doors and windows that may be damaged by water.  CLEANING WINDOWS IS NOT INCLUDED IN CONTRACT AMOUNT.  Windows can be cleaned once job is completed at an additional cost.', 0, $fontstylebold, $predefinedMultilevelStyle, $spaceAfter);

$section->addText('Additional Work Orders:',$underline,$spaceboth);
$section->addListItem('If after you agree to this work, you desire any changes of additional work, please contact us as the cost of all revisions must be agreed upon in writing.  Workers are instructed not to undertake additional work without authorization.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('It is essential that the work area be available to us, free from other trades.  As a result of trade interference, ALL Bright Inc. may leave the job and additional charges may be incurred.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);
$section->addListItem('All work is to be performed according to standard painting sequencing and work flow.  If interruptions occur, additional charges may be incurred.', 0, $fontstyle, $predefinedMultilevelStyle, $spaceAfter);

$section = $phpWord->addSection(array('borderColor' => '#000000', 'borderSize' => 6,'marginLeft' => 600, 'marginRight' => 600, 'marginTop' => 600, 'marginBottom' => 600));

$contentwithtimebold = array('size' => 12,'name' => 'Times New Roman','bold' => true);
$section->addText('Additional Provisions',$contentwithtimebold,$cellHCentered);

$section = $phpWord->addSection(
    array(
        'colsNum'   => 2,
        'colsSpace' => 500,
        'breakType' => 'continuous','marginLeft' => 600, 'marginRight' => 600, 'marginTop' => 0, 'marginBottom' => 0
    )
);
$fontsize7 = array('size'=> 7);
$fontsize7time = array('size'=> 7,'name'=> 'Times New Roman','bold'=> true);
$fontsize9time = array('size'=> 9,'name'=> 'Times New Roman','bold'=> true);
$fontsize10time = array('size'=> 10,'name'=> 'Times New Roman');
$fontsize6time = array('size'=> 6,'name'=> 'Times New Roman');
$section->addText("Unless otherwise specified herein, the following additional provisions are expressly incorporated into this contract:",$fontsize7,$spaceAfter);
$textrun = $section->addTextRun();
$textrun->addText("1.  Outside Agency Circumstances:",$fontsize7time,$spaceAfter);
$textrun->addText("Any changes required by an outside agency such as the government, EPA, inspection service or the like will be considered additional work which are to be paid by the owner.",$fontsize6time,$spaceAfter);

$textrun2 = $section->addTextRun();
$textrun2->addText("2.  Installation:",$fontsize7time,$spaceAfter);
$textrun2->addText("Any changes required by an outside agency such as the government, EPA, inspection service or the like will be considered additional work which are to be paid by the owner.",$fontsize6time,$spaceAfter);

$textrun3 = $section->addTextRun();
$textrun3->addText("3.  Change Orders",$fontsize7time,$spaceAfter);
$textrun3->addText("Should owner, or other authorized individual under this contract require any modification to the work covered under this contract, any cost incurred by Contractor shall be added to the contract price as extra work and Owner agrees to pay Contractor his normal selling price for such extra work.  All extra work as well as any other modifications to the original contract shall be specified and approved by both parties in a written change order.  All change orders shall become a part of this contract and shall be incorporated herein.",$fontsize6time,$spaceAfter);

$textrun4 = $section->addTextRun();
$textrun4->addText("4.  Owners Responsibility / Insurance etc.: ",$fontsize7time,$spaceAfter);
$textrun4->addText("Owner is responsible for the following (1) to see that all necessary water, electrical power, access to premises, refuse removal services, and toilet facilities are provided on the premises. (2) to provide a storage area on the premises for equipment and materials (3) to, prior to work, remove or relocate any item that prevents contractor from having free access to the work areas such as pictures, artwork, decorative items, furniture, appliances, draperies, clothing, plants, or any other personal effects and properties.  In the event the Owner fails to relocate items, contractor may relocate these items as required but in no way is contractor responsible for damage to these items during their relocation and during the performance of the work. (4) to obtain permission from the owner(s) of adjacent properties that contractor must use to gain access to the work areas. Owner agrees to be responsible and to hold the contractor harmless and accept any risk resulting from the use of adjacent property by contractor. (5) to correct any existing defects which are recognized during the course of the work.  Contractor shall have no liability for correcting any existing defects such as, but not limited to dry rot, structural defects, or code violations. (6) to maintain property insurance with Fire, course of construction, all physical loss with vandalism and malicious mischief clauses attached, in a sum at least equal to the contract price, prior to and during performance of this contract. If the project is destroyed or damaged by an accident, disaster or calamity, or by theft or vandalism, any work or material supplied by contractor in repairing or repainting the project shall be paid for by the owner as extra work.",$fontsize6time,$spaceAfter);

$textrun5 = $section->addTextRun();
$textrun5->addText("5.  Delay: ",$fontsize7time,$spaceAfter);
$textrun5->addText("Contractor shall not be held responsible for any damage occasioned by delays resulting from work done by owners subcontractors, extra work, acts of owner or owners agent including failure of owner to make timely progress payments or payments for extra work, shortages of material and/or labor, bad weather, fire, strike, war, governmental regulations, or any other contingencies unforeseen by contractor or beyond contractors reasonable control.",$fontsize6time,$spaceAfter);

$textrun6 = $section->addTextRun();
$textrun6->addText("6.  Surplus Materials: ",$fontsize7time,$spaceAfter);
$textrun6->addText("Any surplus material (except necessary touch up amounts) left over after this contract has been completed are the property of contractor and will be removed by the same. No credit is due owner on returns for any surplus materials because this contract is based upon a complete job.  All salvage resulting from work under this contract is the property of the contractor",$fontsize6time,$spaceAfter);
		
$textrun7 = $section->addTextRun();
$textrun7->addText("7. Cleanup and Displaying Signs ",$fontsize7time,$spaceAfter);
$textrun7->addText("Upon completion, and after removing all debris and surplus materials, contractor will leave premises in a neat, broom clean condition.  Owner hereby grants to contractor the right to display signs and advertise at the job site for the period of time starting at the date of signing of this contract and continuing uninterrupted until fourteen (14) days past the date the job is completed and payment in full has been made",$fontsize6time,$spaceAfter);
		
$textrun8 = $section->addTextRun();
$textrun8->addText("8. Method of Application and Paint Colors",$fontsize7time,$spaceAfter);
$textrun8->addText("Owner authorizes contractor to use any method of paint application that contractor deems appropriate, weather it be brush, pad, roller, spray or a combination thereof.  Where colors and sheen factors are to be matched, contractor shall make reasonable efforts to do so but does not guarantee a perfect match.  At the written request of owner, contractor shall provide a sample of any paint for approval by owner.  If the owner does not request a paint sample, contractor is authorized to apply manufacturer’s standard paint as identified in this contract and is not responsible for any differences between the manufacturer’s color chart and the paint as it is applied.",$fontsize6time,$spaceAfter);
	
$textrun9 = $section->addTextRun();
$textrun9->addText("9. Hazardous Substances",$fontsize7time,$spaceAfter);
$textrun9->addText("Owner understands that contractor is not qualified as a hazardous material handler or inspector or as a hazardous material abatement contractor.  Should any hazardous substances as defined by the government be found to be present on the premises, it is the owners responsibility to arrange and pay for abatement of these substances",$fontsize6time,$spaceAfter);

$textrun10 = $section->addTextRun();
$textrun10->addText("10. Right to Stop Work",$fontsize7time,$spaceAfter);
$textrun10->addText("If any payment is not made to contractor as per this contract, contractor shall have the right to stop work and keep the job idle until all past due progress payments are received.  Contractor is further excused by owner from paying any material, equipment and/or labor suppliers or any subcontractors (hereinafter collectively called suppliers).  If these same suppliers make demand upon owner for payment, owner may not make such payment on behalf of contractor without contractor approval at which time the contractor may access a late payment penalty by not reimbursing the customer the amount paid to the suppliers.  The owner is responsible to verify the true amounts owed to the contractor and to these same suppliers prior to making payment.  Owner shall not be entitled, under any circumstances, to collect as reimbursement from contractor any amount greater than that exact amount actually and truly owned by contractor to the same suppliers for work done on owners project.",$fontsize6time,$spaceAfter);

$textrun11 = $section->addTextRun();
$textrun11->addText("11. Payment",$fontsize7time,$spaceAfter);
$textrun11->addText("Payments shall be made per Sec. 7159 (f) on the California Business and Professions Code, upon satisfactory payment being made for any portion of the work performed, the contractor shall prior to any further payment being made, furnish to the person contracting  for this home improvement, a full and unconditional release from any claim or mechanic’s lien pursuant to Section 3114 of the Civil Code for that portion of the work for which payment has been made.",$fontsize6time,$spaceAfter);

$textrun12 = $section->addTextRun();
$textrun12->addText("12. Collection",$fontsize7time,$spaceAfter);
$textrun12->addText("Owner agrees to pay all collection fees and charges including but not limited to all legal and attorney fees that result should owner default in payment of this contract.  Overdue accounts are subject to interest charged at the rate of 24% per annum.  Deposit is forfeited upon cancellation of job by owner.",$fontsize6time,$spaceAfter);

$textrun13 = $section->addTextRun();
$textrun13->addText("13. Legal Fees",$fontsize7time,$spaceAfter);
$textrun13->addText("In the event litigation arises out of this contract, prevailing party(ies) are entitled to a legal, arbitration, and attorney fees.  The court shall not be bound to award fees based on any set, court fee schedule but shall if it so chooses, award the true amount of all cost, expenses and attorney fees paid or incurred.",$fontsize6time,$spaceAfter);

$textrun14 = $section->addTextRun();
$textrun14->addText("14. Notice",$fontsize7time,$spaceAfter);
$textrun14->addText("Any notice required or permitted under this contract may be given by ordinary mail at the address of both parties contained on page one of this contract. This address may be changed from time to time by written notice given by one party to the other.  After a notice is correctly posted and deposited in the mail, it shall be deemed received by the other party after one (1) day.",$fontsize6time,$spaceAfter);

$textrun15 = $section->addTextRun();
$textrun15->addText("15. Sever ability",$fontsize7time,$spaceAfter);
$textrun15->addText("If any clause contained within this contract is rendered null and void, that clause shall not render the entire contract null and void.",$fontsize6time,$spaceAfter);

$textrun16 = $section->addTextRun();
$textrun16->addText("NOTICE TO OWNER – LIEN DISCLOSURE",$fontsize10time,$cellHCentered);

$spaceAfter50 = array('spaceAfter' => 100);
$textrun17 = $section->addTextRun();
$textrun17->addText("Under the California Mechanics’ Lien Law, any contractor, subcontractor, laborer, supplier, or other person or entity who helps to improve your property, but is not paid for his or her work or supplies, has a right to place a lien on your home, land, or property where the work was performed and to sue you in court to obtain payment. This means that after a court hearing, your home, land, and property could be sold by a court officer and the proceeds of the sale used to satisfy what you owe.  This can happen even if you have paid your contractor in full if the contractor’s subcontractors, Laborers, or suppliers remain unpaid",$fontsize9time,$spaceAfter50);

$spaceAfter25 = array('spaceAfter' => 50);
$textrun18 = $section->addTextRun();
$textrun18->addText("Under the California Mechanics’ Lien Law, any contractor, subcontractor, laborer, supplier, or other person or entity who helps to improve your property, but is not paid for his or her work or supplies, has a right to place a lien on your home, land, or property where the work was performed and to sue you in court to obtain payment. This means that after a court hearing, your home, land, and property could be sold by a court officer and the proceeds of the sale used to satisfy what you owe.  This can happen even if you have paid your contractor in full if the contractor’s subcontractors, Laborers, or suppliers remain unpaid",$fontsize9time,$spaceAfter25);

$textrun19 = $section->addTextRun();
$textrun19->addText("CUSTOMER PROTECTION",$fontsize7time,$spaceAfter);

$textrun20 = $section->addTextRun();
$textrun20->addText("To insure extra protection for yourself and your property, you may whish to take one or more of the following precautionary steps:",$fontsize6time,$spaceAfter);

$textrun21 = $section->addTextRun();
$textrun21->addText("(1)  Require that your contractor supply you with a payment and performance bond (not a license bond), which provides that the bonding company will either complete the project or pay damages up to the amount of the bond.  This payment and performance bond as well as a copy of the construction contract should be filed with the county recorder for your future protection.  They payment and performance bond will usually cost from 1 to 5 percent of the contract amount depending on the contractor’s bonding ability.  If a contractor cannot obtain such bonding, it may indicate his or her financial incapacity.",$fontsize6time,$spaceAfter);

$textrun22 = $section->addTextRun();
$textrun22->addText("(2)  Require that payments be made directly to subcontractors and material suppliers through a joint control. Funding services may be available for a fee in your area which will establish voucher or other means of payment to your contractor.  These services may also provide you with lien waivers and other forms of protection.  Any joint control agreement should include the addendum approved by the registrar.",$fontsize6time,$spaceAfter);

$textrun23 = $section->addTextRun();
$textrun23->addText("(3)  Issue joint checks for payment, made out to both your contractor and subcontractors or material suppliers involved in the project.  The joint checks should be made payable to the persons or entities which send preliminary notices to you.  Those persons or entities have indicated that they may have lien rights on your property, therefore you need to protect yourself. This will help to insure that all persons due payment are actually paid.",$fontsize6time,$spaceAfter);

$textrun24 = $section->addTextRun();
$textrun24->addText("(4)  Upon making payment on any completed phase of the project, and before making any further payments, require your contractor to provide you with unconditional “Waiver and Release” forms signed by each material supplier, subcontractor, and laborer involved in that portion of the work for which payment was made. The statutory lien releases are set forth in exact language in Section 3262 of the Civil Code.  Most stationary stores will sell the “Waiver and Release” forms if your contractor does not have them.  The material suppliers, subcontractors, and laborers that you obtain releases from are those suppliers, contractors and laborers working on your project, you may obtain a list from your contractor.  On projects involving improvements to a single-family residence or a duplex owned by the individuals, the person signing these releases lose the right to file a mechanic’s lien claim against your property.  In other types of construction, this protection may still be important but may not be as complete.",$fontsize6time,$spaceAfter);

$textrun25 = $section->addTextRun();
$textrun25->addText("To protect yourself under this option you must be certain that all material suppliers, subcontractors, and laborers have signed the “waiver and Release” form.  IF a mechanic’s lien has been filed against your property, it can only be voluntarily released by a recorded “release of Mechanic’s Lien” signed by the person or entity that filed the mechanic’s lien against your property unless the law suit to enforce the lien was not timely filed. When making final payments, you should have the release form signed and make sure any and all such liens are removed.  You should consult an attorney if a lien is filed against your property.",$fontsize6time,$spaceAfter);


$section = $phpWord->addSection(array('marginLeft' => 600, 'marginRight' => 600, 'marginTop' => 600, 'marginBottom' => 600));
$fontsizetime = array('size'=> 9,'name'=> 'Times New Roman');
$section->addText('Contractors are required by law to be licensed and regulated by the contractors state license board, which has jurisdiction to investigate complaints against contractors if a complaint regarding a patent act or omission is filed within four years of the date of the alleged violation.  A complaint regarding a latent act or omission pertaining to structural defects must be filed within 10 years of the date of the alleged violation.  Any questions concerning a contractor may be referred to the registrar, contractors state license board, P.O. Box 26000, Sacramento, CA 95826-0026.  State law requires anyone who contracts to do construction work to be licensed by the contractors’ state license board in the license category in which the contractor is going to be working. If the total price of the job is $300 or more (including labor and materials).  Licensed contractors are regulated by laws designed to protect the public.  The board has offices throughout California.  Please check the government pages of the white pages for the office nearest you or call 1-800-321-CSLB for more information.',$fontsizetime);
/*$cell1 = $table->addCell(4000, $cellRowSpan);
$textrun1 = $cell1->addTextRun($cellHCentered);
$textrun1->addText('A');
/*$textrun1->addFootnote()->addText('Row span');*/

/*$cell2 = $table->addCell(4000, $cellColSpan);
$textrun2 = $cell2->addTextRun($cellHCentered);
$textrun2->addText('B');
/*$textrun2->addFootnote()->addText('Column span');*/

/*$table->addCell(4000, $cellRowSpan)->addText('E', null, $cellHCentered);

$table->addRow();
$table->addCell(null, $cellRowContinue);
$table->addCell(4000, $cellVCentered)->addText('C', null, $cellHCentered);
$table->addCell(4000, $cellVCentered)->addText('D', null, $cellHCentered);
$table->addCell(null, $cellRowContinue);*/


// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}
