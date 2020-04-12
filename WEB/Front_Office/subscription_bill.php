<?php
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
$result = $hm_database->getLastSubscriptionBill($id);

if ($result['billId'] != $_GET['id']) {

    header('Location: orders.php');
    exit;
}

require_once('pdf/fpdf.php');
$lastname = utf8_decode($user->getLastname());
$firstname = utf8_decode($user->getFirstname());
$address = utf8_decode($user->getAddress());
$town = utf8_decode($user->getCity());
$email = $user->getMail();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Image('img/favicon.png', 10, 10, 30, 30);

$num_fact = "Bill Number : "  . $_GET['id'];
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
$pdf->Cell($pdf->GetStringWidth("Nom du client"), 0, "Nom du client", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(65, 78);
$pdf->MultiCell(190, 4, utf8_decode($result['customerLastName']) . " " . utf8_decode($result['customerFirstName']), 0, "L");

//Customer's subscription address
$pdf->SetFont("Arial", "BU", 10);
$pdf->SetXY(5, 90);
$pdf->Cell($pdf->GetStringWidth("Adresse des prestations"), 0, "Adresse des prestations", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(5, 93);
$pdf->MultiCell(190, 4, utf8_decode($result['customerAddress']) . " " . utf8_decode($result['customerTown']), 0, "L");

//Customer's subscription date
$pdf->SetFont("Arial", "BU", 10);
$pdf->SetXY(65, 90);
$pdf->Cell($pdf->GetStringWidth("Date de souscription"), 0, "Date de souscription", 0, "L");
$pdf->SetFont("Arial", "", 10);
$pdf->SetXY(65, 93);
$pdf->MultiCell(190, 4, $result['billDate'], 0, "L");

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
$pdf->Cell(140, 8, "Abonnement", 0, 0, 'C');

$pdf->SetXY(177, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 8, "Prix", 0, 0, 'C');

$pdf->SetXY(185, 105);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 8, "TOTAL", 0, 0, 'C');

// les articles
$pdf->SetFont('Arial', '', 8);
$y = 105;

// Abonnement
$pdf->SetXY(7, $y + 9);
$pdf->Cell(140, 5, $result['typeName'], 0, 0, 'L');

// Prix
$pdf->SetXY(177, $y + 9);
$pdf->Cell(10, 5, $result['price'], 0, 0, 'R');

// Total
$pdf->SetXY(187, $y + 9);
$pdf->Cell(18, 5, $result['price'], 0, 0, 'R');

$pdf->Line(5, $y + 14, 205, $y + 14);

$tot_ttc = 12;
$tot_tva = 123;
//Total Price
$nombre_format_francais = utf8_decode("Net à payer TTC : ") . $result['price'] . iconv('UTF-8', 'windows-1252', " €");
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(192);
$pdf->Rect(5, 213, 105, 10, "DF");
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
$pdf->Cell($pdf->GetPageWidth(), 5, "REF BANCAIRE : FR76 xxx - BIC : xxxx", 0, 0, 'C');

//Generate PDF output
$fileName = "Facture-" . $result['billId'] . ".pdf";
$pdf->Output("I", $fileName);
