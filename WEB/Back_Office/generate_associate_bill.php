<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: associates_bills.php');
    exit;
}

require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);

$associateBillId = $_GET['id'];

$associateBill = $hm_database->getAssociateBill($associateBillId);

if ($associateBill == NULL) {
    header('Location: associates_bills.php');
    exit;
}

$serviceProvided = $hm_database->getServiceProvided($associateBill->getServiceProvidedId());
$associate = $hm_database->getAssociate($associateBill->getAssociateId());
$totalAdditionalPrices = $hm_database->getAdditionalPrice($serviceProvided->getServiceProvidedId());
$service = $hm_database->getService($serviceProvided->getServiceId());

require_once('pdf/fpdf.php');
$lastname = utf8_decode($associate->getLastName());
$firstname = utf8_decode($associate->getFirstName());
$address = utf8_decode($associate->getAddress());
$town = utf8_decode($associate->getTown());
$email = $associate->getEmail();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Image('img/favicon.png', 10, 10, 30, 30);

$num_fact = utf8_decode("Facture Prestataire Numéro " . $associateBillId);
$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(192);
$pdf->Rect(110, 15, 85, 8, "DF");
$pdf->SetXY(110, 15);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(85, 8, $num_fact, 0, 0, 'C');

//Customer's Address
$pdf->SetFont('Arial', 'B', 11);
$x = 110;
$y = 50;
$pdf->SetXY($x, $y);

if ($lastname && $firstname) {
    $pdf->SetXY($x, $y);
    $pdf->Cell(100, 8, $lastname . " " . $firstname, 0, 0, '');
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
$pdf->Cell($pdf->GetStringWidth("Nom du prestataire"), 0, "Nom du prestataire", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(65, 78);
$pdf->MultiCell(190, 4, utf8_decode($associateBill->getAssociateLastName()) . " " . utf8_decode($associateBill->getAssociateFirstName()), 0, "L");

//Service provided address
$pdf->SetFont("Arial", "BU", 10);
$pdf->SetXY(5, 90);
$pdf->Cell($pdf->GetStringWidth("Adresse de la prestation"), 0, "Adresse de la prestation", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(5, 93);
$pdf->MultiCell(190, 4, utf8_decode($serviceProvided->getAddress()) . " " . utf8_decode($serviceProvided->getTown()), 0, "L");

$parts = explode(".", $serviceProvided->getBeginHour());

//Customer's service provided date
$pdf->SetFont("Arial", "BU", 10);
$pdf->SetXY(65, 90);
$pdf->Cell($pdf->GetStringWidth("Date de la prestation"), 0, "Date de la prestation", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(65, 93);
$pdf->MultiCell(190, 4, $serviceProvided->getDate() . utf8_decode(" à ") . $parts[0], 0, "L");

$data = 1;

// cadre avec 18 lignes max ! et 118 de hauteur --> 95 + 118 = 213 pour les traits verticaux
$pdf->SetLineWidth(0.1);
$pdf->Rect(5, 105, 200, 118, "D");
// cadre titre des colonnes
$pdf->Line(5, 105, 205, 105);

$pdf->Line(5, 112, 205, 112);

// les traits verticaux colonnes
$pdf->Line(90, 105, 90, 223);
$pdf->Line(120, 105, 120, 223);
$pdf->Line(152, 105, 152, 223);
$pdf->Line(166, 105, 166, 223);
$pdf->Line(187, 105, 187, 223);

// titre colonne
$pdf->SetXY(1, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(140, 8, "Service", 0, 0, 'C');
$pdf->SetXY(105, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1, 8, utf8_decode("Heures demandées"), 0, 0, 'C');
$pdf->SetXY(136, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1, 8, utf8_decode("Heures effectuées"), 0, 0, 'C');
$pdf->SetXY(155, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 8, "Prix/h", 0, 0, 'C');
$pdf->SetXY(165, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 8, "Commission", 0, 0, 'C');
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


$servicePrice = $associateBill->getTotalPrice() - $totalAddPrice;
$servicePricePerHour = $servicePrice / $serviceProvided->getHoursAssociate();
//Service
$pdf->SetXY(7, $y + 9);
$pdf->Cell(140, 5, $associateBill->getServiceTitle(), 0, 0, 'L');
//Heures demandees
$pdf->SetXY(105, $y + 9);
$pdf->Cell(13, 5, strrev(wordwrap(strrev($serviceProvided->getHours()), 3, ' ', true)), 0, 0, 'R');
//Heures effectuees
$pdf->SetXY(132, $y + 9);
$pdf->Cell(18, 5, $serviceProvided->getHoursAssociate(), 0, 0, 'R');
//Prix/h
$nombre_format_francais = number_format($servicePricePerHour, 2, ',', ' ');
$pdf->SetXY(155, $y + 9);
$pdf->Cell(10, 5, $nombre_format_francais, 0, 0, 'R');
//Commission
$nombre_format_francais = number_format($service->getCommission(), 2, ',', ' ');
$pdf->SetXY(175, $y + 9);
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

$tot_ttc = 12;
$tot_tva = 123;

//Total Price
$nombre_format_francais = utf8_decode("Net à payer TTC : ") . number_format($associateBill->getTotalPrice(), 2, ',', ' ') . iconv('UTF-8', 'windows-1252', " €");
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(192);
$pdf->Rect(5, 213, 85, 10, "DF");
$pdf->SetXY(5, 213);
$pdf->Cell(90, 8, $nombre_format_francais, 0, 0, 'C');

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
$pdf->Cell($pdf->GetPageWidth(), 5, "REF BANCAIRE : FR76 xxx - BIC : xxxx" . " FR76 xxx - BIC : xxxx", 0, 0, 'C');

//Generate PDF output
$fileName = "Facture-Presataire" . $associateBill->getAssociateBillId() . ".pdf";
$pdf->Output("I", $fileName);
