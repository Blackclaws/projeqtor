<?php
define('FPDF_FONTPATH','../external/fpdf/font/');
require('../external/fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World !');
$pdf->Output();
?> 
