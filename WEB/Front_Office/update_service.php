<?php

if (!isset($_GET['sp']) || empty(trim($_GET['sp']))) {

    http_response_code(401);
    echo http_response_code();
    return;
}

if (!isset($_GET['cid']) || empty(trim($_GET['cid']))) {

    http_response_code(402);
    echo http_response_code();
    return;
}

// Connexion à la base de données
require_once('class/DBManager.php');
$hm_database = new DBManager($bdd);
$customer = $hm_database->getUserById($_GET['cid']);
if ($customer == NULL) {

    http_response_code(403);
    echo http_response_code();
    return;
}

$serviceProvided = $hm_database->getServiceProvided($_GET['sp']);
if ($serviceProvided == NULL) {

    http_response_code(404);
    echo http_response_code();
    return;
}

$q = "UPDATE Bill SET paidStatus=1 WHERE serviceProvidedId = ?";
$res = $hm_database->getDb()->prepare($q);
$res->execute([$serviceProvided->getServiceProvidedId()]);

system('python3 mail/mail.py ' . 7 . ' ' . $customer->getMail());
http_response_code(200);
echo http_response_code();
return;