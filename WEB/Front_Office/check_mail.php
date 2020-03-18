<?php

// Connexion à la base de données
require_once('class/DBManager.php');

if (!isset($_POST['mail']) || empty($_POST['mail'])) {

    http_response_code(400);
    exit;
}

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
