<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
		
function makepdf($html, $invoice) {
	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);


	// Render the HTML as PDF
	$dompdf->render();

	$output = $dompdf->output();
	$file_to_save = "invoice/".$invoice.'.pdf';
	file_put_contents($file_to_save, $output);
}
?>