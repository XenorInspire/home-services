<?php

if (!isset($_POST['mail']) || empty(trim($_POST['mail']))) {

    http_response_code(400);
    echo http_response_code();
    return;
}

if (!isset($_GET['st']) || empty(trim($_GET['st']))) {

    http_response_code(400);
    echo http_response_code();
    return;
}

// Connexion à la base de données
require_once('class/DBManager.php');

$hm_database = new DBManager($bdd);
$mail = htmlspecialchars($_POST['mail']);

if ($_GET['st'] == 'c') {

    $q = "SELECT customerId FROM Customer WHERE email = ?";
    $req = $hm_database->getDb()->prepare($q);
    $req->execute([$mail]);

    $results = [];
    while ($user = $req->fetch())
        $results[] = $user;

    if (count($results) != 0) {

        http_response_code(200);
        echo http_response_code();
        return;
    } else {

        http_response_code(401);
        echo http_response_code();
        return;
    }
} elseif ($_GET['st'] == 'a') {

    $q = "SELECT associateId FROM Associate WHERE email = ?";
    $req = $hm_database->getDb()->prepare($q);
    $req->execute([$mail]);

    $results = [];
    while ($user = $req->fetch())
        $results[] = $user;

    if (count($results) != 0) {

        http_response_code(200);
        echo http_response_code();
        return;
    } else {

        http_response_code(401);
        echo http_response_code();
        return;
    }
} else {

    http_response_code(400);
    echo http_response_code();
    return;
}
