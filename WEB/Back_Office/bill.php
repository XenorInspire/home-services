<?php
require_once('pdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Image('img/favicon.png', 10, 10, 30, 30);

$date = "10-10-2020";

$num_fact = "Bill Number "  . $date;
$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(192);
$pdf->Rect(120, 15, 85, 8, "DF");
$pdf->SetXY(120, 15);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(85, 8, $num_fact, 0, 0, 'C');


$pdf->Output();
