<?php

if (!isset($_GET['billId']) || empty($_GET['billId'])) {
    header('Location: services_provided_bills.php');
    exit;
}

require_once('pdf/fpdf.php');
require_once('class/DBManager.php');

//Data
$billId = $_GET['billId'];
$hm_database = new DBManager($bdd);
$bill = $hm_database->getBill($billId);
$customer = $hm_database->getCustomer($bill->getCustomerId());
$serviceProvided = $hm_database->getServiceProvided($bill->getServiceProvidedId());
$totalAdditionalPrices = $hm_database->getAdditionalPrice($serviceProvided->getServiceProvidedId());

$lastname = utf8_decode($customer->getLastname());
$fisrtname = utf8_decode($customer->getFirstname());
$address = utf8_decode($customer->getAddress());
$town = utf8_decode($customer->getTown());
$email = $customer->getEmail();

//Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

//Logo
$pdf->Image('img/favicon.png', 10, 10, 30, 30);

//Number Invoicing
$num_fact = "Bill Number "  . $billId;
$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(192);
$pdf->Rect(120, 15, 85, 8, "DF");
$pdf->SetXY(120, 15);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(85, 8, $num_fact, 0, 0, 'C');


//Customer's Address
$pdf->SetFont('Arial', 'B', 11);
$x = 110;
$y = 50;
$pdf->SetXY($x, $y);
// $pdf->Cell(100, 8, $lastname . $fisrtname . $address . $town, 0, 0, '');
// $y += 4;
if ($lastname && $fisrtname) {
    $pdf->SetXY($x, $y);
    $pdf->Cell(100, 8, $lastname . " " . $fisrtname, 0, 0, '');
    $y += 4;
}
if ($address) {
    $pdf->SetXY($x, $y);
    $pdf->Cell(100, 8, $address, 0, 0, '');
    $y += 4;
}
if ($town) {
    $pdf->SetXY($x, $y);
    $pdf->Cell(100, 8, $town, 0, 0, '');
    $y += 4;
}

//Customer's email
$pdf->SetFont("Arial", "BU", 10);
$pdf->SetXY(5, 75);
$pdf->Cell($pdf->GetStringWidth("Adresse email de contact"), 0, "Adresse email de contact", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(5, 78);
$pdf->MultiCell(190, 4, $email, 0, "L");

//Customer's names
$pdf->SetFont("Arial", "BU", 10);
$pdf->SetXY(65, 75);
$pdf->Cell($pdf->GetStringWidth("Nom du client"), 0, "Nom du client", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(65, 78);
$pdf->MultiCell(190, 4, $bill->getCustomerLastName() . " " . $bill->getCustomerFirstName(), 0, "L");

//Customer's service provided address
$pdf->SetFont("Arial", "BU", 10);
$pdf->SetXY(5, 90);
$pdf->Cell($pdf->GetStringWidth("Adresse de la prestation"), 0, "Adresse de la prestation", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(5, 93);
$pdf->MultiCell(190, 4, $serviceProvided->getAddress() . " " . $serviceProvided->getTown(), 0, "L");

//Customer's service provided date
$pdf->SetFont("Arial", "BU", 10);
$pdf->SetXY(65, 90);
$pdf->Cell($pdf->GetStringWidth("Date de la prestation"), 0, "Date de la prestation", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(65, 93);
$pdf->MultiCell(190, 4, $serviceProvided->getDate() . utf8_decode(" à ") . $serviceProvided->getBeginHour(), 0, "L");

$data = 1;

// cadre avec 18 lignes max ! et 118 de hauteur --> 95 + 118 = 213 pour les traits verticaux
$pdf->SetLineWidth(0.1);
$pdf->Rect(5, 105, 200, 118, "D");
// cadre titre des colonnes
$pdf->Line(5, 105, 205, 105);

$pdf->Line(5, 112, 205, 112);

// les traits verticaux colonnes
$pdf->Line(110, 105, 110, 223);
$pdf->Line(140, 105, 140, 223);
$pdf->Line(176, 105, 176, 223);
$pdf->Line(187, 105, 187, 223);


// titre colonne
$pdf->SetXY(1, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(140, 8, "Service", 0, 0, 'C');
$pdf->SetXY(125, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1, 8, utf8_decode("Heures demandées"), 0, 0, 'C');
$pdf->SetXY(156, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1, 8, utf8_decode("Heures effectuées"), 0, 0, 'C');
$pdf->SetXY(177, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 8, "Prix/h", 0, 0, 'C');
$pdf->SetXY(185, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 8, "TOTAL", 0, 0, 'C');

// les articles
$pdf->SetFont('Arial', '', 8);
$y = 105;


//SERVICE
$totalAddPrice = 0;
foreach ($totalAdditionalPrices as $totalAdditionalPrice)
    $totalAddPrice += $totalAdditionalPrice->getPrice();


$servicePrice = $bill->getTotalPrice() - $totalAddPrice;
$servicePricePerHour = $servicePrice / $serviceProvided->getHoursAssociate();
//Service
$pdf->SetXY(7, $y + 9);
$pdf->Cell(140, 5, $bill->getServiceTitle(), 0, 0, 'L');
//Heures demandees
$pdf->SetXY(127, $y + 9);
$pdf->Cell(13, 5, strrev(wordwrap(strrev($serviceProvided->getHours()), 3, ' ', true)), 0, 0, 'R');
//Heures effectuees
$pdf->SetXY(158, $y + 9);
$pdf->Cell(18, 5, $serviceProvided->getHoursAssociate(), 0, 0, 'R');
//Prix/h
$nombre_format_francais = number_format($servicePricePerHour, 2, ',', ' ');
$pdf->SetXY(177, $y + 9);
$pdf->Cell(10, 5, $nombre_format_francais, 0, 0, 'R');
//Total
$nombre_format_francais = number_format($servicePrice, 2, ',', ' ');
$pdf->SetXY(187, $y + 9);
$pdf->Cell(18, 5, $nombre_format_francais, 0, 0, 'R');

$pdf->Line(5, $y + 14, 205, $y + 14);

$y += 6;

//ADDITIONAL PRICES
$totalAddPrice = 0;
foreach ($totalAdditionalPrices as $totalAdditionalPrice) {
    //Service
    $pdf->SetXY(7, $y + 9);
    $pdf->Cell(140, 5, $totalAdditionalPrice->getDescription(), 0, 0, 'L');
    //Heures demandees
    $pdf->SetXY(127, $y + 9);
    $pdf->Cell(13, 5, 'X', 0, 0, 'R');
    //Heures effectuees
    $pdf->SetXY(158, $y + 9);
    $pdf->Cell(18, 5, 'X', 0, 0, 'R');
    //Prix/h
    $pdf->SetXY(177, $y + 9);
    $pdf->Cell(10, 5, 'X', 0, 0, 'R');
    //Total
    $nombre_format_francais = number_format($totalAdditionalPrice->getPrice(), 2, ',', ' ');
    $pdf->SetXY(187, $y + 9);
    $pdf->Cell(18, 5, $nombre_format_francais, 0, 0, 'R');

    $pdf->Line(5, $y + 14, 205, $y + 14);

    $y += 6;
}

// // le detail des totaux, demarre a 221 après le cadre des totaux
// $pdf->SetLineWidth(0.1);
// $pdf->Rect(130, 221, 75, 24, "D");
// // les traits verticaux
// $pdf->Line(147, 221, 147, 245);
// $pdf->Line(164, 221, 164, 245);
// $pdf->Line(181, 221, 181, 245);
// // les traits horizontaux pas de 6 et demarre a 221
// $pdf->Line(130, 227, 205, 227);
// $pdf->Line(130, 233, 205, 233);
// $pdf->Line(130, 239, 205, 239);
// // les titres
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->SetXY(181, 221);
// $pdf->Cell(24, 6, "TOTAL", 0, 0, 'C');
// $pdf->SetFont('Arial', '', 8);
// $pdf->SetXY(105, 221);
// $pdf->Cell(25, 6, "Taux TVA", 0, 0, 'R');
// $pdf->SetXY(105, 227);
// $pdf->Cell(25, 6, "Total HT", 0, 0, 'R');
// $pdf->SetXY(105, 233);
// $pdf->Cell(25, 6, "Total TVA", 0, 0, 'R');
// $pdf->SetXY(105, 239);
// $pdf->Cell(25, 6, "Total TTC", 0, 0, 'R');

$tot_ttc = 12;
$tot_tva = 123;
//Total Price
$nombre_format_francais = utf8_decode("Net à payer TTC : ") . number_format($bill->getTotalPrice(), 2, ',', ' ') . iconv('UTF-8', 'windows-1252', " €");
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(192);
$pdf->Rect(5, 213, 105, 10, "DF");
$pdf->SetXY(5, 213);
$pdf->Cell(90, 8, $nombre_format_francais, 0, 0, 'C');
// // en bas à droite
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->SetXY(181, 239);
// $pdf->Cell(24, 6, number_format($tot_ttc, 2, ',', ' '), 0, 0, 'R');
// // TVA
// $nombre_format_francais = "Total TVA : " . number_format($tot_tva, 2, ',', ' ') . " €";
// $pdf->SetFont('Arial', '', 10);
// $pdf->SetXY(158, 213);
// $pdf->Cell(47, 8, $nombre_format_francais, 0, 0, 'C');
// // en bas à droite
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->SetXY(181, 233);
// $pdf->Cell(24, 6, number_format($tot_tva, 2, ',', ' '), 0, 0, 'R');



// **************************
// pied de page
// **************************
$pdf->SetLineWidth(0.1);
$pdf->Rect(5, 260, 200, 6, "D");
$pdf->SetXY(1, 260);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell($pdf->GetPageWidth(), 7, "Home-Services", 0, 0, 'C');

$y1 = 270;
//Positionnement en bas et tout centrer
$pdf->SetXY(1, $y1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($pdf->GetPageWidth(), 5, "REF BANCAIRE : FR76 xxx - BIC : xxxx", 0, 0, 'C');

//Generate PDF output
$fileName = "Facture-" . $billId . ".pdf";
$pdf->Output("I", $fileName);
