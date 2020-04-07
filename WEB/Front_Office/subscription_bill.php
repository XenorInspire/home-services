<?php
require_once('pdf/fpdf.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {

    header('Location: orders.php');
    exit;
}

require_once('include/check_identity.php');
if ($connected != 1 || $status != "customer") {

    header('Location: orders.php');
    exit;
}
$hm_database = new DBManager($bdd);

if ($hm_database->getLastSubscriptionBill($id) != $_GET['id']) {

    header('Location: orders.php');
    exit;
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Image('img/favicon.png', 10, 10, 30, 30);

$date = "10-10-2020";

$num_fact = "Bill Number "  . $date;
$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(192);
$pdf->Rect(110, 15, 85, 8, "DF");
$pdf->SetXY(110, 15);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(85, 8, $num_fact, 0, 0, 'C');


$pdf->Output();
