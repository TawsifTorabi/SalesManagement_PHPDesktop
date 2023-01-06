<?php


//Before Starting to use pdf.php - Unzip the dompdf folder in this directory with pdf.php
//This folder should look alike,
/*

	/Vendor
	/composer.json
	/composer.lock
	/pdf.php
	
*/

//I used mPDF previously to get support to print Bangla and Unicode Fonts.
//DOmPDF is just lightweight, I'm using it again to print English and ANSI Fonts.


require_once 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$html = $_GET['html'];
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

exit(0);

?>
