<?php

if (!isset($_POST['mail']) || empty(trim($_POST['mail']))) {

    http_response_code(400);
    echo http_response_code();
    return;
}

// Connexion à la base de données
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
$mail = htmlspecialchars($_POST['mail']);

$q = "SELECT customerId FROM Customer WHERE email = ?";
$req = $hm_database->getDb()->prepare($q);
$req->execute([$mail]);

$results = [];
while ($user = $req->fetch())
    $results[] = $user;

if (count($results) != 0)
    echo "1";
else
    echo "0";
