<?php

// Connexion à la base de données
require_once('class/DBManager.php');

if (!isset($_GET['sid']) || empty(trim($_GET['sid']))) {

    http_response_code(400);
    exit;
}

if (!isset($_GET['cid']) || empty(trim($_GET['cid']))) {

    http_response_code(400);
    exit;
}

$hm_database = new DBManager($bdd);
$q = "INSERT INTO Subscription (beginDate,customerId,typeId) VALUES (:beginDate, :customerId, :typeId)";
$res = $hm_database->getDb()->prepare($q);
$res->execute(array(
    'beginDate' => date('Y-m-d'),
    'customerId' => $_GET['cid'],
    'typeId' => $_GET['sid']
));

$customer = $hm_database->getUserById($_GET['cid']);
if($customer == NULL){

    http_response_code(400);
    exit;

}

system('python3 mail/mail.py ' . 2 . ' ' . $customer->getMail());
http_response_code(200);