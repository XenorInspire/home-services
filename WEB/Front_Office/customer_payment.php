<?php

if (!isset($_GET['sid']) || empty(trim($_GET['sid']))) {

    http_response_code(400);
    echo http_response_code();
    return;
}

if (!isset($_GET['cid']) || empty(trim($_GET['cid']))) {

    http_response_code(400);
    echo http_response_code();
    return;
}

// Connexion à la base de données
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
$customer = $hm_database->getUserById($_GET['cid']);
if ($customer == NULL) {

    http_response_code(400);
    echo http_response_code();
    return;
}

$subscriptionType = $hm_database->getSubscriptionTypeById($_GET['sid']);
if ($subscriptionType == NULL) {

    http_response_code(400);
    echo http_response_code();
    return;
}

$date = date('Y-m-d');

$q = "INSERT INTO Subscription (beginDate,customerId,typeId,remainingHours) VALUES (:beginDate, :customerId, :typeId, :remainingHours)";
$res = $hm_database->getDb()->prepare($q);
$res->execute(array(
    'beginDate' => $date,
    'customerId' => $_GET['cid'],
    'typeId' => $_GET['sid'],
    'remainingHours' => $subscriptionType->getServiceTime()
));

$hm_database->addSubscriptionBill($customer, $subscriptionType, $date);

system('python3 mail/mail.py ' . 2 . ' ' . $customer->getMail());
http_response_code(200);
echo http_response_code();
return;
